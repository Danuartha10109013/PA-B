<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login || PT. Bersama Sahabat Makmur</title>
  <link rel="shortcut icon" type="image/png" href="{{asset('PT. Bersama Sahabat Makmur Logo.png')}}" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
  <style>
    body {
      min-height: 100vh;
      background: linear-gradient(120deg, #e0e7ff 0%, #a4cafe 100%);
      font-family: 'Inter', Arial, sans-serif;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0;
      padding: 0;
      overflow-x: hidden;
    }

    .login-outer {
      width: 100vw;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
      z-index: 1;
    }

    .login-card {
      background: #fff;
      border-radius: 22px;
      box-shadow: 0 8px 32px rgba(60, 72, 100, .13);
      padding: 2.5rem 2.2rem 2.2rem 2.2rem;
      max-width: 370px;
      width: 100%;
      display: flex;
      flex-direction: column;
      align-items: center;
      animation: fadeInUp 0.8s;
      position: relative;
      overflow: hidden;
    }

    .login-logo {
      width: 90px;
      height: 90px;
      border-radius: 18px;
      box-shadow: 0 2px 12px rgba(60, 72, 100, .10);
      margin-bottom: 1.1rem;
      object-fit: cover;
      background: #f3f6fd;
      display: block;
      animation: fadeIn 1.2s;
    }

    .login-title {
      font-weight: 700;
      font-size: 1.25rem;
      color: #3b4861;
      letter-spacing: 1px;
      text-align: center;
      margin-bottom: 2.1rem;
      line-height: 1.3;
    }

    .login-form {
      width: 100%;
      display: flex;
      flex-direction: column;
      gap: 1.1rem;
    }

    .input-group {
      position: relative;
      width: 100%;
      box-sizing: border-box;
      min-height: 48px;
    }

    .form-control {
      width: 100%;
      border-radius: 10px;
      border: 1.5px solid #e2e8f0;
      padding: 13px 44px 13px 44px;
      font-size: 1.07rem;
      background: #f8faff;
      transition: border-color 0.18s, box-shadow 0.18s;
      font-family: 'Inter', Arial, sans-serif;
      font-weight: 500;
      color: #3b4861;
      box-sizing: border-box;
      height: 48px;
    }

    .form-control:focus {
      border-color: #6a93ff;
      box-shadow: 0 0 0 2px rgba(93, 135, 255, 0.10);
      background: #fff;
      outline: none;
    }

    .input-icon,
    .toggle-password {
      position: absolute;
      top: 0;
      bottom: 0;
      display: flex;
      align-items: center;
      height: 100%;
    }

    .input-icon {
      left: 16px;
      color: #a0aec0;
      font-size: 1.15rem;
      pointer-events: none;
    }

    .toggle-password {
      right: 16px;
      color: #a0aec0;
      font-size: 1.15rem;
      cursor: pointer;
      transition: color 0.18s;
    }

    .toggle-password:hover {
      color: #6a93ff;
    }

    .form-error {
      color: #e53e3e;
      font-size: 0.93rem;
      margin-top: 0.3rem;
      margin-left: 2px;
      animation: fadeIn 0.5s;
    }

    .btn-login {
      background: linear-gradient(90deg, #6a93ff 0%, #a4cafe 100%);
      border: none;
      font-weight: 700;
      border-radius: 10px;
      transition: all 0.18s;
      box-shadow: 0 2px 8px rgba(93, 135, 255, 0.08);
      font-size: 1.13rem;
      padding: 13px 0;
      width: 100%;
      margin-top: 0.2rem;
      color: #fff;
      letter-spacing: 0.5px;
      position: relative;
      overflow: hidden;
    }

    .btn-login:active {
      transform: scale(0.98);
    }

    .btn-login[disabled] {
      opacity: 0.7;
      cursor: not-allowed;
    }

    .login-bottom {
      margin-top: 1.5rem;
      text-align: center;
      color: #a0aec0;
      font-size: 0.97rem;
    }

    .alert {
      border-radius: 8px;
      font-size: 0.97rem;
      margin-bottom: 1rem;
      animation: fadeIn 0.7s;
      width: 100%;
      text-align: left;
    }

    @media (max-width: 500px) {
      .login-card {
        padding: 1.2rem 0.5rem 1.5rem 0.5rem;
        max-width: 98vw;
      }

      .login-title {
        font-size: 1.05rem;
      }
    }

    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
      }

      to {
        opacity: 1;
      }
    }
  </style>
</head>

<body>
  <div class="login-outer">
    <div class="login-card">
      <img src="{{asset('PT. Bersama Sahabat Makmur Logo.png')}}" alt="Logo" class="login-logo">
      <div class="login-title">PT. Bersama Sahabat Makmur<br><span
          style="font-weight:400;font-size:0.98rem;color:#6a93ff;">Employee Portal</span></div>
      <form action="{{route('login-proses')}}" method="POST" class="login-form" autocomplete="off" id="loginForm">
        @method('POST')
        @csrf
        @if (session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif
        @if (session('error'))
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif
        <div class="input-group">
          <span class="input-icon"><i class="fa fa-user"></i></span>
          <input type="text" name="username" class="form-control" placeholder="Username" required autofocus
            value="{{ old('username') }}">
        </div>
        @if($errors->has('username'))
      <div class="form-error">{{ $errors->first('username') }}</div>
    @endif
        <div class="input-group">
          <span class="input-icon"><i class="fa fa-lock"></i></span>
          <input type="password" name="password" class="form-control" id="password-input" placeholder="Password"
            required>
          <span class="toggle-password" onclick="togglePassword()"><i class="fa fa-eye" id="eye-icon"></i></span>
        </div>
        @if($errors->has('password'))
      <div class="form-error">{{ $errors->first('password') }}</div>
    @endif
        <div style="margin-top:0.2rem; margin-bottom:0.7rem; display:flex; align-items:center;">
          <input class="form-check-input primary" type="checkbox" value="1" id="flexCheckChecked" name="remember"
            checked style="margin-right:7px;">
          <label class="form-check-label text-dark" for="flexCheckChecked" style="font-size:0.97rem;">Remember this
            Device</label>
        </div>
        <button type="submit" class="btn-login" id="loginBtn">
          <span id="loginBtnText">Sign In</span>
          <span id="loginBtnSpinner"
            style="display:none;position:absolute;right:18px;top:50%;transform:translateY(-50%);"><i
              class="fa fa-spinner fa-spin"></i></span>
        </button>
      </form>
      <div class="login-bottom">&copy; {{ date('Y') }} PT. Bersama Sahabat Makmur</div>
    </div>
  </div>
  <script>
    function togglePassword() {
      const input = document.getElementById('password-input');
      const icon = document.getElementById('eye-icon');
      if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
      } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
      }
    }
    // Animasi loading pada tombol login
    document.getElementById('loginForm').addEventListener('submit', function () {
      document.getElementById('loginBtn').setAttribute('disabled', 'disabled');
      document.getElementById('loginBtnText').style.opacity = '0.5';
      document.getElementById('loginBtnSpinner').style.display = 'inline-block';
    });
  </script>
</body>

</html>