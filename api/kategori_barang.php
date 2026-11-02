
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
                "SELECT * FROM kategori_barang WHERE id_kategori = ?"
            );

            mysqli_stmt_bind_param($stmt, "i", $id);
            mysqli_stmt_execute($stmt);
            $r = mysqli_stmt_get_result($stmt);

            $data = mysqli_fetch_assoc($r);

            if (!$data) {
                sendResponse(false, "Kategori tidak ditemukan", null, 404);
            }

            sendResponse(true, "berhasil", $data, 200);
        }

        if (isset($_GET['search'])) {
            $search = "%" . $_GET['search'] . "%";

            $stmt = mysqli_prepare($koneksi,
                "SELECT * FROM kategori_barang
                 WHERE nama_kategori LIKE ? OR kode_kategori LIKE ?
                 ORDER BY id_kategori DESC"
            );

            mysqli_stmt_bind_param($stmt, "ss", $search, $search);
            mysqli_stmt_execute($stmt);
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

            $q = "SELECT * FROM kategori_barang
                  ORDER BY id_kategori DESC
                  LIMIT $limit OFFSET $offset";

            $r = mysqli_query($koneksi, $q);

            $data = [];

            while ($row = mysqli_fetch_assoc($r)) {
                $data[] = $row;
            }

            sendResponse(true, "berhasil", $data, 200);
        }

        $q = "SELECT * FROM kategori_barang ORDER BY id_kategori DESC";
        $r = mysqli_query($koneksi, $q);

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
            !isset($input['nama_kategori']) ||
            !isset($input['kode_kategori']) ||
            !isset($input['deskripsi']) ||
            !isset($input['tanggal_dibuat'])
        ) {
            sendResponse(false, "Semua field wajib diisi", null, 400);
        }

        $nama = trim($input['nama_kategori']);
        $kode = trim($input['kode_kategori']);
        $deskripsi = $input['deskripsi'];
        $tanggal = $input['tanggal_dibuat'];

        $stmt = mysqli_prepare($koneksi,
            "SELECT id_kategori FROM kategori_barang WHERE kode_kategori = ?"
        );

        mysqli_stmt_bind_param($stmt, "s", $kode);
        mysqli_stmt_execute($stmt);
        $cek = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($cek) > 0) {
            sendResponse(false, "Kode kategori sudah digunakan", null, 409);
        }

        $stmt = mysqli_prepare($koneksi,
            "INSERT INTO kategori_barang
             (nama_kategori, kode_kategori, deskripsi, tanggal_dibuat)
             VALUES (?, ?, ?, ?)"
        );

        mysqli_stmt_bind_param($stmt, "ssss",
            $nama, $kode, $deskripsi, $tanggal
        );

        if (mysqli_stmt_execute($stmt)) {
            sendResponse(true, "Kategori berhasil ditambahkan",
                ["id" => mysqli_insert_id($koneksi)], 201);
        } else {
            sendResponse(false, "Gagal menambahkan kategori", null, 500);
        }

        break;

    case 'PUT':

        $id = (int) ($_GET['id'] ?? 0);
        $input = json_decode(file_get_contents("php://input"), true);

        if ($id <= 0) {
            sendResponse(false, "ID kategori wajib diisi", null, 400);
        }

        if (
            !$input ||
            !isset($input['nama_kategori']) ||
            !isset($input['kode_kategori']) ||
            !isset($input['deskripsi']) ||
            !isset($input['tanggal_dibuat'])
        ) {
            sendResponse(false, "Semua field wajib diisi", null, 400);
        }

        $stmt = mysqli_prepare($koneksi,
            "SELECT id_kategori FROM kategori_barang WHERE id_kategori = ?"
        );

        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);

        if (mysqli_num_rows(mysqli_stmt_get_result($stmt)) == 0) {
            sendResponse(false, "Kategori tidak ditemukan", null, 404);
        }

        $nama = trim($input['nama_kategori']);
        $kode = trim($input['kode_kategori']);
        $deskripsi = $input['deskripsi'];
        $tanggal = $input['tanggal_dibuat'];

        $stmt = mysqli_prepare($koneksi,
            "SELECT id_kategori FROM kategori_barang
             WHERE kode_kategori = ? AND id_kategori != ?"
        );

        mysqli_stmt_bind_param($stmt, "si", $kode, $id);
        mysqli_stmt_execute($stmt);

        if (mysqli_num_rows(mysqli_stmt_get_result($stmt)) > 0) {
            sendResponse(false, "Kode kategori sudah digunakan", null, 409);
        }

        $stmt = mysqli_prepare($koneksi,
            "UPDATE kategori_barang
             SET nama_kategori = ?, kode_kategori = ?,
                 deskripsi = ?, tanggal_dibuat = ?
             WHERE id_kategori = ?"
        );

        mysqli_stmt_bind_param($stmt, "ssssi",
            $nama, $kode, $deskripsi, $tanggal, $id
        );

        if (mysqli_stmt_execute($stmt)) {
            sendResponse(true, "Kategori berhasil diperbarui", ["id" => $id], 200);
        } else {
            sendResponse(false, "Gagal memperbarui kategori", null, 500);
        }

        break;

    case 'DELETE':

        $id = (int) ($_GET['id'] ?? 0);

        if ($id <= 0) {
            sendResponse(false, "ID kategori wajib diisi", null, 400);
        }

        $stmt = mysqli_prepare($koneksi,
            "DELETE FROM kategori_barang WHERE id_kategori = ?"
        );

        mysqli_stmt_bind_param($stmt, "i", $id);

        if (mysqli_stmt_execute($stmt)) {
            if (mysqli_stmt_affected_rows($stmt) == 0) {
                sendResponse(false, "Kategori tidak ditemukan", null, 404);
            }

            sendResponse(true, "Kategori berhasil dihapus", ["id" => $id], 200);
        } else {
            sendResponse(false,
                "Kategori tidak dapat dihapus karena masih digunakan oleh barang",
                null, 409);
        }

        break;

    default:
        sendResponse(false, "Method tidak diizinkan", null, 405);
        break;
}

?>
