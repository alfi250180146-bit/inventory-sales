@extends('layouts.app')
@section('title', 'Tambah Pembelian Stok')
@section('page_title', 'Tambah Stok Masuk (Stock In)')

@section('content')
<div class="card border-0 shadow-sm rounded-3">
    <div class="card-body">
        <form action="{{ route('purchases.store') }}" method="POST">
            @csrf
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Pilih Pemasok / Supplier</label>
                    <select name="supplier_id" class="form-select" required>
                        <option value="">-- Pilih Supplier --</option>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Pilih Produk</label>
                    <select name="product_id" class="form-select" required>
                        <option value="">-- Pilih Produk --</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }} (Stok Sekarang: {{ $product->stock }})</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Jumlah Stok Masuk (Qty)</label>
                    <input type="number" name="quantity" class="form-control" min="1" required placeholder="0">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Harga Beli Beli Per Item (Rp)</label>
                    <input type="number" name="purchase_price" class="form-control" min="0" required placeholder="0">
                </div>
            </div>

            <div class="d-flex justify-content-between pt-3 border-top">
                <a href="{{ route('purchases.index') }}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-success fw-bold"><i class="bi bi-save me-1"></i> Simpan Stok Masuk</button>
            </div>
        </form>
    </div>
</div>
@endsection