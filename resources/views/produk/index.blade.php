{{-- resources/views/produk/index.blade.php --}}
@extends('app')

@section('title', 'Produk')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-center">🛍️ Daftar Produk</h2>
    @auth
        @if(auth()->user()->role === 'admin')
            <div class="mb-4 text-center">
                <a href="{{ route('produk.create') }}" class="btn btn-primary">➕ Tambah Produk</a>
            </div>
        @endif
    @endauth

    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger text-center">{{ session('error') }}</div>
    @endif

    @if($produk->isEmpty())
        <div class="alert alert-info text-center">Tidak ada produk tersedia.</div>
    @else
        <div class="row row-cols-1 row-cols-md-3 g-4">
            @foreach ($produk as $p)
                <div class="col">
                    <div class="card h-100 shadow border-0">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold">{{ $p->nama }}</h5>
                            <p class="card-text text-muted small">{{ $p->deskripsi ?? 'Tidak ada deskripsi.' }}</p>

                            <div class="d-flex justify-content-between mb-3">
                                <span class="badge bg-primary">Rp{{ number_format($p->harga, 0, ',', '.') }}</span>
                                <span class="badge {{ $p->stok > 0 ? 'bg-success' : 'bg-secondary' }}">
                                    Stok: {{ $p->stok }}
                                </span>
                            </div>

                            <div class="mt-auto">
                                @auth
                                    @if(auth()->user()->role === 'admin')
                                        <div class="row">
                                            <div class="col-6 pe-1">
                                                <a href="{{ route('produk.edit', $p->id) }}" class="btn btn-warning w-100">Edit</a>
                                            </div>
                                            <div class="col-6 ps-1">
                                                <form method="POST" action="{{ route('produk.destroy', $p->id) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger w-100">Hapus</button>
                                                </form>
                                            </div>
                                        </div>
                                    @else
                                        <a href="{{ route('produk.buy', $p->id) }}"
                                           class="btn btn-success w-100 {{ $p->stok == 0 ? 'disabled' : '' }}">
                                           Beli
                                        </a>
                                    @endif
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
