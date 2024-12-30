@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-red-800 pb-32" x-data="{ 
    showModal: false,
    submitForm() {
        const form = document.getElementById('orderForm');
        if (form) {
            form.submit();
        }
    }
}">
    <!-- Title -->
    <div class="text-center py-4 sm:py-6 md:py-8">
        <!-- Background kayu -->
        <div class="inline-block bg-[#D68C45] px-6 sm:px-8 md:px-12 py-2 sm:py-3 md:py-4 rounded-lg transform -rotate-2">
            <h1 class="text-xl sm:text-2xl md:text-3xl font-['Kalam'] font-bold text-white italic">Customize Your Seblak</h1>
            <p class="text-sm sm:text-base font-['Kalam'] text-white/90 italic">Buat Seblak Sesuai Seleramu!</p>
        </div>
    </div>

    <!-- Form Content -->
    <div class="w-full max-w-xl sm:max-w-2xl lg:max-w-6xl mx-auto px-3 sm:px-4">
        <form action="{{ route('orders.store') }}" method="POST" class="space-y-6 sm:space-y-8" id="orderForm">
            @csrf
            
            <!-- Tingkat Kepedasan -->
            <div class="text-white max-w-2xl mx-auto">
                <div class="flex items-center gap-2 mb-2 sm:mb-3">
                    <label class="font-['Kalam'] text-lg sm:text-xl italic">Tingkat Kepedasan :</label>
                    <div id="spice-icons" class="flex gap-1">
                        <!-- Icons will be populated by JavaScript -->
                    </div>
                </div>
                <div class="relative">
                    <select name="spice_level" id="spice-level"
                            class="w-full bg-[#FFE5E5] text-gray-800 px-4 sm:px-6 py-2 sm:py-3 rounded-full text-sm sm:text-base font-['Kalam'] italic
                            appearance-none cursor-pointer">
                        <option value="1">Level 1 - Tidak Pedas</option>
                        <option value="2">Level 2 - Sedang</option>
                        <option value="3">Level 3 - Pedas</option>
                        <option value="4">Level 4 - Sangat Pedas</option>
                        <option value="5">Level 5 - Extra Pedas</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-4 sm:pr-8 pointer-events-none">
                        <svg class="h-4 w-4 sm:h-5 sm:w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Tingkat Kematangan -->
            <div class="text-white max-w-2xl mx-auto" style="margin-bottom: 65px">
                <div class="flex items-center gap-2 mb-2 sm:mb-3">
                    <label class="font-['Kalam'] text-lg sm:text-xl italic">Tingkat Kematangan :</label>
                    <div id="cooking-icons" class="flex gap-1">
                        <!-- Icons will be populated by JavaScript -->
                    </div>
                </div>
                <div class="relative">
                    <select name="consistency" id="consistency-level"
                            class="w-full bg-[#FFE5E5] text-gray-800 px-4 sm:px-6 py-2 sm:py-3 rounded-full text-sm sm:text-base font-['Kalam'] italic
                            appearance-none cursor-pointer">
                        <option value="kuah">Kuah (Berkuah)</option>
                        <option value="nyemek">Nyemek (Sedikit Kuah)</option>
                        <option value="kering">Kering (Tanpa Kuah)</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-4 sm:pr-8 pointer-events-none">
                        <svg class="h-4 w-4 sm:h-5 sm:w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Pilih Topping Text -->
            <div class="text-center" style="margin-bottom: 30px">
                <div class="inline-block bg-[#3C1515] text-white px-6 sm:px-8 py-1.5 sm:py-2 rounded-full">
                    <span class="font-['Kalam'] text-lg sm:text-xl">Pilih Topping Yang Kamu Suka !</span>
                </div>
            </div>

            <!-- Topping Categories -->
            <div class="w-full max-w-xl sm:max-w-2xl lg:max-w-6xl mx-auto px-3 sm:px-4">
                @foreach($toppingCategories as $category)
                <div class="space-y-3 sm:space-y-4 mb-16">
                    <h3 class="text-center font-['Kalam'] text-xl sm:text-2xl text-white mb-6">{{ $category->name }} :</h3>
                    
                    <div class="relative mx-auto">
                        @if(count($category->toppings) > 4)
                        <button class="carousel-prev absolute left-0 top-1/2 -translate-y-1/2 w-8 h-8 rounded-full bg-white shadow-md flex items-center justify-center z-10 opacity-0 transition-opacity duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </button>
                        <button class="carousel-next absolute right-0 top-1/2 -translate-y-1/2 w-8 h-8 rounded-full bg-white shadow-md flex items-center justify-center z-10 opacity-0 transition-opacity duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>
                        @endif

                        <div class="carousel-items flex gap-3 sm:gap-4 overflow-x-auto snap-x snap-mandatory scrollbar-hide px-8 sm:px-12 
                            @if(count($category->toppings) <= 4) lg:justify-center @endif">
                            @foreach($category->toppings as $topping)
                            <div class="flex-none w-40 sm:w-56 snap-start" data-topping-id="{{ $topping->id }}">
                                <div class="relative bg-[#FFE5E5] rounded-2xl overflow-hidden shadow-lg">
                                    <!-- Image with Unavailable Overlay -->
                                    <div class="relative h-32 sm:h-40">
                                    <img src="{{ asset('storage/images/toppings/' . $topping->image) }}" 
     class="w-full h-full object-cover {{ (!$topping->is_available || $topping->stock <= 0) ? 'opacity-50' : '' }}" 
     alt="{{ $topping->name }}">
                                        
                                        <!-- Unavailable Overlay -->
                                        @if(!$topping->is_available || $topping->stock <= 0)
                                        <div class="absolute inset-0 flex items-center justify-center">
                                            <div class="bg-black/60 text-white px-3 py-1 rounded-full text-sm font-['Kalam']">
                                                Topping Saat Ini Tidak Tersedia
                                            </div>
                                        </div>
                                        @endif

                                        <!-- Checkmark -->
                                        <div class="absolute top-2 right-2 z-10">
                                            <div class="w-5 h-5 sm:w-6 sm:h-6 rounded-full bg-white transition-colors duration-200 peer-checked:bg-[#90B77D] flex items-center justify-center 
                                                {{ (!$topping->is_available || $topping->stock <= 0) ? 'opacity-50' : '' }}">
                                                <svg class="w-3 h-3 sm:w-4 sm:h-4 transition-colors duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                    <path d="M5 13l4 4L19 7" class="text-gray-300 peer-checked:text-white"/>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Info -->
                                    <div class="p-3 sm:p-4">
                                        <h4 class="font-['Kalam'] text-lg sm:text-xl text-center {{ (!$topping->is_available || $topping->stock <= 0) ? 'opacity-50' : '' }}">
                                            {{ $topping->name }}
                                        </h4>
                                        <p class="text-center text-sm sm:text-base bg-[#90B77D]/20 rounded-full py-1 {{ (!$topping->is_available || $topping->stock <= 0) ? 'opacity-50' : '' }}" 
                                           style="font-family: 'Courgette', cursive;" 
                                           data-price="{{ $topping->price }}">
                                            Rp {{ number_format($topping->price) }}
                                        </p>
                                    </div>

                                    <!-- Checkbox -->
                                    <input type="checkbox" 
                                           id="topping-{{ $topping->id }}" 
                                           name="toppings[]" 
                                           value="{{ $topping->id }}" 
                                           class="peer hidden"
                                           {{ (!$topping->is_available || $topping->stock <= 0) ? 'disabled' : '' }}>

                                    <!-- Label -->
                                    <label for="topping-{{ $topping->id }}" 
                                           class="absolute inset-0 cursor-pointer z-20 {{ (!$topping->is_available || $topping->stock <= 0) ? 'cursor-not-allowed' : '' }}">
                                    </label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </form>
    </div>

    <!-- Modal -->
    <div x-show="showModal" 
         class="fixed inset-0 z-[100] overflow-y-auto flex items-center justify-center min-h-screen" 
         style="display: none;">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-black bg-opacity-50"></div>
        
        <!-- Modal Content -->
        <div class="relative z-[101] bg-white rounded-2xl max-w-sm w-full mx-4 p-6">
            <div class="text-center mb-6">
                <h3 class="font-['Kalam'] text-xl text-gray-800">Kamu yakin nih mau pesan tanpa topping?</h3>
            </div>
            <div class="flex justify-center gap-4">
                <button type="button"
                        @click="
                            $event.preventDefault();
                            showModal = false;
                            submitForm();
                        " 
                        class="px-6 py-2 bg-[#90B77D] text-white rounded-full font-['Kalam'] hover:bg-[#90B77D]/90 transition-colors">
                    Ya
                </button>
                <button type="button"
                        @click="showModal = false" 
                        class="px-6 py-2 bg-[#ff4c4c] text-white rounded-full font-['Kalam'] hover:bg-[#ff4c4c]/90 transition-colors">
                    Pilih Topping
                </button>
            </div>
        </div>
    </div>

    <!-- Fixed Bottom Section -->
    <div id="bottom-section" class="fixed bottom-0 left-0 right-0 transition-transform duration-300 ease-in-out transform translate-y-0 z-40">
        <div class="bg-white rounded-t-3xl shadow-lg max-w-2xl mx-auto w-full px-3 sm:px-4 py-2 sm:py-3">
            <!-- Total Price -->
            <div class="text-center mb-2 sm:mb-3">
                <p class="font-['Kalam'] text-base sm:text-lg">
                    TOTAL BAYAR:
                    <span class="inline-block bg-[#90B77D] text-white px-3 sm:px-4 py-0.5 sm:py-1 rounded-full ml-2">
                        Rp <span id="total-price">15.000</span>
                    </span>
                </p>
            </div>

            <!-- Submit Button -->
            <button type="button" 
                    @click="
                    const toppings = document.querySelectorAll('input[name=\'toppings[]\']:checked');
                        if (toppings.length === 0) {
                            showModal = true;
                        } else {
                            submitForm();
                        }
                    "
                    class="w-full bg-[#90B77D] hover:bg-[#90B77D]/90 text-white font-['Kalam'] text-base sm:text-lg py-1.5 sm:py-2.5 rounded-full transition-colors duration-200">
                Pesan Sekarang
            </button>
        </div>
    </div>
</div>

@push('styles')
<style>
/* Hide scrollbar for Chrome, Safari and Opera */
.scrollbar-hide::-webkit-scrollbar {
    display: none;
}

/* Hide scrollbar for IE, Edge and Firefox */
.scrollbar-hide {
    -ms-overflow-style: none;  /* IE and Edge */
    scrollbar-width: none;  /* Firefox */
}

/* Bottom section styles */
.min-h-screen {
    padding-bottom: 120px;
}

#bottom-section {
    box-shadow: 0 -2px 4px -1px rgba(0, 0, 0, 0.06);
}

/* Carousel navigation buttons */
.carousel-prev,
.carousel-next {
    opacity: 0;
    transition: all 0.2s ease-in-out;
}

.carousel-prev:hover,
.carousel-next:hover {
    opacity: 1 !important;
    background-color: rgba(255, 255, 255, 0.9);
}

/* Mobile adjustments */
@media (max-width: 640px) {
    #bottom-section {
        margin-bottom: 60px;
    }
    
    .carousel-prev,
    .carousel-next {
        width: 32px;
        height: 32px;
    }
}

/* Update padding bottom untuk layar normal */
.min-h-screen {
    padding-bottom: 120px;
}

/* Update padding bottom untuk kategori terakhir */
.space-y-3:last-child {
    margin-bottom: 140px;
}

/* Update padding untuk layar mobile */
@media (max-width: 640px) {
    .min-h-screen {
        padding-bottom: 140px;
    }
    
    .space-y-3:last-child {
        margin-bottom: 160px;
    }
    
    #bottom-section {
        margin-bottom: 60px;
    }
}

/* Ensure carousel items don't get cut off */
.carousel-items {
    scroll-padding: 0 1rem;
    -webkit-overflow-scrolling: touch;
    scroll-snap-type: x mandatory;
    padding-bottom: 1rem; /* Prevent bottom shadow cut-off */
}

.flex-none {
    scroll-snap-align: start;
}
</style>
@endpush

@push('scripts')
<script src="//unpkg.com/alpinejs" defer></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Spice and cooking level elements
    const spiceLevelSelect = document.getElementById('spice-level');
    const consistencySelect = document.getElementById('consistency-level');
    const spiceIconsContainer = document.getElementById('spice-icons');
    const cookingIconsContainer = document.getElementById('cooking-icons');

    // Total price elements
    const basePrice = 15000;
    const totalElement = document.getElementById('total-price');

    // Icons
    const chiliIcon = `
        <img src="{{ asset('images/chilli.png') }}" class="h-8 w-8" alt="chili">
    `;
    const bowlIcon = `
        <img src="{{ asset('images/bowl.png') }}" class="h-8 w-8" alt="bowl">
    `;

    // Update spice icons
    function updateSpiceIcons(level) {
        spiceIconsContainer.innerHTML = '';
        for(let i = 1; i < level; i++) {
            spiceIconsContainer.innerHTML += chiliIcon;
        }
    }

    // Update cooking icons
    function updateCookingIcons(type) {
        cookingIconsContainer.innerHTML = '';
        let bowlImage = '';
        
        switch(type) {
            case 'kering':
                bowlImage = `<img src="{{ asset('images/bowl 2.png') }}" class="h-8 w-8" alt="bowl-kering">`;
                break;
            case 'nyemek':
                bowlImage = `<img src="{{ asset('images/bowl 1.png') }}" class="h-8 w-8" alt="bowl-nyemek">`;
                break;
            case 'kuah':
                bowlImage = `<img src="{{ asset('images/bowl.png') }}" class="h-8 w-8" alt="bowl-kuah">`;
                break;
        }
        
        cookingIconsContainer.innerHTML = bowlImage;
    }

    // Update total price
    function updateTotal() {
        let total = basePrice;
        
        document.querySelectorAll('input[type="checkbox"][name="toppings[]"]:checked').forEach(checkbox => {
            const priceElement = checkbox.closest('.flex-none').querySelector('p[data-price]');
            const price = parseInt(priceElement.dataset.price);
            if (!isNaN(price)) {
                total += price;
            }
        });
        
        totalElement.textContent = new Intl.NumberFormat('id-ID').format(total);
    }

    // Handle topping selection
    document.querySelectorAll('input[type="checkbox"][name="toppings[]"]').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const checkmarkBg = this.closest('.flex-none').querySelector('.rounded-full');
            const checkmarkPath = this.closest('.flex-none').querySelector('svg path');
            
            if (this.checked) {
                checkmarkBg.classList.remove('bg-white');
                checkmarkBg.classList.add('bg-[#90B77D]');
                checkmarkPath.classList.remove('text-gray-300');
                checkmarkPath.classList.add('text-white');
            } else {
                checkmarkBg.classList.remove('bg-[#90B77D]');
                checkmarkBg.classList.add('bg-white');
                checkmarkPath.classList.remove('text-white');
                checkmarkPath.classList.add('text-gray-300');
            }
            
            updateTotal();
        });
    });

    // Enhanced carousel navigation
    document.querySelectorAll('.carousel-items').forEach(carousel => {
        const container = carousel.parentElement;
        const prevBtn = container.querySelector('.carousel-prev');
        const nextBtn = container.querySelector('.carousel-next');
        
        if (prevBtn && nextBtn) {
            const scrollAmount = carousel.querySelector('.flex-none').offsetWidth + 16;
            
            // Tambahkan smooth scroll
            const smoothScroll = (amount) => {
                carousel.scrollBy({
                    left: amount,
                    behavior: 'smooth'
                });
            };
            
            prevBtn.addEventListener('click', () => smoothScroll(-scrollAmount));
            nextBtn.addEventListener('click', () => smoothScroll(scrollAmount));

            // Update navigation visibility
            const updateNavigation = () => {
                const isAtStart = carousel.scrollLeft <= 0;
                const isAtEnd = carousel.scrollLeft + carousel.clientWidth >= carousel.scrollWidth - 1;
                
                prevBtn.style.opacity = isAtStart ? '0' : '0.8';
                prevBtn.style.pointerEvents = isAtStart ? 'none' : 'auto';
                
                nextBtn.style.opacity = isAtEnd ? '0' : '0.8';
                nextBtn.style.pointerEvents = isAtEnd ? 'none' : 'auto';
            };

            // Add scroll event listener
            carousel.addEventListener('scroll', updateNavigation);
            
            // Update on window resize
            window.addEventListener('resize', updateNavigation);
            
            // Initial check
            updateNavigation();
        }
    });

    // Event listeners for spice and cooking level
    spiceLevelSelect.addEventListener('change', function() {
        updateSpiceIcons(parseInt(this.value));
    });

    consistencySelect.addEventListener('change', function() {
        updateCookingIcons(this.value);
    });

    // Bottom section scroll handling
    let lastScrollY = window.scrollY;
    const bottomSection = document.getElementById('bottom-section');
    let isScrolling;
    
    window.addEventListener('scroll', () => {
        const currentScrollY = window.scrollY;
        
        // Clear previous timeout
        window.clearTimeout(isScrolling);
        
        // Handle scroll direction
        if (currentScrollY > lastScrollY) {
            bottomSection.style.transform = 'translateY(100%)';
        } else {
            bottomSection.style.transform = 'translateY(0)';
        }
        
        lastScrollY = currentScrollY;
        
        // Show bottom section after scroll stops
        isScrolling = setTimeout(() => {
            bottomSection.style.transform = 'translateY(0)';
        }, 150);
    });

    // Initial updates
    updateSpiceIcons(parseInt(spiceLevelSelect.value));
    updateCookingIcons(consistencySelect.value);
    updateTotal();
});
</script>
@endpush
@endsection