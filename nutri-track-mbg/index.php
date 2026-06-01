<?php
/**
 * NUTRI TRACK MBG - Login Page
 * Halaman login utama sistem
 */

session_start();

// Jika sudah login, redirect ke dashboard
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard/' . $_SESSION['role'] . '_dashboard.php');
    exit();
}

// Inisialisasi variabel
$error = '';

// Process login
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    
    // Validasi input
    if (empty($username) || empty($password)) {
        $error = '⚠️ Username dan password harus diisi!';
    } else {
        // Data akun demo (untuk testing - tidak ditampilkan)
        $users = array(
            array('username' => 'bgn_admin', 'password' => 'BGN@12345', 'role' => 'bgn', 'name' => 'Admin BGN'),
            array('username' => 'kemenskes_admin', 'password' => 'Kemenskes@12345', 'role' => 'kemenskes', 'name' => 'Admin Kemenskes'),
            array('username' => 'sppg_bandung', 'password' => 'SPPG@bandung123', 'role' => 'sppg', 'name' => 'SPPG Bandung'),
            array('username' => 'sppg_jakarta', 'password' => 'SPPG@jakarta123', 'role' => 'sppg', 'name' => 'SPPG Jakarta'),
            array('username' => 'sppg_surabaya', 'password' => 'SPPG@surabaya123', 'role' => 'sppg', 'name' => 'SPPG Surabaya'),
            array('username' => 'sppg_medan', 'password' => 'SPPG@medan123', 'role' => 'sppg', 'name' => 'SPPG Medan'),
            array('username' => 'sppg_makassar', 'password' => 'SPPG@makassar123', 'role' => 'sppg', 'name' => 'SPPG Makassar'),
            array('username' => 'sekolah_01', 'password' => 'Sekolah@123', 'role' => 'sekolah', 'name' => 'SDN Mekar Jaya 01'),
            array('username' => 'sekolah_02', 'password' => 'Sekolah@123', 'role' => 'sekolah', 'name' => 'SDN Mekar Jaya 02'),
            array('username' => 'sekolah_03', 'password' => 'Sekolah@123', 'role' => 'sekolah', 'name' => 'SDN Mekar Jaya 03'),
            array('username' => 'ortu_01', 'password' => 'Ortu@12345', 'role' => 'ortu', 'name' => 'Ibu Siti'),
            array('username' => 'ortu_02', 'password' => 'Ortu@12345', 'role' => 'ortu', 'name' => 'Bapak Ahmad'),
            array('username' => 'ortu_03', 'password' => 'Ortu@12345', 'role' => 'ortu', 'name' => 'Ibu Nur'),
            array('username' => 'ortu_04', 'password' => 'Ortu@12345', 'role' => 'ortu', 'name' => 'Bapak Budi'),
            array('username' => 'ortu_05', 'password' => 'Ortu@12345', 'role' => 'ortu', 'name' => 'Ibu Rina'),
            array('username' => 'ortu_06', 'password' => 'Ortu@12345', 'role' => 'ortu', 'name' => 'Bapak Doni'),
            array('username' => 'ortu_07', 'password' => 'Ortu@12345', 'role' => 'ortu', 'name' => 'Ibu Maya'),
            array('username' => 'ortu_08', 'password' => 'Ortu@12345', 'role' => 'ortu', 'name' => 'Bapak Roni'),
        );
        
        $user_found = false;
        foreach ($users as $user) {
            if ($user['username'] === $username && $user['password'] === $password) {
                // Login berhasil
                $_SESSION['user_id'] = $username;
                $_SESSION['role'] = $user['role'];
                $_SESSION['name'] = $user['name'];
                $_SESSION['login_time'] = time();
                
                // Redirect ke dashboard
                header('Location: dashboard/' . $user['role'] . '_dashboard.php');
                exit();
            }
        }
        
        $error = '❌ Username atau password salah!';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nutri Track MBG - Login</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Cambria', 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .login-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 420px;
            padding: 40px;
            animation: slideUp 0.5s ease-out;
        }
        
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .logo-section {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .logo-icon {
            font-size: 48px;
            margin-bottom: 10px;
        }
        
        h1 {
            font-family: 'Cambria', serif;
            color: #333;
            font-size: 24px;
            margin-bottom: 5px;
        }
        
        .subtitle {
            color: #999;
            font-size: 14px;
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
        input[type="password"] {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-family: 'Segoe UI', sans-serif;
            font-size: 14px;
            transition: all 0.3s ease;
        }
        
        input[type="text"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
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
        
        button[type="submit"] {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
        }
        
        button[type="submit"]:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.3);
        }
        
        button[type="submit"]:active {
            transform: translateY(0);
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo-section">
            <div class="logo-icon">🥗</div>
            <h1>Nutri Track MBG</h1>
            <p class="subtitle">Sistem Monitoring Gizi Program Makan Bergizi Gratis</p>
        </div>
        
        <?php if ($error): ?>
            <div class="error-message"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form method="POST" action="index.php">
            <div class="form-group">
                <label for="username">👤 Username</label>
                <input type="text" id="username" name="username" placeholder="Masukkan username Anda" required autofocus>
            </div>
            
            <div class="form-group">
                <label for="password">🔐 Password</label>
                <input type="password" id="password" name="password" placeholder="Masukkan password Anda" required>
            </div>
            
            <button type="submit">🔓 Masuk</button>
        </form>
    </div>
</body>
</html>