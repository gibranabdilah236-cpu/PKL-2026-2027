<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Verifikasi &amp; Serah Terima</title>
    <style>
        @page { margin: 28px 32px; }
        body   { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #000; }
        h2     { text-align: center; margin: 0 0 4px; font-size: 16px; }
        .sub   { text-align: center; color: #444; margin-bottom: 16px; }
        table  { width: 100%; border-collapse: collapse; }

        .info td { padding: 2px 4px; border: none; }
        .info td.label { width: 60px; font-weight: bold; }

        .data { margin-top: 12px; }
        .data th, .data td { border: 1px solid #000; padding: 5px 6px; }
        .data th { background: #00bfe0; color: #fff; text-align: left; }

        h3 { font-size: 13px; margin: 22px 0 8px; }
        .ttd { page-break-inside: avoid; }
        .ttd td.kolom { width: 50%; vertical-align: top; padding: 0 6px; }
        .box { border: 1px solid #000; border-radius: 6px; padding: 8px 10px; }
        .box .judul { font-weight: bold; font-size: 12px; margin-bottom: 8px; }
        .box .isian { margin-bottom: 8px; }
        .paraf { border: 1px dashed #777; height: 100px; text-align: center; }
        .paraf img { max-width: 95%; max-height: 92px; margin-top: 4px; }

        .footer { margin-top: 18px; font-size: 9px; color: #555; text-align: right; }
    </style>
</head>
<body>
    <h2>Verifikasi &amp; Serah Terima</h2>
    <div class="sub">RSUD Kota Bogor</div>

    <table class="info">
        <tr><td class="label">Nama</td><td>: {{ $nama }}</td></tr>
        <tr><td class="label">NIS</td><td>: {{ $nis }}</td></tr>
    </table>

    <table class="data">
        <thead>
            <tr>
                <th style="width: 30px;">No</th>
                <th style="width: 70px;">Kode ICD</th>
                <th>Diagnosis Penyakit</th>
                <th style="width: 90px;">Jumlah Kunjungan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($diagnosa as $i => $row)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $row->kode_icd }}</td>
                    <td>{{ $row->diagnosis }}</td>
                    <td>{{ $row->jumlah_kunjungan }}</td>
                </tr>
            @empty
                <tr><td colspan="4" style="text-align:center;">Belum ada data</td></tr>
            @endforelse
        </tbody>
    </table>

    <h3>Verifikasi &amp; Serah Terima</h3>
    <table class="ttd">
        <tr>
            @foreach($kolom as $k)
                <td class="kolom">
                    <div class="box">
                        <div class="judul">{{ $k['judul'] }}</div>
                        <div class="isian">{{ $k['isian'] }}: {{ $k['nilai'] !== '' ? $k['nilai'] : '-' }}</div>
                        <div>Paraf:</div>
                        <div class="paraf">
                            @if($k['gambar'])
                                <img src="{{ $k['gambar'] }}" alt="Paraf">
                            @endif
                        </div>
                    </div>
                </td>
            @endforeach
        </tr>
    </table>

    <div class="footer">Dicetak: {{ $dicetak }}</div>
</body>
</html>
