
@extends('layout.main')
@section('title')
    Absensi Pulang || Pegawai
@endsection
@section('content')
<div class="container-fluid">
    <form action="{{ route('pegawai.absensi.pulang.store') }}" method="POST">
        @csrf
        <div class="modal-body">
            <div class="mb-3">
                <label for="location_pulang" class="form-label">Location</label>
                <input type="text" class="form-control mb-3" id="location_pulang" name="location_pulang" readonly>
                <div id="map_pulang" style="width: 100%; height: 200px;"></div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>
@endsection

<!-- Include Leaflet JS and CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
    // Lokasi yang diperbolehkan (dari database)
    let lokasiResmi = {
        lat: {{ $lokasi->latitude }},
        lng: {{ $lokasi->longitude }},
        radius: {{ $lokasi->jarak }} // meter
    };

    let userLocation = null;

    // Fungsi menghitung jarak antara dua titik koordinat
    function getDistance(lat1, lon1, lat2, lon2) {
        const R = 6371000;
        const toRad = x => x * Math.PI / 180;
        const dLat = toRad(lat2 - lat1);
        const dLon = toRad(lon2 - lon1);
        const a = Math.sin(dLat / 2) ** 2 +
                  Math.cos(toRad(lat1)) * Math.cos(toRad(lat2)) *
                  Math.sin(dLon / 2) ** 2;
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        return R * c;
    }

    function initializeMap(elementId, locationInputId) {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;
                userLocation = { lat, lng };

                document.getElementById(locationInputId).value = `${lat}, ${lng}`;

                let map = L.map(elementId).setView([lat, lng], 17);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors'
                }).addTo(map);

                // Marker posisi user
                L.marker([lat, lng]).addTo(map).bindPopup("Lokasi Anda").openPopup();

                // Lingkaran radius absensi
                L.circle([lokasiResmi.lat, lokasiResmi.lng], {
                    color: 'blue',
                    fillColor: '#03f3',
                    fillOpacity: 0.3,
                    radius: lokasiResmi.radius
                }).addTo(map).bindPopup("Area Absensi Diperbolehkan");

                // Marker titik absensi resmi
                L.marker([lokasiResmi.lat, lokasiResmi.lng]).addTo(map).bindPopup("Titik Resmi Absensi");
            }, function(error) {
                alert("Gagal mendapatkan lokasi Anda: " + error.message);
            });
        } else {
            alert("Browser Anda tidak mendukung geolocation.");
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        initializeMap('map_pulang', 'location_pulang');

        document.querySelector('form').addEventListener('submit', function (e) {
            if (!userLocation) {
                e.preventDefault();
                alert("Lokasi Anda belum terdeteksi.");
                return;
            }

            const distance = getDistance(
                userLocation.lat,
                userLocation.lng,
                lokasiResmi.lat,
                lokasiResmi.lng
            );

            if (distance > lokasiResmi.radius) {
                e.preventDefault();
                alert(`Anda berada di luar radius lokasi absensi! Jarak Anda: ${Math.round(distance)} meter`);
            }
        });
    });
</script>
