@extends('layouts.app')
@section('title', 'Pembelian Stok')
@section('page_title', 'Riwayat Pembelian Barang (Stock In)')

@section('content')
<div class="card border-0 shadow-sm rounded-3">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold m-0">Riwayat Pembelian dari Pemasok</h5>
            <a href="{{ route('purchases.create') }}" class="btn btn-primary fw-bold">
                <i class="bi bi-plus-circle me-1"></i> Tambah Stock In
            </a>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No. Pembelian</th>
                        <th>Pemasok</th>
                        <th>Total Pembelian</th>
                        <th>Tanggal Masuk</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($purchases as $p)
                    <tr>
                        <td><code class="fw-bold text-primary">{{ $p->purchase_number ?? 'PO-'.$p->id }}</code></td>
                        <td class="fw-bold">{{ $p->supplier->name ?? '-' }}</td>
                        <td class="fw-bold text-success">Rp {{ number_format($p->total ?? $p->grand_total ?? 0, 0, ',', '.') }}</td>
                        <td>{{ $p->created_at->format('d/m/Y H:i') }}</td>
                        <td class="text-center">
                            <a href="{{ route('purchases.show', $p->id) }}" class="btn btn-info btn-sm text-white fw-bold">
                                <i class="bi bi-eye"></i> Lihat Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted p-4">Belum ada riwayat pembelian barang.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection