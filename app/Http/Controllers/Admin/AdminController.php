<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
   public function dashboard()
   {
       $pendingOrders = Order::where('status', Order::STATUS_PENDING)
                            ->whereNotNull('payment_proof')  
                            ->count();
       $orders = Order::with(['user', 'toppings'])
                   ->orderBy('id', 'asc')  
                   ->get();
       return view('admin.orders', compact('orders', 'pendingOrders'));
   }

   public function orders($status = null)
   {
       $query = Order::with('user');

       switch ($status) {
           case 'pending':
               $query->where('status', Order::STATUS_PENDING);
               break;
           case 'processing':
               $query->where('status', Order::STATUS_PROCESSING);
               break;
           case 'completed':
               $query->where('status', Order::STATUS_COMPLETED);
               break;
           case 'rejected':
               $query->where('status', Order::STATUS_REJECTED);
               break;
           case 'cancelled':
               $query->where('status', Order::STATUS_CANCELLED);
               break;
       }

       $orders = $query->orderBy('id', 'asc')->get();
       return view('admin.orders.index', compact('orders', 'status'));
   }

   public function viewOrder(Order $order)
   {
       $order->load(['user', 'toppings']);
       return view('admin.orders.view', compact('order'));
   }

   public function orderDetails(Order $order)
   {
       $order->load(['user', 'toppings']);
       return view('admin.orders.details', compact('order'));
   }

   public function updateStatus(Request $request, Order $order)
   {
       $order->update(['status' => $request->status]);
       return back()->with('success', 'Order status updated successfully');
   }

   public function rejectOrder(Request $request, Order $order)
   {
       try {
           \Log::info('Attempting to reject order', [
               'order_id' => $order->id,
               'current_status' => $order->status,
               'reason' => $request->reason
           ]);

           $order->status = Order::STATUS_REJECTED;
           $order->rejection_reason = $request->reason;
           $updated = $order->save();

           \Log::info('Order rejection result', [
               'order_id' => $order->id,
               'update_success' => $updated,
               'new_status' => $order->fresh()->status
           ]);

           if (!$updated) {
               throw new \Exception('Failed to update order status');
           }

           return redirect()->route('admin.orders')
                          ->with('success', 'Order rejected successfully');

       } catch (\Exception $e) {
           \Log::error('Error rejecting order', [
               'order_id' => $order->id,
               'error' => $e->getMessage()
           ]);

           return redirect()->route('admin.orders')
                          ->with('error', 'Failed to reject order. Please try again.');
       }
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

            // Ambil order yang bisa dihapus (completed, cancelled, rejected)
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