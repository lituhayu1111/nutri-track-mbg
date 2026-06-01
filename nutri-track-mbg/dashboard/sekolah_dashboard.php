<?php
/**
 * DASHBOARD SEKOLAH
 */

session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'sekolah') {
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
    <title>Dashboard Sekolah - Nutri Track MBG</title>
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
            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
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
            border-left-color: #fa709a;
            color: #fa709a;
        }
        
        .menu-item.active {
            background: #f5f5f5;
            border-left-color: #fa709a;
            color: #fa709a;
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
        
        .quick-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
            margin-bottom: 30px;
        }
        
        .info-box {
            background: white;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            border-left: 4px solid #fa709a;
        }
        
        .info-label {
            color: #999;
            font-size: 12px;
        }
        
        .info-value {
            font-size: 18px;
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
            color: #fa709a;
        }
        
        .menu-list li:last-child {
            border-bottom: none;
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
            background: #ffebee;
            border-left: 4px solid #fa709a;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 15px;
        }
        
        .clickable {
            text-decoration: none;
            color: inherit;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div class="navbar-brand">🥗 Nutri Track MBG</div>
        <div class="navbar-user">
            <div class="user-info">
                <div>👤 <?php echo htmlspecialchars($name); ?></div>
                <div class="role">Sekolah Penerima MBG</div>
            </div>
            <a href="../api/logout.php"><button class="logout-btn">🚪 Logout</button></a>
        </div>
    </div>
    
    <div class="container">
        <div class="sidebar">
            <div class="menu-item active">📊 Dashboard</div>
            <div class="menu-item">👥 Data Siswa Penerima</div>
            <a href="../pages/lihat_menu.php" class="clickable">
                <div class="menu-item">🍽️ Lihat Menu Harian</div>
            </a>
            <a href="../pages/database_nutrisi.php" class="clickable">
                <div class="menu-item">ℹ️ Informasi Gizi</div>
            </a>
            <div class="menu-item">📈 Laporan Compliance</div>
            <div class="menu-item">💬 Komunikasi SPPG</div>
            <div class="menu-item">🏫 Profil Sekolah</div>
            <div class="menu-item">👤 Profil & Settings</div>
        </div>
        
        <div class="main-content">
            <div class="page-title">📊 Dashboard Sekolah Penerima MBG</div>
            
            <div class="highlight">
                <strong>✨ Selamat datang di Nutri Track MBG!</strong> Di sini Anda dapat melihat menu gizi anak, info nutrisi, dan laporan compliance.
            </div>
            
            <div class="quick-info">
                <div class="info-box">
                    <div class="info-label">Siswa Penerima</div>
                    <div class="info-value">50</div>
                </div>
                <div class="info-box">
                    <div class="info-label">Compliance Hari Ini</div>
                    <div class="info-value">95% ✓</div>
                </div>
                <div class="info-box">
                    <div class="info-label">SPPG Terkait</div>
                    <div class="info-value">SPPG Bandung</div>
                </div>
                <div class="info-box">
                    <div class="info-label">Menu Status</div>
                    <div class="info-value">Siap ✓</div>
                </div>
            </div>
            
            <div class="content-section">
                <div class="section-title">📋 Menu Utama Sekolah</div>
                <ul class="menu-list">
                    <li>👥 <strong>Data Siswa Penerima MBG</strong>
                        <br><small style="color: #999;">Lihat, edit, dan tambah data siswa penerima program</small>
                    </li>
                    <li style="margin-top: 15px;" onclick="window.location.href='../pages/lihat_menu.php'">
                        🍽️ <strong>Lihat Menu Harian</strong>
                        <br><small style="color: #999;">Lihat menu gizi yang akan diberikan setiap hari</small>
                    </li>
                    <li style="margin-top: 15px;" onclick="window.location.href='../pages/database_nutrisi.php'">
                        ℹ️ <strong>Informasi Gizi</strong>
                        <br><small style="color: #999;">Panduan standar gizi dan kebutuhan nutrisi anak</small>
                    </li>
                    <li style="margin-top: 15px;">
                        📈 <strong>Laporan Compliance</strong>
                        <br><small style="color: #999;">Monitoring apakah nutrisi memenuhi standar nasional</small>
                    </li>
                    <li style="margin-top: 15px;">
                        💬 <strong>Komunikasi SPPG</strong>
                        <br><small style="color: #999;">Chat dengan SPPG untuk request menu khusus atau laporan</small>
                    </li>
                    <li style="margin-top: 15px;">
                        🏫 <strong>Profil Sekolah</strong>
                        <br><small style="color: #999;">Lihat dan edit info sekolah, SPPG terkait</small>
                    </li>
                </ul>
            </div>
            
            <div class="content-section">
                <div class="section-title">🎯 Tugas Sekolah Setiap Hari</div>
                <ul class="menu-list">
                    <li>✅ Lihat menu gizi dari SPPG (pagi sebelum jam 07:00)</li>
                    <li>✅ Siapkan bahan makanan sesuai menu</li>
                    <li>✅ Bagikan menu ke orang tua siswa</li>
                    <li>✅ Monitor kesehatan siswa saat makan</li>
                    <li>✅ Report masalah/keluhan ke SPPG jika ada</li>
                    <li>✅ Pastikan compliance nutrisi berjalan baik</li>
                </ul>
            </div>
            
            <div class="content-section">
                <div class="section-title">ℹ️ Tentang Program MBG</div>
                <p style="color: #666; line-height: 1.8;">
                    <strong>Program Makan Bergizi Gratis (MBG)</strong> adalah program pemerintah yang bertujuan untuk meningkatkan gizi anak di sekolah.<br><br>
                    <strong>Tujuan Program:</strong><br>
                    • Memastikan setiap anak menerima nutrisi cukup<br>
                    • Meningkatkan prestasi belajar anak<br>
                    • Mengurangi angka gizi buruk di Indonesia<br><br>
                    <strong>Standar Gizi yang Harus Dipenuhi:</strong><br>
                    • Kalori: 1,300 - 1,500 kcal per hari<br>
                    • Protein: minimal 40g per hari<br>
                    • Plus vitamin, mineral, dan nutrisi lainnya<br><br>
                    <strong>Peran Sekolah:</strong> Memastikan menu tepat waktu, berkualitas, dan sesuai standar gizi.
                </p>
            </div>
        </div>
    </div>
</body>
</html>