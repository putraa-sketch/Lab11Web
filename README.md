# Praktikum 11 - PHP OOP Lanjutan: Framework Modular


**Nama:** Abdi Putra Perdana

**NIM:** 312410426

**Kelas:** TI 24 A3  

**Mata Kuliah:** Pemrograman Web 1

---

## Deskripsi

Praktikum ini mengimplementasikan konsep **Framework Modular** dengan PHP OOP, mencakup:
- Modularisasi struktur folder
- Routing dengan `.htaccess`
- CRUD User dengan OOP
- Template system untuk layout
- Class Database dan Form yang reusable

---

## Struktur Folder

```
lab11_php_oop/
├── .htaccess              # URL Rewriting
├── config.php             # Konfigurasi database
├── index.php              # Router utama
├── class/                 # Library class
│   ├── Database.php       # Class database operations
│   └── Form.php           # Class form generator
├── module/                # Modul aplikasi
│   ├── home/
│   │   └── index.php      # Halaman home
│   └── user/
│       ├── list.php       # Tampil data user
│       ├── tambah.php     # Form tambah user
│       ├── ubah.php       # Form edit user
│       └── hapus.php      # Proses hapus user
└── template/              # Template layout
    ├── header.php         # Header
    └── footer.php         # Footer
```

---

## Langkah-Langkah Praktikum

### Persiapan Database

Buat tabel `users` di database `latihan1`:

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

### Konfigurasi File

**File: `config.php`**
```php
<?php
$config = [
    'host' => 'localhost',
    'username' => 'root',
    'password' => '',
    'db_name' => 'latihan1'
];
?>
```

### URL Rewriting dengan .htaccess

**File: `.htaccess`**
```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteBase /lab11_php_oop/
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^(.*)$ index.php/$1 [L]
</IfModule>
```

**Penjelasan:**
- `RewriteEngine On` → Mengaktifkan URL rewriting
- `RewriteBase` → Menentukan base folder project
- `RewriteCond` → Kondisi: jika bukan file/folder asli
- `RewriteRule` → Arahkan semua request ke `index.php`

### Router Utama (index.php)

Router berfungsi menangkap URL dan mengarahkan ke modul yang sesuai:

```
URL: localhost/lab11_php_oop/user/list
↓
Routing logic memecah:
- Module: user
- Page: list
↓
Load file: module/user/list.php
```

**Kode Router:**
```php
$path = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '/home/index';
$segments = explode('/', trim($path, '/'));
$mod = isset($segments[0]) ? $segments[0] : 'home';
$page = isset($segments[1]) ? $segments[1] : 'index';
$file = "module/{$mod}/{$page}.php";
```

### Class Database

Class `Database` menyediakan method untuk operasi database:
- `get()` → Ambil satu data
- `getAll()` → Ambil semua data
- `insert()` → Tambah data
- `update()` → Update data
- `delete()` → Hapus data

**Contoh Penggunaan:**
```php
$db = new Database();
$users = $db->getAll('users', null, 'id DESC');
```

### Class Form

Class `Form` untuk membuat form dinamis dengan berbagai tipe input:
- Text, Password
- Radio, Checkbox
- Select dropdown
- Textarea

**Contoh Penggunaan:**
```php
$form = new Form("", "Simpan Data");
$form->addField("nama", "Nama Lengkap");
$form->addField("jenis_kelamin", "Jenis Kelamin", "radio", [
    'L' => 'Laki-laki',
    'P' => 'Perempuan'
]);
$form->displayForm();
```

---

## Screenshot

### 1. Halaman Home
<img width="1656" height="1569" alt="image" src="https://github.com/user-attachments/assets/d76e7ab4-1f3a-497c-b572-4e40785aa64d" />

*Halaman utama dengan informasi fitur aplikasi*

### 2. Daftar User
<img width="1656" height="1068" alt="image" src="https://github.com/user-attachments/assets/6e6df694-8916-46f9-bf0a-98074d7ba394" />

*Menampilkan semua data user dalam bentuk tabel*

### 3. Form Tambah User
<img width="1656" height="1430" alt="image" src="https://github.com/user-attachments/assets/f7b2d31e-8863-45b4-ae22-01dbc8e822e4" />

*Form untuk menambah user baru dengan berbagai tipe input*

### 4. Form Edit User
<img width="1656" height="1417" alt="image" src="https://github.com/user-attachments/assets/5d025e34-1b2b-4ae4-bee5-e4e4bc7a7950" />

*Form untuk mengubah data user yang sudah ada*

### 5. Hapus User
<img width="1656" height="972" alt="image" src="https://github.com/user-attachments/assets/a876a507-a556-4778-ae91-06a291960a48" />

*Konfirmasi dan proses hapus data user*

---

## Fitur Utama

### CRUD Lengkap
- **Create:** Tambah user baru dengan form dinamis
- **Read:** Tampilkan semua data user
- **Update:** Edit data user yang sudah ada
- **Delete:** Hapus data user dengan konfirmasi

### Modularisasi
- Setiap fitur dipisah dalam folder modul
- Code mudah dikelola dan dikembangkan
- Reusable components (Database, Form)

### Routing Clean URL
```
Sebelum: index.php?page=user&action=list
Sesudah: /user/list
```

### Template System
- Header dan footer terpisah
- Konsisten di semua halaman
- Mudah dimodifikasi

---

## Konsep yang Dipelajari

1. **Modularisasi** → Memecah aplikasi jadi modul-modul kecil
2. **Routing** → Mengelola URL dengan clean dan SEO-friendly
3. **OOP** → Menggunakan class untuk code yang reusable
4. **MVC Pattern** → Pemisahan logic, view, dan data
5. **Template System** → Layout konsisten dengan header/footer terpisah

---

## Kesimpulan

Praktikum ini berhasil mengimplementasikan:
- Framework PHP sederhana dengan konsep modular
- Routing menggunakan `.htaccess` untuk clean URL
- CRUD operations dengan OOP (Class Database)
- Dynamic form generator (Class Form)
- Template system untuk layout yang konsisten

Framework ini bisa dikembangkan lebih lanjut dengan menambahkan:
- Authentication & Authorization
- Validation & Security
- Pagination
- Search & Filter
- Dan fitur-fitur lainnya

---

Project ini dibuat untuk keperluan pembelajaran Praktikum 11 - PHP OOP Lanjutan.
