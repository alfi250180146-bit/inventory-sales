@extends('layouts.app')
@section('title', 'Tambah Produk')
@section('page_title', 'Form Tambah Produk')

@section('content')
<div class="card border-0 shadow-sm col-md-8 mx-auto">
    <div class="card-body">
        <form action="{{ route('products.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">SKU Produk</label>
                    <input type="text" name="sku" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Kategori</label>
                    <select name="category_id" class="form-select" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $c)
                            <option value="{{ $c->id }}">{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Nama Produk</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Harga Beli (Rp)</label>
                    <input type="number" min="0" name="purchase_price" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Harga Jual (Rp)</label>
                    <input type="number" min="0" name="selling_price" class="form-control" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Stok Awal</label>
                    <input type="number" min="0" name="stock" class="form-control" value="0" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Batas Stok Minimum</label>
                    <input type="number" min="0" name="minimum_stock" class="form-control" value="5" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Simpan Produk</button>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection