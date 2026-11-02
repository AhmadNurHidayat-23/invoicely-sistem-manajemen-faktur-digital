# Invoicely — Sistem Informasi Manajemen Invoice dan Penagihan Digital

## Deskripsi Sistem

Invoicely merupakan aplikasi web untuk membuat, menyimpan, mengelola, dan mencetak invoice secara digital. Aplikasi ini menyatukan identitas pengirim, informasi pelanggan, rincian produk atau jasa, tanggal penagihan, serta status pembayaran dalam sebuah pencatatan yang terstruktur. Seluruh antarmuka menggunakan bahasa Indonesia dan dirender di server melalui Blade.

Sistem dikembangkan untuk mendukung kebutuhan penagihan sederhana bagi pekerja lepas, studio, dan usaha berskala kecil. Pengguna dapat menyusun invoice dengan beberapa item, menghitung pajak opsional, menemukan tagihan melalui pencarian, serta meninjau ringkasan invoice melalui dashboard. Identitas pihak terkait disimpan pada setiap invoice agar dokumen tetap sesuai dengan data saat dibuat dan dapat dicetak kembali.

Dibandingkan pengelolaan dokumen secara manual, Invoicely mengurangi pengulangan perhitungan dan membantu menjaga konsistensi pencatatan. Nomor invoice dibuat otomatis, nilai tagihan dihitung kembali di server, dan status pembayaran disimpan bersama dokumen. Aplikasi ini ditujukan sebagai demonstrasi sistem informasi berbasis Laravel serta lingkungan pengembangan lokal untuk satu pengguna.

## Latar Belakang

Pengelolaan invoice melalui dokumen terpisah atau lembar kerja yang tidak terpusat dapat menyulitkan pencarian tagihan dan pemantauan pembayaran. Ketika jumlah transaksi meningkat, pencatatan manual juga rentan terhadap nomor dokumen ganda, kesalahan penjumlahan, dan perbedaan rincian antara dokumen yang disimpan dengan dokumen yang dicetak.

Invoicely dikembangkan untuk menyediakan alur pengelolaan invoice yang sederhana dan konsisten. Struktur data yang saling terhubung, validasi isian, serta perhitungan otomatis membantu pengguna menyusun dan meninjau tagihan tanpa harus mengulangi proses administrasi yang sama pada setiap transaksi.

## Tujuan Sistem

- Mempermudah pembuatan invoice yang memuat informasi penagihan secara lengkap.
- Menyimpan data invoice dan item dalam satu database lokal.
- Mengotomatisasi perhitungan subtotal, pajak, dan total tagihan secara konsisten.
- Membantu pemantauan status pembayaran melalui dashboard dan filter invoice.
- Mempermudah pencetakan invoice atau penyimpanan dokumen sebagai PDF melalui browser.
- Menunjukkan penerapan MVC, Eloquent, validasi, transaksi database, dan Blade dalam aplikasi Laravel.

## Fitur Utama Sistem

| Fitur | Fungsi |
| --- | --- |
| Dashboard | Menampilkan jumlah invoice, jumlah lunas dan belum lunas, total nilai tagihan, invoice terbaru, serta jumlah invoice yang melewati jatuh tempo. Semua nilai berasal dari database. |
| Manajemen invoice | Membuat, melihat, mengedit, dan menghapus invoice beserta identitas pengirim, pelanggan, tanggal, dan catatan. |
| Nomor otomatis | Membentuk nomor unik seperti `INV-2026-000001` berdasarkan tahun tanggal invoice dan ID database. Nomor tidak berubah ketika invoice diedit dan nomor yang dihapus tidak digunakan kembali. |
| Manajemen item | Menambahkan, mengubah, atau menghapus rincian produk/jasa dalam formulir. Setiap invoice memiliki minimal satu dan maksimal 100 item. |
| Perhitungan otomatis | Menghitung total setiap item, subtotal, pajak opsional, dan total akhir. Pratinjau browser membantu pengisian; server menentukan nilai yang disimpan. |
| Status pembayaran | Menyimpan status Draft, Belum Lunas, atau Lunas. Status dapat diubah melalui formulir atau halaman detail. |
| Pencarian dan filter | Mencari nomor invoice atau nama pelanggan, memfilter status, menggabungkan kedua kriteria, dan menelusuri hasil melalui paginasi. |
| Cetak invoice | Menyediakan dokumen dengan identitas pihak terkait, rincian tagihan, status, catatan, dan CSS cetak A4. PDF disimpan melalui dialog cetak browser. |
| Validasi dan notifikasi | Memvalidasi isian di server, menampilkan pesan berbahasa Indonesia, mempertahankan isian saat terjadi kesalahan, dan meminta konfirmasi sebelum penghapusan. |

Dashboard menghitung **Invoice Belum Lunas** hanya dari status Belum Lunas; Draft ditampilkan sebagai kategori terpisah dalam daftar. **Total Nilai Invoice** menjumlahkan seluruh invoice, termasuk Draft dan Lunas, sehingga angka ini merupakan nilai dokumen yang tercatat, bukan laporan pendapatan atau saldo piutang.

## Alur Kerja Sistem

1. Pengguna membuka dashboard untuk melihat ringkasan pencatatan dan invoice terbaru.
2. Pengguna memilih **Buat Invoice** untuk membuka formulir penagihan.
3. Pengguna mengisi nama serta alamat pengirim dan pelanggan. Data disimpan langsung pada invoice sebagai salinan identitas dokumen.
4. Pengguna menentukan tanggal invoice, jatuh tempo, status awal, serta rincian produk atau jasa. Baris item dapat ditambah atau dihapus sesuai kebutuhan.
5. Browser menampilkan pratinjau subtotal, pajak, dan total. Pajak dapat diisi `0` atau dikosongkan jika tidak digunakan.
6. Ketika formulir dikirim, Laravel memvalidasi seluruh data dan menghitung ulang tagihan. Invoice beserta item disimpan dalam satu transaksi database.
7. Pengguna diarahkan ke detail invoice untuk meninjau dokumen, melakukan pengeditan, atau memperbarui status pembayaran. Invoice dapat dicari kembali melalui menu **Semua Invoice**.
8. Pengguna memilih **Cetak Invoice**, lalu mencetak pada kertas A4 atau memilih **Simpan sebagai PDF** pada dialog browser.

## Teknologi yang Digunakan

| Teknologi | Peran |
| --- | --- |
| Laravel 13 | Menangani routing, controller, validasi, transaksi, dan siklus permintaan aplikasi. |
| Blade | Menyusun layout, komponen, formulir, tabel, dan dokumen invoice yang dirender di server. |
| Eloquent ORM | Mengelola model, relasi invoice-item, pencarian, filter, dan agregasi statistik. |
| SQLite | Menyimpan data pada satu berkas lokal tanpa konfigurasi server MySQL. |
| HTML5 dan CSS3 | Membentuk antarmuka responsif bergaya Swiss editorial dengan warna netral, border tipis, dan aksen biru terbatas. |
| Vanilla JavaScript | Menangani baris item dinamis, pratinjau perhitungan, menu seluler, konfirmasi penghapusan, dan cetak browser. |
| Vite | Membangun serta memberi versi pada aset CSS, JavaScript, dan font Inter lokal. |
| PHPUnit | Menguji perhitungan dan alur aplikasi melalui pengujian unit serta fitur Laravel. |

Aplikasi tidak menggunakan React, Vue, Inertia, Livewire, framework CSS tambahan, atau library PDF. Font Inter disertakan secara lokal agar tampilan tidak bergantung pada layanan font eksternal ketika aplikasi dijalankan.

## Struktur Database

### Tabel `invoices`

Menyimpan nomor invoice yang unik, nama dan alamat pengirim/pelanggan, tanggal invoice, tanggal jatuh tempo, persentase pajak, subtotal, nilai pajak, total, status pembayaran, catatan, dan waktu pencatatan. Nama pelanggan dan status memiliki indeks untuk mendukung pengelolaan daftar invoice.

Kolom `tax_percentage` menyimpan **basis poin** sebagai bilangan bulat: `1100` berarti 11,00% dan `1125` berarti 11,25%. Formulir dan dokumen menampilkan persentase biasa. Kolom `subtotal`, `tax_amount`, dan `total` menyimpan nilai dalam Rupiah bulat.

### Tabel `invoice_items`

Menyimpan referensi invoice, nama produk atau jasa, jumlah, harga satuan, total harga, dan waktu pencatatan. Harga satuan dan total harga menggunakan bilangan bulat Rupiah. Jumlah item menggunakan bilangan bulat positif.

Satu `Invoice` memiliki banyak `InvoiceItem` melalui `hasMany`; setiap item merujuk satu invoice melalui `belongsTo`. Foreign key dengan `cascadeOnDelete` memastikan item terkait ikut dihapus. Pembuatan dan pengeditan dijalankan dalam transaksi; kegagalan penyimpanan item membatalkan perubahan invoice secara keseluruhan.

### Ketentuan Perhitungan

- Jumlah per item: 1–1.000 unit, tanpa pecahan.
- Harga satuan: Rp0–Rp999.999.999, tanpa pecahan Rupiah.
- Jumlah baris: 1–100 item per invoice.
- Pajak opsional: 0–100%, maksimal dua angka desimal.
- Total item = jumlah × harga satuan.
- Subtotal = jumlah seluruh total item.
- Nilai pajak = subtotal × tarif pajak, dibulatkan **half-up** ke Rupiah terdekat satu kali pada total pajak.
- Total tagihan = subtotal + nilai pajak.

Contoh: dua unit jasa dengan harga Rp125.000 menghasilkan subtotal Rp250.000. Pajak 11,25% bernilai Rp28.125, sehingga total tagihan Rp278.125. Server menggunakan operasi integer dan basis poin. Pratinjau browser menggunakan `BigInt` dengan aturan pembulatan yang sama; nilai subtotal atau total yang dikirim klien tidak digunakan.

## Struktur Aplikasi

```text
app/Http/Controllers/     Dashboard dan alur CRUD invoice
app/Http/Requests/        Validasi data invoice
app/Models/               Invoice dan InvoiceItem
app/Services/             Perhitungan dan transaksi penyimpanan
resources/views/          Layout, komponen, serta halaman Blade
resources/css/            Gaya antarmuka, formulir, dokumen, dan cetak
resources/js/             Interaksi ringan dan pratinjau perhitungan
resources/fonts/          Font Inter lokal beserta lisensinya
lang/id/                  Pesan validasi dan paginasi Indonesia
database/migrations/      Skema SQLite
database/seeders/         Data demonstrasi opsional
tests/                    Pengujian unit dan fitur
```

Berkas kode aplikasi dipisahkan berdasarkan tanggung jawab dan dibatasi maksimal 300 baris per berkas. CSS dan JavaScript ditempatkan di aset tersendiri; Blade menggunakan komponen serta partial untuk bagian yang digunakan kembali. Berkas lock dependensi dibuat oleh pengelola paket dan bukan kode aplikasi.

## Cara Menjalankan Aplikasi

### Persyaratan

- PHP **8.5** versi 64 bit, sesuai batas versi dan dependensi yang dikunci pada proyek ini.
- Ekstensi PHP yang dibutuhkan Laravel, termasuk PDO SQLite, SQLite3, Mbstring, OpenSSL, XML, Ctype, Fileinfo, dan Tokenizer.
- Composer 2.
- Node.js 22.12 atau lebih baru yang didukung Vite, beserta npm. Lingkungan pengembangan awal menggunakan Node.js 26.
- Browser modern dengan dukungan `BigInt`.

Laravel 13 mendokumentasikan PHP 8.3 sebagai versi minimum framework. Proyek ini sengaja menggunakan PHP 8.5 agar sesuai dengan lingkungan pengembangan dan seluruh dependensi dalam `composer.lock`.

### Instalasi dari Repository

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

Buka [http://127.0.0.1:8000](http://127.0.0.1:8000). Jalankan seluruh perintah dari direktori proyek. Konfigurasi `.env.example` menggunakan SQLite, sesi berbasis berkas, cache berbasis berkas, bahasa Indonesia, dan zona waktu Asia/Jakarta. Tanpa `DB_DATABASE` khusus, Laravel menggunakan `database/database.sqlite` secara otomatis.

Database awal kosong sehingga dashboard menampilkan kondisi belum ada invoice. Berkas `.env`, database lokal, dependensi, log, dan hasil build tidak disimpan dalam Git. File `composer.lock` dan `package-lock.json` disertakan untuk instalasi yang konsisten.

Untuk pengembangan aset, jalankan `npm run dev` di terminal kedua sambil menjalankan Laravel. Untuk penggunaan lokal biasa, `npm run build` sudah cukup; tidak perlu menjalankan server Vite secara terus-menerus.

### Penggunaan pada MAMP di macOS

Lokasi proyek lokal yang digunakan:

```text
/Applications/MAMP/htdocs/invoicely-digital-invoice-management-system
```

Jika `php` di terminal belum menunjuk PHP yang sesuai, gunakan PHP 8.5 MAMP yang tersedia pada komputer ini:

```bash
export PATH="/Applications/MAMP/bin/php/php8.5.2/bin:$PATH"
php -v
cd /Applications/MAMP/htdocs/invoicely-digital-invoice-management-system
php artisan serve --host=127.0.0.1
```

PHP Homebrew 8.5 juga dapat digunakan. Tidak perlu menyalakan MySQL MAMP karena database menggunakan SQLite. Jika menggunakan Apache MAMP, arahkan document root situs ke direktori `public` proyek; `php artisan serve` tetap menjadi cara paling langsung untuk menjalankan demo. Konfigurasi proyek MAMP lain tidak perlu diubah.

### Data Demonstrasi Opsional

Untuk melihat contoh dashboard dengan data fiktif:

```bash
php artisan db:seed --class=DemoInvoiceSeeder
```

Seeder menambahkan lima invoice bertanda **(Contoh)** dengan variasi status dan jatuh tempo. Perintah ini menambahkan data setiap kali dijalankan; tidak otomatis menghapus atau mengganti invoice yang sudah ada. Tidak ada data contoh yang dimasukkan oleh seeder default.

## Cara Menggunakan Sistem

1. **Membuat invoice:** pilih **Buat Invoice**, isi identitas kedua pihak dan tanggal, lalu tentukan status awal. Kolom wajib ditandai dengan tanda bintang.
2. **Menambahkan item:** isi nama produk/jasa, jumlah, dan harga satuan. Pilih **Tambah Item** untuk baris tambahan atau ikon hapus untuk membuang baris. Satu baris terakhir tetap dipertahankan.
3. **Menentukan pajak:** masukkan persentase sesuai kebutuhan atau gunakan nol. Periksa ringkasan, lalu pilih **Simpan Invoice**. Nomor otomatis ditampilkan setelah penyimpanan berhasil.
4. **Mengedit dokumen:** buka detail dan pilih **Edit Invoice**. Perubahan rincian dihitung ulang; nomor dokumen tetap sama.
5. **Mengelola status:** pada detail, pilih Draft, Belum Lunas, atau Lunas dan tekan **Perbarui**. Perubahan ikut memengaruhi statistik dashboard.
6. **Mencari invoice:** buka **Semua Invoice**, masukkan nomor atau nama pelanggan, pilih status bila diperlukan, lalu tekan **Terapkan**. Gunakan **Reset** untuk menghapus kriteria.
7. **Mencetak invoice:** buka detail, pilih **Cetak Invoice**, tentukan kertas A4 dan orientasi potret, lalu cetak atau simpan sebagai PDF. Nonaktifkan header/footer browser agar URL dan tanggal browser tidak ikut tercetak. Dokumen panjang dapat berlanjut ke halaman berikutnya dengan judul tabel berulang.
8. **Menghapus invoice:** pilih ikon hapus pada tabel dan setujui konfirmasi. Invoice dan seluruh item terkait dihapus permanen dari database lokal.

## Pengujian

```bash
php artisan test
npm run build
php artisan route:list --except-vendor
php artisan view:cache
php artisan view:clear
```

Pengujian Laravel menggunakan SQLite dalam memori sehingga tidak mengubah database invoice lokal. Cakupan pengujian meliputi kondisi awal kosong, halaman dashboard/form/detail, pembuatan dan perubahan invoice, penggantian item, penghapusan berantai, nomor unik, status, statistik database, pencarian, filter gabungan, paginasi, validasi, escaping keluaran, serta pembatalan transaksi saat penyimpanan item gagal.

Pengujian unit memeriksa perhitungan beberapa item, tarif pajak desimal, pembulatan half-up, pajak nol, dan batas nilai tertinggi. Tampilan responsif dan interaksi JavaScript diperiksa melalui browser. Hasil cetak akhir tetap mengikuti pengaturan perangkat dan dialog cetak browser pengguna.

## Batasan Sistem

Invoicely berfokus pada pengelolaan invoice sederhana untuk demonstrasi dan pengembangan lokal. Aplikasi belum mendukung payment gateway, pembayaran otomatis, multi-user, autentikasi, otorisasi, atau pengiriman tagihan melalui email. Status pembayaran diperbarui secara manual; tidak ada verifikasi transfer bank.

Jumlah item hanya mendukung satuan bulat dan harga menggunakan Rupiah bulat. Pajak merupakan satu tarif opsional pada subtotal, bukan perhitungan perpajakan lengkap atau integrasi faktur pajak resmi. Sistem belum menyediakan diskon, pembayaran sebagian, manajemen pelanggan terpisah, maupun laporan akuntansi.

**Jangan menjalankan aplikasi ini sebagai pengelola invoice yang terbuka untuk publik.** Sebelum penggunaan publik diperlukan autentikasi, pembatasan hak akses, konfigurasi produksi, cadangan data, dan perlindungan operasional yang sesuai. Repository GitHub publik hanya membagikan source code; data invoice serta konfigurasi lokal tidak disertakan.

## Penutup

Invoicely menyediakan dasar pengelolaan invoice digital yang terstruktur, mulai dari pencatatan rincian hingga pencetakan dokumen. Pengembangan proyek ini menunjukkan pemanfaatan Laravel 13, Blade, dan SQLite untuk membangun aplikasi web yang dapat ditinjau, dipelajari, serta dijalankan secara lokal dengan alur penggunaan yang jelas dan perhitungan yang konsisten.
