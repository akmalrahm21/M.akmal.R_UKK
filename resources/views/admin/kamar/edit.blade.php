@extends('layouts.app')

@section('title', 'Edit Kamar')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Edit Kamar</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('kamar.update', $kamar->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="foto" class="form-label">Foto Kamar</label><br>
                <img src="{{ asset('storage/' . $kamar->foto) }}" width="120" class="mb-2" alt="foto kamar">
                <input type="file" name="foto" class="form-control">
                <small class="text-muted">Kosongkan jika tidak ingin ganti foto</small>
            </div>

            <div class="mb-3">
                <label for="tipe_kamar" class="form-label">Tipe Kamar</label>
                <input type="text" name="tipe_kamar" class="form-control" value="{{ $kamar->tipe_kamar }}" required>
            </div>

            <div class="mb-3">
                <label for="jumlah_kamar" class="form-label">Jumlah Kamar</label>
                <input type="number" name="jumlah_kamar" class="form-control" value="{{ $kamar->jumlah_kamar }}" required>
            </div>

            <div class="mb-3">
                <label for="fasilitas" class="form-label">Fasilitas Kamar</label>
                <textarea name="fasilitas" class="form-control" rows="3" required>{{ $kamar->fasilitas }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('kamar.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection
