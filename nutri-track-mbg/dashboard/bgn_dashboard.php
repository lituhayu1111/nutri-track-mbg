<?php
/**
 * DASHBOARD BGN (Badan Gizi Nasional)
 */

session_start();

// Cek login
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'bgn') {
    header('Location: ../index.php');
    exit();
}

$name = $_SESSION['name'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard BGN - Nutri Track MBG</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Cambria', 'Segoe UI', sans-serif;
            background: #f5f5f5;
        }
        
        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .navbar-brand {
            font-size: 20px;
            font-weight: bold;
            font-family: 'Cambria', serif;
        }
        
        .navbar-user {
            display: flex;
            gap: 20px;
            align-items: center;
        }
        
        .user-info {
            text-align: right;
        }
        
        .user-info .role {
            font-size: 12px;
            opacity: 0.8;
        }
        
        .container {
            display: flex;
            min-height: calc(100vh - 60px);
        }
        
        .sidebar {
            width: 250px;
            background: white;
            border-right: 1px solid #e0e0e0;
            padding: 20px 0;
        }
        
        .menu-item {
            padding: 12px 20px;
            border-left: 3px solid transparent;
            cursor: pointer;
            transition: all 0.3s ease;
            color: #555;
        }
        
        .menu-item:hover {
            background: #f5f5f5;
            border-left-color: #667eea;
            color: #667eea;
        }
        
        .menu-item.active {
            background: #f5f5f5;
            border-left-color: #667eea;
            color: #667eea;
            font-weight: 600;
        }
        
        .main-content {
            flex: 1;
            padding: 30px;
            overflow-y: auto;
        }
        
        .page-title {
            font-size: 28px;
            color: #333;
            margin-bottom: 30px;
            font-family: 'Cambria', serif;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            border-left: 4px solid #667eea;
        }
        
        .stat-number {
            font-size: 32px;
            font-weight: bold;
            color: #667eea;
            margin-bottom: 5px;
        }
        
        .stat-label {
            color: #999;
            font-size: 14px;
        }
        
        .content-section {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 20px;
        }
        
        .section-title {
            font-size: 18px;
            font-weight: 600;
            color: #333;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #f0f0f0;
        }
        
        .menu-list {
            list-style: none;
        }
        
        .menu-list li {
            padding: 10px 0;
            border-bottom: 1px solid #f0f0f0;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .menu-list li:hover {
            padding-left: 10px;
            color: #667eea;
        }
        
        .menu-list li:last-child {
            border-bottom: none;
        }
        
        .badge {
            display: inline-block;
            background: #667eea;
            color: white;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 12px;
            margin-left: 10px;
        }
        
        .logout-btn {
            background: #ff6b6b;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .logout-btn:hover {
            background: #ff5252;
        }
        
        .highlight {
            background: #fffbea;
            border-left: 4px solid #ffc107;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div class="navbar-brand">🥗 Nutri Track MBG</div>
        <div class="navbar-user">
            <div class="user-info">
                <div>👤 <?php echo htmlspecialchars($name); ?></div>
                <div class="role">Badan Gizi Nasional</div>
            </div>
            <a href="../api/logout.php"><button class="logout-btn">🚪 Logout</button></a>
        </div>
    </div>
    
    <div class="container">
        <div class="sidebar">
            <div class="menu-item active">📊 Dashboard</div>
            <div class="menu-item">✅ Validasi SPPG <span class="badge">2</span></div>
            <div class="menu-item">✅ Validasi Sekolah</div>
            <div class="menu-item">🍽️ Database Nutrisi</div>
            <div class="menu-item">📋 Laporan Nasional</div>
            <div class="menu-item">⚙️ Set Standar Gizi</div>
            <div class="menu-item">🔔 Alerts & Notifikasi</div>
            <div class="menu-item">👥 User Management</div>
            <div class="menu-item">👤 Profil & Settings</div>
        </div>
        
        <div class="main-content">
            <div class="page-title">📊 Dashboard Monitoring BGN</div>
            
            <div class="highlight">
                <strong>✨ Selamat datang kembali!</strong> Semua sistem berjalan normal. Compliance rate nasional mencapai 92%.
            </div>
            
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number">3</div>
                    <div class="stat-label">Sekolah Terdaftar</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">150</div>
                    <div class="stat-label">Total Siswa Penerima</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">5</div>
                    <div class="stat-label">SPPG Aktif</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">92%</div>
                    <div class="stat-label">Compliance Rate</div>
                </div>
            </div>
            
            <div class="content-section">
                <div class="section-title">📋 Menu Utama</div>
                <ul class="menu-list">
                    <li>📊 <strong>Dashboard Monitoring</strong> - Real-time graph compliance per sekolah</li>
                    <li>✅ <strong>Validasi SPPG</strong> - Approve/reject SPPG baru <span class="badge">2 Pending</span></li>
                    <li>✅ <strong>Validasi Sekolah</strong> - Approve/reject sekolah baru</li>
                    <li>🍽️ <strong>Database Nutrisi</strong> - 500+ items makanan & minuman</li>
                    <li>📋 <strong>Laporan Nasional</strong> - Export compliance report</li>
                    <li>⚙️ <strong>Set Standar Gizi</strong> - Tentukan standar kalori, protein, dll</li>
                    <li>🔔 <strong>Alerts & Notifikasi</strong> - Real-time alerts untuk non-compliance</li>
                    <li>👥 <strong>User Management</strong> - Manage semua user di sistem</li>
                    <li>👤 <strong>Profil & Settings</strong> - Edit profil & preferensi</li>
                </ul>
            </div>
            
            <div class="content-section">
                <div class="section-title">🎯 Quick Actions</div>
                <ul class="menu-list">
                    <li>🔍 Review SPPG yang pending approval (2 items)</li>
                    <li>📊 Lihat compliance trend nasional</li>
                    <li>⚠️ Cek alert dari sekolah non-compliant</li>
                    <li>📧 Kirim notifikasi ke SPPG</li>
                </ul>
            </div>
            
            <div class="content-section">
                <div class="section-title">ℹ️ Informasi Sistem</div>
                <p style="color: #666; line-height: 1.6;">
                    <strong>Nutri Track MBG</strong> adalah sistem terintegrasi untuk monitoring gizi program Makan Bergizi Gratis.<br><br>
                    <strong>Peran Anda (BGN):</strong><br>
                    • Monitoring real-time compliance gizi nasional<br>
                    • Validasi SPPG & sekolah baru<br>
                    • Set standar gizi nasional<br>
                    • Generate laporan & insights<br>
                    • Alert management<br><br>
                    <strong>📚 Dokumentasi:</strong> Lihat README.md, SETUP.md, dan USAGE.md untuk panduan lengkap.
                </p>
            </div>
        </div>
    </div>
</body>
</html>