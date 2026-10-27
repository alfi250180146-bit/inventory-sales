<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        
        // Penjualan Hari Ini
        $todaySales = Sale::whereDate('created_at', Carbon::today())
            ->where('status', 'COMPLETED')
            ->sum('total');

        // Penjualan Bulan Ini
        $monthSales = Sale::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->where('status', 'COMPLETED')
            ->sum('total');

        // Total Transaksi Penjualan
        $totalTransactions = Sale::where('status', 'COMPLETED')->count();

        // Produk Stok Menipis (Barang yang stoknya <= 10)
        $lowStockProducts = Product::where('stock', '<=', 10)->get();

        // Data Grafik Penjualan 7 Hari Terakhir
        $chartLabels = [];
        $chartValues = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $chartLabels[] = $date->format('d M');
            
            $dailyTotal = Sale::whereDate('created_at', $date->toDateString())
                ->where('status', 'COMPLETED')
                ->sum('total');
                
            $chartValues[] = (int) $dailyTotal;
        }

        return view('dashboard', compact(
            'totalProducts',
            'todaySales',
            'monthSales',
            'totalTransactions',
            'lowStockProducts',
            'chartLabels',
            'chartValues'
        ));
    }
}