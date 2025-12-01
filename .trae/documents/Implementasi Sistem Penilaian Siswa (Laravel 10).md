## Ringkasan
- Membangun aplikasi penilaian siswa untuk satu guru dengan dua peran: Guru (login) dan Guest/Siswa (cek nilai tanpa login).
- Mengimplementasikan CRUD Kelas, Mata Pelajaran, Siswa; input nilai multi-step; dashboard statistik; halaman guest cek nilai; ekspor PDF/Excel.
- Menjaga keamanan (auth, CSRF, validasi, rate limit) dan UI responsif dengan Tailwind.

## Status Proyek Saat Ini
- Proyek Laravel 10 sudah ada dengan struktur standar dan beberapa view awal (`resources/views/auth`, `resources/views/admin`).
- `routes/web.php` masih default (hanya `/`).
- Paket yang terpasang: `realrashid/sweet-alert`. Paket PDF/Excel belum ada.
- Frontend memakai Tailwind v4 (`@tailwindcss/vite`, `tailwindcss@^4.1.17`). Spesifikasi meminta Tailwind 3.x — akan disesuaikan ke v3 dan menambahkan `@tailwindcss/forms`, `alpinejs`, serta heroicons.

## Paket & Setup
- Composer: tambah `barryvdh/laravel-dompdf`, `maatwebsite/laravel-excel`.
- NPM: gunakan `tailwindcss@^3`, `@tailwindcss/forms`, `alpinejs@^3`, `heroicons` (SVG inline atau via web), `toastr` (opsional, jika tidak memakai SweetAlert toast).
- Konfigurasi Vite untuk memuat Tailwind 3 dan Alpine.

## Database & Model
- Migration baru/ubah sesuai spesifikasi:
  1. `users`: tambah kolom `username (unique)`, `nama_lengkap`, gunakan `password` hashed. (Jika ada `email` dari default, biarkan atau tidak digunakan.)
  2. `kelas`: `id`, `nama_kelas (unique)`, timestamps.
  3. `mata_pelajaran`: `id`, `kode_mapel (unique)`, `nama_mapel`, timestamps.
  4. `siswa`: `id`, `nis (unique)`, `nama_lengkap`, `kelas_id (FK ke kelas, cascade)`, timestamps.
  5. `nilai`: `id`, `siswa_id`, `mapel_id`, `kelas_id` (semua FK cascade), kolom nilai `decimal(5,2)` nullable, `nilai_akhir decimal(5,2)` nullable, unique index `['siswa_id','mapel_id']`.
- Model & relasi:
  - `User`: fillable `username`, `nama_lengkap`, `password`.
  - `Kelas`: `hasMany(Siswa)`.
  - `MataPelajaran`: `hasMany(Nilai)`.
  - `Siswa`: `belongsTo(Kelas)`, `hasMany(Nilai)`.
  - `Nilai`: `belongsTo(Siswa)`, `belongsTo(MataPelajaran)`, `belongsTo(Kelas)`.
- Mass assignment: set `$fillable` yang aman; sembunyikan `password` di `User`.

## Validasi (Form Request)
- Buat Form Request:
  - `AuthLoginRequest` (username, password, remember me).
  - `KelasRequest` (required, unique `nama_kelas`).
  - `MataPelajaranRequest` (required `nama_mapel`, unique `kode_mapel`).
  - `SiswaRequest` (required `nis` numeric unique, `nama_lengkap` string, `kelas_id` exists).
  - `NilaiBulkRequest` (validasi list angka 0–100 untuk tugas, UH, UTS, UAS; bisa gunakan array rules).

## Autentikasi
- Halaman login `/login` untuk Guru:
  - Form dengan `username`, `password`, checkbox `remember`.
  - Gunakan `Auth::attempt(['username' => ..., 'password' => ...], $remember)`.
  - Rate limiting: `throttle:5,1` pada route atau `RateLimiter` untuk limit login.
  - Redirect ke `/dashboard` saat sukses; tampilkan error saat gagal.
- Logout menghapus session (`Auth::logout`), redirect ke `/login`.

## Routes
- Guest routes: `/` (landing), `/cek-nilai` (hasil pencarian & detail nilai), `/transkrip/pdf` (generate PDF).
- Auth group (`middleware:auth`): `/dashboard`, `/kelas`, `/mata-pelajaran`, `/siswa`, `/nilai`.
- Login/Logout: `GET /login`, `POST /login`, `POST /logout`.
- Penamaan route konsisten (mis. `kelas.index`, `mapel.store`, dll.).

## Controller
- `AuthController`/`LoginController`: form login, proses login (validasi, rate limit), logout.
- `DashboardController`: hitung statistik (`Total siswa`, `Total kelas`, `Total mapel`), kirim ke view dashboard; header menampilkan `nama_lengkap` guru.
- `KelasController`: CRUD dengan pagination; validasi unique; hapus dengan konfirmasi SweetAlert.
- `MataPelajaranController`: CRUD pagination; validasi `kode_mapel` unique.
- `SiswaController`: CRUD, pagination; search real-time (Alpine men-filter client-side) + server-side filter berdasarkan kelas (query params); relasi ke `Kelas` untuk dropdown.
- `NilaiController`:
  - Halaman `/nilai/input`: multi-step (pilih kelas → pilih mapel → tabel input nilai).
  - Ambil daftar siswa per kelas; pre-fill nilai jika sudah ada; hitung otomatis `nilai_akhir = 0.2*Tugas + 0.3*UH + 0.2*UTS + 0.3*UAS` secara front-end (Alpine) dan validasi back-end.
  - Simpan batch: upsert (update jika record ada berdasarkan `siswa_id+mapel_id`, insert jika belum).
- `HomeController`:
  - Landing `/` dengan form pencarian NIS atau Nama.
  - Tampilkan profil siswa (NIS, Nama, Kelas), dropdown mapel, kartu nilai.
  - Grade A/B/C/D berdasar spesifikasi; badge warna.
  - Tombol "Cetak Transkrip" (PDF DomPDF) dan ekspor Excel (opsional).

## Views & UI
- Layouts:
  - `layouts/app.blade.php`: sidebar hijau gradasi, header dengan nama guru & tombol logout, slot untuk konten; responsive (collapse di mobile).
  - `layouts/guest.blade.php`: header dengan logo & judul; hero search.
- Komponen reusable: cards, modals, tables, breadcrumbs, badges grade, toast container.
- Dashboard: 3 stats cards dengan icon (Heroicons), quick access widget.
- Kelas/Mapel/Siswa: tabel pagination (Laravel pagination), tombol hijau tambah, ikon edit (pensil hijau) dan hapus (trash merah), modal Bootstrap/Tailwind untuk tambah/edit.
- Nilai Input: tabel dengan input number 0–100, kolom readonly `Nilai Akhir`; tombol "Simpan Semua Nilai" (hijau) dengan loading spinner.
- Guest hasil nilai: kartu hasil dengan header hijau, body nilai-nilai, Nilai Akhir besar hijau, badge grade berwarna.

## Tailwind & Alpine
- Tailwind 3.x: konfigurasi warna hijau (#10B981, #059669, hover #047857), gray untuk background, font Inter/Poppins, forms plugin, custom spacing/shadows bila perlu.
- Alpine.js: multi-step nilai input, real-time search siswa, toast & transitions.
- SweetAlert2: konfirmasi hapus; Toastr untuk notifikasi sukses/gagal CRUD.

## PDF & Excel
- PDF: `barryvdh/laravel-dompdf` untuk `Cetak Transkrip`; view `resources/views/pdf/transkrip.blade.php`; route di guest.
- Excel (opsional): `NilaiExport` menggunakan `maatwebsite/laravel-excel` untuk ekspor nilai per kelas/mapel.

## Keamanan
- Password hashing bcrypt (default Laravel) saat seeding/registrasi.
- Middleware `auth` untuk halaman admin.
- CSRF protection (default), input sanitized oleh Laravel.
- Validasi via FormRequest; Eloquent ORM mencegah SQL injection.
- Rate limiting untuk login.
- `$fillable` pada model untuk mencegah mass assignment.

## Seeder
- `UserSeeder`: buat user `username: guru`, `password: bcrypt('guru123')`, `nama_lengkap: Bapak Guru`.
- `KelasSeeder`: `10 IPA 1`, `11 IPA 1`, `12 IPA 1`.
- `MataPelajaranSeeder`: sesuai daftar kode/nama.
- `SiswaSeeder`: 10 siswa per kelas (NIS berurutan `2024001` dst, nama dummy).
- `NilaiSeeder`: nilai random 60–95 untuk ±50% siswa.
- Registrasi di `DatabaseSeeder`.

## Breadcrumb & Navigasi
- Breadcrumb di semua halaman admin; sidebar dengan menu: Dashboard, Data Kelas, Data Mata Pelajaran, Data Siswa, Input Nilai, Logout.

## Pagination & UX
- Pagination 15 item per page untuk semua tabel; loading state pada submit; smooth transitions.

## Rencana Implementasi Teknis
1. Tambah paket Composer (PDF, Excel) dan NPM (Tailwind 3, forms, Alpine, heroicons, toastr).
2. Sesuaikan konfigurasi Tailwind 3 dan Vite; siapkan stylesheet & script (import Alpine).
3. Buat migrations 5 tabel (dan migrasi alter `users`).
4. Buat model & relasi; set `$fillable`/hidden.
5. Buat Form Requests untuk semua entitas.
6. Buat controllers seperti di atas; implementasi logic CRUD, filter, upsert nilai.
7. Definisikan routes lengkap (guest, auth, login/logout, nilai input).
8. Buat layouts & komponen UI; implementasi halaman-halaman (dashboard, kelas, mapel, siswa, nilai, home guest, pdf).
9. Integrasi SweetAlert/Toastr untuk UX; Alpine untuk interaktivitas.
10. Buat seeders dan registrasikan; jalankan migrasi & seeding.
11. Verifikasi end-to-end: login → dashboard → CRUD → input nilai → cek nilai guest → cetak PDF/ekspor Excel.

## Output & Cara Menjalankan
- Setelah konfirmasi, saya akan mengimplementasikan semua perubahan.
- Jalankan: `composer install` (paket baru), `npm install`, `php artisan migrate --seed`, `npm run dev`, lalu akses `/login` dan `/`.

Apabila Anda setuju, saya akan mulai menerapkan rencana ini dan menyesuaikan Tailwind ke v3 sesuai spesifikasi, menambahkan semua controller, routes, migrations, seeders, dan view yang dibutuhkan hingga aplikasi siap pakai.