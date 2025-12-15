<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-10">

            {{-- HERO --}}
            <div class="bg-white rounded-2xl shadow-sm p-8 flex flex-col lg:flex-row items-center gap-10">
                <div class="flex-1">
                    <p class="text-xs font-bold text-[#fc5205] mb-2 uppercase tracking-wide">
                        Grooming Service
                    </p>

                    <h3 class="text-3xl font-extrabold text-gray-900 leading-tight mb-3">
                        Grooming Profesional<br>
                        Langsung ke Rumah Anda
                    </h3>

                    <p class="text-sm text-gray-600 leading-relaxed max-w-xl mb-6">
                        Pesan layanan grooming kucing & anjing dengan mudah.
                        Groomer berpengalaman akan datang sesuai jadwal yang Anda tentukan.
                    </p>

                    <a href="{{ route('order.create') }}"
                        class="inline-flex items-center gap-2 px-7 py-3 bg-[#fc5205] text-white
                               rounded-xl text-sm font-bold shadow hover:bg-[#e04804] transition">
                        Booking Sekarang
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>

                <div class="flex-shrink-0">
                    <img src="https://cdn-icons-png.flaticon.com/512/616/616408.png"
                        class="w-44 h-44 object-contain opacity-90"
                        alt="Pet Grooming">
                </div>
            </div>

            {{-- QUICK STATS --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <div class="bg-white rounded-xl shadow-sm p-6">
                    <p class="text-xs text-gray-400 mb-1">Booking Aktif</p>
                    <h4 class="text-2xl font-extrabold text-gray-900">
                        {{ $activeOrders ?? 0 }}
                    </h4>
                    <p class="text-xs text-gray-500 mt-2">
                        {{ $activeOrders > 0 ? 'Sedang diproses' : 'Tidak ada booking aktif' }}
                    </p>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6">
                    <p class="text-xs text-gray-400 mb-1">Total Booking</p>
                    <h4 class="text-2xl font-extrabold text-gray-900">
                        {{ $totalOrders ?? 0 }}
                    </h4>
                    <p class="text-xs text-gray-500 mt-2">
                        Seluruh riwayat grooming
                    </p>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6">
                    <p class="text-xs text-gray-400 mb-1">Akun</p>
                    <h4 class="text-lg font-bold text-gray-900 truncate">
                        {{ Auth::user()->email }}
                    </h4>
                    <a href="{{ route('profile.edit') }}"
                        class="inline-block mt-3 text-xs font-bold text-[#2ba6c5] hover:underline">
                        Edit Profil →
                    </a>
                </div>

            </div>

            {{-- STEPS --}}
            <div class="bg-white rounded-2xl shadow-sm p-8">
                <h4 class="text-lg font-bold text-gray-900 mb-6">
                    Cara Booking Grooming
                </h4>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                    <div class="flex gap-4">
                        <div
                            class="w-10 h-10 rounded-full bg-[#fc5205] text-white font-bold
                                   flex items-center justify-center flex-shrink-0">
                            1
                        </div>
                        <div>
                            <p class="font-bold text-gray-800 mb-1">
                                Isi Form Booking
                            </p>
                            <p class="text-sm text-gray-500">
                                Pilih layanan, jumlah pet, dan alamat.
                            </p>
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <div
                            class="w-10 h-10 rounded-full bg-[#fc5205] text-white font-bold
                                   flex items-center justify-center flex-shrink-0">
                            2
                        </div>
                        <div>
                            <p class="font-bold text-gray-800 mb-1">
                                Konfirmasi Admin
                            </p>
                            <p class="text-sm text-gray-500">
                                Jadwal dan groomer akan ditentukan.
                            </p>
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <div
                            class="w-10 h-10 rounded-full bg-[#fc5205] text-white font-bold
                                   flex items-center justify-center flex-shrink-0">
                            3
                        </div>
                        <div>
                            <p class="font-bold text-gray-800 mb-1">
                                Groomer Datang
                            </p>
                            <p class="text-sm text-gray-500">
                                Layanan dilakukan di lokasi Anda.
                            </p>
                        </div>
                    </div>

                </div>
            </div>

            {{-- ACTIONS --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h5 class="font-bold text-gray-900 mb-2">
                        📦 Status Booking
                    </h5>
                    <p class="text-sm text-gray-500 mb-4">
                        Lihat perkembangan grooming Anda secara realtime.
                    </p>
                    <a href="{{ route('customer.history') }}"
                        class="text-sm font-bold text-[#2ba6c5] hover:underline">
                        Lihat Status →
                    </a>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h5 class="font-bold text-gray-900 mb-2">
                        📜 Riwayat Grooming
                    </h5>
                    <p class="text-sm text-gray-500 mb-4">
                        Semua layanan grooming yang pernah Anda pesan.
                    </p>
                    <a href="{{ route('customer.history') }}"
                        class="text-sm font-bold text-[#2ba6c5] hover:underline">
                        Lihat Riwayat →
                    </a>
                </div>

            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if(session('success'))
                Swal.fire({
                    title: 'Booking Berhasil 🎉',
                    text: "{{ session('success') }}",
                    icon: 'success',
                    confirmButtonText: 'Oke',
                    confirmButtonColor: '#10B981',
                });
            @endif
        });
    </script>
</x-app-layout>
