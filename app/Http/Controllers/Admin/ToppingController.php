<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Topping;
use App\Models\ToppingCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ToppingController extends Controller
{
    private function debugImagePath($imageName)
    {
        \Log::info('Image path debug:', [
            'storage_path' => storage_path('app/public/images/toppings/' . $imageName),
            'public_path' => public_path('storage/images/toppings/' . $imageName),
            'exists_in_storage' => file_exists(storage_path('app/public/images/toppings/' . $imageName)),
            'exists_in_public' => file_exists(public_path('storage/images/toppings/' . $imageName))
        ]);
    }

    public function index()
    {
        $toppingCategories = ToppingCategory::with(['toppings' => function($query) {
            $query->orderBy('name');
        }])->orderBy('name')->get();
        
        \Log::info('Available categories:', $toppingCategories->pluck('name', 'id')->toArray());
        
        return view('admin.toppings.index', compact('toppingCategories'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'price' => 'required|numeric|min:0',
                'stock' => 'required|integer|min:0',
                'category_id' => 'required|exists:topping_categories,id',
                'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                'is_available' => 'boolean'
            ]);

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                
                // Simpan gambar menggunakan move
                $image->move(storage_path('app/public/images/toppings'), $imageName);
                $validated['image'] = $imageName;
                
                // Debug image path
                $this->debugImagePath($imageName);
                
                \Log::info('Image saved:', [
                    'name' => $imageName,
                    'path' => storage_path('app/public/images/toppings/' . $imageName)
                ]);
            }

            $validated['is_available'] = $request->has('is_available');
            $topping = Topping::create($validated);

            return redirect()->route('admin.toppings.index')
                ->with('success', 'Topping berhasil ditambahkan');
                
        } catch (\Exception $e) {
            \Log::error('Error creating topping:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Gagal menambahkan topping: ' . $e->getMessage()]);
        }
    }

    public function edit(Topping $topping)
    {
        $imagePath = storage_path('app/public/images/toppings/' . $topping->image);
        $imageExists = file_exists($imagePath);
        
        \Log::info('Edit topping image check:', [
            'topping_id' => $topping->id,
            'image_name' => $topping->image,
            'image_path' => $imagePath,
            'exists' => $imageExists
        ]);

        return response()->json([
            'name' => $topping->name,
            'category_id' => $topping->category_id,
            'price' => $topping->price,
            'stock' => $topping->stock,
            'is_available' => $topping->is_available,
            'image_url' => asset('storage/images/toppings/' . $topping->image)
        ]);
    }

    public function update(Request $request, Topping $topping)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'price' => 'required|numeric|min:0',
                'stock' => 'required|integer|min:0',
                'category_id' => 'required|exists:topping_categories,id',
                'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'is_available' => 'nullable|boolean'
            ]);

            $validated['is_available'] = $request->has('is_available');

            if ($request->hasFile('image')) {
                // Hapus gambar lama
                $oldImagePath = storage_path('app/public/images/toppings/' . $topping->image);
                if ($topping->image && file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
                
                $image = $request->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                
                // Simpan gambar baru menggunakan move
                $image->move(storage_path('app/public/images/toppings'), $imageName);
                $validated['image'] = $imageName;
                
                // Debug image path
                $this->debugImagePath($imageName);
            }

            $topping->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Topping berhasil diperbarui',
                'data' => $topping->fresh()
            ]);

        } catch (\Exception $e) {
            \Log::error('Error updating topping:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui topping: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Topping $topping)
    {
        try {
            // Hapus file gambar
            $imagePath = storage_path('app/public/images/toppings/' . $topping->image);
            if ($topping->image && file_exists($imagePath)) {
                unlink($imagePath);
            }

            $topping->delete();

            return redirect()->route('admin.toppings.index')
                ->with('success', 'Topping berhasil dihapus');
        } catch (\Exception $e) {
            \Log::error('Error deleting topping:', [
                'topping_id' => $topping->id,
                'message' => $e->getMessage()
            ]);
            return redirect()->back()->with('error', 'Gagal menghapus topping');
        }
    }

    public function updateStock(Request $request, Topping $topping)
    {
        \Log::info('Updating stock', [
            'topping_id' => $topping->id,
            'current_stock' => $topping->stock,
            'new_stock' => $request->stock
        ]);
    
        $validated = $request->validate([
            'stock' => 'required|integer|min:0'
        ]);
    
        $topping->update([
            'stock' => $validated['stock'],
            'is_available' => $validated['stock'] > 0
        ]);
    
        \Log::info('Stock updated', [
            'topping_id' => $topping->id,
            'new_stock' => $topping->stock,
            'is_available' => $topping->is_available
        ]);
    
        return response()->json([
            'success' => true,
            'stock' => $topping->stock,
            'is_available' => $topping->is_available
        ]);
    }

    public function toggleAvailability(Request $request, Topping $topping)
    {
        $validated = $request->validate([
            'is_available' => 'required|boolean'
        ]);

        $topping->update([
            'is_available' => $validated['is_available']
        ]);

        return response()->json([
            'success' => true,
            'is_available' => $topping->is_available
        ]);
    }
}