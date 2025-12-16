# Praktikum 11 & 12 - PHP OOP Framework dengan Autentikasi

**Nama:** Abdi Putra Perdana  
**NIM:** 312410426  
**Kelas:** TI 24 A3  
**Mata Kuliah:** Pemrograman Web 1

---

## Deskripsi

Praktikum ini mengimplementasikan:
- **Praktikum 11:** Framework Modular dengan PHP OOP
- **Praktikum 12:** Sistem Autentikasi & Session Management

### Fitur Utama:
- Modularisasi struktur folder
- Routing dengan `.htaccess`
- CRUD User dengan OOP
- **Autentikasi Login/Logout**
- **Session Management**
- **Middleware untuk proteksi halaman**
- **Ubah Password dengan enkripsi**
- Template system untuk layout

---

## Langkah-Langkah Praktikum

### 1️Persiapan Database

**Tabel untuk CRUD User (Praktikum 11):**
```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    pass VARCHAR(100) NOT NULL,
    jenis_kelamin ENUM('L', 'P') NOT NULL,
    agama VARCHAR(50) NOT NULL,
    hobi TEXT,
    alamat TEXT NOT NULL
);
```

**Tabel untuk Autentikasi (Praktikum 12):**
```sql
CREATE TABLE admin_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    nama VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert user admin (password: admin123)
INSERT INTO admin_users (username, password, nama) VALUES 
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrator');
```

### Cara Login

**Demo Account:**
- Username: `admin`
- Password: `admin123`

### Alur Autentikasi

```
User belum login → Akses halaman protected
    ↓
Redirect ke /auth/login
    ↓
Input username & password
    ↓
Verifikasi dengan password_verify()
    ↓
Jika valid: Set Session → Redirect ke dashboard
Jika invalid: Tampilkan error
```

### Middleware Protection

Router (`index.php`) mengecek setiap request:
```php
// Halaman public (tanpa login)
$public_modules = ['home', 'auth'];

// Halaman protected (butuh login)
if (!in_array($mod, $public_modules)) {
    if (!isset($_SESSION['is_login'])) {
        header('Location: /auth/login');
        exit();
    }
}
```

---

## Screenshot

### Praktikum 11: CRUD User

#### 1. Halaman Home
![Cuplikan layar_9-12-2025_113916_localhost](https://github.com/user-attachments/assets/6dc5b238-10b1-4de4-8097-6692dd080102)

*Halaman utama dengan informasi fitur*

#### 2. Daftar User
![Cuplikan layar_9-12-2025_114445_localhost](https://github.com/user-attachments/assets/ab43605f-d26a-42e2-ad5d-a2f6bcf7a3fc)


*Menampilkan semua data user*

#### 3. Form Tambah User
![Cuplikan layar_9-12-2025_114516_localhost](https://github.com/user-attachments/assets/554e1f25-1baf-4e8b-ac0b-078841b2c76e)

*Form input user baru*

#### 4. Form Edit User
![Cuplikan layar_9-12-2025_114546_localhost](https://github.com/user-attachments/assets/4a04f9a6-593d-419e-ba56-5e7122b4a200)


*Form edit data user*

#### 5. Hapus User
![Cuplikan layar_9-12-2025_114821_localhost](https://github.com/user-attachments/assets/6b9be6aa-d413-4bd7-9592-c7141b920ebd)

*Konfirmasi hapus data*

### Praktikum 12: Autentikasi

#### 6. Halaman Login
<img width="1656" height="915" alt="image" src="https://github.com/user-attachments/assets/c4a6e7af-a719-4842-b2ae-c0cbdaacf721" />

*Form login dengan validasi*

#### 7. Dashboard (Setelah Login)
<img width="1656" height="969" alt="image" src="https://github.com/user-attachments/assets/7f6fb5f8-ac16-4a73-a111-562702d067ee" />

*Menu berubah sesuai status login*

#### 8. Halaman Profil
<img width="1656" height="1540" alt="image" src="https://github.com/user-attachments/assets/ca38449a-7347-44df-a045-ea9567577c50" />

*Update nama dan ubah password*

#### 9. Protected Page
<img width="1656" height="915" alt="image" src="https://github.com/user-attachments/assets/4cb9d588-7161-477a-b1ac-2fb035e19998" />

*Ketika user mencoba akses halaman protected tanpa login, otomatis redirect ke halaman login*

---

## Fitur Praktikum 12

### Autentikasi
- Login dengan username & password
- Password di-hash menggunakan `password_hash()`
- Verifikasi dengan `password_verify()`
- Session management untuk tracking user

### Middleware Protection
- Halaman tertentu hanya bisa diakses jika sudah login
- Auto redirect ke login jika belum authenticated
- Public pages: Home, Login
- Protected pages: User CRUD, Profile

### Session Management
```php
$_SESSION['is_login'] = true;
$_SESSION['user_id'] = $user['id'];
$_SESSION['username'] = $user['username'];
$_SESSION['nama'] = $user['nama'];
```

### Dynamic Menu
- Menu berubah berdasarkan status login
- Tampilkan nama user yang sedang login
- Tombol logout dengan konfirmasi

### Profil & Ubah Password (TUGAS)
- Update nama pengguna
- Ubah password dengan validasi:
  - Cek password lama
  - Password baru minimal 6 karakter
  - Konfirmasi password baru
  - Hash password dengan `password_hash()`

---

## Keamanan

### Password Hashing
```php
// Saat registrasi/ubah password
$hashed = password_hash($password, PASSWORD_DEFAULT);

// Saat login
if (password_verify($input_password, $hashed_from_db)) {
    // Login sukses
}
```

### SQL Injection Prevention
```php
$username = $db->escape($_POST['username']);
```

### Session Security
- Session dimulai di awal request
- Session dihapus saat logout
- Validasi session di setiap halaman protected



## Konsep yang Dipelajari

### Praktikum 11:
1. **Modularisasi** → Struktur folder terorganisir
2. **Routing** → Clean URL dengan `.htaccess`
3. **OOP** → Class reusable (Database, Form)
4. **MVC Pattern** → Pemisahan concern

### Praktikum 12:
1. **Autentikasi** → Login/Logout system
2. **Session Management** → Tracking user state
3. **Password Hashing** → Keamanan password
4. **Middleware** → Proteksi halaman
5. **Authorization** → Akses control berdasarkan login

---

## Cara Menjalankan

1. **Clone/Download** project ke `htdocs`
2. **Import database:**
   - Buat database `latihan1`
   - Jalankan SQL untuk tabel `users` dan `admin_users`
3. **Konfigurasi** `config.php` sesuai database
4. **Akses:** `http://localhost/lab11_php_oop`
5. **Login:**
   - Username: `admin`
   - Password: `admin123`

---

## Kesimpulan

Praktikum ini berhasil mengimplementasikan:
- Framework modular PHP dengan routing
- CRUD operations dengan OOP
- Sistem autentikasi lengkap
- Session management
- Password hashing untuk keamanan
- Middleware untuk proteksi halaman
- Dynamic menu berdasarkan auth status

---
