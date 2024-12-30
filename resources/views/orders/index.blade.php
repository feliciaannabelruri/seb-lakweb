@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-red-800 pb-12">
    <!-- Title -->
    <div class="text-center py-4 sm:py-6 md:py-8">
        <div class="inline-block bg-[#D68C45] px-6 sm:px-8 md:px-12 py-2 sm:py-3 md:py-4 rounded-lg transform -rotate-2">
            <h1 class="text-xl sm:text-2xl md:text-3xl font-['Kalam'] font-bold text-white italic">Pesanan Saya</h1>
            <p class="text-sm sm:text-base font-['Kalam'] text-white/90 italic">Daftar Pesanan Seblak Kamu</p>
        </div>
    </div>

    <!-- Orders Display -->
    <div class="w-full max-w-6xl mx-auto px-3 sm:px-4">
        @if($orders->count() > 0)
            <div class="orders-carousel relative w-full">
                <div class="carousel-container overflow-hidden">
                    <div class="carousel-track flex transition-transform duration-300">
                        @foreach($orders->chunk(4) as $orderChunk)
                            <div class="carousel-page w-full flex-shrink-0 px-4">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    @foreach($orderChunk as $order)
                                        <div class="w-full">
                                            <!-- Paper Style Card -->
                                            <div class="bg-white shadow-md relative w-full max-w-md mx-auto transform hover:-translate-y-1 transition-transform duration-200">
                                                <!-- Paper lines effect -->
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
                                                    <!-- Order Header -->
                                                    <div class="flex justify-between items-center mb-4 pl-1">
                                                        <h3 class="font-['Kalam'] text-lg sm:text-xl ">Order #{{ $order->id }}</h3>
                                                        <div class="flex justify-center">
                                                            <span class="px-3 py-1 rounded-full text-sm font-['Kalam'] text-center whitespace-nowrap
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
                                                                        @else
                                                                            bg-yellow-400 text-gray-800
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
                                                                        @else
                                                                            {{ ucfirst($order->status) }}
                                                                        @endif
                                                                        @break
                                                                    @default
                                                                        {{ ucfirst($order->status) }}
                                                                @endswitch
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <!-- Order Details dengan spacing yang lebih baik -->
                                                    <div class="space-y-4 pl-4">
                                                        <!-- Spice Level dengan layout yang lebih rapi -->
                                                        <div class="flex flex-col gap-1">
                                                            <span class="font-['Kalam'] text-gray-700">Tingkat Kepedasan:</span>
                                                            <div class="flex items-center gap-2">
                                                                <div class="flex gap-1">
                                                                    @for($i = 0; $i < $order->spice_level; $i++)
                                                                        <img src="{{ asset('images/chilli.png') }}" class="h-5 w-5" alt="chili">
                                                                    @endfor
                                                                </div>
                                                                <span class="font-['Kalam'] text-sm ml-2">
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

                                                        <!-- Consistency dengan spacing yang konsisten -->
                                                        <div class="flex items-center gap-2">
                                                            <span class="font-['Kalam'] text-gray-700">Tingkat Kematangan:</span>
                                                            <span class="capitalize font-['Kalam'] bg-[#90B77D]/20 px-3 py-1 rounded-full text-sm">
                                                                {{ $order->consistency }}
                                                            </span>
                                                        </div>

                                                        <!-- Toppings dengan layout yang lebih baik -->
                                                        <div>
                                                            <span class="font-['Kalam'] text-gray-700">Topping:</span>
                                                            <div class="flex flex-wrap gap-2 mt-2 mb-8">
                                                                @foreach($order->toppings as $topping)
                                                                    <span class="bg-[#D68C45]/20 px-3 py-1 rounded-full text-sm font-['Kalam']">
                                                                        {{ $topping->name }}
                                                                    </span>
                                                                @endforeach
                                                            </div>
                                                        </div>

                                                        <!-- Total Price dengan alignment yang lebih baik -->
                                                        <div class="mt-6 text-right">
                                                            <span class="font-['Kalam'] text-lg">Total: 
                                                                <span class="bg-[#90B77D] text-white px-4 py-1 rounded-full ml-2">
                                                                    Rp {{ number_format($order->total_price) }}
                                                                </span>
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <!-- Action Buttons dengan spacing yang konsisten -->
                                                    <div class="mt-6 flex justify-end gap-2">
                                                        @if($order->status === 'pending')
                                                            @if(!$order->payment_proof)
                                                                <a href="{{ route('payment.show', $order) }}" 
                                                                   class="bg-[#90B77D] hover:bg-[#90B77D]/90 text-white text-center px-4 py-2 rounded-full font-['Kalam'] text-sm transition-colors">
                                                                    Bayar Sekarang
                                                                </a>
                                                                <button type="button"
                                                                        data-modal-toggle="cancelModal{{ $order->id }}"
                                                                        class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-full font-['Kalam'] text-sm transition-colors">
                                                                    Batalkan Pesanan
                                                                </button>
                                                            @endif
                                                        @elseif($order->status === 'rejected')
                                                            <button type="button"
                                                                    data-modal-toggle="rejectReasonModal{{ $order->id }}"
                                                                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-full font-['Kalam'] text-sm transition-colors">
                                                                Lihat Alasan Penolakan
                                                            </button>
                                                        @endif
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
                
                <!-- Navigation Buttons -->
                @if($orders->count() > 4)
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

    <!-- Cancel Modals Container -->
    @foreach($orders as $order)
        @if($order->status === 'pending' && !$order->payment_proof)
            <div id="cancelModal{{ $order->id }}" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden" aria-modal="true" role="dialog">
                <div class="flex items-center justify-center min-h-screen p-4">
                    <div class="bg-white rounded-lg max-w-md w-full p-6">
                        <h3 class="text-xl font-['Kalam'] mb-4">Konfirmasi Pembatalan</h3>
                        <p class="font-['Kalam'] text-gray-600 mb-6">Apakah Anda yakin ingin membatalkan pesanan ini?</p>
                        <div class="flex justify-end gap-3">
                            <button type="button" 
                                    class="modal-close px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-full font-['Kalam'] transition-colors">
                                Batal
                            </button>
                            <form action="{{ route('orders.cancel', $order) }}" method="POST">
                                @csrf
                                @method('DELETE') 
                                <button type="submit"
                                        class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-full font-['Kalam'] transition-colors">
                                    Ya, Batalkan
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach

    <!-- Rejection Reason Modals -->
    @foreach($orders as $order)
        @if($order->status === 'rejected' && $order->rejection_reason)
            <div id="rejectReasonModal{{ $order->id }}" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden" aria-modal="true" role="dialog">
                <div class="flex items-center justify-center min-h-screen p-4">
                    <div class="bg-white rounded-lg max-w-md w-full p-6">
                        <h3 class="text-xl font-['Kalam'] mb-4">Alasan Penolakan Pesanan #{{ $order->id }}</h3>
                        <p class="font-['Kalam'] text-gray-600 mb-6">{{ $order->rejection_reason }}</p>
                        <div class="flex justify-end">
                            <button type="button" 
                                    class="modal-close px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-full font-['Kalam'] transition-colors">
                                Tutup
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
</div>

@push('styles')
<style>
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
    user-select: none;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
}

.carousel-track:active {
    cursor: grabbing;
}

/* Prevent text selection during swipe/drag */
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

/* Navigation buttons */
.carousel-prev,
.carousel-next {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    z-index: 20;
    opacity: 0.8;
    transition: opacity 0.2s;
}

.carousel-prev:hover,
.carousel-next:hover {
    opacity: 1;
}

.carousel-prev {
    left: 1rem;
}

.carousel-next {
    right: 1rem;
}

/* Paper card refinements */
.paper-card {
    position: relative;
    background: white;
    border-radius: 0.5rem;
    overflow: hidden;
}

/* Content spacing */
.order-content {
    padding-left: 2.5rem;
}

/* Responsive adjustments */
@media (max-width: 640px) {
    .order-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }
    
    .status-badge {
        align-self: flex-end;
    }
}
</style>
@endpush

@push('scripts')
<script>

document.addEventListener('DOMContentLoaded', function() {
    // Modal Toggle Function
    const modalToggleButtons = document.querySelectorAll('[data-modal-toggle]');
    modalToggleButtons.forEach(button => {
        button.addEventListener('click', () => {
            const modalId = button.getAttribute('data-modal-toggle');
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }
        });
    });

    // Modal Close Function
    const modalCloseButtons = document.querySelectorAll('.modal-close');
    modalCloseButtons.forEach(button => {
        button.addEventListener('click', () => {
            const modal = button.closest('.fixed');
            if (modal) {
                modal.classList.add('hidden');
                document.body.style.overflow = '';
            }
        });
    });

    // Close modal when clicking outside the modal content
    const modals = document.querySelectorAll('.fixed.inset-0');
    modals.forEach(modal => {
modal.addEventListener('click', (event) => {
if (event.target === modal) {
modal.classList.add('hidden');
document.body.style.overflow = '';
}
});
});
});
   
document.addEventListener('DOMContentLoaded', function() {
    initCarousel();
});

function initCarousel() {
    const track = document.querySelector('.carousel-track');
    const pages = Array.from(document.querySelectorAll('.carousel-page'));
    const prevBtn = document.querySelector('.carousel-prev');
    const nextBtn = document.querySelector('.carousel-next');
    
    if (!track || !prevBtn || !nextBtn || pages.length === 0) return;
    
    let currentPage = 0;
    let startX = 0;
    let currentX = 0;
    let isDragging = false;
    const threshold = 50;
    
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
        if (e.touches.length > 1) return;
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
        
        if ((currentPage === 0 && diff > 0) || (currentPage === pages.length - 1 && diff < 0)) {
            track.style.transform = `translateX(${currentOffset + (percentMove / 2)}%)`;
        } else {
            track.style.transform = `translateX(${currentOffset + percentMove}%)`;
        }
    }, { passive: true });

    track.addEventListener('touchend', (e) => {
        if (!isDragging) return;
        isDragging = false;
        
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

    // Button Events
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

    // Mouse Events untuk desktop
    track.addEventListener('mousedown', (e) => {
        isDragging = true;
        startX = e.clientX;
        currentX = startX;
        track.style.transition = 'none';
        track.style.cursor = 'grabbing';
        e.preventDefault(); // Prevent text selection
    });

    window.addEventListener('mousemove', (e) => {
        if (!isDragging) return;
        currentX = e.clientX;
        const diff = currentX - startX;
        const trackWidth = track.offsetWidth;
        const percentMove = (diff / trackWidth) * 100;
        const currentOffset = -(currentPage * 100);
        
        if ((currentPage === 0 && diff > 0) || (currentPage === pages.length - 1 && diff < 0)) {
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

    // Prevent context menu on drag
    track.addEventListener('contextmenu', (e) => {
        if (isDragging) {
            e.preventDefault();
        }
    });

    // Prevent text selection during drag
    track.addEventListener('selectstart', (e) => {
        if (isDragging) {
            e.preventDefault();
        }
    });
}
</script>
@endpush
@endsection