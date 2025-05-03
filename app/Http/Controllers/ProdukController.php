<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    /**
     * Display a listing of the products.
     */
    public function index()
    {
        $produks = Produk::all();
        return view('adminHome', compact('produks'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        $kategoris = Kategori::all();
        return view('produk.create', compact('kategoris'));
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_produk' => 'required|unique:produks,kode_produk',
            'nama'        => 'required|string|max:255',
            'id_kategori' => 'required|exists:kategoris,id',
            'harga'       => 'required|numeric|min:1',
            'stok'        => 'required|integer|min:0',
            'photo'       => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $photoPath = null;

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('produk_photos', 'public');
        }

        Produk::create([
            'kode_produk' => $request->kode_produk,
            'nama'        => $request->nama,
            'id_kategori' => $request->id_kategori,
            'harga'       => $request->harga,
            'stok'        => $request->stok,
            'photo'       => $photoPath,
        ]);

        return redirect()->route('adminHome')->with('success', 'Produk berhasil ditambahkan');
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        $kategoris = Kategori::all();
        return view('produk.edit', compact('produk', 'kategoris'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);

        $request->validate([
            'kode_produk' => 'required',
            'nama'        => 'required|string|max:255',
            'id_kategori' => 'required|exists:kategoris,id',
            'harga'       => 'required|numeric|min:1',
            'stok'        => 'required|integer|min:0',
            'photo'       => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        // Jika ada foto baru diupload
        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($produk->photo) {
                Storage::disk('public')->delete($produk->photo);
            }

            // Simpan foto baru
            $photoPath = $request->file('photo')->store('produk_photos', 'public');
            $produk->photo = $photoPath;
        }

        $produk->update([
            'kode_produk' => $request->kode_produk,
            'nama'        => $request->nama,
            'id_kategori' => $request->id_kategori,
            'harga'       => $request->harga,
            'stok'        => $request->stok,
            'photo'       => $produk->photo,
        ]);

        return redirect()->route('adminHome')->with('success', 'Produk berhasil diperbarui');
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);

        // Hapus file foto dari storage
        if ($produk->photo) {
            Storage::disk('public')->delete($produk->photo);
        }

        $produk->delete();

        return redirect()->route('adminHome')->with('success', 'Produk berhasil dihapus');
    }
}
