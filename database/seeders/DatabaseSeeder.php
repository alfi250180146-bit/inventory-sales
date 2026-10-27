<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Product;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Pengguna Demo
        User::updateOrCreate(
            ['email' => 'admin@inventory.com'],
            ['name' => 'Admin Utama', 'password' => Hash::make('admin123'), 'role' => 'admin']
        );

        User::updateOrCreate(
            ['email' => 'staff@inventory.com'],
            ['name' => 'Staff Kasir', 'password' => Hash::make('staff123'), 'role' => 'staff']
        );

        // 2. Kategori Khusus Sembako & Kebutuhan Pokok
        $catBeras  = Category::updateOrCreate(['name' => 'Beras & Tepung'], ['description' => 'Berbagai jenis beras, tepung terigu, dan tepung tapioka']);
        $catMinyak = Category::updateOrCreate(['name' => 'Minyak & Mentega'], ['description' => 'Minyak goreng kemasan dan mentega']);
        $catBumbu  = Category::updateOrCreate(['name' => 'Bumbu & Makanan Instan'], ['description' => 'Mi instan, bumbu dapur, kecap, dan saus']);
        $catGula   = Category::updateOrCreate(['name' => 'Gula & Susu'], ['description' => 'Gula pasir, gula merah, krimer, dan susu kental manis']);
        $catMinuman= Category::updateOrCreate(['name' => 'Minuman Kemasan'], ['description' => 'Kopi, teh, dan air mineral']);

        // 3. Pemasok / Distributor Sembako
        $supIndo  = Supplier::updateOrCreate(
            ['phone' => '081299887766'],
            ['name' => 'PT Indofood Sukses Makmur', 'email' => 'sales@indofood.co.id', 'address' => 'Jl. Sudirman No. 45, Jakarta']
        );
        $supBagus = Supplier::updateOrCreate(
            ['phone' => '081311223344'],
            ['name' => 'CV Sumber Sembako Murah', 'email' => 'info@sumbersembako.com', 'address' => 'Pasar Induk Kramat Jati Block C']
        );

        // 4. Daftar Produk Sembako Realistis
        $products = [
            // Beras & Tepung
            [
                'category_id'    => $catBeras->id,
                'sku'            => 'SBK-TRS-001',
                'name'           => 'Beras Setra Ramos 5kg',
                'purchase_price' => 68000,
                'selling_price'  => 75000,
                'stock'          => 30,
                'minimum_stock'  => 5
            ],
            [
                'category_id'    => $catBeras->id,
                'sku'            => 'SBK-TPG-002',
                'name'           => 'Tepung Terigu Segitiga Biru 1kg',
                'purchase_price' => 11000,
                'selling_price'  => 13000,
                'stock'          => 45,
                'minimum_stock'  => 10
            ],

            // Minyak & Mentega
            [
                'category_id'    => $catMinyak->id,
                'sku'            => 'SBK-MYK-001',
                'name'           => 'Minyak Goreng Bimoli 2 Litre',
                'purchase_price' => 34000,
                'selling_price'  => 38000,
                'stock'          => 20,
                'minimum_stock'  => 5
            ],
            [
                'category_id'    => $catMinyak->id,
                'sku'            => 'SBK-MYK-002',
                'name'           => 'Minyak Goreng Sania 1 Litre',
                'purchase_price' => 16500,
                'selling_price'  => 19000,
                'stock'          => 3, // Pemicu Warning Stok Rendah
                'minimum_stock'  => 10
            ],
            [
                'category_id'    => $catMinyak->id,
                'sku'            => 'SBK-MTG-003',
                'name'           => 'Margarin Blue Band 200g',
                'purchase_price' => 8500,
                'selling_price'  => 10500,
                'stock'          => 25,
                'minimum_stock'  => 5
            ],

            // Bumbu & Makanan Instan
            [
                'category_id'    => $catBumbu->id,
                'sku'            => 'SBK-MII-001',
                'name'           => 'Indomie Goreng Spesial (1 Dus / 40 pcs)',
                'purchase_price' => 108000,
                'selling_price'  => 120000,
                'stock'          => 15,
                'minimum_stock'  => 3
            ],
            [
                'category_id'    => $catBumbu->id,
                'sku'            => 'SBK-KCP-002',
                'name'           => 'Kecap Manis Bango Botol 135ml',
                'purchase_price' => 9000,
                'selling_price'  => 11500,
                'stock'          => 2, // Pemicu Warning Stok Rendah
                'minimum_stock'  => 8
            ],

            // Gula & Susu
            [
                'category_id'    => $catGula->id,
                'sku'            => 'SBK-GLA-001',
                'name'           => 'Gula Pasir Gulaku 1kg',
                'purchase_price' => 15500,
                'selling_price'  => 17500,
                'stock'          => 50,
                'minimum_stock'  => 10
            ],
            [
                'category_id'    => $catGula->id,
                'sku'            => 'SBK-SSU-002',
                'name'           => 'Susu Kental Manis Frisian Flag Kaleng 370g',
                'purchase_price' => 10500,
                'selling_price'  => 12500,
                'stock'          => 18,
                'minimum_stock'  => 5
            ],

            // Minuman Kemasan
            [
                'category_id'    => $catMinuman->id,
                'sku'            => 'SBK-KPI-001',
                'name'           => 'Kopi Kapal Api Mantap (1 Renteng / 10 sachet)',
                'purchase_price' => 12000,
                'selling_price'  => 14500,
                'stock'          => 35,
                'minimum_stock'  => 5
            ],
            [
                'category_id'    => $catMinuman->id,
                'sku'            => 'SBK-TEH-002',
                'name'           => 'Teh Celup SariWangi (Isi 25)',
                'purchase_price' => 5500,
                'selling_price'  => 7000,
                'stock'          => 40,
                'minimum_stock'  => 5
            ]
        ];

        foreach ($products as $prod) {
            Product::updateOrCreate(
                ['sku' => $prod['sku']],
                $prod
            );
        }
    }
}