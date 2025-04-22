@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Data Fasilitas</h1>
    <a href="{{ route('fasilitas.create') }}" class="btn btn-primary mb-3">+ Tambah Fasilitas</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Keterangan</th>
                <th>Foto</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($fasilitas as $item)
                <tr>
                    <td>{{ $item->nama_fasilitas }}</td>
                    <td>{{ $item->keterangan }}</td>
                    <td>
                        @if ($item->foto_fasilitas)
                            <img src="{{ Storage::url($item->foto_fasilitas) }}" width="100">
                        @else
                            <small class="text-muted">Belum ada foto</small>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('fasilitas.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('fasilitas.destroy', $item->id) }}" method="POST" style="display:inline-block;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin and ingin hapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4">Belum ada data</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
