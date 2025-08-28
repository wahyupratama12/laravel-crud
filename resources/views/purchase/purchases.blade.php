@extends('app')

@section('title', 'Warung Asep - Daftar Pembelian')

@section('content')
<div class="container mt-5">
    <h2 class="fw-bold text-primary mb-4">
        <i class="bi bi-bag-check-fill me-2"></i> Daftar Pembelian
    </h2>

    {{-- Pesan sukses --}}
    @if (session('success'))
        <div class="alert alert-success shadow-sm">
            <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
        </div>
    @endif

    {{-- Jika tidak ada pembelian --}}
    @if ($purchases->isEmpty())
        <div class="alert alert-info shadow-sm">
            <i class="bi bi-info-circle me-1"></i> Anda belum membeli produk apapun.
        </div>
    @else
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-primary">
                            <tr>
                                <th>No</th>
                                <th>Nama Produk</th>
                                <th>Harga Satuan</th>
                                <th>Jumlah</th>
                                <th>Total</th>
                                <th>Tanggal Pembelian</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($purchases as $index => $purchase)
                                <tr>
                                    <td class="fw-semibold">{{ $index + 1 }}</td>
                                    <td>{{ $purchase->produk->nama }}</td>
                                    <td>Rp{{ number_format($purchase->produk->harga, 0, ',', '.') }}</td>
                                    <td>{{ $purchase->quantity }}</td>
                                    <td class="fw-bold text-success">
                                        Rp{{ number_format($purchase->produk->harga * $purchase->quantity, 0, ',', '.') }}
                                    </td>
                                    <td>{{ $purchase->created_at->format('d M Y - H:i:s ') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</div>

{{-- Style tambahan --}}
<style>
    .table-hover tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.05);
        transition: background-color 0.2s ease;
    }
</style>
@endsection
