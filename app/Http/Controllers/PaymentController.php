<?php

namespace App\Http\Controllers;

use App\Rules\SecureFile;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller 
{
    public function show(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }
        return view('payment.show', compact('order'));
    }

    public function uploadProof(Request $request, Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'payment_proof' => ['required', new SecureFile]
        ]);

        if ($request->hasFile('payment_proof')) {
            try {
                // Create directory if it doesn't exist
                $path = storage_path('app/public/payment_proofs');
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }

                // Store file with sanitized filename
                $file = $request->file('payment_proof');
                $filename = time() . '_' . preg_replace('/[^A-Za-z0-9\-\_\.]/', '', $file->getClientOriginalName());
                
                // Store the file
                $file->storeAs('payment_proofs', $filename, 'public');
                
                // Update order with the correct path
                $order->update([
                    'payment_proof' => 'payment_proofs/' . $filename,
                    'status' => Order::STATUS_PENDING
                ]);

                Log::info('Payment proof uploaded', [
                    'order_id' => $order->id,
                    'filename' => $filename,
                    'path' => 'payment_proofs/' . $filename
                ]);

                return redirect()->route('orders.index')
                    ->with('success', 'Payment proof uploaded successfully');

            } catch (\Exception $e) {
                Log::error('Payment proof upload failed', [
                    'error' => $e->getMessage(),
                    'order_id' => $order->id
                ]);
                return back()->with('error', 'Failed to upload payment proof');
            }
        }

        return back()->with('error', 'No file was uploaded');
    }
}