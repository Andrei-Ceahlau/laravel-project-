<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Response;

class ProductController extends Controller
{
    /**
     * Afișează lista de produse
     */
    public function index(Request $request)
    {
        $query = Product::query();
        
        // Filtrare după nume/cuvinte cheie
        if ($request->has('search') && !empty($request->search)) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }
        
        // Filtrare după categorie
        if ($request->has('category') && $request->category !== 'Toate') {
            $query->where('category', $request->category);
        }
        
        // Filtrare după status
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }
        
        $products = $query->get();
        $categories = Product::select('category')->distinct()->pluck('category')->prepend('Toate');
        
        return view('products.index', compact('products', 'categories'));
    }

    /**
     * Afișează formularul pentru adăugarea unui produs nou
     */
    public function create()
    {
        $categories = ['Electronice', 'Telefoane', 'Laptopuri', 'Gaming', 'Foto', 'Electrocasnice'];
        
        return view('products.create', compact('categories'));
    }

    /**
     * Stochează un produs nou în baza de date
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category' => 'required|string|max:255',
            'brand' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'sku' => 'nullable|string|max:255|unique:products,sku',
            'weight' => 'nullable|string|max:255',
            'dimensions' => 'nullable|string|max:255',
            'warranty' => 'nullable|string|max:255',
            'featured' => 'boolean',
            'image' => 'nullable|image|max:2048'
        ]);
        
        // Determină statusul stocului
        if ($validatedData['stock'] <= 0) {
            $validatedData['status'] = 'out_of_stock';
        } elseif ($validatedData['stock'] <= 5) {
            $validatedData['status'] = 'low_stock';
        } else {
            $validatedData['status'] = 'in_stock';
        }
        
        // Procesează imaginea
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $validatedData['image'] = $path;
        }
        
        Product::create($validatedData);
        
        return redirect()->route('products.index')
            ->with('success', 'Produsul a fost creat cu succes!');
    }

    /**
     * Afișează informațiile unui produs specific
     */
    public function show(Product $product)
    {
        // Găsim produse similare din aceeași categorie
        $similarProducts = Product::where('category', $product->category)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();
            
        // Încărcăm recenziile pentru acest produs
        $reviews = $product->reviews()->with('user')->latest()->paginate(5);
        $averageRating = $product->getAverageRatingAttribute();
        $reviewsCount = $product->getReviewsCountAttribute();
        
        return view('products.show', compact('product', 'similarProducts', 'reviews', 'averageRating', 'reviewsCount'));
    }

    /**
     * Afișează formularul pentru editarea unui produs
     */
    public function edit(Product $product)
    {
        $categories = ['Electronice', 'Telefoane', 'Laptopuri', 'Gaming', 'Foto', 'Electrocasnice'];
        $statuses = ['in_stock', 'low_stock', 'out_of_stock'];
        
        return view('products.edit', compact('product', 'categories', 'statuses'));
    }

    /**
     * Actualizează un produs specific în baza de date
     */
    public function update(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category' => 'required|string|max:255',
            'brand' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'sku' => 'nullable|string|max:255|unique:products,sku,' . $product->id,
            'weight' => 'nullable|string|max:255',
            'dimensions' => 'nullable|string|max:255',
            'warranty' => 'nullable|string|max:255',
            'featured' => 'boolean',
            'image' => 'nullable|image|max:2048'
        ]);
        
        // Determină statusul stocului
        if ($validatedData['stock'] <= 0) {
            $validatedData['status'] = 'out_of_stock';
        } elseif ($validatedData['stock'] <= 5) {
            $validatedData['status'] = 'low_stock';
        } else {
            $validatedData['status'] = 'in_stock';
        }
        
        // Procesează imaginea
        if ($request->hasFile('image')) {
            // Șterge imaginea veche dacă există
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            
            $path = $request->file('image')->store('products', 'public');
            $validatedData['image'] = $path;
        }
        
        $product->update($validatedData);
        
        return redirect()->route('products.show', $product)
            ->with('success', 'Produsul a fost actualizat cu succes!');
    }

    /**
     * Șterge un produs specific din baza de date
     */
    public function destroy(Product $product)
    {
        // Șterge imaginea produsului dacă există
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        
        $product->delete();
        
        return redirect()->route('products.index')
            ->with('success', 'Produsul a fost șters cu succes!');
    }

    /**
     * Afișează formularul pentru modificarea prețului unui produs
     */
    public function editPrice(Product $product)
    {
        return view('products.edit_price', compact('product'));
    }
    
    /**
     * Actualizează prețul unui produs
     */
    public function updatePrice(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            'price' => 'required|numeric|min:0',
        ]);
        
        $product->update([
            'price' => $validatedData['price'],
        ]);
        
        return redirect()->route('products.show', $product)
            ->with('success', 'Prețul produsului a fost actualizat cu succes!');
    }
    
    /**
     * Duplică un produs existent
     */
    public function duplicate(Product $product)
    {
        // Creăm o copie a produsului
        $newProduct = $product->replicate();
        $newProduct->name = $product->name . ' (copie)';
        $newProduct->sku = $product->sku ? $product->sku . '-copy-' . Str::random(5) : null;
        $newProduct->created_at = now();
        $newProduct->updated_at = now();
        
        // Dacă produsul are o imagine, o copiem
        if ($product->image) {
            $originalImage = $product->image;
            $imageParts = explode('/', $originalImage);
            $imageName = end($imageParts);
            $newImageName = 'products/copy_' . $imageName;
            
            if (Storage::disk('public')->exists($originalImage)) {
                Storage::disk('public')->copy($originalImage, $newImageName);
                $newProduct->image = $newImageName;
            }
        }
        
        $newProduct->save();
        
        return redirect()->route('products.show', $newProduct)
            ->with('success', 'Produsul a fost duplicat cu succes!');
    }
    
    /**
     * Generează un raport PDF pentru un produs
     */
    public function generateReport(Product $product)
    {
        // Implementare simplă - doar returnăm datele produsului într-un format text
        $content = "RAPORT PRODUS\n\n";
        $content .= "ID: " . $product->id . "\n";
        $content .= "Nume: " . $product->name . "\n";
        $content .= "Categorie: " . $product->category . "\n";
        $content .= "Preț: " . number_format($product->price, 2) . " Lei\n";
        $content .= "Stoc: " . $product->stock . " bucăți\n";
        $content .= "Status: " . $product->status . "\n";
        $content .= "Brand: " . ($product->brand ?? 'N/A') . "\n";
        $content .= "Model: " . ($product->model ?? 'N/A') . "\n";
        $content .= "SKU: " . ($product->sku ?? 'N/A') . "\n";
        $content .= "Dimensiuni: " . ($product->dimensions ?? 'N/A') . "\n";
        $content .= "Greutate: " . ($product->weight ?? 'N/A') . "\n";
        $content .= "Garanție: " . ($product->warranty ?? 'N/A') . "\n";
        $content .= "Creat la: " . $product->created_at->format('d.m.Y') . "\n";
        $content .= "Actualizat la: " . $product->updated_at->format('d.m.Y') . "\n";
        
        // Generam un fisier text pentru download
        $fileName = 'raport_produs_' . $product->id . '.txt';
        
        return Response::make($content, 200, [
            'Content-Type' => 'text/plain',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ]);
    }
    
    /**
     * Afișează formularul pentru adăugarea de stoc
     */
    public function addStock(Product $product)
    {
        return view('products.add_stock', compact('product'));
    }
    
    /**
     * Actualizează stocul prin adăugare
     */
    public function updateAddStock(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);
        
        // Adăugăm cantitatea la stocul existent
        $newStock = $product->stock + $validatedData['quantity'];
        
        // Actualizăm stocul și statusul
        $status = $newStock <= 0 ? 'out_of_stock' : ($newStock <= 5 ? 'low_stock' : 'in_stock');
        
        $product->update([
            'stock' => $newStock,
            'status' => $status,
        ]);
        
        return redirect()->route('products.show', $product)
            ->with('success', 'Stocul a fost actualizat cu succes! Au fost adăugate ' . $validatedData['quantity'] . ' bucăți.');
    }
    
    /**
     * Afișează formularul pentru ajustarea stocului
     */
    public function adjustStock(Product $product)
    {
        return view('products.adjust_stock', compact('product'));
    }
    
    /**
     * Actualizează stocul prin ajustare
     */
    public function updateAdjustStock(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            'quantity' => 'required|integer|max:' . $product->stock,
            'reason' => 'required|string|max:255',
        ]);
        
        // Scădem cantitatea din stocul existent
        $newStock = $product->stock - $validatedData['quantity'];
        
        // Actualizăm stocul și statusul
        $status = $newStock <= 0 ? 'out_of_stock' : ($newStock <= 5 ? 'low_stock' : 'in_stock');
        
        $product->update([
            'stock' => $newStock,
            'status' => $status,
        ]);
        
        return redirect()->route('products.show', $product)
            ->with('success', 'Stocul a fost ajustat cu succes! Au fost eliminate ' . $validatedData['quantity'] . ' bucăți.');
    }
    
    /**
     * Exportă lista de produse în format CSV
     */
    public function export(Request $request)
    {
        // Folosim aceeași logică de filtrare ca în metoda index
        $query = Product::query();
        
        // Filtrare după nume/cuvinte cheie
        if ($request->has('search') && !empty($request->search)) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }
        
        // Filtrare după categorie
        if ($request->has('category') && $request->category !== 'Toate') {
            $query->where('category', $request->category);
        }
        
        // Filtrare după status
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }
        
        $products = $query->get();
        
        // Numele coloanelor pentru CSV
        $headers = [
            'ID',
            'Nume',
            'Descriere',
            'Preț',
            'Stoc',
            'Status',
            'Categorie',
            'Brand',
            'Model',
            'SKU',
            'Greutate',
            'Dimensiuni',
            'Garanție',
            'Featured',
            'Creat la',
            'Actualizat la'
        ];
        
        // Generăm fișierul CSV
        $filename = 'produse_' . date('Y-m-d_H-i-s') . '.csv';
        
        $handle = fopen('php://temp', 'r+');
        
        // Adăugăm header-ul
        fputcsv($handle, $headers);
        
        // Adăugăm datele produselor
        foreach ($products as $product) {
            $row = [
                $product->id,
                $product->name,
                $product->description,
                $product->price,
                $product->stock,
                $product->status,
                $product->category,
                $product->brand,
                $product->model,
                $product->sku,
                $product->weight,
                $product->dimensions,
                $product->warranty,
                $product->featured ? 'Da' : 'Nu',
                $product->created_at->format('d.m.Y H:i:s'),
                $product->updated_at->format('d.m.Y H:i:s')
            ];
            
            fputcsv($handle, $row);
        }
        
        rewind($handle);
        $content = stream_get_contents($handle);
        fclose($handle);
        
        return Response::make($content, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }
}
