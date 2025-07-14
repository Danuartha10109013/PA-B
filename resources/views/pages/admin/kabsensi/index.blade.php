@extends('layout.main')
@section('title')
    Kelola Pegawai || Admin
@endsection
@section('content')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
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
            padding: 2rem;
        }

        .modern-card:hover {
            box-shadow: 0 8px 32px rgba(60, 72, 100, .16);
            transform: translateY(-2px);
        }

        .modern-card.no-hover:hover {
            box-shadow: 0 4px 24px rgba(60, 72, 100, .10);
            transform: none;
        }

        .modern-header {
            display: flex;
            align-items: center;
            gap: 0.7rem;
            font-size: 1.35rem;
            font-weight: 700;
            color: #3b4861;
            margin-bottom: 1.5rem;
            letter-spacing: 0.5px;
        }

        .modern-header i {
            font-size: 1.5rem;
            color: #6a93ff;
        }

        .modern-subheader {
            font-size: 1.1rem;
            font-weight: 600;
            color: #4a5568;
            margin-bottom: 1rem;
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
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-modern:hover {
            background: #4b6fd8;
            color: #fff;
        }

        .btn-modern i {
            font-size: 1.1rem;
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
            padding: 0.8rem 1rem;
            border-bottom: 1px solid #e6eaf3;
            text-align: center;
        }

        .table-modern td:first-child,
        .table-modern th:first-child {
            padding-left: 1.5rem;
        }

        .table-modern td:last-child,
        .table-modern th:last-child {
            padding-right: 1.5rem;
        }

        .table-modern tr:hover {
            background: #f0f6ff;
            transition: background 0.18s;
        }

        .badge-status {
            border-radius: 8px;
            padding: 0.3em 0.8em;
            font-size: 0.93rem;
            font-weight: 600;
            color: #fff;
            background: #6a93ff;
            display: inline-block;
        }

        .badge-status.verified {
            background: #4caf50;
        }

        .badge-status.unverified {
            background: #ff6b6b;
        }

        .badge-status.ontime {
            background: #4caf50;
        }

        .badge-status.late {
            background: #ff6b6b;
        }

        .badge-status.early {
            background: #ffb347;
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
            font-size: 1.2rem;
            letter-spacing: 0.5px;
        }

        .modal-body {
            padding: 1.5rem;
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

        .map-card,
        .photo-card {
            border-radius: 14px;
            background: #f8faff;
            box-shadow: 0 2px 8px rgba(60, 72, 100, .07);
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .photo-card img {
            width: 100%;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(60, 72, 100, .10);
            background: #fff;
        }

        .modal-footer {
            border-top: 1px solid #e6eaf3;
            padding: 1rem 1.5rem;
        }
    </style>

    <div class="row g-4">
        {{-- Absensi Masuk Section --}}
        <div class="col-lg-12">
            <div class="modern-card w-100">
                <div class="modern-header mb-4"><i class="fa fa-sign-in-alt"></i> Absensi Masuk</div>
                <div class="row g-4">
                    {{-- Absensi Tepat Masuk --}}
                    <div class="col-md-6">
                        <div class="modern-card w-100 no-hover p-4">
                            <div class="modern-subheader">Tepat Waktu</div>
                            <div class="table-responsive">
                                <table class="table-modern table text-nowrap mb-0 align-middle">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th>Name</th>
                                            <th>Time</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tepatmasuk as $t)
                                            <tr>
                                                <td class="text-center">{{$loop->iteration}}</td>
                                                <td>
                                                    @php
                                                        $nama = \App\Models\User::where('id', $t->user_id)->value('name');
                                                        $no_pegawai = \App\Models\User::where('id', $t->user_id)->value('no_pegawai');
                                                    @endphp
                                                    <span class="fw-semibold d-block">{{$nama}}</span>
                                                    <span class="fw-normal text-muted"
                                                        style="font-size:0.97em;">{{$no_pegawai}}</span>
                                                </td>
                                                <td><span
                                                        class="fw-normal">{{ \Carbon\Carbon::parse($t->created_at)->format('H:i:s') }}</span>
                                                </td>
                                                <td>
                                                    @if($t->confirmation == 1)
                                                        <span class="badge-status verified">Terverifikasi</span>
                                                    @else
                                                        <span class="badge-status unverified">Belum Terverifikasi</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="#" class="btn btn-modern py-1 px-2" data-bs-toggle="modal"
                                                        data-bs-target="#detailModalMasuk-{{$t->id}}" title="Detail Absensi"><i
                                                            class="fa fa-eye"></i> Detail</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    {{-- Absensi Terlambat Masuk --}}
                    <div class="col-md-6">
                        <div class="modern-card w-100 no-hover p-4">
                            <div class="modern-subheader">Terlambat</div>
                            <div class="table-responsive">
                                <table class="table-modern table text-nowrap mb-0 align-middle">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th>Name</th>
                                            <th>Time</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($telatmasuk as $d)
                                            <tr>
                                                <td class="text-center">{{$loop->iteration}}</td>
                                                <td>
                                                    @php
                                                        $nama = \App\Models\User::where('id', $d->user_id)->value('name');
                                                        $no_pegawai = \App\Models\User::where('id', $d->user_id)->value('no_pegawai');
                                                    @endphp
                                                    <span class="fw-semibold d-block">{{$nama}}</span>
                                                    <span class="fw-normal text-muted"
                                                        style="font-size:0.97em;">{{$no_pegawai}}</span>
                                                </td>
                                                <td><span
                                                        class="fw-normal">{{ \Carbon\Carbon::parse($d->created_at)->format('H:i:s') }}</span>
                                                </td>
                                                <td>
                                                    @if($d->confirmation == 1)
                                                        <span class="badge-status verified">Terverifikasi</span>
                                                    @else
                                                        <span class="badge-status unverified">Belum Terverifikasi</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="#" class="btn btn-modern py-1 px-2" data-bs-toggle="modal"
                                                        data-bs-target="#detailModalMasuk-{{$d->id}}" title="Detail Absensi"><i
                                                            class="fa fa-eye"></i> Detail</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Absensi Pulang Section --}}
        <div class="col-lg-12">
            <div class="modern-card w-100">
                <div class="modern-header mb-4"><i class="fa fa-sign-out-alt"></i> Absensi Pulang</div>
                <div class="row g-4">
                    {{-- Absensi Tepat Pulang --}}
                    <div class="col-md-6">
                        <div class="modern-card w-100 no-hover p-4">
                            <div class="modern-subheader">Tepat Waktu</div>
                            <div class="table-responsive">
                                <table class="table-modern table text-nowrap mb-0 align-middle">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th>Name</th>
                                            <th>Time</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tepatpulang as $t)
                                            <tr>
                                                <td class="text-center">{{$loop->iteration}}</td>
                                                <td>
                                                    @php
                                                        $nama = \App\Models\User::where('id', $t->user_id)->value('name');
                                                        $no_pegawai = \App\Models\User::where('id', $t->user_id)->value('no_pegawai');
                                                    @endphp
                                                    <span class="fw-semibold d-block">{{$nama}}</span>
                                                    <span class="fw-normal text-muted"
                                                        style="font-size:0.97em;">{{$no_pegawai}}</span>
                                                </td>
                                                <td><span
                                                        class="fw-normal">{{ \Carbon\Carbon::parse($t->created_at)->format('H:i:s') }}</span>
                                                </td>
                                                <td>
                                                    @if($t->confirmation == 1)
                                                        <span class="badge-status verified">Terverifikasi</span>
                                                    @else
                                                        <span class="badge-status unverified">Belum Terverifikasi</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="#" class="btn btn-modern py-1 px-2" data-bs-toggle="modal"
                                                        data-bs-target="#detailModalPulang-{{$t->id}}" title="Detail Absensi"><i
                                                            class="fa fa-eye"></i> Detail</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    {{-- Absensi Pulang Lebih Awal --}}
                    <div class="col-md-6">
                        <div class="modern-card w-100 no-hover p-4">
                            <div class="modern-subheader">Pulang Lebih Awal</div>
                            <div class="table-responsive">
                                <table class="table-modern table text-nowrap mb-0 align-middle">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th>Name</th>
                                            <th>Time</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($telatpulang as $d)
                                            <tr>
                                                <td class="text-center">{{$loop->iteration}}</td>
                                                <td>
                                                    @php
                                                        $nama = \App\Models\User::where('id', $d->user_id)->value('name');
                                                        $no_pegawai = \App\Models\User::where('id', $d->user_id)->value('no_pegawai');
                                                    @endphp
                                                    <span class="fw-semibold d-block">{{$nama}}</span>
                                                    <span class="fw-normal text-muted"
                                                        style="font-size:0.97em;">{{$no_pegawai}}</span>
                                                </td>
                                                <td><span
                                                        class="fw-normal">{{ \Carbon\Carbon::parse($d->created_at)->format('H:i:s') }}</span>
                                                </td>
                                                <td>
                                                    @if($d->confirmation == 1)
                                                        <span class="badge-status verified">Terverifikasi</span>
                                                    @else
                                                        <span class="badge-status unverified">Belum Terverifikasi</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="#" class="btn btn-modern py-1 px-2" data-bs-toggle="modal"
                                                        data-bs-target="#detailModalPulang-{{$d->id}}" title="Detail Absensi"><i
                                                            class="fa fa-eye"></i> Detail</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- All Absensi History Section --}}
            <div class="col-lg-12">
                <div class="modern-card w-100">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="modern-header"><i class="fa fa-history"></i> History All Absensi</div>
                        <a href="{{route('admin.kabsensi.export')}}" class="btn btn-modern"><i class="fa fa-download"></i>
                            Export Data</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table-modern table text-nowrap mb-0 align-middle">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Name</th>
                                    <th>Time</th>
                                    <th>Keterangan</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($terkonfirmasi as $t)

                                    <tr>
                                        <td class="text-center">{{$loop->iteration}}</td>
                                        <td>
                                            @php
                                                $nama = \App\Models\User::where('id', $t->user_id)->value('name');
                                                $no_pegawai = \App\Models\User::where('id', $t->user_id)->value('no_pegawai');
                                              @endphp
                                            <span class="fw-semibold d-block">{{$nama}}</span>
                                            <span class="fw-normal text-muted" style="font-size:0.97em;">{{$no_pegawai}}</span>

                                        </td>
                                        <td><span class="fw-normal">{{$t->created_at}}</span></td>
                                        <td>
                                            @php
                                                $createdTime = \Carbon\Carbon::parse($t->created_at)->format('H:i:s');
                                                $keterangan = $t->type === 'masuk'
                                                    ? ($createdTime <= '09:00:00' ? 'Tepat Waktu' : 'Terlambat')
                                                    : ($createdTime >= '17:00:00' ? 'Tepat Waktu' : 'Pulang Lebih Awal');
                                              @endphp
                                            <span
                                                class="badge-status {{ $keterangan === 'Tepat Waktu' ? 'ontime' : ($keterangan === 'Terlambat' ? 'late' : 'early') }}">{{$keterangan}}</span>
                                        </td>
                                        <td><span class="fw-normal">{{$t->type}}</span></td>
                                        <td>
                                            @if($t->confirmation == 1)
                                                <span class="badge-status verified">Terverifikasi</span>
                                            @else
                                                <span class="badge-status unverified">Belum Terverifikasi</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="#" class="btn btn-modern py-1 px-2" data-bs-toggle="modal"
                                                data-bs-target="#detailModalall-{{$t->id}}" title="Detail Absensi"><i
                                                    class="fa fa-eye"></i> Detail</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modals for Absensi Masuk --}}
        @foreach ($tepatmasuk->merge($telatmasuk) as $d)
            <div class="modal fade" id="detailModalMasuk-{{$d->id}}" tabindex="-1"
                aria-labelledby="detailModalMasukLabel-{{$d->id}}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="detailModalMasukLabel-{{$d->id}}">Detail Absensi Masuk</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3"><strong>Nama:</strong>
                                {{ \App\Models\User::where('id', $d->user_id)->value('name') }}</div>
                            <div class="mb-3"><strong>No Pegawai:</strong>
                                {{ \App\Models\User::where('id', $d->user_id)->value('no_pegawai') }}</div>
                            <div class="mb-3"><strong>Waktu:</strong> {{ $d->created_at }}</div>
                            <div class="mb-3"><strong>Lokasi:</strong> {{ $d->location }}</div>
                            <div class="map-card mb-3">
                                <div id="map-masuk-{{$d->id}}" style="height: 220px;"></div>
                            </div>
                            <div class="photo-card mb-3"><strong>Bukti Absen:</strong><br><img
                                    src="{{ asset('/' . $d->photo) }}" alt="Bukti Absen"></div>
                        </div>
                        <div class="modal-footer d-flex justify-content-between align-items-center">
                            @if ($d->confirmation == 1)
                                <span class="badge-status verified">Absensi Telah dikonfirmasi</span>
                            @elseif(is_null($d->confirmation) || $d->confirmation != 1)
                                <form action="{{ route('admin.kabsensi.konfirmasi', $d->id) }}" method="POST"
                                    id="form-verifikasi-masuk-{{$d->id}}" class="w-100 d-flex flex-column gap-2">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-2">
                                        <label for="verifikasi-select-masuk-{{$d->id}}" class="form-label">Status Verifikasi</label>
                                        <select name="verivikasi" id="verifikasi-select-masuk-{{$d->id}}" class="form-control"
                                            onchange="toggleOtherInput('masuk-{{$d->id}}')">
                                            <option value="" disabled selected>--Pilih Konfirmasi--</option>
                                            <option value="1">Sesuai</option>
                                            <option value="0">Bukan Dikantor</option>
                                            <option value="other">Other</option>
                                        </select>
                                    </div>
                                    <div class="mb-2">
                                        <label for="keterangan-masuk-{{$d->id}}" class="form-label">Keterangan</label>
                                        <input type="text" name="keterangan" id="keterangan-masuk-{{$d->id}}" class="form-control">
                                        <input type="text" name="verivikasi_oleh" value="{{ Auth::user()->id }}" hidden>
                                    </div>
                                    <button type="submit" class="btn btn-modern w-100">Konfirmasi</button>
                                </form>
                            @endif
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        {{-- Modals for Absensi Pulang --}}
        @foreach ($tepatpulang->merge($telatpulang) as $d)
            <div class="modal fade" id="detailModalPulang-{{$d->id}}" tabindex="-1"
                aria-labelledby="detailModalPulangLabel-{{$d->id}}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="detailModalPulangLabel-{{$d->id}}">Detail Absensi Pulang</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3"><strong>Nama:</strong>
                                {{ \App\Models\User::where('id', $d->user_id)->value('name') }}</div>
                            <div class="mb-3"><strong>No Pegawai:</strong>
                                {{ \App\Models\User::where('id', $d->user_id)->value('no_pegawai') }}</div>
                            <div class="mb-3"><strong>Waktu:</strong> {{ $d->created_at }}</div>
                            <div class="mb-3"><strong>Lokasi:</strong> {{ $d->location }}</div>
                            <div class="map-card mb-3">
                                <div id="map-pulang-{{$d->id}}" style="height: 220px;"></div>
                            </div>
                            <div class="photo-card mb-3"><strong>Bukti Absen:</strong><br><img
                                        src="{{ asset('/' . $d->photo) }}" alt="Bukti Absen">
                                </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-between align-items-center">
                            @if ($d->confirmation == 1)
                                <span class="badge-status verified">Absensi Telah dikonfirmasi</span>
                            @elseif(is_null($d->confirmation) || $d->confirmation != 1)
                                <form action="{{ route('admin.kabsensi.konfirmasi', $d->id) }}" method="POST"
                                    id="form-verifikasi-pulang-{{$d->id}}" class="w-100 d-flex flex-column gap-2">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-2">
                                        <label for="verifikasi-select-pulang-{{$d->id}}" class="form-label">Status
                                            Verifikasi</label>
                                        <select name="verivikasi" id="verifikasi-select-pulang-{{$d->id}}" class="form-control"
                                            onchange="toggleOtherInput('pulang-{{$d->id}}')">
                                            <option value="" disabled selected>--Pilih Konfirmasi--</option>
                                            <option value="1">Sesuai</option>
                                            <option value="0">Bukan Dikantor</option>
                                            <option value="other">Other</option>
                                        </select>
                                    </div>
                                    <div class="mb-2">
                                        <label for="keterangan-pulang-{{$d->id}}" class="form-label">Keterangan</label>
                                        <input type="text" name="keterangan" id="keterangan-pulang-{{$d->id}}" class="form-control">
                                        <input type="text" name="verivikasi_oleh" value="{{ Auth::user()->id }}" hidden>
                                    </div>
                                    <button type="submit" class="btn btn-modern w-100">Konfirmasi</button>
                                </form>
                            @endif
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        {{-- Modals for All Absensi History --}}
        @foreach ($terkonfirmasi as $d)
            <div class="modal fade" id="detailModalall-{{$d->id}}" tabindex="-1"
                aria-labelledby="detailModalallLabel-{{$d->id}}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="detailModalallLabel-{{$d->id}}">Detail Absensi History</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3"><strong>Nama:</strong>
                                {{ \App\Models\User::where('id', $d->user_id)->value('name') }}</div>
                            <div class="mb-3"><strong>No Pegawai:</strong>
                                {{ \App\Models\User::where('id', $d->user_id)->value('no_pegawai') }}</div>
                            <div class="mb-3"><strong>Waktu:</strong> {{ $d->created_at }}</div>
                            <div class="mb-3"><strong>Lokasi:</strong> {{ $d->location }}</div>
                            <div class="map-card mb-3">
                                <div id="map-all-{{$d->id}}" style="height: 220px;"></div>
                            </div>
                                <div class="photo-card mb-3"><strong>Bukti Absen:</strong><br><img
                                        src="{{ asset('/' . $d->photo) }}" alt="Bukti Absen">
                                </div>
                            </div>
                        <div class="modal-footer d-flex justify-content-between align-items-center">
                            @if ($d->confirmation == 1)
                                <span class="badge-status verified">Absensi Telah dikonfirmasi</span>
                            @elseif(is_null($d->confirmation) || $d->confirmation != 1)
                                <form action="{{ route('admin.kabsensi.konfirmasi', $d->id) }}" method="POST"
                                    id="form-verifikasi-all-{{$d->id}}" class="w-100 d-flex flex-column gap-2">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-2">
                                        <label for="verifikasi-select-all-{{$d->id}}" class="form-label">Status Verifikasi</label>
                                        <select name="verivikasi" id="verifikasi-select-all-{{$d->id}}" class="form-control"
                                            onchange="toggleOtherInput('all-{{$d->id}}')">
                                            <option value="" disabled selected>--Pilih Konfirmasi--</option>
                                            <option value="1">Sesuai</option>
                                            <option value="0">Bukan Dikantor</option>
                                            <option value="other">Other</option>
                                        </select>
                                    </div>
                                    <div class="mb-2">
                                        <label for="keterangan-all-{{$d->id}}" class="form-label">Keterangan</label>
                                        <input type="text" name="keterangan" id="keterangan-all-{{$d->id}}" class="form-control">
                                        <input type="text" name="verivikasi_oleh" value="{{ Auth::user()->id }}" hidden>
                                    </div>
                                    <button type="submit" class="btn btn-modern w-100">Konfirmasi</button>
                                </form>
                            @endif
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach


        <script>
            // Fungsi untuk inisialisasi peta
            function initMap(mapId, lat, lng) {
                // Cek jika elemen map sudah ada dan belum diinisialisasi
                const mapElement = document.getElementById(mapId);
                if (mapElement && mapElement._leaflet_id === undefined) {
                    var map = L.map(mapId).setView([lat, lng], 13);

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                    }).addTo(map);

                    L.marker([lat, lng]).addTo(map)
                        .bindPopup('Location').openPopup();
                }
            }

            // Fungsi untuk menampilkan/menyembunyikan input 'Other' pada konfirmasi
            function toggleOtherInput(id) {
                const selectElement = document.getElementById('verifikasi-select-' + id);
                const keteranganInput = document.getElementById('keterangan-' + id);
                if (selectElement.value === 'other') {
                    keteranganInput.style.display = 'block';
                } else {
                    keteranganInput.style.display = 'none';
                }
            }

            // Inisialisasi peta saat modal absensi masuk muncul
            @foreach($tepatmasuk->merge($telatmasuk) as $d)
                document.addEventListener('DOMContentLoaded', function () {
                    $('#detailModalMasuk-{{$d->id}}').on('shown.bs.modal', function () {
                        let location = "{{$d->location}}".split(',');
                        let latitude = parseFloat(location[0].trim());
                        let longitude = parseFloat(location[1].trim());
                        initMap('map-masuk-{{$d->id}}', latitude, longitude);
                    });
                    $('#detailModalMasuk-{{$d->id}}').on('hidden.bs.modal', function () {
                        // Optional: destroy map to prevent issues if modals are re-opened
                        const mapElement = document.getElementById('map-masuk-{{$d->id}}');
                        if (mapElement && mapElement._leaflet_id !== undefined) {
                            mapElement._leaflet_id = undefined; // Reset Leaflet ID
                            mapElement.innerHTML = ''; // Clear map container
                        }
                    });
                });
            @endforeach

            // Inisialisasi peta saat modal absensi pulang muncul
            @foreach($tepatpulang->merge($telatpulang) as $d)
                document.addEventListener('DOMContentLoaded', function () {
                    $('#detailModalPulang-{{$d->id}}').on('shown.bs.modal', function () {
                        let location = "{{$d->location}}".split(',');
                        let latitude = parseFloat(location[0].trim());
                        let longitude = parseFloat(location[1].trim());
                        initMap('map-pulang-{{$d->id}}', latitude, longitude);
                    });
                    $('#detailModalPulang-{{$d->id}}').on('hidden.bs.modal', function () {
                        // Optional: destroy map to prevent issues if modals are re-opened
                        const mapElement = document.getElementById('map-pulang-{{$d->id}}');
                        if (mapElement && mapElement._leaflet_id !== undefined) {
                            mapElement._leaflet_id = undefined; // Reset Leaflet ID
                            mapElement.innerHTML = ''; // Clear map container
                        }
                    });
                });
            @endforeach

            // Inisialisasi peta saat modal absensi history muncul
            @foreach($terkonfirmasi as $d)
                document.addEventListener('DOMContentLoaded', function () {
                    $('#detailModalall-{{$d->id}}').on('shown.bs.modal', function () {
                        let location = "{{$d->location}}".split(',');
                        let latitude = parseFloat(location[0].trim());
                        let longitude = parseFloat(location[1].trim());
                        initMap('map-all-{{$d->id}}', latitude, longitude);
                    });
                    $('#detailModalall-{{$d->id}}').on('hidden.bs.modal', function () {
                        // Optional: destroy map to prevent issues if modals are re-opened
                        const mapElement = document.getElementById('map-all-{{$d->id}}');
                        if (mapElement && mapElement._leaflet_id !== undefined) {
                            mapElement._leaflet_id = undefined; // Reset Leaflet ID
                            mapElement.innerHTML = ''; // Clear map container
                        }
                    });
                });
            @endforeach


        </script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
@endsection