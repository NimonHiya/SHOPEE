<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display the product list with optional category filter.
     */
    public function index(Request $request)
    {
        $kategoris = Kategori::all();
        $query = Produk::query();

        // Filter by kategori
        if ($request->filled('kategori')) {
            $query->where('id_kategori', $request->kategori);
        }

        // Filter by search keyword (nama produk)
        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        // Paginate result (6 per page, you can change)
        $produks = $query->paginate(6);

        // Return lowercase view name for consistency
        return view('home', compact('produks', 'kategoris'));
    }

    /**
     * Display all products for admin.
     */
    public function adminHome()
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
     * Store a newly created product.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_produk' => 'required|unique:produks',
            'nama'        => 'required|string',
            'id_kategori' => 'required|exists:kategoris,id',
            'harga'       => 'required|numeric',
            'stok'        => 'required|integer',
        ]);

        Produk::create($request->all());

        return redirect()->route('adminHome')
            ->with('success', 'Produk berhasil ditambahkan');
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
        $request->validate([
            'kode_produk' => 'required',
            'nama'        => 'required|string',
            'id_kategori' => 'required|exists:kategoris,id',
            'harga'       => 'required|numeric',
            'stok'        => 'required|integer',
        ]);

        $produk = Produk::findOrFail($id);
        $produk->update($request->all());

        return redirect()->route('adminHome')
            ->with('success', 'Produk berhasil diperbarui');
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        $produk->delete();

        return redirect()->route('adminHome')
            ->with('success', 'Produk berhasil dihapus');
    }
}
