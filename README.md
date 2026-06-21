# SIGAP TUHA

Project awal Laravel untuk aplikasi SIGAP TUHA. Saat ini project sudah berisi:

- Laravel 13
- Konfigurasi dasar sesuai PHP Laragon `8.5.5`
- Halaman awal `SIGAP TUHA`
- Route modul awal: `dashboard`, `lansia`, `laporan`, `peta`, dan `edukasi`
- Database awal menggunakan `SQLite` agar langsung bisa dijalankan

## Menjalankan project

Pastikan Anda memakai PHP Laragon berikut:

```powershell
C:\laragon\bin\php\php-8.5.5-nts-Win32-vs17-x64\php.exe
```

Perintah yang bisa dipakai:

```powershell
& 'C:\laragon\bin\php\php-8.5.5-nts-Win32-vs17-x64\php.exe' artisan serve
```

Jika ingin memastikan dependency:

```powershell
& 'C:\laragon\bin\php\php-8.5.5-nts-Win32-vs17-x64\php.exe' 'C:\laragon\bin\composer\composer.phar' install
```

## Database

Secara default project ini memakai `SQLite` dengan file:

```text
database/database.sqlite
```

Jika ingin pindah ke MySQL Laragon:

1. Ubah `.env`
2. Set `DB_CONNECTION=mysql`
3. Isi `DB_DATABASE`, `DB_USERNAME`, dan `DB_PASSWORD`
4. Jalankan migrasi ulang

```powershell
& 'C:\laragon\bin\php\php-8.5.5-nts-Win32-vs17-x64\php.exe' artisan migrate
```

## Tahap berikutnya

Bagian yang paling siap dilanjutkan:

- autentikasi login dan role
- migration tabel `lansias`
- migration tabel `laporan_darurat`
- CRUD data lansia
- status penanganan laporan
- notifikasi WhatsApp berbasis queue
- integrasi peta dengan Leaflet
