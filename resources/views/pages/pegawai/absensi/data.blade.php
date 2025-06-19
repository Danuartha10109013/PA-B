@extends('layout.main')
@section('title')
    Dashboard || Pegawai
@endsection
@section('content')
    {{--
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <style>
        body,
        .card,
        .btn,
        .table,
        .modal-content {
            font-family: 'Inter', Arial, sans-serif;
        }

        .history-section {
            max-width: 1100px;
            margin: 0 auto;
            padding: 2.5rem 0 1.5rem 0;
        }

        .history-card {
            border-radius: 18px;
            box-shadow: 0 4px 24px rgba(60, 72, 100, .10);
            border: 1px solid #e6eaf3;
            background: #fff;
            transition: all 0.2s;
            overflow: hidden;
            margin-bottom: 2rem;
        }

        .history-title {
            font-size: 1.35rem;
            font-weight: 700;
            color: #5D87FF;
            margin-bottom: 0.7rem;
            letter-spacing: 0.5px;
        }

        .table-responsive {
            border-radius: 12px;
            overflow: auto;
        }

        .table {
            background: #fff;
            border-radius: 12px;
            margin-bottom: 0;
        }

        .table thead th {
            background: #f6f8fa;
            color: #5D87FF;
            font-weight: 700;
            position: sticky;
            top: 0;
            z-index: 2;
            border-bottom: 2px solid #e6eaf3;
        }

        .table tbody tr {
            transition: background 0.18s;
        }

        .table tbody tr:hover {
            background: #f0f6ff;
        }

        .badge.bg-primary {
            background: linear-gradient(90deg, #6a93ff 0%, #a4cafe 100%) !important;
            color: #fff !important;
            font-weight: 600;
            border-radius: 8px;
            padding: 6px 16px;
            font-size: 0.98rem;
            box-shadow: 0 2px 8px rgba(93, 135, 255, 0.08);
            transition: all 0.18s;
        }

        .badge.bg-primary:hover {
            background: #4b6fd8 !important;
            color: #fff !important;
        }

        .modal-content {
            border-radius: 16px;
            box-shadow: 0 8px 30px rgba(60, 72, 100, .13);
            border: none;
        }

        .modal-header {
            background: linear-gradient(90deg, #6a93ff 0%, #a4cafe 100%);
            color: #fff;
            border-radius: 16px 16px 0 0;
            padding: 1.2rem 1.5rem;
        }

        .modal-title {
            font-weight: 700;
            font-size: 1.15rem;
        }

        .modal-body h6 {
            font-size: 1rem;
            margin-bottom: 0.5rem;
        }

        .modal-body img {
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(60, 72, 100, .10);
            margin-bottom: 1rem;
            max-width: 100%;
            height: auto;
            display: block;
        }

        .modal-footer {
            border-top: none;
            padding: 1rem 1.5rem 1.2rem 1.5rem;
        }

        .modal-footer .btn {
            min-width: 110px;
        }

        .leaflet-container {
            border-radius: 10px;
            box-shadow: 0 1px 6px rgba(60, 72, 100, .07);
            margin-bottom: 1rem;
        }

        @media (max-width: 991px) {
            .history-section {
                padding: 1.2rem 0 0.5rem 0;
            }
        }

        @media (max-width: 767px) {
            .history-section {
                padding: 0.7rem 0 0.2rem 0;
            }

            .history-title {
                font-size: 1.1rem;
            }

            .modal-header,
            .modal-footer {
                padding-left: 0.7rem;
                padding-right: 0.7rem;
            }
        }

        /* Pastikan semua tombol di dalam modal ditampilkan */
        .modal-content button {
            display: block !important;
        }

        /* Mengembalikan aturan untuk tombol close ke default Bootstrap 5 */
        .btn-close {
            background-color: transparent !important;
            opacity: 1 !important;
            filter: invert(1) grayscale(100%) brightness(200%) !important;
            /* Membuat ikon putih jika header gelap */
            border: none !important;
            width: auto !important;
            height: auto !important;
            box-sizing: content-box !important;
            position: relative;
            /* Kembali ke posisi relatif dalam header */
            right: auto;
            top: auto;
            z-index: auto;
        }

        .btn-close:hover {
            opacity: 0.8 !important;
        }
    </style>
    <div class="history-section animate__animated animate__fadeInUp">
        <div class="history-card animate__animated animate__fadeIn">
            <div class="p-4 pb-0">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="history-title">History Absensi</div>
                </div>
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th>Nama</th>
                                <th>Waktu</th>
                                <th>Keterangan</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $users = \App\Models\User::pluck('name', 'id');
                                $noPegawai = \App\Models\User::pluck('no_pegawai', 'id');
                            @endphp
                            @foreach ($absen as $t)
                                <tr>
                                    <td class="text-center">{{$loop->iteration}}</td>
                                    <td>
                                        <div class="fw-semibold">{{ $users[$t->user_id] ?? 'Unknown' }}</div>
                                        <div class="text-muted small">{{ $noPegawai[$t->user_id] ?? 'Unknown' }}</div>
                                    </td>
                                    <td>{{$t->created_at}}</td>
                                    <td>
                                        @php
                                            $createdTime = \Carbon\Carbon::parse($t->created_at)->format('H:i:s');
                                            $keterangan = $t->type === 'masuk'
                                                ? ($createdTime <= '09:00:00' ? 'Tepat Waktu' : 'Terlambat')
                                                : ($createdTime >= '16:00:00' ? 'Tepat Waktu' : 'Pulang Lebih Awal');
                                        @endphp
                                        {{$keterangan}}
                                    </td>
                                    <td>{{$t->type}}</td>
                                    <td>
                                        <span class="badge {{ $t->confirmation == 1 ? 'bg-success' : 'bg-warning' }}">
                                            {{$t->confirmation == 1 ? 'Terverifikasi' : 'Belum Terverifikasi'}}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="#" class="badge bg-primary" data-bs-toggle="modal"
                                            data-bs-target="#detailModalall-{{$t->id}}">
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                                <!-- Modal for Detail -->
                                <div class="modal fade" id="detailModalall-{{$t->id}}" tabindex="-1"
                                    aria-labelledby="detailModalallLabel-{{$t->id}}" aria-hidden="true"
                                    data-bs-backdrop="false">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header" data-bs-theme="dark">
                                                <h5 class="modal-title" id="detailModalallLabel-{{$t->id}}">Detail Absensi</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close">X</button>
                                            </div>
                                            <div class="modal-body">
                                                <h6><strong>Nama:</strong> {{ $users[$t->user_id] ?? 'Unknown' }}</h6>
                                                <h6><strong>No Pegawai:</strong> {{ $noPegawai[$t->user_id] ?? 'Unknown' }}</h6>
                                                @if ($t->type == 'masuk')
                                                    <h6><strong>Bukti Absen:</strong></h6>
                                                    <img src="{{ asset('/' . $t->photo) }}" alt="Bukti Absen"
                                                        class="img-fluid mb-2">
                                                @endif
                                                <h6><strong>Lokasi:</strong> {{$t->location}}</h6>
                                                <div id="maps-{{$t->id}}" style="height: 250px; width: 100%;"></div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                @foreach($absen as $d)
                    $('#detailModalall-{{$d->id}}').on('shown.bs.modal', function () {
                        console.log('Modal shown for ID: {{$d->id}}');

                        // Explicitly remove modal-open class and any lingering backdrops
                        setTimeout(() => {
                            $('body').removeClass('modal-open');
                            $('.modal-backdrop').remove();
                            console.log('Attempted to remove modal-open and modal-backdrop after delay.');
                        }, 50); // Small delay to let Bootstrap fully render its backdrop

                        let locationString = "{{$d->location}}";
                        let locationParts = locationString.split(',');

                        if (locationParts.length === 2) {
                            let latitude = parseFloat(locationParts[0].trim());
                            let longitude = parseFloat(locationParts[1].trim());

                            if (!isNaN(latitude) && !isNaN(longitude)) {
                                try {
                                    // Hancurkan instance peta sebelumnya jika ada
                                    if (window.maps && window.maps['maps-{{$d->id}}']) {
                                        window.maps['maps-{{$d->id}}'].remove();
                                    }

                                    var map = L.map('maps-{{$d->id}}').setView([latitude, longitude], 13);
                                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                                    }).addTo(map);
                                    L.marker([latitude, longitude]).addTo(map)
                                        .bindPopup('Location of {{ $users[$d->user_id] ?? "Unknown" }}').openPopup();

                                    // Simpan instance peta ke objek global agar bisa diakses nanti
                                    window.maps = window.maps || {};
                                    window.maps['maps-{{$d->id}}'] = map;

                                    console.log('Map initialized for ID: {{$d->id}}');
                                } catch (e) {
                                    console.error('Error initializing map for ID {{$d->id}}:', e);
                                }
                            } else {
                                console.error('Invalid latitude or longitude for ID {{$d->id}}:', latitude, longitude);
                            }
                        } else {
                            console.error('Invalid location string format for ID {{$d->id}}:', locationString);
                        }
                    }).on('hidden.bs.modal', function () {
                        // Hancurkan instance peta saat modal ditutup
                        if (window.maps && window.maps['maps-{{$d->id}}']) {
                            window.maps['maps-{{$d->id}}'].remove();
                            delete window.maps['maps-{{$d->id}}'];
                            console.log('Map destroyed for ID: {{$d->id}}');
                        }
                    });
                @endforeach
                                    });
        </script>
    @endpush
@endsection