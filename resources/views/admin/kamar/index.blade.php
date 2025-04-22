@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Data Kamar</h1>
    <a href="{{ route('kamar.create') }}" class="btn btn-primary mb-3">+ Tambah Kamar</a>


    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Foto</th>
                <th>Tipe Kamar</th>
                <th>Jumlah</th>
                <th>Fasilitas</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($kamar as $item)
                <tr>
                    <td><img src="{{ asset('storage/' . $item->foto) }}" width="100" alt="Foto"></td>
                    <td>{{ $item->tipe_kamar }}</td>
                    <td>{{ $item->jumlah_kamar }}</td>
                    <td>{{ $item->fasilitas }}</td>
                    <td>
                        <a href="{{ route('kamar.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('kamar.destroy', $item->id) }}" method="POST" style="display:inline-block;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin anda ingin hapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
