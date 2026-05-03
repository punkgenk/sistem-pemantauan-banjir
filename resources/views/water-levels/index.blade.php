@extends(auth()->user()->role === 'pemerintah'
    ? 'layouts.pemerintah'
    : 'layouts.masyarakat')

@section('title','Pantau Banjir')

@section('content')
<h1 class="text-2xl font-bold mb-6 flex items-center gap-2">
    <i class="fa-solid fa-water"></i>
    Pantau Banjir
</h1>

{{-- Peta --}}
<div id="map" class="h-[500px] rounded-xl shadow mb-6"></div>

{{-- Tabel laporan masyarakat --}}
<div class="bg-white center rounded-xl shadow overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-gray-100 text-gray-700">
            <tr>
                <th class="p-3 text-center">Pelapor</th>
                <th class="p-3 text-center">Judul</th>
                <th class="p-3 text-center">Alamat</th>
                <th class="p-3 text-center">Tanggal</th>
                <th class="p-3 text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reports as $report)
            <tr class="border-b">
                <td class="p-3 text-center">{{ $report->user->name ?? '-' }}</td>
                <td class="p-3 text-center">{{ $report->title }}</td>
                <td class="p-3 text-center">{{ $report->address ?? '-' }}</td>
                <td class="p-3 text-center">{{ $report->created_at->format('d M Y') }}</td>
                <td class="p-3 text-center">
                    <span class="px-3 py-1 rounded-full text-xs
                        {{ $report->status === 'pending' ? 'bg-yellow-100 text-yellow-700' :
                           ($report->status === 'selesai' ? 'bg-green-100 text-green-700' :
                           'bg-red-100 text-red-700') }}">
                        {{ ucfirst($report->status) }}
                    </span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="p-6 text-center text-gray-500">
                    Belum ada laporan
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

       {{-- Pagination links --}}
    <div class="mt-4">
        {{ $reports->links() }}
    </div>
</div>

@endsection

@push('scripts')
<script>
    const map = L.map('map').setView([-6.2, 106.8], 11);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap'
    }).addTo(map);

    // Ambil array yang sudah diproses di controller
    const reports = @json($reportMarkers);

    function getMarkerColor(status) {
        switch(status){
            case 'pending': return 'yellow';
            case 'selesai': return 'green';
            case 'batal':   return 'red';
            default: return 'blue';
        }
    }

    const markerGroup = [];
    reports.forEach(r => {
        if(r.lat && r.lng){
            // Marker utama
            const icon = L.icon({
                iconUrl: `https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-${getMarkerColor(r.status)}.png`,
                iconSize: [25,41],
                iconAnchor: [12,41],
                popupAnchor: [1,-34],
                shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-shadow.png',
                shadowSize: [41,41]
            });

            const statusLabel = {
                'pending': '<span style="background:#fef08a;color:#854d0e;padding:2px 8px;border-radius:999px;font-size:11px;font-weight:600;">Pending</span>',
                'selesai': '<span style="background:#bbf7d0;color:#166534;padding:2px 8px;border-radius:999px;font-size:11px;font-weight:600;">Selesai</span>',
                'batal':   '<span style="background:#fecaca;color:#991b1b;padding:2px 8px;border-radius:999px;font-size:11px;font-weight:600;">Batal</span>',
            };

            const popupContent = `
                <div style="min-width:200px;font-family:Arial,sans-serif;">
                    <div style="background:#1d4ed8;color:white;padding:8px 12px;border-radius:8px 8px 0 0;margin:-14px -20px 10px -20px;">
                        <b style="font-size:13px;">🌊 ${r.title}</b>
                    </div>
                    <table style="width:100%;font-size:12px;border-collapse:collapse;">
                        <tr>
                            <td style="padding:3px 0;color:#6b7280;">👤 Pelapor</td>
                            <td style="padding:3px 0;font-weight:600;">${r.name}</td>
                        </tr>
                        <tr>
                            <td style="padding:3px 0;color:#6b7280;">📍 Alamat</td>
                            <td style="padding:3px 0;">${r.address}</td>
                        </tr>
                        <tr>
                            <td style="padding:3px 0;color:#6b7280;">📌 Status</td>
                            <td style="padding:3px 0;">${statusLabel[r.status] ?? r.status}</td>
                        </tr>
                    </table>
                </div>
            `;

            const marker = L.marker([r.lat, r.lng], {icon})
            .addTo(map)
            .bindPopup(popupContent, { maxWidth: 250 });
            markerGroup.push(marker);

            // Circle radius halus
            const circle = L.circle([r.lat, r.lng], {
                color: getMarkerColor(r.status),
                fillColor: getMarkerColor(r.status),
                fillOpacity: 0.2,
                radius: 100 // radius dalam meter, bisa disesuaikan
            }).addTo(map);
        }
    });

    // Zoom otomatis sesuai semua marker
    if(markerGroup.length){
        const group = L.featureGroup(markerGroup);
        map.fitBounds(group.getBounds().pad(0.2));
    }
</script>
@endpush
