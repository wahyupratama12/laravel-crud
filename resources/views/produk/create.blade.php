@extends('app')

@section('title', 'Tambah Produk')

@section('content')
<div class="container mt-5">
    <h2 class="text-center mb-4">➕ Tambah Produk Baru</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Terjadi kesalahan!</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('produk.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nama" class="form-label">Nama Produk</label>
            <input type="text" name="nama" class="form-control" id="nama" value="{{ old('nama') }}" required>
        </div>

        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea name="deskripsi" class="form-control" id="deskripsi" rows="3">{{ old('deskripsi') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="harga" class="form-label">Harga (Rp)</label>
            <input type="number" name="harga" class="form-control" id="harga" value="{{ old('harga') }}" required>
        </div>

        <div class="mb-3">
            <label for="stok" class="form-label">Stok</label>
            <input type="number" name="stok" class="form-control" id="stok" value="{{ old('stok') }}" required>
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('produk.index') }}" class="btn btn-secondary">⬅ Kembali</a>
            <button type="submit" class="btn btn-primary">💾 Simpan</button>
        </div>
    </form>
</div>
@endsection
