## Catatan artisan serve dan composer run dev
Modul ini cukup memakai php artisan serve karena kita tidak mengkompilasi file CSS/JS dengan Vite, melainkan memanggil CSS/gambar secara langsung dan mengambil Bootstrap dari CDN.

## Versi Tools
- PHP: 8.5.12
- Composer: 2.10.3
- Laravel Installer: 5.32.0

## jawaban langkah 4
Karena perintah migrate:fresh selalu menghapus bersih (drop) semua tabel yang ada terlebih dahulu, lalu membuat ulang tabelnya dari awal, baru kemudian --seed mengisinya kembali dengan data. Jadi, datanya akan selalu kembali ke posisi 3 promotor dan 5 konser, tidak akan pernah berlipat ganda.