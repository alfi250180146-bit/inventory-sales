@extends('layouts.app')
@section('title', 'Dashboard')
@section('page_title', 'Ringkasan Aktivitas')

@section('content')
<!-- KARTU STATISTIK UTAMA -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm p-3 bg-white rounded-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted small fw-medium">Total Produk</span>
                    <h4 class="fw-bold text-dark mb-0 mt-1">{{ $totalProducts ?? 0 }}</h4>
                </div>
                <div class="bg-light text-primary p-2 rounded">
                    <i class="bi bi-box fs-5"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm p-3 bg-white rounded-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted small fw-medium">Penjualan Hari Ini</span>
                    <h4 class="fw-bold text-dark mb-0 mt-1">Rp {{ number_format($todaySales ?? 0, 0, ',', '.') }}</h4>
                </div>
                <div class="bg-light text-success p-2 rounded">
                    <i class="bi bi-cash-stack fs-5"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm p-3 bg-white rounded-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted small fw-medium">Penjualan Bulan Ini</span>
                    <h4 class="fw-bold text-dark mb-0 mt-1">Rp {{ number_format($monthSales ?? 0, 0, ',', '.') }}</h4>
                </div>
                <div class="bg-light text-info p-2 rounded">
                    <i class="bi bi-graph-up fs-5"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm p-3 bg-white rounded-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted small fw-medium">Total Transaksi</span>
                    <h4 class="fw-bold text-dark mb-0 mt-1">{{ $totalTransactions ?? 0 }}</h4>
                </div>
                <div class="bg-light text-warning p-2 rounded">
                    <i class="bi bi-receipt fs-5"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- GRAFIK & ALERT STOK -->
<div class="row g-3 mb-4">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm bg-white rounded-3 p-3 h-100">
            <h6 class="fw-bold text-slate-700 mb-3">Tren Pendapatan 7 Hari Terakhir</h6>
            <canvas id="salesChart" height="140"></canvas>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm bg-white rounded-3 p-3 h-100">
            <h6 class="fw-bold text-slate-700 mb-3">Stok Menipis (<=10)</h6>
            <div class="table-responsive">
                <table class="table table-sm align-middle mb-0">
                    <tbody>
                        @forelse($lowStockProducts ?? [] as $product)
                        <tr>
                            <td class="fw-medium text-dark small">{{ $product->name }}</td>
                            <td class="text-end">
                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle">Sisa {{ $product->stock }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" class="text-center text-muted py-3 small">Semua stok aman.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- TABEL TRANSAKSI TERBARU (MENGISI KEBENTUKAN KOSONG DI BAWAH) -->
<div class="card border-0 shadow-sm bg-white rounded-3 p-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="fw-bold text-slate-700 m-0">Aktivitas Penjualan Terakhir</h6>
        <a href="{{ route('sales.index') }}" class="btn btn-link btn-sm text-decoration-none fw-medium">Lihat Semua</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0 small">
            <thead class="table-light">
                <tr>
                    <th>No. Faktur</th>
                    <th>Tanggal</th>
                    <th>Total</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $latestSales = \App\Models\Sale::latest()->take(5)->get();
                @endphp
                @forelse($latestSales as $sale)
                <tr>
                    <td class="fw-semibold text-primary">{{ $sale->invoice_number ?? 'INV-'.$sale->id }}</td>
                    <td>{{ $sale->created_at->format('d/m/Y H:i') }}</td>
                    <td class="fw-bold text-dark">Rp {{ number_format($sale->total ?? $sale->grand_total ?? 0, 0, ',', '.') }}</td>
                    <td><span class="badge bg-success-subtle text-success">Selesai</span></td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center text-muted py-3">Belum ada transaksi recorded.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    const ctx = document.getElementById('salesChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($chartLabels ?? []) !!},
            datasets: [{
                label: 'Pendapatan',
                data: {!! json_encode($chartValues ?? []) !!},
                borderColor: '#3b82f6',
                backgroundColor: 'rgba(59, 130, 246, 0.05)',
                fill: true,
                tension: 0.2,
                borderWidth: 2,
                pointRadius: 3
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { color: '#f1f5f9' } },
                x: { grid: { display: false } }
            }
        }
    });
</script>
@endsection