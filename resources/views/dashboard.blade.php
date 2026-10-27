@extends('layouts.app')
@section('title', 'Dashboard')
@section('page_title', 'Ringkasan Sistem')

@section('content')
<!-- KARTU STATISTIK -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white border-0 shadow-sm rounded-3">
            <div class="card-body">
                <h6 class="text-white-50">Total Produk</h6>
                <h3 class="fw-bold mb-0">{{ $totalProducts ?? 0 }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white border-0 shadow-sm rounded-3">
            <div class="card-body">
                <h6 class="text-white-50">Penjualan Hari Ini</h6>
                <h3 class="fw-bold mb-0">Rp {{ number_format($todaySales ?? 0, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white border-0 shadow-sm rounded-3">
            <div class="card-body">
                <h6 class="text-white-50">Penjualan Bulan Ini</h6>
                <h3 class="fw-bold mb-0">Rp {{ number_format($monthSales ?? 0, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-dark border-0 shadow-sm rounded-3">
            <div class="card-body">
                <h6 class="text-dark-50">Total Transaksi Penjualan</h6>
                <h3 class="fw-bold mb-0">{{ $totalTransactions ?? 0 }}</h3>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <!-- GRAFIK PENDAPATAN 7 HARI -->
    <div class="col-md-8">
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-body">
                <h5 class="fw-bold mb-3"><i class="bi bi-graph-up me-2 text-primary"></i>Grafik Pendapatan Penjualan 7 Hari Terakhir</h5>
                <canvas id="salesChart" height="120"></canvas>
            </div>
        </div>
    </div>

    <!-- ALERT PERINGATAN STOK MENIPIS -->
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-header bg-white border-0 fw-bold text-danger pt-3">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>Peringatan Stok Menipis (<=10)
            </div>
            <div class="card-body p-0 overflow-auto" style="max-height: 250px;">
                <ul class="list-group list-group-flush">
                    @forelse($lowStockProducts ?? [] as $product)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <strong class="d-block text-dark">{{ $product->name }}</strong>
                            <small class="text-muted">Kode: {{ $product->code }}</small>
                        </div>
                        <span class="badge bg-danger rounded-pill">Sisa: {{ $product->stock }}</span>
                    </li>
                    @empty
                    <li class="list-group-item text-center text-muted py-3">Semua stok aman</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
    const ctx = document.getElementById('salesChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($chartLabels ?? []) !!},
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: {!! json_encode($chartValues ?? []) !!},
                borderColor: '#0d6efd',
                backgroundColor: 'rgba(13, 110, 253, 0.1)',
                fill: true,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            scales: { y: { beginAtZero: true } }
        }
    });
</script>
@endsection