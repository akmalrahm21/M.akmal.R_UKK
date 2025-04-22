@extends('layouts.app')

@section('title', 'Tambah Kamar')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Tambah Kamar</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('kamar.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="foto" class="form-label">Foto Kamar</label>
                <input type="file" name="foto" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="tipe_kamar" class="form-label">Tipe Kamar</label>
                <input type="text" name="tipe_kamar" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="jumlah_kamar" class="form-label">Jumlah Kamar</label>
                <input type="number" name="jumlah_kamar" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="fasilitas" class="form-label">Fasilitas Kamar</label>
                <textarea name="fasilitas" class="form-control" rows="3" required placeholder="Pisahkan dengan koma, contoh: AC, TV, WiFi"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('kamar.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
@endsection
