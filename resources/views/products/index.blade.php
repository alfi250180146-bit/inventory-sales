@extends('layouts.app')
@section('title', 'Produk')
@section('page_title', 'Daftar Produk')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <form class="d-flex gap-2" method="GET">
        <input type="text" name="search" class="form-control" placeholder="Cari SKU / Nama..." value="{{ request('search') }}">
        <button class="btn btn-secondary">Cari</button>
    </form>
    <a href="{{ route('products.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Tambah Produk</a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>SKU</th>
                    <th>Nama Produk</th>
                    <th>Kategori</th>
                    <th>Harga Beli</th>
                    <th>Harga Jual</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $p)
                <tr>
                    <td><code>{{ $p->sku }}</code></td>
                    <td>{{ $p->name }}</td>
                    <td>{{ $p->category->name }}</td>
                    <td>Rp {{ number_format($p->purchase_price, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($p->selling_price, 0, ',', '.') }}</td>
                    <td>
                        @if($p->stock <= $p->minimum_stock)
                            <span class="badge bg-danger">{{ $p->stock }}</span>
                        @else
                            <span class="badge bg-success">{{ $p->stock }}</span>
                        @endif
                    </td>
                    <td>
                        <form action="{{ route('products.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Hapus produk ini?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="p-2">
        {{ $products->links() }}
    </div>
</div>
@endsection