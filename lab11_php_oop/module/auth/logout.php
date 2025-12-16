<?php
/**
 * File: module/auth/logout.php
 * Deskripsi: Proses logout - menghapus session
 */

// Hapus semua session
session_unset();
session_destroy();

// Redirect menggunakan JavaScript karena header sudah dikirim
echo '<script>window.location.href = "/lab11_php_oop/index.php/auth/login";</script>';
exit;
?>