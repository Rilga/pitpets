<x-app-layout>
    {{-- Leaflet --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <div class="h-[calc(100vh-65px)] relative bg-gray-100">

        {{-- FILTER TANGGAL --}}
        <form method="GET"
            class="absolute top-4 left-1/2 -translate-x-1/2 z-[500]
                   bg-white px-4 py-2 rounded-lg shadow border flex items-center gap-3">
            <span class="text-xs font-bold text-gray-500">Tanggal</span>
            <input type="date" name="date"
                value="{{ $date }}"
                class="border rounded-md px-2 py-1 text-sm">
            <button
                class="bg-[#2ba6c5] text-white px-3 py-1 rounded-md text-sm font-bold hover:bg-[#2490aa]">
                Tampilkan
            </button>
        </form>

        {{-- MAP --}}
        <div id="groomerMap" class="w-full h-full z-0"></div>

        {{-- LOADING --}}
        <div id="loadingMap"
            class="absolute top-4 left-4 z-[400] bg-white px-4 py-2 rounded-lg shadow-lg border flex items-center gap-3">
            <svg class="animate-spin h-5 w-5 text-[#fc5205]" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10"
                    stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
            </svg>
            <div>
                <p class="text-xs font-bold text-gray-700">Memuat Lokasi Grooming...</p>
                <p class="text-[10px] text-gray-400" id="progressText">0/0 selesai</p>
            </div>
        </div>

        {{-- SIDEBAR --}}
        <div
            class="absolute top-4 right-4 z-[400] w-64 bg-white rounded-xl shadow-2xl p-4 border bg-opacity-95 backdrop-blur-sm">
            <h3 class="font-bold text-gray-900 text-sm mb-1">Peta Groomer</h3>
            <p class="text-[10px] text-gray-500 mb-3">
                Order <strong>Confirmed</strong> sesuai tanggal
            </p>

            <div class="space-y-2 text-xs">
                <div class="flex items-center">
                    <img src="https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png"
                        class="w-3 h-5 mr-2">
                    <span>Lokasi Customer</span>
                </div>
                <div class="flex items-center">
                    <div class="w-3 h-3 rounded-full bg-[#fc5205] mr-2"></div>
                    <span>PitPet Clinic</span>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            /* =============================
               KONFIGURASI TOKO
            ============================= */
            const storeLat = -6.302075258990813;
            const storeLng = 106.78154042561847;

            const map = L.map('groomerMap').setView([storeLat, storeLng], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; PitPet'
            }).addTo(map);

            /* =============================
               MARKER TOKO
            ============================= */
            L.marker([storeLat, storeLng]).addTo(map)
                .bindPopup("<b>🏠 PitPet Clinic</b>");

            /* =============================
               ICON MERAH CUSTOMER
            ============================= */
            const redIcon = new L.Icon({
                iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
                shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            });

            const orders = @json($orders);
            const totalOrders = orders.length;
            let processed = 0;

            if (totalOrders === 0) {
                document.getElementById('loadingMap').style.display = 'none';
            } else {
                document.getElementById('progressText').innerText = `0/${totalOrders}`;
            }

            /* =============================
               HELPER ROUTE
            ============================= */
            async function getRoute(lon, lat) {
                try {
                    let url =
                        `https://router.project-osrm.org/route/v1/driving/${storeLng},${storeLat};${lon},${lat}?overview=full&geometries=geojson`;
                    let res = await fetch(url);
                    let data = await res.json();
                    if (!data.routes) return null;

                    return {
                        distance: (data.routes[0].distance / 1000).toFixed(1),
                        geometry: data.routes[0].geometry
                    };
                } catch {
                    return null;
                }
            }

            /* =============================
               LOOP ORDER
            ============================= */
            orders.forEach((order, i) => {
                setTimeout(() => pinOrder(order), i * 1200);
            });

            async function pinOrder(order) {
                try {
                    let geoUrl =
                        `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(order.customer_address)}&limit=1`;
                    let geoRes = await fetch(geoUrl);
                    let geo = await geoRes.json();
                    if (!geo.length) return;

                    let lat = geo[0].lat;
                    let lon = geo[0].lon;

                    let route = await getRoute(lon, lat);

                    /* MARKER CUSTOMER (MERAH) */
                    L.marker([lat, lon], { icon: redIcon }).addTo(map).bindPopup(`
                        <div class="text-sm min-w-[180px]">
                            <strong>${order.customer_name}</strong>
                            <div class="text-xs text-gray-500 mb-2">
                                ${order.customer_address}
                            </div>
                            <div class="text-xs font-bold">
                                ⏰ ${order.time_slot}<br>
                                📏 ${route ? route.distance : 'N/A'} KM
                            </div>
                        </div>
                    `);

                    /* ROUTE */
                    if (route) {
                        L.geoJSON(route.geometry, {
                            style: {
                                color: '#2ba6c5',
                                weight: 4,
                                opacity: 0.75
                            }
                        }).addTo(map);
                    }
                } catch (e) {
                    console.error(e);
                } finally {
                    processed++;
                    document.getElementById('progressText').innerText =
                        `${processed}/${totalOrders}`;
                    if (processed === totalOrders) {
                        setTimeout(() => {
                            document.getElementById('loadingMap').style.display = 'none';
                        }, 800);
                    }
                }
            }
        });
    </script>
</x-app-layout>
