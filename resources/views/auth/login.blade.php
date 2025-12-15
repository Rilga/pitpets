<x-guest-layout>
    {{-- HEADER CUSTOMER --}}
    <div class="mb-8 text-center">
        <h2 class="text-2xl font-extrabold text-gray-900 tracking-tight">
            Selamat Datang di <span class="text-[#fc5205]">PitPet</span>
        </h2>
        <p class="text-sm text-gray-500 mt-2 font-medium">
            Masuk untuk booking grooming dan melihat riwayat layanan anabul Anda 🐾
        </p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        {{-- EMAIL --}}
        <div>
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
                autofocus
                placeholder="emailanda@gmail.com"
            />

            <x-input-error :messages="$errors->get('email')" class="mt-2" />
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
                placeholder="••••••••"
            />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        {{-- REMEMBER ME --}}
        <div class="block mt-6">
            <label for="remember_me" class="inline-flex items-center">
                <input
                    id="remember_me"
                    type="checkbox"
                    class="rounded border-gray-300 text-[#fc5205]
                           shadow-sm focus:ring-[#fc5205]"
                    name="remember"
                >
                <span class="ms-2 text-sm text-gray-600">
                    Ingat saya
                </span>
            </label>
        </div>

        {{-- ACTION --}}
        <div class="flex items-center justify-between mt-8">
            @if (Route::has('password.request'))
                <a
                    class="text-sm text-gray-500 hover:text-[#fc5205] transition underline"
                    href="{{ route('password.request') }}"
                >
                    Lupa password?
                </a>
            @endif

            <x-primary-button
                class="bg-[#fc5205] hover:bg-[#e04804]
                       rounded-xl py-3 px-6
                       shadow-lg shadow-[#fc5205]/30
                       transition-all transform hover:-translate-y-0.5"
            >
                Masuk
            </x-primary-button>
        </div>
    </form>

    {{-- REGISTER CTA --}}
    <div class="mt-8 text-center">
        <p class="text-sm text-gray-500">
            Belum punya akun?
            <a href="{{ route('register') }}"
               class="font-bold text-[#fc5205] hover:underline">
                Daftar sekarang
            </a>
        </p>
    </div>
</x-guest-layout>
