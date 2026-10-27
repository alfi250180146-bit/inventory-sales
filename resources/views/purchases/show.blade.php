@extends('layouts.app')
@section('title', 'Detail Pembelian')
@section('page_title', 'Rincian Pembelian Stok (Stock In)')

@section('content')
<div class="card border-0 shadow-sm rounded-3 mb-4">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold m-0">No. Nota: <span class="text-primary">{{ $purchase->purchase_number ?? 'PO-'.$purchase->id }}</span></h5>
            <a href="{{ route('purchases.index') }}" class="btn btn-secondary btn-sm fw-bold">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Riwayat
            </a>
        </div>
        <hr>
        <div class="row mb-3">
            <div class="col-md-4">
                <small class="text-muted d-block">Pemasok / Supplier</small>
                <strong class="fs-6">{{ $purchase->supplier->name ?? '-' }}</strong>
            </div>
            <div class="col-md-4">
                <small class="text-muted d-block">Tanggal Transaksi</small>
                <strong>{{ $purchase->created_at->format('d F Y - H:i') }} WIB</strong>
            </div>
            <div class="col-md-4">
                <small class="text-muted d-block">Total Pembelian</small>
                <strong class="text-success fs-5">Rp {{ number_format($purchase->total ?? $purchase->grand_total ?? 0, 0, ',', '.') }}</strong>
            </div>
        </div>
    </div>
</div>

<!-- TABEL RINCIAN ITEM BARANG -->
<div class="card border-0 shadow-sm rounded-3">
    <div class="card-body">
        <h6 class="fw-bold mb-3"><i class="bi bi-box-seam me-2"></i>Daftar Item Barang Dipesan</h6>
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Nama Produk / Barang</th>
                        <th class="text-center">Jumlah (Qty)</th>
                        <th class="text-end">Harga Beli Satuan</th>
                        <th class="text-end">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($purchase->details) && count($purchase->details) > 0)
                        @foreach($purchase->details as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td class="fw-bold">{{ $item->product->name ?? 'Produk' }}</td>
                            <td class="text-center"><span class="badge bg-secondary fs-6">{{ $item->quantity }}</span></td>
                            <td class="text-end">Rp {{ number_format($item->purchase_price, 0, ',', '.') }}</td>
                            <td class="text-end fw-bold">Rp {{ number_format($item->quantity * $item->purchase_price, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    @elseif(isset($purchase->product))
                        <tr>
                            <td>1</td>
                            <td class="fw-bold">{{ $purchase->product->name ?? 'Produk' }}</td>
                            <td class="text-center"><span class="badge bg-secondary fs-6">{{ $purchase->quantity }}</span></td>
                            <td class="text-end">Rp {{ number_format($purchase->purchase_price, 0, ',', '.') }}</td>
                            <td class="text-end fw-bold">Rp {{ number_format($purchase->quantity * $purchase->purchase_price, 0, ',', '.') }}</td>
                        </tr>
                    @else
                        <tr>
                            <td colspan="5" class="text-center text-muted p-3">Rincian item tidak ditemukan.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection