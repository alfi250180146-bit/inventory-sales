@extends('layouts.app')
@section('title', 'Kasir Penjualan')
@section('page_title', 'Kasir Penjualan')

@section('content')
<div class="row g-3">
    <!-- SEBELAH KIRI: Katalog Produk Format LIST / TABEL -->
    <div class="col-md-7">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white fw-bold d-flex justify-content-between align-items-center py-3">
                <span><i class="bi bi-list-ul me-2 text-primary"></i> Daftar Produk</span>
                <input type="text" id="searchProduct" class="form-control form-control-sm w-50" placeholder="Cari produk..." onkeyup="filterProducts()">
            </div>
            <div class="card-body p-0 overflow-auto" style="max-height: 520px;">
                <table class="table table-hover align-middle mb-0" id="productTable">
                    <thead class="table-light sticky-top">
                        <tr>
                            <th>Kode / Produk</th>
                            <th>Harga</th>
                            <th class="text-center">Stok</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $p)
                        <tr class="product-row-item" data-name="{{ strtolower($p->name) }}" data-sku="{{ strtolower($p->sku) }}">
                            <td>
                                <code class="d-block text-muted small">{{ $p->sku }}</code>
                                <strong class="text-dark">{{ $p->name }}</strong>
                            </td>
                            <td class="fw-bold text-primary">Rp {{ number_format($p->selling_price, 0, ',', '.') }}</td>
                            <td class="text-center">
                                <span class="badge {{ $p->stock <= 5 ? 'bg-danger' : 'bg-secondary' }}">{{ $p->stock }}</span>
                            </td>
                            <td class="text-center">
                                @if($p->stock > 0)
                                    <button type="button" class="btn btn-primary btn-sm px-3" 
                                            onclick="addToCart({{ $p->id }}, '{{ addslashes($p->name) }}', {{ $p->selling_price }}, {{ $p->stock }})">
                                        <i class="bi bi-plus-lg me-1"></i> Pilih
                                    </button>
                                @else
                                    <button type="button" class="btn btn-secondary btn-sm" disabled>Habis</button>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- SEBELAH KANAN: Keranjang & Tombol Cancel Per Item -->
    <div class="col-md-5">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white fw-bold d-flex justify-content-between align-items-center py-3">
                <span><i class="bi bi-cart3 me-2 text-success"></i> Keranjang Belanja</span>
                <button type="button" class="btn btn-outline-danger btn-sm" onclick="clearCart()">
                    <i class="bi bi-trash"></i> Hapus Semua
                </button>
            </div>
            
            <form action="{{ route('sales.store') }}" method="POST" id="posForm" class="d-flex flex-column justify-content-between h-100">
                @csrf
                <div class="card-body p-2 overflow-auto" style="max-height: 380px;">
                    <table class="table table-sm align-middle mb-0" id="cartTable">
                        <thead class="table-light">
                            <tr>
                                <th>Produk</th>
                                <th style="width: 25%;">Qty</th>
                                <th class="text-end">Subtotal</th>
                                <th class="text-center" style="width: 10%;">Cancel</th>
                            </tr>
                        </thead>
                        <tbody id="cartItems">
                            <tr id="emptyCartRow">
                                <td colspan="4" class="text-center text-muted py-4">
                                    <i class="bi bi-basket display-6 d-block mb-2 text-secondary"></i>
                                    Pilih produk di sebelah kiri untuk menambah ke keranjang
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="card-footer bg-white border-top p-3">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="h5 m-0 text-muted">Total Bayar:</span>
                        <span class="h3 fw-bold text-success m-0" id="grandTotalDisplay">Rp 0</span>
                    </div>

                    <button type="submit" class="btn btn-success btn-lg w-100 fw-bold" id="btnPay" disabled>
                        <i class="bi bi-cash-stack me-2"></i> BAYAR & CETAK STRUK
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let cart = [];

    // Tambah Produk ke Keranjang
    function addToCart(id, name, price, stock) {
        const existingItem = cart.find(item => item.id === id);
        if (existingItem) {
            if (existingItem.qty + 1 > stock) {
                alert('Jumlah melebih stok ketersediaan!');
                return;
            }
            existingItem.qty += 1;
        } else {
            cart.push({ id, name, price, stock, qty: 1 });
        }
        renderCart();
    }

    // Render Keranjang Belanja
    function renderCart() {
        const cartItems = document.getElementById('cartItems');
        cartItems.innerHTML = '';

        if (cart.length === 0) {
            cartItems.innerHTML = `
                <tr id="emptyCartRow">
                    <td colspan="4" class="text-center text-muted py-4">
                        <i class="bi bi-basket display-6 d-block mb-2 text-secondary"></i>
                        Pilih produk di sebelah kiri untuk menambah ke keranjang
                    </td>
                </tr>`;
            document.getElementById('grandTotalDisplay').textContent = 'Rp 0';
            document.getElementById('btnPay').disabled = true;
            return;
        }

        let grandTotal = 0;

        cart.forEach((item, index) => {
            const subtotal = item.price * item.qty;
            grandTotal += subtotal;

            const row = document.createElement('tr');
            row.innerHTML = `
                <td>
                    <strong class="d-block text-dark lh-sm">${item.name}</strong>
                    <small class="text-muted">Rp ${item.price.toLocaleString('id-ID')}</small>
                    <input type="hidden" name="items[${index}][product_id]" value="${item.id}">
                </td>
                <td>
                    <input type="number" min="1" max="${item.stock}" name="items[${index}][quantity]" 
                           class="form-control form-control-sm text-center" value="${item.qty}" 
                           onchange="updateQty(${item.id}, this.value)">
                </td>
                <td class="text-end fw-bold">Rp ${subtotal.toLocaleString('id-ID')}</td>
                <td class="text-center">
                    <!-- Tombol Cancel / Hapus Produk Ini Saja -->
                    <button type="button" class="btn btn-outline-danger btn-sm p-1" onclick="cancelSingleProduct(${item.id})" title="Cancel Produk Ini">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </td>
            `;
            cartItems.appendChild(row);
        });

        document.getElementById('grandTotalDisplay').textContent = 'Rp ' + grandTotal.toLocaleString('id-ID');
        document.getElementById('btnPay').disabled = false;
    }

    // Ubah Qty Produk
    function updateQty(id, newQty) {
        const item = cart.find(i => i.id === id);
        if (item) {
            const qty = parseInt(newQty) || 1;
            if (qty > item.stock) {
                alert('Stok barang tidak mencukupi!');
                item.qty = item.stock;
            } else {
                item.qty = qty;
            }
            renderCart();
        }
    }

    // Cancel / Hapus Satu Produk Spesifik dari Keranjang
    function cancelSingleProduct(id) {
        cart = cart.filter(item => item.id !== id);
        renderCart();
    }

    // Hapus Semua Item di Keranjang
    function clearCart() {
        if (cart.length > 0 && confirm('Kosongkan semua item di keranjang?')) {
            cart = [];
            renderCart();
        }
    }

    // Pencarian Filter Produk
    function filterProducts() {
        const query = document.getElementById('searchProduct').value.toLowerCase();
        document.querySelectorAll('.product-row-item').forEach(row => {
            const name = row.getAttribute('data-name');
            const sku = row.getAttribute('data-sku');
            row.style.display = (name.includes(query) || sku.includes(query)) ? '' : 'none';
        });
    }
</script>
@endsection