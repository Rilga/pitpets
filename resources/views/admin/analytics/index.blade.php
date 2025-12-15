<x-app-layout>
    {{-- Background decoration (optional) --}}
    <div class="min-h-screen bg-gray-50/50 pb-10">
        
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 pt-4 space-y-8">

            {{-- HEADER SECTION --}}
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">
                        Business <span class="text-[#2ba6c5]">Analytics</span>
                    </h2>
                    <p class="text-gray-500 text-sm mt-1 flex items-center gap-2">
                        <span>Ringkasan performa & layanan grooming</span>
                    </p>
                </div>
            </div>

            {{-- KPI CARDS --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @php
                    // Helper untuk format angka
                    $formatK = function($num) {
                        return $num >= 1000 ? round($num/1000, 1) . 'k' : $num;
                    };
                    
                    $kpis = [
                        [
                            'label' => 'Total Customer',
                            'value' => $totalCustomers,
                            'sub' => 'Pelanggan terdaftar',
                            'color' => 'bg-blue-50 text-blue-600',
                            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />'
                        ],
                        [
                            'label' => 'Total Booking',
                            'value' => $totalOrders,
                            'sub' => 'Order selesai',
                            'color' => 'bg-orange-50 text-orange-600',
                            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />'
                        ],
                        [
                            'label' => 'Repeat Rate',
                            'value' => $repeatRate . '%',
                            'sub' => 'Loyalitas user',
                            'color' => 'bg-purple-50 text-purple-600',
                            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />'
                        ],
                        [
                            'label' => 'Revenue',
                            'value' => 'Rp ' . number_format($totalRevenue, 0, ',', '.'), // Bisa dipendekkan jika angka besar
                            'sub' => 'Total pendapatan',
                            'color' => 'bg-emerald-50 text-emerald-600',
                            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />'
                        ]
                    ];
                @endphp

                @foreach ($kpis as $kpi)
                    <div class="bg-white rounded-2xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] p-6 border border-gray-100 transition hover:shadow-lg">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500">{{ $kpi['label'] }}</p>
                                <h4 class="text-2xl font-bold text-gray-900 mt-2">
                                    {{ $kpi['value'] }}
                                </h4>
                                <p class="text-xs text-gray-400 mt-1">{{ $kpi['sub'] }}</p>
                            </div>
                            <div class="p-3 rounded-xl {{ $kpi['color'] }}">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    {!! $kpi['icon'] !!}
                                </svg>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- CHARTS SECTION --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                
                {{-- Left: Line Chart --}}
                <div class="bg-white rounded-2xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] p-6 border border-gray-100">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="font-bold text-gray-900 text-lg">📈 Booking Trend</h3>
                            <p class="text-xs text-gray-400">Performa transaksi bulanan</p>
                        </div>
                        <button class="text-gray-400 hover:text-gray-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path></svg></button>
                    </div>
                    <div class="relative h-64">
                        <canvas id="monthlyChart"></canvas>
                    </div>
                </div>

                {{-- Right: Bar Chart --}}
                <div class="bg-white rounded-2xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] p-6 border border-gray-100">
                     <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="font-bold text-gray-900 text-lg">⏰ Jam Favorit</h3>
                            <p class="text-xs text-gray-400">Waktu tersibuk layanan</p>
                        </div>
                    </div>
                    <div class="relative h-64">
                        <canvas id="timeChart"></canvas>
                    </div>
                </div>

                {{-- Left: Horizontal Bar --}}
                <div class="bg-white rounded-2xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] p-6 border border-gray-100">
                    <div class="mb-6">
                        <h3 class="font-bold text-gray-900 text-lg">🏆 Top Loyal Customer</h3>
                        <p class="text-xs text-gray-400">Pelanggan dengan order terbanyak</p>
                    </div>
                    <div class="relative h-64">
                        <canvas id="customerChart"></canvas>
                    </div>
                </div>

                {{-- Right: Doughnut --}}
                <div class="bg-white rounded-2xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] p-6 border border-gray-100">
                    <div class="mb-6">
                        <h3 class="font-bold text-gray-900 text-lg">🐾 Service Populer</h3>
                        <p class="text-xs text-gray-400">Distribusi layanan yang dipilih</p>
                    </div>
                    <div class="relative h-64 flex justify-center">
                        <canvas id="serviceChart"></canvas>
                    </div>
                </div>
            </div>

            {{-- TABLE SECTION --}}
            <div class="bg-white rounded-2xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100 overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                    <div>
                        <h3 class="font-bold text-gray-900 text-lg">📋 Loyalitas Customer Detail</h3>
                        <p class="text-xs text-gray-500">Data lengkap transaksi pelanggan</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50 text-gray-500 uppercase text-xs font-semibold tracking-wider">
                            <tr>
                                <th class="px-8 py-4">Customer</th>
                                <th class="px-6 py-4 text-center">Frekuensi Booking</th>
                                <th class="px-6 py-4 text-right">Total Spend</th>
                                <th class="px-6 py-4 text-center">Status Level</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($customers as $c)
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-8 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            {{-- Avatar Initials --}}
                                            <div class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-100 to-cyan-100 text-[#2ba6c5] flex items-center justify-center font-bold text-sm shadow-sm">
                                                {{ substr($c->name, 0, 1) }}
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-bold text-gray-900">{{ $c->name }}</div>
                                                <div class="text-xs text-gray-400">{{ $c->email ?? 'No email' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="inline-block px-3 py-1 bg-gray-100 text-gray-600 rounded-md font-bold text-xs">
                                            {{ $c->orders_count }} Transaksi
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right font-semibold text-gray-700">
                                        Rp {{ number_format($c->orders_sum_total, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @php
                                            $isVip = $c->orders_count >= 10;
                                            $isLoyal = $c->orders_count >= 5;
                                            $badgeClass = $isVip ? 'bg-emerald-100 text-emerald-700 border-emerald-200' : 
                                                         ($isLoyal ? 'bg-blue-100 text-blue-700 border-blue-200' : 
                                                         'bg-gray-100 text-gray-600 border-gray-200');
                                            $label = $isVip ? 'VIP Member' : ($isLoyal ? 'Loyal User' : 'New User');
                                        @endphp
                                        <span class="px-3 py-1 rounded-full text-xs font-bold border {{ $badgeClass }}">
                                            {{ $label }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    {{-- SCRIPTS --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Global Options for Cleaner Look
        Chart.defaults.font.family = "'Figtree', sans-serif";
        Chart.defaults.color = '#64748b';
        Chart.defaults.scale.grid.color = '#f1f5f9';

        const commonOptions = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1e293b',
                    padding: 12,
                    titleFont: { size: 13 },
                    bodyFont: { size: 13 },
                    cornerRadius: 8,
                    displayColors: false
                }
            }
        };

        // 1. Monthly Chart (Area Effect)
        new Chart(document.getElementById('monthlyChart'), {
            type: 'line',
            data: {
                labels: {!! json_encode($monthlyOrders->pluck('month')) !!},
                datasets: [{
                    label: 'Total Orders',
                    data: {!! json_encode($monthlyOrders->pluck('total')) !!},
                    borderColor: '#fc5205', // Orange Brand
                    backgroundColor: (context) => {
                        const ctx = context.chart.ctx;
                        const gradient = ctx.createLinearGradient(0, 0, 0, 300);
                        gradient.addColorStop(0, 'rgba(252, 82, 5, 0.2)');
                        gradient.addColorStop(1, 'rgba(252, 82, 5, 0)');
                        return gradient;
                    },
                    borderWidth: 3,
                    tension: 0.4,
                    fill: true,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#fc5205',
                    pointBorderWidth: 2
                }]
            },
            options: {
                ...commonOptions,
                scales: {
                    y: { beginAtZero: true, border: {display: false} },
                    x: { grid: {display: false}, border: {display: false} }
                }
            }
        });

        // 2. Time Chart
        new Chart(document.getElementById('timeChart'), {
            type: 'bar',
            data: {
                labels: {!! json_encode($favoriteTimes->pluck('time')) !!},
                datasets: [{
                    label: 'Booking Count',
                    data: {!! json_encode($favoriteTimes->pluck('total')) !!},
                    backgroundColor: '#2ba6c5', // Cyan Brand
                    borderRadius: 6,
                    barThickness: 24
                }]
            },
            options: {
                ...commonOptions,
                scales: {
                    y: { display: false },
                    x: { grid: {display: false}, border: {display: false} }
                }
            }
        });

        // 3. Customer Chart (Horizontal)
        new Chart(document.getElementById('customerChart'), {
            type: 'bar', // Gunakan 'bar' dengan indexAxis 'y'
            data: {
                labels: {!! json_encode($topCustomers->pluck('name')) !!},
                datasets: [{
                    label: 'Total Order',
                    data: {!! json_encode($topCustomers->pluck('orders_count')) !!},
                    backgroundColor: '#34d399', // Emerald
                    borderRadius: 6,
                    barThickness: 20
                }]
            },
            options: {
                ...commonOptions,
                indexAxis: 'y',
                scales: {
                    x: { display: false },
                    y: { grid: {display: false}, border: {display: false} }
                }
            }
        });

        // 4. Service Chart (Doughnut)
        new Chart(document.getElementById('serviceChart'), {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($topServices->pluck('service_name')) !!},
                datasets: [{
                    data: {!! json_encode($topServices->pluck('total_ordered')) !!},
                    backgroundColor: ['#fc5205', '#2ba6c5', '#fbbf24', '#818cf8', '#34d399'],
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '75%',
                plugins: {
                    legend: { 
                        display: true, 
                        position: 'bottom',
                        labels: { usePointStyle: true, padding: 20, boxWidth: 8 } 
                    }
                }
            }
        });
    </script>
</x-app-layout>