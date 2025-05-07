<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ImageUpdateController extends Controller
{
    /**
     * Actualizează imaginile pentru toate produsele
     */
    public function updateProductImages()
    {
        // Definim URL-urile imaginilor reale pentru fiecare categorie
        $categoryImages = [
            'Electronice' => [
                'https://images.samsung.com/is/image/samsung/p6pim/ro/qe55q60cauxru/gallery/ro-qled-q60c-qe55q60cauxru-536856934?$650_519_PNG$',
                'https://img.ktc.ro/products/LG_OLED55C31LA.jpg',
                'https://s13emagst.akamaized.net/products/60157/60156038/images/res_5d38de5fca2deac4ccfc4f3b61ce39c6.jpg',
                'https://www.avmag.ro/content/uploads/2021/04/tv-philips-oled806.jpg',
            ],
            'Telefoane' => [
                'https://s13emagst.akamaized.net/products/53110/53109184/images/res_9bb67fb76a79d8acb6c5bc693f4a69de.jpg',
                'https://s13emagst.akamaized.net/products/58267/58266089/images/res_31b6fba4b3ac02ef7f73a3cc9a3e20d7.jpg',
                'https://s13emagst.akamaized.net/products/50853/50852496/images/res_3aa51f493cfb8b2bb7be2dd2a1eb47cc.jpg',
                'https://s13emagst.akamaized.net/products/49990/49989050/images/res_6a1868f5d97f1d1c64f375c71d1c73d6.jpg',
            ],
            'Laptopuri' => [
                'https://s13emagst.akamaized.net/products/54219/54218102/images/res_5f35317b6ee0c2be8a9bdf9acaba5b74.jpg',
                'https://s13emagst.akamaized.net/products/47794/47793982/images/res_518fb6f2b3ef4e2ee7a669d1e0a6ed33.jpg',
                'https://s13emagst.akamaized.net/products/48532/48531054/images/res_d90c5f64eb12e4c62e1d30e8292b4fd0.jpg',
                'https://s13emagst.akamaized.net/products/47557/47556580/images/res_30ef76ed5cbda7f713d0c4f92d80e9ca.jpg',
            ],
            'Gaming' => [
                'https://s13emagst.akamaized.net/products/53111/53110196/images/res_5c7d7f7c5befd19f10e5c49a6c61fea0.jpg',
                'https://s13emagst.akamaized.net/products/39429/39428468/images/res_1f7295a3ac58cce6973c45f3f8fba442.jpg',
                'https://s13emagst.akamaized.net/products/32360/32359368/images/res_a4d9bcf1c0f268fc4c88be69ed9eca1d.jpg',
                'https://s13emagst.akamaized.net/products/38908/38907644/images/res_2c835b64deb3bbfc5d0ebf71f26e4cdf.jpg',
            ],
            'Foto' => [
                'https://s13emagst.akamaized.net/products/27129/27128052/images/res_c9a0e7ed03142da31624d60b53456f4c.jpg',
                'https://s13emagst.akamaized.net/products/4715/4714996/images/res_e15ebd7df51aaa5b38704f15dd1c2d06.jpg',
                'https://s13emagst.akamaized.net/products/4715/4714996/images/res_e15ebd7df51aaa5b38704f15dd1c2d06.jpg',
                'https://s13emagst.akamaized.net/products/39408/39407301/images/res_b5fdbf6e1a31e49cea2a4a3a1aca1da1.jpg',
            ],
            'Electrocasnice' => [
                'https://s13emagst.akamaized.net/products/39352/39351051/images/res_5c1ecca4d232c24e57a2a63f16fb8c67.jpg',
                'https://s13emagst.akamaized.net/products/43903/43902276/images/res_1ca24ae7fa25a1f3dedb6fe336ef5e3a.jpg',
                'https://s13emagst.akamaized.net/products/32000/31999046/images/res_ec61b1e35ea2c2e9ef0a1e19e1bd3f7c.jpg',
                'https://s13emagst.akamaized.net/products/8683/8682089/images/res_2d5dba98741dabb8f07fb4ee01e6b9b3.jpg',
            ],
        ];
        
        // Calea unde vom salva imaginile
        $storagePath = storage_path('app/public/products');
        
        // Creăm directorul dacă nu există
        if (!File::exists($storagePath)) {
            File::makeDirectory($storagePath, 0755, true);
        }
        
        // Definim lista de produse cu care vrem să începem
        $productUpdates = [
            1 => ['url' => 'https://images.samsung.com/is/image/samsung/p6pim/ro/qe55q60cauxru/gallery/ro-qled-q60c-qe55q60cauxru-536856934?$650_519_PNG$', 'name' => 'samsung-smart-tv.jpg'],
            2 => ['url' => 'https://s13emagst.akamaized.net/products/34874/34873038/images/res_e5f6dc13f030ccddf326f27d65bcd339.jpg', 'name' => 'playstation-5.jpg'],
            3 => ['url' => 'https://s13emagst.akamaized.net/products/58267/58266089/images/res_31b6fba4b3ac02ef7f73a3cc9a3e20d7.jpg', 'name' => 'iphone-15.jpg'],
            4 => ['url' => 'https://s13emagst.akamaized.net/products/54219/54218102/images/res_5f35317b6ee0c2be8a9bdf9acaba5b74.jpg', 'name' => 'macbook-pro.jpg'],
            5 => ['url' => 'https://s13emagst.akamaized.net/products/23134/23133978/images/res_2de0a6a0df1ba77f9a09feb52ea587d4.jpg', 'name' => 'beko-fridge.jpg'],
            6 => ['url' => 'https://s13emagst.akamaized.net/products/27129/27128052/images/res_c9a0e7ed03142da31624d60b53456f4c.jpg', 'name' => 'canon-eos.jpg'],
            7 => ['url' => 'https://s13emagst.akamaized.net/products/39429/39428468/images/res_1f7295a3ac58cce6973c45f3f8fba442.jpg', 'name' => 'xbox-series-x.jpg'],
            8 => ['url' => 'https://s13emagst.akamaized.net/products/47794/47793982/images/res_518fb6f2b3ef4e2ee7a669d1e0a6ed33.jpg', 'name' => 'dell-xps.jpg'],
            9 => ['url' => 'https://s13emagst.akamaized.net/products/53110/53109184/images/res_9bb67fb76a79d8acb6c5bc693f4a69de.jpg', 'name' => 'samsung-galaxy.jpg'],
            10 => ['url' => 'https://img.ktc.ro/products/LG_OLED55C31LA.jpg', 'name' => 'lg-oled-tv.jpg'],
        ];
        
        // Procesează produsele din baza de date
        $productsUpdated = 0;
        
        foreach ($productUpdates as $productId => $imageData) {
            $product = Product::find($productId);
            
            if ($product) {
                try {
                    // Creăm un nume unic pentru fișier
                    $filename = 'product_' . $product->id . '_' . Str::slug($product->name) . '.jpg';
                    $filePath = 'products/' . $filename;
                    
                    // Descarc imaginea
                    $context = stream_context_create([
                        'http' => [
                            'header' => 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36'
                        ]
                    ]);
                    
                    $imageContent = @file_get_contents($imageData['url'], false, $context);
                    
                    if ($imageContent !== false) {
                        // Salvez imaginea
                        Storage::disk('public')->put($filePath, $imageContent);
                        
                        // Șterge imaginea veche dacă există
                        if ($product->image) {
                            Storage::disk('public')->delete($product->image);
                        }
                        
                        // Actualizează produsul cu noua imagine
                        $product->image = $filePath;
                        $product->save();
                        
                        $productsUpdated++;
                    }
                } catch (\Exception $e) {
                    // Continuăm cu următorul produs dacă apare o eroare
                    continue;
                }
            }
        }
        
        // Acum procesăm restul produselor cu imagini generice bazate pe categorie
        $remainingProducts = Product::whereNotIn('id', array_keys($productUpdates))->get();
        
        foreach ($remainingProducts as $product) {
            $category = $product->category;
            
            // Folosim o imagine specifică categoriei dacă există
            if (isset($categoryImages[$category]) && count($categoryImages[$category]) > 0) {
                try {
                    // Selectăm o imagine aleatoare pentru această categorie
                    $imageKey = array_rand($categoryImages[$category]);
                    $imageUrl = $categoryImages[$category][$imageKey];
                    
                    // Creăm un nume unic pentru fișier
                    $filename = 'product_' . $product->id . '_' . Str::slug($product->name) . '.jpg';
                    $filePath = 'products/' . $filename;
                    
                    // Descarc imaginea
                    $context = stream_context_create([
                        'http' => [
                            'header' => 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36'
                        ]
                    ]);
                    
                    $imageContent = @file_get_contents($imageUrl, false, $context);
                    
                    if ($imageContent !== false) {
                        // Salvez imaginea
                        Storage::disk('public')->put($filePath, $imageContent);
                        
                        // Șterge imaginea veche dacă există
                        if ($product->image) {
                            Storage::disk('public')->delete($product->image);
                        }
                        
                        // Actualizează produsul cu noua imagine
                        $product->image = $filePath;
                        $product->save();
                        
                        $productsUpdated++;
                        
                        // Eliminăm URL-ul pentru a nu-l refolosi
                        unset($categoryImages[$category][$imageKey]);
                        $categoryImages[$category] = array_values($categoryImages[$category]);
                    }
                } catch (\Exception $e) {
                    // Continuăm cu următorul produs dacă apare o eroare
                    continue;
                }
            }
        }
        
        return "S-au actualizat $productsUpdated produse cu imagini noi.";
    }
} 