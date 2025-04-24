<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\TransaksiItem;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class CartController extends Controller
{
    public function add($id)
    {
        $produk = Produk::findOrFail($id);
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "nama" => $produk->nama,
                "harga" => $produk->harga,
                "quantity" => 1
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Produk ditambahkan ke keranjang!');
    }

    public function index()
    {
        $cart = session()->get('cart', []);
        return view('cart.index', compact('cart'));
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        return redirect()->route('cart.index')->with('success', 'Produk dihapus dari keranjang.');
    }

    public function checkout()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('success', 'Keranjang kamu kosong.');
        }

        $transaksi = Transaksi::create([
            'user_id' => Auth::id(),
            'status' => 'pending',
        ]);

        foreach ($cart as $id => $item) {
            TransaksiItem::create([
                'transaksi_id' => $transaksi->id,
                'produk_id' => $id,
                'quantity' => $item['quantity'],
                'harga' => $item['harga'],
            ]);

            $produk = Produk::find($id);
            $produk->stok -= $item['quantity'];
            $produk->save();
        }

        session()->forget('cart');

        // Generate PDF for the transaction
        $pdf = Pdf::loadView('pdf.receipt', compact('cart', 'transaksi'));

        // Download the PDF
        return $pdf->download('transaction_receipt_' . $transaksi->id . '.pdf');
    }
}
