var NAMA_TTD = {
    ttd1: 'Gibran D. Abdilah (Orang Pertama)',
    ttd2: 'Gibran D. Abdilah (Orang Kedua)'
};

var ID_WAKTU = {
    ttd1: 'tanggal1',
    ttd2: 'jam2'
};

function csrfToken() {
    var token = document.querySelector('meta[name="csrf-token"]');
    return token ? token.getAttribute('content') : '';
}

function aktifkanTTD(id) {
    var canvas = document.getElementById(id);
    if (!canvas) return;

    var ctx = canvas.getContext('2d');
    ctx.lineWidth = 2;
    ctx.lineCap = 'round';
    ctx.lineJoin = 'round';
    var gambar = false;

    function getKoordinat(e) {
        var rect = canvas.getBoundingClientRect();
        var scaleX = canvas.width / rect.width;
        var scaleY = canvas.height / rect.height;
        var titik = (e.touches && e.touches.length > 0) ? e.touches[0] : e;

        return {
            x: (titik.clientX - rect.left) * scaleX,
            y: (titik.clientY - rect.top) * scaleY
        };
    }

    function mulai(e) {
        gambar = true;
        var pos = getKoordinat(e);
        ctx.beginPath();
        ctx.moveTo(pos.x, pos.y);
    }

    function gerak(e) {
        if (!gambar) return;
        var pos = getKoordinat(e);
        ctx.lineTo(pos.x, pos.y);
        ctx.stroke();
    }

    canvas.addEventListener('mousedown', mulai);
    canvas.addEventListener('mousemove', gerak);
    window.addEventListener('mouseup', function () { gambar = false; });

    canvas.addEventListener('touchstart', function (e) { e.preventDefault(); mulai(e); }, { passive: false });
    canvas.addEventListener('touchmove', function (e) { e.preventDefault(); gerak(e); }, { passive: false });
    canvas.addEventListener('touchend', function () { gambar = false; });
}

function bersihkanTTD(id) {
    var canvas = document.getElementById(id);
    if (canvas) canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height);
}

function canvasKosong(canvas) {
    var kosong = document.createElement('canvas');
    kosong.width = canvas.width;
    kosong.height = canvas.height;
    return canvas.toDataURL() === kosong.toDataURL();
}

function isiWaktuSekarang(id) {
    var el = document.getElementById(ID_WAKTU[id]);
    if (!el) return;

    var sekarang = new Date();
    var bulan = String(sekarang.getMonth() + 1).padStart(2, '0');
    var hari = String(sekarang.getDate()).padStart(2, '0');
    var jam = String(sekarang.getHours()).padStart(2, '0');
    var menit = String(sekarang.getMinutes()).padStart(2, '0');

    el.value = id === 'ttd1'
        ? sekarang.getFullYear() + '-' + bulan + '-' + hari
        : jam + ':' + menit;
}

function hapusTTD(id) {
    if (!ttdTersimpan || !ttdTersimpan[id]) {
        bersihkanTTD(id);
        return;
    }

    if (!confirm('Paraf ini sudah tersimpan di database. Hapus juga dari database?')) return;

    fetch('/tanda-tangan-gibran/' + id, {
        method: 'DELETE',
        credentials: 'same-origin',
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken()
        }
    })
    .then(function (response) {
        if (!response.ok) throw new Error('HTTP ' + response.status);
        ttdTersimpan[id] = null;
        bersihkanTTD(id);
        isiWaktuSekarang(id);
    })
    .catch(function (error) {
        alert('Paraf gagal dihapus dari database: ' + error.message);
    });
}

function muatTTDTersimpan() {
    ['ttd1', 'ttd2'].forEach(function (id) {
        var data = ttdTersimpan ? ttdTersimpan[id] : null;
        var el = document.getElementById(ID_WAKTU[id]);

        if (data && data.waktu) {
            el.value = data.waktu;
        } else {
            isiWaktuSekarang(id);
        }

        if (!data || !data.gambar) return;

        var canvas = document.getElementById(id);
        var img = new Image();
        img.onload = function () {
            canvas.getContext('2d').drawImage(img, 0, 0, canvas.width, canvas.height);
        };
        img.src = data.gambar;
    });
}

function simpanKeDatabase(id) {
    var gambar = document.getElementById(id).toDataURL('image/png');
    var waktu = document.getElementById(ID_WAKTU[id]).value || null;

    return fetch('/tanda-tangan/simpan', {
        method: 'POST',
        credentials: 'same-origin',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken()
        },
        body: JSON.stringify({
            nama_pengguna: NAMA_TTD[id],
            ttd: gambar,
            waktu: waktu
        })
    })
    .then(function (response) {
        return response.json().then(function (data) {
            if (!response.ok) {
                throw new Error('HTTP ' + response.status + ' - ' + (data.message || JSON.stringify(data.errors || data)));
            }
            if (!ttdTersimpan || Array.isArray(ttdTersimpan)) ttdTersimpan = {};
            ttdTersimpan[id] = { gambar: gambar, waktu: waktu };
            return true;
        });
    })
    .catch(function (error) {
        alert('Tanda tangan gagal disimpan ke database: ' + error.message);
        return false;
    });
}

function simpanTTD() {
    var tombol = document.getElementById('btnSimpan');
    var daftar = ['ttd1', 'ttd2'].filter(function (id) {
        return !canvasKosong(document.getElementById(id));
    });

    if (!daftar.length) {
        alert('Paraf masih kosong');
        return;
    }

    tombol.disabled = true;

    Promise.all(daftar.map(simpanKeDatabase)).then(function (hasil) {
        tombol.disabled = false;
        if (hasil.every(function (ok) { return ok; })) {
            alert('Berhasil disimpan!');
        }
    });
}

function buatPDF() {
    try {
        if (typeof window.jspdf === 'undefined') {
            alert('Library jsPDF belum dimuat!');
            return null;
        }

        var pdf = new window.jspdf.jsPDF();

        var foto = document.querySelector('img[alt="Foto Gibran"]');
        if (foto && foto.complete && foto.naturalWidth > 0) {
            pdf.addImage(foto, 'JPEG', 20, 15, 30, 37);
        }

        pdf.setFont('helvetica', 'bold');
        pdf.setFontSize(14);
        pdf.text('Gibran D. Abdilah', 58, 25);
        pdf.setFont('helvetica', 'normal');
        pdf.setFontSize(11);
        pdf.text('NIS: 3271300097', 58, 32);
        pdf.text('Praktik Kerja Lapangan (PKL)', 58, 39);
        pdf.text('RSUD Kota Bogor', 58, 46);

        var dataArray = Array.isArray(semuaDataPenyakit)
            ? semuaDataPenyakit
            : Object.values(semuaDataPenyakit || {});

        var bodyData = dataArray.map(function (row, index) {
            return [index + 1, row.kode_icd ?? '', row.diagnosis ?? '', row.jumlah_kunjungan ?? ''];
        });

        pdf.autoTable({
            head: [['No', 'Kode ICD', 'Diagnosis Penyakit', 'Jumlah Kunjungan']],
            body: bodyData,
            startY: 60,
            theme: 'grid',
            styles: { fontSize: 9, lineColor: [0, 0, 0], lineWidth: 0.2, textColor: [0, 0, 0] },
            headStyles: { fillColor: [52, 73, 94], textColor: [255, 255, 255] }
        });

        var tanggal = document.getElementById('tanggal1').value;
        var jam = document.getElementById('jam2').value;

        tanggal = tanggal ? tanggal.split('-').reverse().join('-') : '-';
        jam = jam || '-';

        var canvas1 = document.getElementById('ttd1');
        var canvas2 = document.getElementById('ttd2');
        var gambar1 = canvasKosong(canvas1) ? null : canvas1.toDataURL('image/png');
        var gambar2 = canvasKosong(canvas2) ? null : canvas2.toDataURL('image/png');

        var y = pdf.lastAutoTable.finalY + 15;
        if (y + 75 > 280) {
            pdf.addPage();
            y = 20;
        }

        pdf.setFont('helvetica', 'bold');
        pdf.setFontSize(13);
        pdf.text('Verifikasi & Serah Terima', 20, y);
        pdf.setFont('helvetica', 'normal');
        pdf.setFontSize(11);

        pdf.text('Orang Pertama', 20, y + 10);
        pdf.text('Tanggal : ' + tanggal, 20, y + 17);
        pdf.text('Paraf :', 20, y + 24);
        pdf.rect(20, y + 27, 80, 34);
        if (gambar1) pdf.addImage(gambar1, 'PNG', 20, y + 27, 80, 34);

        pdf.text('Orang Kedua', 110, y + 10);
        pdf.text('Jam : ' + jam, 110, y + 17);
        pdf.text('Paraf :', 110, y + 24);
        pdf.rect(110, y + 27, 80, 34);
        if (gambar2) pdf.addImage(gambar2, 'PNG', 110, y + 27, 80, 34);

        return pdf;
    } catch (error) {
        alert('Terjadi kesalahan: ' + error.message);
        return null;
    }
}

function unduhPDF() {
    var pdf = buatPDF();
    if (pdf) pdf.save('menu-gibran.pdf');
}

function cetakPDF() {
    var pdf = buatPDF();
    if (!pdf) return;

    var url = URL.createObjectURL(pdf.output('blob'));
    var iframe = document.createElement('iframe');
    iframe.style.cssText = 'position:fixed;right:0;bottom:0;width:0;height:0;border:0';
    iframe.src = url;

    iframe.onload = function () {
        try {
            iframe.contentWindow.focus();
            iframe.contentWindow.print();
        } catch (e) {
            window.open(url, '_blank');
        }

        setTimeout(function () {
            URL.revokeObjectURL(url);
            iframe.remove();
        }, 60000);
    };

    document.body.appendChild(iframe);
}

document.addEventListener('DOMContentLoaded', function () {
    aktifkanTTD('ttd1');
    aktifkanTTD('ttd2');
    muatTTDTersimpan();
});