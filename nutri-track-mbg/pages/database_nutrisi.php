<?php
/**
 * Database Nutrisi Lengkap - Akses untuk semua role
 * Menampilkan kalori, protein, lemak, karbo, vitamin, mineral
 */

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit();
}

$name = $_SESSION['name'];
$role = $_SESSION['role'];

// Database nutrisi LENGKAP (per 100g)
$nutrition_items = array(
    // PROTEIN
    array('id' => 1, 'name' => 'Ayam Goreng', 'category' => 'Protein', 'calories' => 165, 'protein' => 31, 'fat' => 9.3, 'carbs' => 0, 'fiber' => 0, 'vit_c' => 0, 'calcium' => 15, 'iron' => 1.3, 'description' => 'Daging ayam yang digoreng, kaya protein'),
    array('id' => 2, 'name' => 'Ayam Rebus', 'category' => 'Protein', 'calories' => 165, 'protein' => 31, 'fat' => 3.6, 'carbs' => 0, 'fiber' => 0, 'vit_c' => 0, 'calcium' => 15, 'iron' => 1.3, 'description' => 'Daging ayam yang direbus, lebih sehat'),
    array('id' => 3, 'name' => 'Ikan Lele Goreng', 'category' => 'Protein', 'calories' => 238, 'protein' => 25, 'fat' => 14, 'carbs' => 0, 'fiber' => 0, 'vit_c' => 0, 'calcium' => 150, 'iron' => 1.2, 'description' => 'Ikan lele yang digoreng, kaya omega-3'),
    array('id' => 4, 'name' => 'Telur Rebus', 'category' => 'Protein', 'calories' => 70, 'protein' => 6, 'fat' => 5, 'carbs' => 0.6, 'fiber' => 0, 'vit_c' => 0, 'calcium' => 50, 'iron' => 1.2, 'description' => 'Telur ayam yang direbus, mudah dicerna'),
    array('id' => 5, 'name' => 'Tahu Goreng', 'category' => 'Protein', 'calories' => 270, 'protein' => 15, 'fat' => 23, 'carbs' => 4, 'fiber' => 2, 'vit_c' => 0, 'calcium' => 400, 'iron' => 1, 'description' => 'Tahu yang digoreng, kaya kalsium'),
    array('id' => 6, 'name' => 'Tempe', 'category' => 'Protein', 'calories' => 195, 'protein' => 19, 'fat' => 11, 'carbs' => 8, 'fiber' => 3.5, 'vit_c' => 0, 'calcium' => 120, 'iron' => 2.7, 'description' => 'Tempe kedelai, sumber protein nabati'),
    array('id' => 7, 'name' => 'Daging Sapi', 'category' => 'Protein', 'calories' => 250, 'protein' => 26, 'fat' => 17, 'carbs' => 0, 'fiber' => 0, 'vit_c' => 0, 'calcium' => 20, 'iron' => 2.6, 'description' => 'Daging sapi merah, kaya zat besi'),
    
    // SAYURAN
    array('id' => 8, 'name' => 'Bayam Rebus', 'category' => 'Sayuran', 'calories' => 22, 'protein' => 2.9, 'fat' => 0.4, 'carbs' => 3.7, 'fiber' => 2.2, 'vit_c' => 8.4, 'calcium' => 136, 'iron' => 3.2, 'description' => 'Bayam direbus, kaya vitamin A dan zat besi'),
    array('id' => 9, 'name' => 'Brokoli Rebus', 'category' => 'Sayuran', 'calories' => 34, 'protein' => 3.7, 'fat' => 0.4, 'carbs' => 7, 'fiber' => 2.4, 'vit_c' => 55, 'calcium' => 47, 'iron' => 0.5, 'description' => 'Brokoli direbus, kaya vitamin C'),
    array('id' => 10, 'name' => 'Wortel Rebus', 'category' => 'Sayuran', 'calories' => 34, 'protein' => 0.7, 'fat' => 0.2, 'carbs' => 8, 'fiber' => 2.3, 'vit_c' => 3.6, 'calcium' => 30, 'iron' => 0.2, 'description' => 'Wortel direbus, kaya beta-karoten'),
    array('id' => 11, 'name' => 'Kangkung Rebus', 'category' => 'Sayuran', 'calories' => 29, 'protein' => 3, 'fat' => 0.3, 'carbs' => 5.3, 'fiber' => 1.2, 'vit_c' => 21, 'calcium' => 73, 'iron' => 1.5, 'description' => 'Kangkung direbus, kaya mineral'),
    array('id' => 12, 'name' => 'Sawi Rebus', 'category' => 'Sayuran', 'calories' => 18, 'protein' => 1.5, 'fat' => 0.2, 'carbs' => 3.2, 'fiber' => 0.8, 'vit_c' => 13, 'calcium' => 105, 'iron' => 0.6, 'description' => 'Sawi direbus, kaya kalsium'),
    array('id' => 13, 'name' => 'Labu Siam Rebus', 'category' => 'Sayuran', 'calories' => 20, 'protein' => 0.8, 'fat' => 0.1, 'carbs' => 4.5, 'fiber' => 1.2, 'vit_c' => 7, 'calcium' => 15, 'iron' => 0.3, 'description' => 'Labu siam direbus, rendah kalori'),
    
    // KARBOHIDRAT
    array('id' => 14, 'name' => 'Nasi Putih (100g)', 'category' => 'Karbohidrat', 'calories' => 130, 'protein' => 2.7, 'fat' => 0.3, 'carbs' => 28, 'fiber' => 0.4, 'vit_c' => 0, 'calcium' => 10, 'iron' => 0.2, 'description' => 'Nasi putih direbus, sumber energi utama'),
    array('id' => 15, 'name' => 'Nasi Merah (100g)', 'category' => 'Karbohidrat', 'calories' => 111, 'protein' => 2.6, 'fat' => 0.9, 'carbs' => 23, 'fiber' => 1.8, 'vit_c' => 0, 'calcium' => 20, 'iron' => 0.8, 'description' => 'Nasi merah direbus, lebih tinggi serat'),
    
    // PELENGKAP
    array('id' => 16, 'name' => 'Sambal', 'category' => 'Pelengkap', 'calories' => 29, 'protein' => 1, 'fat' => 0.5, 'carbs' => 6, 'fiber' => 0.3, 'vit_c' => 9, 'calcium' => 10, 'iron' => 0.3, 'description' => 'Sambal pedas, meningkatkan rasa'),
    array('id' => 17, 'name' => 'Kuah Kaldu', 'category' => 'Pelengkap', 'calories' => 15, 'protein' => 1.5, 'fat' => 0.5, 'carbs' => 1, 'fiber' => 0, 'vit_c' => 0, 'calcium' => 5, 'iron' => 0.1, 'description' => 'Kuah kaldu, meningkatkan cita rasa'),
);

$search = isset($_GET['search']) ? $_GET['search'] : '';
$filter_category = isset($_GET['category']) ? $_GET['category'] : '';

// Filter berdasarkan search & category
$filtered_items = array_filter($nutrition_items, function($item) use ($search, $filter_category) {
    $match_search = empty($search) || stripos($item['name'], $search) !== false;
    $match_category = empty($filter_category) || $item['category'] === $filter_category;
    return $match_search && $match_category;
});

// Get unique categories
$categories = array_unique(array_column($nutrition_items, 'category'));
sort($categories);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Nutrisi Lengkap</title>
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
        
        .back-link {
            color: white;
            text-decoration: none;
            margin-right: 20px;
        }
        
        .back-link:hover {
            opacity: 0.8;
        }
        
        .navbar-user {
            display: flex;
            gap: 20px;
            align-items: center;
        }
        
        .container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }
        
        .page-title {
            font-size: 28px;
            color: #333;
            margin-bottom: 20px;
            font-family: 'Cambria', serif;
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
            min-width: 200px;
        }
        
        .filter-label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 600;
            font-size: 14px;
        }
        
        input[type="text"],
        select {
            width: 100%;
            padding: 10px;
            border: 2px solid #e0e0e0;
            border-radius: 5px;
            font-size: 14px;
            transition: all 0.3s ease;
        }
        
        input[type="text"]:focus,
        select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        .table-section {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            overflow: hidden;
            margin-bottom: 20px;
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
            font-size: 14px;
        }
        
        td {
            padding: 12px 15px;
            border-bottom: 1px solid #f0f0f0;
            font-size: 13px;
        }
        
        tbody tr:hover {
            background: #f9f9f9;
            cursor: pointer;
        }
        
        .category-badge {
            display: inline-block;
            background: #e3f2fd;
            color: #1976d2;
            padding: 5px 10px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .nutrition-value {
            color: #666;
            font-size: 12px;
        }
        
        .nutrition-high {
            color: #d32f2f;
            font-weight: 600;
        }
        
        .nutrition-medium {
            color: #f57c00;
            font-weight: 600;
        }
        
        .nutrition-low {
            color: #388e3c;
            font-weight: 600;
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
        
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
        }
        
        .modal-content {
            background-color: white;
            margin: 5% auto;
            padding: 30px;
            border-radius: 10px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.3);
        }
        
        .modal-header {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #333;
        }
        
        .modal-body {
            color: #666;
            line-height: 1.8;
        }
        
        .modal-nutrient {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-top: 15px;
        }
        
        .nutrient-item {
            background: #f5f5f5;
            padding: 10px;
            border-radius: 5px;
            border-left: 3px solid #667eea;
        }
        
        .nutrient-label {
            font-size: 12px;
            color: #999;
            margin-bottom: 3px;
        }
        
        .nutrient-value {
            font-size: 16px;
            font-weight: bold;
            color: #333;
        }
        
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
        
        .close:hover,
        .close:focus {
            color: black;
        }
        
        .info-badge {
            background: #e3f2fd;
            border-left: 4px solid #1976d2;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            color: #1565c0;
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
                <div style="font-size: 12px; opacity: 0.8;"><?php echo ucfirst($role); ?></div>
            </div>
            <a href="../api/logout.php"><button class="logout-btn">🚪 Logout</button></a>
        </div>
    </div>
    
    <div class="container">
        <div class="page-title">🍽️ Database Nutrisi Lengkap</div>
        
        <div class="info-badge">
            <strong>💡 INFO:</strong> Klik baris untuk melihat detail nutrisi lengkap per bahan makanan. Semua nilai per 100 gram.
        </div>
        
        <div class="filter-section">
            <div class="filter-group">
                <label class="filter-label">🔍 Cari Makanan</label>
                <input type="text" id="search" placeholder="Cari nama makanan..." value="<?php echo htmlspecialchars($search); ?>">
            </div>
            <div class="filter-group">
                <label class="filter-label">📂 Kategori</label>
                <select id="category">
                    <option value="">Semua Kategori</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?php echo $cat; ?>" <?php echo ($filter_category === $cat) ? 'selected' : ''; ?>>
                            <?php echo $cat; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        
        <div class="table-section">
            <?php if (count($filtered_items) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Nama Makanan</th>
                            <th>Kategori</th>
                            <th>Kalori (kcal)</th>
                            <th>Protein (g)</th>
                            <th>Lemak (g)</th>
                            <th>Karbo (g)</th>
                            <th>Vit C (mg)</th>
                            <th>Kalsium (mg)</th>
                            <th>Zat Besi (mg)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($filtered_items as $item): ?>
                            <tr onclick="showDetail(<?php echo htmlspecialchars(json_encode($item)); ?>)">
                                <td><strong><?php echo htmlspecialchars($item['name']); ?></strong></td>
                                <td><span class="category-badge"><?php echo htmlspecialchars($item['category']); ?></span></td>
                                <td><span class="nutrition-value"><?php echo $item['calories']; ?></span></td>
                                <td><span class="nutrition-value"><?php echo $item['protein']; ?></span></td>
                                <td><span class="nutrition-value"><?php echo $item['fat']; ?></span></td>
                                <td><span class="nutrition-value"><?php echo $item['carbs']; ?></span></td>
                                <td><span class="nutrition-value"><?php echo $item['vit_c']; ?></span></td>
                                <td><span class="nutrition-value"><?php echo $item['calcium']; ?></span></td>
                                <td><span class="nutrition-value"><?php echo $item['iron']; ?></span></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="no-results">
                    <strong>❌ Makanan tidak ditemukan</strong><br>
                    Coba ubah pencarian atau filter kategori
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Modal Detail -->
    <div id="detailModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <div class="modal-header" id="modalTitle"></div>
            <div class="modal-body">
                <p id="modalDescription" style="margin-bottom: 15px;"></p>
                <strong>📊 INFORMASI NUTRISI (Per 100g):</strong>
                <div class="modal-nutrient">
                    <div class="nutrient-item">
                        <div class="nutrient-label">Kalori</div>
                        <div class="nutrient-value" id="modalCalories"></div>
                    </div>
                    <div class="nutrient-item">
                        <div class="nutrient-label">Protein</div>
                        <div class="nutrient-value" id="modalProtein"></div>
                    </div>
                    <div class="nutrient-item">
                        <div class="nutrient-label">Lemak</div>
                        <div class="nutrient-value" id="modalFat"></div>
                    </div>
                    <div class="nutrient-item">
                        <div class="nutrient-label">Karbohidrat</div>
                        <div class="nutrient-value" id="modalCarbs"></div>
                    </div>
                    <div class="nutrient-item">
                        <div class="nutrient-label">Serat</div>
                        <div class="nutrient-value" id="modalFiber"></div>
                    </div>
                    <div class="nutrient-item">
                        <div class="nutrient-label">Vitamin C</div>
                        <div class="nutrient-value" id="modalVitC"></div>
                    </div>
                    <div class="nutrient-item">
                        <div class="nutrient-label">Kalsium</div>
                        <div class="nutrient-value" id="modalCalcium"></div>
                    </div>
                    <div class="nutrient-item">
                        <div class="nutrient-label">Zat Besi</div>
                        <div class="nutrient-value" id="modalIron"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        document.getElementById('search').addEventListener('keyup', function(e) {
            const search = this.value;
            const category = document.getElementById('category').value;
            const params = new URLSearchParams();
            if (search) params.append('search', search);
            if (category) params.append('category', category);
            window.location.href = '?' + params.toString();
        });
        
        document.getElementById('category').addEventListener('change', function(e) {
            const search = document.getElementById('search').value;
            const category = this.value;
            const params = new URLSearchParams();
            if (search) params.append('search', search);
            if (category) params.append('category', category);
            window.location.href = '?' + params.toString();
        });
        
        function showDetail(item) {
            document.getElementById('modalTitle').textContent = item.name;
            document.getElementById('modalDescription').textContent = item.description;
            document.getElementById('modalCalories').textContent = item.calories + ' kcal';
            document.getElementById('modalProtein').textContent = item.protein + 'g';
            document.getElementById('modalFat').textContent = item.fat + 'g';
            document.getElementById('modalCarbs').textContent = item.carbs + 'g';
            document.getElementById('modalFiber').textContent = item.fiber + 'g';
            document.getElementById('modalVitC').textContent = item.vit_c + 'mg';
            document.getElementById('modalCalcium').textContent = item.calcium + 'mg';
            document.getElementById('modalIron').textContent = item.iron + 'mg';
            
            document.getElementById('detailModal').style.display = 'block';
        }
        
        function closeModal() {
            document.getElementById('detailModal').style.display = 'none';
        }
        
        window.onclick = function(event) {
            const modal = document.getElementById('detailModal');
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }
    </script>
</body>
</html>