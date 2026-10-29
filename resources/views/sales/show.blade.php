@extends('layouts.app')
@section('title', 'Struk Penjualan')
@section('page_title', 'Struk Transaksi Penjualan')

@section('content')
<style>
    .receipt-box {
        max-width: 380px;
        margin: 0 auto;
        background: #ffffff;
        padding: 20px;
        border-radius: 8px;
        font-family: 'Courier New', Courier, monospace;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }
    @media print {
        body * { visibility: hidden; }
        .receipt-box, .receipt-box * { visibility: visible; }
        .receipt-box { position: absolute; left: 0; top: 0; width: 100%; max-width: 80mm; box-shadow: none; }
        .no-print { display: none !important; }
    }
</style>

<div class="mb-3 text-center no-print">
    <a href="{{ route('sales.index') }}" class="btn btn-secondary btn-sm me-2">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
    <button onclick="window.print()" class="btn btn-primary btn-sm fw-bold">
        <i class="bi bi-printer"></i> Cetak Struk
    </button>
</div>

<div class="receipt-box">
    <div class="text-center mb-2">
        <h5 class="fw-bold m-0">POS INVENTORY</h5>
        <small class="d-block text-muted">Universitas Demo POS System</small>
        <small class="text-muted">==============================</small>
    </div>

    <div class="small mb-2">
        <div><strong>No:</strong> {{ $sale->invoice_number ?? $sale->invoice ?? $sale->sale_number ?? 'INV-'.$sale->id }}</div>
        <div><strong>Tgl:</strong> {{ $sale->created_at ? $sale->created_at->format('d/m/Y H:i') : '-' }}</div>
        <div><strong>Kasir:</strong> {{ $sale->user->name ?? 'Admin' }}</div>
    </div>
    
    <div class="text-center text-muted small">==============================</div>

    <table class="w-100 small my-2">
        @php $items = $sale->items ?? $sale->details ?? []; @endphp
        @forelse($items as $item)
            @php
                $price = $item->unit_price ?? $item->price ?? $item->selling_price ?? ($item->product->selling_price ?? 0);
                $qty = $item->quantity ?? $item->qty ?? 1;
                $subtotal = $item->subtotal ?? ($price * $qty);
            @endphp
            <tr>
                <td colspan="3" class="fw-bold">{{ $item->product->name ?? 'Produk' }}</td>
            </tr>
            <tr>
                <td>{{ $qty }} x {{ number_format($price, 0, ',', '.') }}</td>
                <td class="text-end fw-bold">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
            </tr>
        @empty
            <tr><td class="text-center">Item tidak ditemukan</td></tr>
        @endforelse
    </table>

    <div class="text-center text-muted small">==============================</div>

    <div class="d-flex justify-content-between fw-bold my-2">
        <span>TOTAL:</span>
        <span>Rp {{ number_format($sale->total ?? $sale->grand_total ?? 0, 0, ',', '.') }}</span>
    </div>

    <div class="text-center text-muted small">==============================</div>
    <div class="text-center small mt-3">
        <div>-- TERIMA KASIH --</div>
        <small>Selamat Belanja Kembali</small>
    </div>
</div>
@endsection