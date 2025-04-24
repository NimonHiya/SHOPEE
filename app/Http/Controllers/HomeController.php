<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $produks = Produk::all(); // Ambil semua data dari tabel tikets
        // Kirim data ke tampilan
        return view('Home', ['produks' => $produks]);
    }

    public function adminHome()
    {
        $produks = Produk::all(); // Ambil semua data dari tabel tikets
        // Kirim data ke tampilan
        return view('adminHome', ['produks' => $produks]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_produk' => 'required|unique:tikets',
            'nama' => 'required',
            'harga' => 'required',
        ]);
        Produk::create($request->all());
        return redirect()->route('adminHome')
        ->with('success', 'Produk berhasil ditambahkan');
        // Buat objek tiket baru
        $produk = new Produk;
        // Simpan tiket ke dalam database
        $produk->save();
    }

    public function edit($id)
    {
        $produk = Produk::find($id);
        return view('produk.edit', compact('produk'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_produk' => 'required',
            'nama' => 'required',
            'harga' => 'required',
        ]);
        $produk = Produk::find($id);
        $produk->update($request->all());
        return redirect()->route('adminHome')
        ->with('success', 'Produk berhasil diperbarui');
    }
    public function destroy($id)
    {
        $produk = Produk::find($id);
        $produk->delete();
        return redirect()->route('adminHome')
        ->with('success', 'Produk berhasil dihapus');
    }

}
