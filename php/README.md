## Langkah Set Up Database (step by step)

Ikuti langkah berikut **sebelum** membuka halaman web-nya:

1. **Taruh folder project di htdocs**
   Pastikan folder `portfolio/` berada di dalam:
   - Windows (XAMPP): `C:\xampp\htdocs\portfolio\`

2. **Nyalakan Apache & MySQL**
   Buka XAMPP Control Panel → klik **Start** pada Apache dan MySQL.

3. **Buka phpMyAdmin**
   Di browser, akses:
   ```
   http://localhost/phpmyadmin
   ```

4. **Buat database baru dengan nama `portfolio_db`**
   - Di panel kiri phpMyAdmin, klik **New**.
   - Isi nama database: `portfolio_db`
   - Collation: `utf8mb4_unicode_ci` (opsional, sudah default di file SQL)
   - Klik tombol **Create**.

5. **Masuk ke database `portfolio_db`**
   Setelah dibuat, klik nama `portfolio_db` di sidebar kiri supaya kamu
   berada **di dalam** database itu (jangan di root MySQL).

6. **Import file `database.sql`**
   - Klik tab **Import** di bagian atas.
   - Pada "File to import", klik **Choose File / Pilih File**.
   - Pilih file:
     ```
     /opt/lampp/htdocs/portfolio/php/database.sql
     ```
   - Biarkan opsi lainnya default.
   - Klik tombol **Go / Kirim** di pojok kanan bawah.

7. **Verifikasi tabel sudah masuk**
   Di sidebar `portfolio_db` harus muncul tabel:
   `about`, `messages`, `organizations`, `profile`, `projects`, `users`.

8. **Buat akun admin lewat `install.php`**
   Akses:
   ```
   http://localhost/portfolio/php/install.php
   ```
   Isi form username & password, lalu klik **Buat Akun Admin**.

9. **Login dan mulai kelola portfolio**
   - Login admin: `http://localhost/portfolio/php/login.php`
   - Halaman publik: `http://localhost/portfolio/php/index.php`

> **Penting:** setelah akun admin berhasil dibuat, **hapus atau rename**
> `install.php` supaya tidak bisa diakses pengunjung lain.

Website portfolio dinamis berbasis **PHP native + MySQL**. Semua isi portfolio
(profil, about, organisasi, projects, pesan masuk) bisa diedit lewat halaman
admin — tidak perlu ngoprek HTML.

## Struktur Folder

```
php/
├── index.php            ← Tampilan portfolio untuk pengunjung
├── login.php            ← Form login admin
├── logout.php           ← Menghapus session
├── install.php          ← Dibuka sekali untuk membuat akun admin pertama
├── database.sql         ← Struktur tabel MySQL (di-import lewat phpMyAdmin)
├── style.css            ← CSS halaman portfolio publik
├── README.md
│
├── admin/        (halaman yang dibuka admin di browser)
├── crud/         (proses simpan/update/hapus dari form)
├── config/       (konfigurasi database)
├── includes/     (file pembantu: layout & fungsi)
├── assets/       (CSS khusus halaman admin)
└── img/          (tempat gambar upload disimpan)
```

### Penjelasan tiap folder

#### `admin/` — Halaman pengelola (yang dibuka admin di browser)
Tempat semua halaman yang **ditampilkan** ke admin setelah login. Satu file =
satu halaman. Biasanya berisi kode untuk mengambil data dari database lalu
menampilkannya sebagai tabel atau form.

| File | Fungsi |
|------|--------|
| `dashboard.php` | Ringkasan jumlah data + pesan terbaru |
| `profile.php` | Form edit data diri (nama, subtitle, foto, sosmed) |
| `about.php` | Form edit teks bagian "About Me" |
| `organizations.php` | Daftar pengalaman organisasi |
| `organization_form.php` | Form tambah/edit organisasi |
| `projects.php` | Daftar projects & sertifikat |
| `project_form.php` | Form tambah/edit project (termasuk upload gambar) |
| `messages.php` | Daftar pesan yang masuk dari form kontak |

> Analogi sederhana: folder ini ibarat "tampilan kasir" — menampilkan barang,
> tapi tidak mengurus penyimpanan stok.

#### `crud/` — Proses Create, Update, Delete
Folder ini berisi file yang **tidak punya tampilan**. Tugasnya cuma satu:
menerima data dari form di `admin/`, menyimpan ke database, lalu mengarahkan
(redirect) balik ke halaman admin.

| File | Fungsi |
|------|--------|
| `profile_save.php` | Menyimpan perubahan profil (termasuk upload foto) |
| `about_save.php` | Menyimpan teks About |
| `organization_save.php` | Menyimpan (insert atau update) organisasi |
| `organization_delete.php` | Menghapus organisasi |
| `project_save.php` | Menyimpan project + menangani upload gambar |
| `project_delete.php` | Menghapus project dan file gambarnya |
| `message_mark_read.php` | Menandai pesan sudah dibaca |
| `message_delete.php` | Menghapus pesan |
| `contact_process.php` | Menerima submit dari form kontak di halaman publik |

> Alur umum: form di `admin/xxx_form.php` → submit ke `crud/xxx_save.php` →
> redirect kembali ke `admin/xxx.php`.

#### `config/` — Konfigurasi sistem
Isinya pengaturan yang dipakai seluruh aplikasi. Di-load (dipanggil) di awal
setiap halaman.

| File | Fungsi |
|------|--------|
| `config.php` | Koneksi ke MySQL + konstanta path upload gambar |

Kalau database kamu pakai username/password berbeda, edit file ini saja.

#### `includes/` — Layout & fungsi bantu
File yang di-`require` (dipakai bersama) dari banyak halaman, supaya tidak
perlu nulis ulang kode yang sama.

| File | Fungsi |
|------|--------|
| `header.php` | Bagian atas halaman admin (navbar, menu) |
| `footer.php` | Bagian bawah halaman admin (copyright, script JS) |
| `functions.php` | Kumpulan fungsi: cek login, upload gambar, escape HTML, flash message |

> Analogi: `header.php` + `footer.php` ibarat "bingkai foto" — tiap halaman
> admin tinggal mengisi bagian tengahnya saja.

#### `assets/` — File statis untuk admin
Khusus menyimpan CSS (dan ke depan bisa JS/gambar dekorasi) yang dipakai
halaman admin.

| File | Fungsi |
|------|--------|
| `admin_style.css` | Styling halaman admin (navbar plum, card, tabel, dll.) |

Berbeda dengan `style.css` di root `php/` yang dipakai halaman publik
(`index.php`), file di `assets/` hanya untuk halaman admin.

#### `img/` — Tempat gambar upload
Setiap gambar yang diunggah admin (foto profil, gambar project, sertifikat)
disimpan di sini dengan nama file yang diacak secara otomatis supaya tidak
bentrok.

> Di database hanya disimpan **nama filenya** (misal `abc123.jpg`), bukan
> seluruh isi gambar. Saat ditampilkan, PHP menggabungkan `img/` + nama file.

Folder ini harus **writable** (bisa ditulis oleh Apache/PHP). Kalau upload
gagal, jalankan: `chmod -R 775 img/`.

## Cara Pasang (XAMPP)

1. Taruh folder `portfolio/` di:
   - Windows: `C:\xampp\htdocs\`
2. Nyalakan **Apache** dan **MySQL** lewat XAMPP Control Panel.
3. Buka `http://localhost/phpmyadmin` → klik tab **Import** → pilih
   `portfolio/php/database.sql` → klik **Go**.
4. Buka `http://localhost/portfolio/php/install.php` → isi form untuk membuat
   akun admin (username & password bebas).
5. Buka `http://localhost/portfolio/php/login.php` → login pakai akun tadi.
6. **Penting:** setelah instalasi sukses, hapus atau rename `install.php`
   supaya tidak bisa diakses orang lain.

## URL Utama

| Halaman              | URL                                                  |
|----------------------|------------------------------------------------------|
| Portfolio publik     | `http://localhost/portfolio/php/index.php`           |
| Login Admin          | `http://localhost/portfolio/php/login.php`           |
| Admin Dashboard      | `http://localhost/portfolio/php/admin/dashboard.php` |

## Fitur

- **Profile** — edit foto, nama, subtitle, brand, sosmed, teks footer.
- **About** — edit paragraf "About Me" (multi paragraf, pisahkan dengan baris kosong).
- **Organizations** — tambah/edit/hapus pengalaman organisasi (daftar bullet).
- **Projects & Certificates** — tambah/edit/hapus + upload gambar (gambar
  lama otomatis dihapus saat diganti atau datanya dihapus).
- **Messages** — baca pesan dari form kontak publik, tandai dibaca, hapus.

## Keamanan

- Password disimpan dalam bentuk hash bcrypt (`password_hash` + `password_verify`).
- Semua query database pakai **prepared statement** → aman dari SQL injection.
- Upload gambar divalidasi ekstensi + MIME type, maksimal 5 MB.
- Semua output dari database di-escape pakai `htmlspecialchars` → aman dari XSS.
- Proteksi **path traversal** saat menghapus file gambar.
- Session di-regenerate setiap kali login berhasil.

## Konfigurasi Database

Buka `config/config.php` lalu sesuaikan kalau kredensial MySQL-mu berbeda:

```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'portfolio_db');
```
