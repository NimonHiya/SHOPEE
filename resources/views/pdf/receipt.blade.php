<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Transaction Receipt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Transaction Receipt</h1>
    <p><strong>Transaction ID:</strong> {{ $transaksi->id }}</p>
    <p><strong>User:</strong> {{ $transaksi->user->name }}</p>
    <table>
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
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
                </tr>
            @endforeach
            <tr>
                <td colspan="3"><strong>Total</strong></td>
                <td><strong>Rp {{ number_format($total) }}</strong></td>
            </tr>
        </tbody>
    </table>
    <p><strong>Thank you for your purchase!</strong></p>
</body>
</html>
