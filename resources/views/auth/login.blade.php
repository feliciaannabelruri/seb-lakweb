@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center bg-red-800 overflow-hidden relative px-4 sm:px-6" style="perspective: 1000px;"
     x-data="forgotPassword">
    <!-- Floating Ingredients - Adjust sizes for mobile -->
    <div class="absolute inset-0 pointer-events-none">
        <!-- Cabai -->
        <img src="{{ asset('images/ingredients/chili.png') }}" class="absolute w-8 sm:w-12 h-8 sm:h-12 floating-ingredient" id="chili1" alt="">
        <img src="{{ asset('images/ingredients/chili.png') }}" class="absolute w-6 sm:w-10 h-6 sm:h-10 floating-ingredient" id="chili2" alt="">
        <img src="{{ asset('images/ingredients/chili.png') }}" class="absolute w-10 sm:w-14 h-10 sm:h-14 floating-ingredient" id="chili3" alt="">
        <img src="{{ asset('images/ingredients/chili.png') }}" class="absolute w-8 sm:w-12 h-8 sm:h-12 floating-ingredient" id="chili4" alt="">
        <img src="{{ asset('images/ingredients/chili.png') }}" class="absolute w-7 sm:w-11 h-7 sm:h-11 floating-ingredient" id="chili5" alt="">
        <img src="{{ asset('images/ingredients/chili.png') }}" class="absolute w-9 sm:w-13 h-9 sm:h-13 floating-ingredient" id="chili6" alt="">
        <img src="{{ asset('images/ingredients/chili.png') }}" class="absolute w-8 sm:w-12 h-8 sm:h-12 floating-ingredient" id="chili7" alt="">
        <img src="{{ asset('images/ingredients/chili.png') }}" class="absolute w-6 sm:w-10 h-6 sm:h-10 floating-ingredient" id="chili8" alt="">
        <img src="{{ asset('images/ingredients/chili.png') }}" class="absolute w-7 sm:w-11 h-7 sm:h-11 floating-ingredient" id="chili9" alt="">
        <img src="{{ asset('images/ingredients/chili.png') }}" class="absolute w-9 sm:w-13 h-9 sm:h-13 floating-ingredient" id="chili10" alt="">
        <img src="{{ asset('images/ingredients/chili.png') }}" class="absolute w-8 sm:w-12 h-8 sm:h-12 floating-ingredient" id="chili11" alt="">
        <img src="{{ asset('images/ingredients/chili.png') }}" class="absolute w-10 sm:w-14 h-10 sm:h-14 floating-ingredient" id="chili12" alt="">
        <img src="{{ asset('images/ingredients/chili.png') }}" class="absolute w-8 sm:w-12 h-8 sm:h-12 floating-ingredient" id="chili13" alt="">
        <img src="{{ asset('images/ingredients/chili.png') }}" class="absolute w-7 sm:w-11 h-7 sm:h-11 floating-ingredient" id="chili14" alt="">
        <img src="{{ asset('images/ingredients/chili.png') }}" class="absolute w-9 sm:w-13 h-9 sm:h-13 floating-ingredient" id="chili15" alt="">
        <img src="{{ asset('images/ingredients/chili.png') }}" class="absolute w-6 sm:w-10 h-6 sm:h-10 floating-ingredient" id="chili16" alt="">
        <img src="{{ asset('images/ingredients/chili.png') }}" class="absolute w-8 sm:w-12 h-8 sm:h-12 floating-ingredient" id="chili17" alt="">
        <img src="{{ asset('images/ingredients/chili.png') }}" class="absolute w-10 sm:w-14 h-10 sm:h-14 floating-ingredient" id="chili18" alt="">
        <img src="{{ asset('images/ingredients/chili.png') }}" class="absolute w-7 sm:w-11 h-7 sm:h-11 floating-ingredient" id="chili19" alt="">
        <img src="{{ asset('images/ingredients/chili.png') }}" class="absolute w-9 sm:w-13 h-9 sm:h-13 floating-ingredient" id="chili20" alt="">
        <img src="{{ asset('images/ingredients/chili.png') }}" class="absolute w-8 sm:w-12 h-8 sm:h-12 floating-ingredient" id="chili21" alt="">
        <img src="{{ asset('images/ingredients/chili.png') }}" class="absolute w-6 sm:w-10 h-6 sm:h-10 floating-ingredient" id="chili22" alt="">
        <img src="{{ asset('images/ingredients/chili.png') }}" class="absolute w-10 sm:w-14 h-10 sm:h-14 floating-ingredient" id="chili23" alt="">
        <img src="{{ asset('images/ingredients/chili.png') }}" class="absolute w-7 sm:w-11 h-7 sm:h-11 floating-ingredient" id="chili24" alt="">
        
        <!-- Bawang Putih -->
        <img src="{{ asset('images/ingredients/garlic.png') }}" class="absolute w-6 sm:w-10 h-6 sm:h-10 floating-ingredient" id="garlic1" alt="">
        <img src="{{ asset('images/ingredients/garlic.png') }}" class="absolute w-8 sm:w-12 h-8 sm:h-12 floating-ingredient" id="garlic2" alt="">
        <img src="{{ asset('images/ingredients/garlic.png') }}" class="absolute w-7 sm:w-11 h-7 sm:h-11 floating-ingredient" id="garlic3" alt="">
        <img src="{{ asset('images/ingredients/garlic.png') }}" class="absolute w-9 sm:w-13 h-9 sm:h-13 floating-ingredient" id="garlic4" alt="">
        <img src="{{ asset('images/ingredients/garlic.png') }}" class="absolute w-8 sm:w-12 h-8 sm:h-12 floating-ingredient" id="garlic5" alt="">
        <img src="{{ asset('images/ingredients/garlic.png') }}" class="absolute w-6 sm:w-10 h-6 sm:h-10 floating-ingredient" id="garlic6" alt="">
        <img src="{{ asset('images/ingredients/garlic.png') }}" class="absolute w-7 sm:w-11 h-7 sm:h-11 floating-ingredient" id="garlic7" alt="">
        <img src="{{ asset('images/ingredients/garlic.png') }}" class="absolute w-9 sm:w-13 h-9 sm:h-13 floating-ingredient" id="garlic8" alt="">
        <img src="{{ asset('images/ingredients/garlic.png') }}" class="absolute w-8 sm:w-12 h-8 sm:h-12 floating-ingredient" id="garlic9" alt="">
        <img src="{{ asset('images/ingredients/garlic.png') }}" class="absolute w-10 sm:w-14 h-10 sm:h-14 floating-ingredient" id="garlic10" alt="">
        <img src="{{ asset('images/ingredients/garlic.png') }}" class="absolute w-7 sm:w-11 h-7 sm:h-11 floating-ingredient" id="garlic11" alt="">
        <img src="{{ asset('images/ingredients/garlic.png') }}" class="absolute w-8 sm:w-12 h-8 sm:h-12 floating-ingredient" id="garlic12" alt="">
        <img src="{{ asset('images/ingredients/garlic.png') }}" class="absolute w-8 sm:w-12 h-8 sm:h-12 floating-ingredient" id="garlic13" alt="">
        <img src="{{ asset('images/ingredients/garlic.png') }}" class="absolute w-6 sm:w-10 h-6 sm:h-10 floating-ingredient" id="garlic14" alt="">
        <img src="{{ asset('images/ingredients/garlic.png') }}" class="absolute w-9 sm:w-13 h-9 sm:h-13 floating-ingredient" id="garlic15" alt="">
        <img src="{{ asset('images/ingredients/garlic.png') }}" class="absolute w-7 sm:w-11 h-7 sm:h-11 floating-ingredient" id="garlic16" alt="">
        <img src="{{ asset('images/ingredients/garlic.png') }}" class="absolute w-10 sm:w-14 h-10 sm:h-14 floating-ingredient" id="garlic17" alt="">
        <img src="{{ asset('images/ingredients/garlic.png') }}" class="absolute w-8 sm:w-12 h-8 sm:h-12 floating-ingredient" id="garlic18" alt="">
        <img src="{{ asset('images/ingredients/garlic.png') }}" class="absolute w-6 sm:w-10 h-6 sm:h-10 floating-ingredient" id="garlic19" alt="">
        <img src="{{ asset('images/ingredients/garlic.png') }}" class="absolute w-9 sm:w-13 h-9 sm:h-13 floating-ingredient" id="garlic20" alt="">
        <img src="{{ asset('images/ingredients/garlic.png') }}" class="absolute w-7 sm:w-11 h-7 sm:h-11 floating-ingredient" id="garlic21" alt="">
        <img src="{{ asset('images/ingredients/garlic.png') }}" class="absolute w-8 sm:w-12 h-8 sm:h-12 floating-ingredient" id="garlic22" alt="">
        <img src="{{ asset('images/ingredients/garlic.png') }}" class="absolute w-10 sm:w-14 h-10 sm:h-14 floating-ingredient" id="garlic23" alt="">
        <img src="{{ asset('images/ingredients/garlic.png') }}" class="absolute w-6 sm:w-10 h-6 sm:h-10 floating-ingredient" id="garlic24" alt="">
    </div>

    <!-- Judul - Responsive text size -->
    <div class="mb-6 sm:mb-8 text-center" style="z-index: 10;" id="logo-container">
        <img 
            src="{{ asset('images/logo.png') }}" 
            alt="Seblak Mama DK" 
            class="h-[120px] sm:h-[160px] w-auto"
            style="filter: drop-shadow(0 0 4px rgba(0,0,0,0.2));"
        >
    </div>
    
    <!-- Card Login - Paper Style -->
    <div class="w-full max-w-[320px] sm:max-w-md" id="paper-card">
        <!-- Content area -->
        <div class="relative bg-white shadow-md">
            <!-- Paper lines effect -->
            <div class="absolute inset-0 pointer-events-none" style="z-index: 1;">
                <div class="w-full h-full" style="background-image: repeating-linear-gradient(transparent, transparent 27px, #e5e7eb 28px);">
                </div>
            </div>

            <!-- Paper border effect -->
            <div class="absolute inset-0 border border-gray-200 pointer-events-none" style="z-index: 1;"></div>

            <!-- Binder holes di sisi kiri -->
            <div class="absolute left-4 sm:left-6 top-0 bottom-0 flex flex-col justify-evenly" style="z-index: 2;">
                <div class="w-3 h-3 sm:w-4 sm:h-4 rounded-full bg-red-800"></div>
                <div class="w-3 h-3 sm:w-4 sm:h-4 rounded-full bg-red-800"></div>
                <div class="w-3 h-3 sm:w-4 sm:h-4 rounded-full bg-red-800"></div>
                <div class="w-3 h-3 sm:w-4 sm:h-4 rounded-full bg-red-800"></div>
                <div class="w-3 h-3 sm:w-4 sm:h-4 rounded-full bg-red-800"></div>
            </div>

            <!-- Login Form Content -->
            <div class="px-8 sm:px-16 py-4 sm:py-6 relative" style="z-index: 3;">
                <!-- Login Form Title -->
                <div class="text-center mb-6 sm:mb-8">
                    <h2 class="text-xl sm:text-2xl font-['Kalam'] font-bold underline">Login Form</h2>
                </div>

                <form id="login-form" method="POST" action="{{ route('login') }}" class="space-y-4 sm:space-y-6">
                    @csrf
                    
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
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Ubah div forgot password -->
    <div class="text-center mt-2 opacity-0" id="forgot-password-container">
        <button type="button"
                @click="showForgotModal = true" 
                class="text-sm text-lime-400 hover:text-lime-300 font-['Kalam'] transition-colors">
            Forgot Password?
        </button>
    </div>

    <!-- Modal Forgot Password -->
    <div x-show="showForgotModal" 
         class="fixed inset-0 z-50 overflow-y-auto"
         x-cloak
         @keydown.escape.window="showForgotModal = false">
        <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" 
             @click="showForgotModal = false"></div>
        
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="bg-white rounded-2xl shadow-xl w-full max-w-md mx-auto relative"
                 @click.stop>
                <!-- Modal Content -->
                <div class="p-6">
                    <!-- Step 1: Get Token -->
                    <template x-if="step === 1">
                        <div>
                            <h3 class="text-xl font-['Kalam'] font-bold text-center mb-4">Get Reset Token</h3>
                            <form @submit.prevent="handleForgotPassword">
                                <div class="space-y-4">
                                    <div>
                                        <label class="block font-['Kalam'] text-sm mb-1">Email Address</label>
                                        <input type="email" 
                                               x-model="email"
                                               required
                                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-[#90B77D]"
                                               placeholder="Enter your email">
                                    </div>
                                    <button type="submit"
                                            class="w-full bg-[#90B77D] text-white py-2 rounded-md hover:bg-[#90B77D]/90 transition-colors font-['Kalam']">
                                        Get Reset Token
                                    </button>
                                </div>
                            </form>
                        </div>
                    </template>

                    <!-- Step 2: Show Token & Verify -->
                    <template x-if="step === 2">
                        <div>
                            <h3 class="text-xl font-['Kalam'] font-bold text-center mb-4">Reset Password</h3>
                            
                            <!-- Token Display Box -->
                            <div class="mb-6 p-4 bg-yellow-50 rounded-lg border border-yellow-200">
                                <p class="text-gray-700 font-['Kalam'] mb-2">Your reset token is:</p>
                                <p class="text-xl font-mono font-bold text-center bg-white p-2 rounded" x-text="token"></p>
                                <p class="text-sm text-gray-500 mt-2">Please use this token below to reset your password</p>
                            </div>

                            <form @submit.prevent="verifyToken">
                                <div class="space-y-4">
                                    <div>
                                        <label class="block font-['Kalam'] text-sm mb-1">Email</label>
                                        <input type="email" 
                                               x-model="verifyEmail"
                                               required
                                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-[#90B77D]"
                                               placeholder="Enter your email">
                                    </div>
                                    <div>
                                        <label class="block font-['Kalam'] text-sm mb-1">Token</label>
                                        <input type="text" 
                                               x-model="resetToken"
                                               required
                                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-[#90B77D]"
                                               placeholder="Enter reset token">
                                    </div>
                                    <button type="submit"
                                            class="w-full bg-[#90B77D] text-white py-2 rounded-md hover:bg-[#90B77D]/90 transition-colors font-['Kalam']">
                                        Verify Token
                                    </button>
                                </div>
                            </form>
                        </div>
                    </template>

                    <!-- Step 3: New Password -->
                    <template x-if="step === 3">
                        <div>
                            <h3 class="text-xl font-['Kalam'] font-bold text-center mb-4">Create New Password</h3>
                            <form @submit.prevent="resetPassword">
                                <div class="space-y-4">
                                    <div>
                                        <label class="block font-['Kalam'] text-sm mb-1">New Password</label>
                                        <input type="password" 
                                               x-model="newPassword"
                                               required
                                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-[#90B77D]"
                                               placeholder="Enter new password">
                                    </div>
                                    <div>
                                        <label class="block font-['Kalam'] text-sm mb-1">Confirm New Password</label>
                                        <input type="password" 
                                               x-model="confirmPassword"
                                               required
                                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-[#90B77D]"
                                               placeholder="Confirm new password">
                                    </div>
                                    <button type="submit"
                                            class="w-full bg-[#90B77D] text-white py-2 rounded-md hover:bg-[#90B77D]/90 transition-colors font-['Kalam']">
                                        Save New Password
                                    </button>
                                </div>
                            </form>
                        </div>
                    </template>

                    <!-- Message Display -->
                    <div x-show="message" 
                         class="mt-4 p-3 rounded-lg"
                         :class="isSuccess ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'">
                        <p class="text-center font-['Kalam']" x-text="message"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Buttons outside the paper -->
    <div class="mt-4 sm:mt-6 w-full max-w-[320px] sm:max-w-md px-4 sm:px-8 opacity-0" id="button-container">
        <button type="submit" 
                form="login-form"
                class="w-full bg-yellow-400 hover:bg-yellow-500 text-gray-800 font-bold py-2.5 sm:py-3 rounded-full transition duration-200 mb-3 sm:mb-4 text-sm sm:text-base">
            Login
        </button>
        <p class="text-center text-white font-['Kalam'] text-sm sm:text-base">
            don't have an account? 
            <a href="{{ route('register') }}" class="text-lime-400 hover:text-lime-300 font-['Kalam']">
                register here
            </a>
        </p>
    </div>
</div>

<!-- Tambahkan GSAP dan plugin yang diperlukan -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/CustomEase.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Set kondisi awal semua elemen
        gsap.set(".floating-ingredient", {
            opacity: 0,
            visibility: 'hidden',
            scale: 0.8
        });

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

        // Tambahkan initial state untuk forgot password
        gsap.set("#forgot-password-container", {
            opacity: 0,
            y: 20
        });

        const ingredients = document.querySelectorAll('.floating-ingredient');
        
        // Setup ingredients positions
        setupIngredientsPositions(ingredients);

        // Timeline untuk animasi utama
        let mainTimeline = gsap.timeline({
            onComplete: () => {
                setTimeout(() => {
                    startIngredientsAnimations(ingredients);
                }, 500);
            }
        });

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
            })
            // Tambahkan animasi untuk forgot password
            .to("#forgot-password-container", {
                duration: 0.8,
                opacity: 1,
                y: 0,
                ease: "power2.out"
            }, "-=0.5"); // Mulai sedikit lebih awal dari animasi sebelumnya

        // Fungsi untuk setup posisi awal ingredients
        function setupIngredientsPositions(ingredients) {
            const screenWidth = window.innerWidth;
            const screenHeight = window.innerHeight;
            const padding = 30; // Kurangi padding agar lebih memenuhi layar
            let positions = [];

            // Bagi layar menjadi grid yang lebih rapat
            const columns = 15; // Tambah jumlah kolom
            const rows = 10;    // Tambah jumlah baris
            const cellWidth = (screenWidth - (padding * 2)) / columns;
            const cellHeight = (screenHeight - (padding * 2)) / rows;

            // Generate posisi grid
            for(let row = 0; row < rows; row++) {
                for(let col = 0; col < columns; col++) {
                    const x = padding + (col * cellWidth) + (Math.random() * cellWidth * 0.5);
                    const y = padding + (row * cellHeight) + (Math.random() * cellHeight * 0.5);
                    
                    positions.push({
                        x: x,
                        y: y,
                        scale: gsap.utils.random(0.6, 0.8)
                    });
                }
            }

            // Acak posisi
            positions = positions.sort(() => Math.random() - 0.5);

            // Set posisi awal
            ingredients.forEach((ingredient, index) => {
                gsap.set(ingredient, {
                    x: positions[index % positions.length].x,
                    y: positions[index % positions.length].y,
                    rotation: Math.random() * 360,
                    visibility: 'visible',
                    opacity: 0,
                    scale: positions[index % positions.length].scale
                });
            });
        }

        // Update fungsi startIngredientsAnimations
        function startIngredientsAnimations(ingredients) {
            // Fade in ingredients
            gsap.to(".floating-ingredient", {
                    duration: 0.5,
                    opacity: 0.9,
                stagger: 0.02,
                    ease: "power2.out",
                onComplete: () => {
                    ingredients.forEach(startFloatingAnimation);
                }
            });

            // Add mouse interaction with throttle
            document.addEventListener('mousemove', throttle(moveIngredientsFromCursor, 16));
        }

        function startFloatingAnimation(ingredient) {
            const startX = gsap.getProperty(ingredient, "x");
            const startY = gsap.getProperty(ingredient, "y");
            
            // Single continuous animation
            gsap.to(ingredient, {
                duration: gsap.utils.random(8, 12),
                x: `+=${gsap.utils.random(-10, 10)}`,
                y: `+=${gsap.utils.random(-10, 10)}`,
                rotation: `+=${gsap.utils.random(-15, 15)}`,
                repeat: -1,
                yoyo: true,
                ease: "sine.inOut"
            });
        }

        // Throttle function untuk mengontrol frekuensi update
        function throttle(func, limit) {
            let inThrottle;
            return function(...args) {
                if (!inThrottle) {
                    func.apply(this, args);
                    inThrottle = true;
                    setTimeout(() => inThrottle = false, limit);
                }
            }
        }

        function moveIngredientsFromCursor(e) {
            const mouseX = e.clientX;
            const mouseY = e.clientY;
            const repelRadius = 100;
            const repelStrength = 30;
            const padding = 20;

            ingredients.forEach((ingredient) => {
                const rect = ingredient.getBoundingClientRect();
                const centerX = rect.left + rect.width / 2;
                const centerY = rect.top + rect.height / 2;
                
                const dx = centerX - mouseX;
                const dy = centerY - mouseY;
                const distance = Math.sqrt(dx * dx + dy * dy);
                
                if (distance < repelRadius) {
                    gsap.killTweensOf(ingredient); // Stop current animation
                    
                    const angle = Math.atan2(dy, dx);
                    const force = (repelRadius - distance) / repelRadius;
                    
                    let newX = centerX + Math.cos(angle) * force * repelStrength;
                    let newY = centerY + Math.sin(angle) * force * repelStrength;

                    // Boundary check
                    newX = Math.min(Math.max(newX, padding), window.innerWidth - padding);
                    newY = Math.min(Math.max(newY, padding), window.innerHeight - padding);

                    gsap.to(ingredient, {
                        duration: 0.8,
                        x: newX - rect.width / 2,
                        y: newY - rect.height / 2,
                        ease: "power2.out",
                        onComplete: () => {
                            startFloatingAnimation(ingredient);
                        }
                    });
                }
            });
        }
    });
</script>

<style>

[x-cloak] { 
        display: none !important;
    }
    
    #paper-card {
        transform-style: flat;
        backface-visibility: hidden;
    }

    #paper-card > div {
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1),
                   0 2px 4px -1px rgba(0, 0, 0, 0.06);
        transition: all 0.2s ease;
        position: relative;
    }

    #paper-card:hover > div {
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1),
                   0 4px 6px -2px rgba(0, 0, 0, 0.05);
        transform: translateY(-2px);
    }

    #paper-card:active > div {
        transform: translateY(0);
        box-shadow: 0 5px 10px -3px rgba(0, 0, 0, 0.1),
                   0 2px 4px -2px rgba(0, 0, 0, 0.05);
    }

    input:-webkit-autofill,
    input:-webkit-autofill:hover,
    input:-webkit-autofill:focus {
        -webkit-box-shadow: 0 0 0px 1000px #f9fafb inset;
        transition: background-color 5000s ease-in-out 0s;
    }

    .floating-ingredient {
        opacity: 0;
        visibility: hidden;
        filter: brightness(1) contrast(1.2);
        mix-blend-mode: overlay;
        pointer-events: none;
        position: absolute;
        z-index: 1;
    }

    @media (hover: none) {
        #paper-card:hover > div {
            transform: none;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1),
                       0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
    }

    #logo-container img {
        will-change: transform, opacity;
        backface-visibility: hidden;
        -webkit-backface-visibility: hidden;
        transform: translateZ(0);
        -webkit-transform: translateZ(0);
    }

    [x-cloak] {
        display: none !important;
    }
</style>

<!-- Tambahkan script Alpine.js untuk handle forgot password -->
@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('forgotPassword', () => ({
        showForgotModal: false,
        step: 1,
        email: '',
        verifyEmail: '',
        message: '',
        isSuccess: false,
        token: '',
        resetToken: '',
        newPassword: '',
        confirmPassword: '',

        async handleForgotPassword() {
            if (!this.email) {
                this.message = 'Please enter your email';
                this.isSuccess = false;
                return;
            }

            // Cek jika email adalah "admin@gmail.com"
    if (this.email === 'admin@gmail.com') {
        this.message = 'You are not allowed to reset the password for this email';
        this.isSuccess = false;
        return;
    }

            try {
                const response = await fetch('/forgot-password', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ email: this.email })
                });

                const data = await response.json();
                
                if (data.success) {
                    this.isSuccess = true;
                    this.token = data.token;
                    this.step = 2;
                    this.message = '';
                } else {
                    this.isSuccess = false;
                    this.message = data.message;
                }
            } catch (error) {
                console.error('Error:', error);
                this.isSuccess = false;
                this.message = 'An error occurred. Please try again.';
            }
        },

        async verifyToken() {
            if (this.verifyEmail !== this.email || this.resetToken !== this.token) {
                this.message = 'Invalid email or token';
                this.isSuccess = false;
                return;
            }
            
            this.step = 3;
            this.message = '';
        },

        async resetPassword() {
            if (this.newPassword !== this.confirmPassword) {
                this.message = 'Passwords do not match';
                this.isSuccess = false;
                return;
            }

            try {
                const response = await fetch('/reset-password', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ 
                        email: this.email,
                        token: this.token,
                        password: this.newPassword 
                    })
                });

                const data = await response.json();
                
                if (data.success) {
                    this.isSuccess = true;
                    this.message = 'Password has been reset successfully! You can now login.';
                    setTimeout(() => {
                        this.showForgotModal = false;
                        this.resetForm();
                    }, 2000);
                } else {
                    this.isSuccess = false;
                    this.message = data.message;
                }
            } catch (error) {
                this.isSuccess = false;
                this.message = 'Failed to reset password. Please try again.';
            }
        },

        resetForm() {
            this.step = 1;
            this.email = '';
            this.verifyEmail = '';
            this.message = '';
            this.isSuccess = false;
            this.token = '';
            this.resetToken = '';
            this.newPassword = '';
            this.confirmPassword = '';
        }
    }));
});
</script>
@endpush
@endsection