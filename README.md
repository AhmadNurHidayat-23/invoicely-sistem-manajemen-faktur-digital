# Invoicely — Sistem Informasi Manajemen Invoice dan Penagihan Digital

Invoicely adalah aplikasi web untuk membuat, mengelola, dan mencetak invoice. Sistem ini membantu menyatukan pencatatan tagihan, mengurangi kesalahan perhitungan manual, serta memantau status pembayaran dalam satu ruang kerja berbahasa Indonesia.

## Fitur

- Dashboard dengan statistik dari database dan daftar invoice terbaru.
- Buat, lihat, edit, dan hapus invoice dengan nomor otomatis yang unik.
- Identitas pengirim dan pelanggan, tanggal invoice, jatuh tempo, serta catatan.
- Pengelolaan beberapa item dengan perhitungan subtotal, pajak opsional, dan total Rupiah.
- Status **Draft**, **Belum Lunas**, dan **Lunas**, serta pencarian, filter, dan paginasi.
- Dokumen invoice responsif dengan cetak A4 atau simpan sebagai PDF melalui browser.
- Validasi berbahasa Indonesia dan konfirmasi sebelum penghapusan.

## Teknologi dan Data

**Laravel 13** menangani proses backend, **Blade** merender antarmuka, dan **SQLite** menyimpan data. Tampilan menggunakan HTML, CSS, JavaScript ringan, serta **Vite** untuk membangun aset.

Tabel `invoices` menyimpan identitas pihak terkait dan ringkasan tagihan; `invoice_items` menyimpan item milik setiap invoice. Penyimpanan menggunakan transaksi, dan penghapusan invoice turut menghapus item terkait.

Nilai uang menggunakan bilangan bulat Rupiah, sedangkan pajak disimpan dalam basis poin. Semua total dihitung ulang di server; pajak dibulatkan half-up ke Rupiah terdekat. Jumlah item menggunakan satuan bulat. Total nilai pada dashboard mencakup seluruh status, termasuk Draft.

## Menjalankan Aplikasi

Siapkan **PHP 8.5 (64 bit)** dengan ekstensi SQLite, **Composer 2**, **Node.js 22.12+**, dan npm.

```bash
git clone https://github.com/AhmadNurHidayat-23/invoicely-digital-invoice-management-system.git
cd invoicely-digital-invoice-management-system
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate
npm ci
npm run build
php artisan serve --host=127.0.0.1
```

Buka [http://127.0.0.1:8000](http://127.0.0.1:8000). Konfigurasi SQLite sudah tersedia pada `.env.example`; MySQL tidak diperlukan. Pada MAMP, gunakan PHP 8.5 dan jalankan perintah dari folder proyek.

Untuk menambahkan lima invoice fiktif, jalankan `php artisan db:seed --class=DemoInvoiceSeeder`. Setiap pemanggilan menambahkan data baru. Untuk pengembangan aset, gunakan `npm run dev` di terminal terpisah.

## Penggunaan

1. Buka dashboard, lalu pilih **Buat Invoice**.
2. Isi identitas, tanggal, item, pajak, dan status; kemudian simpan.
3. Buka **Semua Invoice** untuk mencari, memfilter, mengedit, atau menghapus tagihan. Status juga dapat diperbarui dari detail invoice.
4. Pilih **Cetak Invoice** untuk mencetak atau menyimpan PDF. Gunakan A4/potret dan nonaktifkan header/footer browser.

## Pengujian

Jalankan `php artisan test`. Pengujian mencakup CRUD, nomor unik, item, perhitungan, validasi, status, pencarian/filter, statistik, dan rollback transaksi. Database pengujian berada dalam memori sehingga tidak mengubah data lokal.

## Batasan

Aplikasi ini merupakan demo lokal untuk satu pengguna, tanpa autentikasi, payment gateway, atau pembayaran otomatis. Status pembayaran diperbarui secara manual. Penggunaan publik memerlukan autentikasi dan perlindungan tambahan. Berkas `.env` dan database lokal tidak disertakan dalam repository.
