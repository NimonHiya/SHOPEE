<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    // Menampilkan daftar kategori
    public function index()
    {
        // Mengambil semua kategori
        $categories = Kategori::all();

        // Mengirim data kategori ke view
        return view('kategori.index', compact('categories'));
    }

    // Menampilkan form untuk menambahkan kategori baru
    public function create()
    {
        return view('kategori.create');
    }

    // Menyimpan kategori baru yang ditambahkan
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255|unique:kategoris,nama', // Ensure the category name is unique
        ]);

        // Menyimpan kategori baru menggunakan data yang telah divalidasi
        Kategori::create($request->validated());

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    // Menampilkan form untuk mengedit kategori
    public function edit(Kategori $kategori)
    {
        return view('kategori.edit', compact('kategori'));
    }

    // Memperbarui kategori
    public function update(Request $request, Kategori $kategori)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255|unique:kategoris,nama,' . $kategori->id, // Ensure the category name is unique except for the current category
        ]);

        // Memperbarui kategori dengan data yang telah divalidasi
        $kategori->update($request->validated());

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    // Menghapus kategori
    public function destroy(Kategori $kategori)
    {
        // Menghapus kategori
        $kategori->delete();

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus!');
    }
}
