@extends('layout.main')
@section('title')
  Kelola Pegawai || Admin
@endsection
@section('content')
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body,
    .card,
    .btn,
    .form-label,
    .form-control,
    .table,
    .badge {
    font-family: 'Inter', Arial, sans-serif;
    }

    .modern-card {
    border-radius: 18px;
    box-shadow: 0 4px 24px rgba(60, 72, 100, .10);
    border: 1px solid #e6eaf3;
    background: #fff;
    transition: box-shadow 0.2s, transform 0.2s;
    margin-bottom: 2rem;
    overflow: hidden;
    padding: 2rem 2rem 1.5rem 2rem;
    }

    .modern-card:hover {
    box-shadow: 0 8px 32px rgba(60, 72, 100, .16);
    transform: translateY(-2px) scale(1.01);
    }

    .modern-header {
    display: flex;
    align-items: center;
    gap: 0.7rem;
    font-size: 1.25rem;
    font-weight: 700;
    color: #3b4861;
    margin-bottom: 1.2rem;
    letter-spacing: 0.5px;
    }

    .modern-header i {
    font-size: 1.3rem;
    color: #6a93ff;
    }

    .btn-modern {
    border-radius: 8px;
    background: linear-gradient(90deg, #6a93ff 0%, #a4cafe 100%);
    color: #fff;
    font-weight: 600;
    box-shadow: 0 2px 8px rgba(93, 135, 255, 0.08);
    border: none;
    transition: background 0.18s;
    padding: 8px 18px;
    font-size: 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    }

    .btn-modern:hover {
    background: #4b6fd8;
    color: #fff;
    }

    .table-modern {
    border-radius: 12px;
    overflow: hidden;
    background: #fff;
    box-shadow: 0 2px 12px rgba(60, 72, 100, .07);
    }

    .table-modern th {
    background: #f4f7fe;
    font-weight: 700;
    color: #3b4861;
    position: sticky;
    top: 0;
    z-index: 2;
    text-align: center;
    }

    .table-modern td,
    .table-modern th {
    vertical-align: middle;
    padding: 0.7rem 0.8rem;
    border-bottom: 1px solid #e6eaf3;
    text-align: center;
    }

    .table-modern tr:hover {
    background: #f0f6ff;
    transition: background 0.18s;
    }

    .avatar-table {
    width: 48px;
    height: 48px;
    object-fit: cover;
    border-radius: 50%;
    border: 3px solid #e6eaf3;
    box-shadow: 0 2px 8px rgba(60, 72, 100, .10);
    margin: 0 auto;
    background: #f8faff;
    }

    .badge-status {
    border-radius: 8px;
    padding: 0.3em 0.8em;
    font-size: 0.93rem;
    font-weight: 600;
    color: #fff;
    background: #6a93ff;
    margin-right: 0.3em;
    display: inline-block;
    }

    .badge-status.active {
    background: #4caf50;
    }

    .badge-status.nonactive {
    background: #ff6b6b;
    }

    .modal-content {
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 8px 32px rgba(60, 72, 100, .13);
    }

    .modal-header {
    background: linear-gradient(90deg, #6a93ff 0%, #a4cafe 100%);
    color: #fff;
    border-bottom: none;
    padding: 1.2rem 1.5rem;
    }

    .modal-title {
    font-weight: 700;
    font-size: 1.15rem;
    letter-spacing: 0.5px;
    }

    .form-label {
    font-weight: 600;
    color: #4a5568;
    margin-bottom: 0.3rem;
    font-size: 0.97rem;
    }

    .form-control {
    border-radius: 8px;
    border: 1px solid #e2e8f0;
    padding: 10px 15px;
    font-size: 0.98rem;
    background: #f8f9fa;
    margin-bottom: 0.7rem;
    }

    .form-control:focus {
    border-color: #6a93ff;
    box-shadow: 0 0 0 2px rgba(93, 135, 255, 0.10);
    }

    .avatar-preview-modal {
    width: 100px;
    height: 100px;
    object-fit: cover;
    border-radius: 50%;
    border: 4px solid #fff;
    box-shadow: 0 2px 8px rgba(60, 72, 100, .10);
    background: #f6f8fa;
    margin-bottom: 1rem;
    display: block;
    margin-left: auto;
    margin-right: auto;
    }

    .btn-modal {
    width: 100%;
    border-radius: 8px;
    background: linear-gradient(90deg, #6a93ff 0%, #a4cafe 100%);
    color: #fff;
    font-weight: 600;
    box-shadow: 0 2px 8px rgba(93, 135, 255, 0.08);
    border: none;
    transition: background 0.18s;
    padding: 10px 0;
    margin-top: 1rem;
    }

    .btn-modal:hover {
    background: #4b6fd8;
    color: #fff;
    }
  </style>
  @php
    $isNew = !$data || !$data->latitude || !$data->longitude;
@endphp

@if ($isNew)
    <script>alert('Silakan pilih lokasi terlebih dahulu!');</script>
@endif

<div class="row">
    <div class="col-lg-12 d-flex align-items-stretch">
        <div class="modern-card w-100">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="modern-header"><i class="fa fa-location"></i> Kelola Lokasi</div>
            </div>

            <form action="{{ $isNew ? route('admin.klocation.store') : route('admin.klocation.update', $data->id) }}" method="POST">
                @csrf
                @if(!$isNew)
                    @method('PUT')
                @endif

                <div id="map" style="height: 400px;" class="mb-3"></div>

                <div class="mb-2">
                    <label>Latitude</label>
                    <input type="text" id="latitude" name="latitude" class="form-control" value="{{ old('latitude', $data->latitude ?? '') }}" readonly>
                </div>
                <div class="mb-2">
                    <label>Longitude</label>
                    <input type="text" id="longitude" name="longitude" class="form-control" value="{{ old('longitude', $data->longitude ?? '') }}" readonly>
                </div>
                <div class="mb-2">
                    <label>Alamat</label>
                    <input type="text" id="alamat" name="alamat" class="form-control" value="{{ old('alamat', $data->alamat ?? '') }}" readonly>
                </div>
                <div class="mb-2">
                    <label>Jarak Diperbolehkan (meter)</label>
                    <input type="number" name="jarak" class="form-control" value="{{ old('jarak', $data->jarak ?? '') }}" required>
                </div>

                <button type="submit" class="btn btn-success">Simpan Lokasi</button>
            </form>
        </div>
    </div>
</div>

{{-- Leaflet JS & CSS --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

{{-- Optional: Nominatim Reverse Geocoding --}}
<script>
    let map = L.map('map').setView([{{ $data->latitude ?? '-6.200000' }}, {{ $data->longitude ?? '106.816666' }}], 13);
    let marker;

    // Tile
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    // Pasang marker jika sudah ada data
    @if(!$isNew)
        marker = L.marker([{{ $data->latitude }}, {{ $data->longitude }}]).addTo(map);
    @endif

    // Saat klik peta
    map.on('click', function(e) {
        const lat = e.latlng.lat;
        const lng = e.latlng.lng;

        if (marker) {
            marker.setLatLng(e.latlng);
        } else {
            marker = L.marker(e.latlng).addTo(map);
        }

        document.getElementById('latitude').value = lat;
        document.getElementById('longitude').value = lng;

        // Reverse Geocoding pakai Nominatim
        fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('alamat').value = data.display_name || '';
            })
            .catch(() => {
                document.getElementById('alamat').value = '';
            });
    });
</script>


  @endsection