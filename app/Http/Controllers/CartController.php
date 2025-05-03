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
    // Add product to cart
    public function add($id)
    {
        $produk = Produk::findOrFail($id);
        $cart = session()->get('cart', []);

        // Check if the requested quantity exceeds stock
        if (isset($cart[$id])) {
            // If the product is already in the cart, increment the quantity
            if ($cart[$id]['quantity'] < $produk->stok) {
                $cart[$id]['quantity']++;
            } else {
                // If the quantity exceeds stock, show an error message
                return redirect()->back()->with('error', 'Stok tidak cukup untuk menambah produk ini.');
            }
        } else {
            // Add product to the cart if not already present
            $cart[$id] = [
                "nama" => $produk->nama,
                "harga" => $produk->harga,
                "quantity" => 1
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Produk ditambahkan ke keranjang!');
    }

    // View the cart
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('cart.index', compact('cart'));
    }

    // Remove a product from the cart
    public function remove($id)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        return redirect()->route('cart.index')->with('success', 'Produk dihapus dari keranjang.');
    }

    // Checkout process
    public function checkout()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kamu kosong.');
        }

        // Create a transaction record
        $transaksi = Transaksi::create([
            'user_id' => Auth::id(),
            'status' => 'pending',
        ]);

        // Process each cart item
        foreach ($cart as $id => $item) {
            // Check if enough stock is available before creating the transaction item
            $produk = Produk::find($id);

            if ($produk->stok < $item['quantity']) {
                return redirect()->route('cart.index')->with('error', 'Stok tidak cukup untuk produk: ' . $produk->nama);
            }

            // Create a transaction item
            TransaksiItem::create([
                'transaksi_id' => $transaksi->id,
                'produk_id' => $id,
                'quantity' => $item['quantity'],
                'harga' => $item['harga'],
            ]);

            // Update the product stock
            $produk->stok -= $item['quantity'];
            $produk->save();
        }

        // Clear the cart session
        session()->forget('cart');

        // Generate PDF for the transaction
        $pdf = Pdf::loadView('pdf.receipt', compact('cart', 'transaksi'));

        // Download the PDF
        return $pdf->download('transaction_receipt_' . $transaksi->id . '.pdf');
    }
}
