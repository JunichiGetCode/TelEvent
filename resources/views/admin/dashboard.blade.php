<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - TelEVent</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --red: #C60C30;
            --red-dark: #A00926;
            --sidebar-bg: #0F0F1A;
            --sidebar-width: 260px;
            --bg: #F4F7FE;
            --card-bg: #FFFFFF;
            --text: #1A1A2E;
            --muted: #64748B;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: var(--bg); color: var(--text); min-height: 100vh; display: flex; }

        /* SIDEBAR */
        .sidebar {
            width: var(--sidebar-width);
            background: var(--sidebar-bg);
            height: 100vh; position: fixed; top: 0; left: 0;
            display: flex; flex-direction: column;
            padding: 0; z-index: 100;
            border-right: 1px solid rgba(255,255,255,0.05);
        }
        .sidebar-header {
            padding: 28px 24px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }
        .sidebar-logo { font-size: 1.4rem; font-weight: 900; color: #fff; display: flex; align-items: center; gap: 10px; }
        .sidebar-logo i { color: var(--red); background: rgba(198,12,48,0.15); width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 16px; }
        .sidebar-role { font-size: 0.75rem; color: rgba(255,255,255,0.4); margin-top: 4px; letter-spacing: 1px; text-transform: uppercase; }

        .sidebar-nav { flex: 1; padding: 20px 16px; overflow-y: auto; }
        .nav-section-label { font-size: 0.7rem; font-weight: 700; color: rgba(255,255,255,0.3); letter-spacing: 1.5px; text-transform: uppercase; margin: 20px 0 8px 12px; }
        .nav-link {
            display: flex; align-items: center; gap: 12px;
            padding: 12px 14px; border-radius: 12px;
            color: rgba(255,255,255,0.55); text-decoration: none;
            font-size: 0.9rem; font-weight: 500; transition: 0.25s;
            margin-bottom: 4px;
        }
        .nav-link i { width: 20px; font-size: 16px; text-align: center; opacity: 0.8; }
        .nav-link:hover { color: #fff; background: rgba(255,255,255,0.07); }
        .nav-link.active { color: #fff; background: linear-gradient(135deg, var(--red), var(--red-dark)); box-shadow: 0 4px 15px rgba(198,12,48,0.4); }
        .nav-link.active i { opacity: 1; }

        .sidebar-footer {
            padding: 20px 16px;
            border-top: 1px solid rgba(255,255,255,0.08);
        }
        .admin-info { display: flex; align-items: center; gap: 12px; margin-bottom: 14px; }
        .admin-avatar { width: 40px; height: 40px; border-radius: 12px; background: linear-gradient(135deg, var(--red), var(--red-dark)); display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 700; font-size: 0.9rem; }
        .admin-name { font-weight: 700; color: #fff; font-size: 0.875rem; }
        .admin-email { font-size: 0.75rem; color: rgba(255,255,255,0.4); }
        .btn-logout {
            width: 100%; background: rgba(239,68,68,0.1); border: none; color: #F87171;
            padding: 11px; border-radius: 10px; cursor: pointer;
            font-family: inherit; font-weight: 600; display: flex; align-items: center; justify-content: center;
            gap: 8px; transition: 0.25s; font-size: 0.875rem;
        }
        .btn-logout:hover { background: rgba(239,68,68,0.2); }

        /* MAIN */
        .main-wrap { margin-left: var(--sidebar-width); flex: 1; min-height: 100vh; }

        /* TOP BAR */
        .topbar {
            background: #fff; padding: 18px 36px;
            display: flex; align-items: center; justify-content: space-between;
            border-bottom: 1px solid #F1F5F9;
            box-shadow: 0 2px 10px rgba(0,0,0,0.03);
            position: sticky; top: 0; z-index: 50;
        }
        .topbar-title { font-size: 1.3rem; font-weight: 800; color: var(--text); }
        .topbar-right { display: flex; align-items: center; gap: 16px; }
        .topbar-time { font-size: 0.85rem; color: var(--muted); }
        .topbar-badge { background: rgba(198,12,48,0.1); color: var(--red); font-size: 0.8rem; font-weight: 700; padding: 6px 14px; border-radius: 50px; }

        /* CONTENT */
        .content { padding: 36px; }

        /* STAT CARDS */
        .stat-cards { display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 20px; margin-bottom: 36px; }
        .stat-card {
            background: var(--card-bg); border-radius: 20px; padding: 24px;
            display: flex; flex-direction: column;
            box-shadow: 0 4px 20px rgba(0,0,0,0.04);
            border: 1px solid rgba(0,0,0,0.03);
            transition: 0.3s; cursor: pointer;
        }
        .stat-card:hover { transform: translateY(-4px); box-shadow: 0 12px 35px rgba(0,0,0,0.08); }
        .stat-card-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px; }
        .stat-card-icon { width: 52px; height: 52px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 22px; }
        .stat-card-icon.green { background: rgba(16,185,129,0.1); color: #10B981; }
        .stat-card-icon.orange { background: rgba(245,158,11,0.1); color: #F59E0B; }
        .stat-card-icon.red { background: rgba(239,68,68,0.1); color: #EF4444; }
        .stat-card-icon.blue { background: rgba(59,130,246,0.1); color: #3B82F6; }
        .stat-card-number { font-size: 2rem; font-weight: 900; color: var(--text); line-height: 1; }
        .stat-card-label { font-size: 0.8rem; font-weight: 600; color: var(--muted); margin-top: 6px; text-transform: uppercase; letter-spacing: 0.5px; }
        .stat-card-trend { font-size: 0.78rem; margin-top: 10px; color: #94A3B8; }

        /* RECENT TABLE */
        .section-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; }
        .section-title { font-size: 1.1rem; font-weight: 800; color: var(--text); }
        .view-all-link { font-size: 0.875rem; color: var(--red); text-decoration: none; font-weight: 600; display: flex; align-items: center; gap: 6px; }
        .view-all-link:hover { text-decoration: underline; }

        .table-card { background: var(--card-bg); border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.04); overflow: hidden; border: 1px solid rgba(0,0,0,0.03); }
        .table-card table { width: 100%; border-collapse: collapse; }
        .table-card th { padding: 14px 20px; color: var(--muted); font-weight: 600; font-size: 0.78rem; letter-spacing: 0.5px; text-transform: uppercase; background: #FAFBFC; border-bottom: 1px solid #F1F5F9; text-align: left; }
        .table-card td { padding: 16px 20px; border-bottom: 1px solid #F8FAFC; vertical-align: middle; }
        .table-card tr:last-child td { border-bottom: none; }
        .table-card tr:hover td { background: #FAFBFF; }

        .event-name-cell { font-weight: 600; color: var(--text); text-decoration: none; font-size: 0.9rem; }
        .event-name-cell:hover { color: var(--red); }
        .event-by { font-size: 0.78rem; color: var(--muted); margin-top: 2px; }

        .status-badge { padding: 5px 12px; border-radius: 50px; font-size: 0.75rem; font-weight: 700; display: inline-flex; align-items: center; gap: 5px; }
        .status-approved { background: rgba(16,185,129,0.1); color: #10B981; }
        .status-rejected { background: rgba(239,68,68,0.1); color: #EF4444; }
        .status-pending { background: rgba(245,158,11,0.1); color: #F59E0B; }

        .action-btns { display: flex; gap: 6px; }
        .btn-action { width: 32px; height: 32px; border-radius: 8px; border: none; display: inline-flex; align-items: center; justify-content: center; cursor: pointer; transition: 0.2s; color: #fff; text-decoration: none; font-size: 12px; }
        .btn-action:hover { transform: translateY(-2px); color: #fff; }
        .btn-view { background: #3B82F6; }
        .btn-accept { background: #10B981; }
        .btn-reject { background: #EF4444; }
        .btn-edit { background: #F59E0B; }

        /* MODAL */
        .modal-overlay { display: none; position: fixed; inset: 0; background: rgba(15,15,26,0.7); backdrop-filter: blur(6px); z-index: 1000; justify-content: center; align-items: center; }
        .modal-box { background: #fff; width: 100%; max-width: 580px; border-radius: 24px; overflow: hidden; max-height: 85vh; display: flex; flex-direction: column; box-shadow: 0 25px 60px rgba(0,0,0,0.25); animation: slideUp 0.3s ease; }
        @keyframes slideUp { from { transform: translateY(40px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
        .modal-head { display: flex; justify-content: space-between; align-items: center; padding: 22px 26px; border-bottom: 1px solid #F1F5F9; }
        .modal-title { font-size: 1.05rem; font-weight: 800; color: var(--text); display: flex; align-items: center; gap: 10px; }
        .modal-close { background: #F1F5F9; border: none; width: 32px; height: 32px; border-radius: 8px; cursor: pointer; font-size: 18px; color: var(--muted); transition: 0.2s; display: flex; align-items: center; justify-content: center; }
        .modal-close:hover { background: #E5E7EB; }
        .modal-body { overflow-y: auto; flex: 1; }
        .modal-item { display: flex; align-items: center; padding: 14px 26px; border-bottom: 1px solid #F8FAFC; transition: 0.2s; }
        .modal-item:hover { background: #FAFBFF; }
        .modal-item:last-child { border-bottom: none; }
    </style>
</head>
<body>
    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <div class="sidebar-logo">
                <i class="fa-solid fa-calendar-check"></i>
                TelEVent
            </div>
            <div class="sidebar-role">Admin Panel</div>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-section-label">Menu Utama</div>
            <a href="{{ route('admin.dashboard') }}" class="nav-link active">
                <i class="fa-solid fa-chart-pie"></i> Dashboard
            </a>
            <a href="{{ route('admin.events.index') }}" class="nav-link">
                <i class="fa-solid fa-calendar-days"></i> Kelola Acara
            </a>

            <div class="nav-section-label">Navigasi</div>
            <a href="{{ route('user.home') }}" class="nav-link">
                <i class="fa-solid fa-house"></i> Beranda User
            </a>
            <a href="{{ route('events.index') }}" class="nav-link">
                <i class="fa-solid fa-globe"></i> Direktori Acara
            </a>
        </nav>

        <div class="sidebar-footer">
            <div class="admin-info">
                <div class="admin-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                <div>
                    <div class="admin-name">{{ Auth::user()->name }}</div>
                    <div class="admin-email">Administrator</div>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-logout">
                    <i class="fa-solid fa-right-from-bracket"></i> Keluar
                </button>
            </form>
        </div>
    </aside>

    <!-- MAIN -->
    <div class="main-wrap">
        <!-- TOP BAR -->
        <div class="topbar">
            <div>
                <div class="topbar-title">Dashboard Admin</div>
            </div>
            <div class="topbar-right">
                <span class="topbar-time" id="realtime-clock"><i class="fa-regular fa-clock me-1"></i> {{ now()->timezone('Asia/Jakarta')->format('d M Y, H:i:s') }} WIB</span>
                <span class="topbar-badge"><i class="fa-solid fa-shield me-1"></i>Admin</span>
            </div>
        </div>

        <!-- CONTENT -->
        <div class="content">

            @if(session('success'))
            <div style="background: rgba(16,185,129,0.1); color: #065F46; padding: 14px 18px; border-radius: 12px; margin-bottom: 24px; font-weight: 500; display:flex; align-items:center; gap:10px;">
                <i class="fa-solid fa-check-circle"></i> {{ session('success') }}
            </div>
            @endif

            <!-- STAT CARDS -->
            <div class="stat-cards">
                <div class="stat-card" onclick="openModal('modal-reviewed')">
                    <div class="stat-card-header">
                        <div class="stat-card-icon green"><i class="fa-solid fa-check-double"></i></div>
                    </div>
                    <div class="stat-card-number">{{ $sudahReview ?? 0 }}</div>
                    <div class="stat-card-label">Selesai Ditinjau</div>
                    <div class="stat-card-trend"><i class="fa-solid fa-arrow-up me-1"></i>Klik untuk lihat detail</div>
                </div>

                <div class="stat-card" onclick="openModal('modal-pending')">
                    <div class="stat-card-header">
                        <div class="stat-card-icon orange"><i class="fa-solid fa-hourglass-half"></i></div>
                    </div>
                    <div class="stat-card-number">{{ $menungguReview ?? 0 }}</div>
                    <div class="stat-card-label">Menunggu Tinjauan</div>
                    <div class="stat-card-trend"><i class="fa-solid fa-clock me-1"></i>Perlu ditindaklanjuti</div>
                </div>

                <div class="stat-card">
                    <div class="stat-card-header">
                        <div class="stat-card-icon blue"><i class="fa-solid fa-layer-group"></i></div>
                    </div>
                    <div class="stat-card-number">{{ ($sudahReview ?? 0) + ($menungguReview ?? 0) }}</div>
                    <div class="stat-card-label">Total Pengajuan</div>
                    <div class="stat-card-trend"><i class="fa-solid fa-list me-1"></i>Semua pengajuan masuk</div>
                </div>
            </div>

            <!-- RECENT PROPOSALS -->
            <div class="section-header">
                <div class="section-title"><i class="fa-solid fa-clock-rotate-left me-2" style="color:var(--red);"></i> Pengajuan Terbaru</div>
                <a href="{{ route('admin.events.index') }}" class="view-all-link">Lihat Semua <i class="fa-solid fa-arrow-right"></i></a>
            </div>

            <div class="table-card">
                @if(isset($recentEvents) && count($recentEvents) > 0)
                <table>
                    <thead>
                        <tr>
                            <th>Acara</th>
                            <th>Status</th>
                            <th>Waktu</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentEvents as $event)
                        <tr>
                            <td>
                                <a href="{{ route('events.show', $event->id) }}" class="event-name-cell">{{ $event->title }}</a>
                                <div class="event-by"><i class="fa-solid fa-user fa-xs me-1"></i>{{ $event->user->name ?? 'User' }}</div>
                            </td>
                            <td>
                                @if($event->status == 'approved')
                                    <span class="status-badge status-approved"><i class="fa-solid fa-circle fa-xs"></i> Disetujui</span>
                                @elseif($event->status == 'rejected')
                                    <span class="status-badge status-rejected"><i class="fa-solid fa-circle fa-xs"></i> Ditolak</span>
                                @else
                                    <span class="status-badge status-pending"><i class="fa-solid fa-circle fa-xs"></i> Menunggu</span>
                                @endif
                            </td>
                            <td style="font-size:0.82rem; color:var(--muted);">{{ $event->created_at->diffForHumans() }}</td>
                            <td>
                                <div class="action-btns">
                                    <a href="{{ route('events.show', $event->id) }}" class="btn-action btn-view" title="Lihat"><i class="fa-solid fa-eye"></i></a>
                                    <a href="{{ route('admin.events.edit', $event->id) }}" class="btn-action btn-edit" title="Edit"><i class="fa-solid fa-pen"></i></a>
                                    <form action="{{ route('admin.event.status', ['id' => $event->id, 'status' => 'approved']) }}" method="POST" style="display:inline">
                                        @csrf <button type="submit" class="btn-action btn-accept" title="Setujui"><i class="fa-solid fa-check"></i></button>
                                    </form>
                                    <form action="{{ route('admin.event.status', ['id' => $event->id, 'status' => 'rejected']) }}" method="POST" style="display:inline">
                                        @csrf <button type="submit" class="btn-action btn-reject" title="Tolak"><i class="fa-solid fa-xmark"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div style="text-align:center; padding:60px 20px; color:#94A3B8;">
                    <i class="fa-solid fa-folder-open fa-3x mb-3" style="opacity:0.4;"></i>
                    <p style="margin:0;">Belum ada pengajuan yang masuk.</p>
                </div>
                @endif
            </div>

        </div>
    </div>

    <!-- MODAL: Selesai Ditinjau -->
    <div id="modal-reviewed" class="modal-overlay" onclick="closeModal(event,'modal-reviewed')">
        <div class="modal-box" onclick="event.stopPropagation()">
            <div class="modal-head">
                <span class="modal-title"><i class="fa-solid fa-check-circle" style="color:#10B981;"></i> Selesai Ditinjau</span>
                <button class="modal-close" onclick="closeModal(null,'modal-reviewed')">×</button>
            </div>
            <div class="modal-body">
                @if(isset($reviewedEvents) && count($reviewedEvents) > 0)
                    @foreach($reviewedEvents as $item)
                    <div class="modal-item">
                        <div style="flex:1;">
                            <a href="{{ route('events.show', $item->id) }}" style="text-decoration:none; font-weight:600; color:var(--text);">{{ $item->title }}</a>
                            <div style="font-size:0.78rem; color:var(--muted); margin-top:2px;">{{ $item->user->name ?? 'User' }}</div>
                        </div>
                        @if($item->status == 'approved')
                            <span class="status-badge status-approved">Disetujui</span>
                        @else
                            <span class="status-badge status-rejected">Ditolak</span>
                        @endif
                        <a href="{{ route('events.show', $item->id) }}" class="btn-action btn-view ms-2"><i class="fa-solid fa-eye"></i></a>
                    </div>
                    @endforeach
                @else
                    <p style="text-align:center; padding:40px; color:#94A3B8;">Belum ada acara yang selesai ditinjau.</p>
                @endif
            </div>
        </div>
    </div>

    <!-- MODAL: Menunggu Tinjauan -->
    <div id="modal-pending" class="modal-overlay" onclick="closeModal(event,'modal-pending')">
        <div class="modal-box" onclick="event.stopPropagation()">
            <div class="modal-head">
                <span class="modal-title"><i class="fa-solid fa-hourglass-half" style="color:#F59E0B;"></i> Menunggu Tinjauan</span>
                <button class="modal-close" onclick="closeModal(null,'modal-pending')">×</button>
            </div>
            <div class="modal-body">
                @if(isset($pendingEvents) && count($pendingEvents) > 0)
                    @foreach($pendingEvents as $item)
                    <div class="modal-item">
                        <div style="flex:1;">
                            <a href="{{ route('events.show', $item->id) }}" style="text-decoration:none; font-weight:600; color:var(--text);">{{ $item->title }}</a>
                            <div style="font-size:0.78rem; color:var(--muted); margin-top:2px;">{{ $item->user->name ?? 'User' }}</div>
                        </div>
                        <span class="status-badge status-pending ms-2">Menunggu</span>
                        <a href="{{ route('events.show', $item->id) }}" class="btn-action btn-view ms-2"><i class="fa-solid fa-eye"></i></a>
                    </div>
                    @endforeach
                @else
                    <p style="text-align:center; padding:40px; color:#94A3B8;">Tidak ada acara yang menunggu tinjauan.</p>
                @endif
            </div>
        </div>
    </div>

    <script>
        function openModal(id) { document.getElementById(id).style.display = 'flex'; document.body.style.overflow = 'hidden'; }
        function closeModal(e, id) { if (!e || e.target.id === id) { document.getElementById(id).style.display = 'none'; document.body.style.overflow = ''; } }
        document.addEventListener('keydown', e => { if (e.key === 'Escape') { document.querySelectorAll('.modal-overlay').forEach(m => { m.style.display = 'none'; }); document.body.style.overflow = ''; } });

        // Real-time clock
        function updateTime() {
            const now = new Date();
            const d = String(now.getDate()).padStart(2, '0');
            const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agt', 'Sep', 'Okt', 'Nov', 'Des'];
            const m = months[now.getMonth()];
            const y = now.getFullYear();
            const h = String(now.getHours()).padStart(2, '0');
            const min = String(now.getMinutes()).padStart(2, '0');
            const sec = String(now.getSeconds()).padStart(2, '0');
            document.getElementById('realtime-clock').innerHTML = `<i class="fa-regular fa-clock me-1"></i> ${d} ${m} ${y}, ${h}:${min}:${sec} WIB`;
        }
        setInterval(updateTime, 1000);
        updateTime();
    </script>
</body>
</html>
