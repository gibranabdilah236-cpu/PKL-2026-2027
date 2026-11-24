function aktifkanTTD(id) {
    var canvas = document.getElementById(id);
    var ctx = canvas.getContext('2d');
    var gambar = false;

    canvas.addEventListener('mousedown', function (e) {
        gambar = true;
        ctx.beginPath();
        ctx.moveTo(e.offsetX, e.offsetY);
    });

    canvas.addEventListener('mousemove', function (e) {
        if (gambar) {
            ctx.lineTo(e.offsetX, e.offsetY);
            ctx.stroke();
        }
    });

    canvas.addEventListener('mouseup', function () {
        gambar = false;
    });

    canvas.addEventListener('mouseleave', function () {
        gambar = false;
    });
}

function hapusTTD(id) {
    var canvas = document.getElementById(id);
    canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height);
}

function unduhPDF() {
    var jsPDF = window.jspdf.jsPDF;
    var pdf = new jsPDF();

    var tanggal = document.getElementById('tanggal1').value;
    var jam = document.getElementById('jam2').value;

    if (tanggal) {
        tanggal = tanggal.split('-').reverse().join('-');
    } else {
        tanggal = '-';
    }

    if (!jam) {
        jam = '-';
    }

    var gambar1 = document.getElementById('ttd1').toDataURL('image/png');
    var gambar2 = document.getElementById('ttd2').toDataURL('image/png');

    pdf.setFontSize(16);
    pdf.text('Verifikasi & Serah Terima', 105, 20, { align: 'center' });

    pdf.setFontSize(12);
    pdf.text('Orang Pertama', 20, 40);
    pdf.text('Tanggal : ' + tanggal, 20, 48);
    pdf.text('Paraf :', 20, 56);
    pdf.rect(20, 60, 105, 45);
    pdf.addImage(gambar1, 'PNG', 20, 60, 105, 45);

    pdf.text('Orang Kedua', 20, 125);
    pdf.text('Jam : ' + jam, 20, 133);
    pdf.text('Paraf :', 20, 141);
    pdf.rect(20, 145, 105, 45);
    pdf.addImage(gambar2, 'PNG', 20, 145, 105, 45);

    pdf.save('tanda-tangan-gibran.pdf');
}

aktifkanTTD('ttd1');
aktifkanTTD('ttd2');