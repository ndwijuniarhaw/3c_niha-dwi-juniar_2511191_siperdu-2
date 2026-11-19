<?php
 
namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;
 
class KategoriController extends Controller
{
    public function index()
    {
        // withCount menambah kolom buku_count (jumlah buku per kategori)
        $kategori = Kategori::withCount('buku')->orderBy('nama_kategori')->get();
 
        return view('admin.kategori.index', compact('kategori'));
    }
 
    public function create()
    {
        $kategori = new Kategori();
 
        return view('admin.kategori.create', compact('kategori'));
    }
 
    public function store(Request $request)
    {
        Kategori::create($this->validasi($request));
 
        return redirect()->route('admin.kategori.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }
 
    public function edit(Kategori $kategori)
    {
        return view('admin.kategori.edit', compact('kategori'));
    }
 
    public function update(Request $request, Kategori $kategori)
    {
        $kategori->update($this->validasi($request));
 
        return redirect()->route('admin.kategori.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }
 
    public function destroy(Kategori $kategori)
    {
        $kategori->delete();   // buku pada kategori ini ikut terhapus (cascade)
 
        return redirect()->route('admin.kategori.index')
            ->with('success', 'Kategori "' . $kategori->nama_kategori . '" berhasil dihapus.');
    }
 
    private function validasi(Request $request): array
    {
        return $request->validate([
            'nama_kategori' => 'required|string|max:100',
        ], [
            'required' => ':attribute wajib diisi.',
            'max'      => ':attribute terlalu panjang.',
   ], [
            'nama_kategori' => 'Nama kategori',
        ]);
    }
}
