<!DOCTYPE html>
<html>
<head>
    <title>Konfirmasi Pemesanan Kamar</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f9f9f9;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #4CAF50;
        }
        p {
            margin: 10px 0;
        }
        .footer {
            margin-top: 20px;
            font-size: 0.9em;
            color: #555;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Terima Kasih atas Pemesanan Anda!</h1>
        <p>Halo <strong>{{ $bookingData['nama'] }}</strong>,</p>
        <p>Terima kasih telah memercayai kami untuk kebutuhan akomodasi Anda. Berikut adalah detail pemesanan Anda:</p>
        <p><strong>Nama:</strong> {{ $bookingData['nama'] }}</p>
        <p><strong>Email:</strong> {{ $bookingData['email'] }}</p>
        <p><strong>Telepon:</strong> {{ $bookingData['telepon'] }}</p>
        <p><strong>Jumlah Orang:</strong> {{ $bookingData['jumlah_orang'] }}</p>
        <p><strong>Jumlah Kamar Dipesan:</strong> {{ $bookingData['jumlah_pesan'] }}</p>
        <p><strong>Check-in:</strong> {{ $bookingData['checkin'] }}</p>
        <p><strong>Check-out:</strong> {{ $bookingData['checkout'] }}</p>
        <p><strong>Tipe Kamar:</strong> {{ $bookingData['room_type'] }}</p>
        <p><b>Tunjukkan ini ke resepsionis ketika hendak melakukan konfirmasi pemesanan kamar</b>. Kami berharap Anda memiliki pengalaman menginap yang menyenangkan!</p>
        <div class="footer">
            <p>Salam hangat,</p>
            <p><strong>Tim Hotel Insitu</strong></p>
        </div>
    </div>
</body>
</html>
