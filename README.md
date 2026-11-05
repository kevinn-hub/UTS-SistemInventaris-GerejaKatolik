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
![ERD](./screenshot/ERD.png)


### Daftar Endpoint

<table>
  <tr>
    <th>File PHP</th>
    <th>Method</th>
    <th>URL</th>
    <th>Body</th>
    <th>Response</th>
  </tr>

  <!-- KATEGORI BARANG -->
  <tr>
    <td>kategori_barang.php</td>
    <td>GET</td>
    <td>http://localhost/UTS-SistemInventaris-GerejaKatolik/api/kategori_barang.php</td>
    <td>-</td>
    <td>200 OK - Berhasil mengambil semua data kategori barang</td>
  </tr>
  <tr>
    <td>kategori_barang.php</td>
    <td>GET</td>
    <td>http://localhost/UTS-SistemInventaris-GerejaKatolik/api/kategori_barang.php?id=999</td>
    <td>-</td>
    <td>404 Not Found - Kategori barang tidak ditemukan</td>
  </tr>
  <tr>
    <td>kategori_barang.php</td>
    <td>GET</td>
    <td>http://localhost/UTS-SistemInventaris-GerejaKatolik/api/kategori_barang.php?id=1</td>
    <td>-</td>
    <td>200 OK - Berhasil mengambil kategori berdasarkan ID</td>
  </tr>
  <tr>
    <td>kategori_barang.php</td>
    <td>GET</td>
    <td>http://localhost/UTS-SistemInventaris-GerejaKatolik/api/kategori_barang.php?search=Elektronik</td>
    <td>-</td>
    <td>200 OK - Berhasil mencari kategori barang</td>
  </tr>
  <tr>
    <td>kategori_barang.php</td>
    <td>GET</td>
    <td>http://localhost/UTS-SistemInventaris-GerejaKatolik/api/kategori_barang.php?page=1&limit=2</td>
    <td>-</td>
    <td>200 OK - Berhasil menampilkan pagination kategori barang</td>
  </tr>
  <tr>
    <td>kategori_barang.php</td>
    <td>POST</td>
    <td>http://localhost/UTS-SistemInventaris-GerejaKatolik/api/kategori_barang.php</td>
    <td><pre>{
  "nama_kategori": "Peralatan Misa",
  "kode_kategori": "KAT007",
  "deskripsi": "Peralatan gereja",
  "tanggal_dibuat": "2026-11-02"
}</pre></td>
    <td>201 Created - Data kategori berhasil ditambahkan</td>
  </tr>
  <tr>
    <td>kategori_barang.php</td>
    <td>POST</td>
    <td>http://localhost/UTS-SistemInventaris-GerejaKatolik/api/kategori_barang.php</td>
    <td><pre>{
  "nama_kategori": "Kategori Percobaan",
  "kode_kategori": "KAT010"
}</pre></td>
    <td>400 Bad Request - Data kategori tidak lengkap</td>
  </tr>
  <tr>
    <td>kategori_barang.php</td>
    <td>POST</td>
    <td>http://localhost/UTS-SistemInventaris-GerejaKatolik/api/kategori_barang.php</td>
    <td><pre>{
  "nama_kategori": "Peralatan Liturgi",
  "kode_kategori": "KAT001",
  "deskripsi": "Pengujian kode kategori duplikat",
  "tanggal_dibuat": "2026-11-02"
}</pre></td>
    <td>409 Conflict - Kode kategori sudah digunakan</td>
  </tr>
  <tr>
    <td>kategori_barang.php</td>
    <td>PUT</td>
    <td>http://localhost/UTS-SistemInventaris-GerejaKatolik/api/kategori_barang.php?id=6</td>
    <td><pre>{
  "nama_kategori": "Peralatan Kebersihan Gereja",
  "kode_kategori": "KAT006",
  "deskripsi": "Peralatan untuk menjaga kebersihan gereja",
  "tanggal_dibuat": "2026-11-02"
}</pre></td>
    <td>200 OK - Data kategori berhasil diperbarui</td>
  </tr>
  <tr>
    <td>kategori_barang.php</td>
    <td>PUT</td>
    <td>http://localhost/UTS-SistemInventaris-GerejaKatolik/api/kategori_barang.php?id=5</td>
    <td><pre>{
  "nama_kategori": "Kategori Percobaan",
  "kode_kategori": "KAT999"
}</pre></td>
    <td>400 Bad Request - Data kategori tidak lengkap</td>
  </tr>
  <tr>
    <td>kategori_barang.php</td>
    <td>PUT</td>
    <td>http://localhost/UTS-SistemInventaris-GerejaKatolik/api/kategori_barang.php?id=9</td>
    <td><pre>{
  "nama_kategori": "Kategori Percobaan",
  "kode_kategori": "KAT999",
  "deskripsi": "Pengujian kategori yang tidak ditemukan",
  "tanggal_dibuat": "2026-11-02"
}</pre></td>
    <td>404 Not Found - Kategori barang tidak ditemukan</td>
  </tr>
  <tr>
    <td>kategori_barang.php</td>
    <td>DELETE</td>
    <td>http://localhost/UTS-SistemInventaris-GerejaKatolik/api/kategori_barang.php?id=7</td>
    <td>-</td>
    <td>200 OK - Data kategori berhasil dihapus</td>
  </tr>
  <tr>
    <td>kategori_barang.php</td>
    <td>DELETE</td>
    <td>http://localhost/UTS-SistemInventaris-GerejaKatolik/api/kategori_barang.php?id=999</td>
    <td>-</td>
    <td>404 Not Found - Kategori barang tidak ditemukan</td>
  </tr>

  <!-- BARANG -->
  <tr>
    <td>barang.php</td>
    <td>GET</td>
    <td>http://localhost/UTS-SistemInventaris-GerejaKatolik/api/barang.php</td>
    <td>-</td>
    <td>200 OK - Berhasil mengambil semua data barang beserta kategori dan lokasi</td>
  </tr>
  <tr>
    <td>barang.php</td>
    <td>GET</td>
    <td>http://localhost/UTS-SistemInventaris-GerejaKatolik/api/barang.php?id=999</td>
    <td>-</td>
    <td>404 Not Found - Barang tidak ditemukan</td>
  </tr>
  <tr>
    <td>barang.php</td>
    <td>GET</td>
    <td>http://localhost/UTS-SistemInventaris-GerejaKatolik/api/barang.php?id=2</td>
    <td>-</td>
    <td>200 OK - Berhasil mengambil barang berdasarkan ID</td>
  </tr>
  <tr>
    <td>barang.php</td>
    <td>GET</td>
    <td>http://localhost/UTS-SistemInventaris-GerejaKatolik/api/barang.php?search=piala</td>
    <td>-</td>
    <td>200 OK - Berhasil mencari data barang</td>
  </tr>
  <tr>
    <td>barang.php</td>
    <td>GET</td>
    <td>http://localhost/UTS-SistemInventaris-GerejaKatolik/api/barang.php?page=1&limit=2</td>
    <td>-</td>
    <td>200 OK - Berhasil menampilkan pagination barang</td>
  </tr>
  <tr>
    <td>barang.php</td>
    <td>POST</td>
    <td>http://localhost/UTS-SistemInventaris-GerejaKatolik/api/barang.php</td>
    <td><pre>{
  "kode_barang": "BRG008",
  "id_kategori": 1,
  "id_lokasi": 1,
  "nama_barang": "Mikrofon Gereja",
  "jumlah": 5,
  "kondisi": "Baik"
}</pre></td>
    <td>201 Created - Data barang berhasil ditambahkan</td>
  </tr>
  <tr>
    <td>barang.php</td>
    <td>POST</td>
    <td>http://localhost/UTS-SistemInventaris-GerejaKatolik/api/barang.php</td>
    <td><pre>{
  "kode_barang": "BRG011",
  "id_kategori": 1,
  "id_lokasi": 1,
  "jumlah": 5,
  "kondisi": "Baik"
}</pre></td>
    <td>400 Bad Request - Data barang tidak lengkap</td>
  </tr>
  <tr>
    <td>barang.php</td>
    <td>POST</td>
    <td>http://localhost/UTS-SistemInventaris-GerejaKatolik/api/barang.php</td>
    <td><pre>{
  "kode_barang": "BRG012",
  "id_kategori": 999,
  "id_lokasi": 1,
  "nama_barang": "Mikrofon Gereja",
  "jumlah": 5,
  "kondisi": "Baik"
}</pre></td>
    <td>404 Not Found - Kategori barang tidak ditemukan</td>
  </tr>
  <tr>
    <td>barang.php</td>
    <td>POST</td>
    <td>http://localhost/UTS-SistemInventaris-GerejaKatolik/api/barang.php</td>
    <td><pre>{
  "kode_barang": "BRG013",
  "id_kategori": 1,
  "id_lokasi": 999,
  "nama_barang": "Mikrofon Gereja",
  "jumlah": 5,
  "kondisi": "Baik"
}</pre></td>
    <td>404 Not Found - Lokasi tidak ditemukan</td>
  </tr>
  <tr>
    <td>barang.php</td>
    <td>POST</td>
    <td>http://localhost/UTS-SistemInventaris-GerejaKatolik/api/barang.php</td>
    <td><pre>{
  "kode_barang": "BRG09",
  "id_kategori": 1,
  "id_lokasi": 1,
  "nama_barang": "Speaker Gereja",
  "jumlah": 3,
  "kondisi": "Baik"
}</pre></td>
    <td>409 Conflict - Kode barang sudah digunakan</td>
  </tr>
  <tr>
    <td>barang.php</td>
    <td>PUT</td>
    <td>http://localhost/UTS-SistemInventaris-GerejaKatolik/api/barang.php?id=9</td>
    <td><pre>{
  "kode_barang": "BRG009",
  "id_kategori": 1,
  "id_lokasi": 1,
  "nama_barang": "speaker Gereja Update",
  "jumlah": 10,
  "kondisi": "Baik"
}</pre></td>
    <td>200 OK - Data barang berhasil diperbarui</td>
  </tr>
  <tr>
    <td>barang.php</td>
    <td>PUT</td>
    <td>http://localhost/UTS-SistemInventaris-GerejaKatolik/api/barang.php?id=9</td>
    <td><pre>{
  "id_kategori": 1,
  "id_lokasi": 1,
  "nama_barang": "speaker Gereja Update",
  "jumlah": 10,
  "kondisi": "Baik"
}</pre></td>
    <td>400 Bad Request - Data barang tidak lengkap</td>
  </tr>
  <tr>
    <td>barang.php</td>
    <td>PUT</td>
    <td>http://localhost/UTS-SistemInventaris-GerejaKatolik/api/barang.php?id=99</td>
    <td><pre>{
  "kode_barang": "BRG009",
  "id_kategori": 1,
  "id_lokasi": 1,
  "nama_barang": "speaker Gereja Update",
  "jumlah": 10,
  "kondisi": "Baik"
}</pre></td>
    <td>404 Not Found - Barang tidak ditemukan</td>
  </tr>
  <tr>
    <td>barang.php</td>
    <td>DELETE</td>
    <td>http://localhost/UTS-SistemInventaris-GerejaKatolik/api/barang.php?id=9</td>
    <td>-</td>
    <td>200 OK - Data barang berhasil dihapus</td>
  </tr>
  <tr>
    <td>barang.php</td>
    <td>DELETE</td>
    <td>http://localhost/UTS-SistemInventaris-GerejaKatolik/api/barang.php?id=99</td>
    <td>-</td>
    <td>404 Not Found - Barang tidak ditemukan</td>
  </tr>

  <!-- LOKASI -->
  <tr>
    <td>lokasi.php</td>
    <td>GET</td>
    <td>http://localhost/UTS-SistemInventaris-GerejaKatolik/api/lokasi.php</td>
    <td>-</td>
    <td>200 OK - Berhasil mengambil semua data lokasi</td>
  </tr>
  <tr>
    <td>lokasi.php</td>
    <td>GET</td>
    <td>http://localhost/UTS-SistemInventaris-GerejaKatolik/api/lokasi.php?id=99</td>
    <td>-</td>
    <td>404 Not Found - Lokasi tidak ditemukan</td>
  </tr>
  <tr>
    <td>lokasi.php</td>
    <td>GET</td>
    <td>http://localhost/UTS-SistemInventaris-GerejaKatolik/api/lokasi.php?id=2</td>
    <td>-</td>
    <td>200 OK - Berhasil mengambil lokasi berdasarkan ID</td>
  </tr>
  <tr>
    <td>lokasi.php</td>
    <td>GET</td>
    <td>http://localhost/UTS-SistemInventaris-GerejaKatolik/api/lokasi.php?search=sak</td>
    <td>-</td>
    <td>200 OK - Berhasil mencari data lokasi</td>
  </tr>
  <tr>
    <td>lokasi.php</td>
    <td>GET</td>
    <td>http://localhost/UTS-SistemInventaris-GerejaKatolik/api/lokasi.php?page=1&limit=2</td>
    <td>-</td>
    <td>200 OK - Berhasil menampilkan pagination lokasi</td>
  </tr>
  <tr>
    <td>lokasi.php</td>
    <td>POST</td>
    <td>http://localhost/UTS-SistemInventaris-GerejaKatolik/api/lokasi.php</td>
    <td><pre>{
  "nama_lokasi": "Aula Paroki",
  "kode_lokasi": "LOK007",
  "penanggung_jawab": "Petugas Liturgi",
  "kapasitas": 200
}</pre></td>
    <td>201 Created - Data lokasi berhasil ditambahkan</td>
  </tr>
  <tr>
    <td>lokasi.php</td>
    <td>POST</td>
    <td>http://localhost/UTS-SistemInventaris-GerejaKatolik/api/lokasi.php</td>
    <td><pre>{
  "nama_lokasi": "Aula Paroki",
  "kode_lokasi": "LOK007"
}</pre></td>
    <td>400 Bad Request - Data lokasi tidak lengkap</td>
  </tr>
  <tr>
    <td>lokasi.php</td>
    <td>POST</td>
    <td>http://localhost/UTS-SistemInventaris-GerejaKatolik/api/lokasi.php</td>
    <td><pre>{
  "nama_lokasi": "Aula Paroki",
  "kode_lokasi": "LOK007",
  "penanggung_jawab": "Petugas Liturgi",
  "kapasitas": 200
}</pre></td>
    <td>409 Conflict - Kode lokasi sudah digunakan</td>
  </tr>
  <tr>
    <td>lokasi.php</td>
    <td>PUT</td>
    <td>http://localhost/UTS-SistemInventaris-GerejaKatolik/api/lokasi.php?id=7</td>
    <td><pre>{
  "nama_lokasi": "Aula 1",
  "kode_lokasi": "LOK007",
  "penanggung_jawab": "Petugas Liturgi",
  "kapasitas": 200
}</pre></td>
    <td>200 OK - Data lokasi berhasil diperbarui</td>
  </tr>
  <tr>
    <td>lokasi.php</td>
    <td>PUT</td>
    <td>http://localhost/UTS-SistemInventaris-GerejaKatolik/api/lokasi.php?id=7</td>
    <td><pre>{
  "nama_lokasi": "Aula 1",
  "kode_lokasi": "LOK007"
}</pre></td>
    <td>400 Bad Request - Data lokasi tidak lengkap</td>
  </tr>
  <tr>
    <td>lokasi.php</td>
    <td>PUT</td>
    <td>http://localhost/UTS-SistemInventaris-GerejaKatolik/api/lokasi.php?id=777</td>
    <td><pre>{
  "nama_lokasi": "Aula Paroki",
  "kode_lokasi": "LOK777",
  "penanggung_jawab": "Petugas Liturgi",
  "kapasitas": 200
}</pre></td>
    <td>404 Not Found - Lokasi tidak ditemukan</td>
  </tr>
  <tr>
    <td>lokasi.php</td>
    <td>DELETE</td>
    <td>http://localhost/UTS-SistemInventaris-GerejaKatolik/api/lokasi.php?id=7</td>
    <td>-</td>
    <td>200 OK - Data lokasi berhasil dihapus</td>
  </tr>
  <tr>
    <td>lokasi.php</td>
    <td>DELETE</td>
    <td>http://localhost/UTS-SistemInventaris-GerejaKatolik/api/lokasi.php?id=77</td>
    <td>-</td>
    <td>404 Not Found - Lokasi tidak ditemukan</td>
  </tr>

  <!-- TRANSAKSI BARANG -->
  <tr>
    <td>transaksi_barang.php</td>
    <td>GET</td>
    <td>http://localhost/UTS-SistemInventaris-GerejaKatolik/api/transaksi_barang.php</td>
    <td>-</td>
    <td>200 OK - Berhasil mengambil semua data transaksi barang</td>
  </tr>
  <tr>
    <td>transaksi_barang.php</td>
    <td>GET</td>
    <td>http://localhost/UTS-SistemInventaris-GerejaKatolik/api/transaksi_barang.php?id=999</td>
    <td>-</td>
    <td>404 Not Found - Transaksi barang tidak ditemukan</td>
  </tr>
  <tr>
    <td>transaksi_barang.php</td>
    <td>GET</td>
    <td>http://localhost/UTS-SistemInventaris-GerejaKatolik/api/transaksi_barang.php?page=1&limit=2</td>
    <td>-</td>
    <td>200 OK - Berhasil menampilkan pagination transaksi barang</td>
  </tr>
  <tr>
    <td>transaksi_barang.php</td>
    <td>POST</td>
    <td>http://localhost/UTS-SistemInventaris-GerejaKatolik/api/transaksi_barang.php</td>
    <td><pre>{
  "id_barang": 7,
  "jenis_transaksi": "Masuk",
  "jumlah": 10,
  "tanggal": "2026-10-08",
  "keterangan": "Pemindahan Meja"
}</pre></td>
    <td>201 Created - Data transaksi berhasil ditambahkan</td>
  </tr>
  <tr>
    <td>transaksi_barang.php</td>
    <td>POST</td>
    <td>http://localhost/UTS-SistemInventaris-GerejaKatolik/api/transaksi_barang.php</td>
    <td><pre>{
  "id_barang": 7,
  "jenis_transaksi": "Masuk",
  "jumlah": 10
}</pre></td>
    <td>400 Bad Request - Semua field wajib diisi</td>
  </tr>
  <tr>
    <td>transaksi_barang.php</td>
    <td>POST</td>
    <td>http://localhost/UTS-SistemInventaris-GerejaKatolik/api/transaksi_barang.php</td>
    <td><pre>{
  "id_barang": 9999,
  "jenis_transaksi": "Masuk",
  "jumlah": 10,
  "tanggal": "2026-10-08",
  "keterangan": "Pengujian FK 404"
}</pre></td>
    <td>404 Not Found - Barang tidak ditemukan</td>
  </tr>
  <tr>
    <td>transaksi_barang.php</td>
    <td>PUT</td>
    <td>http://localhost/UTS-SistemInventaris-GerejaKatolik/api/transaksi_barang.php?id=6</td>
    <td><pre>{
  "id_barang": 7,
  "jenis_transaksi": "Keluar",
  "jumlah": 10,
  "tanggal": "2026-10-08",
  "keterangan": "Pemindahan Meja"
}</pre></td>
    <td>200 OK - Data transaksi berhasil diperbarui</td>
  </tr>
  <tr>
    <td>transaksi_barang.php</td>
    <td>PUT</td>
    <td>http://localhost/UTS-SistemInventaris-GerejaKatolik/api/transaksi_barang.php?id=6</td>
    <td><pre>{
  "id_barang": 77,
  "jenis_transaksi": "Keluar",
  "jumlah": 10,
  "tanggal": "2026-10-08",
  "keterangan": "Pemindahan Meja"
}</pre></td>
    <td>404 Not Found - Barang tidak ditemukan</td>
  </tr>
  <tr>
    <td>transaksi_barang.php</td>
    <td>DELETE</td>
    <td>http://localhost/UTS-SistemInventaris-GerejaKatolik/api/transaksi_barang.php?id=6</td>
    <td>-</td>
    <td>200 OK - Data transaksi berhasil dihapus</td>
  </tr>
</table>


<h2>Deskripsi Proyek</h2>

<p>
  Sistem Inventaris Gereja Katolik merupakan aplikasi berbasis web yang dirancang untuk membantu pengelolaan dan pencatatan inventaris barang gereja.
</p>

<p>
  Aplikasi ini digunakan untuk mengelola data kategori barang, lokasi penyimpanan, data inventaris barang, serta transaksi barang masuk dan barang keluar.
</p>

<p>
  Dengan adanya sistem ini, pengelolaan inventaris diharapkan menjadi lebih terstruktur, mempermudah pencatatan data, dan membantu pemantauan barang yang dimiliki gereja.
</p>

### 3 Cara Menjalankan


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