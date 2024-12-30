<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Kalam:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Courgette&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine Plugins -->
    <script defer src="https://unpkg.com/@alpinejs/focus@3.x.x/dist/cdn.min.js"></script>
    <!-- Alpine Core -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

</head>
<body>
    @if (!in_array(request()->route()->getName(), ['login', 'register']))
        <!-- Fixed Navbar -->
        <nav class="fixed top-0 left-0 right-0 bg-[#3C1515] z-50 shadow-lg">
            <div class="max-w-7xl mx-auto px-2 sm:px-4 lg:px-8">
                <div class="flex items-center justify-between h-16 sm:h-20">
                    <!-- Left Side - Logo -->
                    <div class="flex-shrink-0">
                        <a href="{{ route('menu') }}" class="block">
                            <img src="{{ asset('images/logo.png') }}" alt="Seblak Mama DK" 
                                 class="h-12 sm:h-16 md:h-18">
                        </a>
                    </div>

                    <!-- Desktop Navigation (hidden on mobile) -->
                    <div class="hidden sm:flex items-center space-x-4">
                        <a href="{{ route('menu') }}" 
                           class="block text-center {{ request()->routeIs('menu') ? 'bg-[#B05B3B]' : 'hover:bg-[#B05B3B]' }} 
                                  rounded-xl px-4 py-2 font-['Kalam'] text-base text-white 
                                  transition-all duration-200">
                            Menu
                        </a>

                        <a href="{{ route('orders.index') }}" 
                           class="block text-center {{ request()->routeIs('orders.index') ? 'bg-[#B05B3B]' : 'hover:bg-[#B05B3B]' }}
                                  rounded-xl px-4 py-2 font-['Kalam'] text-base text-white 
                                  transition-all duration-200">
                            My Order
                        </a>

                        <form action="{{ route('logout') }}" method="POST" class="inline-block" id="logout-form">
                            @csrf
                            <a href="#" 
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
                               class="flex items-center text-center bg-[#8C1A1A] hover:bg-[#701414] rounded-xl px-4 py-2 font-['Kalam'] text-base text-white transition-all duration-200">
                                <img src="{{ asset('images/logout.svg') }}" alt="Logout" 
                                     class="h-5 w-5 mr-1.5">
                                <span>Logout</span>
                            </a>
                        </form>
                    </div>

                    <!-- Mobile Menu Button -->
                    <button type="button" 
                            class="sm:hidden inline-flex items-center justify-center p-2 rounded-xl text-white hover:bg-[#B05B3B] transition-colors duration-200"
                            onclick="toggleMobileMenu()">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Navigation Menu (Slide Out) -->
            <div id="mobile-menu" 
                 class="fixed top-0 right-0 bottom-0 w-64 bg-[#3C1515] transform translate-x-full transition-transform duration-300 ease-in-out sm:hidden shadow-lg">
                <!-- Close Button -->
                <div class="flex justify-end p-4">
                    <button type="button" 
                            class="text-white hover:bg-[#B05B3B] rounded-xl p-2 transition-colors duration-200"
                            onclick="toggleMobileMenu()">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <!-- Mobile Menu Links -->
                <div class="flex flex-col space-y-4 px-4">
                    <a href="{{ route('menu') }}" 
                       class="text-center {{ request()->routeIs('menu') ? 'bg-[#B05B3B]' : 'hover:bg-[#B05B3B]' }} 
                              rounded-xl px-4 py-3 font-['Kalam'] text-base text-white 
                              transition-all duration-200">
                        Menu
                    </a>

                    <a href="{{ route('orders.index') }}" 
                       class="text-center {{ request()->routeIs('orders.index') ? 'bg-[#B05B3B]' : 'hover:bg-[#B05B3B]' }}
                              rounded-xl px-4 py-3 font-['Kalam'] text-base text-white 
                              transition-all duration-200">
                        My Order
                    </a>

                    <form action="{{ route('logout') }}" method="POST" class="block" id="mobile-logout-form">
                        @csrf
                        <a href="#" 
                           onclick="event.preventDefault(); document.getElementById('mobile-logout-form').submit();" 
                           class="flex items-center justify-center text-center bg-[#8C1A1A] hover:bg-[#701414] rounded-xl px-4 py-3 font-['Kalam'] text-base text-white transition-all duration-200">
                            <img src="{{ asset('images/logout.svg') }}" alt="Logout" 
                                 class="h-5 w-5 mr-1.5">
                            <span>Logout</span>
                        </a>
                    </form>
                </div>
            </div>
        </nav>

        <!-- Overlay for mobile menu -->
        <div id="mobile-menu-overlay"
             class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden transition-opacity duration-300 ease-in-out"
             onclick="toggleMobileMenu()">
        </div>

        <!-- Spacer to prevent content from hiding under fixed navbar -->
        <div class="h-16 sm:h-20"></div>
    @endif

    <main>
        @yield('content')
        @stack('scripts')
    </main>

    <!-- Mobile Menu JavaScript -->
    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            const overlay = document.getElementById('mobile-menu-overlay');
            
            // Toggle the menu
            menu.classList.toggle('translate-x-full');
            
            // Toggle the overlay
            if (overlay.classList.contains('hidden')) {
                overlay.classList.remove('hidden');
                setTimeout(() => {
                    overlay.classList.add('opacity-100');
                }, 0);
            } else {
                overlay.classList.remove('opacity-100');
                setTimeout(() => {
                    overlay.classList.add('hidden');
                }, 300);
            }
        }
    </script>
</body>
</html>