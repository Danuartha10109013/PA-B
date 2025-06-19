@extends('layout.main')
@section('title', 'Kelola Cuti || Admin')

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
            padding: 2rem;
        }

        .modern-card:hover {
            box-shadow: 0 8px 32px rgba(60, 72, 100, .16);
            transform: translateY(-2px);
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
            margin-bottom: 1.2rem;
            padding-left: 0.5rem;
            border-left: 4px solid #6a93ff;
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
            margin: 0.2rem;
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
            margin-bottom: 1.5rem;
        }

        .table-modern th {
            background: #f4f7fe;
            font-weight: 700;
            color: #3b4861;
            position: sticky;
            top: 0;
            z-index: 2;
            text-align: center;
            padding: 1rem;
            white-space: nowrap;
        }

        .table-modern td,
        .table-modern th {
            vertical-align: middle;
            padding: 1rem;
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
            padding: 0.4em 1em;
            font-size: 0.93rem;
            font-weight: 600;
            color: #fff;
            background: #6a93ff;
            display: inline-block;
        }

        .badge-status.approved {
            background: #4caf50;
        }

        .badge-status.rejected {
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
            font-size: 1.2rem;
            letter-spacing: 0.5px;
        }

        .modal-body {
            padding: 1.5rem;
        }

        .form-label {
            font-weight: 600;
            color: #4a5568;
            margin-bottom: 0.5rem;
            font-size: 0.97rem;
        }

        .form-control {
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            padding: 10px 15px;
            font-size: 0.98rem;
            background: #f8f9fa;
            margin-bottom: 1rem;
        }

        .form-control:focus {
            border-color: #6a93ff;
            box-shadow: 0 0 0 2px rgba(93, 135, 255, 0.10);
        }

        .modal-footer {
            border-top: 1px solid #e6eaf3;
            padding: 1rem 1.5rem;
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .table-responsive {
            margin-bottom: 2rem;
        }

        .section-spacing {
            margin-bottom: 3rem;
        }
    </style>

    <div class="row g-4">
        <div class="col-lg-12">
            <div class="modern-card w-100">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="modern-header"><i class="fa fa-calendar-alt"></i> Kelola Cuti</div>
                    <div>
                        <a href="#" class="btn btn-modern me-2" data-bs-toggle="modal" data-bs-target="#exportModal"><i
                                class="fa fa-file-export"></i> Export</a>
                        <a href="/run-schedule" class="btn btn-modern"><i class="fa fa-sync"></i> Reset Cuti</a>
                    </div>
                </div>

                <div class="row g-4">
                    <!-- Pengajuan Cuti Section -->
                    <div class="col-md-12 section-spacing">
                        <div class="modern-subheader">Pengajuan Cuti</div>
                        <div class="table-responsive">
                            <table class="table-modern table text-nowrap mb-0 align-middle">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Judul</th>
                                        <th>Jenis Cuti</th>
                                        <th>Nama Karyawan</th>
                                        <th>Alasan Cuti</th>
                                        <th>Tanggal Mulai</th>
                                        <th>Tanggal Selesai</th>
                                        <th>Total Hari</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $d)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $d->title }}</td>
                                            <td>{{ $d->jenis_cuti }}</td>
                                            <td>
                                                @php
                                                    $nama = \App\Models\User::where('id', $d->user_id)->value('name');
                                                @endphp
                                                {{ $nama }}
                                            </td>
                                            <td>{{ $d->alasan_cuti }}</td>
                                            <td>{{ $d->start }}</td>
                                            <td>{{ $d->end }}</td>
                                            <td>
                                                @php
                                                    $start = \Carbon\Carbon::parse($d->start);
                                                    $end = \Carbon\Carbon::parse($d->end);
                                                    $total_hari = $start->diffInDays($end) + 1;
                                                @endphp
                                                {{ $total_hari }} Hari
                                            </td>
                                            <td>
                                                <div class="action-buttons">
                                                    @php
                                                        $file = \App\Models\Cuti::where('id', $d->id)->value('bukti');
                                                    @endphp

                                                    @if ($file)
                                                        <a href="{{ route('admin.kcuti.download', $d->id) }}"
                                                            class="btn btn-modern"><i class="fa fa-download"></i> Download
                                                            Bukti</a>
                                                    @endif

                                                    <a href="#" class="btn btn-modern" data-bs-toggle="modal"
                                                        data-bs-target="#updateModal{{ $d->id }}"><i class="fa fa-reply"></i>
                                                        Response</a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Riwayat Cuti Section -->
                    <div class="col-md-12">
                        <div class="modern-subheader">Riwayat Cuti</div>
                        <div class="table-responsive">
                            <table class="table-modern table text-nowrap mb-0 align-middle">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Judul</th>
                                        <th>Jenis Cuti</th>
                                        <th>Nama Karyawan</th>
                                        <th>Alasan Cuti</th>
                                        <th>Tanggal Mulai</th>
                                        <th>Tanggal Selesai</th>
                                        <th>Total Hari</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data1 as $d)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $d->title }}</td>
                                            <td>{{ $d->jenis_cuti }}</td>
                                            <td>
                                                @php
                                                    $nama = \App\Models\User::where('id', $d->user_id)->value('name');
                                                @endphp
                                                {{ $nama }}
                                            </td>
                                            <td>{{ $d->alasan_cuti }}</td>
                                            <td>{{ $d->start }}</td>
                                            <td>{{ $d->end }}</td>
                                            <td>
                                                @php
                                                    $start = \Carbon\Carbon::parse($d->start);
                                                    $end = \Carbon\Carbon::parse($d->end);
                                                    $total_hari = $start->diffInDays($end) + 1;
                                                @endphp
                                                {{ $total_hari }} Hari
                                            </td>
                                            <td>
                                                <span class="badge-status {{ $d->status == 1 ? 'approved' : 'rejected' }}">
                                                    {{$d->status == 1 ? 'Disetujui' : 'Ditolak'}}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="action-buttons">
                                                    <button class="btn btn-modern" data-bs-toggle="modal"
                                                        data-bs-target="#editModal{{ $d->id }}">
                                                        <i class="fa fa-edit"></i> Edit
                                                    </button>
                                                </div>
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

    <!-- Modals for Pengajuan Cuti -->
    @foreach ($data as $d)
        <div class="modal fade" id="updateModal{{ $d->id }}" tabindex="-1" role="dialog"
            aria-labelledby="updateModalLabel{{ $d->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateModalLabel{{ $d->id }}">Update Leave Request</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="updateCutiForm{{ $d->id }}" action="{{ route('admin.kcuti.update', $d->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="text" name="id" value="{{ $d->id }}" hidden>

                            <div class="mb-3">
                                <label for="keterangan{{ $d->id }}" class="form-label">Keterangan</label>
                                <textarea class="form-control" name="keterangan" id="keterangan{{ $d->id }}" rows="3"
                                    required></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="status{{ $d->id }}" class="form-label">Status</label>
                                <select class="form-control" name="status" id="status{{ $d->id }}" required>
                                    <option value="" selected disabled>--Pilih Status--</option>
                                    <option value="Disetujui">Disetujui</option>
                                    <option value="Ditolak">Ditolak</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-modern w-100">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Modals for Riwayat Cuti -->
    @foreach ($data1 as $d)
        <div class="modal fade" id="editModal{{ $d->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $d->id }}"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel{{ $d->id }}">Edit Cuti</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('admin.kcuti.updatin', $d->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="title{{ $d->id }}" class="form-label">Title</label>
                                <input type="text" class="form-control" id="title{{ $d->id }}" name="title"
                                    value="{{ $d->title }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="jenisCuti{{ $d->id }}" class="form-label">Jenis Cuti</label>
                                <input type="text" class="form-control" id="jenisCuti{{ $d->id }}" name="jenis_cuti"
                                    value="{{ $d->jenis_cuti }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="alasanCuti{{ $d->id }}" class="form-label">Alasan Cuti</label>
                                <textarea class="form-control" id="alasanCuti{{ $d->id }}" name="alasan_cuti" rows="3"
                                    required>{{ $d->alasan_cuti }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="start{{ $d->id }}" class="form-label">Start Date</label>
                                <input type="date" class="form-control" id="start{{ $d->id }}" name="start"
                                    value="{{ $d->start }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="end{{ $d->id }}" class="form-label">End Date</label>
                                <input type="date" class="form-control" id="end{{ $d->id }}" name="end" value="{{ $d->end }}"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="status{{ $d->id }}" class="form-label">Status</label>
                                <select class="form-control" id="status{{ $d->id }}" name="status" required>
                                    <option value="1" {{ $d->status == 1 ? 'selected' : '' }}>Disetujui</option>
                                    <option value="2" {{ $d->status == 2 ? 'selected' : '' }}>Ditolak</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-modern">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Modal Export -->
    <div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="exportModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exportModalLabel">Export Data Cuti</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.kcuti.export') }}" method="GET">
                        <div class="mb-3">
                            <label for="tahun" class="form-label">Pilih Tahun</label>
                            <select class="form-select" id="tahun" name="tahun" required>
                                @php
                                    $currentYear = date('Y');
                                    $startYear = 2024; // Tahun awal yang diinginkan
                                @endphp
                                @for($year = $currentYear; $year >= $startYear; $year--)
                                    <option value="{{ $year }}" {{ $year == $currentYear ? 'selected' : '' }}>{{ $year }}</option>
                                @endfor
                            </select>
                        </div>
                        <button type="submit" class="btn btn-modern w-100">Export Data</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            $('#updateModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');
                var keterangan = button.data('keterangan');

                var modal = $(this);
                modal.find('#cutiId').val(id);
                modal.find('#keterangan').val(keterangan);
                modal.attr('action', modal.attr('action').replace(/\/\d+$/, '/' + id));
            });
        });
    </script>
@endsection