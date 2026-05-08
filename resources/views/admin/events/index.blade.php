<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Acara - Admin TelEVent</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --red: #C60C30; --red-dark: #A00926; --sidebar-bg: #0F0F1A; --sidebar-width: 260px; --bg: #F4F7FE; --card-bg: #FFFFFF; --text: #1A1A2E; --muted: #64748B; }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: var(--bg); color: var(--text); min-height: 100vh; display: flex; }

        .sidebar { width: var(--sidebar-width); background: var(--sidebar-bg); height: 100vh; position: fixed; top: 0; left: 0; display: flex; flex-direction: column; z-index: 100; border-right: 1px solid rgba(255,255,255,0.05); }
        .sidebar-header { padding: 28px 24px; border-bottom: 1px solid rgba(255,255,255,0.08); }
        .sidebar-logo { font-size: 1.4rem; font-weight: 900; color: #fff; display: flex; align-items: center; gap: 10px; }
        .sidebar-logo i { color: var(--red); background: rgba(198,12,48,0.15); width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 16px; }
        .sidebar-role { font-size: 0.75rem; color: rgba(255,255,255,0.4); margin-top: 4px; letter-spacing: 1px; text-transform: uppercase; }
        .sidebar-nav { flex: 1; padding: 20px 16px; overflow-y: auto; }
        .nav-section-label { font-size: 0.7rem; font-weight: 700; color: rgba(255,255,255,0.3); letter-spacing: 1.5px; text-transform: uppercase; margin: 20px 0 8px 12px; }
        .nav-link { display: flex; align-items: center; gap: 12px; padding: 12px 14px; border-radius: 12px; color: rgba(255,255,255,0.55); text-decoration: none; font-size: 0.9rem; font-weight: 500; transition: 0.25s; margin-bottom: 4px; }
        .nav-link i { width: 20px; font-size: 16px; text-align: center; }
        .nav-link:hover { color: #fff; background: rgba(255,255,255,0.07); }
        .nav-link.active { color: #fff; background: linear-gradient(135deg, var(--red), var(--red-dark)); box-shadow: 0 4px 15px rgba(198,12,48,0.4); }
        .sidebar-footer { padding: 20px 16px; border-top: 1px solid rgba(255,255,255,0.08); }
        .admin-info { display: flex; align-items: center; gap: 12px; margin-bottom: 14px; }
        .admin-avatar { width: 40px; height: 40px; border-radius: 12px; background: linear-gradient(135deg, var(--red), var(--red-dark)); display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 700; font-size: 0.9rem; }
        .admin-name { font-weight: 700; color: #fff; font-size: 0.875rem; }
        .admin-email { font-size: 0.75rem; color: rgba(255,255,255,0.4); }
        .btn-logout { width: 100%; background: rgba(239,68,68,0.1); border: none; color: #F87171; padding: 11px; border-radius: 10px; cursor: pointer; font-family: inherit; font-weight: 600; display: flex; align-items: center; justify-content: center; gap: 8px; transition: 0.25s; font-size: 0.875rem; }
        .btn-logout:hover { background: rgba(239,68,68,0.2); }

        .main-wrap { margin-left: var(--sidebar-width); flex: 1; }
        .topbar { background: #fff; padding: 18px 36px; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid #F1F5F9; box-shadow: 0 2px 10px rgba(0,0,0,0.03); position: sticky; top: 0; z-index: 50; }
        .topbar-title { font-size: 1.3rem; font-weight: 800; color: var(--text); }
        .topbar-badge { background: rgba(198,12,48,0.1); color: var(--red); font-size: 0.8rem; font-weight: 700; padding: 6px 14px; border-radius: 50px; }

        .content { padding: 36px; }

        .alert-success-custom { background: rgba(16,185,129,0.1); color: #065F46; padding: 14px 18px; border-radius: 12px; margin-bottom: 24px; font-weight: 500; display: flex; align-items: center; gap: 10px; }

        /* SEARCH BAR */
        .search-bar-wrap { display: flex; gap: 16px; margin-bottom: 24px; align-items: center; }
        .search-input { flex: 1; padding: 12px 16px 12px 44px; border: 2px solid #E5E7EB; border-radius: 12px; font-size: 0.95rem; font-family: inherit; transition: 0.3s; background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%239CA3AF' viewBox='0 0 16 16'%3E%3Cpath d='M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z'/%3E%3C/svg%3E") no-repeat 14px center; }
        .search-input:focus { border-color: var(--red); box-shadow: 0 0 0 4px rgba(198,12,48,0.1); outline: none; }
        .filter-select { padding: 12px 16px; border: 2px solid #E5E7EB; border-radius: 12px; font-size: 0.9rem; font-family: inherit; cursor: pointer; background: #fff; min-width: 180px; transition: 0.3s; }
        .filter-select:focus { border-color: var(--red); box-shadow: 0 0 0 4px rgba(198,12,48,0.1); outline: none; }

        /* TABLE */
        .table-card { background: var(--card-bg); border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.04); overflow: hidden; border: 1px solid rgba(0,0,0,0.03); }
        .table-card table { width: 100%; border-collapse: collapse; }
        .table-card th { padding: 14px 20px; color: var(--muted); font-weight: 600; font-size: 0.78rem; letter-spacing: 0.5px; text-transform: uppercase; background: #FAFBFC; border-bottom: 1px solid #F1F5F9; text-align: left; }
        .table-card td { padding: 16px 20px; border-bottom: 1px solid #F8FAFC; vertical-align: middle; }
        .table-card tr:last-child td { border-bottom: none; }
        .table-card tr:hover td { background: #FAFBFF; }

        .event-name-cell { font-weight: 600; color: var(--text); text-decoration: none; font-size: 0.9rem; display: block; }
        .event-name-cell:hover { color: var(--red); }
        .event-by { font-size: 0.78rem; color: var(--muted); margin-top: 2px; }

        .status-badge { padding: 5px 12px; border-radius: 50px; font-size: 0.75rem; font-weight: 700; display: inline-flex; align-items: center; gap: 5px; }
        .status-approved { background: rgba(16,185,129,0.1); color: #10B981; }
        .status-rejected { background: rgba(239,68,68,0.1); color: #EF4444; }
        .status-pending { background: rgba(245,158,11,0.1); color: #F59E0B; }

        .action-btns { display: flex; gap: 6px; flex-wrap: wrap; }
        .btn-action { width: 32px; height: 32px; border-radius: 8px; border: none; display: inline-flex; align-items: center; justify-content: center; cursor: pointer; transition: 0.2s; color: #fff; text-decoration: none; font-size: 12px; }
        .btn-action:hover { transform: translateY(-2px); color: #fff; opacity: 0.9; }
        .btn-view { background: #3B82F6; }
        .btn-edit { background: #F59E0B; }
        .btn-delete { background: #EF4444; }
        .btn-accept { background: #10B981; }
        .btn-reject { background: #6B7280; }

        .empty-state { text-align: center; padding: 80px 20px; color: #94A3B8; }
        .empty-state i { font-size: 3rem; margin-bottom: 16px; opacity: 0.5; display: block; }
    </style>
</head>
<body>
    <aside class="sidebar">
        <div class="sidebar-header">
            <div class="sidebar-logo"><i class="fa-solid fa-calendar-check"></i>TelEVent</div>
            <div class="sidebar-role">Admin Panel</div>
        </div>
        <nav class="sidebar-nav">
            <div class="nav-section-label">Menu Utama</div>
            <a href="{{ route('admin.dashboard') }}" class="nav-link"><i class="fa-solid fa-chart-pie"></i> Dashboard</a>
            <a href="{{ route('admin.events.index') }}" class="nav-link active"><i class="fa-solid fa-calendar-days"></i> Kelola Acara</a>
            <div class="nav-section-label">Navigasi</div>
            <a href="{{ route('user.home') }}" class="nav-link"><i class="fa-solid fa-house"></i> Beranda User</a>
            <a href="{{ route('events.index') }}" class="nav-link"><i class="fa-solid fa-globe"></i> Direktori Acara</a>
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
                <button type="submit" class="btn-logout"><i class="fa-solid fa-right-from-bracket"></i> Keluar</button>
            </form>
        </div>
    </aside>

    <div class="main-wrap">
        <div class="topbar">
            <div class="topbar-title">Kelola Acara</div>
            <span class="topbar-badge"><i class="fa-solid fa-shield me-1"></i>Admin</span>
        </div>

        <div class="content">
            @if(session('success'))
            <div class="alert-success-custom"><i class="fa-solid fa-check-circle"></i> {{ session('success') }}</div>
            @endif

            <!-- SEARCH & FILTER -->
            <div class="search-bar-wrap">
                <input type="text" id="searchInput" class="search-input" placeholder="Cari nama acara atau penyelenggara...">
                <select id="statusFilter" class="filter-select">
                    <option value="all">Semua Status</option>
                    <option value="pending">Menunggu</option>
                    <option value="approved">Disetujui</option>
                    <option value="rejected">Ditolak</option>
                </select>
            </div>

            <div class="table-card">
                @if(isset($events) && count($events) > 0)
                <table id="eventsTable">
                    <thead>
                        <tr>
                            <th>Judul Acara</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($events as $event)
                        <tr data-status="{{ $event->status }}" data-title="{{ strtolower($event->title) }}" data-user="{{ strtolower($event->user->name ?? '') }}">
                            <td>
                                <a href="{{ route('events.show', $event->id) }}" class="event-name-cell">{{ Str::limit($event->title, 50) }}</a>
                                <div class="event-by"><i class="fa-solid fa-user fa-xs me-1"></i>{{ $event->user->name ?? 'User' }}</div>
                            </td>
                            <td style="font-size:0.85rem; color:var(--muted);">
                                {{ $event->start_date ? \Carbon\Carbon::parse($event->start_date)->format('d M Y') : '-' }}
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
                                    <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST" style="display:inline" onsubmit="return confirm('Hapus acara ini secara permanen?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn-action btn-delete" title="Hapus"><i class="fa-solid fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="empty-state">
                    <i class="fa-solid fa-calendar-xmark"></i>
                    <p style="font-weight:600; margin:0;">Belum ada acara yang terdaftar.</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        const searchInput = document.getElementById('searchInput');
        const statusFilter = document.getElementById('statusFilter');
        function filter() {
            const term = searchInput.value.toLowerCase();
            const status = statusFilter.value;
            document.querySelectorAll('#eventsTable tbody tr').forEach(row => {
                const matchSearch = row.dataset.title.includes(term) || row.dataset.user.includes(term);
                const matchStatus = status === 'all' || row.dataset.status === status;
                row.style.display = (matchSearch && matchStatus) ? '' : 'none';
            });
        }
        searchInput.addEventListener('input', filter);
        statusFilter.addEventListener('change', filter);
    </script>
</body>
</html>
