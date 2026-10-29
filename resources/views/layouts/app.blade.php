<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'POS Inventory')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background-color: #f8fafc;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            color: #334155;
        }
        .sidebar {
            width: 240px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #1e293b;
            color: #94a3b8;
            padding: 1.25rem 1rem;
            z-index: 1000;
        }
        .main-content {
            margin-left: 240px;
            padding: 1.75rem 2rem;
        }
        .sidebar-brand {
            font-size: 0.95rem;
            font-weight: 700;
            color: #f8fafc;
            padding: 0.25rem 0.5rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .sidebar-heading {
            font-size: 0.68rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #64748b;
            padding: 1rem 0.5rem 0.35rem;
        }
        .nav-link-custom {
            display: flex;
            align-items: center;
            gap: 0.65rem;
            padding: 0.5rem 0.65rem;
            color: #94a3b8;
            text-decoration: none;
            border-radius: 0.375rem;
            font-size: 0.85rem;
            font-weight: 500;
            margin-bottom: 0.2rem;
            transition: all 0.15s ease-in-out;
        }
        .nav-link-custom:hover {
            color: #ffffff;
            background-color: rgba(255, 255, 255, 0.05);
        }
        .nav-link-custom.active {
            color: #ffffff;
            background-color: #3b82f6;
        }
    </style>
</head>
<body>

    <div class="sidebar d-flex flex-column justify-content-between">
        <div>
            <div class="sidebar-brand border-bottom border-secondary pb-3">
                <i class="bi bi-box-seam text-primary fs-5"></i>
                <span>POS Inventory</span>
            </div>

            <nav class="nav flex-column">
                <a href="{{ route('dashboard') }}" class="nav-link-custom {{ Request::is('dashboard*') ? 'active' : '' }}">
                    <i class="bi bi-grid"></i> Dashboard
                </a>
                
                {{-- KONTROL AKSES UNTUK ROLE ADMIN --}}
                @if(Auth::user() && Auth::user()->role === 'admin')
                    <div class="sidebar-heading">Master Data</div>
                    
                    <a href="{{ route('products.index') }}" class="nav-link-custom {{ Request::is('products*') ? 'active' : '' }}">
                        <i class="bi bi-box"></i> Produk
                    </a>
                    <a href="{{ route('categories.index') }}" class="nav-link-custom {{ Request::is('categories*') ? 'active' : '' }}">
                        <i class="bi bi-tag"></i> Kategori
                    </a>
                    <a href="{{ route('suppliers.index') }}" class="nav-link-custom {{ Request::is('suppliers*') ? 'active' : '' }}">
                        <i class="bi bi-truck"></i> Pemasok
                    </a>

                    <div class="sidebar-heading">Transaksi Pembelian</div>

                    <a href="{{ route('purchases.index') }}" class="nav-link-custom {{ Request::is('purchases*') ? 'active' : '' }}">
                        <i class="bi bi-arrow-down-left-square"></i> Pembelian (Stock In)
                    </a>
                @endif

                {{-- BISA DIAKSES OLEH KASIR MAUPUN ADMIN --}}
                <div class="sidebar-heading">Kasir</div>
                <a href="{{ route('sales.index') }}" class="nav-link-custom {{ Request::is('sales*') ? 'active' : '' }}">
                    <i class="bi bi-cart"></i> Penjualan (Stock Out)
                </a>
            </nav>
        </div>

        <!-- USER PROFILE & LOGOUT -->
        <div class="border-top border-secondary pt-3">
            <div class="d-flex align-items-center justify-content-between px-1 mb-2">
                <div>
                    <div class="fw-bold text-white small">{{ Auth::user()->name ?? 'Pengguna' }}</div>
                    <small class="text-light opacity-75" style="font-size: 0.72rem;">{{ ucfirst(Auth::user()->role ?? 'Kasir') }}</small>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST" class="m-0">
                @csrf
                <button type="submit" class="btn btn-danger btn-sm w-100 fw-bold d-flex align-items-center justify-content-center gap-2">
                    <i class="bi bi-box-arrow-right"></i> Logout / Keluar
                </button>
            </form>
        </div>
    </div>

    <div class="main-content">
        <div class="mb-4">
            <h5 class="fw-bold text-dark m-0">@yield('page_title', 'Dashboard')</h5>
        </div>

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>