<?php
/**
 * File: module/user/tambah.php
 * Deskripsi: Form untuk menambah user baru
 */

// Instance objek
$db = new Database();
$form = new Form("", "Simpan Data");

// Logika penyimpanan data
if ($_POST && isset($_POST['nama'])) {
    // Siapkan data untuk disimpan
    $hobi = isset($_POST['hobi']) ? implode(', ', $_POST['hobi']) : '';
    
    $data = [
        'nama' => $db->escape($_POST['nama']),
        'email' => $db->escape($_POST['email']),
        'pass' => $db->escape($_POST['pass']),
        'jenis_kelamin' => $db->escape($_POST['jenis_kelamin']),
        'agama' => $db->escape($_POST['agama']),
        'hobi' => $hobi,
        'alamat' => $db->escape($_POST['alamat'])
    ];
    
    // Simpan ke database
    $simpan = $db->insert('users', $data);
    
    if ($simpan) {
        echo '<div class="alert alert-success">
                ✅ Data berhasil disimpan! 
                <a href="/lab11_php_oop/index.php/user/list">Lihat data</a>
              </div>';
    } else {
        echo '<div class="alert alert-danger">
                ❌ Gagal menyimpan data. Silakan coba lagi.
              </div>';
    }
}
?>

<h2 style="color: #667eea; margin-bottom: 20px;">➕ Tambah User Baru</h2>

<div style="background: #f8f9fa; padding: 20px; border-radius: 10px; margin-bottom: 20px;">
    <p style="margin: 0; color: #6c757d;">
        ℹ️ Isi semua field di bawah ini untuk menambah user baru ke database.
    </p>
</div>

<form action="" method="POST" style="max-width: 800px;">
    <table width="100%" border="0">
        <tr>
            <td align="right" valign="top" style="width: 200px; padding: 10px;">Nama Lengkap <span style="color: red;">*</span></td>
            <td style="padding: 10px;">
                <input type="text" name="nama" placeholder="Masukkan nama lengkap" required>
            </td>
        </tr>
        <tr>
            <td align="right" valign="top" style="padding: 10px;">Email <span style="color: red;">*</span></td>
            <td style="padding: 10px;">
                <input type="email" name="email" placeholder="contoh@email.com" required>
            </td>
        </tr>
        <tr>
            <td align="right" valign="top" style="padding: 10px;">Password <span style="color: red;">*</span></td>
            <td style="padding: 10px;">
                <input type="password" name="pass" placeholder="Masukkan password" required>
            </td>
        </tr>
        <tr>
            <td align="right" valign="top" style="padding: 10px;">Jenis Kelamin <span style="color: red;">*</span></td>
            <td style="padding: 10px;">
                <label style="margin-right: 20px;">
                    <input type="radio" name="jenis_kelamin" value="L" required> Laki-laki
                </label>
                <label>
                    <input type="radio" name="jenis_kelamin" value="P" required> Perempuan
                </label>
            </td>
        </tr>
        <tr>
            <td align="right" valign="top" style="padding: 10px;">Agama <span style="color: red;">*</span></td>
            <td style="padding: 10px;">
                <select name="agama" required>
                    <option value="">-- Pilih Agama --</option>
                    <option value="Islam">Islam</option>
                    <option value="Kristen">Kristen</option>
                    <option value="Katolik">Katolik</option>
                    <option value="Hindu">Hindu</option>
                    <option value="Buddha">Buddha</option>
                    <option value="Konghucu">Konghucu</option>
                </select>
            </td>
        </tr>
        <tr>
            <td align="right" valign="top" style="padding: 10px;">Hobi</td>
            <td style="padding: 10px;">
                <label style="display: inline-block; margin-right: 15px;">
                    <input type="checkbox" name="hobi[]" value="Membaca"> Membaca
                </label>
                <label style="display: inline-block; margin-right: 15px;">
                    <input type="checkbox" name="hobi[]" value="Coding"> Coding
                </label>
                <label style="display: inline-block; margin-right: 15px;">
                    <input type="checkbox" name="hobi[]" value="Traveling"> Traveling
                </label>
                <label style="display: inline-block; margin-right: 15px;">
                    <input type="checkbox" name="hobi[]" value="Gaming"> Gaming
                </label>
                <label style="display: inline-block; margin-right: 15px;">
                    <input type="checkbox" name="hobi[]" value="Olahraga"> Olahraga
                </label>
            </td>
        </tr>
        <tr>
            <td align="right" valign="top" style="padding: 10px;">Alamat <span style="color: red;">*</span></td>
            <td style="padding: 10px;">
                <textarea name="alamat" cols="50" rows="4" placeholder="Masukkan alamat lengkap" required></textarea>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="padding: 20px 10px;">
                <input type="submit" value="💾 Simpan Data">
                <a href="/lab11_php_oop/index.php/user/list" class="btn btn-warning">⬅️ Kembali</a>
            </td>
        </tr>
    </table>
</form>