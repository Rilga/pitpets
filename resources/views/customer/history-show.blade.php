<x-app-layout>
    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- HEADER --}}
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-extrabold text-gray-900">
                    Detail Booking Grooming
                </h2>

                <a href="{{ route('customer.history') }}"
                   class="text-sm font-bold text-[#2ba6c5] hover:underline">
                    ← Kembali
                </a>
            </div>

            {{-- CARD --}}
            <div class="bg-white rounded-2xl shadow-sm p-8 space-y-8">

                {{-- STATUS --}}
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-400">Status Booking</p>
                        <p class="text-lg font-bold capitalize
                            {{ $order->status === 'pending' ? 'text-yellow-500' : '' }}
                            {{ $order->status === 'confirmed' ? 'text-blue-500' : '' }}
                            {{ $order->status === 'completed' ? 'text-green-600' : '' }}
                            {{ $order->status === 'cancelled' ? 'text-red-500' : '' }}">
                            {{ $order->status }}
                        </p>
                    </div>

                    <div class="text-right">
                        <p class="text-xs text-gray-400">Tanggal Booking</p>
                        <p class="text-sm font-bold text-gray-800">
                            {{ \Carbon\Carbon::parse($order->date)->translatedFormat('d F Y') }}
                        </p>
                        <p class="text-xs text-gray-500">
                            {{ $order->time_slot }}
                        </p>
                    </div>
                </div>

                <hr>

                {{-- CUSTOMER INFO --}}
                <div>
                    <h4 class="text-sm font-bold text-gray-700 mb-3">
                        Data Customer
                    </h4>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-gray-400 text-xs">Nama</p>
                            <p class="font-bold text-gray-800">
                                {{ $order->customer_name }}
                            </p>
                        </div>

                        <div>
                            <p class="text-gray-400 text-xs">No. Telepon</p>
                            <p class="font-bold text-gray-800">
                                {{ $order->customer_phone }}
                            </p>
                        </div>

                        <div class="md:col-span-2">
                            <p class="text-gray-400 text-xs">Alamat</p>
                            <p class="font-bold text-gray-800 leading-relaxed">
                                {{ $order->customer_address }}
                            </p>
                        </div>
                    </div>
                </div>

                <hr>

                {{-- GROOMING INFO --}}
                <div>
                    <h4 class="text-sm font-bold text-gray-700 mb-3">
                        Informasi Grooming
                    </h4>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">

                        <div>
                            <p class="text-gray-400 text-xs">Groomer</p>
                            <p class="font-bold text-gray-800">
                                {{ $order->groomer->name ?? 'Belum ditentukan' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-gray-400 text-xs">Jarak</p>
                            <p class="font-bold text-gray-800">
                                {{ $order->distance_km ?? 0 }} KM
                            </p>
                        </div>

                        <div>
                            <p class="text-gray-400 text-xs">Biaya Transport</p>
                            <p class="font-bold text-gray-800">
                                Rp {{ number_format($order->transport_fee) }}
                            </p>
                        </div>
                    </div>
                </div>

                <hr>

                {{-- PAYMENT --}}
                <div>
                    <h4 class="text-sm font-bold text-gray-700 mb-3">
                        Ringkasan Biaya
                    </h4>

                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Subtotal</span>
                            <span class="font-bold">
                                Rp {{ number_format($order->subtotal) }}
                            </span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-gray-500">Transport</span>
                            <span class="font-bold">
                                Rp {{ number_format($order->transport_fee) }}
                            </span>
                        </div>

                        <hr>

                        <div class="flex justify-between text-base">
                            <span class="font-bold text-gray-900">Total</span>
                            <span class="font-extrabold text-[#fc5205]">
                                Rp {{ number_format($order->total) }}
                            </span>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
