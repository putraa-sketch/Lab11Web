<?php
/**
 * File: module/user/hapus.php
 * Deskripsi: Proses hapus data user
 */

// Instance objek database
$db = new Database();

// Ambil ID dari URL
$id = isset($segments[2]) ? (int)$segments[2] : 0;

if ($id > 0) {
    // Cek apakah data ada
    $user = $db->get('users', "id = $id");
    
    if ($user) {
        // Hapus data
        $hapus = $db->delete('users', "id = $id");
        
        if ($hapus) {
            echo '<div class="alert alert-success">
                    ✅ Data <strong>' . htmlspecialchars($user['nama']) . '</strong> berhasil dihapus!
                  </div>';
        } else {
            echo '<div class="alert alert-danger">
                    ❌ Gagal menghapus data.
                  </div>';
        }
    } else {
        echo '<div class="alert alert-danger">
                ❌ Data tidak ditemukan!
              </div>';
    }
} else {
    echo '<div class="alert alert-danger">
            ❌ ID tidak valid!
          </div>';
}
?>

<div style="margin-top: 20px;">
    <a href="/lab11_php_oop/index.php/user/list" class="btn">⬅️ Kembali ke Daftar User</a>
</div>