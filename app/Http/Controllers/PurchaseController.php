<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PurchaseController extends Controller
{
    public function index()
    {
        $purchases = Purchase::with(['supplier', 'user'])->latest()->paginate(10);
        return view('purchases.index', compact('purchases'));
    }

    public function create()
    {
        $suppliers = Supplier::all();
        $products = Product::all();
        return view('purchases.create', compact('suppliers', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_cost' => 'required|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            $total = 0;
            $itemsData = [];

            foreach ($request->items as $item) {
                $subtotal = $item['quantity'] * $item['unit_cost'];
                $total += $subtotal;

                $itemsData[] = [
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_cost' => $item['unit_cost'],
                    'subtotal' => $subtotal,
                ];
            }

            $purchase = Purchase::create([
                'supplier_id' => $request->supplier_id,
                'user_id' => Auth::id(),
                'purchase_number' => 'PO-' . time() . '-' . rand(100, 999),
                'total' => $total,
                'status' => 'completed',
                'purchased_at' => Carbon::now(),
            ]);

            foreach ($itemsData as $data) {
                $purchase->items()->create($data);

                $product = Product::lockForUpdate()->find($data['product_id']);
                $product->increment('stock', $data['quantity']);
            }

            DB::commit();
            return redirect()->route('purchases.index')->with('success', 'Transaksi Pembelian (Stok Masuk) Berhasil Disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memproses transaksi: ' . $e->getMessage())->withInput();
        }
    }

    public function show(Purchase $purchase)
    {
        $purchase->load(['supplier', 'user', 'items.product']);
        return view('purchases.show', compact('purchase'));
    }

    public function cancel(Purchase $purchase)
    {
        if ($purchase->status === 'cancelled') {
            return redirect()->back()->with('error', 'Transaksi ini telah dibatalkan sebelumnya.');
        }

        try {
            DB::beginTransaction();

            $purchaseLocked = Purchase::lockForUpdate()->find($purchase->id);

            foreach ($purchaseLocked->items as $item) {
                $product = Product::lockForUpdate()->find($item->product_id);
                if ($product->stock < $item->quantity) {
                    throw new \Exception("Stok produk {$product->name} tidak mencukupi untuk melakukan pembatalan pembelian.");
                }
                $product->decrement('stock', $item->quantity);
            }

            $purchaseLocked->update(['status' => 'cancelled']);

            DB::commit();
            return redirect()->back()->with('success', 'Pembelian berhasil dibatalkan dan stok dikurangi secara otomatis.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal membatalkan transaksi: ' . $e->getMessage());
        }
    }
}