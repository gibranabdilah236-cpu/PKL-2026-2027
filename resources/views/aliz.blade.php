
@extends('layouts.dashboard.master')

@section('title', 'Menu Aliz')

@section('breadcrumb-title')
<h3>Aliz</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item active">Aliz</li>
@endsection

@section('content')

<style>
    .aliz-card {
        background: #fff;
        border-radius: 15px;
        padding: 25px;
        margin-bottom: 25px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.04);
    }

    .aliz-profile img {
        width: 187px;
        height: 105px;
        object-fit: cover;
        border-radius: 8px;
        margin-bottom: 15px;
    }

    .aliz-profile h3 {
        font-weight: 700;
    }

    .aliz-card h4 {
        font-weight: 700;
        margin-bottom: 20px;
    }

    .aliz-table {
        width: 100%;
        border-collapse: collapse;
    }

    .aliz-table th,
    .aliz-table td {
        padding: 12px;
        border: 1px solid #ddd;
    }

    .aliz-table th {
        background: #f5f5f5;
    }

    .ttd-card {
        border: 1px solid #ccc;
        border-radius: 12px;
        padding: 20px;
        height: 100%;
    }

    .ttd-card h5 {
        font-weight: 700;
        margin-bottom: 15px;
    }

    .ttd-canvas {
        width: 100%;
        height: 190px;
        border: 1px dashed #999;
        border-radius: 8px;
        display: block;
        background: white;
        touch-action: none;
        cursor: crosshair;
    }

    .btn-hapus {
        background: #f52f63;
        color: white;
        border: none;
        padding: 9px 25px;
        border-radius: 5px;
        margin-top: 10px;
    }

    .btn-simpan {
        background: #4dbb20;
        color: white;
        border: none;
        padding: 11px 35px;
        border-radius: 6px;
    }

    .btn-aliz {
        background: #7161ff;
        color: white;
        border-radius: 7px;
        padding: 10px 25px;
    }
</style>

<div class="container-fluid">

    {{-- PROFIL ALIZ --}}
    <div class="aliz-card aliz-profile">
        <img src="{{ asset('assets/image/aliz.jpg') }}" alt="Foto Aliz">

        <h3>Aliziyya Kautsara</h3>
        <p>NIS: 242510287</p>
    </div>

    {{-- DATA PENYAKIT --}}
    <div class="aliz-card">
        <h4>Data Penyakit Rumah Sakit Umum Daerah Kota Bogor</h4>

        <form action="{{ route('aliz') }}" method="GET"
              class="d-flex flex-wrap mb-3" style="gap: 10px;">

            <input type="text"
                   name="search"
                   class="form-control"
                   style="max-width: 350px;"
                   placeholder="Cari penyakit..."
                   value="{{ $search }}">

            <button type="submit" class="btn btn-aliz">Cari</button>

            <a href="{{ route('aliz') }}" class="btn btn-secondary">
                Reset
            </a>
        </form>

        <div class="table-responsive">
            <table class="aliz-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode ICD</th>
                        <th>Diagnosis Penyakit</th>
                        <th>Jumlah Kunjungan</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($penyakit as $item)
                    <tr>
                        <td>{{ $loop->iteration + ($penyakit->currentPage() - 1) * $penyakit->perPage() }}</td>
                        <td>{{ $item->kode_icd }}</td>
                        <td>{{ $item->diagnosis_penyakit }}</td>
                        <td>{{ $item->jumlah_kunjungan }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center">
                            Data tidak ditemukan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $penyakit->links() }}
        </div>
    </div>

    {{-- VERIFIKASI DAN SERAH TERIMA --}}
    <div class="aliz-card">
        <h4>Verifikasi & Serah Terima</h4>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="{{ route('tertanda.store') }}"
              method="POST"
              id="formTertanda">
            @csrf

            <input type="hidden" name="nama_pertama" value="Orang Pertama">
            <input type="hidden" name="nama_kedua" value="Orang Kedua">

            <div class="row">

                {{-- ORANG PERTAMA --}}
                <div class="col-md-6 mb-4">
                    <div class="ttd-card">
                        <h5>Orang Pertama</h5>

                        <label>Tanggal</label>
                        <input type="date"
                               name="tanggal"
                               class="form-control mb-3"
                               value="{{ old('tanggal') }}"
                               required>

                        <label>Paraf</label>
                        <canvas id="canvasPertama" class="ttd-canvas"></canvas>

                        <input type="hidden"
                               name="ttd_pertama"
                               id="ttdPertama">

                        <button type="button"
                                class="btn-hapus"
                                onclick="hapusParaf('pertama')">
                            Hapus
                        </button>
                    </div>
                </div>

                {{-- ORANG KEDUA --}}
                <div class="col-md-6 mb-4">
                    <div class="ttd-card">
                        <h5>Orang Kedua</h5>

                        <label>Jam</label>
                        <input type="time"
                               name="jam"
                               class="form-control mb-3"
                               value="{{ old('jam') }}"
                               required>

                        <label>Paraf</label>
                        <canvas id="canvasKedua" class="ttd-canvas"></canvas>

                        <input type="hidden"
                               name="ttd_kedua"
                               id="ttdKedua">

                        <button type="button"
                                class="btn-hapus"
                                onclick="hapusParaf('kedua')">
                            Hapus
                        </button>
                    </div>
                </div>

            </div>

            <div class="d-flex flex-wrap" style="gap: 10px;">
                <button type="submit" class="btn-simpan">
                    Simpan
                </button>

                <button type="button" class="btn btn-primary">
                    PDF
                </button>
            </div>

        </form>
    </div>

</div>

<script>
    function buatCanvas(id) {
        const canvas = document.getElementById(id);
        const ctx = canvas.getContext('2d');

        let menggambar = false;
        let sudahMenggambar = false;

        canvas.width = 500;
        canvas.height = 190;

        ctx.lineWidth = 2;
        ctx.lineCap = 'round';
        ctx.lineJoin = 'round';
        ctx.strokeStyle = '#000';

        function posisi(e) {
            const rect = canvas.getBoundingClientRect();

            return {
                x: (e.clientX - rect.left) * canvas.width / rect.width,
                y: (e.clientY - rect.top) * canvas.height / rect.height
            };
        }

        canvas.addEventListener('pointerdown', function(e) {
            menggambar = true;
            sudahMenggambar = true;

            canvas.setPointerCapture(e.pointerId);

            const p = posisi(e);

            ctx.beginPath();
            ctx.moveTo(p.x, p.y);
        });

        canvas.addEventListener('pointermove', function(e) {
            if (!menggambar) return;

            const p = posisi(e);

            ctx.lineTo(p.x, p.y);
            ctx.stroke();
        });

        canvas.addEventListener('pointerup', function() {
            menggambar = false;
        });

        canvas.addEventListener('pointercancel', function() {
            menggambar = false;
        });

        return {
            hapus: function() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                sudahMenggambar = false;
            },

            data: function() {
                return sudahMenggambar
                    ? canvas.toDataURL('image/png')
                    : '';
            }
        };
    }

    const pertama = buatCanvas('canvasPertama');
    const kedua = buatCanvas('canvasKedua');

    function hapusParaf(pihak) {
        if (pihak === 'pertama') {
            pertama.hapus();
            document.getElementById('ttdPertama').value = '';
        } else {
            kedua.hapus();
            document.getElementById('ttdKedua').value = '';
        }
    }

    document.getElementById('formTertanda').addEventListener('submit', function(e) {
        const ttdPertama = pertama.data();
        const ttdKedua = kedua.data();

        if (!ttdPertama || !ttdKedua) {
            e.preventDefault();
            alert('Kedua orang harus mengisi paraf terlebih dahulu.');
            return;
        }

        document.getElementById('ttdPertama').value = ttdPertama;
        document.getElementById('ttdKedua').value = ttdKedua;
    });
</script>

@endsection
