# 💧 Sistem Drainase Pintar

<p align="justify">
Sistem Pemantauan dan Pelaporan Banjir merupakan aplikasi berbasis web yang dikembangkan menggunakan framework Laravel dengan tujuan untuk mendukung proses pelaporan, pemantauan, dan penanganan kejadian banjir atau genangan air secara terintegrasi. Aplikasi ini dirancang sebagai media penghubung antara masyarakat dan pemerintah dalam upaya meningkatkan kecepatan, ketepatan, serta transparansi penanganan banjir di suatu wilayah.

Melalui aplikasi ini, masyarakat dapat dengan mudah melaporkan kejadian banjir yang terjadi di lingkungan sekitar dengan mengisi informasi yang relevan, seperti lokasi kejadian, kondisi genangan, dan keterangan tambahan. Laporan yang dikirimkan akan tersimpan dalam sistem dan dapat langsung diakses oleh pihak pemerintah atau petugas terkait untuk dilakukan pemantauan dan tindak lanjut.

Di sisi pemerintah, aplikasi ini menyediakan dashboard monitoring yang menampilkan daftar laporan banjir secara terstruktur, lengkap dengan status penanganan yang dapat diperbarui sesuai dengan progres di lapangan. Fitur ini membantu petugas dalam mengelola laporan masuk, menentukan prioritas penanganan, serta memantau kondisi wilayah terdampak secara lebih efektif.

Selain itu, sistem ini juga dilengkapi dengan fitur komunikasi antara masyarakat dan pihak pemerintah, sehingga memungkinkan terjadinya interaksi dua arah. Melalui fitur tersebut, masyarakat dapat memperoleh informasi terkait status laporan yang telah dikirimkan, sementara pemerintah dapat memberikan tanggapan, klarifikasi, atau informasi lanjutan secara langsung melalui sistem.

Aplikasi ini dirancang dengan konsep role-based access, di mana setiap pengguna memiliki hak akses yang berbeda sesuai dengan perannya, seperti masyarakat, pemerintah, dan admin. Dengan penerapan autentikasi pengguna, keamanan data laporan dapat terjaga dengan baik, serta setiap aktivitas pengguna dapat dikelola secara terstruktur.

Dengan adanya Sistem Pemantauan dan Pelaporan Banjir ini, diharapkan proses pelaporan dan penanganan banjir dapat dilakukan secara lebih cepat, terorganisir, dan transparan, serta mampu mendukung pengambilan keputusan oleh pihak pemerintah berdasarkan data laporan yang terkumpul. Aplikasi ini juga diharapkan dapat meningkatkan partisipasi masyarakat dalam upaya mitigasi bencana banjir melalui pemanfaatan teknologi informasi berbasis web.
</p>

<p align="justify">
Sistem ini dikembangkan karena permasalahan drainase dan banjir masih menjadi isu rutin di kawasan Ketintang, terutama ketika curah hujan tinggi dan sistem saluran air tidak berfungsi optimal. Warga seringkali tidak tahu harus melapor ke mana ketika menemukan saluran mampet, air meluap, atau sensor ketinggian air menunjukkan kondisi berbahaya. Oleh karena itu, sistem ini berperan sebagai jembatan antara masyarakat dan instansi terkait, di mana warga dapat melaporkan kondisi di lapangan melalui aplikasi, sementara sistem akan menampilkan data sensor air secara real-time dan mengirimkan notifikasi peringatan dini jika terjadi potensi banjir.
</p>

<p align="justify">
Dalam pengembangannya, proyek ini memanfaatkan tiga komponen utama: MySQL sebagai sistem manajemen basis data, Python sebagai bahasa pemrograman utama untuk membangun logika backend, serta Figma sebagai alat utama dalam perancangan dan pengujian antarmuka pengguna (UI/UX). Pemilihan ketiga tool ini tidak dilakukan secara sembarangan, melainkan berdasarkan pengalaman dan hasil evaluasi dari tugas besar semester sebelumnya. MySQL dipilih karena mampu menyimpan data dalam jumlah besar secara terstruktur, seperti laporan warga, data sensor, dan akun pengguna. Python dipilih karena mudah diintegrasikan dengan database dan cocok untuk membangun API serta logika backend, sementara Figma digunakan untuk memastikan tampilan dan alur interaksi aplikasi mudah dipahami oleh pengguna.
</p>

<p align="justify">
Sistem Drainase Pintar ini dirancang agar mudah digunakan oleh berbagai kalangan, mulai dari masyarakat umum hingga pihak pengelola wilayah. Pengguna dapat login, membuat laporan terkait drainase yang tersumbat atau tergenang, melihat peta interaktif yang menampilkan kondisi air di berbagai titik, serta membaca pembaruan dari komunitas sekitar. Sementara itu, administrator atau petugas dapat memantau laporan secara terpusat, memberikan tanggapan, dan mengelola data sensor. Dalam versi akhir nanti, sistem juga akan menampilkan grafik perubahan ketinggian air secara waktu nyata (real-time monitoring), sehingga dapat digunakan untuk pengambilan keputusan cepat saat terjadi hujan lebat.
</p>

<p align="justify">
Selain aspek teknis, proyek ini juga menekankan pentingnya pengujian dan pengalaman pengguna (usability testing). Tim akan melibatkan sejumlah partisipan untuk mencoba prototype dan memberikan umpan balik terhadap desain maupun alur penggunaan sistem. Proses ini penting agar sistem yang dihasilkan tidak hanya berfungsi dengan baik, tetapi juga benar-benar membantu pengguna secara praktis di lapangan.
</p>

<p align="justify">
Secara keseluruhan, proyek ini tidak hanya menjadi latihan akademik, tetapi juga upaya nyata untuk menerapkan ilmu rekayasa perangkat lunak dalam menyelesaikan masalah sosial di lingkungan sekitar. Melalui Sistem Drainase Pintar, diharapkan warga Ketintang dapat berpartisipasi aktif dalam menjaga kebersihan dan kelancaran drainase, sementara pihak pengelola dapat mengambil keputusan berbasis data untuk mencegah bencana banjir secara lebih cepat dan efisien.
</p>

---

## 👥 Anggota Kelompok
| Nama | NIM | Tugas |
|------|------|-------|
| Khusnia Fitri | 1203230030 | Desain UI & Dokumentasi |
| Ahmad Assyifa Dzaky Rahman | 1203230058 | Database & Backend |
| Muhammad Fajri Dwi Prasetya Subandi | 1203230076 | Notifikasi & Integrasi Frontend |

---

## 📁 Struktur Folder
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
