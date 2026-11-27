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

    fetch(URL_TTD.hapus + '/' + id, {
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

    return fetch(URL_TTD.simpan, {
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

function siapkanPDF(lanjut) {
    var daftar = ['ttd1', 'ttd2'].filter(function (id) {
        return !canvasKosong(document.getElementById(id));
    });

    if (!daftar.length) {
        lanjut();
        return;
    }

    Promise.all(daftar.map(simpanKeDatabase)).then(function (hasil) {
        if (hasil.every(function (ok) { return ok; })) lanjut();
    });
}

function unduhPDF() {
    siapkanPDF(function () {
        window.location.href = URL_TTD.pdf + '?unduh=1';
    });
}

document.addEventListener('DOMContentLoaded', function () {
    aktifkanTTD('ttd1');
    aktifkanTTD('ttd2');
    muatTTDTersimpan();
});