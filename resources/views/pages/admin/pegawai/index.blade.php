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

    /* .modern-card:hover {
    box-shadow: 0 8px 32px rgba(60, 72, 100, .16);
    transform: translateY(-2px) scale(1.01);
    } */

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

    /* /* .modal-content {
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 8px 32px rgba(60, 72, 100, .13);
    } */

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
  <div class="row">
    <div class="col-lg-12 d-flex align-items-stretch">
    <div class="modern-card w-100">
      <div class="d-flex justify-content-between align-items-center mb-4">
      <div class="modern-header"><i class="fa fa-users"></i> Kelola Pegawai</div>
      <a href="#" class="btn btn-modern fw-bold mb-3" data-bs-toggle="modal" data-bs-target="#addEmployeeModal"><i
        class="fa fa-plus"></i>Tambah Pegawai</a>
      </div>
      <div class="table-responsive">
      <table class="table table-modern text-nowrap mb-0 align-middle">
        <thead>
        <tr>
          <th class="text-center">Id</th>
          <th>Name</th>
          <th>Username</th>
          <th>Jabatan</th>
          <th>Action</th>
          <th>Profile</th>
          <th>Acuan</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($data as $d)
        <tr>
        <td class="text-center">{{$loop->iteration}}</td>
        <td>
        <span class="fw-semibold d-block">{{$d->name}}</span>
        <span class="fw-normal text-muted" style="font-size:0.97em;">{{$d->no_pegawai}}</span>
        </td>
        <td><span class="fw-normal">{{$d->username}}</span></td>
        <td><span class="fw-normal">{{$d->jabatan}}</span></td>
        <td>
        <div class="d-flex align-items-center gap-2 justify-content-center">
          @if ($d->active == 1)
        <a href="{{route('admin.kelolapegawai.nonactive', $d->id)}}" class="btn btn-modern"
        title="Nonaktifkan"><i class="fa fa-toggle-on"></i>Active</a>
        @else
        <a href="{{route('admin.kelolapegawai.active', $d->id)}}" class="btn btn-warning text-white"
        title="Aktifkan"><i class="fa fa-toggle-off"></i>Nonactive</a>
        @endif
          <a href="#" class="btn btn-warning text-white" data-bs-toggle="modal"
          data-bs-target="#editEmployeeModal-{{$d->id}}" title="Edit"><i class="fa fa-edit"></i>Edit</a>
          <a href="{{route('admin.kelolapegawai.delete', $d->id)}}" class="btn btn-danger" title="Delete"><i
          class="fa fa-trash"></i>Delete</a>
        </div>
        </td>
        <td class="text-center">
        <img class="avatar-table" src="{{asset('storage/' . $d->profile)}}" alt="profile">
        </td>
         <td class="text-center">
        <img class="avatar-table" src="{{asset('storage/' . $d->acuan)}}" alt="acuan">
        </td>
        </tr>
        <!-- Edit Modal -->
        <div class="modal fade" id="editEmployeeModal-{{$d->id}}" tabindex="-1"
        aria-labelledby="editEmployeeModalLabel-{{$d->id}}" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
          <h5 class="modal-title" id="editEmployeeModalLabel-{{$d->id}}">Edit Pegawai</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
          <form action="{{ route('admin.kelolapegawai.edit', $d->id) }}" method="POST"
          enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <div class="text-center mb-3">
          <img src="{{ asset('storage/' . $d->profile) }}" alt="{{ $d->profile }}"
            class="avatar-preview-modal" id="avatar-preview-{{$d->id}}">
          </div>
          <div class="mb-3">
          <label for="name" class="form-label">Name</label>
          <input type="text" class="form-control" id="name" name="name" value="{{ $d->name }}">
          </div>
          <div class="mb-3">
          <label for="username" class="form-label">Username</label>
          <input type="text" class="form-control" id="username" name="username"
            value="{{ $d->username }}">
          </div>
          <div class="mb-3">
          <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
          <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir"
            value="{{ $d->tempat_lahir ?? '' }}">
          </div>
          <div class="mb-3">
          <label for="birthday" class="form-label">Birthday</label>
          <input type="date" class="form-control" id="birthday" name="birthday"
            value="{{ $d->birthday }}">
          </div>
          <div class="mb-3">
          <label for="jabatan" class="form-label">Jabatan</label>
          <input type="text" class="form-control" id="jabatan" name="jabatan" value="{{ $d->jabatan }}">
          </div>
          <div class="mb-3">
          <label for="alamat" class="form-label">Alamat</label>
          <input type="text" class="form-control" id="alamat" name="alamat" value="{{ $d->alamat }}">
          </div>
          <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" class="form-control" id="email" name="email" value="{{ $d->email }}">
          </div>
          <div class="mb-3">
          <label for="no_wa" class="form-label">No WA</label>
          <input type="text" class="form-control" id="no_wa" name="no_wa" value="{{ $d->no_wa ?? '' }}">
          </div>
          <div class="mb-3">
          <label for="gender" class="form-label">Gender</label>
          <select class="form-control" id="gender" name="gender">
            <option value="" disabled {{ !$d->gender ? 'selected' : '' }}>--Pilih Gender--</option>
            <option value="Laki-Laki" {{ $d->gender == 'Laki-Laki' ? 'selected' : '' }}>Laki-Laki</option>
            <option value="Perempuan" {{ $d->gender == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
          </select>
          </div>
          <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control" id="password" name="password"
            placeholder="Leave blank to keep current password">
          </div>
          <div class="mb-3">
          <label for="avatar" class="form-label">Avatar</label>
          <input type="file" id="avatar-input-{{$d->id}}" name="avatar" class="form-control avatar-input"
            onchange="previewImage(event, 'avatar-preview-{{$d->id}}')">
          </div>
          <div class="mb-3">
          <label for="acuan" class="form-label">Acuan</label>
          <input type="file" id="acuan-input-{{$d->id}}" name="acuan" class="form-control acuan-input"
            onchange="previewImage(event, 'acuan-preview-{{$d->id}}')">
          </div>
          <button type="submit" class="btn btn-modal">Save changes</button>
          </form>
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
  <!-- Add Modal -->
  <div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-labelledby="addEmployeeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="addEmployeeModalLabel">Tambah Pegawai</h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form action="{{ route('admin.kelolapegawai.add') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
        <div class="col-md-6">
          <div class="text-center mb-3">
          <img src="" alt="Preview" class="avatar-preview-modal" id="avatar-preview-add" style="display:none;">
          </div>
          <div class="mb-3">
          <label for="name" class="form-label">Name</label>
          <input type="text" class="form-control" id="name" name="name" required>
          </div>
          <div class="mb-3">
          <label for="username" class="form-label">Username</label>
          <input type="text" class="form-control" id="username" name="username" required>
          </div>
          <div class="mb-3">
          <label for="birthday" class="form-label">Birthday</label>
          <input type="date" class="form-control" id="birthday" name="birthday" required>
          </div>
          <div class="mb-3">
          <label for="jabatan" class="form-label">Jabatan</label>
          <input type="text" class="form-control" id="jabatan" name="jabatan" required>
          </div>
          <div class="mb-3">
          <label for="avatar" class="form-label">Avatar</label>
          <input type="file" id="avatar-input-add" name="avatar" class="form-control avatar-input"
            onchange="previewImage(event, 'avatar-preview-add')">
          </div>
          <div class="mb-3">
          <label for="acuan" class="form-label">Acuan</label>
          <input type="file" id="acuan-input-add" name="acuan" class="form-control acuan-input"
            onchange="previewImage(event, 'acuan-preview-add')">
          </div>
        </div>
        <div class="col-md-6">
          <div class="mb-3">
          <label for="no_pegawai" class="form-label">No Pegawai</label>
          <input type="text" class="form-control" id="no_pegawai" name="no_pegawai" value="{{$nopegawai}}"
            readonly>
          </div>
          <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" class="form-control" id="email" name="email">
          </div>
          <div class="mb-3">
          <label for="no_wa" class="form-label">No WA</label>
          <input type="text" class="form-control" id="no_wa" name="no_wa">
          </div>
          <div class="mb-3">
          <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
          <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir">
          </div>
          <div class="mb-3">
          <label for="gender" class="form-label">Gender</label>
          <select class="form-control" id="gender" name="gender">
            <option value="" selected disabled>--Pilih Gender--</option>
            <option value="Laki-Laki">Laki-Laki</option>
            <option value="Perempuan">Perempuan</option>
          </select>
          </div>
          <div class="mb-3">
          <label class="form-label"><small>Password Automaticly : <span
              style="color: red">ShabatMakmur</span></small></label>
          </div>
        </div>
        </div>
        <button type="submit" class="btn btn-modal">Add Employee</button>
      </form>
      </div>
    </div>
    </div>
  </div>
  <script>
function previewImage(event, previewId, containerId = null) {
  const input = event.target;
  const preview = document.getElementById(previewId);
  const container = containerId ? document.getElementById(containerId) : null;

  if (input.files && input.files[0]) {
    const reader = new FileReader();
    reader.onload = function(e) {
      preview.src = e.target.result;
      preview.classList.remove('d-none');
      if (container) container.classList.remove('d-none');
    };
    reader.readAsDataURL(input.files[0]);
  } else {
    preview.src = "";
    preview.classList.add('d-none');
    if (container) container.classList.add('d-none');
  }
}
</script>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
@endsection