<?php
namespace App\Http\Controllers;

use App\Models\Kamar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KamarController extends Controller
{
    public function index()
    {
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('home')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        $kamar = Kamar::all();
        return view('admin.kamar.index', compact('kamar'));
    }

    public function create()
    {
        return view('admin.kamar.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'tipe_kamar' => 'required|string|max:255',
            'jumlah_kamar' => 'required|integer',
            'fasilitas' => 'required|string',
            'harga_kamar' => 'required|numeric',
        ]);

        $data = $request->except('foto');
        $data['harga_kamar'] = $request->input('harga_kamar');

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('kamar', 'public');
            $data['foto'] = $path;
        }

        Kamar::create($data);

        return redirect()->route('kamar.index')->with('success', 'Kamar berhasil ditambahkan!');
    }

    public function edit(Kamar $kamar)
    {
        return view('admin.kamar.edit', compact('kamar'));
    }

    public function update(Request $request, Kamar $kamar)
    {
        $request->validate([
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'tipe_kamar' => 'required|string|max:255',
            'jumlah_kamar' => 'required|integer',
            'fasilitas' => 'required|string',
            'harga_kamar' => 'required|numeric',
        ]);

        $data = $request->except('foto');

        if ($request->hasFile('foto')) {
            if ($kamar->foto && Storage::disk('public')->exists($kamar->foto)) {
                Storage::disk('public')->delete($kamar->foto);
            }

            $path = $request->file('foto')->store('kamar', 'public');
            $data['foto'] = $path;
        }

        $kamar->update($data);

        return redirect()->route('kamar.index')->with('success', 'Kamar berhasil diupdate!');
    }

    public function destroy(Kamar $kamar)
    {
        if ($kamar->foto && Storage::disk('public')->exists($kamar->foto)) {
            Storage::disk('public')->delete($kamar->foto);
        }

        $kamar->delete();

        return redirect()->route('kamar.index')->with('success', 'Kamar berhasil dihapus!');
    }
}
