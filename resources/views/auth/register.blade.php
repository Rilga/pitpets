<x-guest-layout>
    {{-- HEADER CUSTOMER --}}
    <div class="mb-8 text-center">
        <h2 class="text-2xl font-extrabold text-gray-900 tracking-tight">
            Daftar Akun <span class="text-[#fc5205]">PitPet</span>
        </h2>
        <p class="text-sm text-gray-500 mt-2 font-medium">
            Buat akun untuk booking grooming anabul Anda 🐶🐱
        </p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        {{-- NAMA --}}
        <div>
            <x-input-label
                for="name"
                value="Nama Lengkap"
                class="text-gray-700 font-bold text-xs uppercase tracking-wide"
            />
            <x-text-input
                id="name"
                class="block mt-1 w-full rounded-xl border-gray-300 shadow-sm
                       focus:border-[#fc5205] focus:ring focus:ring-[#fc5205]/20
                       py-3 px-4 bg-gray-50 focus:bg-white transition"
                type="text"
                name="name"
                :value="old('name')"
                required
                autofocus
                placeholder="Contoh: Budi Santoso"
            />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        {{-- EMAIL --}}
        <div class="mt-5">
            <x-input-label
                for="email"
                value="Email"
                class="text-gray-700 font-bold text-xs uppercase tracking-wide"
            />
            <x-text-input
                id="email"
                class="block mt-1 w-full rounded-xl border-gray-300 shadow-sm
                       focus:border-[#fc5205] focus:ring focus:ring-[#fc5205]/20
                       py-3 px-4 bg-gray-50 focus:bg-white transition"
                type="email"
                name="email"
                :value="old('email')"
                required
                placeholder="emailanda@gmail.com"
            />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        {{-- NO TELEPON --}}
        <div class="mt-5">
            <x-input-label
                for="phone"
                value="No. WhatsApp"
                class="text-gray-700 font-bold text-xs uppercase tracking-wide"
            />
            <x-text-input
                id="phone"
                class="block mt-1 w-full rounded-xl border-gray-300 shadow-sm
                       focus:border-[#fc5205] focus:ring focus:ring-[#fc5205]/20
                       py-3 px-4 bg-gray-50 focus:bg-white transition"
                type="text"
                name="phone"
                :value="old('phone')"
                required
                placeholder="08xxxxxxxxxx"
            />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        {{-- PASSWORD --}}
        <div class="mt-5">
            <x-input-label
                for="password"
                value="Password"
                class="text-gray-700 font-bold text-xs uppercase tracking-wide"
            />
            <x-text-input
                id="password"
                class="block mt-1 w-full rounded-xl border-gray-300 shadow-sm
                       focus:border-[#fc5205] focus:ring focus:ring-[#fc5205]/20
                       py-3 px-4 bg-gray-50 focus:bg-white transition"
                type="password"
                name="password"
                required
                placeholder="Minimal 8 karakter"
            />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        {{-- KONFIRMASI PASSWORD --}}
        <div class="mt-5">
            <x-input-label
                for="password_confirmation"
                value="Konfirmasi Password"
                class="text-gray-700 font-bold text-xs uppercase tracking-wide"
            />
            <x-text-input
                id="password_confirmation"
                class="block mt-1 w-full rounded-xl border-gray-300 shadow-sm
                       focus:border-[#fc5205] focus:ring focus:ring-[#fc5205]/20
                       py-3 px-4 bg-gray-50 focus:bg-white transition"
                type="password"
                name="password_confirmation"
                required
                placeholder="Ulangi password"
            />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        {{-- ACTION --}}
        <div class="flex items-center justify-between mt-8">
            <a
                href="{{ route('login') }}"
                class="text-sm text-gray-500 hover:text-[#fc5205] transition underline"
            >
                Sudah punya akun?
            </a>

            <x-primary-button
                class="bg-[#fc5205] hover:bg-[#e04804]
                       rounded-xl py-3 px-6
                       shadow-lg shadow-[#fc5205]/30
                       transition-all transform hover:-translate-y-0.5"
            >
                Daftar
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
