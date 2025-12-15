<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- HEADER --}}
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-extrabold text-gray-900">
                    Riwayat Booking Grooming
                </h2>

                <a href="{{ route('order.create') }}"
                   class="px-5 py-2 bg-[#fc5205] text-white text-sm font-bold rounded-lg hover:bg-[#e04804] transition">
                    + Booking Baru
                </a>
            </div>

            {{-- TABLE --}}
            <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 border-b">
                        <tr class="text-left text-gray-500 uppercase text-xs tracking-wide">
                            <th class="px-6 py-4">Tanggal</th>
                            <th class="px-6 py-4">Waktu</th>
                            <th class="px-6 py-4">Alamat</th>
                            <th class="px-6 py-4">Total</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y">
                        @forelse ($orders as $order)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 font-medium text-gray-800">
                                    {{ \Carbon\Carbon::parse($order->date)->format('d M Y') }}
                                </td>

                                <td class="px-6 py-4 text-gray-600">
                                    {{ $order->time_slot }}
                                </td>

                                <td class="px-6 py-4 text-gray-600 max-w-xs truncate">
                                    {{ $order->customer_address }}
                                </td>

                                <td class="px-6 py-4 font-bold text-gray-900">
                                    Rp {{ number_format($order->total, 0, ',', '.') }}
                                </td>

                                <td class="px-6 py-4">
                                    @php
                                        $statusColor = match($order->status) {
                                            'pending' => 'bg-yellow-100 text-yellow-700',
                                            'confirmed' => 'bg-blue-100 text-blue-700',
                                            'on_progress' => 'bg-orange-100 text-orange-700',
                                            'completed' => 'bg-green-100 text-green-700',
                                            'cancelled' => 'bg-red-100 text-red-700',
                                            default => 'bg-gray-100 text-gray-700',
                                        };
                                    @endphp

                                    <span class="px-3 py-1 rounded-full text-xs font-bold {{ $statusColor }}">
                                        {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('customer.history.show', $order->id) }}"
                                    class="inline-flex items-center gap-1 text-sm font-bold text-[#2ba6c5] hover:underline">
                                        Detail
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-10 text-center text-gray-500">
                                    Belum ada riwayat booking grooming 🐾
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- PAGINATION --}}
            <div>
                {{ $orders->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
