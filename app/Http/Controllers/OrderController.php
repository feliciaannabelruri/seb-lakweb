<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Topping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['toppings']) 
                      ->where('user_id', auth()->id())
                      ->orderBy('id', 'desc')
                      ->get();
                      
        return view('orders.index', compact('orders'));
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            
            // Validasi input
            $validated = $request->validate([
                'spice_level' => 'required|integer|between:1,5',
                'consistency' => 'required|in:kuah,nyemek,kering',
                'toppings' => 'nullable|array',
                'toppings.*' => 'exists:toppings,id'
            ]);

            // Verifikasi ketersediaan topping dan get data topping
            if (!empty($validated['toppings'])) {
                $toppings = Topping::whereIn('id', $validated['toppings'])
                                 ->lockForUpdate()  // Lock records for update
                                 ->get();

                // Cek ketersediaan dan stock
                foreach ($toppings as $topping) {
                    if (!$topping->is_available) {
                        DB::rollBack();
                        return back()->with('error', "Maaf, topping {$topping->name} sedang tidak tersedia.");
                    }

                    if ($topping->stock <= 0) {
                        DB::rollBack();
                        return back()->with('error', "Maaf, stock topping {$topping->name} sudah habis.");
                    }
                }
            }

            // Hitung total price
            $basePrice = 15000;
            $totalPrice = $basePrice;

            // Proses topping: tambah harga dan kurangi stock
            if (!empty($validated['toppings'])) {
                foreach ($toppings as $topping) {
                    // Tambah harga
                    $totalPrice += $topping->price;

                    // Kurangi stock
                    $topping->stock -= 1;
                    
                    // Set is_available = false jika stock habis
                    if ($topping->stock <= 0) {
                        $topping->is_available = false;
                    }
                    
                    $topping->save();
                }
            }

            // Buat order
            $order = Order::create([
                'user_id' => auth()->id(),
                'spice_level' => $validated['spice_level'],
                'consistency' => $validated['consistency'],
                'status' => 'pending',
                'total_price' => $totalPrice
            ]);

            // Attach toppings ke order
            if (!empty($validated['toppings'])) {
                $order->toppings()->attach($validated['toppings']);
            }

            DB::commit();

            return redirect()->route('payment.show', $order)
                           ->with('success', 'Pesanan berhasil dibuat');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan. Silakan coba lagi.');
        }
    }

    public function cancel(Order $order)
    {
        try {
            DB::beginTransaction();

            // Cek apakah order bisa dicancel
            if ($order->status !== 'pending' || $order->payment_proof) {
                throw new \Exception('Order tidak dapat dibatalkan.');
            }

            // Pastikan order milik user yang login
            if ($order->user_id !== auth()->id()) {
                throw new \Exception('Unauthorized action.');
            }

            // Kembalikan stock topping
            foreach ($order->toppings as $topping) {
                $topping->increment('stock');
                
                // Jika topping tidak available tapi masih ada stock, set available lagi
                if (!$topping->is_available && $topping->stock > 0) {
                    $topping->update(['is_available' => true]);
                }
            }

            // Hapus order
            $order->delete();

            DB::commit();
            return redirect()->route('orders.index')
                           ->with('success', 'Pesanan berhasil dibatalkan');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('orders.index')
                           ->with('error', $e->getMessage());
        }
    }

    // Helper method untuk format currency
    private function formatPrice($price)
    {
        return number_format($price, 0, ',', '.');
    }

    public function deleteMultiple(Request $request)
{
    try {
        $orderIds = $request->order_ids;

        // Validasi order ids
        if (empty($orderIds)) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada orderan yang dipilih'
            ], 400);
        }

        // Ambil order yang bisa dihapus (completed, rejected)
        $orders = Order::whereIn('id', $orderIds)
                      ->whereIn('status', ['completed', 'cancelled', 'rejected'])
                      ->get();

        if ($orders->count() === 0) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada orderan yang dapat dihapus'
            ], 400);
        }

        // Hapus orderan
        DB::beginTransaction();
        try {
            foreach ($orders as $order) {
                $order->delete();
            }
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Orderan berhasil dihapus'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Terjadi kesalahan saat menghapus orderan'
        ], 500);
    }
}
}