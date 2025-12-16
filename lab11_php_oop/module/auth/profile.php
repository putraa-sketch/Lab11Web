<?php
/**
 * File: module/auth/profile.php
 * Deskripsi: Halaman profil user dan ubah password (TUGAS)
 */

// Cek login
if (!isset($_SESSION['is_login'])) {
    header('Location: /lab11_php_oop/index.php/auth/login');
    exit;
}

$db = new Database();
$message = "";
$message_type = "";

// Ambil data user yang sedang login
$user_id = $_SESSION['user_id'];
$user = $db->get('admin_users', "id = {$user_id}");

// Proses update password
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_password'])) {
    $password_lama = $_POST['password_lama'];
    $password_baru = $_POST['password_baru'];
    $password_konfirmasi = $_POST['password_konfirmasi'];
    
    // Validasi password lama
    if (password_verify($password_lama, $user['password'])) {
        // Cek password baru dan konfirmasi sama
        if ($password_baru === $password_konfirmasi) {
            // Cek panjang password minimal 6 karakter
            if (strlen($password_baru) >= 6) {
                // Hash password baru
                $password_hash = password_hash($password_baru, PASSWORD_DEFAULT);
                
                // Update ke database
                $update = $db->update('admin_users', [
                    'password' => $password_hash
                ], "id = {$user_id}");
                
                if ($update) {
                    $message = "Password berhasil diubah!";
                    $message_type = "success";
                    // Refresh data user
                    $user = $db->get('admin_users', "id = {$user_id}");
                } else {
                    $message = "Gagal mengubah password!";
                    $message_type = "danger";
                }
            } else {
                $message = "Password baru minimal 6 karakter!";
                $message_type = "danger";
            }
        } else {
            $message = "Password baru dan konfirmasi tidak sama!";
            $message_type = "danger";
        }
    } else {
        $message = "Password lama salah!";
        $message_type = "danger";
    }
}

// Proses update profil (nama)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $nama_baru = $db->escape($_POST['nama']);
    
    $update = $db->update('admin_users', [
        'nama' => $nama_baru
    ], "id = {$user_id}");
    
    if ($update) {
        $_SESSION['nama'] = $nama_baru; // Update session
        $message = "Profil berhasil diupdate!";
        $message_type = "success";
        // Refresh data user
        $user = $db->get('admin_users', "id = {$user_id}");
    } else {
        $message = "Gagal mengupdate profil!";
        $message_type = "danger";
    }
}
?>

<h2 style="color: #667eea; margin-bottom: 20px;">👤 Profil Pengguna</h2>

<?php if ($message): ?>
    <div class="alert alert-<?php echo $message_type; ?>">
        <?php echo htmlspecialchars($message); ?>
    </div>
<?php endif; ?>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-top: 30px;">
    
    <!-- Card Info Profil -->
    <div style="background: #f8f9fa; padding: 30px; border-radius: 10px; border-left: 5px solid #667eea;">
        <h3 style="color: #333; margin-bottom: 20px;">📋 Informasi Profil</h3>
        
        <form method="POST" action="">
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">Username</label>
                <input type="text" 
                       value="<?php echo htmlspecialchars($user['username']); ?>" 
                       disabled
                       style="width: 100%; padding: 12px; background: #e9ecef; border: 2px solid #dee2e6; border-radius: 5px; color: #6c757d;">
                <small style="color: #6c757d;">Username tidak dapat diubah</small>
            </div>
            
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">Nama Lengkap</label>
                <input type="text" 
                       name="nama"
                       value="<?php echo htmlspecialchars($user['nama']); ?>" 
                       required
                       style="width: 100%; padding: 12px; border: 2px solid #e9ecef; border-radius: 5px;">
            </div>
            
            <button type="submit" name="update_profile" class="btn" style="width: 100%;">
                💾 Update Profil
            </button>
        </form>
    </div>
    
    <!-- Card Ubah Password -->
    <div style="background: #fff3cd; padding: 30px; border-radius: 10px; border-left: 5px solid #ffc107;">
        <h3 style="color: #333; margin-bottom: 20px;">🔒 Ubah Password</h3>
        
        <form method="POST" action="">
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">Password Lama</label>
                <input type="password" 
                       name="password_lama"
                       placeholder="Masukkan password lama"
                       required
                       style="width: 100%; padding: 12px; border: 2px solid #e9ecef; border-radius: 5px;">
            </div>
            
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">Password Baru</label>
                <input type="password" 
                       name="password_baru"
                       placeholder="Masukkan password baru (min 6 karakter)"
                       required
                       minlength="6"
                       style="width: 100%; padding: 12px; border: 2px solid #e9ecef; border-radius: 5px;">
            </div>
            
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">Konfirmasi Password Baru</label>
                <input type="password" 
                       name="password_konfirmasi"
                       placeholder="Ketik ulang password baru"
                       required
                       minlength="6"
                       style="width: 100%; padding: 12px; border: 2px solid #e9ecef; border-radius: 5px;">
            </div>
            
            <button type="submit" name="update_password" class="btn btn-warning" style="width: 100%;">
                🔐 Ubah Password
            </button>
        </form>
        
        <div style="margin-top: 20px; padding: 15px; background: white; border-radius: 5px; border: 1px solid #ffc107;">
            <small style="color: #856404;">
                <strong>⚠️ Catatan:</strong><br>
                • Password minimal 6 karakter<br>
                • Gunakan kombinasi huruf dan angka<br>
                • Password akan di-enkripsi dengan aman
            </small>
        </div>
    </div>
</div>

<div style="margin-top: 30px; padding: 20px; background: #e7f3ff; border-left: 4px solid #2196F3; border-radius: 5px;">
    <strong>ℹ️ Info Akun:</strong><br>
    User ID: <?php echo $user['id']; ?><br>
    Terdaftar sejak: <?php echo date('d M Y H:i', strtotime($user['created_at'])); ?>
</div>