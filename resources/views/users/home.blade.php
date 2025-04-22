<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Insitu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>
<body>


<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="#"><i class="bi bi-building"></i> Hotel Insitu</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                @auth
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-link nav-link">Logout</button>
                </form>
                @else
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">Login</a>
                </li>
                @endauth
                @foreach(['Home'=>'#','Kamar'=>'#rooms','Fasilitas'=>'#facilities','Kontak'=>'#contact'] as $label => $href)
                <li class="nav-item"><a class="nav-link" href="{{ $href }}">{{ $label }}</a></li>
                @endforeach
            </ul>
        </div>
    </div>
</nav>

<section class="text-center bg-dark text-white py-5" style="background: linear-gradient(...), url('https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?...'); background-size:cover; margin-top:56px;">
    <div class="container">
        <h1 class="display-4 fw-bold mb-3">Selamat Datang di Hotel Insitu</h1>
        <p class="lead mb-4">Pengalaman menginap mewah dengan kenyamanan tak tertandingi</p>
        <a href="#rooms" class="btn btn-primary btn-lg me-2"><i class="bi bi-door-open"></i> Lihat Kamar</a>
        <a href="#rooms" class="btn btn-success btn-lg"><i class="bi bi-calendar-check"></i> Pesan Sekarang</a>
    </div>
</section>

<section id="rooms" class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-4 border-bottom">Kamar Kami</h2>
        <p class="text-center mb-4">Temukan kamar sesuai kebutuhan Anda</p>
        <div class="d-flex overflow-auto pb-3">
            @foreach($kamars as $kamar)
            <div class="card mx-2" style="min-width: 300px;">
                <img src="{{ Storage::url($kamar->foto) }}" class="card-img-top" style="height:200px; object-fit:cover;">
                <div class="card-body">
                    <h5>{{ $kamar->tipe_kamar }}</h5>
                    <p>{{ $kamar->fasilitas }}</p>
                    <p><i class="bi bi-check-circle-fill text-success"></i> {{ $kamar->jumlah_kamar }} kamar tersedia</p>
                    <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#bookingModal"
                        data-room-id="{{ $kamar->id }}"
                        data-room-type="{{ $kamar->tipe_kamar }}"
                        data-room-photo="{{ Storage::url($kamar->foto) }}"
                        data-room-facilities="{{ $kamar->fasilitas }}"
                        data-room-available="{{ $kamar->jumlah_kamar }}">
                        @if(Auth::check())
                            <i class="bi bi-cart"></i> Pesan
                        @else
                            <a href="{{ route('login') }}" class="btn btn-primary w-100">
                                <i class="bi bi-cart"></i>Pesan
                            </a>
                        @endif
                    </button>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<section id="facilities" class="py-5">
    <div class="container">
        <h2 class="text-center mb-4 border-bottom">Fasilitas Hotel</h2>
        <p class="text-center mb-4">Nikmati berbagai fasilitas premium</p>
        <div class="d-flex overflow-auto pb-3">
            @foreach($fasilitass as $fasilitas)
            <div class="card mx-2" style="min-width: 300px;">
                @if($fasilitas->foto_fasilitas)
                <img src="{{ Storage::url($fasilitas->foto_fasilitas) }}" class="card-img-top" style="height:200px; object-fit:cover;">
                @endif
                <div class="card-body">
                    <h5>{{ $fasilitas->nama_fasilitas }}</h5>
                    <p>{{ $fasilitas->keterangan ?? 'Fasilitas premium untuk kenyamanan Anda' }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<section id="contact" class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-4 border-bottom">Hubungi Kami</h2>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow p-4">
                    <div class="row">
                        <div class="col-md-6">
                            <h5><i class="bi bi-geo-alt-fill text-primary"></i> Alamat</h5>
                            <p>Jl. Otista, RT.03/RW.13, Kp. Tanjung, Kec. Tarogong Kaler, Kabupaten Garut, Jawa Barat 44151</p>
                            <h5><i class="bi bi-telephone-fill text-primary"></i> Telepon</h5>
                            <p>0811-2007-0000</p>
                            <h5><i class="bi bi-envelope-fill text-primary"></i> Email</h5>
                            <p>info@hotelinsitu.com</p>
                        </div>
                        <div class="col-md-6">
                            <h5><i class="bi bi-clock-fill text-primary"></i> Jam Operasional</h5>
                            <p>24 Jam | Check-in: 14.00 | Check-out: 12.00 WIB</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<footer class="bg-dark text-white text-center py-4">
    <div class="container">
        <div class="mb-2">
            @foreach(['facebook','instagram','twitter','youtube'] as $sosmed)
            <a href="#" class="text-white mx-2"><i class="bi bi-{{ $sosmed }} fs-4"></i></a>
            @endforeach
        </div>
        <p>&copy; 2023 Hotel Insitu. All Rights Reserved.</p>
    </div>
</footer>

@include('modal.booking-modal')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('modalCheckin').min = today;

        const bookingModal = document.getElementById('bookingModal');
        bookingModal.addEventListener('show.bs.modal', function(e) {
            const btn = e.relatedTarget;
            document.getElementById('modalRoomId').value = btn.dataset.roomId;
            document.getElementById('modalRoomType').innerText = btn.dataset.roomType;
            document.getElementById('modalRoomPhoto').src = btn.dataset.roomPhoto;
            document.getElementById('modalRoomAvailable').innerText = btn.dataset.roomAvailable;
        });
    });
</script>
</body>
</html>
