<nav class="bg-white/95 backdrop-blur-sm shadow-sm border-b border-gray-100 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
        
        {{-- LOGO --}}
        <a href="/">
            {{-- Ganti 'logo.png' dengan nama file logo Anda yang sebenarnya --}}
            <img src="{{ asset('asset/logo_pitpet.png') }}" alt="PitPet Logo" class="h-12 w-auto hover:opacity-50 transition">
        </a>

        {{-- MENU KANAN --}}
        <div class="flex items-center space-x-3">
            
            {{-- Link Biasa --}}
            <a href="/order/create" class="mr-4 text-sm font-bold text-gray-500 hover:text-[#2ba6c5] transition duration-300">
                Pesan Grooming
            </a>

            <a href="/register" class="h-10 px-6 flex items-center justify-center text-sm font-bold text-[#fc5205] border border-[#fc5205] rounded-full hover:bg-[#fc5205] hover:text-white transition duration-300">
                Register
            </a>

            <a href="/login"
            class="h-10 px-6 flex items-center justify-center text-sm font-bold bg-[#fc5205] text-white rounded-full shadow-md shadow-[#fc5205]/20 hover:bg-[#e04804] transition duration-300">
                Login
            </a>
                        
                    </div>
                </div>
            </nav>