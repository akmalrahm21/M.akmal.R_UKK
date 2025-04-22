<?php

namespace App\Http\Controllers;

use App\Models\Resepsionis;
use App\Models\Kamar;
use Illuminate\Http\Request;
use App\Mail\BookingConfirmationMail;
use Illuminate\Support\Facades\Mail;

class ResepsionisController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'kamar_id' => 'required|exists:kamars,id',
            'nama' => 'required|string|max:255',
            'email' => 'required|email',
            'telepon' => 'required|string|max:20',
            'jumlah_orang' => 'required|integer|min:1',
            'jumlah_pesan' => 'required|integer|min:1',
            'checkin' => 'required|date',
            'checkout' => 'required|date|after:checkin',
            'tipe_kamar' => 'required|string',
        ]);

        $kamar = Kamar::findOrFail($request->kamar_id);

        if ($request->jumlah_pesan > $kamar->jumlah_kamar) {
            return response()->json(['error' => 'Jumlah kamar tidak mencukupi.'], 422);
        }

        try {
            $pesanan = Resepsionis::create([
                'kamar_id' => $request->kamar_id,
                'nama' => $request->nama,
                'email' => $request->email,
                'telepon' => $request->telepon,
                'jumlah_orang' => $request->jumlah_orang,
                'jumlah_pesan' => $request->jumlah_pesan,
                'checkin' => $request->checkin,
                'checkout' => $request->checkout,
                'status' => 'pending',
            ]);

            $bookingData = $pesanan->toArray();
            $bookingData['room_type'] = $request->tipe_kamar; 

            Mail::to($request->email)->send(new BookingConfirmationMail($bookingData));

            return response()->json([
                'success' => 'Pesanan berhasil dibuat!',
                'resepsionis_id' => $pesanan->id
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan saat membuat pesanan.'], 500);
        }
    }

    public function delete($id)
    {
        $pesanan = Resepsionis::findOrFail($id);

        try {
            $kamar = Kamar::findOrFail($pesanan->kamar_id);

            if ($pesanan->bukti_pembayaran && file_exists(public_path('bukti_pembayaran/' . $pesanan->bukti_pembayaran))) {
                unlink(public_path('bukti_pembayaran/' . $pesanan->bukti_pembayaran));
            }

            $kamar->jumlah_kamar += $pesanan->jumlah_pesan;
            $kamar->save();

            $pesanan->delete();

            return redirect()->back()->with('success', 'Pesanan berhasil dihapus dan jumlah kamar diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus pesanan.');
        }
    }

    public function uploadBukti(Request $request)
    {
        $request->validate([
            'resepsionis_id' => 'required|exists:resepsionis,id',
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $pesanan = Resepsionis::findOrFail($request->resepsionis_id);

        if ($request->hasFile('bukti_pembayaran')) {
            $file = $request->file('bukti_pembayaran');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('bukti_pembayaran'), $filename);

            $pesanan->bukti_pembayaran = $filename;
            $pesanan->save();

            return redirect()->back()->with('success', 'Bukti pembayaran berhasil diupload!');
        }

        return redirect()->back()->with('error', 'Gagal upload bukti pembayaran.');
    }


    public function konfirmasi($id)
    {
        $pesanan = Resepsionis::findOrFail($id);
        $kamar = Kamar::findOrFail($pesanan->kamar_id);

        if ($pesanan->jumlah_pesan > $kamar->jumlah_kamar) {
            return redirect()->back()->with('error', 'Jumlah kamar tidak mencukupi untuk dikonfirmasi.');
        }

        try {
            $kamar->jumlah_kamar -= $pesanan->jumlah_pesan;
            $kamar->save();

            $pesanan->status = 'memesan';
            $pesanan->save();

            return redirect()->back()->with('success', 'Pesanan berhasil dikonfirmasi.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal konfirmasi pesanan.');
        }
    }

    public function index()
    {
        if (auth()->user()->role !== 'resepsionis') {
            return redirect()->route('home')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        $pesanans = Resepsionis::latest()->get();
        return view('resepsionis.index', compact('pesanans'));
    }

}
