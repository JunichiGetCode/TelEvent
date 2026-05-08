<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Acara - Admin TelEVent</title>
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

        .form-card { background: var(--card-bg); border-radius: 20px; padding: 30px; box-shadow: 0 4px 20px rgba(0,0,0,0.04); border: 1px solid rgba(0,0,0,0.03); max-width: 1000px; }
        .section-title { font-size: 1rem; font-weight: 800; color: var(--text); margin-bottom: 20px; padding-bottom: 10px; border-bottom: 1px solid #F1F5F9; display: flex; align-items: center; gap: 10px; }
        .section-title i { color: var(--red); }

        .form-group { margin-bottom: 20px; }
        .form-label { display: block; font-weight: 600; margin-bottom: 8px; color: #374151; font-size: 0.875rem; }
        .form-control, .form-select { width: 100%; padding: 12px 16px; border: 2px solid #E5E7EB; border-radius: 12px; font-size: 0.95rem; font-family: inherit; transition: 0.3s; background: #fff; }
        .form-control:focus, .form-select:focus { border-color: var(--red); box-shadow: 0 0 0 4px rgba(198,12,48,0.1); outline: none; }
        
        .form-row { display: flex; gap: 24px; flex-wrap: wrap; }
        .form-col { flex: 1; min-width: 300px; }

        .current-file { display: inline-flex; align-items: center; gap: 8px; font-size: 0.85rem; color: #3B82F6; margin-top: 8px; text-decoration: none; font-weight: 600; }
        .current-file:hover { text-decoration: underline; }

        .btn-submit { background: linear-gradient(135deg, var(--red), var(--red-dark)); color: #fff; border: none; padding: 12px 30px; border-radius: 10px; font-weight: 700; cursor: pointer; transition: 0.3s; font-size: 0.9rem; font-family: inherit; display: inline-flex; align-items: center; gap: 8px; }
        .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 4px 15px rgba(198,12,48,0.3); }
        .btn-cancel { background: #F1F5F9; color: #4B5563; border: none; padding: 12px 24px; border-radius: 10px; font-weight: 600; cursor: pointer; transition: 0.3s; font-size: 0.9rem; font-family: inherit; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; }
        .btn-cancel:hover { background: #E5E7EB; }

        .alert-danger-custom { background: rgba(239,68,68,0.1); color: #991B1B; padding: 16px 20px; border-radius: 12px; margin-bottom: 24px; font-weight: 500; }
        .alert-danger-custom ul { margin-top: 8px; padding-left: 20px; font-size: 0.9rem; }
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
            <div class="topbar-title">Edit Acara</div>
            <span class="topbar-badge"><i class="fa-solid fa-shield me-1"></i>Admin</span>
        </div>

        <div class="content">
            @if ($errors->any())
                <div class="alert-danger-custom">
                    <div style="font-weight: 700;"><i class="fa-solid fa-circle-exclamation me-2"></i> Terdapat kesalahan:</div>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="form-card">
                <form action="{{ route('admin.events.update', $event->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-row">
                        <!-- Detail Acara -->
                        <div class="form-col">
                            <div class="section-title"><i class="fa-solid fa-info-circle"></i> Detail Acara</div>
                            
                            <div class="form-group">
                                <label class="form-label">Nama Acara</label>
                                <input type="text" name="title" class="form-control" value="{{ old('title', $event->title) }}" required>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Jenis Acara</label>
                                <select name="type" class="form-select" required>
                                    <option value="Exhibition" {{ old('type', $event->type) == 'Exhibition' ? 'selected' : '' }}>Exhibition</option>
                                    <option value="Festival" {{ old('type', $event->type) == 'Festival' ? 'selected' : '' }}>Festival</option>
                                    <option value="Lomba" {{ old('type', $event->type) == 'Lomba' ? 'selected' : '' }}>Lomba</option>
                                    <option value="Seminar" {{ old('type', $event->type) == 'Seminar' ? 'selected' : '' }}>Seminar</option>
                                    <option value="Webinar" {{ old('type', $event->type) == 'Webinar' ? 'selected' : '' }}>Webinar</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Tanggal Mulai</label>
                                <input type="date" name="start_date" class="form-control" value="{{ old('start_date', $event->start_date) }}" required>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Tanggal Selesai</label>
                                <input type="date" name="end_date" class="form-control" value="{{ old('end_date', $event->end_date) }}" required>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Status Proposal</label>
                                <select name="status" class="form-select" required>
                                    <option value="pending" {{ old('status', $event->status) == 'pending' ? 'selected' : '' }}>Menunggu Review (Pending)</option>
                                    <option value="approved" {{ old('status', $event->status) == 'approved' ? 'selected' : '' }}>Disetujui (Approved)</option>
                                    <option value="rejected" {{ old('status', $event->status) == 'rejected' ? 'selected' : '' }}>Ditolak (Rejected)</option>
                                </select>
                            </div>
                        </div>

                        <!-- Dokumen -->
                        <div class="form-col">
                            <div class="section-title"><i class="fa-solid fa-folder-open"></i> Dokumen Pendukung</div>
                            <p style="font-size: 0.8rem; color: #94A3B8; margin-bottom: 15px;">Pilih file baru jika ingin mengganti dokumen yang sudah ada.</p>
                            
                            <div class="form-group">
                                <label class="form-label">File Proposal (.pdf)</label>
                                <input type="file" name="proposal" class="form-control" accept=".pdf">
                                @if($event->proposal)
                                    <a href="{{ asset('storage/' . $event->proposal) }}" target="_blank" class="current-file"><i class="fa-solid fa-file-pdf"></i> Lihat file saat ini</a>
                                @endif
                            </div>

                            <div class="form-group">
                                <label class="form-label">File Poster (.jpg, .png)</label>
                                <input type="file" name="poster" class="form-control" accept=".jpg,.jpeg,.png">
                                @if($event->poster)
                                    <a href="{{ asset('storage/' . $event->poster) }}" target="_blank" class="current-file"><i class="fa-solid fa-image"></i> Lihat poster saat ini</a>
                                @endif
                            </div>

                            <div class="form-group">
                                <label class="form-label">File Timeline (.pdf)</label>
                                <input type="file" name="timeline" class="form-control" accept=".pdf">
                                @if($event->timeline)
                                    <a href="{{ asset('storage/' . $event->timeline) }}" target="_blank" class="current-file"><i class="fa-solid fa-file-pdf"></i> Lihat file saat ini</a>
                                @endif
                            </div>

                            <div class="form-group">
                                <label class="form-label">File Budgeting (.pdf)</label>
                                <input type="file" name="budgeting" class="form-control" accept=".pdf">
                                @if($event->budgeting)
                                    <a href="{{ asset('storage/' . $event->budgeting) }}" target="_blank" class="current-file"><i class="fa-solid fa-file-pdf"></i> Lihat file saat ini</a>
                                @endif
                            </div>

                            <div class="form-group">
                                <label class="form-label">File Data Lainnya (.pdf, .jpg, .png)</label>
                                <input type="file" name="other_data" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                @if($event->other_data)
                                    <a href="{{ asset('storage/' . $event->other_data) }}" target="_blank" class="current-file"><i class="fa-solid fa-file"></i> Lihat file saat ini</a>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div style="margin-top: 30px; border-top: 1px solid #F1F5F9; padding-top: 20px; display: flex; gap: 10px;">
                        <button type="submit" class="btn-submit"><i class="fa-solid fa-save"></i> Simpan Perubahan</button>
                        <a href="{{ route('admin.events.index') }}" class="btn-cancel">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
