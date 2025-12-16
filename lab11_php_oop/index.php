<?php
/**
 * File: index.php
 * Deskripsi: Router utama aplikasi dengan konsep modularisasi + Autentikasi
 */

// 1. Mulai session di baris paling atas
session_start();

// Load konfigurasi
include "config.php";

// Include class yang diperlukan
include "class/Database.php";
include "class/Form.php";

// === ROUTING LOGIC ===
// Menangkap request path
$path = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '/home/index';

// Memecah path menjadi array
$segments = explode('/', trim($path, '/'));

// Menentukan Module (default: home)
$mod = isset($segments[0]) && !empty($segments[0]) ? $segments[0] : 'home';

// Menentukan Action/Page (default: index)
$page = isset($segments[1]) && !empty($segments[1]) ? $segments[1] : 'index';

// === MIDDLEWARE AUTENTIKASI ===
// Halaman yang boleh diakses TANPA login
$public_modules = ['home', 'auth'];

// Cek apakah module butuh login
if (!in_array($mod, $public_modules)) {
    // Jika belum login, redirect ke halaman login
    if (!isset($_SESSION['is_login']) || $_SESSION['is_login'] !== true) {
        header('Location: /lab11_php_oop/index.php/auth/login');
        exit();
    }
}

// Menentukan path file modul
$file = "module/{$mod}/{$page}.php";

// === LOAD TEMPLATE & KONTEN ===
// Cek apakah file modul ada
if (file_exists($file)) {
    // Jangan load header/footer untuk halaman auth (login, logout, register)
    if ($mod == 'auth' && in_array($page, ['login', 'logout', 'register'])) {
        include $file;
    } else {
        include "template/header.php";
        include $file;
        include "template/footer.php";
    }
} else {
    include "template/header.php";
    echo '<div style="padding: 20px; background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 5px; margin: 20px 0;">';
    echo '<strong>Error 404:</strong> Modul tidak ditemukan: <strong>' . htmlspecialchars($mod) . '/' . htmlspecialchars($page) . '</strong>';
    echo '</div>';
    include "template/footer.php";
}
?>