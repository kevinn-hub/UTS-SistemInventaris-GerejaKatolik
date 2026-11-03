<?php
    
    require_once __DIR__ . "/helpers/response.php";

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Authorization");

    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        http_response_code(204);
        exit;
    }

    mysqli_report(MYSQLI_REPORT_OFF);

    $host = "localhost";
    $user = "root";
    $pass = "";
    $db = "gereja_hky";

    $koneksi = @mysqli_connect($host, $user, $pass, $db);

    if (!$koneksi) {
         error_log("Koneksi database gagal: " . mysqli_connect_error());
        sendResponse(false, "Koneksi database gagal", null, 500);
    }

?>