<?php
/**
 * File: module/user/ubah.php
 * Deskripsi: Form untuk mengubah/edit data user
 */

// Instance objek
$db = new Database();

// Ambil ID dari URL
$id = isset($segments[2]) ? (int)$segments[2] : 0;

// Ambil data user berdasarkan ID
$user = $db->get('users', "id = $id");

// Redirect jika data tidak ditemukan
if (!$user) {
    echo '<div class="alert alert-danger">❌ Data tidak ditemukan!</div>';
    echo '<a href="/lab11_php_oop/index.php/user/list" class="btn">Kembali</a>';
    exit;
}

// Logika update data
if ($_POST && isset($_POST['nama'])) {
    $data = [
        'nama' => $db->escape($_POST['nama']),
        'email' => $db->escape($_POST['email']),
        'pass' => $db->escape($_POST['pass']),
        'jenis_kelamin' => $db->escape($_POST['jenis_kelamin']),
        'agama' => $db->escape($_POST['agama']),
        'hobi' => isset($_POST['hobi']) ? implode(', ', $_POST['hobi']) : '',
        'alamat' => $db->escape($_POST['alamat'])
    ];
    
    $update = $db->update('users', $data, "id = $id");
    
    if ($update) {
        echo '<div class="alert alert-success">
                ✅ Data berhasil diupdate! 
                <a href="/lab11_php_oop/index.php/user/list">Lihat data</a>
              </div>';
        // Refresh data user
        $user = $db->get('users', "id = $id");
    } else {
        echo '<div class="alert alert-danger">
                ❌ Gagal mengupdate data.
              </div>';
    }
}
?>

<h2 style="color: #667eea; margin-bottom: 20px;">✏️ Edit Data User</h2>

<div style="background: #fff3cd; padding: 15px; border-radius: 5px; border-left: 4px solid #ffc107; margin-bottom: 20px;">
    <strong>⚠️ Perhatian:</strong> Anda sedang mengedit data <strong><?php echo htmlspecialchars($user['nama']); ?></strong>
</div>

<form action="" method="POST">
    <table width="100%" border="0">
        <tr>
            <td align="right" valign="top" style="width: 200px; padding: 10px;">Nama Lengkap</td>
            <td style="padding: 10px;">
                <input type="text" name="nama" value="<?php echo htmlspecialchars($user['nama']); ?>" required>
            </td>
        </tr>
        <tr>
            <td align="right" valign="top" style="padding: 10px;">Email</td>
            <td style="padding: 10px;">
                <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </td>
        </tr>
        <tr>
            <td align="right" valign="top" style="padding: 10px;">Password</td>
            <td style="padding: 10px;">
                <input type="password" name="pass" value="<?php echo htmlspecialchars($user['pass']); ?>" required>
            </td>
        </tr>
        <tr>
            <td align="right" valign="top" style="padding: 10px;">Jenis Kelamin</td>
            <td style="padding: 10px;">
                <label>
                    <input type="radio" name="jenis_kelamin" value="L" <?php echo ($user['jenis_kelamin'] == 'L') ? 'checked' : ''; ?>> Laki-laki
                </label>
                <label style="margin-left: 20px;">
                    <input type="radio" name="jenis_kelamin" value="P" <?php echo ($user['jenis_kelamin'] == 'P') ? 'checked' : ''; ?>> Perempuan
                </label>
            </td>
        </tr>
        <tr>
            <td align="right" valign="top" style="padding: 10px;">Agama</td>
            <td style="padding: 10px;">
                <select name="agama" required>
                    <option value="">-- Pilih Agama --</option>
                    <?php
                    $agama_list = ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'];
                    foreach ($agama_list as $agama_item) {
                        $selected = ($user['agama'] == $agama_item) ? 'selected' : '';
                        echo "<option value='$agama_item' $selected>$agama_item</option>";
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td align="right" valign="top" style="padding: 10px;">Hobi</td>
            <td style="padding: 10px;">
                <?php
                $hobi_user = explode(', ', $user['hobi']);
                $hobi_list = ['Membaca', 'Coding', 'Traveling', 'Gaming', 'Olahraga'];
                foreach ($hobi_list as $hobi_item) {
                    $checked = in_array($hobi_item, $hobi_user) ? 'checked' : '';
                    echo "<label style='display: inline-block; margin-right: 15px;'>";
                    echo "<input type='checkbox' name='hobi[]' value='$hobi_item' $checked> $hobi_item";
                    echo "</label>";
                }
                ?>
            </td>
        </tr>
        <tr>
            <td align="right" valign="top" style="padding: 10px;">Alamat</td>
            <td style="padding: 10px;">
                <textarea name="alamat" cols="30" rows="4" required><?php echo htmlspecialchars($user['alamat']); ?></textarea>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="padding: 20px 10px;">
                <input type="submit" value="💾 Update Data">
                <a href="/lab11_php_oop/index.php/user/list" class="btn btn-warning">⬅️ Kembali</a>
            </td>
        </tr>
    </table>
</form>