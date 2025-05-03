@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Tambah Kategori</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Ups!</strong> Ada masalah dengan inputan kamu.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('kategori.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nama">Nama Kategori</label>
            <input type="text" name="nama" class="form-control" required>
        </div>

        <button type="submit" class="mt-2 btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
