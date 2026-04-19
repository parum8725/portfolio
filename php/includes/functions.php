<?php
require_once __DIR__ . '/../config/config.php';

// Cek login — redirect ke login.php kalau belum (dipanggil dari /php/admin/ atau /php/crud/)
function require_login() {
    if (empty($_SESSION['user_id'])) {
        header('Location: ../login.php');
        exit;
    }
}

// Escape untuk output HTML
function e($str) {
    return htmlspecialchars((string)$str, ENT_QUOTES, 'UTF-8');
}

// Flash message
function flash_get() {
    if (!empty($_SESSION['flash'])) {
        $f = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $f;
    }
    return null;
}

function flash_set($message, $type = 'success') {
    $_SESSION['flash'] = ['message' => $message, 'type' => $type];
}

// Upload gambar — kembalikan nama file. Null jika tidak ada file diupload.
function upload_image($field_name, $old_file = null) {
    if (empty($_FILES[$field_name]) || $_FILES[$field_name]['error'] === UPLOAD_ERR_NO_FILE) {
        return null;
    }

    $file = $_FILES[$field_name];

    if ($file['error'] !== UPLOAD_ERR_OK) {
        throw new Exception('Upload gagal (kode error: ' . $file['error'] . ')');
    }
    if ($file['size'] > 5 * 1024 * 1024) {
        throw new Exception('Ukuran file maksimal 5 MB.');
    }

    $allowed_ext = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowed_ext, true)) {
        throw new Exception('Ekstensi tidak diperbolehkan. Gunakan: ' . implode(', ', $allowed_ext));
    }

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($file['tmp_name']);
    $allowed_mime = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    if (!in_array($mime, $allowed_mime, true)) {
        throw new Exception('Tipe file bukan gambar yang valid.');
    }

    if (!is_dir(UPLOAD_DIR)) {
        mkdir(UPLOAD_DIR, 0775, true);
    }

    $new_name = uniqid('img_', true) . '.' . $ext;
    $target = UPLOAD_DIR . $new_name;

    if (!move_uploaded_file($file['tmp_name'], $target)) {
        throw new Exception('Gagal memindahkan file ke folder tujuan.');
    }

    if ($old_file) {
        delete_image($old_file);
    }

    return $new_name;
}

// Hapus gambar dari UPLOAD_DIR (proteksi path traversal)
function delete_image($filename) {
    if (!$filename) return;
    $path = UPLOAD_DIR . $filename;
    $real_upload = realpath(UPLOAD_DIR);
    $real_path = realpath($path);
    if ($real_path && $real_upload && strpos($real_path, $real_upload) === 0 && is_file($real_path)) {
        @unlink($real_path);
    }
}

// Format tanggal
function fmt_date($datetime) {
    return date('d M Y H:i', strtotime($datetime));
}

// Hitung baris tabel
function count_rows($conn, $table) {
    $table = preg_replace('/[^a-zA-Z0-9_]/', '', $table);
    $res = $conn->query("SELECT COUNT(*) AS c FROM `$table`");
    return $res ? (int)$res->fetch_assoc()['c'] : 0;
}
