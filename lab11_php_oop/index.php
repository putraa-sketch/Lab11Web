<?php
/**
 * File: index.php
 * Deskripsi: Router utama aplikasi dengan konsep modularisasi
 */

// Load konfigurasi
include "config.php";

// Include class yang diperlukan
include "class/Database.php";
include "class/Form.php";

// Mulai session
session_start();

// === ROUTING LOGIC ===
// Menangkap request path
// Contoh: /user/list atau /artikel/tambah
$path = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '/home/index';

// Memecah path menjadi array
$segments = explode('/', trim($path, '/'));

// Menentukan Module (default: home)
$mod = isset($segments[0]) && !empty($segments[0]) ? $segments[0] : 'home';

// Menentukan Action/Page (default: index)
$page = isset($segments[1]) && !empty($segments[1]) ? $segments[1] : 'index';

// Menentukan path file modul
$file = "module/{$mod}/{$page}.php";

// === LOAD TEMPLATE & KONTEN ===
include "template/header.php";

// Cek apakah file modul ada
if (file_exists($file)) {
    include $file;
} else {
    echo '<div style="padding: 20px; background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 5px; margin: 20px 0;">';
    echo '<strong>Error 404:</strong> Modul tidak ditemukan: <strong>' . htmlspecialchars($mod) . '/' . htmlspecialchars($page) . '</strong>';
    echo '</div>';
}

include "template/footer.php";
?>