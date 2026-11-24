<!-- <!DOCTYPE html>
<html>
<head>
    <title>Data Penyakit</title>
</head>
<body>

    <h2>Data Penyakit Rumah Sakit Umum Daerah Kota Bogor</h2>

    <form action="{{ route('penyakit.index') }}" method="GET">
        <input type="text" name="search" placeholder="Cari penyakit..." value="{{ $search }}">
        <button type="submit">Cari</button>
        <a href="{{ route('penyakit.index') }}">Reset</a>
    </form>

    <br>

    <table border="1" cellpadding="8" cellspacing="0" width="100%">
        <tr>
            <th>No</th>
            <th>Kode ICD</th>
            <th>Diagnosis Penyakit</th>
            <th>Jumlah Kunjungan</th>
        </tr>

        @forelse ($penyakit as $item)
        <tr>
            <td>{{ $loop->iteration + ($penyakit->currentPage() - 1) * $penyakit->perPage() }}</td>
            <td>{{ $item->kode_icd }}</td>
            <td>{{ $item->diagnosis_penyakit }}</td>
            <td>{{ $item->jumlah_kunjungan }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="4">Data tidak ditemukan.</td>
        </tr>
        @endforelse
    </table>

    <br>

    @if ($penyakit->previousPageUrl())
        <a href="{{ $penyakit->previousPageUrl() }}">Sebelumnya</a>
    @endif

    Halaman {{ $penyakit->currentPage() }} dari {{ $penyakit->lastPage() }}

    @if ($penyakit->nextPageUrl())
        <a href="{{ $penyakit->nextPageUrl() }}">Selanjutnya</a>
    @endif

</body>
</html> -->
