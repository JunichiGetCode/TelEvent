<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TelUVent – Dashboard User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --red-light: #D2042D;
            --red-mid:   #A8092D;
            --red-dark:  #450C1C;
            --bg-soft:   #FFF5F6;
            --card-bg:   #FFFFFF;
            --text-soft: #6B6B6B;
        }

        body {
            background-color: var(--bg-soft);
            font-family: system-ui, sans-serif;
        }

        .nav-shell {
            background: linear-gradient(90deg, var(--red-light), var(--red-mid));
            padding: 1rem;
        }

        .navbar-brand {
            font-weight: 800;
            color: #fff !important;
        }

        .nav-link {
            color: #fff !important;
            font-weight: 500;
        }

        .logout-btn {
            background-color: #ffffff;
            color: #D2042D;
            border-radius: 50px;
            border: 2px solid #D2042D;
            padding: 8px 24px;
            font-weight: bold;
        }

        .logout-btn:hover {
            background-color: #D2042D;
            color: white;
        }
    </style>
</head>
<body>
    <!-- NAVBAR -->
    <div class="nav-shell">
        <div class="container d-flex justify-content-between align-items-center">
            <a class="navbar-brand" href="{{ route('user.home') }}">TelUVent</a>
            <div class="d-flex gap-3 align-items-center">
                <a href="{{ route('user.home') }}" class="nav-link">Beranda</a>
                <a href="{{ route('events.index') }}" class="nav-link">Semua Acara</a>
                <a href="{{ route('about') }}" class="nav-link">About</a>
                <a href="{{ route('profile.show') }}" class="nav-link">Profile</a>
                <span class="text-white fw-semibold">Halo, {{ Auth::user()->name }} 👋</span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="logout-btn">Keluar</button>
                </form>
            </div>
        </div>
    </div>
    
    <!-- PROFILE PAGE -->
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-4">
                <!-- Profile Image and Basic Info -->
                <div class="card shadow-sm" style="border-radius: 15px;">
                    <img src="{{ asset('storage/profile/' . Auth::user()->avatar) }}" class="card-img-top" alt="User Image">
                    <div class="card-body text-center">
                        <h5 class="card-title">{{ Auth::user()->name }}</h5>
                        <p class="card-text">Email: {{ Auth::user()->email }}</p>
                        <p class="card-text">Gender: {{ Auth::user()->gender }}</p>
                        <p class="card-text">Alerts: {{ Auth::user()->alerts ? 'Enabled' : 'Disabled' }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <!-- Event Information -->
                <div class="card shadow-sm mb-4" style="border-radius: 15px;">
                    <div class="card-body">
                        <h4 class="card-title">Acara-mu</h4>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="card text-white bg-danger">
                                    <div class="card-body">
                                        <h5 class="card-title">5</h5>
                                        <p class="card-text">Selesai</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="card text-white bg-success">
                                    <div class="card-body">
                                        <h5 class="card-title">2</h5>
                                        <p class="card-text">Akan Berlangsung</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="card text-white bg-warning">
                                    <div class="card-body">
                                        <h5 class="card-title">5</h5>
                                        <p class="card-text">Menunggu Persetujuan</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Event List -->
                <h4>Upcoming Appointments</h4>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Event</th>
                            <th>Status</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>29 Sep</td>
                            <td>Plumbing</td>
                            <td>Cancelled</td>
                            <td>$50</td>
                        </tr>
                        <tr>
                            <td>15 Oct</td>
                            <td>Carpentry</td>
                            <td>Booked</td>
                            <td>$345</td>
                        </tr>
                        <tr>
                            <td>11 Nov</td>
                            <td>Painting</td>
                            <td>Done</td>
                            <td>$130</td>
                        </tr>
                        <tr>
                            <td>13 Apr</td>
                            <td>Hair Drying</td>
                            <td>Done</td>
                            <td>$50</td>
                        </tr>
                        <tr>
                            <td>24 Feb</td>
                            <td>Blue Print Structure</td>
                            <td>Booked</td>
                            <td>$80</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Include Bootstrap JS (optional for dropdown, modals, etc.) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>