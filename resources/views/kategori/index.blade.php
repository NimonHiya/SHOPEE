@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Daftar Kategori</h2>
    
    @if ($categories->isEmpty())
        <div class="alert alert-warning">Tidak ada kategori yang ditemukan.</div>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Nama Kategori</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $kategori)
                    <tr>
                        <td>{{ $kategori->nama }}</td>
                        <td>
                            <a href="{{ route('kategori.edit', $kategori->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('kategori.destroy', $kategori->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <a href="{{ route('kategori.create') }}" class="btn btn-primary">Tambah Kategori</a>
</div>
@endsection
