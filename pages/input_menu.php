<?php
/**
 * Input Menu Harian - SPPG
 * HANYA UNTUK MAKAN SIANG (Standar: 500-700 kcal)
 * DENGAN HITUNG KALORI OTOMATIS
 */

session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'sppg') {
    header('Location: ../index.php');
    exit();
}

$name = $_SESSION['name'];
$message = '';
$error = '';

// Process form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $school_id = isset($_POST['school_id']) ? $_POST['school_id'] : '';
    $menu_date = isset($_POST['menu_date']) ? $_POST['menu_date'] : '';
    $menu_items = isset($_POST['menu_items']) ? $_POST['menu_items'] : array();
    $total_calories = isset($_POST['total_calories']) ? (int)$_POST['total_calories'] : 0;
    $notes = isset($_POST['notes']) ? $_POST['notes'] : '';
    
    if (empty($school_id) || empty($menu_date) || empty($menu_items)) {
        $error = '❌ Harap lengkapi semua field yang diperlukan!';
    } elseif ($total_calories < 500 || $total_calories > 700) {
        $error = '❌ Kalori makan siang harus antara 500-700 kcal! (Sekarang: ' . $total_calories . ' kcal)';
    } else {
        // Simulasi penyimpanan (dalam production, gunakan database)
        $message = '✅ Menu makan siang berhasil disimpan! Notifikasi sudah dikirim ke sekolah & orang tua.';
    }
}

$schools = array(
    array('id' => 1, 'name' => 'SDN Mekar Jaya 01', 'students' => 50),
    array('id' => 2, 'name' => 'SDN Mekar Jaya 02', 'students' => 50),
    array('id' => 3, 'name' => 'SDN Mekar Jaya 03', 'students' => 50),
);

// Database nutrisi (per 100g)
$nutrition_items = array(
    // Protein
    array('name' => 'Ayam Goreng', 'category' => 'Protein', 'calories' => 165, 'protein' => 31),
    array('name' => 'Ayam Rebus', 'category' => 'Protein', 'calories' => 165, 'protein' => 31),
    array('name' => 'Ikan Lele Goreng', 'category' => 'Protein', 'calories' => 238, 'protein' => 25),
    array('name' => 'Telur Rebus', 'category' => 'Protein', 'calories' => 70, 'protein' => 6),
    array('name' => 'Tahu Goreng', 'category' => 'Protein', 'calories' => 270, 'protein' => 15),
    array('name' => 'Tempe', 'category' => 'Protein', 'calories' => 195, 'protein' => 19),
    array('name' => 'Daging Sapi', 'category' => 'Protein', 'calories' => 250, 'protein' => 26),
    
    // Sayuran
    array('name' => 'Bayam Rebus', 'category' => 'Sayuran', 'calories' => 22, 'protein' => 2.9),
    array('name' => 'Brokoli Rebus', 'category' => 'Sayuran', 'calories' => 34, 'protein' => 3.7),
    array('name' => 'Wortel Rebus', 'category' => 'Sayuran', 'calories' => 34, 'protein' => 0.7),
    array('name' => 'Kangkung Rebus', 'category' => 'Sayuran', 'calories' => 29, 'protein' => 3),
    array('name' => 'Sawi Rebus', 'category' => 'Sayuran', 'calories' => 18, 'protein' => 1.5),
    array('name' => 'Labu Siam Rebus', 'category' => 'Sayuran', 'calories' => 20, 'protein' => 0.8),
    
    // Karbohidrat
    array('name' => 'Nasi Putih (100g)', 'category' => 'Karbohidrat', 'calories' => 130, 'protein' => 2.7),
    array('name' => 'Nasi Merah (100g)', 'category' => 'Karbohidrat', 'calories' => 111, 'protein' => 2.6),
    
    // Pelengkap
    array('name' => 'Sambal', 'category' => 'Pelengkap', 'calories' => 29, 'protein' => 1),
    array('name' => 'Kuah Kaldu', 'category' => 'Pelengkap', 'calories' => 15, 'protein' => 1.5),
);

// Group by category
$items_by_category = array();
foreach ($nutrition_items as $item) {
    $items_by_category[$item['category']][] = $item;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Menu Makan Siang - SPPG</title>
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
            transition: all 0.3s ease;
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
        
        .form-section {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            max-width: 800px;
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
        input[type="number"],
        select,
        textarea {
            width: 100%;
            padding: 10px;
            border: 2px solid #e0e0e0;
            border-radius: 5px;
            font-family: 'Segoe UI', sans-serif;
            font-size: 14px;
            transition: all 0.3s ease;
        }
        
        input[type="text"]:focus,
        input[type="date"]:focus,
        input[type="number"]:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: #00f2fe;
            box-shadow: 0 0 0 3px rgba(0, 242, 254, 0.1);
        }
        
        textarea {
            resize: vertical;
            min-height: 80px;
        }
        
        .error-message {
            background: #fee;
            color: #c33;
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #c33;
            font-size: 14px;
        }
        
        .success-message {
            background: #efe;
            color: #3c3;
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #3c3;
            font-size: 14px;
        }
        
        .form-actions {
            display: flex;
            gap: 10px;
            margin-top: 25px;
        }
        
        button[type="submit"],
        button[type="reset"],
        .btn-add {
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        button[type="submit"] {
            background: #4facfe;
            color: white;
        }
        
        button[type="submit"]:hover {
            background: #00f2fe;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 242, 254, 0.3);
        }
        
        button[type="reset"] {
            background: #f0f0f0;
            color: #333;
        }
        
        button[type="reset"]:hover {
            background: #e0e0e0;
        }
        
        .btn-add {
            background: #667eea;
            color: white;
            padding: 8px 16px;
            font-size: 13px;
            width: auto;
        }
        
        .btn-add:hover {
            background: #5568d3;
        }
        
        .btn-remove {
            background: #ff6b6b;
            color: white;
            padding: 6px 12px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            font-size: 12px;
            transition: all 0.3s ease;
        }
        
        .btn-remove:hover {
            background: #ff5252;
        }
        
        .nutrition-info {
            background: #e1f5ff;
            border-left: 4px solid #00f2fe;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 13px;
            color: #0277bd;
        }
        
        .form-section h3 {
            color: #333;
            font-size: 16px;
            margin-top: 20px;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #f0f0f0;
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
        
        .calorie-status {
            padding: 10px;
            border-radius: 5px;
            margin-top: 10px;
            font-weight: bold;
            text-align: center;
            display: none;
        }
        
        .calorie-status.good {
            background: #c8e6c9;
            color: #2e7d32;
            display: block;
        }
        
        .calorie-status.warning {
            background: #fff3cd;
            color: #856404;
            display: block;
        }
        
        .calorie-status.danger {
            background: #f8d7da;
            color: #721c24;
            display: block;
        }
        
        .checklist {
            background: #f5f5f5;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        
        .checklist-item {
            padding: 8px 0;
            font-size: 14px;
        }
        
        .menu-items-list {
            background: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            margin-top: 10px;
        }
        
        .menu-item-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            background: white;
            border-radius: 3px;
            margin-bottom: 8px;
            border-left: 3px solid #667eea;
        }
        
        .item-info {
            flex: 1;
        }
        
        .item-name {
            font-weight: 600;
            color: #333;
        }
        
        .item-calories {
            font-size: 13px;
            color: #999;
        }
        
        .item-calories strong {
            color: #667eea;
        }
        
        .category-section {
            margin-bottom: 15px;
        }
        
        .category-title {
            font-weight: 600;
            color: #333;
            padding: 10px 0;
            border-bottom: 1px solid #e0e0e0;
            margin-bottom: 10px;
        }
        
        .food-button {
            display: inline-block;
            background: #e3f2fd;
            color: #1976d2;
            padding: 6px 12px;
            border-radius: 15px;
            font-size: 12px;
            margin: 4px 4px 4px 0;
            cursor: pointer;
            border: 1px solid #1976d2;
            transition: all 0.3s ease;
        }
        
        .food-button:hover {
            background: #1976d2;
            color: white;
        }
        
        .total-calories-display {
            background: #e8f5e9;
            padding: 15px;
            border-radius: 5px;
            text-align: center;
            margin-top: 15px;
            border: 2px solid #4caf50;
        }
        
        .total-calories-display .label {
            font-size: 12px;
            color: #2e7d32;
        }
        
        .total-calories-display .value {
            font-size: 28px;
            font-weight: bold;
            color: #2e7d32;
        }
        
        .total-calories-display .status {
            font-size: 13px;
            color: #558b2f;
            margin-top: 5px;
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
            <div class="menu-item active">🍽️ Input Menu Makan Siang</div>
            <a href="../pages/database_nutrisi.php" style="text-decoration: none; color: inherit;">
                <div class="menu-item">🥗 Database Nutrisi</div>
            </a>
            <div class="menu-item">🏫 Manajemen Sekolah</div>
            <div class="menu-item">📈 Tracking Compliance</div>
            <div class="menu-item">📋 Laporan Bulanan</div>
        </div>
        
        <div class="main-content">
            <div class="page-title">🍽️ Input Menu Makan Siang</div>
            
            <?php if ($error): ?>
                <div class="error-message"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <?php if ($message): ?>
                <div class="success-message"><?php echo $message; ?></div>
            <?php endif; ?>
            
            <div class="form-section">
                <div class="nutrition-info">
                    <strong>⏰ DEADLINE:</strong> Menu harus diinput sebelum jam 07:00 pagi untuk menu hari itu.<br>
                    <strong>📊 STANDAR:</strong> Makan Siang harus 500-700 kcal dengan nutrisi lengkap.<br>
                    <strong>🔄 SISTEM BARU:</strong> Pilih bahan → Kalori terhitung otomatis!
                </div>
                
                <form method="POST" action="input_menu.php">
                    <div class="form-group">
                        <label for="school_id">🏫 Pilih Sekolah</label>
                        <select id="school_id" name="school_id" required>
                            <option value="">-- Pilih Sekolah --</option>
                            <?php foreach ($schools as $school): ?>
                                <option value="<?php echo $school['id']; ?>">
                                    <?php echo $school['name']; ?> (<?php echo $school['students']; ?> siswa)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="menu_date">📅 Tanggal Makan Siang</label>
                        <input type="date" id="menu_date" name="menu_date" required>
                    </div>
                    
                    <h3>🍽️ MENU MAKAN SIANG - Pilih Bahan Makanan</h3>
                    
                    <?php foreach ($items_by_category as $category => $items): ?>
                        <div class="category-section">
                            <div class="category-title">📌 <?php echo htmlspecialchars($category); ?></div>
                            <div style="margin-bottom: 15px;">
                                <?php foreach ($items as $item): ?>
                                    <button type="button" class="food-button" onclick="addMenuItem('<?php echo addslashes($item['name']); ?>', <?php echo $item['calories']; ?>, <?php echo $item['protein']; ?>)">
                                        <?php echo htmlspecialchars($item['name']); ?> (<?php echo $item['calories']; ?> kcal)
                                    </button>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    
                    <div class="menu-items-list">
                        <label>📋 Menu yang Dipilih:</label>
                        <div id="menu-items-container" style="margin-top: 10px;">
                            <div style="color: #999; font-size: 13px;">Pilih bahan di atas untuk menambahkan ke menu</div>
                        </div>
                    </div>
                    
                    <div class="total-calories-display">
                        <div class="label">TOTAL KALORI MAKAN SIANG</div>
                        <div class="value" id="total-calories-value">0</div>
                        <div class="status" id="total-calories-status">kcal / 500-700 kcal (Standar)</div>
                        <div id="calorie-status" class="calorie-status"></div>
                    </div>
                    
                    <input type="hidden" id="total_calories" name="total_calories" value="0">
                    <input type="hidden" id="menu_items" name="menu_items" value="">
                    
                    <div class="form-group" style="margin-top: 20px;">
                        <label for="notes">📝 Catatan Tambahan (Alergi, Pantangan, dll)</label>
                        <textarea id="notes" name="notes" placeholder="Contoh: Ada siswa yang alergi kacang"></textarea>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" id="submit-btn" disabled>💾 Simpan & Kirim ke Sekolah</button>
                        <button type="reset" onclick="resetMenu()">🔄 Bersihkan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script>
        // Database bahan makanan dengan kalori
        const menuDatabase = <?php echo json_encode($nutrition_items); ?>;
        let selectedMenus = [];
        
        function addMenuItem(name, calories, protein) {
            event.preventDefault();
            
            // Cek apakah sudah ada
            const exists = selectedMenus.find(item => item.name === name);
            if (!exists) {
                selectedMenus.push({
                    name: name,
                    calories: calories,
                    protein: protein
                });
                
                updateMenuDisplay();
                updateTotalCalories();
            } else {
                alert('⚠️ Bahan ini sudah ditambahkan!');
            }
        }
        
        function removeMenuItem(index) {
            selectedMenus.splice(index, 1);
            updateMenuDisplay();
            updateTotalCalories();
        }
        
        function updateMenuDisplay() {
            const container = document.getElementById('menu-items-container');
            
            if (selectedMenus.length === 0) {
                container.innerHTML = '<div style="color: #999; font-size: 13px;">Pilih bahan di atas untuk menambahkan ke menu</div>';
                return;
            }
            
            let html = '';
            selectedMenus.forEach((item, index) => {
                html += `
                    <div class="menu-item-row">
                        <div class="item-info">
                            <div class="item-name">${item.name}</div>
                            <div class="item-calories">Kalori: <strong>${item.calories}</strong> kcal | Protein: <strong>${item.protein}</strong>g</div>
                        </div>
                        <button type="button" class="btn-remove" onclick="removeMenuItem(${index})">Hapus</button>
                    </div>
                `;
            });
            
            container.innerHTML = html;
        }
        
        function updateTotalCalories() {
            const total = selectedMenus.reduce((sum, item) => sum + item.calories, 0);
            
            // Update hidden input
            document.getElementById('total_calories').value = total;
            document.getElementById('menu_items').value = selectedMenus.map(item => item.name).join(' + ');
            
            // Update display
            document.getElementById('total-calories-value').textContent = total;
            const status = document.getElementById('total-calories-status');
            const calStatus = document.getElementById('calorie-status');
            
            if (total === 0) {
                status.textContent = 'kcal / 500-700 kcal (Standar)';
                calStatus.innerHTML = '';
                calStatus.className = 'calorie-status';
                document.getElementById('submit-btn').disabled = true;
            } else if (total >= 500 && total <= 700) {
                status.textContent = total + ' kcal / 500-700 kcal ✅ SESUAI STANDAR!';
                status.style.color = '#2e7d32';
                calStatus.innerHTML = '✅ Kalori SESUAI standar (500-700 kcal)!';
                calStatus.className = 'calorie-status good';
                document.getElementById('submit-btn').disabled = false;
            } else if (total < 500) {
                status.textContent = total + ' kcal / 500-700 kcal ⚠️ KURANG';
                status.style.color = '#856404';
                calStatus.innerHTML = '⚠️ Kalori KURANG! Minimum harus 500 kcal.';
                calStatus.className = 'calorie-status warning';
                document.getElementById('submit-btn').disabled = true;
            } else {
                status.textContent = total + ' kcal / 500-700 kcal ❌ BERLEBIH';
                status.style.color = '#721c24';
                calStatus.innerHTML = '❌ Kalori BERLEBIH! Maksimal 700 kcal.';
                calStatus.className = 'calorie-status danger';
                document.getElementById('submit-btn').disabled = true;
            }
        }
        
        function resetMenu() {
            selectedMenus = [];
            updateMenuDisplay();
            updateTotalCalories();
            document.getElementById('notes').value = '';
        }
        
        // Set default date ke hari ini
        document.getElementById('menu_date').valueAsDate = new Date();
    </script>
</body>
</html>
