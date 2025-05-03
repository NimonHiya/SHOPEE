@extends('layouts.app')

@section('content') 
<div class="container"> 
    <div class="row justify-content-center"> 
        <div class="col-md-8"> 
            <div class="card"> 
                <div class="card-header">{{ __('Dashboard') }}</div> 
                <div class="card-body">
                    <a href="{{ route('produk.create') }}" class="mb-3 btn btn-sm btn-primary">Tambah Produk</a>
                    <a href="{{ route('kategori.index') }}" class="mb-3 btn btn-sm btn-success">Daftar Kategori</a>
                    <a href="{{ route('admin.transaksi.index') }}" class="mb-3 btn btn-sm btn-secondary">Kelola Transaksi</a>

                    <table class="table"> 
                        <thead> 
                            <tr> 
                                <th>Foto</th> <!-- Kolom foto -->
                                <th>Kode Produk</th> 
                                <th>Nama</th> 
                                <th>Harga</th> 
                                <th>Stok</th> 
                                <th>Kategori</th> 
                                <th>Aksi</th> 
                            </tr> 
                        </thead> 
                        <tbody> 
                            @foreach($produks as $produk) 
                            <tr> 
                                <td>
                                    @if ($produk->photo)
                                        <img src="{{ asset('storage/' . $produk->photo) }}" width="60" height="60" alt="Foto Produk">
                                    @else
                                        <small>Tidak ada foto</small>
                                    @endif
                                </td>
                                <td>{{ $produk->kode_produk }}</td> 
                                <td>{{ $produk->nama }}</td> 
                                <td>{{ $produk->harga }}</td> 
                                <td>{{ $produk->stok }}</td> 
                                <td>{{ $produk->kategori->nama ?? 'Kategori Tidak Tersedia' }}</td> 
                                <td> 
                                    <a href="{{ route('produk.edit', $produk->id) }}" class="btn btn-warning btn-sm">Edit</a> 
                                    <form action="{{ route('produk.destroy', $produk->id) }}" method="POST" style="display:inline;">
                                        @csrf 
                                        @method('DELETE') 
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">Hapus</button> 
                                    </form> 
                                </td> 
                            </tr> 
                            @endforeach 
                        </tbody> 
                    </table> 
                </div>
            </div> 
        </div> 
    </div> 
</div> 
@endsection
