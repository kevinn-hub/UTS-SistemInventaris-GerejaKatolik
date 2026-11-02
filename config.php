<?php
    
    require_once __DIR__ . "/helpers/response.php";

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