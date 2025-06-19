@extends('layout.main')
@section('title')
  Dashboard || Admin
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

    .modern-filter {
    background: #f8faff;
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(60, 72, 100, .06);
    padding: 1rem 1.2rem;
    margin-bottom: 1.2rem;
    }

    .modern-filter .form-control {
    border-radius: 8px;
    border: 1px solid #e2e8f0;
    background: #f8f9fa;
    font-size: 0.98rem;
    margin-right: 0.5rem;
    }

    .modern-filter .btn {
    border-radius: 8px;
    background: linear-gradient(90deg, #6a93ff 0%, #a4cafe 100%);
    color: #fff;
    font-weight: 600;
    box-shadow: 0 2px 8px rgba(93, 135, 255, 0.08);
    border: none;
    transition: background 0.18s;
    }

    .modern-filter .btn:hover {
    background: #4b6fd8;
    }

    .stat-card {
    border-radius: 16px;
    background: linear-gradient(90deg, #6a93ff 0%, #a4cafe 100%);
    color: #fff;
    box-shadow: 0 2px 12px rgba(93, 135, 255, 0.10);
    margin-bottom: 1.2rem;
    padding: 1.5rem 1.2rem;
    display: flex;
    align-items: center;
    gap: 1.2rem;
    }

    .stat-icon {
    font-size: 2.2rem;
    background: #fff;
    color: #6a93ff;
    border-radius: 50%;
    padding: 0.6rem;
    box-shadow: 0 2px 8px rgba(93, 135, 255, 0.10);
    }

    .stat-title {
    font-size: 1.05rem;
    font-weight: 600;
    margin-bottom: 0.2rem;
    color: #eaf1ff;
    }

    .stat-value {
    font-size: 1.5rem;
    font-weight: 700;
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
    }

    .table-modern td,
    .table-modern th {
    vertical-align: middle;
    padding: 0.7rem 0.8rem;
    border-bottom: 1px solid #e6eaf3;
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
    margin-right: 0.3em;
    }

    .badge-status.late {
    background: #ff6b6b;
    }

    .badge-status.early {
    background: #ffb347;
    }

    .badge-status.ontime {
    background: #4caf50;
    }

    .badge-status.leave {
    background: #a4cafe;
    color: #3b4861;
    }
  </style>
  <div class="row">
    <div class="col-lg-9 d-flex align-items-stretch">
    <div class="modern-card w-100 p-4">
      <div class="modern-header mb-3"><i class="fa fa-chart-bar"></i> Tren Absensi</div>
      <div class="modern-filter mb-4">
      <form method="GET" action="{{ route('admin.dashboard') }}" class="d-flex flex-wrap align-items-center">
        <input type="month" name="month" class="form-control me-2 mb-2" value="{{ request('month') }}">
        <input type="number" name="year" class="form-control me-2 mb-2" value="{{ request('year', date('Y')) }}"
        placeholder="Year">
        <input type="date" name="start_date" class="form-control me-2 mb-2" value="{{ request('start_date') }}">
        <input type="date" name="end_date" class="form-control me-2 mb-2" value="{{ request('end_date') }}">
        <button type="submit" class="btn"><i class="fa fa-filter me-1"></i>Filter</button>
      </form>
      </div>
      <canvas id="attendanceChart"></canvas>
      <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
      <script>
      var ctx = document.getElementById('attendanceChart').getContext('2d');
      var attendanceChart = new Chart(ctx, {
        type: 'bar',
        data: {
        labels: {!! json_encode($months) !!},
        datasets: [
          {
          label: 'Absen Masuk',
          data: {!! json_encode($absenMasukCounts) !!},
          backgroundColor: '#4caf50',
          borderColor: '#4caf50',
          borderWidth: 1
          },
          {
          label: 'Absen Pulang',
          data: {!! json_encode($absenPulangCounts) !!},
          backgroundColor: '#ff5733',
          borderColor: '#ff5733',
          borderWidth: 1
          }
        ]
        },
        options: {
        responsive: true,
        animation: { duration: 900, easing: 'easeOutQuart' },
        plugins: { legend: { labels: { font: { family: 'Inter', size: 14 } } } },
        scales: {
          x: {
          beginAtZero: true,
          title: { display: true, text: 'Months', font: { family: 'Inter', weight: 600 } }
          },
          y: {
          beginAtZero: true,
          title: { display: true, text: 'Jumlah Absensi', font: { family: 'Inter', weight: 600 } }
          }
        }
        }
      });
      </script>
    </div>
    </div>
    <div class="col-lg-3">
    <div class="row">
      <div class="col-lg-12">
      <div class="stat-card mb-3">
        <span class="stat-icon"><i class="fa fa-clock"></i></span>
        <div>
        <div class="stat-title">Today's Late</div>
        <div class="stat-value">{{$todaylate}}</div>
        </div>
      </div>
      </div>
      <div class="col-lg-12">
      <div class="stat-card" style="background: linear-gradient(90deg, #a4cafe 0%, #6a93ff 100%);">
        <span class="stat-icon"><i class="fa fa-calendar-check"></i></span>
        <div>
        <div class="stat-title">Monthly Leaves</div>
        <div class="stat-value">{{$monthlyleaves}}</div>
        </div>
      </div>
      </div>
    </div>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-6 d-flex align-items-stretch">
    <div class="modern-card w-100 p-4">
      <div class="modern-header mb-3"><i class="fa fa-clock"></i> Recent Attendance</div>
      <div class="table-responsive">
      <table class="table table-modern text-nowrap mb-0 align-middle">
        <thead>
        <tr>
          <th>No</th>
          <th>Name</th>
          <th>Status</th>
          <th>Time</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($absen as $a)
        <tr>
        <td>{{$loop->iteration}}</td>
        <td>
        @php
        $nama = \App\Models\User::where('id', $a->user_id)->value('name');
        $jabatan = \App\Models\User::where('id', $a->user_id)->value('jabatan');
      @endphp
        <div class="d-flex flex-column">
          <span class="fw-semibold">{{$nama}}</span>
          <span class="fw-normal text-muted" style="font-size:0.97em;">{{$jabatan}}</span>
        </div>
        </td>
        <td>
        @php
        $createdTime = \Carbon\Carbon::parse($a->created_at)->format('H:i:s');
        $keterangan = $a->type === 'masuk'
        ? ($createdTime <= '09:00:00' ? 'Tepat Waktu' : 'Terlambat')
        : ($createdTime >= '16:00:00' ? 'Tepat Waktu' : 'Pulang Lebih Awal');
        $badgeClass = $keterangan === 'Tepat Waktu' ? 'ontime' : ($keterangan === 'Terlambat' ? 'late' : 'early');
      @endphp
        <span class="badge-status {{$badgeClass}}">{{$keterangan}}</span>
        </td>
        <td><span class="fw-semibold">{{$a->created_at}}</span></td>
        </tr>
      @endforeach
        </tbody>
      </table>
      </div>
    </div>
    </div>
    <div class="col-lg-6 d-flex align-items-stretch">
    <div class="modern-card w-100 p-4">
      <div class="modern-header mb-3"><i class="fa fa-calendar-check"></i> Recent Leaves</div>
      <div class="table-responsive">
      <table class="table table-modern text-nowrap mb-0 align-middle">
        <thead>
        <tr>
          <th>Id</th>
          <th>Name</th>
          <th>Jenis Cuti</th>
          <th>Start</th>
          <th>End</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($cuti as $c)
        <tr>
        <td>{{$loop->iteration}}</td>
        <td>
        @php
        $nama = \App\Models\User::where('id', $c->user_id)->value('name');
        $jabatan = \App\Models\User::where('id', $c->user_id)->value('jabatan');
      @endphp
        <div class="d-flex flex-column">
          <span class="fw-semibold">{{$nama}}</span>
          <span class="fw-normal text-muted" style="font-size:0.97em;">{{$jabatan}}</span>
        </div>
        </td>
        <td><span class="badge-status leave">{{$c->jenis_cuti}}</span></td>
        <td><span class="fw-semibold">{{$c->start}}</span></td>
        <td><span class="fw-semibold">{{$c->end}}</span></td>
        </tr>
      @endforeach
        </tbody>
      </table>
      </div>
    </div>
    </div>
  </div>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
@endsection