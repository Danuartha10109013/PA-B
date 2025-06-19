@extends('layout.main')
@section('title')
    All Karyawan || {{ Auth::user()->role == 0 ? 'Admin' : 'Pegawai' }}
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

        .karyawan-section {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2.5rem 0 1.5rem 0;
        }

        .karyawan-title {
            font-size: 1.7rem;
            font-weight: 700;
            color: #5D87FF;
            margin-bottom: 2.2rem;
            letter-spacing: 0.5px;
            text-align: center;
        }

        .karyawan-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 2rem;
            justify-content: center;
        }

        .karyawan-card {
            border-radius: 18px;
            box-shadow: 0 4px 24px rgba(60, 72, 100, .10);
            border: 1px solid #e6eaf3;
            background: #fff;
            transition: all 0.2s;
            overflow: hidden;
            width: 320px;
            min-width: 260px;
            max-width: 100%;
            margin-bottom: 0.5rem;
            display: flex;
            flex-direction: column;
            align-items: stretch;
            animation: fadeInUp 0.7s;
        }

        .karyawan-card:hover {
            box-shadow: 0 8px 30px rgba(60, 72, 100, .13);
            transform: translateY(-4px) scale(1.01);
        }

        .karyawan-header {
            background: linear-gradient(90deg, #6a93ff 0%, #a4cafe 100%);
            padding: 2rem 0 1.2rem 0;
            border-radius: 18px 18px 0 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .karyawan-photo {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid #fff;
            box-shadow: 0 2px 8px rgba(60, 72, 100, .10);
            background: #f6f8fa;
            margin-bottom: 0.5rem;
        }

        .karyawan-body {
            padding: 1.2rem 1.2rem 1.2rem 1.2rem;
            text-align: center;
            flex: 1 1 auto;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .karyawan-name {
            font-size: 1.18rem;
            font-weight: 700;
            color: #5D87FF;
            margin-bottom: 0.5rem;
        }

        .karyawan-info {
            font-size: 1.01rem;
            color: #4a5568;
            margin-bottom: 1.1rem;
            line-height: 1.6;
        }

        .karyawan-info strong {
            color: #5D87FF;
            font-weight: 600;
        }

        .wa-btn {
            background: linear-gradient(90deg, #25d366 0%, #128c7e 100%);
            color: #fff;
            font-weight: 600;
            border: none;
            border-radius: 8px;
            padding: 10px 0;
            width: 100%;
            font-size: 1.05rem;
            box-shadow: 0 2px 8px rgba(37, 211, 102, 0.10);
            transition: all 0.18s;
            margin-top: auto;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.7rem;
        }

        .wa-btn:hover {
            background: #128c7e;
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(37, 211, 102, 0.13);
        }

        .wa-btn i {
            font-size: 1.3rem;
        }

        @media (max-width: 991px) {
            .karyawan-section {
                padding: 1.2rem 0 0.5rem 0;
            }

            .karyawan-card {
                width: 100%;
                min-width: 0;
            }

            .karyawan-grid {
                gap: 1.2rem;
            }
        }

        @media (max-width: 575px) {
            .karyawan-header {
                padding: 1.2rem 0 0.7rem 0;
            }

            .karyawan-body {
                padding: 0.8rem 0.7rem 0.8rem 0.7rem;
            }

            .karyawan-title {
                font-size: 1.1rem;
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
    <div class="karyawan-section animate__animated animate__fadeInUp">
        <div class="karyawan-title">All Karyawan</div>
        <div class="karyawan-grid">
            @php
                $users = \App\Models\User::all();
            @endphp
            @foreach ($users as $user)
                <div class="karyawan-card animate__animated animate__fadeIn">
                    <div class="karyawan-header">
                        <img src="{{ $user->profile ? asset('storage/' . $user->profile) : asset('PT. Bersama Sahabat Makmur Logo.png') }}"
                            alt="{{ $user->profile }}" class="karyawan-photo">
                    </div>
                    <div class="karyawan-body">
                        <div class="karyawan-name">{{ $user->name }}</div>
                        <div class="karyawan-info">
                            <strong>Jabatan:</strong> {{ $user->jabatan ?? 'N/A' }}<br>
                            <strong>Tempat Lahir:</strong> {{ $user->tempat_lahir ?? 'N/A' }}<br>
                            <strong>Tanggal Lahir:</strong>
                            {{ $user->birthday ? \Carbon\Carbon::parse($user->birthday)->format('d M Y') : 'N/A' }}<br>
                            <strong>Umur:</strong>
                            {{ $user->birthday ? \Carbon\Carbon::parse($user->birthday)->age . ' tahun' : 'N/A' }}<br>
                            <strong>Alamat:</strong> {{ $user->alamat ?? 'N/A' }}<br>
                            <strong>Email:</strong> {{ $user->email }}
                        </div>
                        <a target="_blank"
                            href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $user->no_wa)) }}"
                            class="wa-btn">
                            <i class="fa-brands fa-whatsapp"></i> WhatsApp
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection