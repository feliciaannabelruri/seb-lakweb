@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-red-800 pb-12" x-data="orderManager">
    <!-- Title -->
    <div class="text-center py-4 sm:py-6 md:py-8">
        <div class="inline-block bg-[#D68C45] px-6 sm:px-8 md:px-12 py-2 sm:py-3 md:py-4 rounded-lg transform -rotate-2">
            <h1 class="text-xl sm:text-2xl md:text-3xl font-['Kalam'] font-bold text-white italic">Admin Dashboard</h1>
            <p class="text-sm sm:text-base font-['Kalam'] text-white/90 italic">Kelola Pesanan Seblak</p>
        </div>
    </div>

    <!-- Status Tabs -->
    <div class="w-full max-w-6xl mx-auto px-4 mb-8">
        <div class="flex flex-wrap gap-2 justify-center">
            <a href="{{ route('admin.orders') }}" 
               class="px-6 py-2 rounded-full font-['Kalam'] text-white transition-all duration-200 
                      {{ !request('status') ? 'bg-[#D68C45]' : 'bg-white/20 hover:bg-[#D68C45]/80' }}">
                All Orders
            </a>
            <a href="{{ route('admin.orders.filter', ['status' => 'confirmation']) }}" 
               class="px-6 py-2 rounded-full font-['Kalam'] text-white transition-all duration-200 
                      {{ request('status') === 'confirmation' ? 'bg-[#78A2CC]' : 'bg-white/20 hover:bg-[#78A2CC]/80' }}">
                Waiting for Confirmation
            </a>
            <a href="{{ route('admin.orders.filter', ['status' => 'processing']) }}" 
               class="px-6 py-2 rounded-full font-['Kalam'] text-white transition-all duration-200 
                      {{ request('status') === 'processing' ? 'bg-[#D68C45]' : 'bg-white/20 hover:bg-[#D68C45]/80' }}">
                Processing
            </a>
            <a href="{{ route('admin.orders.filter', ['status' => 'completed']) }}" 
               class="px-6 py-2 rounded-full font-['Kalam'] text-white transition-all duration-200 
                      {{ request('status') === 'completed' ? 'bg-[#90B77D]' : 'bg-white/20 hover:bg-[#90B77D]/80' }}">
                Completed
            </a>
            <a href="{{ route('admin.orders.filter', ['status' => 'rejected']) }}" 
               class="px-6 py-2 rounded-full font-['Kalam'] text-white transition-all duration-200 
                      {{ request('status') === 'rejected' ? 'bg-red-500' : 'bg-white/20 hover:bg-red-500/80' }}">
                Rejected
            </a>
        </div>
    </div>

    <!-- Delete Orders Button -->
    <div class="w-full max-w-6xl mx-auto px-4 mb-4">
        <div class="flex justify-end gap-2">
            <!-- Hapus Orderan Button -->
            <button @click="toggleDeleteMode"
                    x-cloak
                    class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-full font-['Kalam'] transition-colors flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9z" clip-rule="evenodd" />
                </svg>
                <span x-text="deleteMode ? 'Batal' : 'Hapus Orderan'"></span>
            </button>

            <!-- Hapus yang Dipilih Button -->
            <button x-show="deleteMode && selectedOrders.length > 0"
                    @click="confirmDeleteSelected"
                    x-cloak

                    class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-full font-['Kalam'] transition-colors">
                Hapus yang Dipilih (<span x-text="selectedOrders.length"></span>)
            </button>
        </div>
    </div>

    <!-- Orders Display -->
    <div class="w-full max-w-6xl mx-auto px-3 sm:px-4">
        @php
            if(request('status') === 'confirmation') {
                $filteredOrders = $orders->filter(function($order) {
                    return $order->status === 'pending' && $order->payment_proof;
                });
            } elseif(request('status') === 'processing') {
                $filteredOrders = $orders->filter(function($order) {
                    return $order->status === 'processing';
                });
            } elseif(request('status') === 'completed') {
                $filteredOrders = $orders->filter(function($order) {
                    return $order->status === 'completed';
                });
            } elseif(request('status') === 'rejected') {
                $filteredOrders = $orders->filter(function($order) {
                    return $order->status === 'rejected';
                });
            } else {
                $filteredOrders = $orders->filter(function($order) {
                    return $order->status !== 'pending' || ($order->status === 'pending' && $order->payment_proof);
                });
            }
            $filteredOrders = $filteredOrders->sortByDesc('id');
        @endphp

        @if($filteredOrders->count() > 0)
            <div class="orders-carousel relative w-full">
                <div class="carousel-container">
                    <div class="carousel-track">
                        @foreach($filteredOrders->chunk(4) as $chunk)
                            <div class="carousel-page">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 px-4">
                                    @foreach($chunk as $order)
                                        <div class="w-full">
                                            <!-- Paper Style Card -->
                                            <div class="bg-white shadow-md relative w-full max-w-md mx-auto transform hover:-translate-y-1 transition-transform duration-200"
                                                :class="{'cursor-pointer': deleteMode}"
                                                @click="deleteMode && handleCardClick($event, '{{ $order->status }}', {{ $order->id }})">                                                <!-- Paper lines effect -->
                                                <div class="absolute inset-0 pointer-events-none" style="z-index: 1;">
                                                    <div class="w-full h-full" style="background-image: repeating-linear-gradient(transparent, transparent 27px, #e5e7eb 28px);"></div>
                                                </div>

                                                <!-- Paper border effect -->
                                                <div class="absolute inset-0 border border-gray-200 pointer-events-none" style="z-index: 1;"></div>

                                                <!-- Binder holes -->
                                                <div class="absolute left-4 top-0 bottom-0 flex flex-col justify-evenly" style="z-index: 2;">
                                                    <div class="w-3 h-3 rounded-full bg-red-800"></div>
                                                    <div class="w-3 h-3 rounded-full bg-red-800"></div>
                                                    <div class="w-3 h-3 rounded-full bg-red-800"></div>
                                                </div>

                                                <!-- Order Content -->
                                                <div class="p-4 sm:p-6 relative" style="z-index: 2;">
                                                    <!-- Order Header with Checkbox -->
<div class="flex items-center justify-between mb-4 flex-wrap gap-2">
    <div class="flex items-center gap-2">
        <template x-if="deleteMode">
            <div class="relative z-10">
                <input type="checkbox" 
                    class="sr-only"
                    id="order-{{ $order->id }}"
                    value="{{ $order->id }}"
                    x-model="selectedOrders"
                    :disabled="!isOrderDeletable('{{ $order->status }}')"
                    @click="handleOrderSelection($event, '{{ $order->status }}')">
                <label for="order-{{ $order->id }}"
                    class="w-6 h-6 rounded flex items-center justify-center cursor-pointer transition-colors"
                    :class="[
                        selectedOrders.includes('{{ $order->id }}') ? 'bg-red-500' : 'bg-gray-200',
                        !isOrderDeletable('{{ $order->status }}') ? 'opacity-50 cursor-not-allowed' : ''
                    ]">
                    <svg class="w-4 h-4 text-white" 
                            x-show="selectedOrders.includes({{ $order->id }})"
                            xmlns="http://www.w3.org/2000/svg" 
                            viewBox="0 0 20 20" 
                            fill="currentColor">
                        <path fill-rule="evenodd" 
                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" 
                                clip-rule="evenodd" />
                    </svg>
                </label>
            </div>
        </template>
        <h3 class="font-['Kalam'] text-lg sm:text-xl">Order #{{ $order->id }}</h3>
    </div>
    
    <div class="flex justify-center w-full sm:w-auto">                                                     
        <span class="px-3 py-1 rounded-full text-sm font-['Kalam'] 
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

                                                    <!-- Order Details -->
                                                    <div class="space-y-3 pl-4">
                                                        <!-- Customer Name -->
                                                        <div class="flex items-center gap-2">
                                                            <span class="font-['Kalam'] text-gray-700">Customer:</span>
                                                            <strong><span class="font-['Kalam'] text-gray-900">{{ $order->user->name }}</span></strong>
                                                        </div>

                                                        <!-- Spice Level -->
<div class="flex flex-col gap-1">
    <span class="font-['Kalam'] text-gray-700">Tingkat Kepedasan:</span>
    <div class="flex items-center gap-2">
        <div class="flex gap-1 mb-5">
            @for($i = 0; $i < min($order->spice_level, 5); $i++)
                <img src="{{ asset('images/chilli.png') }}" class="h-5 w-5" alt="chili">
            @endfor
        </div>
        <span class="font-['Kalam'] text-sm">
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
        </span>
    </div>
</div>
                                                        <!-- Consistency -->
                                                        <div class="flex items-center gap-2">
                                                            <span class="font-['Kalam'] text-gray-700">Tingkat Kematangan:</span>
                                                            <span class="capitalize font-['Kalam'] bg-[#90B77D]/20 px-3 py-1 rounded-full text-sm">
                                                                {{ $order->consistency }}
                                                            </span>
                                                        </div>

                                                        <!-- Toppings -->
                                                        <div>
                                                            <span class="font-['Kalam'] text-gray-700">Topping:</span>
                                                            <div class="flex flex-wrap gap-2 mt-1 mb-10">
                                                                @foreach($order->toppings as $topping)
                                                                    <span class="bg-[#D68C45]/20 px-3 py-1 rounded-full text-sm font-['Kalam']">
                                                                        {{ $topping->name }}
                                                                        </span>
                                                                @endforeach
                                                            </div>
                                                        </div>

                                                        <!-- Total Price -->
                                                        <div class="mt-4 text-right">
                                                            <span class="font-['Kalam'] text-lg">Total: 
                                                                <span class="bg-[#90B77D] text-white px-4 py-1 rounded-full">
                                                                    Rp {{ number_format($order->total_price) }}
                                                                </span>
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <!-- View Details Button -->
                                                    <div class="mt-4 flex justify-end">
                                                        <a href="{{ route('admin.orders.view', $order) }}" 
                                                           class="bg-[#D68C45] hover:bg-[#D68C45]/90 text-white px-4 py-2 rounded-full font-['Kalam'] text-sm transition-colors">
                                                            View Details
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                
                @if($filteredOrders->count() > 4)
                    <button type="button" 
                            class="carousel-prev absolute left-2 top-1/2 -translate-y-1/2 bg-[#D68C45] hover:bg-[#D68C45]/80 text-white p-2 rounded-full transition-colors hidden">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </button>
                    <button type="button" 
                            class="carousel-next absolute right-2 top-1/2 -translate-y-1/2 bg-[#D68C45] hover:bg-[#D68C45]/80 text-white p-2 rounded-full transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>
                @endif
            </div>
        @else
            <div class="text-center py-8">
                <p class="text-white font-['Kalam'] text-xl">Belum ada pesanan</p>
            </div>
        @endif
    </div>

    <!-- Delete Confirmation Modal -->
    <div x-show="showDeleteModal" 
         class="fixed inset-0 z-50 overflow-y-auto"
         x-cloak
         @keydown.escape.window="showDeleteModal = false">
        <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" @click="showDeleteModal = false"></div>
        
        <div class="relative min-h-screen flex items-center justify-center p-4">
            <div class="relative bg-white rounded-2xl w-full max-w-md p-6" @click.stop>
                <div class="text-center">
                    <div class="w-12 h-12 rounded-full bg-red-100 mx-auto mb-4 flex items-center justify-center">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-['Kalam'] font-bold mb-2">Konfirmasi Hapus</h3>
                    <p class="text-gray-600">Apakah Anda yakin ingin menghapus <span x-text="selectedOrders.length"></span> orderan yang dipilih? Tindakan ini tidak dapat dibatalkan.</p>
                </div>
                
                <div class="mt-6 flex justify-center gap-3">
                    <button @click="cancelDelete"
                            class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition-colors font-['Kalam']">
                        Tidak
                    </button>
                    <button @click="deleteOrders"
                            class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition-colors font-['Kalam']">
                        Ya, Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>

[x-cloak] {
    display: none !important;
}

.carousel-container {
    overflow: hidden;
    width: 100%;
    position: relative;
}

.carousel-track {
    display: flex;
    transition: transform 0.3s ease-out;
    width: 100%;
    touch-action: pan-y pinch-zoom;
    cursor: grab;
}

.carousel-track:active {
    cursor: grabbing;
}

/* Prevent text selection during swipe */
.carousel-track * {
    user-select: none;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
}

.carousel-page {
    min-width: 100%;
    flex: 0 0 100%;
    flex-shrink: 0;
}

.carousel-prev,
.carousel-next {
    position: absolute;
    top: 54%;
    transform: translateY(-50%);
    z-index: 20;
}

.carousel-prev {
    left: 1rem;
}

.carousel-next {
    right: 1rem;
}

.min-h-screen {
    background-color: #991B1B;
}

main {
    background-color: #991B1B;
}

/* Checkbox styles */
.checkbox-custom {
    opacity: 0;
    position: absolute;
}

.checkbox-custom-label {
    position: relative;
    cursor: pointer;
}

.checkbox-custom:disabled + .checkbox-custom-label {
    cursor: not-allowed;
    opacity: 0.5;
}

/* Toast notification styles */
.toast {
    position: fixed;
    bottom: 1rem;
    right: 1rem;
    padding: 1rem;
    border-radius: 0.5rem;
    color: white;
    z-index: 50;
    animation: toast-in-right 0.7s;
}

.toast-error {
    background-color: #EF4444;
}

.toast-success {
    background-color: #10B981;
}

@keyframes toast-in-right {
    from {
        transform: translateX(100%);
    }
    to {
        transform: translateX(0);
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('orderManager', () => ({
    deleteMode: false,
    showDeleteModal: false,
    selectedOrders: [],
    
    init() {
        this.initCarousel();
    },

    toggleDeleteMode() {
        this.deleteMode = !this.deleteMode;
        if (!this.deleteMode) {
            this.selectedOrders = [];
        }
    },

    isOrderDeletable(status) {
        return ['completed', 'cancelled', 'rejected'].includes(status);
    },

    handleOrderSelection(event, status) {
        if (!this.isOrderDeletable(status)) {
            event.preventDefault();
            this.showToast('Orderan ini tidak dapat dihapus', 'error');
            return;
        }
    },

    // Tambahkan fungsi confirmDeleteSelected
    confirmDeleteSelected() {
        if (this.selectedOrders.length === 0) {
            this.showToast('Pilih orderan yang akan dihapus', 'error');
            return;
        }
        this.showDeleteModal = true;
    },

    cancelDelete() {
        this.showDeleteModal = false;
        this.deleteMode = false;
        this.selectedOrders = [];
    },

    async deleteOrders() {
    try {
        // Tambahkan csrf token dari meta tag
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        const response = await fetch('/admin/orders/delete-multiple', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json' // Tambahkan header Accept
            },
            body: JSON.stringify({
                order_ids: this.selectedOrders
            })
        });

        // Cek tipe konten response
        const contentType = response.headers.get("content-type");
        if (contentType && contentType.indexOf("application/json") !== -1) {
            const result = await response.json();
            
            if (response.ok) {
                this.showToast('Orderan berhasil dihapus', 'success');
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            } else {
                throw new Error(result.message || 'Gagal menghapus orderan');
            }
        } else {
            // Jika bukan JSON, ambil text saja
            const text = await response.text();
            throw new Error('Response bukan dalam format JSON');
        }
    } catch (error) {
        console.error('Error:', error);
        this.showToast(error.message || 'Gagal menghapus orderan', 'error');
    } finally {
        this.showDeleteModal = false;
        this.deleteMode = false;
        this.selectedOrders = [];
    }
},

    showToast(message, type = 'success') {
        const toast = document.createElement('div');
        toast.className = `toast toast-${type}`;
        toast.textContent = message;
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.remove();
        }, 3000);
    },

    handleCardClick(event, status, orderId) {
    // Jika yang diklik adalah link View Details atau checkbox, abaikan
    if (event.target.closest('a') || event.target.closest('input[type="checkbox"]')) {
        return;
    }

    // Cek apakah order bisa dihapus
    if (!this.isOrderDeletable(status)) {
        this.showToast('Orderan ini tidak dapat dihapus', 'error');
        return;
    }

    // Toggle selection
    if (this.selectedOrders.includes(orderId.toString())) {
        this.selectedOrders = this.selectedOrders.filter(id => id !== orderId.toString());
    } else {
        this.selectedOrders.push(orderId.toString());
    }
},

        initCarousel() {
            const track = document.querySelector('.carousel-track');
            const pages = Array.from(document.querySelectorAll('.carousel-page'));
            const prevBtn = document.querySelector('.carousel-prev');
            const nextBtn = document.querySelector('.carousel-next');
            
            if (!track || !prevBtn || !nextBtn || pages.length === 0) return;
            
            let currentPage = 0;
            let startX = 0;
            let currentX = 0;
            let isDragging = false;
            const threshold = 50; // Minimum swipe distance untuk trigger page change
            
            function updateCarousel(animate = true) {
                if (animate) {
                    track.style.transition = 'transform 0.3s ease-out';
                } else {
                    track.style.transition = 'none';
                }
                track.style.transform = `translateX(-${currentPage * 100}%)`;
                prevBtn.classList.toggle('hidden', currentPage === 0);
                nextBtn.classList.toggle('hidden', currentPage === pages.length - 1);
            }

            // Touch Events
            track.addEventListener('touchstart', (e) => {
                if (e.touches.length > 1) return; // Ignore multi-touch
                isDragging = true;
                startX = e.touches[0].clientX;
                currentX = startX;
                track.style.transition = 'none';
            }, { passive: true });

            track.addEventListener('touchmove', (e) => {
                if (!isDragging) return;
                currentX = e.touches[0].clientX;
                const diff = currentX - startX;
                const trackWidth = track.offsetWidth;
                const percentMove = (diff / trackWidth) * 100;
                const currentOffset = -(currentPage * 100);
                
                // Tambah resistance di ujung carousel
                if (
                    (currentPage === 0 && diff > 0) || 
                    (currentPage === pages.length - 1 && diff < 0)
                ) {
                    track.style.transform = `translateX(${currentOffset + (percentMove / 2)}%)`;
                } else {
                    track.style.transform = `translateX(${currentOffset + percentMove}%)`;
                }
            }, { passive: true });

            track.addEventListener('touchend', (e) => {
                if (!isDragging) return;
                isDragging = false;
                
                const diff = currentX - startX;
                const trackWidth = track.offsetWidth;
                
                if (Math.abs(diff) > threshold) {
                    if (diff > 0 && currentPage > 0) {
                        currentPage--;
                    } else if (diff < 0 && currentPage < pages.length - 1) {
                        currentPage++;
                    }
                }
                
                updateCarousel(true);
            });

            // Mouse Events (optional, untuk desktop)
            track.addEventListener('mousedown', (e) => {
                isDragging = true;
                startX = e.clientX;
                currentX = startX;
                track.style.transition = 'none';
                track.style.cursor = 'grabbing';
                
                // Prevent text selection while dragging
                e.preventDefault();
            });

            window.addEventListener('mousemove', (e) => {
                if (!isDragging) return;
                currentX = e.clientX;
                const diff = currentX - startX;
                const trackWidth = track.offsetWidth;
                const percentMove = (diff / trackWidth) * 100;
                const currentOffset = -(currentPage * 100);
                
                if (
                    (currentPage === 0 && diff > 0) || 
                    (currentPage === pages.length - 1 && diff < 0)
                ) {
                    track.style.transform = `translateX(${currentOffset + (percentMove / 2)}%)`;
                } else {
                    track.style.transform = `translateX(${currentOffset + percentMove}%)`;
                }
            });

            window.addEventListener('mouseup', () => {
                if (!isDragging) return;
                isDragging = false;
                track.style.cursor = '';
                
                const diff = currentX - startX;
                if (Math.abs(diff) > threshold) {
                    if (diff > 0 && currentPage > 0) {
                        currentPage--;
                    } else if (diff < 0 && currentPage < pages.length - 1) {
                        currentPage++;
                    }
                }
                
                updateCarousel(true);
            });

            // Button click events
            nextBtn.addEventListener('click', () => {
                if (currentPage < pages.length - 1) {
                    currentPage++;
                    updateCarousel();
                }
            });
            
            prevBtn.addEventListener('click', () => {
                if (currentPage > 0) {
                    currentPage--;
                    updateCarousel();
                }
            });
            
            // Initial setup
            updateCarousel();
        }
    }));
});
</script>
@endpush

@endsection