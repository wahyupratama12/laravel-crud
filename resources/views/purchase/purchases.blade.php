<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'My App')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
@extends('app')

@section('title', 'My Purchases')

@section('content')
    <div class="container">
        <h2 class="mb-4">My Purchases</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($purchases->isEmpty())
            <div class="alert alert-info">You haven't bought anything yet.</div>
        @else
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Product Name</th>
                            <th>Price (each)</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Purchased At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($purchases as $index => $purchase)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $purchase->produk->nama }}</td>
                                <td>Rp{{ number_format($purchase->produk->harga, 0, ',', '.') }}</td>
                                <td>{{ $purchase->quantity }}</td>
                                <td>Rp{{ number_format($purchase->produk->harga * $purchase->quantity, 0, ',', '.') }}</td>
                                <td>{{ $purchase->created_at->format('d M Y - H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection

</body>
</html>
