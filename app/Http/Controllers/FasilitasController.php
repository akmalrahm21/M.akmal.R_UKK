<?php
namespace App\Http\Controllers;

use App\Models\Fasilitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FasilitasController extends Controller
{
    public function index()
    {
        $fasilitas = Fasilitas::all();
        return view('admin.fasilitas.index', compact('fasilitas'));
    }

    public function create()
    {
        return view('admin.fasilitas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_fasilitas' => 'required',
            'keterangan' => 'nullable',
            'foto_fasilitas' => 'nullable|image|mimes:jpeg,jpg,png|max:2048'
        ]);

        $data = $request->only('nama_fasilitas', 'keterangan');

        if ($request->hasFile('foto_fasilitas')) {
            $data['foto_fasilitas'] = $request->file('foto_fasilitas')->store('fasilitas', 'public');
        }

        Fasilitas::create($data);

        return redirect()->route('fasilitas.index')->with('success', 'Fasilitas berhasil ditambahkan!');
    }

    public function edit(Fasilitas $fasilitas)
    {
        return view('admin.fasilitas.edit', compact('fasilitas'));
    }

    public function update(Request $request, Fasilitas $fasilitas)
    {
        $request->validate([
            'nama_fasilitas' => 'required',
            'keterangan' => 'nullable',
            'foto_fasilitas' => 'nullable|image|mimes:jpeg,jpg,png|max:2048'
        ]);

        $data = $request->only('nama_fasilitas', 'keterangan');

        if ($request->hasFile('foto_fasilitas')) {

            if ($fasilitas->foto_fasilitas) {
                Storage::disk('public')->delete($fasilitas->foto_fasilitas);
            }
            $data['foto_fasilitas'] = $request->file('foto_fasilitas')->store('fasilitas', 'public');
        }

        $fasilitas->update($data);

        return redirect()->route('fasilitas.index')->with('success', 'Fasilitas berhasil diupdate!');
    }

    public function destroy(Fasilitas $fasilitas)
    {
        if ($fasilitas->foto_fasilitas) {
            Storage::disk('public')->delete($fasilitas->foto_fasilitas);
        }

        $fasilitas->delete();

        return redirect()->route('fasilitas.index')->with('success', 'Fasilitas dihapus!');
    }
}
