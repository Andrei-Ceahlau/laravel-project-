<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageUpdaterController extends Controller
{
    /**
     * Actualizează imaginile pentru toate produsele
     */
    public function updateImages()
    {
        // Definim imagini prestabilite pentru fiecare categorie
        $categoryImages = [
            'Electronice' => 'https://images.unsplash.com/photo-1588508065123-287b28e013da?w=800&auto=format&fit=crop',
            'Telefoane' => 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=800&auto=format&fit=crop',
            'Laptopuri' => 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=800&auto=format&fit=crop',
            'Gaming' => 'https://images.unsplash.com/photo-1593305841991-05c297ba4575?w=800&auto=format&fit=crop',
            'Foto' => 'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?w=800&auto=format&fit=crop',
            'Electrocasnice' => 'https://images.unsplash.com/photo-1556911220-bff31c812dba?w=800&auto=format&fit=crop',
        ];
        
        // Imagini specifice pentru anumite produse (bazate pe id)
        $specificImages = [
            1 => 'https://images.unsplash.com/photo-1593359677879-a4bb92f829d1?w=800&auto=format&fit=crop', // Samsung TV
            3 => 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=800&auto=format&fit=crop', // MacBook Pro
            4 => 'https://images.unsplash.com/photo-1607853202273-797f1c22a38e?w=800&auto=format&fit=crop', // PlayStation 5
            5 => 'https://images.unsplash.com/photo-1516724562728-afc824a36e84?w=800&auto=format&fit=crop', // Canon
            6 => 'https://images.unsplash.com/photo-1507646227500-4d389b0012be?w=800&auto=format&fit=crop', // Dyson
        ];
        
        // Contorizăm produsele actualizate
        $updatedCount = 0;
        
        // Procesăm toate produsele
        $products = Product::all();
        
        foreach ($products as $product) {
            // Determinăm ce imagine să folosim (specifică sau generică pentru categorie)
            $imageUrl = isset($specificImages[$product->id]) 
                ? $specificImages[$product->id] 
                : ($categoryImages[$product->category] ?? 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=800&auto=format&fit=crop');
            
            try {
                // Creăm numele fișierului
                $filename = 'product_' . $product->id . '_' . Str::slug($product->name) . '.jpg';
                $filePath = 'products/' . $filename;
                
                // Descarc imaginea cu context pentru a evita erorile
                $context = stream_context_create([
                    'http' => [
                        'header' => 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36'
                    ]
                ]);
                
                $imageContent = @file_get_contents($imageUrl, false, $context);
                
                if ($imageContent !== false) {
                    // Creăm directorul dacă nu există
                    if (!Storage::disk('public')->exists('products')) {
                        Storage::disk('public')->makeDirectory('products');
                    }
                    
                    // Salvăm imaginea
                    Storage::disk('public')->put($filePath, $imageContent);
                    
                    // Actualizăm produsul
                    $product->image = $filePath;
                    $product->save();
                    
                    $updatedCount++;
                }
            } catch (\Exception $e) {
                // Ignorăm erorile și continuăm cu următorul produs
                continue;
            }
        }
        
        return "S-au actualizat $updatedCount produse cu imagini noi.";
    }
} 