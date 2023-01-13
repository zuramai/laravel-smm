# Laravel SMM

A social media marketing app where users can buy various social media booster services like Instagram followers, Youtube subscribers, Twitter likes, and many more.


[![tag](https://img.shields.io/github/tag/zuramai/laravel-smm.svg)](https://github.com/zuramai/laravel-smm) [![License: MIT](https://img.shields.io/badge/License-GPL-blue.svg)](https://github.com/zuramai/laravel-smm/blob/master/LICENSE) [![Issue](https://img.shields.io/github/issues/zuramai/laravel-smm)](https://img.shields.io/github/issues/zuramai/laravel-smm) [![Forks](https://img.shields.io/github/forks/zuramai/laravel-smm)](https://img.shields.io/github/forks/zuramai/laravel-smm) [![Stars](https://img.shields.io/github/stars/zuramai/laravel-smm)](https://img.shields.io/github/stars/zuramai/laravel-smm)

![image](https://user-images.githubusercontent.com/45036724/177029755-a54a7980-4ebd-4edb-801a-94b0fb4fd00a.png)

# Installation

1. Clone this repository
```bash
git clone https://github.com/zuramai/laravel-smm
```
2. Install dependencies
```bash
cd laravel-smm
npm install
composer install
```

4. Change database information in [.env](https://github.com/zuramai/laravel-smm/blob/master/.env) file

5. Database setup

```bash
php artisan migrate --seed
```

5. Run the app locally
```
npm run watch
php artisan serve
```

Untuk deploy di hosting, bisa ikuti cara ini: [Hosting installation](hosting-installation.md).

# Features

- Konfigurasi website melalui halaman admin (logo, judul, deskripsi website, dll)
- 🔥⭐ Tambah operan sosmed & pulsa melalui halaman admin (tanpa perlu coding).
- Website Installer, agar memudahkan untuk mengkoneksikan database tanpa coding ulang.
- Special Price, dapat memberikan harga spesial untuk username tertentu ke layanan tertenu.
- Unread ticket untuk member dan admin. Dapat melihat jumlah tiket yang belum dibaca.
- Admin Statistik, admin dapat melihat statistik keseluruhan dari panel. Contoh: total keuntungan panel, total deposit, total saldo member, dan lain-lain.
- Auto deposit 
    - OVO/GOPAY/Mandiri/BRI/BCA dari Cekmutasi auto aktif jika sudah ditambah di “Kelola metode deposit”
    - Telkomsel/XL via EnvayaSMS
- Mass Order Sosmed. Bisa order banyak sekaligus dalam 1x order.
- API Profile. Tersedia API untuk informasi akun (sisa saldo, level)

## Admin Account

admin@gmail.com	
admin

## Website Configuration

Konfigurasi website (logo, deskripsi, kode mata uang, dll) dapat dilakukan di {domain}/developer/configuration

## Perhatian!

- Versi PHP Minimal 8.0.2
- Wajib mengaktifkan "mysqli" dan "pdo_mysqli" di `php.ini`
- Dalam file .env, ubah `APP_DEBUG` menjadi false dan `APP_ENV` menjadi Production, jika tidak diubah maka akan menjadi bug di website

## Setting operan

Provider seperti JAP, PERFECTSMM, dll silahkan tambah provider dengan tanpa spasi & capslock di halaman `{domain}/developer/providers`


## Menjalankan Cronjob

- Jalankan command:
```bash
cd /home/{NAMA USER CPANEL}/laravel && php -d register_argc_argv=On artisan schedule:run >> /home/{NAMA USER CPANEL}/logs/cron.log 2>&1 
```

- Ubah {NAMA USER CPANEL} menjadi nama user cpanelmu
- Buka laravel/console/Kernel.php
- Hapus operan yang dirasa tidak diperlukan (untuk menghindari error)






# License

This repository is under GPL License
