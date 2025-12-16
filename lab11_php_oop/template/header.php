<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Praktikum 11 & 12 - PHP OOP Framework</title>
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
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            overflow: hidden;
        }
        
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        
        .header h1 {
            font-size: 2em;
            margin-bottom: 10px;
        }
        
        .header p {
            opacity: 0.9;
        }
        
        .nav {
            background: #f8f9fa;
            padding: 15px 30px;
            border-bottom: 2px solid #e9ecef;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }
        
        .nav-left, .nav-right {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }
        
        .nav a {
            display: inline-block;
            padding: 10px 20px;
            background: white;
            color: #667eea;
            text-decoration: none;
            border-radius: 5px;
            transition: all 0.3s;
            border: 2px solid #667eea;
            font-size: 14px;
        }
        
        .nav a:hover {
            background: #667eea;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        .nav a.logout {
            background: #dc3545;
            border-color: #dc3545;
            color: white;
        }
        
        .nav a.logout:hover {
            background: #c82333;
            border-color: #c82333;
        }
        
        .nav .user-info {
            padding: 10px 15px;
            background: #e7f3ff;
            border-radius: 5px;
            color: #004085;
            font-size: 14px;
            font-weight: 600;
        }
        
        .content {
            padding: 30px;
            min-height: 400px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        
        table th {
            background: #667eea;
            color: white;
            padding: 12px;
            text-align: left;
        }
        
        table td {
            padding: 10px;
            border-bottom: 1px solid #e9ecef;
        }
        
        table tr:hover {
            background: #f8f9fa;
        }
        
        input[type="text"],
        input[type="email"],
        input[type="password"],
        select,
        textarea {
            width: 100%;
            padding: 10px;
            border: 2px solid #e9ecef;
            border-radius: 5px;
            font-size: 14px;
            transition: border 0.3s;
        }
        
        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: #667eea;
        }
        
        input[type="submit"],
        .btn {
            background: #667eea;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s;
        }
        
        input[type="submit"]:hover,
        .btn:hover {
            background: #764ba2;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        
        .btn-danger {
            background: #dc3545;
        }
        
        .btn-danger:hover {
            background: #c82333;
        }
        
        .btn-warning {
            background: #ffc107;
            color: #000;
        }
        
        .btn-warning:hover {
            background: #e0a800;
        }
        
        .alert {
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }
        
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
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
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🚀 Praktikum 11 & 12 - PHP OOP Framework</h1>
            <p>Konsep Modularisasi, Routing & Autentikasi</p>
        </div>
        
        <div class="nav">
            <div class="nav-left">
                <a href="/lab11_php_oop/">🏠 Home</a>
                
                <?php if (isset($_SESSION['is_login']) && $_SESSION['is_login'] === true): ?>
                    <a href="/lab11_php_oop/index.php/user/list">👥 Data User</a>
                    <a href="/lab11_php_oop/index.php/user/tambah">➕ Tambah User</a>
                    <a href="/lab11_php_oop/index.php/auth/profile">👤 Profil</a>
                <?php endif; ?>
            </div>
            
            <div class="nav-right">
                <?php if (isset($_SESSION['is_login']) && $_SESSION['is_login'] === true): ?>
                    <span class="user-info">
                        👋 <?php echo htmlspecialchars($_SESSION['nama']); ?>
                    </span>
                    <a href="/lab11_php_oop/index.php/auth/logout" class="logout" onclick="return confirm('Yakin ingin logout?')">
                        🚪 Logout
                    </a>
                <?php else: ?>
                    <a href="/lab11_php_oop/index.php/auth/login">
                        🔐 Login
                    </a>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="content">