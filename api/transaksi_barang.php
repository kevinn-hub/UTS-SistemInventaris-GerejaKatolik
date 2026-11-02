
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
                "SELECT t.*, b.kode_barang, b.nama_barang
                 FROM transaksi_barang t
                 LEFT JOIN barang b ON t.id_barang = b.id_barang
                 WHERE t.id_transaksi = ?"
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
                sendResponse(false, "Transaksi tidak ditemukan", null, 404);
            }

            sendResponse(true, "berhasil", $data);

        } elseif (isset($_GET['search'])) {

            $search = "%" . $_GET['search'] . "%";

            $stmt = mysqli_prepare($koneksi,
                "SELECT t.*, b.kode_barang, b.nama_barang
                 FROM transaksi_barang t
                 LEFT JOIN barang b ON t.id_barang = b.id_barang
                 WHERE b.nama_barang LIKE ?
                 OR b.kode_barang LIKE ?
                 OR t.jenis_transaksi LIKE ?
                 OR t.keterangan LIKE ?
                 ORDER BY t.id_transaksi DESC"
            );

            if (!$stmt) {
                error_log(mysqli_error($koneksi));
                sendResponse(false, "Terjadi kesalahan pada server", null, 500);
            }

            mysqli_stmt_bind_param($stmt, "ssss", $search, $search, $search, $search);

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
                "SELECT t.*, b.kode_barang, b.nama_barang
                 FROM transaksi_barang t
                 LEFT JOIN barang b ON t.id_barang = b.id_barang
                 ORDER BY t.id_transaksi DESC
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
                "SELECT t.*, b.kode_barang, b.nama_barang
                 FROM transaksi_barang t
                 LEFT JOIN barang b ON t.id_barang = b.id_barang
                 ORDER BY t.id_transaksi DESC"
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
            !isset($input['id_barang']) ||
            !isset($input['jenis_transaksi']) ||
            !isset($input['jumlah']) ||
            !isset($input['tanggal']) ||
            !isset($input['keterangan'])
        ) {
            sendResponse(false, "Semua field wajib diisi", null, 400);
        }

        $id_barang = (int) $input['id_barang'];
        $jenis_transaksi = $input['jenis_transaksi'];
        $jumlah = (int) $input['jumlah'];
        $tanggal = $input['tanggal'];
        $keterangan = $input['keterangan'];

        if (
            $id_barang <= 0 ||
            $jumlah <= 0 ||
            !in_array($jenis_transaksi, ['Masuk', 'Keluar'])
        ) {
            sendResponse(false, "Data tidak valid", null, 400);
        }

        $stmt = mysqli_prepare($koneksi,
            "SELECT id_barang FROM barang WHERE id_barang = ?"
        );

        if (!$stmt) {
            error_log(mysqli_error($koneksi));
            sendResponse(false, "Terjadi kesalahan pada server", null, 500);
        }

        mysqli_stmt_bind_param($stmt, "i", $id_barang);

        if (!mysqli_stmt_execute($stmt)) {
            error_log(mysqli_stmt_error($stmt));
            sendResponse(false, "Terjadi kesalahan pada server", null, 500);
        }

        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) == 0) {
            sendResponse(false, "Barang tidak ditemukan", null, 404);
        }

        $stmt = mysqli_prepare($koneksi,
            "INSERT INTO transaksi_barang
             (id_barang, jenis_transaksi, jumlah, tanggal, keterangan)
             VALUES (?, ?, ?, ?, ?)"
        );

        if (!$stmt) {
            error_log(mysqli_error($koneksi));
            sendResponse(false, "Terjadi kesalahan pada server", null, 500);
        }

        mysqli_stmt_bind_param(
            $stmt,
            "isiss",
            $id_barang,
            $jenis_transaksi,
            $jumlah,
            $tanggal,
            $keterangan
        );

        if (!mysqli_stmt_execute($stmt)) {
            error_log(mysqli_stmt_error($stmt));
            sendResponse(false, "Terjadi kesalahan pada server", null, 500);
        }

        sendResponse(true, "Transaksi berhasil ditambahkan", [
            "id" => mysqli_insert_id($koneksi)
        ], 201);

        break;

    case 'PUT':

        if (!isset($_GET['id'])) {
            sendResponse(false, "ID transaksi wajib diisi", null, 400);
        }

        $id = (int) $_GET['id'];

        if ($id <= 0) {
            sendResponse(false, "ID tidak valid", null, 400);
        }

        $input = json_decode(file_get_contents("php://input"), true);

        if (
            !isset($input['id_barang']) ||
            !isset($input['jenis_transaksi']) ||
            !isset($input['jumlah']) ||
            !isset($input['tanggal']) ||
            !isset($input['keterangan'])
        ) {
            sendResponse(false, "Semua field wajib diisi", null, 400);
        }

        $id_barang = (int) $input['id_barang'];
        $jenis_transaksi = $input['jenis_transaksi'];
        $jumlah = (int) $input['jumlah'];
        $tanggal = $input['tanggal'];
        $keterangan = $input['keterangan'];

        if (
            $id_barang <= 0 ||
            $jumlah <= 0 ||
            !in_array($jenis_transaksi, ['Masuk', 'Keluar'])
        ) {
            sendResponse(false, "Data tidak valid", null, 400);
        }

        $stmt = mysqli_prepare($koneksi,
            "SELECT id_transaksi FROM transaksi_barang WHERE id_transaksi = ?"
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
            sendResponse(false, "Transaksi tidak ditemukan", null, 404);
        }

        $stmt = mysqli_prepare($koneksi,
            "SELECT id_barang FROM barang WHERE id_barang = ?"
        );

        if (!$stmt) {
            error_log(mysqli_error($koneksi));
            sendResponse(false, "Terjadi kesalahan pada server", null, 500);
        }

        mysqli_stmt_bind_param($stmt, "i", $id_barang);

        if (!mysqli_stmt_execute($stmt)) {
            error_log(mysqli_stmt_error($stmt));
            sendResponse(false, "Terjadi kesalahan pada server", null, 500);
        }

        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) == 0) {
            sendResponse(false, "Barang tidak ditemukan", null, 404);
        }

        $stmt = mysqli_prepare($koneksi,
            "UPDATE transaksi_barang
             SET id_barang = ?, jenis_transaksi = ?, jumlah = ?,
                 tanggal = ?, keterangan = ?
             WHERE id_transaksi = ?"
        );

        if (!$stmt) {
            error_log(mysqli_error($koneksi));
            sendResponse(false, "Terjadi kesalahan pada server", null, 500);
        }

        mysqli_stmt_bind_param(
            $stmt,
            "isissi",
            $id_barang,
            $jenis_transaksi,
            $jumlah,
            $tanggal,
            $keterangan,
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

        sendResponse(true, "Transaksi berhasil diperbarui", [
            "id" => $id
        ]);

        break;

    case 'DELETE':

        if (!isset($_GET['id'])) {
            sendResponse(false, "ID transaksi wajib diisi", null, 400);
        }

        $id = (int) $_GET['id'];

        if ($id <= 0) {
            sendResponse(false, "ID tidak valid", null, 400);
        }

        $stmt = mysqli_prepare($koneksi,
            "DELETE FROM transaksi_barang WHERE id_transaksi = ?"
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
            sendResponse(false, "Transaksi tidak ditemukan", null, 404);
        }

        sendResponse(true, "Transaksi berhasil dihapus", [
            "id" => $id
        ]);

        break;

    default:
        sendResponse(false, "Method tidak diizinkan", null, 405);
        break;
}
?>
