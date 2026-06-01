<?php
/**
 * DASHBOARD ORANG TUA/WALI
 */

session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'ortu') {
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
    <title>Dashboard Orang Tua - Nutri Track MBG</title>
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
            background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
            color: #333;
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
            color: #333;
        }
        
        .navbar-user {
            display: flex;
            gap: 20px;
            align-items: center;
        }
        
        .user-info {
            text-align: right;
            color: #333;
        }
        
        .user-info .role {
            font-size: 12px;
            opacity: 0.7;
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
            border-left-color: #ff6b9d;
            color: #ff6b9d;
        }
        
        .menu-item.active {
            background: #f5f5f5;
            border-left-color: #ff6b9d;
            color: #ff6b9d;
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
        
        .children-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 30px;
        }
        
        .child-card {
            background: white;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            border-left: 4px solid #ff6b9d;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .child-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .child-name {
            font-weight: bold;
            color: #333;
            font-size: 16px;
        }
        
        .child-info {
            color: #999;
            font-size: 12px;
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
            color: #ff6b9d;
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
            background: #ffe1f0;
            border-left: 4px solid #ff6b9d;
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
                <div class="role">Orang Tua / Wali</div>
            </div>
            <a href="../api/logout.php"><button class="logout-btn">🚪 Logout</button></a>
        </div>
    </div>
    
    <div class="container">
        <div class="sidebar">
    <div class="menu-item active">📊 Dashboard</div>
    <div class="menu-item">🍽️ Menu Gizi Anak</div>
    <a href="../pages/lihat_menu.php" class="clickable">
        <div class="menu-item">ℹ️ Info Nutrisi</div>
    </a>
    <div class="menu-item">📈 Laporan Kesehatan</div>
    <div class="menu-item">❓ FAQ & Tips</div>
    <div class="menu-item">💬 Komunikasi Sekolah</div>
    <div class="menu-item">👤 Profil & Settings</div>
</div>
        
        <div class="main-content">
            <div class="page-title">👨‍👩‍👧‍👦 Dashboard Orang Tua</div>
            
            <div class="highlight">
                <strong>❤️ Pantau Gizi Anak Anda!</strong> Lihat menu gizi anak setiap hari dan monitor perkembangan kesehatannya.
            </div>
            
            <div class="content-section">
                <div class="section-title">👶 Anak yang Terdaftar</div>
                <div class="children-list">
                    <div class="child-card">
                        <div class="child-name">👦 Budi Santoso</div>
                        <div class="child-info">Kelas III A<br>SDN Mekar Jaya 01</div>
                    </div>
                    <div class="child-card">
                        <div class="child-name">👧 Siti Aminah</div>
                        <div class="child-info">Kelas III A<br>SDN Mekar Jaya 01</div>
                    </div>
                </div>
            </div>
            
            <div class="content-section">
                <div class="section-title">📋 Menu Utama Orang Tua</div>
                <ul class="menu-list">
                    <li>🍽️ <strong>Menu Gizi Anak</strong>
                        <br><small style="color: #999;">Lihat menu yang akan diberikan setiap hari (7 hari ke depan)</small>
                    </li>
                    <li style="margin-top: 15px;">ℹ️ <strong>Info Nutrisi</strong>
                        <br><small style="color: #999;">Pelajari tentang nutrisi sehat untuk anak sekolah</small>
                    </li>
                    <li style="margin-top: 15px;">📈 <strong>Laporan Kesehatan Anak</strong>
                        <br><small style="color: #999;">Monitor rata-rata nutrisi dan compliance harian/mingguan</small>
                    </li>
                    <li style="margin-top: 15px;">❓ <strong>FAQ & Tips Gizi</strong>
                        <br><small style="color: #999;">Tanya jawab & tips makan sehat untuk anak</small>
                    </li>
                    <li style="margin-top: 15px;">💬 <strong>Komunikasi Sekolah</strong>
                        <br><small style="color: #999;">Chat dengan sekolah untuk pertanyaan atau report alergi</small>
                    </li>
                </ul>
            </div>
            
            <div class="content-section">
                <div class="section-title">✨ Fitur untuk Orang Tua</div>
                <p style="color: #666; line-height: 1.8;">
                    <strong>Transparansi Penuh:</strong> Anda dapat melihat menu apa yang dimakan anak setiap hari di sekolah, termasuk informasi nutrisi lengkapnya.<br><br>
                    <strong>Monitoring Kesehatan:</strong> Laporan compliance gizi anak dibandingkan dengan standar nasional. Jika ada kekurangan nutrisi, sistem akan memberikan rekomendasi.<br><br>
                    <strong>Tips Gizi:</strong> Akses panduan nutrisi sehat dan resep makanan sehat untuk melengkapi asupan anak di rumah.<br><br>
                    <strong>Komunikasi Langsung:</strong> Hubungi sekolah langsung jika anak memiliki alergi makanan atau kondisi kesehatan khusus.
                </p>
            </div>
            
            <div class="content-section">
                <div class="section-title">📊 Info Standar Gizi Anak</div>
                <p style="color: #666; line-height: 1.8;">
                    Anak sekolah dasar (6-12 tahun) membutuhkan:<br><br>
                    <strong>Per Hari:</strong><br>
                    • <strong>Kalori:</strong> 1,300 - 1,500 kcal<br>
                    • <strong>Protein:</strong> 40 - 60 gram (untuk pertumbuhan otot & otak)<br>
                    • <strong>Lemak sehat:</strong> 35 - 45 gram<br>
                    • <strong>Karbohidrat:</strong> 160 - 200 gram (untuk energi)<br>
                    • <strong>Serat:</strong> minimal 10 gram (untuk pencernaan)<br><br>
                    <strong>Vitamin & Mineral Penting:</strong><br>
                    • <strong>Vitamin A:</strong> untuk mata & imunitas<br>
                    • <strong>Vitamin C:</strong> untuk imun & penyerap zat besi<br>
                    • <strong>Kalsium & Fosfor:</strong> untuk tulang & gigi kuat<br>
                    • <strong>Zat Besi:</strong> untuk mencegah anemia<br>
                    • <strong>Iodine:</strong> untuk perkembangan otak<br>
                </p>
            </div>
        </div>
    </div>
</body>
</html>