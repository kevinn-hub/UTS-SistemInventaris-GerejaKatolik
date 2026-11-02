
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
                "SELECT * FROM lokasi WHERE id_lokasi = ?"
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

            $result = mysqli_stmt_get_result($stmt);
            $data = mysqli_fetch_assoc($result);

            if (!$data) {
                sendResponse(false, "Lokasi tidak ditemukan", null, 404);
            }

            sendResponse(true, "berhasil", $data);

        } elseif (isset($_GET['search'])) {

            $search = "%" . $_GET['search'] . "%";

            $stmt = mysqli_prepare($koneksi,
                "SELECT * FROM lokasi
                 WHERE nama_lokasi LIKE ?
                 OR kode_lokasi LIKE ?
                 OR penanggung_jawab LIKE ?
                 ORDER BY id_lokasi DESC"
            );

            if (!$stmt) {
                error_log(mysqli_error($koneksi));
                sendResponse(false, "Terjadi kesalahan pada server", null, 500);
            }

            mysqli_stmt_bind_param($stmt, "sss", $search, $search, $search);

            if (!mysqli_stmt_execute($stmt)) {
                error_log(mysqli_stmt_error($stmt));
                sendResponse(false, "Terjadi kesalahan pada server", null, 500);
            }

            $result = mysqli_stmt_get_result($stmt);
            $data = [];

            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }

            sendResponse(true, "berhasil", $data);

        } elseif (isset($_GET['page']) && isset($_GET['limit'])) {

            $page = max(1, (int) $_GET['page']);
            $limit = max(1, (int) $_GET['limit']);
            $offset = ($page - 1) * $limit;

            $stmt = mysqli_prepare($koneksi,
                "SELECT * FROM lokasi
                 ORDER BY id_lokasi DESC
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

            $result = mysqli_stmt_get_result($stmt);
            $data = [];

            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }

            sendResponse(true, "berhasil", $data);

        } else {

            $stmt = mysqli_prepare($koneksi,
                "SELECT * FROM lokasi ORDER BY id_lokasi DESC"
            );

            if (!$stmt) {
                error_log(mysqli_error($koneksi));
                sendResponse(false, "Terjadi kesalahan pada server", null, 500);
            }

            if (!mysqli_stmt_execute($stmt)) {
                error_log(mysqli_stmt_error($stmt));
                sendResponse(false, "Terjadi kesalahan pada server", null, 500);
            }

            $result = mysqli_stmt_get_result($stmt);
            $data = [];

            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }

            sendResponse(true, "berhasil", $data);
        }

        break;

    case 'POST':

        $input = json_decode(file_get_contents("php://input"), true);

        if (
            !isset($input['nama_lokasi']) ||
            !isset($input['kode_lokasi']) ||
            !isset($input['penanggung_jawab']) ||
            !isset($input['kapasitas'])
        ) {
            sendResponse(false, "Semua field wajib diisi", null, 400);
        }

        $nama_lokasi = $input['nama_lokasi'];
        $kode_lokasi = $input['kode_lokasi'];
        $penanggung_jawab = $input['penanggung_jawab'];
        $kapasitas = (int) $input['kapasitas'];

        if ($kapasitas < 0) {
            sendResponse(false, "Kapasitas tidak valid", null, 400);
        }

        $stmt = mysqli_prepare($koneksi,
            "INSERT INTO lokasi
             (nama_lokasi, kode_lokasi, penanggung_jawab, kapasitas)
             VALUES (?, ?, ?, ?)"
        );

        if (!$stmt) {
            error_log(mysqli_error($koneksi));
            sendResponse(false, "Terjadi kesalahan pada server", null, 500);
        }

        mysqli_stmt_bind_param(
            $stmt,
            "sssi",
            $nama_lokasi,
            $kode_lokasi,
            $penanggung_jawab,
            $kapasitas
        );

        if (!mysqli_stmt_execute($stmt)) {
            error_log(mysqli_stmt_error($stmt));
            sendResponse(false, "Terjadi kesalahan pada server", null, 500);
        }

        sendResponse(true, "Lokasi berhasil ditambahkan", [
            "id" => mysqli_insert_id($koneksi)
        ], 201);

        break;

    case 'PUT':

        if (!isset($_GET['id'])) {
            sendResponse(false, "ID lokasi wajib diisi", null, 400);
        }

        $id = (int) $_GET['id'];

        if ($id <= 0) {
            sendResponse(false, "ID tidak valid", null, 400);
        }

        $input = json_decode(file_get_contents("php://input"), true);

        if (
            !isset($input['nama_lokasi']) ||
            !isset($input['kode_lokasi']) ||
            !isset($input['penanggung_jawab']) ||
            !isset($input['kapasitas'])
        ) {
            sendResponse(false, "Semua field wajib diisi", null, 400);
        }

        $nama_lokasi = $input['nama_lokasi'];
        $kode_lokasi = $input['kode_lokasi'];
        $penanggung_jawab = $input['penanggung_jawab'];
        $kapasitas = (int) $input['kapasitas'];

        if ($kapasitas < 0) {
            sendResponse(false, "Kapasitas tidak valid", null, 400);
        }

        $stmt = mysqli_prepare($koneksi,
            "SELECT id_lokasi FROM lokasi WHERE id_lokasi = ?"
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

        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) == 0) {
            sendResponse(false, "Lokasi tidak ditemukan", null, 404);
        }

        $stmt = mysqli_prepare($koneksi,
            "UPDATE lokasi
             SET nama_lokasi = ?, kode_lokasi = ?,
                 penanggung_jawab = ?, kapasitas = ?
             WHERE id_lokasi = ?"
        );

        if (!$stmt) {
            error_log(mysqli_error($koneksi));
            sendResponse(false, "Terjadi kesalahan pada server", null, 500);
        }

        mysqli_stmt_bind_param(
            $stmt,
            "sssii",
            $nama_lokasi,
            $kode_lokasi,
            $penanggung_jawab,
            $kapasitas,
            $id
        );

        if (!mysqli_stmt_execute($stmt)) {
            error_log(mysqli_stmt_error($stmt));
            sendResponse(false, "Terjadi kesalahan pada server", null, 500);
        }

        if (mysqli_stmt_affected_rows($stmt) == 0) {
            sendResponse(true, "Tidak ada perubahan data", [
                "id" => $id
            ]);
        }

        sendResponse(true, "Lokasi berhasil diperbarui", [
            "id" => $id
        ]);

        break;

    case 'DELETE':

        if (!isset($_GET['id'])) {
            sendResponse(false, "ID lokasi wajib diisi", null, 400);
        }

        $id = (int) $_GET['id'];

        if ($id <= 0) {
            sendResponse(false, "ID tidak valid", null, 400);
        }

        $stmt = mysqli_prepare($koneksi,
            "DELETE FROM lokasi WHERE id_lokasi = ?"
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

        if (mysqli_stmt_affected_rows($stmt) == 0) {
            sendResponse(false, "Lokasi tidak ditemukan", null, 404);
        }

        sendResponse(true, "Lokasi berhasil dihapus", [
            "id" => $id
        ]);

        break;

    default:
        sendResponse(false, "Method tidak diizinkan", null, 405);
        break;
}
?>
