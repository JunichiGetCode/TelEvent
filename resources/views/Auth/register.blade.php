<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(
                180deg,
                #D2042D 0%,
                #A8092D 25%,
                #7D0D2C 50%,
                #450C1C 75%,
                #0D0A0B 100%
            );
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        .auth-card {
            max-width: 420px;
            width: 100%;
            background-color: #ffffff;
            border-radius: 16px;
            box-shadow: 0 18px 40px rgba(0, 0, 0, 0.40);
            border: 1px solid rgba(0,0,0,0.08);
            padding: 2.5rem 2.25rem;
        }

        .auth-title {
            text-align: center;
            font-weight: 700;
            font-size: 24px;
            color: #450C1C;
            margin-bottom: 1.5rem;
        }

        .form-label {
            font-weight: 500;
            color: #450C1C;
        }

        .btn-auth-primary {
            background-color: #D2042D;
            border-color: #D2042D;
            font-weight: 600;
            color: #ffffff;
        }

        .btn-auth-primary:hover {
            background-color: #A8092D;
            border-color: #A8092D;
            color: #ffffff;
        }

        .auth-text-muted {
            color: #7D0D2C;
            font-size: 0.95rem;
        }

        .auth-link {
            color: #D2042D;
            text-decoration: none;
            font-weight: 500;
        }

        .auth-link:hover {
            color: #A8092D;
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="auth-card">
        <h2 class="auth-title">Daftar</h2>

        {{-- error / validasi gagal --}}
        @if ($errors->any())
            <div class="alert alert-danger small">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register.perform') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Nama Lengkap</label>
                <input type="text"
                       name="name"
                       class="form-control"
                       value="{{ old('name') }}"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email"
                       name="email"
                       class="form-control"
                       value="{{ old('email') }}"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label">Kata Sandi</label>
                <input type="password"
                       name="password"
                       class="form-control"
                       required>
            </div>

            <div class="mb-4">
                <label class="form-label">Konfirmasi Kata Sandi</label>
                <input type="password"
                       name="password_confirmation"
                       class="form-control"
                       required>
            </div>

            <button type="submit" class="btn btn-auth-primary w-100">
                Daftar
            </button>

            <div class="text-center mt-3 auth-text-muted">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="auth-link">Masuk</a>
            </div>
        </form>
    </div>

</body>
</html>