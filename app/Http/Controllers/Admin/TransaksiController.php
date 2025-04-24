<?php

namespace App\Http\Controllers\Admin;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TransaksiController extends Controller
{
    // Display a list of transactions
    public function index()
    {
        $transactions = Transaksi::all(); // Fetch all transactions from the database
        return view('admin.transactions.index', compact('transactions')); // Pass the data to a view
    }

    // Approve the transaction
    public function approve($id)
    {
        $transaction = Transaksi::findOrFail($id);

        if ($transaction->status == 'pending') {
            $transaction->status = 'approved';
            $transaction->save();
        }

        return redirect()->route('admin.transaksi.index')->with('success', 'Transaction approved successfully.');
    }
}
