<?php

namespace App\Http\Controllers;

use App\Models\Resepsionis;
use App\Models\Kamar;
use Illuminate\Support\Facades\Log;
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

            return response()->json([
                'resepsionis_id' => $pesanan->id
            ]);
        } catch (\Exception $e) {
            \Log::error("Kesalahan saat membuat pesanan: " . $e->getMessage());
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
            $pesanan->status = 'paid';
            $pesanan->save();

            try {
                $bookingData = $pesanan->toArray();
                $bookingData['room_type'] = $pesanan->tipe_kamar;

                Mail::to($pesanan->email)->send(new BookingConfirmationMail($bookingData));
            } catch (\Exception $e) {
                \Log::error("Kesalahan saat mengirim email: " . $e->getMessage());
                return redirect()->back()->with('error', 'Bukti pembayaran berhasil diunggah, tetapi email gagal dikirim.');
            }

            return redirect()->back()->with('success', 'Bukti pembayaran berhasil diunggah dan email konfirmasi telah dikirim.');
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

public function batal($id)
{
    $pesanan = Resepsionis::findOrFail($id);

    try {
        $kamar = Kamar::findOrFail($pesanan->kamar_id);

        $kamar->jumlah_kamar += $pesanan->jumlah_pesan;
        $kamar->save();

        $pesanan->delete();

        return response()->json(['success' => 'Pesanan berhasil dibatalkan.']);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Gagal membatalkan pesanan.'], 500);
    }
}
public function batalEmail($id)
{
    $pesanan = Resepsionis::findOrFail($id);

    try {

        $pesanan->status = 'email_batal';
        $pesanan->save();

        return response()->json(['success' => 'Pengiriman email berhasil dibatalkan.']);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Gagal membatalkan pengiriman email.'], 500);
    }
}

}
