<?php
/**
 * Laporan Harian & Tracking Menu - SPPG
 * Lihat riwayat menu yang sudah diinput
 */

session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'sppg') {
    header('Location: ../index.php');
    exit();
}

$name = $_SESSION['name'];

// Dummy data laporan (dalam production gunakan database)
$reports = array(
    array(
        'id' => 1,
        'date' => '2026-06-04',
        'day' => 'Rabu',
        'school_id' => 1,
        'school_name' => 'SDN Mekar Jaya 01',
        'menu' => 'Nasi Merah + Ayam Rebus + Labu Siam Rebus + Kuah Kaldu',
        'calories' => 570,
        'protein' => 36,
        'compliance' => 96,
        'status' => 'excellent',
        'notes' => ''
    ),
    array(
        'id' => 2,
        'date' => '2026-06-03',
        'day' => 'Selasa',
        'school_id' => 2,
        'school_name' => 'SDN Mekar Jaya 02',
        'menu' => 'Nasi Putih + Tempe Goreng + Bayam Rebus + Sambal',
        'calories' => 540,
        'protein' => 30,
        'compliance' => 91,
        'status' => 'good',
        'notes' => ''
    ),
    array(
        'id' => 3,
        'date' => '2026-06-02',
        'day' => 'Senin',
        'school_id' => 3,
        'school_name' => 'SDN Mekar Jaya 03',
        'menu' => 'Nasi Putih + Telur Rebus + Sawi Rebus + Kuah',
        'calories' => 490,
        'protein' => 28,
        'compliance' => 82,
        'status' => 'warning',
        'notes' => 'Kalori sedikit kurang'
    ),
    array(
        'id' => 4,
        'date' => '2026-06-01',
        'day' => 'Minggu',
        'school_id' => 1,
        'school_name' => 'SDN Mekar Jaya 01',
        'menu' => 'Nasi + Tahu Goreng + Brokoli Rebus + Sambal',
        'calories' => 520,
        'protein' => 32,
        'compliance' => 88,
        'status' => 'good',
        'notes' => ''
    ),
    array(
        'id' => 5,
        'date' => '2026-05-31',
        'day' => 'Sabtu',
        'school_id' => 2,
        'school_name' => 'SDN Mekar Jaya 02',
        'menu' => 'Nasi Putih + Daging Sapi Rebus + Kangkung + Kuah',
        'calories' => 600,
        'protein' => 42,
        'compliance' => 98,
        'status' => 'excellent',
        'notes' => ''
    ),
    array(
        'id' => 6,
        'date' => '2026-05-30',
        'day' => 'Jumat',
        'school_id' => 3,
        'school_name' => 'SDN Mekar Jaya 03',
        'menu' => 'Nasi Merah + Ikan Lele Goreng + Wortel Rebus + Kuah Kaldu',
        'calories' => 580,
        'protein' => 38,
        'compliance' => 95,
        'status' => 'excellent',
        'notes' => ''
    ),
    array(
        'id' => 7,
        'date' => '2026-05-29',
        'day' => 'Kamis',
        'school_id' => 1,
        'school_name' => 'SDN Mekar Jaya 01',
        'menu' => 'Nasi Putih + Ayam Goreng + Bayam Rebus + Sambal',
        'calories' => 550,
        'protein' => 35,
        'compliance' => 92,
        'status' => 'good',
        'notes' => ''
    ),
);

// Filter by date range
$filter_date = isset($_GET['date']) ? $_GET['date'] : '';
$filter_school = isset($_GET['school']) ? $_GET['school'] : '';
$filter_status = isset($_GET['status']) ? $_GET['status'] : '';

$filtered_reports = array_filter($reports, function($report) use ($filter_date, $filter_school, $filter_status) {
    $match_date = empty($filter_date) || $report['date'] === $filter_date;
    $match_school = empty($filter_school) || $report['school_id'] == $filter_school;
    $match_status = empty($filter_status) || $report['status'] === $filter_status;
    return $match_date && $match_school && $match_status;
});

usort($filtered_reports, function($a, $b) {
    return strtotime($b['date']) - strtotime($a['date']);
});

$schools = array(
    array('id' => 1, 'name' => 'SDN Mekar Jaya 01'),
    array('id' => 2, 'name' => 'SDN Mekar Jaya 02'),
    array('id' => 3, 'name' => 'SDN Mekar Jaya 03'),
);

// Calculate statistics
$total_menus = count($reports);
$avg_calories = round(array_sum(array_column($reports, 'calories')) / $total_menus);
$avg_compliance = round(array_sum(array_column($reports, 'compliance')) / $total_menus);
$excellent_count = count(array_filter($reports, function($r) { return $r['status'] === 'excellent'; }));
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Harian & Tracking Menu - SPPG</title>
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
        
        .back-link {
            color: white;
            text-decoration: none;
            margin-right: 20px;
        }
        
        .back-link:hover {
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
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
            margin-bottom: 30px;
        }
        
        .stat-box {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            border-left: 4px solid #00f2fe;
        }
        
        .stat-label {
            color: #999;
            font-size: 12px;
        }
        
        .stat-value {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin-top: 5px;
        }
        
        .filter-section {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 20px;
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }
        
        .filter-group {
            flex: 1;
            min-width: 150px;
        }
        
        .filter-label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 600;
            font-size: 14px;
        }
        
        input[type="date"],
        select {
            width: 100%;
            padding: 10px;
            border: 2px solid #e0e0e0;
            border-radius: 5px;
            font-size: 14px;
        }
        
        input[type="date"]:focus,
        select:focus {
            outline: none;
            border-color: #00f2fe;
        }
        
        .table-section {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            overflow: hidden;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        thead {
            background: #667eea;
            color: white;
        }
        
        th {
            padding: 15px;
            text-align: left;
            font-weight: 600;
            font-size: 13px;
        }
        
        td {
            padding: 12px 15px;
            border-bottom: 1px solid #f0f0f0;
            font-size: 13px;
        }
        
        tbody tr:hover {
            background: #f9f9f9;
        }
        
        .date-badge {
            background: #e3f2fd;
            color: #1976d2;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 600;
        }
        
        .status-badge {
            padding: 6px 12px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 600;
            text-align: center;
            display: inline-block;
            min-width: 60px;
        }
        
        .status-excellent {
            background: #c8e6c9;
            color: #2e7d32;
        }
        
        .status-good {
            background: #bbdefb;
            color: #1565c0;
        }
        
        .status-warning {
            background: #ffe0b2;
            color: #e65100;
        }
        
        .status-danger {
            background: #ffccbc;
            color: #d84315;
        }
        
        .no-results {
            padding: 30px;
            text-align: center;
            color: #999;
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
            background: #e1f5ff;
            border-left: 4px solid #00f2fe;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            color: #0277bd;
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
            <div style="text-align: right; color: white;">
                <div>👤 <?php echo htmlspecialchars($name); ?></div>
                <div style="font-size: 12px; opacity: 0.8;">SPPG</div>
            </div>
            <a href="../api/logout.php"><button class="logout-btn">🚪 Logout</button></a>
        </div>
    </div>
    
    <div class="container">
        <div class="sidebar">
            <a href="../dashboard/sppg_dashboard.php" style="text-decoration: none; color: inherit;">
                <div class="menu-item">📊 Dashboard</div>
            </a>
            <a href="../pages/input_menu.php" style="text-decoration: none; color: inherit;">
                <div class="menu-item">🍽️ Input Menu Makan Siang</div>
            </a>
            <a href="../pages/database_nutrisi.php" style="text-decoration: none; color: inherit;">
                <div class="menu-item">🥗 Database Nutrisi</div>
            </a>
            <div class="menu-item active">📈 Laporan Harian</div>
            <div class="menu-item">📊 Analytics</div>
            <div class="menu-item">🏫 Manajemen Sekolah</div>
        </div>
        
        <div class="main-content">
            <div class="page-title">📈 Laporan Harian & Tracking Menu</div>
            
            <div class="info-box">
                <strong>📊 STATISTIK KESELURUHAN:</strong> Total menu yang diinput, rata-rata kalori, dan compliance rate semua sekolah.
            </div>
            
            <div class="stats-grid">
                <div class="stat-box">
                    <div class="stat-label">Total Menu Diinput</div>
                    <div class="stat-value"><?php echo $total_menus; ?></div>
                </div>
                <div class="stat-box">
                    <div class="stat-label">Rata-rata Kalori</div>
                    <div class="stat-value"><?php echo $avg_calories; ?></div>
                </div>
                <div class="stat-box">
                    <div class="stat-label">Rata-rata Compliance</div>
                    <div class="stat-value"><?php echo $avg_compliance; ?>%</div>
                </div>
                <div class="stat-box">
                    <div class="stat-label">Menu Excellent</div>
                    <div class="stat-value"><?php echo $excellent_count; ?></div>
                </div>
            </div>
            
            <div class="filter-section">
                <div class="filter-group">
                    <label class="filter-label">📅 Tanggal</label>
                    <input type="date" id="filter-date" value="<?php echo htmlspecialchars($filter_date); ?>">
                </div>
                <div class="filter-group">
                    <label class="filter-label">🏫 Sekolah</label>
                    <select id="filter-school">
                        <option value="">Semua Sekolah</option>
                        <?php foreach ($schools as $school): ?>
                            <option value="<?php echo $school['id']; ?>" <?php echo ($filter_school == $school['id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($school['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="filter-group">
                    <label class="filter-label">✅ Status</label>
                    <select id="filter-status">
                        <option value="">Semua Status</option>
                        <option value="excellent" <?php echo ($filter_status === 'excellent') ? 'selected' : ''; ?>>Excellent</option>
                        <option value="good" <?php echo ($filter_status === 'good') ? 'selected' : ''; ?>>Good</option>
                        <option value="warning" <?php echo ($filter_status === 'warning') ? 'selected' : ''; ?>>Warning</option>
                    </select>
                </div>
            </div>
            
            <div class="table-section">
                <?php if (count($filtered_reports) > 0): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Sekolah</th>
                                <th>Menu Makan Siang</th>
                                <th>Kalori</th>
                                <th>Protein</th>
                                <th>Compliance</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($filtered_reports as $report): ?>
                                <tr>
                                    <td>
                                        <span class="date-badge">
                                            <?php echo date('d M', strtotime($report['date'])); ?> <br>
                                            <?php echo htmlspecialchars($report['day']); ?>
                                        </span>
                                    </td>
                                    <td><?php echo htmlspecialchars($report['school_name']); ?></td>
                                    <td style="max-width: 300px;"><?php echo htmlspecialchars($report['menu']); ?></td>
                                    <td><strong><?php echo $report['calories']; ?></strong> kcal</td>
                                    <td><?php echo $report['protein']; ?>g</td>
                                    <td><?php echo $report['compliance']; ?>%</td>
                                    <td>
                                        <span class="status-badge status-<?php echo $report['status']; ?>">
                                            <?php 
                                            $status_text = array(
                                                'excellent' => '✅ Excellent',
                                                'good' => '✅ Good',
                                                'warning' => '⚠️ Warning',
                                                'danger' => '❌ Danger'
                                            );
                                            echo $status_text[$report['status']];
                                            ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="no-results">
                        <strong>❌ Tidak ada laporan yang sesuai dengan filter</strong><br>
                        Coba ubah tanggal, sekolah, atau status
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <script>
        document.getElementById('filter-date').addEventListener('change', updateFilters);
        document.getElementById('filter-school').addEventListener('change', updateFilters);
        document.getElementById('filter-status').addEventListener('change', updateFilters);
        
        function updateFilters() {
            const date = document.getElementById('filter-date').value;
            const school = document.getElementById('filter-school').value;
            const status = document.getElementById('filter-status').value;
            
            const params = new URLSearchParams();
            if (date) params.append('date', date);
            if (school) params.append('school', school);
            if (status) params.append('status', status);
            
            window.location.href = '?' + params.toString();
        }
    </script>
</body>
</html>