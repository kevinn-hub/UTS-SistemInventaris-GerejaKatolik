
<?php

require_once "../config.php";
require_once "../helpers/response.php";

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {

    case 'GET':

        if (isset($_GET['id'])) {
            $id = (int) $_GET['id'];

            if ($id <= 0) {
                sendResponse(false, "ID tidak valid", null, 400);
            }

            $stmt = mysqli_prepare($koneksi,
                "SELECT b.*, k.nama_kategori, l.nama_lokasi
                FROM barang b
                LEFT JOIN kategori_barang k ON b.id_kategori = k.id_kategori
                LEFT JOIN lokasi l ON b.id_lokasi = l.id_lokasi
                WHERE b.id_barang = ?"
            );

            if (!$stmt) {
                error_log(mysqli_error($koneksi));
                sendResponse(false, "Terjadi kesalahan pada server", null, 500);
            }

            mysqli_stmt_bind_param($stmt, "i", $id);

            if (!mysqli_stmt_execute($stmt)) {
                error_log(mysqli_stmt_error($stmt));
                sendResponse(false, "Terjadi kesalahan pada server", null, 500);
            }

            $r = mysqli_stmt_get_result($stmt);
            $data = mysqli_fetch_assoc($r);

            if (!$data) {
                sendResponse(false, "Barang tidak ditemukan", null, 404);
            }

            sendResponse(true, "berhasil", $data, 200);
        }

        if (isset($_GET['search'])) {
            $search = "%" . $_GET['search'] . "%";

            $stmt = mysqli_prepare($koneksi,
                "SELECT b.*, k.nama_kategori, l.nama_lokasi
                FROM barang b
                LEFT JOIN kategori_barang k ON b.id_kategori = k.id_kategori
                LEFT JOIN lokasi l ON b.id_lokasi = l.id_lokasi
                WHERE b.nama_barang LIKE ?
                OR b.kode_barang LIKE ?
                OR k.nama_kategori LIKE ?
                OR l.nama_lokasi LIKE ?
                ORDER BY b.id_barang DESC"
            );

            if (!$stmt) {
                error_log(mysqli_error($koneksi));
                sendResponse(false, "Terjadi kesalahan pada server", null, 500);
            }

            mysqli_stmt_bind_param($stmt, "ssss",
                $search, $search, $search, $search
            );

            if (!mysqli_stmt_execute($stmt)) {
                error_log(mysqli_stmt_error($stmt));
                sendResponse(false, "Terjadi kesalahan pada server", null, 500);
            }

            $r = mysqli_stmt_get_result($stmt);
            $data = [];

            while ($row = mysqli_fetch_assoc($r)) {
                $data[] = $row;
            }

            sendResponse(true, "berhasil", $data, 200);
        }

        if (isset($_GET['page']) || isset($_GET['limit'])) {
            $page = max(1, (int) ($_GET['page'] ?? 1));
            $limit = max(1, (int) ($_GET['limit'] ?? 10));
            $offset = ($page - 1) * $limit;

            $stmt = mysqli_prepare($koneksi,
                "SELECT b.*, k.nama_kategori, l.nama_lokasi
                FROM barang b
                LEFT JOIN kategori_barang k ON b.id_kategori = k.id_kategori
                LEFT JOIN lokasi l ON b.id_lokasi = l.id_lokasi
                ORDER BY b.id_barang DESC
                LIMIT ? OFFSET ?"
            );

            if (!$stmt) {
                error_log(mysqli_error($koneksi));
                sendResponse(false, "Terjadi kesalahan pada server", null, 500);
            }

            mysqli_stmt_bind_param($stmt, "ii", $limit, $offset);

            if (!mysqli_stmt_execute($stmt)) {
                error_log(mysqli_stmt_error($stmt));
                sendResponse(false, "Terjadi kesalahan pada server", null, 500);
            }

            $r = mysqli_stmt_get_result($stmt);
            $data = [];

            while ($row = mysqli_fetch_assoc($r)) {
                $data[] = $row;
            }

            sendResponse(true, "berhasil", $data, 200);
        }

        $stmt = mysqli_prepare($koneksi,
            "SELECT b.*, k.nama_kategori, l.nama_lokasi
            FROM barang b
            LEFT JOIN kategori_barang k ON b.id_kategori = k.id_kategori
            LEFT JOIN lokasi l ON b.id_lokasi = l.id_lokasi
            ORDER BY b.id_barang DESC"
        );

        if (!$stmt) {
            error_log(mysqli_error($koneksi));
            sendResponse(false, "Terjadi kesalahan pada server", null, 500);
        }

        if (!mysqli_stmt_execute($stmt)) {
            error_log(mysqli_stmt_error($stmt));
            sendResponse(false, "Terjadi kesalahan pada server", null, 500);
        }

        $r = mysqli_stmt_get_result($stmt);
        $data = [];

        while ($row = mysqli_fetch_assoc($r)) {
            $data[] = $row;
        }

        sendResponse(true, "berhasil", $data, 200);

        break;

    case 'POST':

        $input = json_decode(file_get_contents("php://input"), true);

        if (
            !$input ||
            !isset($input['kode_barang']) ||
            !isset($input['id_kategori']) ||
            !isset($input['id_lokasi']) ||
            !isset($input['nama_barang']) ||
            !isset($input['jumlah']) ||
            !isset($input['kondisi'])
        ) {
            sendResponse(false, "Semua field wajib diisi", null, 400);
        }

        $kode = trim($input['kode_barang']);
        $id_kategori = (int) $input['id_kategori'];
        $id_lokasi = (int) $input['id_lokasi'];
        $nama = trim($input['nama_barang']);
        $jumlah = (int) $input['jumlah'];
        $kondisi = trim($input['kondisi']);

        if ($id_kategori <= 0 || $id_lokasi <= 0 || $jumlah < 0) {
            sendResponse(false, "Data tidak valid", null, 400);
        }

        $stmt = mysqli_prepare($koneksi,
            "SELECT id_barang FROM barang WHERE kode_barang = ?"
        );

        if (!$stmt) {
            error_log(mysqli_error($koneksi));
            sendResponse(false, "Terjadi kesalahan pada server", null, 500);
        }

        mysqli_stmt_bind_param($stmt, "s", $kode);

        if (!mysqli_stmt_execute($stmt)) {
            error_log(mysqli_stmt_error($stmt));
            sendResponse(false, "Terjadi kesalahan pada server", null, 500);
        }

        $cek = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($cek) > 0) {
            sendResponse(false, "Kode barang sudah digunakan", null, 409);
        }

        $stmt = mysqli_prepare($koneksi,
            "SELECT id_kategori FROM kategori_barang WHERE id_kategori = ?"
        );

        if (!$stmt) {
            error_log(mysqli_error($koneksi));
            sendResponse(false, "Terjadi kesalahan pada server", null, 500);
        }

        mysqli_stmt_bind_param($stmt, "i", $id_kategori);

        if (!mysqli_stmt_execute($stmt)) {
            error_log(mysqli_stmt_error($stmt));
            sendResponse(false, "Terjadi kesalahan pada server", null, 500);
        }

        if (mysqli_num_rows(mysqli_stmt_get_result($stmt)) == 0) {
            sendResponse(false, "Kategori tidak ditemukan", null, 404);
        }

        $stmt = mysqli_prepare($koneksi,
            "SELECT id_lokasi FROM lokasi WHERE id_lokasi = ?"
        );

        if (!$stmt) {
            error_log(mysqli_error($koneksi));
            sendResponse(false, "Terjadi kesalahan pada server", null, 500);
        }

        mysqli_stmt_bind_param($stmt, "i", $id_lokasi);

        if (!mysqli_stmt_execute($stmt)) {
            error_log(mysqli_stmt_error($stmt));
            sendResponse(false, "Terjadi kesalahan pada server", null, 500);
        }

        if (mysqli_num_rows(mysqli_stmt_get_result($stmt)) == 0) {
            sendResponse(false, "Lokasi tidak ditemukan", null, 404);
        }

        $stmt = mysqli_prepare($koneksi,
            "INSERT INTO barang
            (kode_barang, id_kategori, id_lokasi, nama_barang, jumlah, kondisi)
            VALUES (?, ?, ?, ?, ?, ?)"
        );

        if (!$stmt) {
            error_log(mysqli_error($koneksi));
            sendResponse(false, "Terjadi kesalahan pada server", null, 500);
        }

        mysqli_stmt_bind_param($stmt, "siisis",
            $kode, $id_kategori, $id_lokasi, $nama, $jumlah, $kondisi
        );

        if (mysqli_stmt_execute($stmt)) {
            sendResponse(true, "Barang berhasil ditambahkan",
                ["id" => mysqli_insert_id($koneksi)], 201);
        } else {
            error_log(mysqli_stmt_error($stmt));
            sendResponse(false, "Terjadi kesalahan pada server", null, 500);
        }

        break;

    case 'PUT':

        $id = (int) ($_GET['id'] ?? 0);
        $input = json_decode(file_get_contents("php://input"), true);

        if ($id <= 0) {
            sendResponse(false, "ID barang wajib diisi", null, 400);
        }

        if (
            !$input ||
            !isset($input['kode_barang']) ||
            !isset($input['id_kategori']) ||
            !isset($input['id_lokasi']) ||
            !isset($input['nama_barang']) ||
            !isset($input['jumlah']) ||
            !isset($input['kondisi'])
        ) {
            sendResponse(false, "Semua field wajib diisi", null, 400);
        }

        $kode = trim($input['kode_barang']);
        $id_kategori = (int) $input['id_kategori'];
        $id_lokasi = (int) $input['id_lokasi'];
        $nama = trim($input['nama_barang']);
        $jumlah = (int) $input['jumlah'];
        $kondisi = trim($input['kondisi']);

        if ($id_kategori <= 0 || $id_lokasi <= 0 || $jumlah < 0) {
            sendResponse(false, "Data tidak valid", null, 400);
        }

        $stmt = mysqli_prepare($koneksi,
            "SELECT id_barang FROM barang WHERE id_barang = ?"
        );

        if (!$stmt) {
            error_log(mysqli_error($koneksi));
            sendResponse(false, "Terjadi kesalahan pada server", null, 500);
        }

        mysqli_stmt_bind_param($stmt, "i", $id);

        if (!mysqli_stmt_execute($stmt)) {
            error_log(mysqli_stmt_error($stmt));
            sendResponse(false, "Terjadi kesalahan pada server", null, 500);
        }

        if (mysqli_num_rows(mysqli_stmt_get_result($stmt)) == 0) {
            sendResponse(false, "Barang tidak ditemukan", null, 404);
        }

        $stmt = mysqli_prepare($koneksi,
            "SELECT id_barang FROM barang
            WHERE kode_barang = ? AND id_barang != ?"
        );

        if (!$stmt) {
            error_log(mysqli_error($koneksi));
            sendResponse(false, "Terjadi kesalahan pada server", null, 500);
        }

        mysqli_stmt_bind_param($stmt, "si", $kode, $id);

        if (!mysqli_stmt_execute($stmt)) {
            error_log(mysqli_stmt_error($stmt));
            sendResponse(false, "Terjadi kesalahan pada server", null, 500);
        }

        if (mysqli_num_rows(mysqli_stmt_get_result($stmt)) > 0) {
            sendResponse(false, "Kode barang sudah digunakan", null, 409);
        }

        $stmt = mysqli_prepare($koneksi,
            "SELECT id_kategori FROM kategori_barang WHERE id_kategori = ?"
        );

        if (!$stmt) {
            error_log(mysqli_error($koneksi));
            sendResponse(false, "Terjadi kesalahan pada server", null, 500);
        }

        mysqli_stmt_bind_param($stmt, "i", $id_kategori);

        if (!mysqli_stmt_execute($stmt)) {
            error_log(mysqli_stmt_error($stmt));
            sendResponse(false, "Terjadi kesalahan pada server", null, 500);
        }

        if (mysqli_num_rows(mysqli_stmt_get_result($stmt)) == 0) {
            sendResponse(false, "Kategori tidak ditemukan", null, 404);
        }

        $stmt = mysqli_prepare($koneksi,
            "SELECT id_lokasi FROM lokasi WHERE id_lokasi = ?"
        );

        if (!$stmt) {
            error_log(mysqli_error($koneksi));
            sendResponse(false, "Terjadi kesalahan pada server", null, 500);
        }

        mysqli_stmt_bind_param($stmt, "i", $id_lokasi);

        if (!mysqli_stmt_execute($stmt)) {
            error_log(mysqli_stmt_error($stmt));
            sendResponse(false, "Terjadi kesalahan pada server", null, 500);
        }

        if (mysqli_num_rows(mysqli_stmt_get_result($stmt)) == 0) {
            sendResponse(false, "Lokasi tidak ditemukan", null, 404);
        }

        $stmt = mysqli_prepare($koneksi,
            "UPDATE barang
            SET kode_barang = ?, id_kategori = ?, id_lokasi = ?,
                nama_barang = ?, jumlah = ?, kondisi = ?
            WHERE id_barang = ?"
        );

        if (!$stmt) {
            error_log(mysqli_error($koneksi));
            sendResponse(false, "Terjadi kesalahan pada server", null, 500);
        }

        mysqli_stmt_bind_param($stmt, "siisisi",
            $kode, $id_kategori, $id_lokasi, $nama, $jumlah, $kondisi, $id
        );

        if (mysqli_stmt_execute($stmt)) {
            if (mysqli_stmt_affected_rows($stmt) == 0) {
                sendResponse(true, "Tidak ada perubahan data", ["id" => $id], 200);
            }

            sendResponse(true, "Barang berhasil diperbarui", ["id" => $id], 200);
        } else {
            error_log(mysqli_stmt_error($stmt));
            sendResponse(false, "Terjadi kesalahan pada server", null, 500);
        }

        break;

    case 'DELETE':

        $id = (int) ($_GET['id'] ?? 0);

        if ($id <= 0) {
            sendResponse(false, "ID barang wajib diisi", null, 400);
        }

        $stmt = mysqli_prepare($koneksi,
            "DELETE FROM barang WHERE id_barang = ?"
        );

        if (!$stmt) {
            error_log(mysqli_error($koneksi));
            sendResponse(false, "Terjadi kesalahan pada server", null, 500);
        }

        mysqli_stmt_bind_param($stmt, "i", $id);

        if (mysqli_stmt_execute($stmt)) {
            if (mysqli_stmt_affected_rows($stmt) == 0) {
                sendResponse(false, "Barang tidak ditemukan", null, 404);
            }

            sendResponse(true, "Barang berhasil dihapus", ["id" => $id], 200);
        } else {
            error_log(mysqli_stmt_error($stmt));
            sendResponse(false, "Terjadi kesalahan pada server", null, 500);
        }

        break;

    default:
        sendResponse(false, "Method tidak diizinkan", null, 405);
        break;
}

?>
