<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - TelEVent</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            margin: 0;
            display: flex;
            align-items: stretch;
        }

        /* LEFT PANEL */
        .auth-left {
            flex: 1;
            background: linear-gradient(135deg, #C60C30 0%, #A00926 50%, #1A1A2E 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 60px 50px;
            position: relative;
            overflow: hidden;
        }
        .auth-left::before {
            content: '';
            position: absolute;
            width: 600px; height: 600px;
            background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, transparent 70%);
            top: -200px; right: -200px; border-radius: 50%;
        }
        .auth-left::after {
            content: '';
            position: absolute;
            width: 400px; height: 400px;
            background: radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 70%);
            bottom: -100px; left: -100px; border-radius: 50%;
        }
        .auth-left-content { position: relative; z-index: 1; text-align: center; }
        .auth-left-logo { font-size: 3rem; font-weight: 900; color: #fff; margin-bottom: 10px; letter-spacing: -1px; }
        .auth-left-logo i { color: #FFD700; margin-right: 10px; }
        .auth-left-tagline { color: rgba(255,255,255,0.85); font-size: 1.1rem; margin-bottom: 50px; line-height: 1.7; }
        .auth-feature { display: flex; align-items: center; gap: 15px; margin-bottom: 20px; text-align: left; }
        .auth-feature-icon { width: 48px; height: 48px; background: rgba(255,255,255,0.15); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px; color: #FFD700; flex-shrink: 0; }
        .auth-feature-text .title { font-weight: 700; color: #fff; font-size: 0.95rem; }
        .auth-feature-text .desc { font-size: 0.82rem; color: rgba(255,255,255,0.65); margin-top: 2px; }

        /* RIGHT PANEL */
        .auth-right {
            width: 500px;
            background: #F8F9FA;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 60px 50px;
            overflow-y: auto;
        }
        .auth-form-title { font-size: 1.8rem; font-weight: 800; color: #1A1A2E; margin-bottom: 8px; }
        .auth-form-subtitle { color: #64748B; font-size: 0.95rem; margin-bottom: 40px; }

        .form-label { font-weight: 600; color: #374151; font-size: 0.875rem; margin-bottom: 8px; }
        .form-control { border: 2px solid #E5E7EB; border-radius: 12px; padding: 12px 16px; font-size: 0.95rem; transition: 0.3s; background: #fff; }
        .form-control:focus { border-color: #C60C30; box-shadow: 0 0 0 4px rgba(198,12,48,0.1); outline: none; }
        .input-group .input-group-text { background: #fff; border: 2px solid #E5E7EB; border-right: none; border-radius: 12px 0 0 12px; color: #9CA3AF; }
        .input-group .form-control { border-left: none; border-radius: 0 12px 12px 0; }
        .input-group:focus-within .input-group-text { border-color: #C60C30; }

        .btn-auth-primary { background: linear-gradient(135deg, #C60C30, #A00926); color: #fff; border: none; border-radius: 12px; padding: 14px; font-weight: 700; font-size: 1rem; transition: 0.3s; width: 100%; margin-top: 8px; }
        .btn-auth-primary:hover { transform: translateY(-2px); box-shadow: 0 10px 25px rgba(198,12,48,0.35); }

        .auth-divider { text-align: center; margin: 20px 0; color: #9CA3AF; font-size: 0.85rem; position: relative; }
        .auth-divider::before, .auth-divider::after { content: ''; position: absolute; top: 50%; width: 40%; height: 1px; background: #E5E7EB; }
        .auth-divider::before { left: 0; }
        .auth-divider::after { right: 0; }

        .auth-link { color: #C60C30; font-weight: 600; text-decoration: none; }
        .auth-link:hover { color: #A00926; text-decoration: underline; }

        .back-link { color: #9CA3AF; text-decoration: none; font-size: 0.875rem; display: inline-flex; align-items: center; gap: 6px; transition: 0.2s; }
        .back-link:hover { color: #6B7280; }

        @media (max-width: 992px) {
            .auth-left { display: none; }
            .auth-right { width: 100%; }
        }
    </style>
</head>
<body>
    <!-- LEFT PANEL -->
    <div class="auth-left d-none d-lg-flex">
        <div class="auth-left-content">
            <div class="auth-left-logo"><i class="fa-solid fa-calendar-check"></i>TelEVent</div>
            <p class="auth-left-tagline">Platform Manajemen Acara Digital<br>Telkom University</p>
            <div class="auth-feature">
                <div class="auth-feature-icon"><i class="fa-solid fa-file-circle-check"></i></div>
                <div class="auth-feature-text">
                    <div class="title">Pengajuan Proposal Digital</div>
                    <div class="desc">Upload semua dokumen dalam satu platform</div>
                </div>
            </div>
            <div class="auth-feature">
                <div class="auth-feature-icon"><i class="fa-solid fa-gauge-high"></i></div>
                <div class="auth-feature-text">
                    <div class="title">Dashboard Real-time</div>
                    <div class="desc">Pantau status acara kapan saja, di mana saja</div>
                </div>
            </div>
            <div class="auth-feature">
                <div class="auth-feature-icon"><i class="fa-solid fa-shield-halved"></i></div>
                <div class="auth-feature-text">
                    <div class="title">Persetujuan Terpercaya</div>
                    <div class="desc">Proses review oleh admin yang terstruktur</div>
                </div>
            </div>
        </div>
    </div>

    <!-- RIGHT PANEL -->
    <div class="auth-right">
        <div class="d-lg-none text-center mb-4">
            <span style="font-size:1.5rem; font-weight:800; color:#C60C30;"><i class="fa-solid fa-calendar-check me-2"></i>TelEVent</span>
        </div>

        <h2 class="auth-form-title">Selamat Datang Kembali! 👋</h2>
        <p class="auth-form-subtitle">Masuk ke akun Anda untuk mulai mengelola acara.</p>

        @if (session('success'))
            <div class="alert alert-success border-0 rounded-3 py-3 mb-4" style="background: rgba(16,185,129,0.1); color: #065F46;">
                <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger border-0 rounded-3 py-3 mb-4" style="background: rgba(239,68,68,0.1); color: #991B1B;">
                <div class="fw-bold mb-1"><i class="fa-solid fa-triangle-exclamation me-2"></i>Terdapat kesalahan:</div>
                <ul class="mb-0 ps-4 small">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login.process') }}">
            @csrf

            <div class="mb-4">
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
                    <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan kata sandi" required>
                    <button type="button" class="input-group-text border-start-0 border border-2" onclick="togglePassword()" style="cursor:pointer; border-radius:0 12px 12px 0; background:#fff; border-color:#E5E7EB;">
                        <i class="fa-regular fa-eye" id="eyeIcon"></i>
                    </button>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" style="border-color:#C60C30;">
                    <label class="form-check-label small text-muted" for="remember">Ingat Saya</label>
                </div>
            </div>

            <button type="submit" class="btn btn-auth-primary">
                <i class="fa-solid fa-right-to-bracket me-2"></i>Masuk
            </button>
        </form>

        <div class="text-center mt-4" style="font-size:0.9rem; color:#6B7280;">
            Belum punya akun? <a href="{{ route('register.show') }}" class="auth-link">Daftar Gratis</a>
        </div>

        <div class="text-center mt-3">
            <a href="{{ route('dashboard') }}" class="back-link"><i class="fa-solid fa-arrow-left"></i> Kembali ke Beranda</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function togglePassword() {
            const pass = document.getElementById('password');
            const icon = document.getElementById('eyeIcon');
            if (pass.type === 'password') { pass.type = 'text'; icon.className = 'fa-regular fa-eye-slash'; }
            else { pass.type = 'password'; icon.className = 'fa-regular fa-eye'; }
        }
    </script>
</body>
</html>
