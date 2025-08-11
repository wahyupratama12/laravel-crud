@extends('app')

@section('title', 'Beli Makanan')

@section('content')
<div class="container mt-5" style="max-width: 600px;">
    <h2 class="text-center mb-4 fw-bold text-primary">
        <i class="bi bi-cart-check-fill me-2"></i> Beli Produk
    </h2>

    {{-- Pesan notifikasi --}}
    @if(session('error'))
        <div class="alert alert-danger text-center shadow-sm">
            <i class="bi bi-exclamation-circle me-1"></i> {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success text-center shadow-sm">
            <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
        </div>
    @endif

    <div class="card shadow-lg border-0 rounded-4 produk-card">
        <div class="card-body">
            <h4 class="card-title fw-bold">{{ $produk->nama }}</h4>
            <div class="mb-3">
                <span class="badge bg-primary fs-6 me-2">
                    <i class="bi bi-tag-fill"></i> Rp{{ number_format($produk->harga, 0, ',', '.') }}
                </span>
                <span class="badge {{ $produk->stok > 0 ? 'bg-success' : 'bg-secondary' }}">
                    <i class="bi bi-box-seam"></i> Stok: {{ $produk->stok }}
                </span>
            </div>
            <p class="card-text text-muted">{{ $produk->deskripsi }}</p>

            <form method="POST" action="{{ route('produk.purchase', $produk->id) }}">
                @csrf
                <div class="mb-3">
                    <label for="quantity" class="form-label fw-semibold">Jumlah yang ingin dibeli</label>
                    <input type="number" 
                           name="quantity" 
                           id="quantity" 
                           class="form-control rounded-3" 
                           min="1" 
                           max="{{ $produk->stok }}" 
                           required>
                </div>

                <button type="submit" class="btn btn-success w-100 mb-2">
                    <i class="bi bi-cart-plus me-1"></i> Beli Sekarang
                </button>
                <a href="{{ route('produk.index') }}" class="btn btn-outline-secondary w-100">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </form>
        </div>
    </div>
</div>

{{-- Style tambahan --}}
<style>
    .produk-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .produk-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }
</style>
@endsection
