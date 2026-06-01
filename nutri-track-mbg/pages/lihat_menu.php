<?php
/**
 * Lihat Menu Makan Siang - Sekolah & Orang Tua
 * HANYA MAKAN SIANG (1x sehari)
 */

session_start();

if (!isset($_SESSION['user_id']) || ($_SESSION['role'] != 'sekolah' && $_SESSION['role'] != 'ortu')) {
    header('Location: ../index.php');
    exit();
}

$name = $_SESSION['name'];
$role = $_SESSION['role'];

// Dummy data menu untuk 7 hari ke depan - HANYA MAKAN SIANG
$menus = array(
    array(
        'date' => '2026-05-29',
        'day' => 'Kamis',
        'lunch' => 'Nasi Putih + Ayam Goreng + Bayam Rebus + Sambal',
        'lunch_cal' => 550,
        'lunch_protein' => 35,
        'compliance' => '92%',
        'status' => 'good'
    ),
    array(
        'date' => '2026-05-30',
        'day' => 'Jumat',
        'lunch' => 'Nasi Merah + Ikan Lele Goreng + Wortel Rebus + Kuah Kaldu',
        'lunch_cal' => 580,
        'lunch_protein' => 38,
        'compliance' => '95%',
        'status' => 'excellent'
    ),
    array(
        'date' => '2026-05-31',
        'day' => 'Sabtu',
        'lunch' => 'Nasi Putih + Daging Sapi Rebus + Kangkung + Kuah',
        'lunch_cal' => 600,
        'lunch_protein' => 42,
        'compliance' => '98%',
        'status' => 'excellent'
    ),
    array(
        'date' => '2026-06-01',
        'day' => 'Minggu',
        'lunch' => 'Nasi + Tahu Goreng + Brokoli Rebus + Sambal',
        'lunch_cal' => 520,
        'lunch_protein' => 32,
        'compliance' => '88%',
        'status' => 'good'
    ),
    array(
        'date' => '2026-06-02',
        'day' => 'Senin',
        'lunch' => 'Nasi Putih + Telur Rebus + Sawi Rebus + Kuah',
        'lunch_cal' => 490,
        'lunch_protein' => 28,
        'compliance' => '82%',
        'status' => 'warning'
    ),
    array(
        'date' => '2026-06-03',
        'day' => 'Selasa',
        'lunch' => 'Nasi + Tempe Goreng + Bayam Rebus + Sambal',
        'lunch_cal' => 540,
        'lunch_protein' => 30,
        'compliance' => '91%',
        'status' => 'good'
    ),
    array(
        'date' => '2026-06-04',
        'day' => 'Rabu',
        'lunch' => 'Nasi Merah + Ayam Rebus + Labu Siam + Kuah Kaldu',
        'lunch_cal' => 570,
        'lunch_protein' => 36,
        'compliance' => '96%',
        'status' => 'excellent'
    ),
);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lihat Menu Makan Siang</title>
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
            background: <?php echo ($role == 'sekolah') ? 'linear-gradient(135deg, #fa709a 0%, #fee140 100%)' : 'linear-gradient(135deg, #a8edea 0%, #fed6e3 100%)'; ?>;
            color: <?php echo ($role == 'sekolah') ? 'white' : '#333'; ?>;
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
        
        .back-link {
            color: inherit;
            text-decoration: none;
            margin-right: 20px;
            transition: all 0.3s ease;
        }
        
        .back-link:hover {
            opacity: 0.7;
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
            opacity: 0.7;
        }
        
        .container {
            max-width: 900px;
            margin: 30px auto;
            padding: 0 20px;
        }
        
        .page-title {
            font-size: 28px;
            color: #333;
            margin-bottom: 10px;
            font-family: 'Cambria', serif;
        }
        
        .subtitle {
            color: #999;
            margin-bottom: 30px;
            font-size: 14px;
        }
        
        .menu-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 20px;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        
        .menu-card:hover {
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            transform: translateY(-2px);
        }
        
        .menu-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .menu-date-info {
            display: flex;
            flex-direction: column;
        }
        
        .menu-date {
            font-size: 18px;
            font-weight: bold;
        }
        
        .menu-day {
            font-size: 14px;
            opacity: 0.9;
        }
        
        .compliance-badge {
            background: white;
            color: #333;
            padding: 8px 15px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 14px;
        }
        
        .compliance-badge.excellent {
            background: #4caf50;
            color: white;
        }
        
        .compliance-badge.good {
            background: #2196f3;
            color: white;
        }
        
        .compliance-badge.warning {
            background: #ff9800;
            color: white;
        }
        
        .menu-body {
            padding: 20px;
        }
        
        .section-title {
            font-weight: bold;
            color: #333;
            margin-bottom: 8px;
            font-size: 16px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .section-content {
            color: #666;
            padding: 15px;
            background: #f9f9f9;
            border-radius: 5px;
            border-left: 4px solid #667eea;
            line-height: 1.6;
            font-size: 15px;
        }
        
        .nutrition-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-top: 12px;
        }
        
        .nutrition-item {
            background: #e8f5e9;
            padding: 10px;
            border-radius: 5px;
            border-left: 3px solid #4caf50;
            font-size: 13px;
        }
        
        .nutrition-label {
            color: #2e7d32;
            font-weight: bold;
            display: flex;
            justify-content: space-between;
        }
        
        .nutrition-tips {
            background: #e3f2fd;
            border-left: 4px solid #1976d2;
            padding: 15px;
            border-radius: 5px;
            margin-top: 30px;
            color: #1565c0;
            line-height: 1.6;
            font-size: 14px;
        }
        
        .nutrition-tips strong {
            display: block;
            margin-bottom: 10px;
            font-size: 15px;
        }
        
        .logout-btn {
            background: #ff6b6b;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
        }
        
        .logout-btn:hover {
            background: #ff5252;
        }
        
        .info-box {
            background: #fff3e0;
            border-left: 4px solid #f57c00;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            color: #e65100;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div style="display: flex; align-items: center;">
            <a href="javascript:history.back()" class="back-link">← Kembali</a>
            <div class="navbar-brand">🥗 Nutri Track MBG</div>
        </div>
        <div class="navbar-user">
            <div class="user-info">
                <div>👤 <?php echo htmlspecialchars($name); ?></div>
                <div class="role"><?php echo ($role == 'sekolah') ? 'Sekolah' : 'Orang Tua'; ?></div>
            </div>
            <a href="../api/logout.php"><button class="logout-btn">🚪 Logout</button></a>
        </div>
    </div>
    
    <div class="container">
        <div class="page-title">🍽️ Menu Makan Siang Harian</div>
        <div class="subtitle">Program MBG diberikan 1x sehari pada jam makan siang (11:00 - 12:30)</div>
        
        <div class="info-box">
            <strong>📢 INFO PENTING:</strong> Menu makan siang berikut adalah bagian dari Program Makan Bergizi Gratis (MBG) yang disediakan setiap hari untuk mendukung gizi anak.
        </div>
        
        <?php foreach ($menus as $menu): ?>
            <div class="menu-card">
                <div class="menu-header">
                    <div class="menu-date-info">
                        <div class="menu-date">📅 <?php echo date('d M Y', strtotime($menu['date'])); ?></div>
                        <div class="menu-day"><?php echo htmlspecialchars($menu['day']); ?></div>
                    </div>
                    <div class="compliance-badge <?php echo $menu['status']; ?>">
                        ✓ <?php echo $menu['compliance']; ?> Compliance
                    </div>
                </div>
                
                <div class="menu-body">
                    <div class="section-title">🍽️ Menu Makan Siang (Jam 11:00-12:30)</div>
                    <div class="section-content">
                        <?php echo htmlspecialchars($menu['lunch']); ?>
                        
                        <div class="nutrition-info">
                            <div class="nutrition-item">
                                <div class="nutrition-label">
                                    <span>Kalori:</span>
                                    <strong><?php echo $menu['lunch_cal']; ?> kcal</strong>
                                </div>
                            </div>
                            <div class="nutrition-item">
                                <div class="nutrition-label">
                                    <span>Protein:</span>
                                    <strong><?php echo $menu['lunch_protein']; ?>g</strong>
                                </div>
                            </div>
                        </div>
                        
                        <?php 
                        $status_text = '';
                        $status_color = '';
                        
                        if ($menu['lunch_cal'] >= 500 && $menu['lunch_cal'] <= 700) {
                            $status_text = '✅ Memenuhi standar gizi';
                            $status_color = '#4caf50';
                        } else {
                            $status_text = '⚠️ Perlu review';
                            $status_color = '#ff9800';
                        }
                        ?>
                        <div style="background: rgba(76, 175, 80, 0.1); padding: 10px; border-radius: 5px; margin-top: 12px; text-align: center; color: <?php echo $status_color; ?>; font-weight: bold;">
                            <?php echo $status_text; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        
        <div class="nutrition-tips">
            <strong>💡 Tips Nutrisi untuk <?php echo ($role == 'sekolah') ? 'Sekolah' : 'Orang Tua'; ?>:</strong><br><br>
            ✓ Menu makan siang MBG diberikan setiap hari dengan standar 500-700 kcal<br>
            ✓ Pastikan anak menghabiskan semua menu yang diberikan sekolah<br>
            ✓ Minum air putih minimal 6-8 gelas per hari<br>
            ✓ Di rumah, berikan tambahan makanan sehat (buah, sayur) jika diperlukan<br>
            ✓ Pastikan anak tidur cukup 8-10 jam setiap malam<br>
            ✓ Olahraga ringan minimal 30 menit per hari untuk kesehatan optimal
        </div>
    </div>
</body>
</html>