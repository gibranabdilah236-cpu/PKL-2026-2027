function aktifkanTTD(id) {
    var canvas = document.getElementById(id);
    if (!canvas) return;

    var ctx = canvas.getContext('2d');
    var gambar = false;

    function getKoordinat(e) {
        var rect = canvas.getBoundingClientRect();
        var scaleX = canvas.width / rect.width;
        var scaleY = canvas.height / rect.height;

        if (e.touches && e.touches.length > 0) {
            return {
                x: (e.touches[0].clientX - rect.left) * scaleX,
                y: (e.touches[0].clientY - rect.top) * scaleY
            };
        }

        return {
            x: (e.clientX - rect.left) * scaleX,
            y: (e.clientY - rect.top) * scaleY
        };
    }

    canvas.addEventListener('mousedown', function (e) {
        gambar = true;
        var pos = getKoordinat(e);
        ctx.beginPath();
        ctx.moveTo(pos.x, pos.y);
    });

    canvas.addEventListener('mousemove', function (e) {
        if (!gambar) return;
        var pos = getKoordinat(e);
        ctx.lineTo(pos.x, pos.y);
        ctx.stroke();
    });

    window.addEventListener('mouseup', function () {
        gambar = false;
    });

    canvas.addEventListener('touchstart', function (e) {
        e.preventDefault();
        gambar = true;
        var pos = getKoordinat(e);
        ctx.beginPath();
        ctx.moveTo(pos.x, pos.y);
    }, { passive: false });

    canvas.addEventListener('touchmove', function (e) {
        e.preventDefault();
        if (!gambar) return;
        var pos = getKoordinat(e);
        ctx.lineTo(pos.x, pos.y);
        ctx.stroke();
    }, { passive: false });

    canvas.addEventListener('touchend', function () {
        gambar = false;
    });
}

function hapusTTD(id) {
    var canvas = document.getElementById(id);
    if (!canvas) return;
    canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height);
}

function isiTanggalJam() {
    var sekarang = new Date();
    var tahun = sekarang.getFullYear();
    var bulan = String(sekarang.getMonth() + 1).padStart(2, '0');
    var hari = String(sekarang.getDate()).padStart(2, '0');
    var jam = String(sekarang.getHours()).padStart(2, '0');
    var menit = String(sekarang.getMinutes()).padStart(2, '0');

    var elTanggal = document.getElementById('tanggal1');
    var elJam = document.getElementById('jam2');

    if (elTanggal) elTanggal.value = tahun + '-' + bulan + '-' + hari;
    if (elJam) elJam.value = jam + ':' + menit;
}

function unduhPDF() {
    try {
        if (typeof window.jspdf === 'undefined') {
            alert('Library jsPDF belum dimuat!');
            return;
        }

        if (typeof semuaDataPenyakit === 'undefined') {
            alert('Variabel semuaDataPenyakit tidak ditemukan!');
            return;
        }

        var jsPDF = window.jspdf.jsPDF;
        var pdf = new jsPDF();

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
            : (semuaDataPenyakit && semuaDataPenyakit.data ? semuaDataPenyakit.data : Object.values(semuaDataPenyakit || {}));

        var bodyData = dataArray.map(function (row, index) {
            return [
                index + 1,
                row.kode_icd ?? '',
                row.diagnosis_penyakit ?? '',
                row.jumlah_kasus ?? ''
            ];
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
        var gambar1 = canvas1 ? canvas1.toDataURL('image/png') : null;
        var gambar2 = canvas2 ? canvas2.toDataURL('image/png') : null;

        var y = (pdf.lastAutoTable ? pdf.lastAutoTable.finalY : 60) + 15;
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
        if (gambar1) {
            pdf.addImage(gambar1, 'PNG', 20, y + 27, 80, 34);
        }

        pdf.text('Orang Kedua', 110, y + 10);
        pdf.text('Jam : ' + jam, 110, y + 17);
        pdf.text('Paraf :', 110, y + 24);
        pdf.rect(110, y + 27, 80, 34);
        if (gambar2) {
            pdf.addImage(gambar2, 'PNG', 110, y + 27, 80, 34);
        }

        pdf.save('menu-gibran.pdf');
    } catch (error) {
        alert('Terjadi kesalahan: ' + error.message);
    }
}

document.addEventListener('DOMContentLoaded', function () {
    isiTanggalJam();
    aktifkanTTD('ttd1');
    aktifkanTTD('ttd2');
});