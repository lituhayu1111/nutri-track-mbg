<?php
/**
 * Track Compliance - Wadah Komplain Nutrisi
 * User dapat melaporkan masalah nutrisi/menu
 * Admin dapat melihat dan merespons komplain
 */

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit();
}

$name = $_SESSION['name'];
$role = $_SESSION['role'];
$user_id = $_SESSION['user_id'];

// Sample data - diganti dengan database query di production
$complaints = array(
    array(
        'id' => 1,
        'user_name' => 'Ibu Sarah (Orang Tua)',
        'school' => 'SDN Mekar Jaya 01',
        'date' => '2026-05-28',
        'complaint' => 'Menu hari Senin terlalu banyak karbohidrat, kurang sayuran hijau',
        'status' => 'pending',
        'priority' => 'medium',
        'response' => ''
    ),
    array(
        'id' => 2,
        'user_name' => 'Pak Budi (SPPG)',
        'school' => 'SDN Mekar Jaya 02',
        'date' => '2026-05-27',
        'complaint' => 'Supplier tidak mengirim bahan berkualitas, ada telur yang busuk',
        'status' => 'resolved',
        'priority' => 'high',
        'response' => 'Tim QC sudah dihubungi, ganti supplier untuk batch berikutnya'
    ),
    array(
        'id' => 3,
        'user_name' => 'Siswa Aldi (SDN Mekar Jaya 03)',
        'school' => 'SDN Mekar Jaya 03',
        'date' => '2026-05-29',
        'complaint' => 'Ada siswa yang alergi makanan yang disajikan kemarin',
        'status' => 'in_progress',
        'priority' => 'high',
        'response' => 'Akan dibahas dengan kepala sekolah...'
    )
);

// Handle new complaint submission (untuk user)
$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'add_complaint') {
    $complaint_text = isset($_POST['complaint']) ? trim($_POST['complaint']) : '';
    $school_id = isset($_POST['school_id']) ? $_POST['school_id'] : '';
    $priority = isset($_POST['priority']) ? $_POST['priority'] : 'medium';
    
    if (empty($complaint_text)) {
        $error = '❌ Harap isi laporan komplain Anda!';
    } elseif (strlen($complaint_text) < 10) {
        $error = '❌ Laporan harus minimal 10 karakter!';
    } else {
        $message = '✅ Komplain Anda telah dikirim ke Admin! Kami akan merespons dalam 24 jam.';
        // Di production: insert ke database
    }
}

// Handle admin response (untuk admin)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'add_response' && $role == 'admin') {
    $complaint_id = isset($_POST['complaint_id']) ? (int)$_POST['complaint_id'] : 0;
    $response_text = isset($_POST['response']) ? trim($_POST['response']) : '';
    $new_status = isset($_POST['status']) ? $_POST['status'] : 'pending';
    
    if (empty($response_text)) {
        $error = '❌ Harap isi respons untuk komplain ini!';
    } else {
        $message = '✅ Respons telah dikirim kepada user!';
        // Di production: update ke database
    }
}

$schools = array(
    array('id' => 1, 'name' => 'SDN Mekar Jaya 01'),
    array('id' => 2, 'name' => 'SDN Mekar Jaya 02'),
    array('id' => 3, 'name' => 'SDN Mekar Jaya 03'),
);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Compliance - Wadah Komplain</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        
        .navbar {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            border-radius: 10px;
            margin-bottom: 30px;
        }
        
        .navbar-brand {
            font-size: 22px;
            font-weight: bold;
        }
        
        .navbar-user {
            display: flex;
            gap: 20px;
            align-items: center;
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
            transform: translateY(-2px);
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .page-title {
            color: white;
            font-size: 32px;
            margin-bottom: 30px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }
        
        .tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }
        
        .tab-button {
            background: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .tab-button.active {
            background: #667eea;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        
        .tab-button:hover {
            transform: translateY(-2px);
        }
        
        .tab-content {
            display: none;
        }
        
        .tab-content.active {
            display: block;
        }
        
        .card {
            background: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 600;
            font-size: 14px;
        }
        
        input[type="text"],
        input[type="date"],
        select,
        textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-family: inherit;
            font-size: 14px;
            transition: all 0.3s ease;
        }
        
        input[type="text"]:focus,
        input[type="date"]:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        textarea {
            resize: vertical;
            min-height: 100px;
        }
        
        .message-box {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: none;
        }
        
        .message-box.error {
            background: #fee;
            color: #c33;
            border-left: 4px solid #c33;
            display: block;
        }
        
        .message-box.success {
            background: #efe;
            color: #3c3;
            border-left: 4px solid #3c3;
            display: block;
        }
        
        .button-group {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }
        
        button[type="submit"],
        button[type="reset"] {
            padding: 12px 30px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 14px;
        }
        
        button[type="submit"] {
            background: #667eea;
            color: white;
        }
        
        button[type="submit"]:hover {
            background: #5568d3;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }
        
        button[type="reset"] {
            background: #f0f0f0;
            color: #333;
        }
        
        button[type="reset"]:hover {
            background: #e0e0e0;
        }
        
        .complaint-item {
            background: #f9f9f9;
            border-left: 4px solid;
            padding: 20px;
            margin-bottom: 15px;
            border-radius: 5px;
            transition: all 0.3s ease;
        }
        
        .complaint-item:hover {
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }
        
        .complaint-item.priority-high {
            border-left-color: #ff6b6b;
            background: #fff5f5;
        }
        
        .complaint-item.priority-medium {
            border-left-color: #ffa94d;
            background: #fffbf0;
        }
        
        .complaint-item.priority-low {
            border-left-color: #51cf66;
            background: #f1fdf4;
        }
        
        .complaint-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 15px;
        }
        
        .complaint-meta {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            margin-bottom: 10px;
        }
        
        .meta-item {
            font-size: 13px;
            color: #666;
        }
        
        .meta-label {
            font-weight: 600;
            color: #333;
        }
        
        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .status-pending {
            background: #fff3cd;
            color: #856404;
        }
        
        .status-in_progress {
            background: #cfe2ff;
            color: #084298;
        }
        
        .status-resolved {
            background: #d1e7dd;
            color: #0f5132;
        }
        
        .priority-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 15px;
            font-size: 11px;
            font-weight: 600;
            margin-left: 10px;
        }
        
        .priority-high {
            background: #ffe0e0;
            color: #c33;
        }
        
        .priority-medium {
            background: #fff3cd;
            color: #856404;
        }
        
        .priority-low {
            background: #d1e7dd;
            color: #0f5132;
        }
        
        .complaint-text {
            color: #333;
            line-height: 1.6;
            margin-bottom: 15px;
            padding: 10px;
            background: white;
            border-radius: 5px;
        }
        
        .response-section {
            background: #e8f4f8;
            padding: 15px;
            border-radius: 5px;
            margin-top: 15px;
            border-left: 4px solid #00d4ff;
        }
        
        .response-header {
            font-weight: 600;
            color: #0277bd;
            margin-bottom: 10px;
        }
        
        .response-text {
            color: #333;
            line-height: 1.6;
        }
        
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        
        .stat-number {
            font-size: 32px;
            font-weight: bold;
            color: #667eea;
            margin: 10px 0;
        }
        
        .stat-label {
            color: #666;
            font-size: 14px;
        }
        
        .expand-btn {
            background: #667eea;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 12px;
            transition: all 0.3s ease;
        }
        
        .expand-btn:hover {
            background: #5568d3;
        }
        
        .expandable {
            display: none;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #e0e0e0;
        }
        
        .expandable.show {
            display: block;
        }
        
        .divider {
            height: 1px;
            background: #e0e0e0;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div>
            <div class="navbar-brand">📋 Nutri Track MBG - Track Compliance</div>
        </div>
        <div class="navbar-user">
            <div style="text-align: right; color: white;">
                <div>👤 <?php echo htmlspecialchars($name); ?></div>
                <div style="font-size: 12px; opacity: 0.8;"><?php echo strtoupper($role); ?></div>
            </div>
            <a href="../api/logout.php"><button class="logout-btn">🚪 Logout</button></a>
        </div>
    </div>
    
    <div class="container">
        <h1 class="page-title">📋 Track Compliance - Wadah Komplain</h1>
        
        <!-- Tabs Navigation -->
        <div class="tabs">
            <button class="tab-button active" onclick="switchTab('view-complaints')">
                👁️ Lihat Semua Komplain
            </button>
            <?php if ($role != 'admin'): ?>
                <button class="tab-button" onclick="switchTab('new-complaint')">
                    ➕ Buat Komplain Baru
                </button>
            <?php endif; ?>
            <?php if ($role == 'admin'): ?>
                <button class="tab-button" onclick="switchTab('my-dashboard')">
                    📊 Dashboard Admin
                </button>
            <?php endif; ?>
        </div>
        
        <!-- Tab: Lihat Semua Komplain -->
        <div id="view-complaints" class="tab-content active">
            <div class="card">
                <h2 style="margin-bottom: 20px; color: #333;">📋 Daftar Semua Komplain</h2>
                
                <?php if ($error): ?>
                    <div class="message-box error"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <?php if ($message): ?>
                    <div class="message-box success"><?php echo $message; ?></div>
                <?php endif; ?>
                
                <!-- Filter -->
                <div style="display: flex; gap: 10px; margin-bottom: 20px; flex-wrap: wrap;">
                    <input type="text" placeholder="🔍 Cari komplain..." style="flex: 1; min-width: 200px;">
                    <select style="min-width: 150px;">
                        <option value="">-- Filter Status --</option>
                        <option value="pending">Pending</option>
                        <option value="in_progress">In Progress</option>
                        <option value="resolved">Resolved</option>
                    </select>
                    <select style="min-width: 150px;">
                        <option value="">-- Filter Prioritas --</option>
                        <option value="low">Low</option>
                        <option value="medium">Medium</option>
                        <option value="high">High</option>
                    </select>
                </div>
                
                <!-- List Komplain -->
                <?php foreach ($complaints as $complaint): ?>
                    <div class="complaint-item priority-<?php echo $complaint['priority']; ?>">
                        <div class="complaint-header">
                            <div style="flex: 1;">
                                <div style="font-weight: 600; color: #333; margin-bottom: 5px;">
                                    <?php echo htmlspecialchars($complaint['user_name']); ?>
                                    <span class="status-badge status-<?php echo $complaint['status']; ?>">
                                        <?php 
                                            $status_text = array(
                                                'pending' => '⏳ Menunggu',
                                                'in_progress' => '⚙️ Sedang Diproses',
                                                'resolved' => '✅ Selesai'
                                            );
                                            echo $status_text[$complaint['status']];
                                        ?>
                                    </span>
                                    <span class="priority-badge priority-<?php echo $complaint['priority']; ?>">
                                        <?php echo strtoupper($complaint['priority']); ?> PRIORITY
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="complaint-meta">
                            <div class="meta-item">
                                <span class="meta-label">🏫 Sekolah:</span> 
                                <?php echo htmlspecialchars($complaint['school']); ?>
                            </div>
                            <div class="meta-item">
                                <span class="meta-label">📅 Tanggal:</span> 
                                <?php echo date('d-m-Y', strtotime($complaint['date'])); ?>
                            </div>
                            <div class="meta-item">
                                <span class="meta-label">🆔 ID:</span> 
                                #<?php echo $complaint['id']; ?>
                            </div>
                        </div>
                        
                        <div class="complaint-text">
                            <strong>📝 Laporan:</strong><br>
                            <?php echo htmlspecialchars($complaint['complaint']); ?>
                        </div>
                        
                        <?php if (!empty($complaint['response']) || $role == 'admin'): ?>
                            <?php if (!empty($complaint['response'])): ?>
                                <div class="response-section">
                                    <div class="response-header">✅ Respons Admin:</div>
                                    <div class="response-text">
                                        <?php echo htmlspecialchars($complaint['response']); ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($role == 'admin' && $complaint['status'] != 'resolved'): ?>
                                <button class="expand-btn" onclick="toggleExpand('complaint-<?php echo $complaint['id']; ?>')">
                                    📝 Balas Komplain Ini
                                </button>
                                
                                <div id="complaint-<?php echo $complaint['id']; ?>" class="expandable">
                                    <form method="POST" action="track_compliance.php">
                                        <input type="hidden" name="action" value="add_response">
                                        <input type="hidden" name="complaint_id" value="<?php echo $complaint['id']; ?>">
                                        
                                        <div class="form-group">
                                            <label for="status-<?php echo $complaint['id']; ?>">Perbarui Status:</label>
                                            <select id="status-<?php echo $complaint['id']; ?>" name="status" required>
                                                <option value="pending" <?php if($complaint['status'] == 'pending') echo 'selected'; ?>>Menunggu</option>
                                                <option value="in_progress" <?php if($complaint['status'] == 'in_progress') echo 'selected'; ?>>Sedang Diproses</option>
                                                <option value="resolved" <?php if($complaint['status'] == 'resolved') echo 'selected'; ?>>Selesai</option>
                                            </select>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="response-<?php echo $complaint['id']; ?>">Respons Admin:</label>
                                            <textarea id="response-<?php echo $complaint['id']; ?>" name="response" placeholder="Tulis respons Anda..." required></textarea>
                                        </div>
                                        
                                        <button type="submit" style="background: #00d4ff; color: white;">
                                            💬 Kirim Respons
                                        </button>
                                    </form>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <!-- Tab: Buat Komplain Baru (untuk user non-admin) -->
        <?php if ($role != 'admin'): ?>
            <div id="new-complaint" class="tab-content">
                <div class="card">
                    <h2 style="margin-bottom: 20px; color: #333;">➕ Buat Komplain Baru</h2>
                    
                    <?php if ($error): ?>
                        <div class="message-box error"><?php echo $error; ?></div>
                    <?php endif; ?>
                    
                    <?php if ($message): ?>
                        <div class="message-box success"><?php echo $message; ?></div>
                    <?php endif; ?>
                    
                    <div style="background: #e3f2fd; padding: 15px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #00f2fe;">
                        <strong>💡 Tips Membuat Komplain Efektif:</strong>
                        <ul style="margin-top: 10px; margin-left: 20px; color: #0277bd;">
                            <li>Jelaskan masalah secara detail dan spesifik</li>
                            <li>Sebutkan tanggal dan sekolah yang terkait</li>
                            <li>Pilih prioritas yang sesuai dengan urgensi masalah</li>
                            <li>Tim admin akan merespons dalam 24 jam</li>
                        </ul>
                    </div>
                    
                    <form method="POST" action="track_compliance.php">
                        <input type="hidden" name="action" value="add_complaint">
                        
                        <div class="form-group">
                            <label for="school_id">🏫 Sekolah Terkait:</label>
                            <select id="school_id" name="school_id" required>
                                <option value="">-- Pilih Sekolah --</option>
                                <?php foreach ($schools as $school): ?>
                                    <option value="<?php echo $school['id']; ?>">
                                        <?php echo htmlspecialchars($school['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="priority">⚠️ Tingkat Prioritas:</label>
                            <select id="priority" name="priority" required>
                                <option value="low">🟢 Low - Masalah Kecil</option>
                                <option value="medium" selected>🟡 Medium - Masalah Sedang</option>
                                <option value="high">🔴 High - Masalah Urgent</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="complaint">📝 Uraian Komplain (Minimal 10 karakter):</label>
                            <textarea 
                                id="complaint" 
                                name="complaint" 
                                placeholder="Contoh: Menu hari Senin terlalu banyak minyak, anak saya alergi kacang..." 
                                required
                                minlength="10"></textarea>
                        </div>
                        
                        <div class="button-group">
                            <button type="submit">✉️ Kirim Komplain ke Admin</button>
                            <button type="reset">🔄 Bersihkan Form</button>
                        </div>
                    </form>
                </div>
            </div>
        <?php endif; ?>
        
        <!-- Tab: Dashboard Admin -->
        <?php if ($role == 'admin'): ?>
            <div id="my-dashboard" class="tab-content">
                <div class="card">
                    <h2 style="margin-bottom: 20px; color: #333;">📊 Dashboard Admin - Statistik Komplain</h2>
                    
                    <div class="stats">
                        <div class="stat-card">
                            <div style="font-size: 20px;">📋</div>
                            <div class="stat-label">Total Komplain</div>
                            <div class="stat-number"><?php echo count($complaints); ?></div>
                        </div>
                        <div class="stat-card">
                            <div style="font-size: 20px;">⏳</div>
                            <div class="stat-label">Menunggu Respons</div>
                            <div class="stat-number">
                                <?php echo count(array_filter($complaints, function($c) { return $c['status'] == 'pending'; })); ?>
                            </div>
                        </div>
                        <div class="stat-card">
                            <div style="font-size: 20px;">⚙️</div>
                            <div class="stat-label">Sedang Diproses</div>
                            <div class="stat-number">
                                <?php echo count(array_filter($complaints, function($c) { return $c['status'] == 'in_progress'; })); ?>
                            </div>
                        </div>
                        <div class="stat-card">
                            <div style="font-size: 20px;">✅</div>
                            <div class="stat-label">Sudah Diselesaikan</div>
                            <div class="stat-number">
                                <?php echo count(array_filter($complaints, function($c) { return $c['status'] == 'resolved'; })); ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="divider"></div>
                    
                    <h3 style="color: #333; margin-bottom: 15px;">🔴 Komplain Prioritas HIGH yang Belum Diselesaikan</h3>
                    
                    <?php 
                    $urgent = array_filter($complaints, function($c) { 
                        return $c['priority'] == 'high' && $c['status'] != 'resolved'; 
                    });
                    
                    if (empty($urgent)): 
                    ?>
                        <div style="background: #d1e7dd; padding: 15px; border-radius: 8px; color: #0f5132;">
                            ✅ Tidak ada komplain HIGH priority yang tertunda!
                        </div>
                    <?php else: ?>
                        <?php foreach ($urgent as $complaint): ?>
                            <div class="complaint-item priority-high">
                                <div class="complaint-header">
                                    <div>
                                        <div style="font-weight: 600; color: #333;">
                                            <?php echo htmlspecialchars($complaint['user_name']); ?>
                                            <span class="status-badge status-<?php echo $complaint['status']; ?>">
                                                <?php 
                                                    $status_text = array(
                                                        'pending' => '⏳ Menunggu',
                                                        'in_progress' => '⚙️ Sedang Diproses'
                                                    );
                                                    echo $status_text[$complaint['status']];
                                                ?>
                                            </span>
                                        </div>
                                        <div class="complaint-text" style="margin-top: 10px;">
                                            <?php echo htmlspecialchars($complaint['complaint']); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
    
    <script>
        function switchTab(tabName) {
            // Hide all tabs
            const tabs = document.querySelectorAll('.tab-content');
            tabs.forEach(tab => tab.classList.remove('active'));
            
            // Remove active from all buttons
            const buttons = document.querySelectorAll('.tab-button');
            buttons.forEach(btn => btn.classList.remove('active'));
            
            // Show selected tab
            document.getElementById(tabName).classList.add('active');
            
            // Add active to clicked button
            event.target.classList.add('active');
        }
        
        function toggleExpand(id) {
            const element = document.getElementById(id);
            element.classList.toggle('show');
        }
    </script>
</body>
</html>
