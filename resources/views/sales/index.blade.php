@extends('layouts.app')
@section('title', 'Riwayat Penjualan')
@section('page_title', 'Riwayat Transaksi Penjualan (Sales)')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold m-0">Daftar Nota Penjualan</h5>
            <a href="{{ route('sales.create') }}" class="btn btn-success fw-bold">
                <i class="bi bi-cart-plus me-1"></i> Transaksi Kasir Baru
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No. Penjualan</th>
                        <th>Kasir</th>
                        <th>Total Belanja</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sales as $sale)
                    <tr>
                        <td><code class="fw-bold text-primary">{{ $sale->sale_number }}</code></td>
                        <td>{{ $sale->user->name }}</td>
                        <td class="fw-bold">Rp {{ number_format($sale->total, 0, ',', '.') }}</td>
                        <td>
                            @if($sale->status === 'completed')
                                <span class="badge bg-success">COMPLETED</span>
                            @else
                                <span class="badge bg-danger">CANCELLED</span>
                            @endif
                        </td>
                        <td>{{ $sale->sold_at->format('d/m/Y H:i') }}</td>
                        <td class="text-center">
                            <a href="{{ route('sales.show', $sale->id) }}" class="btn btn-info btn-sm text-white me-1">
                                <i class="bi bi-eye"></i> Struk / Detail
                            </a>

                            <!-- Tombol Merah Batal Transaksi -->
                            @if($sale->status === 'completed')
                            <form action="{{ route('sales.cancel', $sale->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan transaksi ini? Stok barang akan dikembalikan.');">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="bi bi-x-circle"></i> Cancel
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted p-4">Belum ada riwayat transaksi penjualan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $sales->links() }}
        </div>
    </div>
</div>
@endsection