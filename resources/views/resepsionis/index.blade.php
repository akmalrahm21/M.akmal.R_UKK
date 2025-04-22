@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-3">Daftar Pesanan Resepsionis</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Telepon</th>
                <th>Jumlah Orang</th>
                <th>Jumlah Kamar</th>
                <th>Checkin</th>
                <th>Checkout</th>
                <th>Status</th>
                <th>Bukti Pembayaran</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pesanans as $p)
            <tr>
                <td>{{ $p->nama }}</td>
                <td>{{ $p->email }}</td>
                <td>{{ $p->telepon }}</td>
                <td>{{ $p->jumlah_orang }}</td>
                <td>{{ $p->jumlah_pesan }}</td>
                <td>{{ $p->checkin }}</td>
                <td>{{ $p->checkout }}</td>
                <td>
                    <span class="badge
                        @if($p->status == 'pending') bg-warning
                        @elseif($p->status == 'memesan') bg-success
                        @endif">
                        {{ ucfirst($p->status) }}
                    </span>
                </td>


                <td>
                    @if($p->bukti_pembayaran)
                        <a href="{{ asset('bukti_pembayaran/' . $p->bukti_pembayaran) }}" target="_blank">
                            <img src="{{ asset('bukti_pembayaran/' . $p->bukti_pembayaran) }}" width="80" class="img-thumbnail" alt="Bukti">
                        </a>
                    @else
                        <span class="text-danger">Belum ada</span>
                    @endif
                </td>

                <td>
                    @if($p->status == 'pending')
                    <form action="{{ route('resepsionis.konfirmasi', $p->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-sm btn-primary">Konfirmasi</button>
                    </form>
                    @else
                    <button class="btn btn-sm btn-secondary" disabled>Sudah Dikonfirmasi</button>
                    @endif
                    <form action="{{ route('resepsionis.delete', $p->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus pesanan ini?')">Hapus</button>
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
