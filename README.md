# UTS/UAS PDCS

### Tema: SistemInventari-GerejaKatolik

### Kelompok Anomali
<p>Leonard Kevin Fernando [2511500012]<br>
<ul>
    <li>Buat database (scheme.sql)</li>
    <li>Buat ERD</li>
    <li>Menyusun Readme.md</li>
    <li>Menyusun Dokumentasi/ Screenshot</li>
    <li>Membuat file mahasiswa.php</li>
</ul>
<br>
</p>

<p>Randy [25115000]<br>
Tugas:<br>
<ul>
    <li></li>
    <li></li>
    <li></li>
    <li></li>
    <li></li>
</ul>
<br>
</p>

<p>Melvyn [25115000]<br>
Tugas:<br>
<ul>
    <li></li>
    <li></li>
</ul>
<br>
</p>

<p>Peter [25115000]<br>
Tugas:<br>
<ul>
    <li></li>
    <li></li>
</ul>
<br>
</p>

### ERD
<img src="screenshot/.png" alt="ERD" width="800">

<table>
  <tr>
    <th>File PHP</th>
    <th>Method</th>
    <th>URL</th>
    <th>Body</th>
    <th>Response</th>
  </tr>

<h2>2. Deskripsi Proyek</h2>

<p>
  Sistem Inventaris Gereja Katolik merupakan aplikasi berbasis web yang dirancang untuk membantu pengelolaan dan pencatatan inventaris barang gereja.
</p>

<p>
  Aplikasi ini digunakan untuk mengelola data kategori barang, lokasi penyimpanan, data inventaris barang, serta transaksi barang masuk dan barang keluar.
</p>

<p>
  Dengan adanya sistem ini, pengelolaan inventaris diharapkan menjadi lebih terstruktur, mempermudah pencatatan data, dan membantu pemantauan barang yang dimiliki gereja.
</p>

3### Cara Menjalankan


<p>1. Import Schema Database</p>
<ol>
    <li>Buka Laragon, kemudian klik Start All</li>
    <li>Buka browser dan akses http://localhost/phpmyadmin</li>
    <li>Pilih database yang akan digunakan atau buat database baru</li>
    <li>Pilih menu Import</li>
    <li>Klik Choose File, lalu pilih file database (file yang berekstensi .sql)</li>
    <li>Klik tombol Import</li>
    <li>Periksa apakah tabel barang, kategori_barang, lokasi, transaksi_barang berhasil diimpor</li>
</ol>

<p>2. Menjalankan Project Menggunakan Laragon</p>
<ol>
    <li>Buka aplikasi Laragon</li>
    <li>Klik Start All untuk menjalankan Apache dan MySQL</li>
    <li>Pastikan folder project berada di dalam direktori C:\laragon\www (C: bisa sesuai dengan lokasi laragon masing-masing)</li>
    <li>Pastikan konfigurasi database pada file config.php sudah sesuai dengan database di PhpMyAdmin</li>
    <li>
        Buka browser dan akses alamat project: http://localhost/UTS-SistemInventaris-GerejaKatolik/api/barang.php
    </li>
</ol>

<p>3. Pengujian API Menggunakan Thunder Client</p>
<ol>
    <li>Buka Visual Studio Code</li>
    <li>Klik ikon Thunder Client pada sidebar (instal dari menu Extension jika belum terinstal)</li>
    <li>Pilih New Request</li>
    <li>Pilih metode HTTP sesuai endpoint yang akan diuji (GET, POST, PUT, atau DELETE)</li>
    <li>Masukkan URL endpoint yang ingin diuji (contohnya dapat dilihat pada tabel daftar endpoint)</li>
    <li>Untuk metode POST dan PUT, pilih Body dan pilih JSON</li>
    <li>Masukkan data JSON sesuai kebutuhan (contohnya dapat dilihat pada tabel daftar endpoint)</li>
    <li>Klik Send untuk mengirim request</li>
    <li>Periksa hasil pengujian pada bagian Response</li>
</ol>