@extends('layout.main')
@section('title')
    Dashboard || Admin
@endsection
@section('content')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        body,
        .card,
        .btn,
        .form-label,
        .form-control,
        .avatar-input {
            font-family: 'Inter', Arial, sans-serif;
        }

        .profile-section {
            max-width: 700px;
            margin: 0 auto;
            padding: 2.5rem 0 1.5rem 0;
        }

        .profile-card {
            border-radius: 18px;
            box-shadow: 0 4px 24px rgba(60, 72, 100, .10);
            border: 1px solid #e6eaf3;
            background: #fff;
            transition: all 0.2s;
            overflow: hidden;
            margin-bottom: 2rem;
            animation: fadeInUp 0.7s;
        }

        .profile-header {
            background: linear-gradient(90deg, #6a93ff 0%, #a4cafe 100%);
            color: #fff;
            border-radius: 18px 18px 0 0;
            padding: 1.5rem 2rem 1rem 2rem;
            font-weight: 700;
            font-size: 1.3rem;
            letter-spacing: 1px;
            margin-bottom: 0;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .profile-header i {
            font-size: 1.5rem;
        }

        .profile-form {
            padding: 2rem 2rem 1.5rem 2rem;
        }

        .form-label {
            font-weight: 600;
            color: #4a5568;
            margin-bottom: 0.3rem;
            font-size: 0.97rem;
        }

        .form-control,
        .avatar-input,
        .form-control:focus {
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            padding: 10px 15px;
            transition: all 0.18s;
            font-size: 0.98rem;
            background: #f8f9fa;
        }

        .form-control:focus {
            border-color: #6a93ff;
            box-shadow: 0 0 0 2px rgba(93, 135, 255, 0.10);
        }

        .avatar-preview {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid #fff;
            box-shadow: 0 2px 8px rgba(60, 72, 100, .10);
            background: #f6f8fa;
            margin-bottom: 1rem;
            display: block;
        }

        .btn-primary {
            background: linear-gradient(90deg, #6a93ff 0%, #a4cafe 100%);
            border: none;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.18s;
            box-shadow: 0 2px 8px rgba(93, 135, 255, 0.08);
            font-size: 1.05rem;
            padding: 10px 0;
            width: 100%;
            margin-top: 1.2rem;
        }

        .btn-primary:hover {
            background: #4b6fd8;
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(93, 135, 255, 0.13);
        }

        @media (max-width: 767px) {
            .profile-section {
                padding: 1.2rem 0 0.5rem 0;
            }

            .profile-header,
            .profile-form {
                padding-left: 0.7rem;
                padding-right: 0.7rem;
            }

            .profile-header {
                font-size: 1.05rem;
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
    <div class="profile-section animate__animated animate__fadeInUp">
        <div class="profile-card animate__animated animate__fadeIn">
            <div class="profile-header">
                <i class="ti ti-user"></i> Edit Profile
            </div>
            <form action="{{ route('profile.update', Auth::user()->id) }}" method="POST" enctype="multipart/form-data"
                class="profile-form">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" id="name" name="name" class="form-control" value="{{ $data->name }}">
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" id="username" name="username" class="form-control"
                                value="{{ $data->username }}">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" id="email" name="email" class="form-control" value="{{ $data->email }}">
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <input type="text" id="role" name="role" class="form-control"
                                value="{{ $data->role == 0 ? 'Admin' : ($data->role == 1 ? 'Pegawai' : 'cc') }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="no_wa" class="form-label">No WhatsApp</label>
                            <input type="text" class="form-control" id="no_wa" name="no_wa"
                                value="{{ $data->no_wa ?? '' }}">
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea type="text" class="form-control" id="alamat"
                                name="alamat">{{ $data->alamat ?? '' }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-6 text-center">
                        <div class="mb-3">
                            <label for="avatar" class="form-label">Avatar</label>
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $data->profile) }}" alt="{{ $data->profile }}"
                                    class="avatar-preview" id="avatar-preview"
                                    style="{{ $data->profile ? '' : 'display:none;' }}">
                            </div>
                            <input type="file" id="avatar-input" name="avatar" class="form-control avatar-input"
                                onchange="previewImage(event)">
                        </div>
                        <div class="mb-3">
                            <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                            <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir"
                                value="{{ $data->tempat_lahir ?? '' }}">
                        </div>
                        <div class="mb-3">
                            <label for="birthday" class="form-label">Birthday</label>
                            <input type="date" class="form-control" id="birthday" name="birthday"
                                value="{{ $data->birthday ?? '' }}">
                        </div>
                        <div class="mb-3">
                            <label for="gender" class="form-label">Gender</label>
                            <select class="form-control" id="gender" name="gender">
                                <option value="" disabled {{ !$data->gender ? 'selected' : '' }}>--Pilih Gender--</option>
                                <option value="Laki-Laki" {{ $data->gender == 'Laki-Laki' ? 'selected' : '' }}>Laki-Laki
                                </option>
                                <option value="Perempuan" {{ $data->gender == 'Perempuan' ? 'selected' : '' }}>Perempuan
                                </option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">New Password</label>
                            <input type="password" id="password" name="password" class="form-control"
                                placeholder="New Password Here">
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Password Confirmation</label>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                class="form-control" placeholder="Password Confirmation Here">
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
    <script>
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function () {
                const output = document.getElementById('avatar-preview');
                output.src = reader.result;
                output.style.display = 'block';
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
@endsection