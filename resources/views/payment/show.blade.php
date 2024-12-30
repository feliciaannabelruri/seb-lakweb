@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-red-800 py-8">
    <div class="container mx-auto px-4">
        <!-- Title -->
        <div class="text-center mb-8">
            <div class="inline-block bg-[#D68C45] px-6 sm:px-8 md:px-12 py-2 sm:py-3 md:py-4 rounded-lg transform -rotate-2">
                <h1 class="text-xl sm:text-2xl md:text-3xl font-['Kalam'] font-bold text-white italic">Pembayaran</h1>
                <p class="text-sm sm:text-base font-['Kalam'] text-white/90 italic">Upload Bukti Pembayaran</p>
            </div>
        </div>

        <!-- Payment Card -->
        <div class="max-w-2xl mx-auto">
            <div class="bg-[#FFE5E5] rounded-2xl overflow-hidden shadow-lg">
                <!-- Total Amount -->
                <div class="bg-[#3C1515] p-6 text-center">
                    <h4 class="font-['Kalam'] text-lg sm:text-xl text-white mb-2">Total Pembayaran:</h4>
                    <div class="inline-block bg-[#90B77D] px-6 py-2 rounded-full">
                        <span class="font-['Kalam'] text-xl sm:text-2xl text-white">
                            Rp {{ number_format($order->total_price) }}
                        </span>
                    </div>
                </div>

                <!-- QR Code Section -->
                <div class="p-6 text-center">
                    <div class="bg-white p-4 rounded-xl inline-block mb-6">
                        <img src="{{ asset('images/qris.png') }}" alt="QR Code Payment" class="max-w-[250px] mx-auto">
                    </div>

                    <!-- Upload Form -->
                    <form action="{{ route('payment.proof', $order) }}" method="POST" enctype="multipart/form-data" id="paymentForm">
                        @csrf
                        <div class="space-y-4">
                            <div class="text-center">
                                <label class="font-['Kalam'] text-lg text-gray-800 block mb-2">Upload Bukti Pembayaran</label>
                                <input type="file" 
                                       name="payment_proof" 
                                       id="paymentProof"
                                       class="block w-full text-sm text-gray-500
                                              file:mr-4 file:py-2 file:px-4
                                              file:rounded-full file:border-0
                                              file:text-sm file:font-['Kalam']
                                              file:bg-[#90B77D] file:text-white
                                              hover:file:bg-[#90B77D]/90
                                              cursor-pointer"
                                       required>
                            </div>

                            <button type="button" 
                                    id="uploadButton"
                                    class="w-full bg-[#90B77D] hover:bg-[#90B77D]/90 text-white font-['Kalam'] text-base sm:text-lg py-2 px-6 rounded-full transition-colors duration-200">
                                Upload Bukti Pembayaran
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Box -->
    <div id="confirmationModal" class="fixed inset-0 z-50 overflow-y-auto hidden">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-black bg-opacity-50"></div>

        <!-- Modal Content -->
        <div class="relative min-h-screen flex items-center justify-center p-4">
            <div class="relative bg-white rounded-2xl max-w-md w-full p-6">
                <div class="text-center mb-6">
                    <h3 class="font-['Kalam'] text-xl text-gray-800">Konfirmasi Upload</h3>
                    <p class="font-['Kalam'] text-gray-600 mt-2">Pastikan bukti yang diupload sudah benar</p>
                </div>

                <div class="flex justify-center gap-3">
                    <button type="button"
                            id="cancelButton"
                            class="px-6 py-2 bg-gray-400 text-white rounded-full font-['Kalam'] hover:bg-gray-500 transition-colors">
                        Batal
                    </button>
                    <button type="button"
                            id="confirmButton"
                            class="px-6 py-2 bg-[#90B77D] text-white rounded-full font-['Kalam'] hover:bg-[#90B77D]/90 transition-colors">
                        Ya, Upload
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const uploadButton = document.getElementById('uploadButton');
    const confirmationModal = document.getElementById('confirmationModal');
    const cancelButton = document.getElementById('cancelButton');
    const confirmButton = document.getElementById('confirmButton');
    const paymentForm = document.getElementById('paymentForm');
    const fileInput = document.getElementById('paymentProof');

    uploadButton.addEventListener('click', function() {
        console.log('Upload button clicked');
        if (!fileInput.files.length) {
            alert("Silakan pilih file bukti pembayaran terlebih dahulu");
            return;
        }
        confirmationModal.classList.remove('hidden');
    });

    cancelButton.addEventListener('click', function() {
        confirmationModal.classList.add('hidden');
    });

    confirmButton.addEventListener('click', function() {
        paymentForm.submit();
    });
});
</script>
@endpush

@endsection