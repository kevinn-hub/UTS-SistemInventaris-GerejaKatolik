# SistemInventaris-GerejaKatolik
Deskripsi
Database gereja_katolik digunakan untuk menyimpan dan mengelola data inventaris barang gereja 

Struktur Tabel
kategori_barang: Menyimpan kategori barang.
lokasi: Menyimpan lokasi penyimpanan barang.
barang: Menyimpan data inventaris barang.
transaksi_barang: Mencatat barang masuk dan keluar.

Relasi Antar Tabel
kategori_barang → barang (1:N).
lokasi → barang (1:N).
barang → transaksi_barang (1:N).