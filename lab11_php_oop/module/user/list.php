<?php
/**
 * File: module/user/list.php
 * Deskripsi: Menampilkan daftar user dari database
 */

// Instance objek database
$db = new Database();

// Ambil semua data user
$users = $db->getAll('users', null, 'id DESC');
?>

<h2 style="color: #667eea; margin-bottom: 20px;">📋 Data User</h2>

<div style="margin-bottom: 20px;">
    <a href="/lab11_php_oop/index.php/user/tambah" class="btn">➕ Tambah User Baru</a>
</div>

<?php if (count($users) > 0): ?>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Jenis Kelamin</th>
                <th>Agama</th>
                <th>Hobi</th>
                <th>Alamat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            foreach ($users as $user): 
            ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo htmlspecialchars($user['nama']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td><?php echo $user['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan'; ?></td>
                    <td><?php echo htmlspecialchars($user['agama']); ?></td>
                    <td><?php echo htmlspecialchars($user['hobi']); ?></td>
                    <td><?php echo htmlspecialchars($user['alamat']); ?></td>
                    <td>
                        <a href="/lab11_php_oop/index.php/user/ubah/<?php echo $user['id']; ?>" class="btn btn-warning" style="padding: 5px 15px; font-size: 12px;">✏️ Edit</a>
                        <a href="/lab11_php_oop/index.php/user/hapus/<?php echo $user['id']; ?>" class="btn btn-danger" style="padding: 5px 15px; font-size: 12px;" onclick="return confirm('Yakin ingin menghapus data ini?')">🗑️ Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <div class="alert alert-danger">
        ⚠️ Belum ada data user. <a href="/lab11_php_oop/index.php/user/tambah">Tambah data pertama</a>
    </div>
<?php endif; ?>

<div style="margin-top: 20px; padding: 15px; background: #e7f3ff; border-left: 4px solid #2196F3; border-radius: 5px;">
    <strong>📊 Total User:</strong> <?php echo count($users); ?> user
</div>