
<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
use App\Http\Controllers\HomeController;

Route::get('/home', [HomeController::class, 'index'])->name('home');


    // Route::get('/', function () {
    //     return view('welcome');
    // });
Route::get('/dashboard', function () {
    return view('dashboard');
});
use App\Http\Controllers\KamarController;

Route::resource('/admin/kamar', KamarController::class);

use App\Http\Controllers\FasilitasController;
Route::resource('fasilitas', FasilitasController::class)->parameters([
    'fasilitas' => 'fasilitas'
]);





use App\Http\Controllers\ResepsionisController;

Route::post('/resepsionis/batal/{id}', [ResepsionisController::class, 'batal'])->name('resepsionis.batal');
Route::post('/pesanan', [ResepsionisController::class, 'store'])->name('pesanan.store');
Route::get('/resepsionis', [ResepsionisController::class, 'index'])->name('resepsionis.index');
Route::put('/resepsionis/konfirmasi/{id}', [ResepsionisController::class, 'konfirmasi'])->name('resepsionis.konfirmasi');
Route::post('/upload-bukti', [ResepsionisController::class, 'uploadBukti'])->name('resepsionis.upload_bukti');

use App\Http\Controllers\AuthController;
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('register', [AuthController::class, 'register']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/resepsionis', [ResepsionisController::class, 'index'])->name('resepsionis.index');
Route::delete('/resepsionis/{id}', [ResepsionisController::class, 'delete'])->name('resepsionis.delete');
Route::resource('/admin/kamar', KamarController::class);




Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
});

use Illuminate\Foundation\Auth\EmailVerificationRequest;

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('status', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');
