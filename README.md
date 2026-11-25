## Catatan artisan serve dan composer run dev
Modul ini cukup memakai php artisan serve karena kita tidak mengkompilasi file CSS/JS dengan Vite, melainkan memanggil CSS/gambar secara langsung dan mengambil Bootstrap dari CDN.

## Versi Tools
- PHP: 8.5.12
- Composer: 2.10.3
- Laravel Installer: 5.32.0

## jawaban langkah 4
Karena perintah migrate:fresh selalu menghapus bersih (drop) semua tabel yang ada terlebih dahulu, lalu membuat ulang tabelnya dari awal, baru kemudian --seed mengisinya kembali dengan data. Jadi, datanya akan selalu kembali ke posisi 3 promotor dan 5 konser, tidak akan pernah berlipat ganda.

## jawaban Latihan debugging(Modul MVC, Migration dan CRUD)

1. Koneksi ditolak: Kemungkinan pertama adalah layanan MySQL di aplikasi XAMPP belum dinyalakan. Kemungkinan kedua adalah pengaturan koneksi di file .env (seperti DB_PORT, DB_HOST, atau DB_DATABASE) salah atau tidak sesuai. Cara memeriksanya adalah dengan memastikan modul MySQL di XAMPP sudah berwarna hijau, dan mengecek kembali kecocokan isi file .env dengan pengaturan database di phpMyAdmin.

2. Model belum punya $fillable: Error ini muncul karena Laravel memiliki sistem perlindungan bawaan terhadap celah keamanan mass assignment. Cara memperbaikinya adalah dengan menambahkan properti protected $fillable = ['kolom1', 'kolom2']; di dalam file Model. Jika $fillable sudah dideklarasikan tetapi kolom 'tanggal' tidak ikut ditulis, Laravel akan membuang isian tanggal tersebut secara diam-diam sehingga datanya tidak akan tersimpan ke database

3. 419 Page Expired: Form tersebut kehilangan arahan token pengaman @csrf

4. 405 Method Not Allowed: Form tersebut kehilangan arahan @method('PUT'). Arahan ini wajib ditambahkan karena form HTML biasa hanya mengenali metode GET dan POST

## Jawaban pertanyaan Seeder
Mengapa data tidak bertambah migrate:fresh --seed dijalankan dua kali? Karena perintah migrate:fresh selalu menghapus seluruh tabel berserta datanya terlebih dahulu sebelum membuat ulang dan menjalankan seeder, sehingga data selalu kembali ke kondisi awal dan tidak menumpuk

## Jawab Latihan Debugging(Modul Transaksi Pesanan)

1. Debugging 1 (total dari from): Kesalaannya adalah mengambil harga total dari input tersembunyi (<input type="hidden">) di form. Ini sangat berbahaya karena pengguna dapat memanipulasi nilainya lewat fitur Inspect Element?DevTools di browser, misalnya mengubah total belanja menjadi 1 rupiah. Perbaikannya adalah server wajib menghitung sendiri total harganya dari database (yaitu harga_satuan dikali jumlah)

2. Debugging 2 (pengecekkan stok tanpa kunci): Kesalahannya adalah mengecek sisa tiket tanpa mengunci baris data di database. Ini berbahaya karena jika ada dua pembeli yang menekan tombol di waktu yang persis bersamaan, tiket bisa terjual melebihi batas stok(oversell). Perbaikannya adalah baris data konser harus dibaca dan dikunci menggunakan fungsi lockForUpdate() sebelum mengecek sisa stok.

## Jawaban Latihan Debugging(Modul Laporan)
- Penyebab: isian dari form tanggal. hanya mengirimkan tanggal tanpa jam, sehingga sistem otomatis menganggapnya sebagai pukul 00:00:00. Sementara kolom created_at di database menyimpan tnaggal berserta jamnya misalnya 2026-11-12 14:30:00 karena 14:30 secra waktu lebih besar daripada 00:00, pesanan hari ini tidak memenuhi syarat <= dan tidak dimunculkan

- Perbaikan: Gunakan method whereDate daripada pakai where biasa. Method whereDate akan mengabaikan jam pada database dan memfokuskan perbandingan hanya pada format tanggalnya saja.
->when($request->query('sampai'), function ($query, $sampai) {
    $query->whereDate('created_at', '<=', $sampai);
})
- 'where' diubah menjadi 'whereDate'

## Jawaban Latihan Debugging (Modul Laporan dan Ekspor PDF)
- Peyebab: Layout layouts/main.blade.php memuat gaya Bootstrap dari link eksternl serta elemen khusus web seperti navbar dan footer. Paket pembuat pdf (dompdf) memiliki keterbatasan seperti tidak bisa mengandalkan file CSS eksternal secara stabil dan hanya mendukung CSS dasar versi 2.1 akibatnya seluruh gaya desain bootstrap gaagal dirender sehingga PDDF menjadi berantakan

- Perbaikan: Hapus arahan @extends('layouts.main'), @section, beserta penutupnya dari file laporan-pdf.blade.php. Dokumen PDF harus dibuat sebagai file HTML yang berdiri sendiri tanpa layout bawaan web, lalu css ditulis secara manual dan sederhana langsung dalam tag <style> pada file tersebut.

## Jawaban Latihan Debugging (Modul API dan autentikasi)

### Debug 1: Pesanan dari semua isian
- **Kesalahan**
  Langsung menyimpan semua input mentah dari klien memakai 'Pesanan::create($request->all())' tanpa validasi dan tanpa memilih kolom, padahal 'harga_satuan', 'total', dan 'status' terdaftar di '$fillable' model 'Pesanan'
- **Kenapa berbahaya**
  Membuka celah manipulasi data (*mass assignment*). Penyerang bisa memalsukan `harga_satuan` dan `total` menjadi `1`, serta langsung mengubah `status` menjadi `lunas` tanpa membayar. Selain itu, pengecekan dan pengurangan stok juga terlewati.
- **Perbaikan**
  Validasi hanya kolom yang boleh diisi pelanggan (`nama_pemesan`, `email`, `jumlah`) memakai `$request->validate(...)`. Saat membuat pesanan, isi `harga_satuan`, `total` (dihitung server), dan `status` (`Pesanan::MENUNGGU_BAYAR`) secara eksplisit di dalam `DB::transaction` lengkap dengan `lockForUpdate()` dan `decrement('sisa')`.

## Debug 2: Postman menerima HTML
- **Kesalahan:**
  Request ke endpoint API (`GET /api/user`) dikirim tanpa
  menyertakan header `Accept: application/json`.
- **Kenapa bermasalah:**
  Laravel menebak jenis klien dari header `Accept`. Karena
  header kosong, Laravel mengira klien adalah browser, sehingga
  middleware `auth` mengalihkan (*redirect*) ke route `login`—
  muncul error `Route [login] not defined` sebelum Bab 7, atau
  mengembalikan halaman HTML login (status `200`) sesudah Bab 7.
  Klien API akan gagal membaca balasan HTML tersebut.
- **Perbaikan:**
  Selalu kirim header `Accept: application/json` di setiap
  request API agar Laravel otomatis membalas dengan JSON
  `401 {"message": "Unauthenticated."}`.

  ### Debugging 3: Login yang selalu 419
- **Kesalahan:**
  Form login menggunakan metode `POST` tanpa menyertakan direktif `@csrf` di dalam tag `<form>`.
- **Kenapa berbahaya (dan kenapa tidak boleh mematikan CSRF):**
  Laravel mewajibkan token CSRF pada setiap form `POST` untuk memastikan permintaan benar-benar berasal dari aplikasi sendiri.
  Mematikan pemeriksaan CSRF sebagai jalan pintas sangat berbahaya karena membuka celah serangan *Cross-Site Request Forgery* (situs lain bisa memaksa browser pengguna mengirim permintaan berbahaya secara diam-diam).
- **Perbaikan:**
  Tambahkan direktif `@csrf` tepat di bawah tag pembuka `<form action="{{ route('login.proses') }}" method="POST">`.

### Debugging 4: Login buatan sendiri
- **Kesalahan:**
  Tidak menggunakan `Auth::attempt()`, membandingkan password secara mentah (`$user->password !== $request->password`), tidak melakukan validasi input, memberi pesan error berbeda untuk email vs password, dan tidak memanggil `$request->session()->regenerate()` setelah login.
- **Kenapa berbahaya:**
  1. Perbandingan teks biasa menandakan kata sandi tidak disimpan dalam bentuk hash, sehingga mudah bocor jika database diretas.
  2. Pesan error yang berbeda memudahkan penyerang menebak email mana yang terdaftar (*userenumeration*).
  3. Tanpa regenerasi session, aplikasi rentan terhadap serangan *session fixation* (penyerang memanfaatkan ID session lama korban).
- **Perbaikan:**
  Validasi input dengan `$request->validate(...)`, verifikasi dengan `Auth::attempt($credentials)` serta satu pesan gagal yang sama (`Email atau kata sandi salah.`) disertai `onlyInput('email'`, lalu panggil `$request->session( ->regenerate()` sebelum `redirect()->intended(route('pesanan.index'))`.