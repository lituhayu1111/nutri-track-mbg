<?php
/**
 * DASHBOARD KEMENSKES (Kementerian Kesehatan)
 */

session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'kemenskes') {
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
    <title>Dashboard Kemenskes - Nutri Track MBG</title>
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
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
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
            border-left-color: #f5576c;
            color: #f5576c;
        }
        
        .menu-item.active {
            background: #f5f5f5;
            border-left-color: #f5576c;
            color: #f5576c;
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
            border-left: 4px solid #f5576c;
        }
        
        .stat-number {
            font-size: 32px;
            font-weight: bold;
            color: #f5576c;
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
            color: #f5576c;
        }
        
        .menu-list li:last-child {
            border-bottom: none;
        }
        
        .badge {
            display: inline-block;
            background: #f5576c;
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
                <div class="role">Kementerian Kesehatan RI</div>
            </div>
            <a href="../api/logout.php"><button class="logout-btn">🚪 Logout</button></a>
        </div>
    </div>
    
    <div class="container">
        <div class="sidebar">
            <div class="menu-item active">📊 Dashboard</div>
            <div class="menu-item">✅ Validasi Sekolah <span class="badge">1</span></div>
            <div class="menu-item">📈 Monitoring Compliance</div>
            <div class="menu-item">🍽️ Database Nutrisi</div>
            <div class="menu-item">📋 Audit Trail</div>
            <div class="menu-item">🤝 Koordinasi BGN</div>
            <div class="menu-item">💬 Support & FAQ</div>
            <div class="menu-item">📊 Laporan Kesehatan</div>
            <div class="menu-item">👤 Profil & Settings</div>
        </div>
        
        <div class="main-content">
            <div class="page-title">📊 Dashboard Kemenskes</div>
            
            <div class="highlight">
                <strong>✨ Status Program MBG</strong> Berjalan dengan baik. Ada 1 sekolah baru menunggu validasi.
            </div>
            
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number">3</div>
                    <div class="stat-label">Sekolah Aktif</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">150</div>
                    <div class="stat-label">Siswa Terpenuhi</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">95%</div>
                    <div class="stat-label">Compliance Rate</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">5</div>
                    <div class="stat-label">SPPG Partner</div>
                </div>
            </div>
            
            <div class="content-section">
                <div class="section-title">📋 Menu Utama</div>
                <ul class="menu-list">
                    <li>📊 <strong>Dashboard Overview</strong> - Monitoring compliance sekolah</li>
                    <li>✅ <strong>Validasi Sekolah</strong> - Review & approve sekolah baru <span class="badge">1 Pending</span></li>
                    <li>📈 <strong>Monitoring Compliance</strong> - Track nutrisi per sekolah</li>
                    <li>🍽️ <strong>Database Nutrisi</strong> - Akses database nutrisi lengkap</li>
                    <li>📋 <strong>Audit Trail</strong> - Lihat history semua perubahan sistem</li>
                    <li>🤝 <strong>Koordinasi BGN</strong> - Chat & share informasi dengan BGN</li>
                    <li>💬 <strong>Support & FAQ</strong> - Jawab pertanyaan dari sekolah</li>
                    <li>📊 <strong>Laporan Kesehatan</strong> - Export laporan gizi per region</li>
                    <li>👤 <strong>Profil & Settings</strong> - Manage profil & preferensi</li>
                </ul>
            </div>
            
            <div class="content-section">
                <div class="section-title">🎯 Pending Tasks</div>
                <ul class="menu-list">
                    <li>✅ Validasi SDN Mekar Jaya 04 (Tunggu dokumen)</li>
                    <li>📞 Follow-up dengan SPPG Jakarta tentang compliance</li>
                    <li>📊 Review laporan bulanan April 2026</li>
                </ul>
            </div>
            
            <div class="content-section">
                <div class="section-title">ℹ️ Peran Kemenskes dalam Sistem</div>
                <p style="color: #666; line-height: 1.6;">
                    Sebagai Kementerian Kesehatan RI, tanggung jawab Anda dalam sistem ini adalah:<br><br>
                    • Melakukan oversight program MBG secara keseluruhan<br>
                    • Validasi sekolah penerima program<br>
                    • Monitoring compliance nutrisi berkala<br>
                    • Audit trail & accountability<br>
                    • Support & troubleshooting untuk stakeholder<br>
                    • Koordinasi dengan BGN untuk policy<br><br>
                    <strong>Kunci Sukses:</strong> Pastikan setiap hari ada monitoring compliance dan response cepat terhadap sekolah non-compliant.
                </p>
            </div>
        </div>
    </div>
</body>
</html>