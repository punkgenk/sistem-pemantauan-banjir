@extends('layouts.masyarakat')

@section('content')
<div class="container mx-auto px-4 py-6">
    
    {{-- Judul halaman --}}
    <h1 class="text-3xl font-bold mb-6 flex items-center gap-3 text-blue-700">
        <i class="fa-solid fa-inbox"></i>
        Laporan Saya
    </h1>

    {{-- Tabel laporan user --}}
    <div class="bg-white rounded-xl shadow overflow-x-auto mb-8">
        <table class="w-full text-sm table-auto">
            <thead class="bg-blue-100 text-blue-700">
                <tr>
                    <th class="p-4 text-center"><i class="fa-solid fa-file-lines"></i> Judul</th>
                    <th class="p-4 text-center"><i class="fa-solid fa-align-left"></i> Deskripsi</th>
                    <th class="p-4 text-center"><i class="fa-solid fa-calendar-days"></i> Tanggal</th>
                    <th class="p-4 text-center"><i class="fa-solid fa-circle-check"></i> Status</th>
                    <th class="p-4 text-center"><i class="fa-solid fa-image"></i> Foto</th>
                    <th class="p-4 text-center"><i class="fa-solid fa-location-dot"></i> Alamat</th>
                </tr>
            </thead>
            <tbody>
            @forelse($reports as $report)
                <tr class="border-t hover:bg-gray-50 transition">
                    <td class="p-4 font-medium text-center">{{ $report->title }}</td>
                    <td class="p-4 text-gray-600 text-center">{{ Str::limit($report->description, 50) }}</td>
                    <td class="p-4 text-gray-600 text-center">{{ $report->created_at->format('d M Y') }}</td>
                    <td class="p-4 text-center">
                        @php
                            $statusStyle = match($report->status) {
                                'pending' => 'bg-yellow-100 text-yellow-700',
                                'selesai' => 'bg-green-100 text-green-700',
                                'batal'   => 'bg-red-100 text-red-700',
                                default   => 'bg-gray-100 text-gray-600'
                            };
                        @endphp
                        <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusStyle }}">
                            {{ ucfirst($report->status) }}
                        </span>
                    </td>
                    <td class="p-4 text-center">
                        @if($report->photo)
                            <img src="{{ asset('storage/'.$report->photo) }}" class="h-12 w-12 object-cover rounded mx-auto border">
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </td>
                    <td class="p-4 text-center">{{ $report->address ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="p-10 text-center text-gray-500">
                        <i class="fa-solid fa-folder-open text-2xl mb-2"></i><br>
                        Belum ada laporan
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $reports->links() }}
    </div>

    {{-- Notifikasi sukses --}}
    @if(session('success'))
        <div 
            id="toast-success" 
            class="fixed top-6 right-6 bg-green-600 text-white px-6 py-4 rounded-xl shadow-lg flex items-center gap-4 animate-slideIn z-50"
        >
            <i class="fa-solid fa-circle-check text-2xl"></i>
            <span class="font-medium">{{ session('success') }}</span>
            <button onclick="document.getElementById('toast-success').remove()" class="ml-auto text-white hover:text-gray-200">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <style>
            @keyframes slideIn {
                0% { transform: translateX(200%); opacity: 0; }
                100% { transform: translateX(0); opacity: 1; }
            }
            .animate-slideIn { animation: slideIn 0.5s ease-out forwards; }
        </style>
    @endif
{{-- Form buat laporan baru --}}
<h2 class="text-2xl font-bold mb-4 gap-2 text-green-600 flex items-center">
    <i class="fa-solid fa-plus-circle"></i>
    Buat Laporan Baru
</h2>

<form method="POST" action="{{ route('reports.store') }}" enctype="multipart/form-data"
      class="bg-white p-6 rounded-xl shadow max-w-3xl space-y-4">
    @csrf

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        {{-- Judul --}}
        <div>
            <label class="block mb-2 font-semibold"><i class="fa-solid fa-file-lines"></i> Judul Laporan</label>
            <input type="text" name="title" class="w-full border rounded-lg p-2 focus:ring focus:ring-green-200" required>
        </div>

        {{-- Kategori --}}
        <div>
            <label class="block mb-2 font-semibold"><i class="fa-solid fa-layer-group"></i> Kategori Banjir</label>
            <select name="category" class="w-full border rounded-lg p-2 focus:ring focus:ring-green-200" required>
                <option value="">-- Pilih Kategori --</option>
                <option value="genangan">Genangan</option>
                <option value="banjir_sedang">Banjir Sedang</option>
                <option value="banjir_parah">Banjir Parah</option>
            </select>
        </div>

        {{-- Tinggi Air --}}
        <div>
            <label class="block mb-2 font-semibold"><i class="fa-solid fa-water"></i> Estimasi Tinggi Air (cm)</label>
            <input type="number" name="water_height" min="0" max="9999"
                class="w-full border rounded-lg p-2 focus:ring focus:ring-green-200"
                placeholder="Contoh: 30">
        </div>

        {{-- Foto --}}
        <div>
            <label class="block mb-2 font-semibold"><i class="fa-solid fa-image"></i> Foto (Opsional)</label>
            <input type="file" name="photo" class="w-full border rounded-lg p-2">
        </div>

        {{-- Deskripsi --}}
        <div class="md:col-span-2">
            <label class="block mb-2 font-semibold"><i class="fa-solid fa-align-left"></i> Deskripsi</label>
            <textarea name="description" class="w-full border rounded-lg p-2 focus:ring focus:ring-green-200" rows="3" required></textarea>
        </div>

        {{-- Alamat --}}
        <div class="md:col-span-2">
            <label class="block mb-2 font-semibold"><i class="fa-solid fa-location-dot"></i> Alamat</label>
            <input type="text" name="address" id="address" class="w-full border rounded-lg p-3 focus:ring focus:ring-green-200" placeholder="Masukkan alamat" required>
        </div>

        {{-- Koordinat (hidden) --}}
        <input type="hidden" name="latitude" id="latitude">
        <input type="hidden" name="longitude" id="longitude">

        {{-- Peta --}}
        <div class="md:col-span-2">
            <label class="block mb-2 font-semibold"><i class="fa-solid fa-map-location-dot"></i> Pilih Lokasi di Peta</label>
            <div id="map" class="w-full h-64 rounded-xl border"></div>
        </div>
    </div>

    {{-- Tombol Kirim di tengah --}}
    <div class="text-center mt-4">
        <button class="bg-green-600 text-white px-6 py-2 rounded-xl font-semibold hover:bg-green-700 transition flex items-center gap-2 justify-center">
            <i class="fa-solid fa-paper-plane"></i>
            Kirim Laporan
        </button>
    </div>
</form>

@push('scripts')
<script>
    // Inisialisasi peta
    const map = L.map('map').setView([-6.2, 106.8], 11);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap'
    }).addTo(map);

    let marker;

    function setMarker(lat, lng) {
        document.getElementById('latitude').value = lat;
        document.getElementById('longitude').value = lng;

        if(marker) map.removeLayer(marker);
        marker = L.marker([lat, lng]).addTo(map);

        fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}`)
        .then(res => res.json())
        .then(data => {
            if(data.display_name){
                document.getElementById('address').value = data.display_name;
            }
        });
    }

    map.on('click', function(e){
        setMarker(e.latlng.lat, e.latlng.lng);
    });

    if(navigator.geolocation){
        navigator.geolocation.getCurrentPosition(function(position){
            const lat = position.coords.latitude;
            const lng = position.coords.longitude;
            map.setView([lat, lng], 15);
            setMarker(lat, lng);
        });
    }
</script>
@endpush
@endsection
