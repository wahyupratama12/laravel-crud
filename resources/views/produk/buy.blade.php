@extends('app')

@section('title', 'Beli Produk')

@section('content')
<div class="container mt-5" style="max-width: 600px;">
    <h2 class="text-center mb-4">🛒 Beli Produk</h2>

    @if(session('error'))
        <div class="alert alert-danger text-center">{{ session('error') }}</div>
    @endif

    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <h4 class="card-title">{{ $produk->nama }}</h4>
            <p class="card-text">Harga: <strong>Rp{{ number_format($produk->harga, 0, ',', '.') }}</strong></p>
            <p class="card-text">Stok tersedia: <strong>{{ $produk->stok }}</strong></p>
            <p class="card-text text-muted">{{ $produk->deskripsi }}</p>

            <form method="POST" action="{{ route('produk.purchase', $produk->id) }}">
                @csrf
                <div class="mb-3">
                    <label for="quantity" class="form-label">Jumlah yang ingin dibeli</label>
                    <input type="number" name="quantity" id="quantity" class="form-control" min="1" max="{{ $produk->stok }}" required>
                </div>

                <button type="submit" class="btn btn-primary w-100">Beli Sekarang</button>
                <a href="{{ route('produk.index') }}" class="btn btn-secondary mt-2 w-100">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
