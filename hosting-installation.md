## Install Laravel SMM di cPanel

1. Buka file sc yang telah diberikan
2. Compress zip scnya (jika sudah diberikan yang .zip maka tidak usah lagi)
3. Login cpanel
4. Buat folder bernama "laravel" (sebelum public_html)
5. Ekstrak scnya difolder "laravel"
6. Jika sudah diekstrak, buka folder "public" didalam folder laravel
7. Pindahkan semua isi dari dalam folder public, ke public_html
8. Edit file public_html/index.php
9. Ikuti tutorial di https://www.rumahweb.com/journal/cara-upload-laravel-ke-hosting-cpanel/
10. Import database (db.sql) ke database yang sudah dibuat
10. Konfigurasi database, domain, panel, dll silahkan edit file laravel/.env

## Setting operan
Provider seperti JAP, PERFECTSMM, dll silahkan tambah provider dengan tanpa spasi & capslock di halaman {domain}/developer/providers


# Menjalankan Cronjob
- Jalankan command:
cd /home/{NAMA USER CPANEL}/laravel && php -d register_argc_argv=On artisan schedule:run >> /home/{NAMA USER CPANEL}/logs/cron.log 2>&1 

- Ubah {NAMA USER CPANEL} menjadi nama user cpanelmu
- Buka laravel/console/Kernel.php
- Hapus operan yang dirasa tidak diperlukan (untuk menghindari error)

# Admin Account
admin@gmail.com	
admin


# Website Configuration
Konfigurasi website (logo, deskripsi, kode mata uang, dll) dapat dilakukan di {domain}/developer/configuration

# Perhatian!
- Versi PHP Minimal 7.2 / 7.3
- Wajib mengaktifkan "mysqli" dan "pdo_mysqli" di cPanel (menu Select PHP Version)
- Dalam file .env, ubah APP_DEBUG menjadi false dan APP_ENV menjadi Production, jika tidak diubah maka akan menjadi bug di panel
