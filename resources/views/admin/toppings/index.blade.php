@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-red-800 pb-12" 
     x-data="toppingManager">
    <!-- Title -->
    <div class="text-center py-4 sm:py-6 md:py-8">
        <div class="inline-block bg-[#D68C45] px-6 sm:px-8 md:px-12 py-2 sm:py-3 md:py-4 rounded-lg transform -rotate-2">
            <h1 class="text-xl sm:text-2xl md:text-3xl font-['Kalam'] font-bold text-white italic">Manage Toppings</h1>
            <p class="text-sm sm:text-base font-['Kalam'] text-white/90 italic">Atur Ketersediaan Topping</p>
        </div>
    </div>

    <!-- Add New Topping Button -->
    <div class="w-full max-w-xl sm:max-w-2xl lg:max-w-6xl mx-auto px-3 sm:px-4 mb-8">
        <button @click="showAddModal = true" 
                class="bg-[#90B77D] hover:bg-[#90B77D]/90 text-white font-['Kalam'] px-6 py-2.5 rounded-full text-lg flex items-center gap-2 mx-auto shadow-md">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
            </svg>
            Tambah Topping Baru
        </button>
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
                        <div class="bg-[#FFE5E5] rounded-2xl overflow-hidden shadow-lg">
                            <!-- Image -->
                            <div class="relative h-32 sm:h-40">
                                <img src="{{ asset('storage/images/toppings/' . $topping->image) }}" 
                                     class="w-full h-full object-cover" 
                                     alt="{{ $topping->name }}">
                            </div>
                            
                            <!-- Content -->
                            <div class="p-3 sm:p-4">
                                <h4 class="font-['Kalam'] text-lg sm:text-xl text-center mb-2">{{ $topping->name }}</h4>
                                <p class="text-center text-sm sm:text-base bg-[#90B77D]/20 rounded-full py-1 mb-3" 
                                   style="font-family: 'Courgette', cursive;">
                                    Rp {{ number_format($topping->price) }}
                                </p>
                                
                                <!-- Stock Controls -->
                                <div class="flex items-center justify-center gap-2">
                                    <button class="w-8 h-8 rounded-full bg-red-500 text-white flex items-center justify-center hover:bg-red-600 transition-colors"
                                            @click="let currentStock = parseInt($el.parentElement.querySelector('.stock-input').value); updateStock({{ $topping->id }}, currentStock - 1)">−</button>
                                    <input type="number" 
                                           class="stock-input w-16 text-center rounded-full bg-white px-2 py-1"
                                           value="{{ $topping->stock }}"
                                           min="0"
                                           @change="updateStock({{ $topping->id }}, parseInt($event.target.value))">
                                    <button class="w-8 h-8 rounded-full bg-[#90B77D] text-white flex items-center justify-center hover:bg-[#90B77D]/90 transition-colors"
                                            @click="let currentStock = parseInt($el.parentElement.querySelector('.stock-input').value); updateStock({{ $topping->id }}, currentStock + 1)">+</button>
                                </div>
                                
                                <!-- Availability Toggle -->
                                <div class="flex items-center justify-center mb-3 mt-4">
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" 
                                               class="sr-only peer"
                                               x-model="toppings[{{ $topping->id }}].is_available"
                                               @change="toggleAvailability({{ $topping->id }}, $event.target.checked)">
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer 
                                                   peer-checked:after:translate-x-full peer-checked:after:border-white 
                                                   after:content-[''] after:absolute after:top-[2px] after:left-[2px] 
                                                   after:bg-white after:border-gray-300 after:border after:rounded-full 
                                                   after:h-5 after:w-5 after:transition-all peer-checked:bg-[#90B77D]">
                                        </div>
                                        <span class="ml-2 text-sm font-medium text-gray-700">Available</span>
                                    </label>
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex justify-center gap-2">
                                    <button @click="editTopping({{ $topping->id }})"
                                            class="px-3 py-1.5 bg-blue-500 hover:bg-blue-600 text-white rounded-full text-sm font-['Kalam'] transition-colors flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                        </svg>
                                        Edit
                                    </button>
                                    <button @click="confirmDelete({{ $topping->id }}, '{{ $topping->name }}')"
                                            class="px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white rounded-full text-sm font-['Kalam'] transition-colors flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                        Hapus
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Add Modal -->
    <div x-show="showAddModal" 
         class="fixed inset-0 z-50 overflow-y-auto"
         x-cloak
         x-transition>
        <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"></div>
        
        <div class="relative min-h-screen flex items-center justify-center p-4">
            <div class="relative bg-white rounded-2xl w-full max-w-md p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-['Kalam'] font-bold">Tambah Topping Baru</h3>
                    <button @click="showAddModal = false" class="text-gray-400 hover:text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                
                <form action="{{ route('admin.toppings.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nama Topping</label>
                            <input type="text" 
                                   name="name" 
                                   required
                                   class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-[#90B77D] focus:ring focus:ring-[#90B77D] focus:ring-opacity-50">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Kategori</label>
                            <select name="category_id" 
                                    required
                                    class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-[#90B77D] focus:ring focus:ring-[#90B77D] focus:ring-opacity-50">
                                @foreach($toppingCategories as $category)
                                    <option value="{{ $category->id }}">
                                        {{ $category->name }} (ID: {{ $category->id }})
                                    </option>
                                @endforeach
                            </select>
                            <!-- Debug info -->
                            @if(config('app.debug'))
                                <div class="mt-1 text-xs text-gray-500">
                                    Available categories: {{ $toppingCategories->pluck('name')->join(', ') }}
                                </div>
                            @endif
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Harga (Rp)</label>
                            <input type="number" 
                                   name="price" 
                                   required 
                                   min="0"
                                   class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-[#90B77D] focus:ring focus:ring-[#90B77D] focus:ring-opacity-50">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Stock Awal</label>
                            <input type="number" 
                                   name="stock" 
                                   required 
                                   min="0"
                                   class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-[#90B77D] focus:ring focus:ring-[#90B77D] focus:ring-opacity-50">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Gambar</label>
                            <input type="file" 
                                   name="image" 
                                   required 
                                   accept="image/*"
                                   class="mt-1 w-full">
                            <p class="mt-1 text-sm text-gray-500">Format: JPG, PNG. Maksimal 2MB</p>
                        </div>

                        <div class="flex items-center">
                            <input type="hidden" name="is_available" value="0">
                            <input type="checkbox" 
                                   name="is_available" 
                                   value="1"
                                   id="new-topping-available"
                                   class="rounded border-gray-300 text-[#90B77D] focus:border-[#90B77D] focus:ring focus:ring-[#90B77D] focus:ring-opacity-50">
                            <label for="new-topping-available" class="ml-2 text-sm text-gray-700">Tersedia</label>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end gap-3">
                        <button type="button" 
                                @click="showAddModal = false"
                                class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition-colors">
                            Batal
                        </button>
                        <button type="submit"
                                class="px-4 py-2 bg-[#90B77D] text-white rounded-md hover:bg-[#90B77D]/90 transition-colors">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div x-show="showEditModal" 
         class="fixed inset-0 z-50 overflow-y-auto"
         x-cloak
         x-transition>
        <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"></div>
        
        <div class="relative min-h-screen flex items-center justify-center p-4">
            <div class="relative bg-white rounded-2xl w-full max-w-md p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-['Kalam'] font-bold">Edit Topping</h3>
                    <button @click="showEditModal = false" class="text-gray-400 hover:text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                
                <form :action="'/admin/toppings/' + editingToppingId" 
                      method="POST" 
                      enctype="multipart/form-data"
                      @submit.prevent="submitEdit($event)">
                    @csrf
                    @method('PUT')
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nama Topping</label>
                            <input type="text" 
                                   name="name" 
                                   required
                                   :value="editingTopping.name"
                                   class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-[#90B77D] focus:ring focus:ring-[#90B77D] focus:ring-opacity-50">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Kategori</label>
                            <select name="category_id" 
                                    required
                                    x-model="editingTopping.category_id"
                                    class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-[#90B77D] focus:ring focus:ring-[#90B77D] focus:ring-opacity-50">
                                @foreach($toppingCategories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Stock</label>
                            <input type="number" 
                                   name="stock" 
                                   required 
                                   min="0"
                                   :value="editingTopping.stock"
                                   class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-[#90B77D] focus:ring focus:ring-[#90B77D] focus:ring-opacity-50">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Harga (Rp)</label>
                            <input type="number" 
                                   name="price" 
                                   required 
                                   min="0"
                                   :value="editingTopping.price"
                                   class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-[#90B77D] focus:ring focus:ring-[#90B77D] focus:ring-opacity-50">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Gambar Saat Ini</label>
                            <img :src="editingTopping.image_url" class="h-32 w-32 object-cover rounded-lg mt-1">
                            <input type="file" 
                                   name="image" 
                                   accept="image/*"
                                   class="mt-2 w-full">
                            <p class="mt-1 text-sm text-gray-500">Kosongkan jika tidak ingin mengubah gambar</p>
                        </div>

                        <div class="flex items-center">
                            <input type="hidden" name="is_available" value="0">
                            <input type="checkbox" 
                                   name="is_available" 
                                   value="1"
                                   x-model="editingTopping.is_available"
                                   class="rounded border-gray-300 text-[#90B77D] focus:border-[#90B77D] focus:ring focus:ring-[#90B77D] focus:ring-opacity-50">
                            <label class="ml-2 text-sm text-gray-700">Tersedia</label>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end gap-3">
                        <button type="button" 
                                @click="showEditModal = false"
                                class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition-colors">
                            Batal
                        </button>
                        <button type="submit"
                                class="px-4 py-2 bg-[#90B77D] text-white rounded-md hover:bg-[#90B77D]/90 transition-colors">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div x-show="showDeleteModal" 
         class="fixed inset-0 z-50 overflow-y-auto"
         x-cloak
         x-transition>
        <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"></div>
        
        <div class="relative min-h-screen flex items-center justify-center p-4">
            <div class="relative bg-white rounded-2xl w-full max-w-sm p-6">
                <div class="text-center">
                    <div class="w-12 h-12 rounded-full bg-red-100 mx-auto mb-4 flex items-center justify-center">
                        <svg class="w-6 h-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-['Kalam'] font-bold mb-2">Konfirmasi Hapus</h3>
                    <p class="text-gray-600" x-text="'Apakah Anda yakin ingin menghapus topping ' + deletingToppingName + '? Tindakan ini tidak dapat dibatalkan.'"></p>
                </div>
                
                <div class="mt-6 flex justify-center gap-3">
                    <button @click="showDeleteModal = false"
                            class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition-colors">
                        Batal
                    </button>
                    <form :action="'/admin/toppings/' + deletingToppingId" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition-colors">
                            Hapus
                        </button>
                    </form>
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

    /* Hide scrollbar for Chrome, Safari and Opera */
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }

    /* Hide scrollbar for IE, Edge and Firefox */
    .scrollbar-hide {
        -ms-overflow-style: none;  /* IE and Edge */
        scrollbar-width: none;  /* Firefox */
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
        .carousel-prev,
        .carousel-next {
            width: 32px;
            height: 32px;
        }
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('toppingManager', () => ({
        showAddModal: false,
        showEditModal: false,
        showDeleteModal: false,
        editingToppingId: null,
        editingTopping: {
            name: '',
            category_id: '',
            price: 0,
            stock: 0,
            is_available: true,
            image_url: ''
        },
        deletingToppingId: null,
        deletingToppingName: '',
        toppings: @json($toppingCategories->pluck('toppings')->flatten()->keyBy('id')->map(function($topping) {
            return [
                'id' => $topping->id,
                'stock' => $topping->stock,
                'is_available' => $topping->is_available
            ];
        })),

        async editTopping(id) {
            try {
                const response = await fetch(`/admin/toppings/${id}/edit`);
                if (!response.ok) throw new Error('Network response was not ok');
                
                const data = await response.json();
                console.log('Edit data received:', data); // Debug log
                
                this.editingToppingId = id;
                this.editingTopping = {
                    name: data.name,
                    category_id: data.category_id,
                    price: data.price,
                    stock: data.stock,
                    is_available: data.is_available,
                    image_url: data.image_url
                };
                console.log('Editing topping state:', this.editingTopping); // Debug log
                this.showEditModal = true;
            } catch (error) {
                console.error('Error:', error);
                Alpine.store('toast').showToast('Gagal memuat data topping', 'error');
            }
        },

        confirmDelete(id, name) {
            this.deletingToppingId = id;
            this.deletingToppingName = name;
            this.showDeleteModal = true;
        },

        async updateStock(toppingId, newStock) {
            newStock = parseInt(newStock);
            if (newStock < 0 || isNaN(newStock)) return;
            
            try {
                const response = await fetch(`/admin/toppings/${toppingId}/stock`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ stock: newStock })
                });

                if (!response.ok) throw new Error('Network response was not ok');
                
                const data = await response.json();
                
                if (data.success) {
                    // Update input value
                    const input = document.querySelector(`[data-topping-id="${toppingId}"] .stock-input`);
                    if (input) {
                        input.value = data.stock;
                    }
                    
                    // Update local state
                    if (!this.toppings[toppingId]) {
                        this.toppings[toppingId] = {};
                    }
                    this.toppings[toppingId].stock = data.stock;
                    this.toppings[toppingId].is_available = data.is_available;
                    
                    Alpine.store('toast').showToast('Stock berhasil diupdate', 'success');
                }
            } catch (error) {
                console.error('Error:', error);
                Alpine.store('toast').showToast('Gagal mengupdate stock', 'error');
            }
        },

        async toggleAvailability(toppingId, isAvailable) {
            try {
                const response = await fetch(`/admin/toppings/${toppingId}/toggle-availability`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ is_available: isAvailable })
                });

                if (!response.ok) throw new Error('Network response was not ok');
                
                this.toppings[toppingId].is_available = isAvailable;
                Alpine.store('toast').showToast('Status ketersediaan berhasil diupdate', 'success');
            } catch (error) {
                console.error('Error:', error);
                Alpine.store('toast').showToast('Gagal mengupdate status ketersediaan', 'error');
                // Revert the toggle
                this.toppings[toppingId].is_available = !isAvailable;
            }
        },

        async submitEdit(event) {
            event.preventDefault();
            const form = event.target;
            const formData = new FormData(form);

            try {
                console.log('Submitting edit form...', {
                    url: form.action,
                    data: Object.fromEntries(formData)
                });

                const response = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: formData
                });

                const result = await response.json();
                console.log('Edit response:', result);

                if (!response.ok) {
                    throw new Error(result.message || 'Network response was not ok');
                }

                if (result.success) {
                    Alpine.store('toast').showToast('Berhasil menyimpan perubahan', 'success');
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    throw new Error(result.message || 'Failed to save changes');
                }
            } catch (error) {
                console.error('Error submitting form:', error);
                Alpine.store('toast').showToast(error.message || 'Gagal menyimpan perubahan', 'error');
            }
        },

        init() {
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

                    carousel.addEventListener('scroll', updateNavigation);
                    window.addEventListener('resize', updateNavigation);
                    updateNavigation();
                }
            });
        }
    }));
});
</script>
@endpush
@endsection