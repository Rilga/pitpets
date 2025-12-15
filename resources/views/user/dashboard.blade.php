<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- HEADER --}}
            <div class="flex flex-col md:flex-row justify-between items-end mb-10 gap-6">

                <div>
                    <h2 class="text-3xl font-extrabold text-gray-900">
                        Halo, <span class="text-[#2ba6c5]">{{ Auth::user()->name }}</span>
                    </h2>
                    <p class="text-gray-500 mt-1 text-sm">
                        Jadwal grooming tanggal:
                    </p>

                    @if(!$selectedDate->isToday())
                        <span class="inline-block mt-2 px-3 py-1 text-xs font-bold rounded-full
                            {{ $selectedDate->isPast() ? 'bg-gray-200 text-gray-600' : 'bg-blue-100 text-blue-700' }}">
                            {{ $selectedDate->isPast() ? 'Riwayat' : 'Jadwal Mendatang' }}
                        </span>
                    @endif
                </div>

                {{-- KONTROL TANGGAL --}}
                <div class="flex items-center gap-3">

                    {{-- PREVIOUS --}}
                    <a href="{{ route('user.dashboard', ['date' => $selectedDate->copy()->subDay()->toDateString()]) }}"
                    class="px-4 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 font-bold">
                        ‹
                    </a>

                    {{-- DATE PICKER --}}
                    <form method="GET" action="{{ route('user.dashboard') }}">
                        <input type="date"
                            name="date"
                            value="{{ $selectedDate->toDateString() }}"
                            onchange="this.form.submit()"
                            class="px-4 py-2 rounded-xl border border-gray-300 font-bold text-gray-700 shadow-sm
                                    focus:ring focus:ring-blue-200">
                    </form>

                    {{-- NEXT --}}
                    <a href="{{ route('user.dashboard', ['date' => $selectedDate->copy()->addDay()->toDateString()]) }}"
                    class="px-4 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 font-bold">
                        ›
                    </a>

                </div>
            </div>


            {{-- ================= STATISTIK ================= --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-10">
                <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm">
                    <p class="text-xs text-gray-400 font-bold uppercase">Total Tugas</p>
                    <p class="text-2xl font-extrabold text-gray-900">{{ $orders->count() }}</p>
                </div>
                <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm">
                    <p class="text-xs text-gray-400 font-bold uppercase">Selesai</p>
                    <p class="text-2xl font-extrabold text-green-500">
                        {{ $orders->where('status', 'completed')->count() }}
                    </p>
                </div>
                <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm">
                    <p class="text-xs text-gray-400 font-bold uppercase">Sisa</p>
                    <p class="text-2xl font-extrabold text-[#fc5205]">
                        {{ $orders->where('status', 'confirmed')->count() }}
                    </p>
                </div>
            </div>

            {{-- ================= GRID ORDER ================= --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse ($orders as $order)
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden flex flex-col hover:-translate-y-1 transition">

                        {{-- Status Indicator --}}
                        <div class="h-1.5 w-full {{ $order->status === 'completed' ? 'bg-green-500' : 'bg-[#fc5205]' }}"></div>

                        <div class="p-6 flex flex-col flex-1">
                            {{-- Jam --}}
                            <div class="flex justify-between items-start mb-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-lg text-sm font-bold bg-gray-900 text-white">
                                    ⏰ {{ $order->time_slot }}
                                </span>
                                <span class="text-xs text-gray-400 font-mono">
                                    #{{ substr($order->id.$order->created_at, 0, 6) }}
                                </span>
                            </div>

                            {{-- Customer --}}
                            <div class="mb-6">
                                <h3 class="text-xl font-bold text-gray-900">{{ $order->customer_name }}</h3>
                                <p class="text-sm text-gray-500 mt-1">
                                    📍 {{ $order->customer_address }}
                                </p>
                            </div>

                            {{-- Hewan --}}
                            <div class="bg-gray-50 rounded-xl p-4 mb-6 flex-1">
                                <p class="text-xs uppercase font-bold text-gray-400 mb-2">Detail Pengerjaan</p>
                                <ul class="space-y-3">
                                    @foreach($order->pets as $pet)
                                        <li class="flex items-start text-sm">
                                            <span class="mr-2 text-lg">
                                                {{ $pet->pet_type === 'cat' ? '🐱' : '🐶' }}
                                            </span>
                                            <div>
                                                <span class="font-bold block">{{ $pet->service_name }}</span>
                                                @if($pet->dog_size)
                                                    <span class="text-[10px] bg-white border px-2 py-0.5 rounded">
                                                        Size {{ $pet->dog_size }}
                                                    </span>
                                                @endif
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>

                                @if($order->notes)
                                    <div class="mt-3 pt-3 border-t text-xs italic text-gray-500">
                                        Catatan: "{{ $order->notes }}"
                                    </div>
                                @endif
                            </div>

                            {{-- Action --}}
                            <form action="{{ route('groomer.order.status', $order->id) }}" method="POST">
                                @csrf @method('PUT')

                                @if($order->status === 'confirmed')
                                    <button name="status" value="completed"
                                        class="w-full bg-[#fc5205] text-white font-bold py-3 rounded-xl hover:bg-[#e04804] transition">
                                        Tandai Selesai
                                    </button>
                                @else
                                    <div class="w-full bg-green-100 text-green-700 font-bold py-3 rounded-xl text-center">
                                        Tugas Selesai
                                    </div>
                                @endif
                            </form>
                        </div>
                    </div>
                @empty
                    {{-- EMPTY --}}
                    <div class="col-span-full py-20 text-center">
                        <div class="text-4xl mb-4">☕</div>
                        <h3 class="text-xl font-bold text-gray-900">
                            Tidak ada tugas pada tanggal ini
                        </h3>
                        <p class="text-gray-500 mt-2">
                            {{ $selectedDate->translatedFormat('l, d F Y') }}
                        </p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>
