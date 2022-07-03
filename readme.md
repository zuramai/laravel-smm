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

3. Create database and import the given `db.sql` example

4. Change database information in [.env](https://github.com/zuramai/laravel-smm/blob/master/.env) file

5. Run the app locally
```
npm run watch
php artisan serve
```


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


# License

This repository is under GPL License
