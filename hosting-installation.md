## Install Laravel SMM di cPanel

1. Clone repository ini
2. Jalankan `composer update` atau `composer install` di project direktori melalui terminal
3. Compress zip projectnya
3. Login cpanel
4. Buat folder bernama `laravel` (sebelum `public_html`)
5. Ekstrak scnya difolder `laravel/`
6. Jika sudah diekstrak, buka folder `public/` didalam folder laravel
7. Pindahkan semua isi dari dalam folder `public/`, ke `public_html/`
8. Edit file `public_html/index.php`
9. Ikuti tutorial di https://www.rumahweb.com/journal/cara-upload-laravel-ke-hosting-cpanel/
10. Import database (db.sql) ke database yang sudah dibuat
10. Konfigurasi database, domain, panel, dll silahkan edit file `laravel/.env`
