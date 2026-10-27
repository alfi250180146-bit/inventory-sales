@extends('layouts.app')
@section('title', 'Struk Penjualan')
@section('page_title', 'Struk Transaksi Penjualan')

@section('content')
<div class="d-flex justify-content-center mb-4">
    <!-- Kartu Struk Penjualan -->
    <div class="card border shadow-sm p-4" style="width: 380px; font-family: 'Courier New', Courier, monospace; background-color: #fff;">
        <!-- Header Struk -->
        <div class="text-center border-bottom pb-3 mb-3">
            <h4 class="fw-bold m-0" style="font-family: sans-serif;">TOKO SEMBAKO JAYA</h4>
            <small class="text-muted d-block">Jl. Raya Utama No. 123, Jakarta</small>
            <small class="text-muted d-block">Telp: 0812-3456-7890</small>
        </div>

        <!-- Info Transaksi & Kasir Ala Indomaret -->
        <div class="small mb-3 pb-2 border-bottom">
            <div class="d-flex justify-content-between">
                <span>No. Nota:</span>
                <strong>{{ $sale->sale_number }}</strong>
            </div>
            <div class="d-flex justify-content-between">
                <span>Tgl / Jam:</span>
                <span>{{ $sale->sold_at->format('d/m/Y H:i:s') }}</span>
            </div>
            <div class="d-flex justify-content-between">
                <span>Kasir / Staff:</span>
                <strong>{{ $sale->user->name }}</strong>
            </div>
        </div>

        <!-- Rincian Barang Belanjaan -->
        <div class="table-responsive mb-3">
            <table class="table table-borderless table-sm small mb-0">
                <thead>
                    <tr class="border-bottom">
                        <th>Item</th>
                        <th class="text-center">Qty</th>
                        <th class="text-end">Harga</th>
                        <th class="text-end">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sale->items as $item)
                    <tr>
                        <td colspan="4" class="fw-bold pb-0">{{ $item->product->name }}</td>
                    </tr>
                    <tr class="border-bottom">
                        <td></td>
                        <td class="text-center">{{ $item->quantity }}</td>
                        <td class="text-end">{{ number_format($item->unit_price, 0, ',', '.') }}</td>
                        <td class="text-end">{{ number_format($item->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Total Pembayaran -->
        <div class="border-top pt-2 mb-3">
            <div class="d-flex justify-content-between h5 fw-bold m-0">
                <span>TOTAL:</span>
                <span>Rp {{ number_format($sale->total, 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- Footer Struk Ala Indomaret -->
        <div class="text-center pt-2 border-top small text-muted">
            <p class="m-0">=== TERIMA KASIH ===</p>
            <p class="m-0">Barang yang sudah dibeli</p>
            <p class="m-0">tidak dapat ditukar/dikembalikan</p>
            <small class="mt-2 d-block text-secondary">Layanan Konsumen: 1500-123</small>
        </div>
    </div>
</div>

<!-- Tombol Aksi (Kembali & Cetak) -->
<div class="text-center no-print">
    <a href="{{ route('sales.index') }}" class="btn btn-secondary me-2">
        <i class="bi bi-arrow-left"></i> Kembali ke Riwayat
    </a>
    <button onclick="window.print()" class="btn btn-primary fw-bold">
        <i class="bi bi-printer"></i> Cetak Struk
    </button>
</div>

<!-- CSS Khusus Saat Ditekan Tombol Cetak/Print -->
<style>
    @media print {
        body * { visibility: hidden; }
        .card, .card * { visibility: visible; }
        .card { position: absolute; left: 0; top: 0; width: 100% !important; border: none !important; shadow: none !important; }
        .no-print { display: none !important; }
    }
</style>
@endsection