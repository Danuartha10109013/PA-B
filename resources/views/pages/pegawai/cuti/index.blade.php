@extends('layout.main')
@section('title')
  Cuti || Pegawai
@endsection
@section('content')
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
  <style>
    body,
    .card,
    .btn,
    .table,
    .modal-content {
    font-family: 'Inter', Arial, sans-serif;
    }

    .cuti-section {
    max-width: 1100px;
    margin: 0 auto;
    padding: 2.5rem 0 1.5rem 0;
    }

    .cuti-card {
    border-radius: 18px;
    box-shadow: 0 4px 24px rgba(60, 72, 100, .10);
    border: 1px solid #e6eaf3;
    background: #fff;
    transition: all 0.2s;
    overflow: hidden;
    margin-bottom: 2rem;
    }

    .cuti-title {
    font-size: 1.35rem;
    font-weight: 700;
    color: #5D87FF;
    margin-bottom: 0.7rem;
    letter-spacing: 0.5px;
    }

    .cuti-balance {
    background: linear-gradient(90deg, #6a93ff 0%, #a4cafe 100%);
    color: #fff;
    border-radius: 12px;
    padding: 1rem 1.5rem;
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
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

    .badge.bg-primary,
    .badge.bg-success,
    .badge.bg-warning,
    .badge.bg-danger,
    .badge.bg-secondary {
    font-weight: 600;
    border-radius: 8px;
    padding: 6px 16px;
    font-size: 0.98rem;
    box-shadow: 0 2px 8px rgba(93, 135, 255, 0.08);
    transition: all 0.18s;
    }

    .badge.bg-primary {
    background: linear-gradient(90deg, #6a93ff 0%, #a4cafe 100%) !important;
    color: #fff !important;
    }

    .badge.bg-success {
    background: #4caf50 !important;
    color: #fff !important;
    }

    .badge.bg-warning {
    background: #ffb347 !important;
    color: #fff !important;
    }

    .badge.bg-danger {
    background: #e74c3c !important;
    color: #fff !important;
    }

    .badge.bg-secondary {
    background: #b0b8c1 !important;
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
    border-bottom: none;
    }

    .modal-title {
    font-weight: 700;
    font-size: 1.15rem;
    }

    .modal-body label {
    font-weight: 600;
    color: #4a5568;
    margin-bottom: 0.3rem;
    font-size: 0.97rem;
    }

    .modal-body input,
    .modal-body select {
    border-radius: 8px;
    border: 1px solid #e2e8f0;
    padding: 8px 12px;
    transition: all 0.18s;
    font-size: 0.98rem;
    margin-bottom: 1rem;
    }

    .modal-footer {
    border-top: none;
    padding: 1rem 1.5rem 1.2rem 1.5rem;
    }

    .modal-footer .btn {
    min-width: 110px;
    }

    @media (max-width: 991px) {
    .cuti-section {
      padding: 1.2rem 0 0.5rem 0;
    }
    }

    @media (max-width: 767px) {
    .cuti-section {
      padding: 0.7rem 0 0.2rem 0;
    }

    .cuti-title {
      font-size: 1.1rem;
    }

    .modal-header,
    .modal-footer {
      padding-left: 0.7rem;
      padding-right: 0.7rem;
    }
    }
  </style>
  <div class="cuti-section animate__animated animate__fadeInUp">
    <div class="cuti-card animate__animated animate__fadeIn">
    <div class="p-4 pb-0">
      <div class="d-flex align-items-center justify-content-between mb-4">
      <div>
        <div class="cuti-title">Manajemen Cuti</div>
        <p class="text-muted mb-0">Kelola pengajuan cuti Anda dengan mudah</p>
      </div>
      <div class="cuti-balance">
        <i class="ti ti-calendar fs-5"></i>
        Sisa Cuti Tahunan :<span style="font-size:1.3rem; font-weight:700;">{{Auth::user()->saldo_cuti}} Kali</span>
      </div>
      </div>
      <div class="card bg-light-primary border-0 mb-4">
      <div class="card-body">
        <div class="row align-items-center">
        <div class="col-md-6">
          <h5 class="mb-2">Pilih Jenis Cuti</h5>
          <select class="form-select form-select-lg shadow-none" id="jenisCuti" onchange="showForm()">
          <option value="" selected disabled>--Pilih Jenis Cuti--</option>
          <option value="tahunan">Cuti Tahunan</option>
          <option value="lain-lain">Cuti Lain-Lain</option>
          </select>
        </div>
        <div class="col-md-6 text-md-end mt-3 mt-md-0">
          <div class="d-inline-block bg-primary rounded-circle p-2 me-2">
          <i class="ti ti-calendar-event text-white fs-4"></i>
          </div>
          <span class="text-primary fw-semibold">Pilih jenis cuti yang ingin Anda ajukan</span>
        </div>
        </div>
      </div>
      </div>
      <!-- Form Cuti Tahunan -->
      <div id="formTahunan" style="display: none;">
      <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h5 class="card-title mb-0">Cuti Tahunan</h5>
          <a href="{{route('pegawai.calendar')}}" class="btn btn-primary">
          <i class="ti ti-plus me-1"></i> Ajukan Cuti Tahunan
          </a>
        </div>
        <div class="table-responsive">
          <table class="table table-hover align-middle">
          <thead>
            <tr>
            <th class="text-center" style="width: 50px">No</th>
            <th>Judul</th>
            <th>Status</th>
            <th>Keterangan</th>
            <th>Start Date</th>
            <th>End Date</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($data as $d)
        <tr>
        <td class="text-center">{{$loop->iteration}}</td>
        <td>
          <div class="d-flex align-items-center">
          <div class="bg-light-primary rounded-circle p-2 me-2">
          <i class="ti ti-calendar text-primary"></i>
          </div>
          <span>{{$d->title}}</span>
          </div>
        </td>
        <td>
          <span
          class="badge {{ $d->status == 0 ? 'bg-warning' : ($d->status == 1 ? 'bg-success' : ($d->status == 2 ? 'bg-danger' : 'bg-secondary')) }}">
          {{ $d->status == 0 ? "Belum Diperiksa" : ($d->status == 1 ? "Disetujui" : ($d->status == 2 ? "Ditolak" : "Unknown")) }}
          </span>
        </td>
        <td>{{$d->keterangan}}</td>
        <td>{{$d->start}}</td>
        <td>{{$d->end}}</td>
        </tr>
        @endforeach
          </tbody>
          </table>
        </div>
        </div>
      </div>
      </div>
      <!-- Form Cuti Lain-Lain -->
      <div id="formLainLain" style="display: none;">
      <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h5 class="card-title mb-0">Cuti Lain-Lain</h5>
          <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#cutiModal">
          <i class="ti ti-plus me-1"></i> Ajukan Cuti Lain-Lain
          </button>
        </div>
        <div class="table-responsive">
          <table class="table table-hover align-middle">
          <thead>
            <tr>
            <th class="text-center" style="width: 50px">No</th>
            <th>Judul</th>
            <th>Status</th>
            <th>Keterangan</th>
            <th>Start Date</th>
            <th>End Date</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($data1 as $d)
        <tr>
        <td class="text-center">{{ $loop->iteration }}</td>
        <td>
          <div class="d-flex align-items-center">
          <div class="bg-light-primary rounded-circle p-2 me-2">
          <i class="ti ti-calendar text-primary"></i>
          </div>
          <span>{{ $d->title }}</span>
          </div>
        </td>
        <td>
          <span
          class="badge {{ $d->status == 0 ? 'bg-warning' : ($d->status == 1 ? 'bg-success' : ($d->status == 2 ? 'bg-danger' : 'bg-secondary')) }}">
          {{ $d->status == 0 ? "Belum Diperiksa" : ($d->status == 1 ? "Disetujui" : ($d->status == 2 ? "Ditolak" : "Unknown")) }}
          </span>
        </td>
        <td>{{ $d->keterangan }}</td>
        <td>{{ $d->start }}</td>
        <td>{{ $d->end }}</td>
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
  </div>
  <!-- Modal for Submitting Cuti -->
  <div class="modal fade" id="cutiModal" tabindex="-1" aria-labelledby="cutiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="cutiModalLabel">
        <i class="ti ti-calendar-plus me-2 text-primary"></i>
        Ajukan Cuti
      </h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form id="cutiForm" action="{{ route('pegawai.cuti.store') }}" enctype="multipart/form-data" method="POST">
        @csrf
        <div class="mb-3">
        <label for="title" class="form-label">Judul</label>
        <input type="text" class="form-control" name="title" id="title" required>
        </div>
        <div class="mb-3">
        <label for="alasan" class="form-label">Alasan Cuti</label>
        <select class="form-select" name="alasan_cuti" id="alasan" required>
          <option value="" selected disabled>--Pilih Alasan--</option>
          <option value="Sakit">Sakit</option>
          <option value="Izin">Izin</option>
        </select>
        <input type="text" name="jenis_cuti" value="lain-lain" hidden>
        </div>
        <div class="mb-3">
        <label for="bukti" class="form-label">Bukti</label>
        <input type="file" class="form-control" name="bukti" id="bukti" required>
        </div>
        <div class="row">
        <div class="col-md-6 mb-3">
          <label for="start" class="form-label">Start Date</label>
          <input type="date" class="form-control" name="start" id="start" required>
        </div>
        <div class="col-md-6 mb-3">
          <label for="end" class="form-label">End Date</label>
          <input type="date" class="form-control" name="end" id="end" required>
        </div>
        </div>
        <div class="text-end">
        <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">
          <i class="ti ti-send me-1"></i> Ajukan
        </button>
        </div>
      </form>
      </div>
    </div>
    </div>
  </div>
  <script>
    function showForm() {
    const jenisCuti = document.getElementById('jenisCuti').value;
    const formTahunan = document.getElementById('formTahunan');
    const formLainLain = document.getElementById('formLainLain');
    if (jenisCuti === 'tahunan') {
      formTahunan.style.display = 'block';
      formLainLain.style.display = 'none';
    } else if (jenisCuti === 'lain-lain') {
      formTahunan.style.display = 'none';
      formLainLain.style.display = 'block';
    } else {
      formTahunan.style.display = 'none';
      formLainLain.style.display = 'none';
    }
    }
  </script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
@endsection