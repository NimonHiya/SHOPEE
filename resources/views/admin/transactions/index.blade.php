@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Manage Transactions</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Transaction ID</th>
                <th>User</th>
                <th>Status</th>
                <th>Action</th>
            </tr>   
        </thead>
        <tbody>
            @foreach($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->id }}</td>
                    <td>{{ $transaction->user->name }}</td>
                    <td>{{ $transaction->status }}</td>
                    <td>
                        @if($transaction->status == 'pending')
                            <form action="{{ route('admin.transaksi.approve', $transaction->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">Approve</button>
                            </form>
                        @else
                            <span class="badge badge-success">Approved</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
