@extends('layouts.app')
@section('title', 'Penjualan')
@section('page_title', 'Daftar Transaksi Penjualan')

@section('content')
<div class="card border-0 shadow-sm bg-white rounded-3">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="fw-bold text-dark m-0">Riwayat Transaksi Kasir</h6>
            <a href="{{ route('sales.create') }}" class="btn btn-primary btn-sm fw-medium">
                <i class="bi bi-plus-lg me-1"></i> Transaksi Baru
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show small py-2" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close py-2" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light small">
                    <tr>
                        <th>No. Faktur</th>
                        <th>Tanggal</th>
                        <th>Kasir</th>
                        <th class="text-end">Total</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="small">
                    @forelse($sales as $sale)
                    <tr>
                        <td class="fw-semibold text-primary">{{ $sale->invoice_number ?? $sale->invoice ?? $sale->sale_number ?? 'INV-'.$sale->id }}</td>
                        <td>{{ $sale->created_at ? $sale->created_at->format('d/m/Y H:i') : '-' }}</td>
                        <td>{{ $sale->user->name ?? 'Kasir' }}</td>
                        <td class="text-end fw-bold text-dark">Rp {{ number_format($sale->total ?? $sale->grand_total ?? 0, 0, ',', '.') }}</td>
                        <td class="text-center">
                            <a href="{{ route('sales.show', $sale->id) }}" class="btn btn-light btn-sm border me-1">
                                <i class="bi bi-eye"></i> Detail & Struk
                            </a>
                            <form action="{{ route('sales.destroy', $sale->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus/Batalkan transaksi ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">Belum ada transaksi penjualan recorded.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection