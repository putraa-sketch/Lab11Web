<?php
/**
 * File: module/auth/login.php
 * Deskripsi: Halaman login dengan autentikasi
 */

// Cek jika sudah login, redirect ke home
if (isset($_SESSION['is_login']) && $_SESSION['is_login'] === true) {
    header('Location: /lab11_php_oop/index.php/user/list');
    exit;
}

$message = "";
$message_type = "";

// Logika Proses Login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'])) {
    $db = new Database();
    
    // Ambil input dan sanitasi
    $username = $db->escape($_POST['username']);
    $password = $_POST['password']; // Jangan di-escape untuk password
    
    // Query cari user berdasarkan username
    $sql = "SELECT * FROM admin_users WHERE username = '{$username}' LIMIT 1";
    $result = $db->query($sql);
    
    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Verifikasi password dengan password_verify
      if (md5($password) === $user['password']) {
            // Login SUKSES: Set Session
            $_SESSION['is_login'] = true;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['nama'] = $user['nama'];
            
            // Redirect ke halaman user list
            header('Location: /lab11_php_oop/index.php/user/list');
            exit;
        } else {
            $message = "Username atau password salah!";
            $message_type = "danger";
        }
    } else {
        $message = "Username tidak ditemukan!";
        $message_type = "danger";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Praktikum 12</title>
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
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .login-container {
            background: white;
            max-width: 450px;
            width: 100%;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .login-header h2 {
            color: #667eea;
            font-size: 28px;
            margin-bottom: 10px;
        }
        
        .login-header p {
            color: #6c757d;
            font-size: 14px;
        }
        
        .alert {
            padding: 12px 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            font-size: 14px;
        }
        
        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
            font-size: 14px;
        }
        
        .form-group input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-size: 14px;
            transition: border 0.3s;
        }
        
        .form-group input:focus {
            outline: none;
            border-color: #667eea;
        }
        
        .btn-login {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        
        .login-footer {
            margin-top: 25px;
            text-align: center;
        }
        
        .login-footer a {
            color: #667eea;
            text-decoration: none;
            font-size: 14px;
            transition: color 0.3s;
        }
        
        .login-footer a:hover {
            color: #764ba2;
            text-decoration: underline;
        }
        
        .demo-info {
            background: #e7f3ff;
            border: 1px solid #b3d7ff;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 13px;
            color: #004085;
        }
        
        .demo-info strong {
            display: block;
            margin-bottom: 8px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h2>🔐 Login System</h2>
            <p>Praktikum 12 - Autentikasi & Session</p>
        </div>
        
        <div class="demo-info">
            <strong>📝 Demo Account:</strong>
            Username: <strong>admin</strong><br>
            Password: <strong>admin123</strong>
        </div>
        
        <?php if ($message): ?>
            <div class="alert alert-<?php echo $message_type; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="username">👤 Username</label>
                <input type="text" 
                       id="username" 
                       name="username" 
                       placeholder="Masukkan username" 
                       required 
                       autofocus>
            </div>
            
            <div class="form-group">
                <label for="password">🔒 Password</label>
                <input type="password" 
                       id="password" 
                       name="password" 
                       placeholder="Masukkan password" 
                       required>
            </div>
            
            <button type="submit" class="btn-login">
                🚀 Login Sekarang
            </button>
        </form>
        
        <div class="login-footer">
            <a href="/lab11_php_oop/">← Kembali ke Home</a>
        </div>
    </div>
</body>
</html>