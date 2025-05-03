@extends('layouts.app')

@section('content')

<div class="container">
    <!-- Filter Form -->
    <form method="GET" action="{{ route('home') }}" class="mb-4">
        <div class="row">
            <div class="col-md-4">
                <select name="kategori" class="form-control">
                    <option value="">Pilih Kategori</option>
                    @foreach($kategoris as $kategori)
                        <option value="{{ $kategori->id }}" {{ request('kategori') == $kategori->id ? 'selected' : '' }}>
                            {{ $kategori->nama }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Cari produk berdasarkan nama">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary btn-block">Cari</button>
            </div>
        </div>
    </form>

    <!-- Produk Grid -->
    <div class="row">
        @forelse($produks as $produk)
            <div class="mb-4 col-sm-6 col-md-4 col-lg-3">
                <div class="shadow-sm card h-100">
                    @if ($produk->photo)
                        <img src="{{ asset('storage/' . $produk->photo) }}" 
                             class="card-img-top" 
                             style="height: 180px; object-fit: contain; padding: 10px;" 
                             alt="{{ $produk->nama }}">
                    @else
                        <img src="https://via.placeholder.com/180x180?text=No+Image" 
                             class="card-img-top" 
                             style="height: 180px; object-fit: contain; padding: 10px;" 
                             alt="No Image">
                    @endif

                    <div class="p-2 card-body">
                        <h6 class="card-title text-truncate">{{ $produk->nama }}</h6>
                        <p class="mb-1 card-text">
                            <small><strong>Harga:</strong> Rp{{ number_format($produk->harga, 0, ',', '.') }}</small><br>
                            <small><strong>Stok:</strong> {{ $produk->stok }}</small>
                        </p>
                    </div>
                    <div class="p-2 bg-transparent card-footer border-top-0">
                        @if($produk->stok > 0)
                            <form action="{{ route('cart.add', $produk->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success btn-block">Tambah ke Keranjang</button>
                            </form>
                        @else
                            <button class="btn btn-sm btn-secondary btn-block" disabled>Stok Habis</button>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center col-12">
                <p>Produk tidak ditemukan</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-4 d-flex justify-content-center">
        {{ $produks->links() }}
    </div>
</div>

@endsection
