@extends('layout.main')
@section('title')
    Dashboard || Pegawai
@endsection
@section('content')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body,
        .card,
        .form-select,
        .btn {
            font-family: 'Inter', Arial, sans-serif;
        }

        .dashboard-gradient {
            background: linear-gradient(90deg, #6a93ff 0%, #a4cafe 100%);
            color: #fff;
            border-radius: 18px 18px 0 0;
            padding: 1.2rem 1.5rem 1.2rem 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 12px rgba(60, 72, 100, .08);
        }

        .dashboard-gradient h2 {
            font-weight: 700;
            letter-spacing: 1px;
            margin-bottom: 0;
            font-size: 1.5rem;
        }

        .dashboard-gradient p {
            opacity: 0.92;
            margin-bottom: 0;
            font-size: 1rem;
        }

        .card {
            border-radius: 16px;
            box-shadow: 0 2px 12px rgba(60, 72, 100, .08);
            border: 1px solid #e6eaf3;
            transition: all 0.2s;
            background: #fff;
        }

        .card:hover {
            transform: translateY(-2px) scale(1.01);
            box-shadow: 0 8px 24px rgba(60, 72, 100, .13);
        }

        .card-body {
            padding: 1.5rem 1.2rem;
        }

        .btn-primary {
            background: linear-gradient(90deg, #6a93ff 0%, #a4cafe 100%);
            border: none;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.2s;
            box-shadow: 0 2px 8px rgba(93, 135, 255, 0.10);
        }

        .btn-primary:hover {
            background: #4b6fd8;
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(93, 135, 255, 0.13);
        }

        .form-select {
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            padding: 8px 12px;
            transition: all 0.2s;
            font-size: 1rem;
        }

        .form-select:focus {
            border-color: #6a93ff;
            box-shadow: 0 0 0 2px rgba(93, 135, 255, 0.10);
        }

        .dashboard-icon {
            font-size: 2rem;
            margin-right: 12px;
            color: #fff;
            background: rgba(255, 255, 255, 0.18);
            border-radius: 50%;
            padding: 8px;
            box-shadow: 0 2px 8px rgba(60, 72, 100, .10);
        }

        .dashboard-card-link {
            text-decoration: none;
            color: inherit;
            transition: all 0.2s;
        }

        .dashboard-card-link:hover .card {
            border-color: #6a93ff;
            box-shadow: 0 6px 18px rgba(93, 135, 255, 0.13);
        }

        .dashboard-img {
            width: 40px;
            height: 40px;
            object-fit: contain;
            margin-bottom: 10px;
            border-radius: 10px;
            box-shadow: 0 1px 4px rgba(60, 72, 100, .08);
            background: #f6f8fa;
            padding: 5px;
        }

        .dashboard-label {
            font-size: 1.05rem;
            font-weight: 600;
            margin-bottom: 0.4rem;
        }

        .dashboard-section {
            margin-bottom: 1.5rem;
        }

        .chart-card {
            background: #f8faff;
            border-radius: 14px;
            box-shadow: 0 1px 6px rgba(60, 72, 100, .07);
            padding: 1.2rem 1rem 1.5rem 1rem;
            margin-bottom: 0.5rem;
        }

        @media (max-width: 991px) {

            .dashboard-gradient,
            .card-body,
            .chart-card {
                padding: 1rem 0.7rem;
            }

            .dashboard-section {
                margin-bottom: 1rem;
            }
        }

        @media (max-width: 767px) {
            .dashboard-gradient h2 {
                font-size: 1.1rem;
            }

            .dashboard-gradient p {
                font-size: 0.95rem;
            }

            .dashboard-img {
                width: 32px;
                height: 32px;
            }
        }
    </style>

    <div class="dashboard-gradient animate__animated animate__fadeInDown mb-4">
        <div class="d-flex align-items-center">
            <i class="fas fa-user-tie dashboard-icon"></i>
            <div>
                <h2 class="mb-1">Dashboard Pegawai</h2>
                <p class="mb-0">Selamat datang, {{ Auth::user()->name }}! Pantau absensi dan aktivitas Anda di sini.</p>
            </div>
        </div>
    </div>

    <div class="row animate__animated animate__fadeInUp">
        <div class="col-lg-8 d-flex align-items-stretch dashboard-section">
            <div class="card w-100 chart-card">
                <div class="card-body">
                    <div class="d-sm-flex d-block align-items-center justify-content-between mb-3">
                        <div class="mb-2 mb-sm-0">
                            <h5 class="card-title fw-semibold mb-2">Absensi Bulanan</h5>
                            <form action="{{ route('pegawai.dashboard') }}" method="GET">
                                <div class="d-flex align-items-center flex-wrap gap-2">
                                    <select name="bulan" class="form-select me-2 mb-2 mb-md-0">
                                        <option value="" selected>Pilih Bulan</option>
                                        @for ($i = 1; $i <= 12; $i++)
                                            <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>
                                                {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                                            </option>
                                        @endfor
                                    </select>
                                    <select name="tahun" class="form-select me-2 mb-2 mb-md-0">
                                        <option value="" selected>Pilih Tahun</option>
                                        @for ($year = now()->year; $year >= now()->year - 5; $year--)
                                            <option value="{{ $year }}" {{ request('tahun') == $year ? 'selected' : '' }}>
                                                {{ $year }}
                                            </option>
                                        @endfor
                                    </select>
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <canvas id="absensiChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-4 dashboard-section">
            <div class="row g-4">
                <div class="col-12">
                    <a href="{{ route('pegawai.absensi.masuk') }}" class="dashboard-card-link">
                        <div class="card animate__animated animate__fadeInRight">
                            <div class="card-body text-center">
                                <img src="{{asset('imageuser.svg')}}" class="dashboard-img" alt="Absen Masuk">
                                <div class="dashboard-label">Absen Masuk</div>
                                <span class="text-muted">Klik untuk melakukan absen masuk</span>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12">
                    <a href="{{ route('pegawai.absensi.pulang') }}" class="dashboard-card-link">
                        <div class="card animate__animated animate__fadeInRight">
                            <div class="card-body text-center">
                                <img src="{{asset('location.svg')}}" class="dashboard-img" alt="Absen Pulang">
                                <div class="dashboard-label">Absen Pulang</div>
                                <span class="text-muted">Klik untuk melakukan absen pulang</span>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('absensiChart').getContext('2d');

            const data = {
                labels: ['Absen Masuk', 'Absen Pulang'],
                datasets: [{
                    label: 'Absensi',
                    data: [{{ $masuk }}, {{ $pulang }}],
                    backgroundColor: ['#4caf50', '#f44336'],
                    hoverBackgroundColor: ['#66bb6a', '#e57373'],
                }]
            };

            const subData = {
                masukTepat: {{ $masukTepat }},
                telatMasuk: {{ $telatMasuk }},
                pulangTepat: {{ $pulangTepat }},
                pulangLebihAwal: {{ $pulangLebihAwal }}
                };

            new Chart(ctx, {
                type: 'pie',
                data: data,
                options: {
                    responsive: true,
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function (tooltipItem) {
                                    const label = tooltipItem.label;
                                    if (label === 'Absen Masuk') {
                                        return [
                                            `Tepat Waktu: ${subData.masukTepat}`,
                                            `Telat: ${subData.telatMasuk}`
                                        ];
                                    } else if (label === 'Absen Pulang') {
                                        return [
                                            `Tepat Waktu: ${subData.pulangTepat}`,
                                            `Lebih Awal: ${subData.pulangLebihAwal}`
                                        ];
                                    }
                                    return tooltipItem.label;
                                }
                            }
                        },
                        legend: {
                            position: 'bottom',
                        },
                    }
                }
            });
        });
    </script>
@endsection