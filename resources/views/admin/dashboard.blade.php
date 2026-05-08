<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        /* --- STYLE GLOBAL & SIDEBAR (TETAP SAMA) --- */
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; padding: 0; background-color: #f4f7fc; color: #333; }
        .sidebar { background: linear-gradient(135deg, #800000, #b30000); color: white; width: 250px; height: 100vh; position: fixed; top: 0; left: 0; padding: 20px; box-shadow: 2px 0 5px rgba(0,0,0,0.1); z-index: 100; }
        .sidebar .avatar { text-align: center; margin-bottom: 30px; }
        .sidebar .avatar img { width: 80px; height: 80px; border-radius: 50%; border: 3px solid rgba(255,255,255,0.3); }
        .sidebar ul { list-style: none; padding: 0; }
        .sidebar ul li { margin: 15px 0; }
        .sidebar ul li a { color: rgba(255,255,255,0.8); text-decoration: none; font-size: 16px; display: block; padding: 10px 15px; border-radius: 5px; transition: all 0.3s; }
        .sidebar ul li a:hover, .sidebar ul li a.active { color: #fff; background-color: rgba(255,255,255,0.1); transform: translateX(5px); }
        .sidebar-footer { position: absolute; bottom: 20px; left: 20px; font-size: 14px; color: rgba(255,255,255,0.6); }
        
        /* Main Content */
        .main-content { margin-left: 290px; padding: 40px; }
        .search-bar { width: 100%; padding: 15px; font-size: 16px; border-radius: 8px; border: 1px solid #e0e0e0; background-color: white; margin-bottom: 40px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); box-sizing: border-box; }
        .section-title { font-size: 20px; font-weight: 600; color: #444; margin-bottom: 20px; margin-top: 30px; border-left: 5px solid #800000; padding-left: 15px; }

        /* Cards Styles (Updated Cursor & Hover) */
        .cards { display: flex; gap: 30px; margin-bottom: 20px; }
        .card {
            background: #fff; border-radius: 12px; padding: 25px; flex: 1; display: flex; align-items: center; justify-content: space-between;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05); transition: transform 0.3s ease-in-out; border-left: 5px solid transparent;
            cursor: pointer; /* Menandakan bisa diklik */
        }
        .card:hover { transform: translateY(-5px); box-shadow: 0 8px 20px rgba(0,0,0,0.1); }
        .card.success { border-left-color: #28a745; }
        .card.warning { border-left-color: #ffc107; }
        
        .card-content { text-align: left; }
        .card .title { font-size: 14px; color: #888; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 5px; }
        .card .count { font-size: 32px; font-weight: bold; color: #333; }
        .card .icon { font-size: 40px; opacity: 0.3; }

        /* Recent Files & List Styles */
        .recent-files ul { list-style: none; padding: 0; }
        .recent-files ul li { background-color: #fff; border-radius: 10px; padding: 20px; margin-bottom: 15px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.03); display: flex; align-items: center; transition: 0.2s; }
        .recent-files ul li:hover { background-color: #fcfcfc; border-left: 5px solid #800000; }
        .recent-files ul li a.file-link { text-decoration: none; color: #333; font-size: 16px; font-weight: 500; flex-grow: 1; margin-left: 15px; }
        
        .file-icon { color: #800000; font-size: 22px; background: #ffe6e6; border-radius: 50%; width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; margin-right: 15px; }
        .file-date { font-size: 12px; color: #999; min-width: 80px; text-align: right; }

        /* Button Actions */
        .action-buttons { display: flex; gap: 10px; margin-right: 20px; }
        .btn-action { width: 35px; height: 35px; border-radius: 50%; border: none; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s; color: white; text-decoration: none; font-size: 14px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .btn-action:hover { transform: scale(1.1); opacity: 0.9; box-shadow: 0 4px 8px rgba(0,0,0,0.15); }
        .btn-view { background-color: #17a2b8; }
        .btn-accept { background-color: #28a745; }
        .btn-reject { background-color: #dc3545; }

        /* --- MODAL STYLES (BARU) --- */
        .modal-overlay {
            display: none; /* Hidden by default */
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background-color: rgba(0,0,0,0.5); z-index: 1000;
            justify-content: center; align-items: center;
        }
        .modal-content {
            background-color: #fff; width: 600px; max-height: 80vh;
            border-radius: 12px; padding: 30px; overflow-y: auto;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            position: relative; animation: slideDown 0.3s ease;
        }
        @keyframes slideDown { from { transform: translateY(-20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
        .modal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 2px solid #f0f0f0; padding-bottom: 15px; }
        .modal-title { font-size: 20px; font-weight: bold; color: #800000; }
        .close-btn { background: none; border: none; font-size: 24px; color: #888; cursor: pointer; transition: 0.2s; }
        .close-btn:hover { color: #d33; }
        
        /* Modal List Item Styles */
        .modal-list-item { display: flex; align-items: center; padding: 15px; border-bottom: 1px solid #eee; transition: 0.2s; }
        .modal-list-item:hover { background-color: #f9f9f9; }
        .status-badge { padding: 5px 10px; border-radius: 20px; font-size: 11px; font-weight: bold; color: white; text-transform: uppercase; margin-left: auto; }
        .status-approved { background-color: #28a745; }
        .status-rejected { background-color: #dc3545; }
        .status-pending { background-color: #ffc107; color: #333; }

    </style>
</head>
<body>
    <div class="sidebar">
        <div class="avatar">
            <img src="https://ui-avatars.com/api/?name=Admin&background=random" alt="Admin Avatar"> 
        </div>
        <ul>
            <li><a href="{{ route('user.home') }}"><i class="fas fa-arrow-left"></i> &nbsp; Beranda Utama</a></li>
            <li><a href="{{ route('admin.dashboard') }}" class="active"><i class="fas fa-tachometer-alt"></i> &nbsp; Beranda Admin</a></li>
            <li><a href="{{ route('admin.events.index') }}"><i class="fas fa-calendar-alt"></i> &nbsp; Kelola Acara</a></li>
            
        </ul>
        <div class="sidebar-footer">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" style="background:none; border:none; color:white; cursor:pointer;">
                    <i class="fas fa-sign-out-alt"></i> Keluar
                </button>
            </form>
        </div>
    </div>

    <div class="main-content">
        <input type="text" class="search-bar" placeholder="Cari acara atau dokumen...">
        
        <h2 class="section-title">Status Acara</h2>

        <div class="cards">
            <div class="card success" onclick="openModal('modal-reviewed')">
                <div class="card-content">
                    <div class="title">Sudah ditinjau</div>
                    <div class="count">{{ $sudahReview ?? 0 }}</div>
                    <small style="color: #28a745; font-size: 12px;">Klik untuk selengkapnya</small>
                </div>
                <div class="icon" style="color: #28a745;">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>

            <div class="card warning" onclick="openModal('modal-pending')">
                <div class="card-content">
                    <div class="title">Menunggu ditinjau</div>
                    <div class="count">{{ $menungguReview ?? 0 }}</div>
                    <small style="color: #e0a800; font-size: 12px;">Klik untuk selengkapnya</small>
                </div>
                <div class="icon" style="color: #ffc107;">
                    <i class="fas fa-hourglass-half"></i>
                </div>
            </div>
        </div>

        <h2 class="section-title">Baru saja dibuka</h2>

        <div class="recent-files">
            @if(isset($recentEvents) && count($recentEvents) > 0)
                <ul>
                    @foreach($recentEvents as $event)
                    <li>
                        <div class="file-icon">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <a href="{{ route('events.show', $event->id) }}" class="file-link">
                            {{ $event->title }} 
                            <span style="display:block; font-size:12px; color:#888; font-weight:normal;">
                                Diajukan oleh: {{ $event->user->name ?? 'User' }}
                            </span>
                        </a>
                        <div class="action-buttons">
                            <a href="{{ route('events.show', $event->id) }}" class="btn-action btn-view" title="Lihat Detail"><i class="fas fa-eye"></i></a>
                            
                            <form action="{{ route('admin.event.status', ['id' => $event->id, 'status' => 'approved']) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn-action btn-accept" title="Terima Proposal"><i class="fas fa-check"></i></button>
                            </form>
                            
                            <form action="{{ route('admin.event.status', ['id' => $event->id, 'status' => 'rejected']) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn-action btn-reject" title="Tolak Proposal"><i class="fas fa-times"></i></button>
                            </form>
                        </div>
                        <span class="file-date">{{ $event->created_at->diffForHumans() }}</span>
                    </li>
                    @endforeach
                </ul>
            @else
                <p style="color: #888; font-style: italic;">Belum ada acara yang diajukan.</p>
            @endif
        </div>
    </div>

    <div id="modal-reviewed" class="modal-overlay" onclick="closeModal(event, 'modal-reviewed')">
        <div class="modal-content" onclick="event.stopPropagation()">
            <div class="modal-header">
                <span class="modal-title"><i class="fas fa-check-circle" style="color: #28a745;"></i> List Acara yang Sudah Ditinjau</span>
                <button class="close-btn" onclick="closeModal(null, 'modal-reviewed')">&times;</button>
            </div>
            
            @if(isset($reviewedEvents) && count($reviewedEvents) > 0)
                @foreach($reviewedEvents as $item)
                <div class="modal-list-item">
                    <div style="flex-grow: 1;">
                        <a href="{{ route('events.show', $item->id) }}" style="text-decoration: none; color: #333; font-weight: 600;">
                            {{ $item->title }}
                        </a>
                        <div style="font-size: 12px; color: #888;">Oleh: {{ $item->user->name ?? 'User' }}</div>
                    </div>
                    
                    @if($item->status == 'approved')
                        <span class="status-badge status-approved">Disetujui</span>
                    @else
                        <span class="status-badge status-rejected">Ditolak</span>
                    @endif
                    
                    <a href="{{ route('events.show', $item->id) }}" class="btn-action btn-view" style="margin-left: 10px; width: 30px; height: 30px; font-size: 12px;">
                        <i class="fas fa-eye"></i>
                    </a>
                </div>
                @endforeach
            @else
                <p style="text-align:center; color:#999; padding: 20px;">Belum ada acara yang ditinjau.</p>
            @endif
        </div>
    </div>

    <div id="modal-pending" class="modal-overlay" onclick="closeModal(event, 'modal-pending')">
        <div class="modal-content" onclick="event.stopPropagation()">
            <div class="modal-header">
                <span class="modal-title"><i class="fas fa-hourglass-half" style="color: #ffc107;"></i> Menunggu Tinjauan</span>
                <button class="close-btn" onclick="closeModal(null, 'modal-pending')">&times;</button>
            </div>

            @if(isset($pendingEvents) && count($pendingEvents) > 0)
                @foreach($pendingEvents as $item)
                <div class="modal-list-item">
                    <div style="flex-grow: 1;">
                        <a href="{{ route('events.show', $item->id) }}" style="text-decoration: none; color: #333; font-weight: 600;">
                            {{ $item->title }}
                        </a>
                        <div style="font-size: 12px; color: #888;">Oleh: {{ $item->user->name ?? 'User' }}</div>
                    </div>
                    <span class="status-badge status-pending">Tertunda</span>
                    
                    <a href="{{ route('events.show', $item->id) }}" class="btn-action btn-view" style="margin-left: 10px; width: 30px; height: 30px; font-size: 12px;">
                        <i class="fas fa-eye"></i>
                    </a>
                </div>
                @endforeach
            @else
                <p style="text-align:center; color:#999; padding: 20px;">Tidak ada acara menunggu tinjauan.</p>
            @endif
        </div>
    </div>

    <script>
        function openModal(modalId) {
            document.getElementById(modalId).style.display = 'flex';
        }

        function closeModal(event, modalId) {
            // Cek jika event null (dari tombol X) atau target klik adalah overlay (background)
            if (!event || event.target.id === modalId) {
                document.getElementById(modalId).style.display = 'none';
            }
        }
    </script>
</body>
</html>