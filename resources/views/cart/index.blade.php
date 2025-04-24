@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Your Cart</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($cart)
        <table class="table">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0 @endphp
                @foreach($cart as $id => $item)
                    @php 
                        $subtotal = $item['harga'] * $item['quantity']; 
                        $total += $subtotal; 
                    @endphp
                    <tr>
                        <td>{{ $item['nama'] }}</td>
                        <td>Rp {{ number_format($item['harga']) }}</td>
                        <td>{{ $item['quantity'] }}</td>
                        <td>Rp {{ number_format($subtotal) }}</td>
                        <td>
                            <form action="{{ route('cart.remove', $id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="3"><strong>Total</strong></td>
                    <td colspan="2"><strong>Rp {{ number_format($total) }}</strong></td>
                </tr>
            </tbody>
        </table>
        <form action="{{ route('cart.checkout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-success">Checkout & Download Receipt</button>
        </form>
    @else
        <p>Your cart is empty.</p>
    @endif
</div>
@endsection
