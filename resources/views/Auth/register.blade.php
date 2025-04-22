<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Hotel Insitu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600&family=Montserrat:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        .form-input {
            transition: all 0.3s ease;
            border-bottom: 2px solid #e2e8f0;
        }
        .form-input:focus {
            border-bottom-color: #D4AF37;
            outline: none;
        }
    </style>
</head>
<body class="bg-[url('https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80')] bg-cover bg-center min-h-screen flex items-center justify-center font-body">
    <div class="bg-white bg-opacity-95 backdrop-blur-sm p-10 rounded-xl shadow-xl w-full max-w-md border border-gold border-opacity-30">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-display font-semibold text-dark-blue mb-2">HOTEL Insitu</h1>
            <div class="w-20 h-1 bg-gold mx-auto"></div>
        </div>

        <h2 class="text-2xl font-display font-medium text-center text-dark-blue mb-8">Buat Akun</h2>

        <form method="POST" action="{{ route('register') }}" class="space-y-6">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                <input type="text" name="name" class="w-full px-3 py-2 form-input bg-transparent border-0 border-b rounded-none" required placeholder="Stalin">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Email</label>
                <input type="email" name="email" class="w-full px-3 py-2 form-input bg-transparent border-0 border-b rounded-none" required placeholder="Adolf@gmail.com">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" name="password" class="w-full px-3 py-2 form-input bg-transparent border-0 border-b rounded-none" required placeholder="••••••••">
                <p class="mt-1 text-xs text-gray-500">Minimal 8 karakter</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                <input type="password" name="password_confirmation" class="w-full px-3 py-2 form-input bg-transparent border-0 border-b rounded-none" required placeholder="••••••••">
            </div>

            <button type="submit" class="w-full bg-gold text-dark-blue py-3 px-4 rounded-md font-medium hover:bg-opacity-90 transition duration-300 shadow-md hover:shadow-lg">
                Daftar
            </button>
        </form>

        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600">
                Sudah punya Akun?
                <a href="{{ route('login') }}" class="font-medium text-gold hover:text-dark-blue transition duration-300">Masuk</a>
            </p>
        </div>
    </div>
</body>
</html>
