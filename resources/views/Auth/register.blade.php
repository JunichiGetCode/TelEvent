<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - TelEVent</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh; margin: 0;
            display: flex; align-items: stretch;
        }
        .auth-left {
            flex: 1;
            background: linear-gradient(135deg, #1A1A2E 0%, #A00926 50%, #C60C30 100%);
            display: flex; flex-direction: column; justify-content: center; align-items: center;
            padding: 60px 50px; position: relative; overflow: hidden;
        }
        .auth-left::before { content: ''; position: absolute; width: 600px; height: 600px; background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, transparent 70%); top: -200px; left: -200px; border-radius: 50%; }
        .auth-left-content { position: relative; z-index: 1; text-align: center; }
        .auth-left-logo { font-size: 3rem; font-weight: 900; color: #fff; margin-bottom: 10px; }
        .auth-left-logo i { color: #FFD700; margin-right: 10px; }
        .auth-left-tagline { color: rgba(255,255,255,0.85); font-size: 1rem; margin-bottom: 40px; line-height: 1.8; }
        .step-item { display: flex; align-items: center; gap: 12px; margin-bottom: 18px; text-align: left; }
        .step-num { width: 36px; height: 36px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; color: #FFD700; flex-shrink: 0; font-size: 0.9rem; }
        .step-text { color: rgba(255,255,255,0.9); font-size: 0.9rem; font-weight: 500; }

        .auth-right { width: 520px; background: #F8F9FA; display: flex; flex-direction: column; justify-content: center; padding: 60px 50px; overflow-y: auto; }
        .auth-form-title { font-size: 1.8rem; font-weight: 800; color: #1A1A2E; margin-bottom: 8px; }
        .auth-form-subtitle { color: #64748B; font-size: 0.95rem; margin-bottom: 35px; }
        .form-label { font-weight: 600; color: #374151; font-size: 0.875rem; margin-bottom: 8px; }
        .form-control { border: 2px solid #E5E7EB; border-radius: 12px; padding: 12px 16px; font-size: 0.95rem; transition: 0.3s; background: #fff; }
        .form-control:focus { border-color: #C60C30; box-shadow: 0 0 0 4px rgba(198,12,48,0.1); outline: none; }
        .input-group .input-group-text { background: #fff; border: 2px solid #E5E7EB; border-right: none; border-radius: 12px 0 0 12px; color: #9CA3AF; }
        .input-group .form-control { border-left: none; border-radius: 0 12px 12px 0; }
        .input-group:focus-within .input-group-text { border-color: #C60C30; }
        .btn-auth-primary { background: linear-gradient(135deg, #C60C30, #A00926); color: #fff; border: none; border-radius: 12px; padding: 14px; font-weight: 700; font-size: 1rem; transition: 0.3s; width: 100%; margin-top: 8px; }
        .btn-auth-primary:hover { transform: translateY(-2px); box-shadow: 0 10px 25px rgba(198,12,48,0.35); }
        .auth-link { color: #C60C30; font-weight: 600; text-decoration: none; }
        .auth-link:hover { color: #A00926; text-decoration: underline; }
        .password-strength { height: 4px; border-radius: 4px; margin-top: 8px; transition: 0.3s; }
        @media (max-width: 992px) { .auth-left { display: none; } .auth-right { width: 100%; } }
    </style>
</head>
<body>
    <div class="auth-left d-none d-lg-flex">
        <div class="auth-left-content">
            <div class="auth-left-logo"><i class="fa-solid fa-calendar-check"></i>TelEVent</div>
            <p class="auth-left-tagline">Daftar dan mulai kelola acara-mu<br>bersama ribuan mahasiswa Telkom University</p>
            <div class="step-item"><div class="step-num">1</div><div class="step-text">Buat akun dengan data diri Anda</div></div>
            <div class="step-item"><div class="step-num">2</div><div class="step-text">Verifikasi dan lengkapi profil</div></div>
            <div class="step-item"><div class="step-num">3</div><div class="step-text">Langsung ajukan proposal acara!</div></div>
        </div>
    </div>

    <div class="auth-right">
        <div class="d-lg-none text-center mb-4">
            <span style="font-size:1.5rem; font-weight:800; color:#C60C30;"><i class="fa-solid fa-calendar-check me-2"></i>TelEVent</span>
        </div>
        <h2 class="auth-form-title">Buat Akun Baru 🚀</h2>
        <p class="auth-form-subtitle">Bergabung dengan komunitas penyelenggara acara Telkom University.</p>

        @if ($errors->any())
            <div class="alert alert-danger border-0 rounded-3 py-3 mb-4" style="background: rgba(239,68,68,0.1); color: #991B1B;">
                <div class="fw-bold mb-1"><i class="fa-solid fa-triangle-exclamation me-2"></i>Terdapat kesalahan:</div>
                <ul class="mb-0 ps-4 small">
                    @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register.perform') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Nama Lengkap</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Nama lengkap Anda" required>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fa-regular fa-envelope"></i></span>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="email@students.telkomuniversity.ac.id" required>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Kata Sandi</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Minimal 8 karakter" required>
                    <button type="button" class="input-group-text border-start-0 border border-2" onclick="togglePass('password','eyeIcon1')" style="cursor:pointer; border-radius:0 12px 12px 0; background:#fff; border-color:#E5E7EB;">
                        <i class="fa-regular fa-eye" id="eyeIcon1"></i>
                    </button>
                </div>
            </div>
            <div class="mb-4">
                <label class="form-label">Konfirmasi Kata Sandi</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fa-solid fa-lock-open"></i></span>
                    <input type="password" name="password_confirmation" id="password2" class="form-control" placeholder="Ulangi kata sandi" required>
                    <button type="button" class="input-group-text border-start-0 border border-2" onclick="togglePass('password2','eyeIcon2')" style="cursor:pointer; border-radius:0 12px 12px 0; background:#fff; border-color:#E5E7EB;">
                        <i class="fa-regular fa-eye" id="eyeIcon2"></i>
                    </button>
                </div>
            </div>
            <button type="submit" class="btn btn-auth-primary">
                <i class="fa-solid fa-user-plus me-2"></i>Buat Akun
            </button>
        </form>

        <div class="text-center mt-4" style="font-size:0.9rem; color:#6B7280;">
            Sudah punya akun? <a href="{{ route('login') }}" class="auth-link">Masuk sekarang</a>
        </div>
        <div class="text-center mt-2">
            <a href="{{ route('dashboard') }}" style="color:#9CA3AF; text-decoration:none; font-size:0.875rem;"><i class="fa-solid fa-arrow-left me-1"></i>Kembali ke Beranda</a>
        </div>
    </div>

    <script>
        function togglePass(inputId, iconId) {
            const p = document.getElementById(inputId);
            const i = document.getElementById(iconId);
            if (p.type === 'password') { p.type = 'text'; i.className = 'fa-regular fa-eye-slash'; }
            else { p.type = 'password'; i.className = 'fa-regular fa-eye'; }
        }
    </script>
</body>
</html>
