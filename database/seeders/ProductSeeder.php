<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Samsung Smart TV',
                'description' => 'Televizor inteligent Samsung cu ecran de 55 inch, rezoluție 4K, HDR și funcții smart integrate.',
                'price' => 1800.00,
                'stock' => 24,
                'status' => 'in_stock',
                'category' => 'Electronice',
                'image' => null,
                'brand' => 'Samsung',
                'model' => 'UE55AU7172',
                'sku' => 'SA-TV-55AU-7172',
                'weight' => '15.5 kg',
                'dimensions' => '123.05 x 70.72 x 5.59 cm',
                'warranty' => '24 luni',
                'featured' => true,
            ],
            [
                'name' => 'iPhone 13 Pro',
                'description' => 'iPhone 13 Pro cu ecran Super Retina XDR de 6,1 inch, procesor A15 Bionic și cameră Pro de 12MP.',
                'price' => 5500.00,
                'stock' => 2,
                'status' => 'low_stock',
                'category' => 'Telefoane',
                'image' => null,
                'brand' => 'Apple',
                'model' => 'iPhone 13 Pro',
                'sku' => 'AP-IP-13PRO-128',
                'weight' => '203 g',
                'dimensions' => '146.7 x 71.5 x 7.65 mm',
                'warranty' => '12 luni',
                'featured' => true,
            ],
            [
                'name' => 'MacBook Pro',
                'description' => 'MacBook Pro 14" cu cip Apple M1 Pro, 16GB RAM, 512GB SSD și ecran Liquid Retina XDR.',
                'price' => 8200.00,
                'stock' => 15,
                'status' => 'in_stock',
                'category' => 'Laptopuri',
                'image' => null,
                'brand' => 'Apple',
                'model' => 'MacBook Pro 14"',
                'sku' => 'AP-MB-PRO14-M1P',
                'weight' => '1.6 kg',
                'dimensions' => '31.26 x 22.12 x 1.55 cm',
                'warranty' => '24 luni',
                'featured' => false,
            ],
            [
                'name' => 'PlayStation 5',
                'description' => 'Consolă PlayStation 5 cu unitate optică, controler DualSense, și SSD ultra-rapid.',
                'price' => 2500.00,
                'stock' => 0,
                'status' => 'out_of_stock',
                'category' => 'Gaming',
                'image' => null,
                'brand' => 'Sony',
                'model' => 'PlayStation 5',
                'sku' => 'SO-PS5-1TB',
                'weight' => '4.5 kg',
                'dimensions' => '39 x 10.4 x 26 cm',
                'warranty' => '24 luni',
                'featured' => true,
            ],
            [
                'name' => 'Canon EOS R5',
                'description' => 'Cameră foto profesională Canon EOS R5 cu senzor CMOS de 45MP și filmare 8K.',
                'price' => 14500.00,
                'stock' => 3,
                'status' => 'low_stock',
                'category' => 'Foto',
                'image' => null,
                'brand' => 'Canon',
                'model' => 'EOS R5',
                'sku' => 'CA-EOS-R5',
                'weight' => '738 g',
                'dimensions' => '138.5 x 97.5 x 88 mm',
                'warranty' => '24 luni',
                'featured' => false,
            ],
            [
                'name' => 'Dyson V11',
                'description' => 'Aspirator vertical fără fir Dyson V11 Absolute cu motor digital și autonomie de până la 60 minute.',
                'price' => 2800.00,
                'stock' => 10,
                'status' => 'in_stock',
                'category' => 'Electrocasnice',
                'image' => null,
                'brand' => 'Dyson',
                'model' => 'V11 Absolute',
                'sku' => 'DY-V11-ABS',
                'weight' => '3.05 kg',
                'dimensions' => '126 x 26.1 x 25 cm',
                'warranty' => '36 luni',
                'featured' => true,
            ],
            [
                'name' => 'Dell XPS 13',
                'description' => 'Laptop ultraportabil Dell XPS 13 cu procesor Intel Core i7, 16GB RAM, 512GB SSD și ecran InfinityEdge.',
                'price' => 6700.00,
                'stock' => 8,
                'status' => 'in_stock',
                'category' => 'Laptopuri',
                'image' => null,
                'brand' => 'Dell',
                'model' => 'XPS 13',
                'sku' => 'DE-XPS13-I7',
                'weight' => '1.27 kg',
                'dimensions' => '29.6 x 19.9 x 1.44 cm',
                'warranty' => '24 luni',
                'featured' => false,
            ],
            [
                'name' => 'Samsung Galaxy S22',
                'description' => 'Smartphone Samsung Galaxy S22 cu ecran Dynamic AMOLED 2X de 6,1 inch, procesor Exynos 2200 și cameră de 50MP.',
                'price' => 3800.00,
                'stock' => 12,
                'status' => 'in_stock',
                'category' => 'Telefoane',
                'image' => null,
                'brand' => 'Samsung',
                'model' => 'Galaxy S22',
                'sku' => 'SA-GS22-128',
                'weight' => '167 g',
                'dimensions' => '146 x 70.6 x 7.6 mm',
                'warranty' => '24 luni',
                'featured' => true,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
