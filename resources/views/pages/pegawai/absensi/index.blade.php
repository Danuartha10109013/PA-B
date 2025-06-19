@extends('layout.main')
@section('title')
    Dashboard || Pegawai
@endsection
@section('content')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        body,
        .card,
        .btn,
        .card-title,
        .card-text {
            font-family: 'Inter', Arial, sans-serif;
        }

        .absensi-section {
            max-width: 900px;
            margin: 0 auto;
            padding: 2.5rem 0 1.5rem 0;
        }

        .absensi-card {
            border-radius: 18px;
            box-shadow: 0 4px 24px rgba(60, 72, 100, .10);
            border: 1px solid #e6eaf3;
            background: #fff;
            transition: all 0.2s;
            overflow: hidden;
            margin-bottom: 2rem;
            min-height: 320px;
        }

        .absensi-card:hover {
            box-shadow: 0 8px 30px rgba(60, 72, 100, .13);
            transform: translateY(-2px) scale(1.01);
        }

        .absensi-img {
            width: 70px;
            height: 70px;
            object-fit: contain;
            margin: 0 auto 18px auto;
            display: block;
            border-radius: 14px;
            background: #f6f8fa;
            box-shadow: 0 2px 8px rgba(60, 72, 100, .08);
            padding: 10px;
        }

        .absensi-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #5D87FF;
            margin-bottom: 0.7rem;
            letter-spacing: 0.5px;
        }

        .absensi-desc {
            font-size: 1.01rem;
            color: #4a5568;
            margin-bottom: 0.5rem;
            min-height: 48px;
        }

        .absensi-link {
            text-decoration: none;
            color: inherit;
            transition: all 0.2s;
        }

        .absensi-link:hover .absensi-card {
            border-color: #5D87FF;
            box-shadow: 0 8px 30px rgba(93, 135, 255, 0.13);
        }

        @media (max-width: 991px) {
            .absensi-section {
                padding: 1.2rem 0 0.5rem 0;
            }

            .absensi-card {
                min-height: 260px;
            }
        }

        @media (max-width: 767px) {
            .absensi-section {
                padding: 0.7rem 0 0.2rem 0;
            }

            .absensi-card {
                min-height: 180px;
            }

            .absensi-img {
                width: 48px;
                height: 48px;
                padding: 6px;
            }
        }
    </style>
    <div class="absensi-section animate__animated animate__fadeInUp">
        <div class="row g-4">
            <div class="col-md-6">
                <a href="{{ route('pegawai.absensi.masuk') }}" class="absensi-link">
                    <div class="absensi-card text-center animate__animated animate__fadeInLeft">
                        <img src="{{asset('imageuser.svg')}}" class="absensi-img" alt="Absen Masuk">
                        <div class="absensi-title">Absen Masuk</div>
                        <div class="absensi-desc">Absensi harus dilakukan sebelum jam masuk. Jika dilakukan setelah jam
                            masuk akan terdeteksi sebagai terlambat. Lakukan absen saat sudah berada di area kantor.</div>
                    </div>
                </a>
            </div>
            <div class="col-md-6">
                <a href="{{ route('pegawai.absensi.pulang') }}" class="absensi-link">
                    <div class="absensi-card text-center animate__animated animate__fadeInRight">
                        <img src="{{asset('location.svg')}}" class="absensi-img" alt="Absen Pulang">
                        <div class="absensi-title">Absen Pulang</div>
                        <div class="absensi-desc">Absen bisa dilakukan setelah jam pulang. Jika dilakukan sebelum pulang
                            maka akan terdeteksi pulang kurang dari jam kerja. Lakukan absen saat masih berada di area
                            kantor.</div>
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection