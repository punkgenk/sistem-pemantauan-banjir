# Sistem Drainase Pintar

<p align="justify">
Sistem Pemantauan dan Pelaporan Banjir merupakan aplikasi berbasis web yang dikembangkan menggunakan framework Laravel dengan tujuan untuk mendukung proses pelaporan, pemantauan, dan penanganan kejadian banjir atau genangan air secara terintegrasi. Aplikasi ini dirancang sebagai media penghubung antara masyarakat dan pemerintah dalam upaya meningkatkan kecepatan, ketepatan, serta transparansi penanganan banjir di suatu wilayah.
</p>

<p align="justify">
Melalui aplikasi ini, masyarakat dapat dengan mudah melaporkan kejadian banjir yang terjadi di lingkungan sekitar dengan mengisi informasi yang relevan, seperti lokasi kejadian, kondisi genangan, dan keterangan tambahan. Laporan yang dikirimkan akan tersimpan dalam sistem dan dapat langsung diakses oleh pihak pemerintah atau petugas terkait untuk dilakukan pemantauan dan tindak lanjut.
</p>

<p align="justify">
Di sisi pemerintah, aplikasi ini menyediakan dashboard monitoring yang menampilkan daftar laporan banjir secara terstruktur, lengkap dengan status penanganan yang dapat diperbarui sesuai dengan progres di lapangan. Fitur ini membantu petugas dalam mengelola laporan masuk, menentukan prioritas penanganan, serta memantau kondisi wilayah terdampak secara lebih efektif.
</p>

<p align="justify">
Selain itu, sistem ini juga dilengkapi dengan fitur komunikasi antara masyarakat dan pihak pemerintah, sehingga memungkinkan terjadinya interaksi dua arah. Melalui fitur tersebut, masyarakat dapat memperoleh informasi terkait status laporan yang telah dikirimkan, sementara pemerintah dapat memberikan tanggapan, klarifikasi, atau informasi lanjutan secara langsung melalui sistem.
</p>

<p align="justify">
Aplikasi ini dirancang dengan konsep role-based access, di mana setiap pengguna memiliki hak akses yang berbeda sesuai dengan perannya, seperti masyarakat, pemerintah, dan admin. Dengan penerapan autentikasi pengguna, keamanan data laporan dapat terjaga dengan baik, serta setiap aktivitas pengguna dapat dikelola secara terstruktur.
</p>

<p align="justify">
Dengan adanya Sistem Pemantauan dan Pelaporan Banjir ini, diharapkan proses pelaporan dan penanganan banjir dapat dilakukan secara lebih cepat, terorganisir, dan transparan, serta mampu mendukung pengambilan keputusan oleh pihak pemerintah berdasarkan data laporan yang terkumpul. Aplikasi ini juga diharapkan dapat meningkatkan partisipasi masyarakat dalam upaya mitigasi bencana banjir melalui pemanfaatan teknologi informasi berbasis web.
</p>


## Anggota Kelompok
| Nama | NIM |
|------|------|
| Khusnia Fitri | 1203230030 |
| Ahmad Assyifa Dzaky Rahman | 1203230058 |
| Muhammad Fajri Dwi Prasetya Subandi | 1203230076 |


## Daftar Isi
1. [Fitur Aplikasi](#fitur-aplikasi)
2. [Prasyarat](#prasyarat)
3. [Instalasi](#instalasi)
4. [Struktur Proyek](#struktur-proyek)
5. [Menjalankan Aplikasi](#menjalankan-aplikasi)


## Fitur Aplikasi
Berdasarkan ide dan proposal tugas besar, aplikasi ini menyediakan fitur-fitur berikut:

### Autentikasi dan Otorisasi
- Login dan registrasi pengguna
- Role-based access control:
  - Masyarakat
  - Pemerintah
- Pengelolaan sesi pengguna secara aman

### Pelaporan Banjir
- Masyarakat dapat melaporkan kejadian banjir atau genangan air
- Laporan berisi informasi lokasi, deskripsi kejadian, dan waktu pelaporan
- Data laporan tersimpan di sistem dan dapat dipantau oleh petugas

### Pemantauan dan Status Laporan
- Pemerintah dapat melihat seluruh laporan yang masuk
- Update status laporan sesuai progres penanganan
- Monitoring laporan melalui dashboard

### Komunikasi
- Fitur komunikasi antara masyarakat dan pemerintah
- Memberikan tanggapan atau klarifikasi terhadap laporan
- Mendukung interaksi dua arah melalui sistem

### Dashboard Monitoring
- Dashboard ringkasan kondisi banjir
- Menampilkan data laporan secara terstruktur
- Mendukung pengambilan keputusan oleh petugas


## Prasyarat
Untuk menjalankan aplikasi ini, diperlukan perangkat lunak berikut:

### Backend
- PHP 8.1 atau lebih tinggi
- Composer
- Framework Laravel

### Database
- SQLite (default)
- MySQL (opsional)

### Frontend
- Node.js versi 16 atau lebih tinggi
- NPM

### Tools Pendukung
- Git
- Visual Studio Code (disarankan)

### Sistem Operasi
- Windows / Linux / macOS


## Instalasi
1. Clone Repository
   ```bash
   git clone https://github.com/fajridwi/sistem-pemantauan-banjir.git
   cd sistem-pemantauan-banjir
   ```
2. Install Dependency Backend
   ```bash
   composer install
   ```
3. Konfigurasi Environment
   ```bash
   php artisan key:generate
   ```
4. Konfigurasi Database (SQLite)
   Buat file database:
   ```bash
   type nul > database\database.sqlite
   ```
   Lalu jalankan migrasi:
   ```bash
   php artisan migrate
   ```

5. Install Dependency Frontend
   ```bash
   npm install
   ```

## Struktur Proyek
```
sistem-pemantauan-banjir-main/
├── .editorconfig
├── .env.example
├── .gitattributes
├── .gitignore
├── README.md
├── artisan
├── composer.json
├── composer.lock
├── package.json
├── package-lock.json
├── vite.config.js
│
├── app/
│   ├── Events/
│   │   └── NewReportNotification.php
│   │
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AdminReportController.php
│   │   │   ├── ConversationController.php
│   │   │   ├── DashboardController.php
│   │   │   ├── FloodMonitoringController.php
│   │   │   ├── MessageController.php
│   │   │   ├── ProfileController.php
│   │   │   ├── ReportController.php
│   │   │   ├── ReportStatusController.php
│   │   │   └── Auth/
│   │   │       ├── AuthenticatedSessionController.php
│   │   │       ├── ConfirmablePasswordController.php
│   │   │       ├── EmailVerificationNotificationController.php
│   │   │       ├── EmailVerificationPromptController.php
│   │   │       ├── NewPasswordController.php
│   │   │       ├── PasswordController.php
│   │   │       ├── PasswordResetLinkController.php
│   │   │       ├── RegisteredUserController.php
│   │   │       └── VerifyEmailController.php
│   │   │
│   │   └── Middleware/
│   │
│   ├── Models/
│   │   ├── Conversation.php
│   │   ├── FloodMonitoring.php
│   │   ├── Message.php
│   │   ├── Report.php
│   │   ├── ReportStatus.php
│   │   └── User.php
│   │
│   └── Providers/
│
├── bootstrap/
│   └── app.php
│
├── config/
│   ├── app.php
│   ├── auth.php
│   ├── cache.php
│   ├── database.php
│   ├── filesystems.php
│   ├── mail.php
│   ├── queue.php
│   └── session.php
│
├── database/
│   ├── factories/
│   ├── migrations/
│   └── seeders/
│
├── public/
│   └── index.php
│
├── resources/
│   ├── css/
│   ├── js/
│   └── views/
│       ├── admin/
│       ├── auth/
│       ├── layouts/
│       ├── masyarakat/
│       └── pemerintah/
│
├── routes/
│   ├── web.php
│   ├── api.php
│   └── auth.php
│
├── storage/
│   ├── app/
│   ├── framework/
│   └── logs/
│
└── tests/
    ├── Feature/
    │   ├── DashboardTest.php
    │   ├── FloodMonitoringMasyarakatTest.php
    │   ├── FloodMonitoringPemerintahTest.php
    │   ├── LoginTest.php
    │   ├── RegisterTest.php
    │   ├── ReportTest.php
    │   └── ReportStatusTest.php
    └── Unit/
        └── ExampleTest.php
```

## Menjalankan Aplikasi
Aplikasi dijalankan menggunakan dua terminal:

Terminal 1 – Backend
```bash
php artisan serve
```

Terminal 2 – Frontend
```bash
npm run dev
```

Akses aplikasi melalui browser:
```bash
http://127.0.0.1:8000
```
