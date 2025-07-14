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
                    <input type="text" class="form-control" id="location_pulang" name="location_pulang" readonly>
                    <!-- Map container -->
                    <div id="map_pulang" style="width: 100%; height: 200px;"></div>
                </div>
                <div class="mb-3">
                    <label for="photo_pulang" class="form-label">Photo</label>
                    <!-- Video for live stream -->
                    <video id="video_pulang" width="100%" height="200" autoplay></video>
                    <!-- Canvas for captured photo -->
                    <canvas id="canvas_pulang" style="display: none;"></canvas>
                    <input type="hidden" id="photo_pulang" name="photo_pulang">
                    <button type="button" class="btn btn-primary mt-2" id="capture_pulang">Capture Photo</button>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
@endsection

<!-- Include Leaflet JS and CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<!-- Tambahkan Leaflet CSS dan JS jika belum -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<!-- Include Leaflet CSS & JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<!-- Countdown style -->
<style>
    #countdown {
        font-size: 50px;
        font-weight: bold;
        color: red;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 10;
        display: none;
    }
</style>

<!-- Countdown Element -->
<div id="countdown"></div>

<script>
    let lokasiResmi = {
        lat: {{ $lokasi->latitude }},
        lng: {{ $lokasi->longitude }},
        radius: {{ $lokasi->jarak }} // meter
    };

    let userLocation = null;

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
            navigator.geolocation.getCurrentPosition(function (position) {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;
                userLocation = { lat, lng };
                document.getElementById(locationInputId).value = `${lat}, ${lng}`;

                let map = L.map(elementId).setView([lat, lng], 17);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors'
                }).addTo(map);

                L.marker([lat, lng]).addTo(map).bindPopup("Lokasi Anda").openPopup();
                L.circle([lokasiResmi.lat, lokasiResmi.lng], {
                    color: 'green',
                    fillColor: '#0f03',
                    fillOpacity: 0.3,
                    radius: lokasiResmi.radius
                }).addTo(map).bindPopup("Area Absensi");
                L.marker([lokasiResmi.lat, lokasiResmi.lng]).addTo(map).bindPopup("Lokasi Diperbolehkan");
            }, function (error) {
                alert("Tidak bisa mendapatkan lokasi: " + error.message);
            });
        } else {
            alert("Geolocation tidak didukung browser ini.");
        }
    }

    function setupVideoCapture(videoId, canvasId, photoInputId, captureButtonId) {
        const video = document.getElementById(videoId);
        const canvas = document.getElementById(canvasId);
        const photoInput = document.getElementById(photoInputId);
        const captureButton = document.getElementById(captureButtonId);
        const countdownEl = document.getElementById('countdown');

        // Preview foto
        const previewImg = document.createElement('img');
        previewImg.id = "preview_photo";
        previewImg.style.maxWidth = "100%";
        previewImg.classList.add("mt-3");
        captureButton.parentNode.appendChild(previewImg);

        if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
            navigator.mediaDevices.getUserMedia({ video: true }).then(function (stream) {
                video.srcObject = stream;
                video.play();
            }).catch(function (err) {
                alert("Tidak dapat mengakses kamera: " + err.message);
            });
        } else {
            alert("Perangkat tidak mendukung kamera");
        }

        captureButton.addEventListener('click', function () {
            let count = 3;
            countdownEl.style.display = 'block';
            countdownEl.innerText = count;

            const countdownInterval = setInterval(() => {
                count--;
                if (count <= 0) {
                    clearInterval(countdownInterval);
                    countdownEl.style.display = 'none';

                    const context = canvas.getContext('2d');
                    canvas.width = video.videoWidth;
                    canvas.height = video.videoHeight;
                    context.drawImage(video, 0, 0, canvas.width, canvas.height);

                    const imageData = canvas.toDataURL('image/png');
                    photoInput.value = imageData;

                    // tampilkan preview
                    previewImg.src = imageData;

                    alert('Foto berhasil diambil!');
                } else {
                    countdownEl.innerText = count;
                }
            }, 1000);
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        initializeMap('map_pulang', 'location_pulang');
        setupVideoCapture('video_pulang', 'canvas_pulang', 'photo_pulang', 'capture_pulang');

        document.querySelector('form').addEventListener('submit', function (e) {
            if (!userLocation) {
                e.preventDefault();
                alert("Lokasi belum terdeteksi.");
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
                alert(`Anda di luar radius absensi! (${Math.round(distance)} meter)`);
            }

            if (!document.getElementById('photo_pulang').value) {
                e.preventDefault();
                alert("Silakan ambil foto terlebih dahulu.");
            }
        });
    });
</script>


