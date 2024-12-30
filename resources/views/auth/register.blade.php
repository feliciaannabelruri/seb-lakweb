@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center bg-red-800 overflow-hidden relative px-4 sm:px-6 pb-12" style="perspective: 1000px;">
    <!-- Logo -->
    <div class="mb-6 sm:mb-8 text-center" style="z-index: 10;" id="logo-container">
        <img 
            src="{{ asset('images/logo.png') }}" 
            alt="Seblak Mama DK" 
            class="h-[120px] sm:h-[160px] w-auto"
            style="filter: drop-shadow(0 0 4px rgba(0,0,0,0.2));"
        >
    </div>
    
    <!-- Card Register - Paper Style -->
    <div class="w-full max-w-[320px] sm:max-w-md" id="paper-card">
        <!-- Content area -->
        <div class="relative bg-white shadow-md">
            <!-- Paper lines effect -->
            <div class="absolute inset-0 pointer-events-none" style="z-index: 1;">
                <div class="w-full h-full" style="background-image: repeating-linear-gradient(transparent, transparent 27px, #e5e7eb 28px);"></div>
            </div>

            <!-- Paper border effect -->
            <div class="absolute inset-0 border border-gray-200 pointer-events-none" style="z-index: 1;"></div>

            <!-- Binder holes -->
            <div class="absolute left-4 sm:left-6 top-0 bottom-0 flex flex-col justify-evenly" style="z-index: 2;">
                <div class="w-3 h-3 sm:w-4 sm:h-4 rounded-full bg-red-800"></div>
                <div class="w-3 h-3 sm:w-4 sm:h-4 rounded-full bg-red-800"></div>
                <div class="w-3 h-3 sm:w-4 sm:h-4 rounded-full bg-red-800"></div>
                <div class="w-3 h-3 sm:w-4 sm:h-4 rounded-full bg-red-800"></div>
                <div class="w-3 h-3 sm:w-4 sm:h-4 rounded-full bg-red-800"></div>
            </div>

            <!-- Register Form Content -->
            <div class="px-8 sm:px-16 py-4 sm:py-6 relative" style="z-index: 3;">
                <div class="text-center mb-6 sm:mb-8">
                    <h2 class="text-xl sm:text-2xl font-['Kalam'] font-bold underline">Register Form</h2>
                </div>

                <form id="register-form" method="POST" action="{{ route('register') }}" class="space-y-4 sm:space-y-6">
                    @csrf
                    
                    <!-- Name Input -->
                    <div class="space-y-2">
                        <label for="name" class="block font-['Kalam'] text-lg sm:text-xl">Name :</label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               required 
                               placeholder="isi disini"
                               class="w-full py-1.5 sm:py-2 px-2 border-none bg-gray-50 focus:outline-none font-['Kalam'] text-base sm:text-xl placeholder-gray-400 relative"
                               value="{{ old('name') }}">
                        <div class="h-px bg-gray-300"></div>
                        @error('name')
                            <p class="text-red-500 text-xs sm:text-sm font-['Kalam']">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email Input -->
                    <div class="space-y-2">
                        <label for="email" class="block font-['Kalam'] text-lg sm:text-xl">Email :</label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               required 
                               placeholder="isi disini"
                               class="w-full py-1.5 sm:py-2 px-2 border-none bg-gray-50 focus:outline-none font-['Kalam'] text-base sm:text-xl placeholder-gray-400 relative"
                               value="{{ old('email') }}">
                        <div class="h-px bg-gray-300"></div>
                        @error('email')
                            <p class="text-red-500 text-xs sm:text-sm font-['Kalam']">{{ $message }}</p>
                        @enderror
                    </div>

                     <!-- Password Input -->
    <div class="space-y-2">
        <label for="password" class="block font-['Kalam'] text-lg sm:text-xl">Password :</label>
        <input type="password" 
               id="password" 
               name="password" 
               required 
               placeholder="isi disini"
               class="w-full py-1.5 sm:py-2 px-2 border-none bg-gray-50 focus:outline-none font-['Kalam'] text-base sm:text-xl placeholder-gray-400 relative">
        <div class="h-px bg-gray-300"></div>
        <p id="password-length-message" class="text-red-500 text-xs sm:text-sm font-['Kalam'] hidden">
            Password minimal harus 8 karakter
        </p>
        @error('password')
            <p class="text-red-500 text-xs sm:text-sm font-['Kalam']">{{ $message }}</p>
        @enderror
    </div>
                    <!-- Confirm Password Input -->
                    <div class="space-y-2">
                        <label for="password_confirmation" class="block font-['Kalam'] text-lg sm:text-xl">Confirm Password :</label>
                        <input type="password" 
                               id="password_confirmation" 
                               name="password_confirmation" 
                               required 
                               placeholder="isi disini"
                               class="w-full py-1.5 sm:py-2 px-2 border-none bg-gray-50 focus:outline-none font-['Kalam'] text-base sm:text-xl placeholder-gray-400 relative">
                        <div class="h-px bg-gray-300"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Buttons outside the paper -->
    <div class="mt-4 sm:mt-6 w-full max-w-[320px] sm:max-w-md px-4 sm:px-8 opacity-0" id="button-container">
        <button type="submit" 
                form="register-form"
                class="w-full bg-lime-400 hover:bg-lime-500 text-gray-800 font-bold py-2.5 sm:py-3 rounded-full transition duration-200 mb-3 sm:mb-4 text-sm sm:text-base">
            Register
        </button>
        <p class="text-center text-white font-['Kalam'] text-sm sm:text-base">
            already have an account? 
            <a href="{{ route('login') }}" class="text-yellow-400 hover:text-yellow-300 font-['Kalam']" id="to-login">
                login here
            </a>
        </p>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/CustomEase.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        // Add password validation
            const passwordInput = document.getElementById('password');
            const passwordMessage = document.getElementById('password-length-message');

            passwordInput.addEventListener('input', function() {
                if (this.value.length > 0 && this.value.length < 8) {
                    passwordMessage.classList.remove('hidden');
                } else {
                    passwordMessage.classList.add('hidden');
                }
            });
        
        // Set kondisi awal elemen
        gsap.set("#logo-container img", {
            opacity: 0,
            scale: 0.8,
            y: -30
        });

        gsap.set("#paper-card", {
            opacity: 0,
            y: -1000,
            rotationX: 45,
            rotationY: -15,
            rotationZ: 10,
            scale: 0.8,
        });

        gsap.set("#button-container", {
            opacity: 0,
            y: 20
        });

        // Timeline untuk animasi
        let mainTimeline = gsap.timeline();

        // Animasi utama
        mainTimeline
            .to("#paper-card", {
                duration: 2,
                opacity: 1,
                y: 0,
                rotationX: 0,
                rotationY: 0,
                rotationZ: 0,
                scale: 1,
                ease: "power2.inOut"
            })
            .to("#logo-container img", {
                duration: 1,
                opacity: 1,
                scale: 1,
                y: 0,
                ease: "power2.inOut"
            })
            .to("#button-container", {
                duration: 1,
                opacity: 1,
                y: 0,
                ease: "power2.out"
            });

        // Event listener untuk link login
        document.getElementById('to-login').addEventListener('click', function(e) {
            window.location.href = this.getAttribute('href');
        });
    });
</script>

<style>
    #paper-card {
        transform-style: preserve-3d;
        backface-visibility: hidden;
    }

    #paper-card > div {
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1),
                   0 2px 4px -1px rgba(0, 0, 0, 0.06);
        transition: all 0.2s ease;
        position: relative;
    }

    input:-webkit-autofill,
    input:-webkit-autofill:hover,
    input:-webkit-autofill:focus {
        -webkit-box-shadow: 0 0 0px 1000px #f9fafb inset;
        transition: background-color 5000s ease-in-out 0s;
    }

    #logo-container img {
        will-change: transform, opacity;
        backface-visibility: hidden;
        -webkit-backface-visibility: hidden;
        transform: translateZ(0);
        -webkit-transform: translateZ(0);
    }
</style>
@endsection