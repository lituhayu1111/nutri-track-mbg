<?php
/**
 * DASHBOARD SPPG (Satuan Pelayanan Pemenuhan Gizi)
 */

session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'sppg') {
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
    <title>Dashboard SPPG - Nutri Track MBG</title>
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
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
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
            border-left-color: #00f2fe;
            color: #00f2fe;
        }
        
        .menu-item.active {
            background: #f5f5f5;
            border-left-color: #00f2fe;
            color: #00f2fe;
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
        
        .quick-status {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
            margin-bottom: 30px;
        }
        
        .status-box {
            background: white;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            border-left: 4px solid #00f2fe;
        }
        
        .status-label {
            color: #999;
            font-size: 12px;
        }
        
        .status-value {
            font-size: 20px;
            font-weight: bold;
            color: #333;
            margin-top: 5px;
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
            padding: 12px 0;
            border-bottom: 1px solid #f0f0f0;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .menu-list li:hover {
            padding-left: 10px;
            color: #00f2fe;
        }
        
        .menu-list li:last-child {
            border-bottom: none;
        }
        
        .menu-list strong {
            color: #333;
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
            background: #e1f5ff;
            border-left: 4px solid #00f2fe;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 15px;
        }
        
        .action-btn {
            background: #4facfe;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 15px;
            transition: all 0.3s ease;
        }
        
        .action-btn:hover {
            background: #00f2fe;
            transform: translateY(-2px);
        }
        
        .clickable {
            text-decoration: none;
            color: inherit;
        }
        
        .clickable:hover {
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div class="navbar-brand">🥗 Nutri Track MBG</div>
        <div class="navbar-user">
            <div class="user-info">
                <div>👤 <?php echo htmlspecialchars($name); ?></div>
                <div class="role">Satuan Pelayanan Pemenuhan Gizi</div>
            </div>
            <a href="../api/logout.php"><button class="logout-btn">🚪 Logout</button></a>
        </div>
    </div>
    
    <div class="container">
        <div class="sidebar">
    <div class="menu-item active">📊 Dashboard</div>
    <a href="../pages/input_menu.php" class="clickable">
        <div class="menu-item">🍽️ Input Menu Harian</div>
    </a>
    <a href="../pages/database_nutrisi.php" class="clickable">
        <div class="menu-item">🥗 Database Nutrisi</div>
    </a>
    <a href="../pages/laporan_harian.php" class="clickable">
        <div class="menu-item">📈 Laporan Harian</div>
    </a>
    <div class="menu-item">🏫 Manajemen Sekolah</div>
    <div class="menu-item">📊 Analytics</div>
    <div class="menu-item">📋 Laporan Bulanan</div>
    <div class="menu-item">📝 Template Menu</div>
    <div class="menu-item">💬 Komunikasi Sekolah</div>
</div>
        
        <div class="main-content">
            <div class="page-title">🍽️ Dashboard SPPG</div>
            
            <div class="highlight">
                <strong>⏰ Status Hari Ini</strong> Menu harus di-input SEBELUM jam 07:00 pagi. Pastikan semua nutrisi memenuhi standar!
            </div>
            
            <div class="quick-status">
                <div class="status-box">
                    <div class="status-label">Sekolah Terkait</div>
                    <div class="status-value">3</div>
                </div>
                <div class="status-box">
                    <div class="status-label">Total Siswa</div>
                    <div class="status-value">150</div>
                </div>
                <div class="status-box">
                    <div class="status-label">Menu Hari Ini</div>
                    <div class="status-value">✅ SUDAH</div>
                </div>
                <div class="status-box">
                    <div class="status-label">Compliance</div>
                    <div class="status-value">92%</div>
                </div>
            </div>
            
            <div class="content-section">
                <div class="section-title">🌟 Fitur Utama SPPG</div>
                <ul class="menu-list">
                    <li onclick="window.location.href='../pages/input_menu.php'" style="cursor: pointer;">
                        🍽️ <strong>Input Menu Harian</strong> - Input menu pagi, siang, sore SETIAP HARI
                        <br><small style="color: #999;">⏰ Deadline: Jam 07:00 pagi untuk menu hari itu</small>
                        <button class="action-btn">📝 Input Menu Sekarang</button>
                    </li>
                    <li onclick="window.location.href='../pages/database_nutrisi.php'" style="cursor: pointer; margin-top: 15px;">
                        🥗 <strong>Database Nutrisi</strong> - 500+ item makanan dengan info lengkap
                        <br><small style="color: #999;">Kalori, protein, lemak, vitamin, mineral per 100g</small>
                    </li>
                    <li style="margin-top: 15px;">
                        🏫 <strong>Manajemen Sekolah</strong> - Lihat data sekolah yang ditangani
                        <br><small style="color: #999;">Kontak sekolah, jumlah siswa, compliance status</small>
                    </li>
                    <li style="margin-top: 15px;">
                        📈 <strong>Tracking Compliance</strong> - Monitor compliance gizi harian
                        <br><small style="color: #999;">Graph 7 hari terakhir, analisis kekurangan nutrisi</small>
                    </li>
                    <li style="margin-top: 15px;">
                        📋 <strong>Laporan Bulanan</strong> - Export laporan gizi ke BGN
                        <br><small style="color: #999;">PDF/Excel dengan summary nutrisi & compliance</small>
                    </li>
                </ul>
            </div>
            
            <div class="content-section">
                <div class="section-title">📋 Checklist Input Menu Harian</div>
                <ul class="menu-list">
                    <li>☑️ Pilih sekolah & tanggal</li>
                    <li>☑️ Input Sarapan (minimum 300 kcal)</li>
                    <li>☑️ Input Makan Siang (minimum 500 kcal)</li>
                    <li>☑️ Input Camilan (optional, 100-200 kcal)</li>
                    <li>☑️ Input Makan Sore (optional, 200-300 kcal)</li>
                    <li>☑️ Verifikasi Total Nutrisi (kalori, protein, vitamin)</li>
                    <li>☑️ Klik SIMPAN MENU</li>
                    <li>☑️ Sistem akan otomatis kirim ke sekolah & orang tua</li>
                </ul>
            </div>
            
            <div class="content-section">
                <div class="section-title">⚠️ Standar Gizi Nasional</div>
                <p style="color: #666; line-height: 1.8;">
                    <strong>Kebutuhan Harian Per Siswa:</strong><br>
                    • <strong>Kalori:</strong> 1,300 - 1,500 kcal<br>
                    • <strong>Protein:</strong> minimum 40g (lebih baik 50-60g)<br>
                    • <strong>Lemak:</strong> 35 - 45g<br>
                    • <strong>Karbohidrat:</strong> 160 - 200g<br>
                    • <strong>Serat:</strong> minimum 10g<br>
                    • <strong>Vitamin C:</strong> minimum 50mg<br>
                    • <strong>Kalsium:</strong> minimum 400mg<br>
                    • <strong>Zat Besi:</strong> minimum 10mg<br><br>
                    <strong>🎯 Target Compliance:</strong> Minimal 90% setiap minggu
                </p>
            </div>
        </div>
    </div>
</body>
</html>