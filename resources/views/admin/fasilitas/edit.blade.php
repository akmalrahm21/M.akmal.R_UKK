@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ isset($fasilitas) ? 'Edit' : 'Tambah' }} Fasilitas</h1>

    <form action="{{ isset($fasilitas) ? route('fasilitas.update', $fasilitas->id) : route('fasilitas.store') }}"
          method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($fasilitas)) @method('PUT') @endif

        <div class="mb-3">
            <label>Nama Fasilitas</label>
            <input type="text" name="nama_fasilitas" class="form-control" value="{{ $fasilitas->nama_fasilitas ?? old('nama_fasilitas') }}" required>
        </div>

        <div class="mb-3">
            <label>Keterangan</label>
            <textarea name="keterangan" class="form-control">{{ $fasilitas->keterangan ?? old('keterangan') }}</textarea>
        </div>

        <div class="mb-3">
            <label>Foto Fasilitas</label>
            <input type="file" name="foto_fasilitas" class="form-control">
            @if (isset($fasilitas) && $fasilitas->foto_fasilitas)
                <img src="{{ Storage::url($fasilitas->foto_fasilitas) }}" width="100" class="mt-2">
            @endif
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
    </form>
</div>
@endsection

