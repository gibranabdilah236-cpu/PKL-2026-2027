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

function isiTanggalJam() {
    var sekarang = new Date();
    var tahun = sekarang.getFullYear();
    var bulan = String(sekarang.getMonth() + 1).padStart(2, '0');
    var hari = String(sekarang.getDate()).padStart(2, '0');
    var jam = String(sekarang.getHours()).padStart(2, '0');
    var menit = String(sekarang.getMinutes()).padStart(2, '0');

    document.getElementById('tanggal1').value = tahun + '-' + bulan + '-' + hari;
    document.getElementById('jam2').value = jam + ':' + menit;
}

function unduhPDF() {
    var jsPDF = window.jspdf.jsPDF;
    var pdf = new jsPDF();

    var foto = document.querySelector('img[alt="Foto Gibran"]');
    pdf.addImage(foto, 'JPEG', 20, 15, 30, 37);

    pdf.setFont('helvetica', 'bold');
    pdf.setFontSize(14);
    pdf.text('Gibran D. Abdilah', 58, 25);
    pdf.setFont('helvetica', 'normal');
    pdf.setFontSize(11);
    pdf.text('NIS: 3271300097', 58, 32);
    pdf.text('Praktik Kerja Lapangan (PKL)', 58, 39);
    pdf.text('RSUD Kota Bogor', 58, 46);

    var dataTabel = $('#tabelPenyakit').DataTable().rows().data().toArray();

    pdf.autoTable({
    head: [['No', 'Kode ICD', 'Diagnosis Penyakit', 'Jumlah Kunjungan']],
    body: dataTabel,
    startY: 60,
    theme: 'grid',
    styles: { fontSize: 9, lineColor: [0, 0, 0], lineWidth: 0.2, textColor: [0, 0, 0] },
        headStyles: { fillColor: [52, 73, 94], textColor: [255, 255, 255] }
    });

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
    pdf.addImage(gambar1, 'PNG', 20, y + 27, 80, 34);

    pdf.text('Orang Kedua', 110, y + 10);
    pdf.text('Jam : ' + jam, 110, y + 17);
    pdf.text('Paraf :', 110, y + 24);
    pdf.rect(110, y + 27, 80, 34);
    pdf.addImage(gambar2, 'PNG', 110, y + 27, 80, 34);

    pdf.save('menu-gibran.pdf');
}

isiTanggalJam();
aktifkanTTD('ttd1');
aktifkanTTD('ttd2');