@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-red-800 pb-12">
    <!-- Title -->
    <div class="text-center py-4 sm:py-6 md:py-8">
        <div class="inline-block bg-[#D68C45] px-6 sm:px-8 md:px-12 py-2 sm:py-3 md:py-4 rounded-lg transform -rotate-2">
            <h1 class="text-xl sm:text-2xl md:text-3xl font-['Kalam'] font-bold text-white italic">Order Details</h1>
            <p class="text-sm sm:text-base font-['Kalam'] text-white/90 italic">Order #{{ $order->id }}</p>
        </div>
    </div>

    <!-- Back Button -->
    <div class="w-full max-w-xl mx-auto px-4 mt-8 mb-4">
        <a href="{{ route('admin.orders') }}" 
           class="inline-block bg-white/90 hover:bg-white text-red-800 px-4 py-2 rounded-full text-sm transition-colors shadow-md">
            ← Back to Orders
        </a>
    </div>

    <!-- Receipt Card -->
    <div class="w-full max-w-xl mx-auto px-4">
        <div class="bg-white shadow-xl rounded-lg relative transform hover:-translate-y-1 transition-transform duration-200">
            <!-- Thermal paper texture effect -->
            <div class="absolute inset-0 pointer-events-none opacity-5" 
                 style="background-image: linear-gradient(90deg, rgba(0,0,0,0.05) 1px, transparent 1px), 
                                       linear-gradient(rgba(0,0,0,0.05) 1px, transparent 1px); 
                        background-size: 15px 15px;"></div>

            <!-- Receipt content -->
            <div class="p-8 relative">
                <!-- Logo and Header -->
                <div class="text-center mb-8">
                    <img src="{{ asset('images/logo2.png') }}" alt="Seblak Mama DK" class="h-24 mx-auto mb-3">
                    <div class="text-xs text-gray-500 space-y-1">
                        <p>Foodcourt Medang, Taman Madani, Seblak & Sinar Garut Mama DK</p>
                        <p>Phone: +62 821-1833-9394</p>
                    </div>
                </div>

                <!-- Order Info -->
                <div class="text-center mb-6">
                    <p class="text-lg font-semibold mb-1">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</p>
                    <p class="text-sm text-gray-500">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                    <div class="mt-2">
                        <span class="inline-block px-3 py-1 rounded-full text-sm
                            @switch($order->status)
                                @case('completed')
                                    bg-[#90B77D] text-white
                                    @break
                                @case('processing')
                                    bg-[#D68C45] text-white
                                    @break
                                @case('pending')
                                    @if($order->payment_proof)
                                        bg-[#78A2CC] text-white
                                    @endif
                                    @break
                                @case('rejected')
                                    bg-red-500 text-white
                                    @break
                            @endswitch">
                            @switch($order->status)
                                @case('pending')
                                    @if($order->payment_proof)
                                        Waiting for Confirmation
                                    @endif
                                    @break
                                @default
                                    {{ ucfirst($order->status) }}
                            @endswitch
                        </span>
                    </div>
                </div>

                <!-- Customer Info -->
                <div class="text-sm mb-6">
                    <p><span class="text-gray-500">Customer:</span> {{ $order->user->name }}</p>
                    <p class="text-gray-500 text-xs">{{ $order->user->email }}</p>
                </div>

                <!-- Order Items -->
                <div class="mb-6">
                    <div class="space-y-2">
                        <!-- Base Seblak -->
                        <div class="flex justify-between text-sm">
                            <div>
                                <p>Base Seblak</p>
                                <div class="text-xs text-gray-500 flex items-center gap-2">
                                    <span>Spice Level:</span>
                                    <div class="flex gap-0.5">
                                    @if($order->spice_level == 0)
                                                                        Level 1 - Tidak Pedas
                                                                    @elseif($order->spice_level == 1)
                                                                        Level 2 - Sedang
                                                                    @elseif($order->spice_level == 2)
                                                                        Level 3 - Pedas
                                                                    @elseif($order->spice_level == 3)
                                                                        Level 4 - Sangat Pedas
                                                                    @elseif($order->spice_level == 4)
                                                                        Level 5 - Extra Pedas
                                                                    @else
                                                                        Level {{ $order->spice_level }}
                                                                    @endif
                                    </div>
                                </div>
                                <p class="text-xs text-gray-500">Consistency: {{ ucfirst($order->consistency) }}</p>
                            </div>
                            <span>15,000</span>
                        </div>

                        <!-- Toppings -->
                        @foreach($order->toppings as $topping)
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">+ {{ $topping->name }}</span>
                            <span>{{ number_format($topping->price) }}</span>
                        </div>
                        @endforeach
                    </div>

                    <!-- Total -->
                    <div class="border-t border-gray-200 mt-4 pt-4">
                        <div class="flex justify-between font-semibold">
                            <span>TOTAL</span>
                            <span>Rp {{ number_format($order->total_price) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Payment Proof -->
                @if($order->payment_proof)
                <div class="mb-6">
                    <p class="text-sm text-gray-500 mb-2">Payment Proof</p>
                    <img src="{{ asset('storage/' . $order->payment_proof) }}" 
                         class="w-full rounded shadow-sm" 
                         alt="Payment Proof">
                </div>
                @endif

                <!-- Action Buttons -->
                <div class="flex justify-end gap-2 mt-6">
                    @if($order->status === 'pending')
                        <button type="button"
                                class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-full text-sm transition-colors"
                                onclick="document.getElementById('rejectModal').classList.remove('hidden')">
                            Reject
                        </button>
                        <form action="{{ route('admin.orders.status', $order) }}" method="POST">
                            @csrf
                            <button type="submit" 
                                    name="status" 
                                    value="processing"
                                    class="bg-[#90B77D] hover:bg-[#90B77D]/90 text-white px-4 py-2 rounded-full text-sm transition-colors">
                                Accept
                            </button>
                        </form>
                    @endif
                    @if($order->status === 'processing')
                        <form action="{{ route('admin.orders.status', $order) }}" method="POST">
                            @csrf
                            <button type="submit" 
                                    name="status" 
                                    value="completed"
                                    class="bg-[#90B77D] hover:bg-[#90B77D]/90 text-white px-4 py-2 rounded-full text-sm transition-colors">
                                Complete
                            </button>
                        </form>
                    @endif
                </div>

                <!-- Rejection Reason -->
                @if($order->rejection_reason)
                <div class="mt-6 pt-4 border-t border-gray-200">
                    <p class="text-sm text-red-500">Rejection Reason:</p>
                    <p class="text-sm text-gray-600 mt-1">{{ $order->rejection_reason }}</p>
                </div>
                @endif

                <!-- Receipt Footer -->
                <div class="text-center text-xs text-gray-400 mt-8">
                    <p>Thank you for your order!</p>
                    <p>{{ now()->format('d/m/Y H:i:s') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg max-w-md w-full p-6">
            <h3 class="text-lg font-semibold mb-4">Reject Order</h3>
            <form action="{{ route('admin.orders.reject', $order) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="reason" class="block text-sm text-gray-700 mb-2">Rejection Reason</label>
                    <textarea id="reason" 
                              name="reason" 
                              rows="3" 
                              class="w-full rounded-lg border-gray-300"
                              required></textarea>
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" 
                            onclick="document.getElementById('rejectModal').classList.add('hidden')"
                            class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-full text-sm transition-colors">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-full text-sm transition-colors">
                        Reject
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
.min-h-screen {
    background-color: #991B1B;
}

main {
    background-color: #991B1B;
}
</style>
@endpush
@endsection