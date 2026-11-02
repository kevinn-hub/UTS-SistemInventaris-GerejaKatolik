SistemInventaris-GerejaKatolik
1. Identitas Kelompok

Nama Kelompok: Anomali

Anggota Kelompok
No.	Nama Anggota	NIM	Tugas dan Tanggung Jawab
1	Leonard Kevin Fernando	2511500012	Pengembangan backend, CRUD barang, CRUD lokasi, dan pengembangan API
2	Rendy Orlando	[NIM]	[Tugas anggota]
3	Peter Immanuell	[NIM]	[Tugas anggota]
4	Melvyn	[NIM]	[Tugas anggota]
2. Deskripsi Proyek

SistemInventaris-GerejaKatolik merupakan aplikasi berbasis web yang dirancang untuk membantu pengelolaan dan pencatatan inventaris barang gereja.

Aplikasi ini digunakan untuk mengelola data kategori barang, lokasi penyimpanan, data inventaris barang, serta transaksi barang masuk dan barang keluar.

Dengan adanya sistem ini, pengelolaan inventaris diharapkan menjadi lebih terstruktur, mempermudah pencatatan data, dan membantu pemantauan barang yang dimiliki gereja.

3. Teknologi yang Digunakan

Teknologi dan perangkat yang digunakan dalam pengembangan aplikasi:

Teknologi	Kegunaan
PHP	Bahasa pemrograman backend
MySQL	Pengelolaan database
HTML	Membuat struktur halaman web
CSS	Mengatur tampilan aplikasi
JavaScript	Mendukung interaksi halaman web
Laragon	Lingkungan pengembangan lokal
phpMyAdmin	Mengelola database MySQL
Git	Version control
GitHub	Penyimpanan repository proyek
4. Struktur Database

Database yang digunakan dalam aplikasi ini bernama gereja_hky.

Database terdiri dari empat tabel utama, yaitu satu tabel master dan tiga tabel lainnya yang saling berelasi.

4.1 Tabel Master

1. kategori_barang

Tabel ini digunakan untuk menyimpan data kategori barang yang berfungsi sebagai referensi pengelompokan inventaris gereja.

4.2 Tabel Lainnya

1. lokasi

Tabel ini digunakan untuk menyimpan informasi lokasi atau tempat penyimpanan barang inventaris gereja.

2. barang

Tabel ini digunakan untuk menyimpan informasi utama barang inventaris gereja, termasuk kategori barang dan lokasi penyimpanannya.

3. transaksi_barang

Tabel ini digunakan untuk mencatat aktivitas transaksi barang masuk dan barang keluar, termasuk informasi barang, jenis transaksi, jumlah, serta informasi transaksi lainnya.

5. Entity Relationship Diagram (ERD)

Entity Relationship Diagram (ERD) merupakan diagram yang menggambarkan hubungan antarentitas dalam database gereja_hky.

ERD terdiri dari empat entitas utama:

kategori_barang
lokasi
barang
transaksi_barang
Gambar ERD

!ERD Sistem Inventaris Gereja Katolik

Keterangan: Gambar ERD disimpan dalam folder docs dengan nama file erd.png.

6. Relasi Antar Tabel

Relasi antar tabel pada database gereja_hky adalah sebagai berikut:

No.	Tabel yang Berelasi	Kardinalitas	Penjelasan
1	kategori_barang → barang	1:N	Satu kategori dapat memiliki banyak barang.
2	lokasi → barang	1:N	Satu lokasi dapat menyimpan banyak barang.
3	barang → transaksi_barang	1:N	Satu barang dapat memiliki banyak catatan transaksi.
Penjelasan Relasi
Kategori Barang dengan Barang: Setiap barang memiliki kategori tertentu, sedangkan satu kategori dapat digunakan oleh banyak barang.
Lokasi dengan Barang: Setiap barang memiliki lokasi penyimpanan, sedangkan satu lokasi dapat menyimpan banyak barang.
Barang dengan Transaksi Barang: Satu barang dapat memiliki beberapa catatan transaksi, baik barang masuk maupun barang keluar.
7. Daftar Endpoint API

API (Application Programming Interface) digunakan sebagai penghubung antara frontend dan backend untuk melakukan pengelolaan data pada database.

Aplikasi memiliki empat kelompok API, yaitu API kategori barang, API lokasi, API barang, dan API transaksi barang.

Base URL:

text
http://localhost/UTS-SistemInventaris-GerejaKatolik

7.1 API Kategori Barang

File: api/kategori_barang.php

Method	URL	Body	Response
GET	/api/kategori_barang.php	-	Data kategori barang
POST	/api/kategori_barang.php	Data kategori dalam JSON	Hasil penambahan kategori
PUT	/api/kategori_barang.php?id={id}	Data kategori yang diperbarui	Hasil perubahan kategori
DELETE	/api/kategori_barang.php?id={id}	-	Hasil penghapusan kategori
7.2 API Lokasi

File: api/lokasi.php

Method	URL	Body	Response
GET	/api/lokasi.php	-	Data lokasi
POST	/api/lokasi.php	Data lokasi dalam JSON	Hasil penambahan lokasi
PUT	/api/lokasi.php?id={id}	Data lokasi yang diperbarui	Hasil perubahan lokasi
DELETE	/api/lokasi.php?id={id}	-	Hasil penghapusan lokasi
7.3 API Barang

File: api/barang.php

Method	URL	Body	Response
GET	/api/barang.php	-	Data seluruh barang
POST	/api/barang.php	Data barang dalam JSON	Hasil penambahan barang
PUT	/api/barang.php?id={id}	Data barang yang diperbarui	Hasil perubahan barang
DELETE	/api/barang.php?id={id}	-	Hasil penghapusan barang
7.4 API Transaksi Barang

File: api/transaksi_barang.php

Method	URL	Body	Response
GET	/api/transaksi_barang.php	-	Data transaksi barang
POST	/api/transaksi_barang.php	Data transaksi dalam JSON	Hasil penambahan transaksi
PUT	/api/transaksi_barang.php?id={id}	Data transaksi yang diperbarui	Hasil perubahan transaksi
DELETE	/api/transaksi_barang.php?id={id}	-	Hasil penghapusan transaksi

Catatan: Dokumentasi endpoint di atas merupakan rancangan awal. Method, URL, parameter, format Body, dan Response perlu disesuaikan dengan implementasi sebenarnya pada masing-masing file PHP. Tidak semua API harus memiliki keempat method apabila memang belum diimplementasikan.

8. Instalasi dan Cara Menjalankan Aplikasi

Berikut langkah-langkah untuk menjalankan aplikasi secara lokal menggunakan Laragon.

8.1 Persiapan

Pastikan perangkat telah memiliki:

Laragon
PHP
MySQL
Web Browser
8.2 Clone Repository

Jalankan perintah berikut melalui terminal:

bash
git clone https://github.com/kevinn-hub/UTS-SistemInventaris-GerejaKatolik.git

8.3 Menjalankan Aplikasi
Pindahkan folder proyek ke direktori C:\laragon\www\.
Jalankan aplikasi Laragon.
Aktifkan Apache dan MySQL.
Buka phpMyAdmin melalui browser.
Buat database dengan nama gereja_hky.
Import file database SQL ke dalam database tersebut.
Sesuaikan konfigurasi koneksi database pada file PHP.
Jalankan aplikasi melalui browser.

Alamat aplikasi:

text
http://localhost/UTS-SistemInventaris-GerejaKatolik/

9. Konfigurasi Database

Database yang digunakan:

Keterangan	Nilai
DBMS	MySQL
Nama Database	gereja_hky
Server	localhost
Username	root
Password	Sesuai konfigurasi MySQL lokal
Contoh Konfigurasi Koneksi PHP
php
$host = "localhost";
$user = "root";
$password = "";
$database = "gereja_hky";


Sesuaikan konfigurasi tersebut dengan pengaturan database pada perangkat masing-masing.

10. Repository GitHub

Repository proyek dapat diakses melalui tautan berikut:

SistemInventaris-GerejaKatolik

11. Penutup

SistemInventaris-GerejaKatolik merupakan proyek pengembangan aplikasi berbasis web yang bertujuan untuk membantu pengelolaan inventaris barang gereja.

Melalui penggunaan database MySQL, pengelolaan data kategori barang, lokasi, barang, dan transaksi barang dapat dilakukan secara lebih terstruktur.

Dokumentasi ini dibuat untuk menjelaskan identitas kelompok, pembagian tugas anggota, rancangan ERD, struktur database, relasi antar tabel, serta dokumentasi endpoint API yang digunakan dalam pengembangan aplikasi.