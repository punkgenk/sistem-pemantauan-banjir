# 💧 Sistem Drainase Pintar

Proyek ini merupakan tugas besar untuk mata kuliah Implementasi dan Pengujian Perangkat Lunak, dengan fokus pada penerapan konsep-konsep yang telah dipelajari sebelumnya, seperti analisis kebutuhan, perancangan sistem, hingga implementasi dan evaluasi usability. Sistem yang dikembangkan bernama “Drainase Pintar untuk Mitigasi Banjir di Ketintang”, sebuah sistem informasi berbasis web yang dirancang untuk memantau kondisi drainase secara real-time serta menerima laporan langsung dari warga. Tujuan utama dari proyek ini adalah menciptakan solusi digital yang membantu masyarakat dan pihak pengelola lingkungan dalam mengantisipasi potensi banjir melalui pemantauan data dan pelaporan berbasis komunitas.

Sistem ini dikembangkan karena permasalahan drainase dan banjir masih menjadi isu rutin di kawasan Ketintang, terutama ketika curah hujan tinggi dan sistem saluran air tidak berfungsi optimal. Warga seringkali tidak tahu harus melapor ke mana ketika menemukan saluran mampet, air meluap, atau sensor ketinggian air menunjukkan kondisi berbahaya. Oleh karena itu, sistem ini berperan sebagai jembatan antara masyarakat dan instansi terkait, di mana warga dapat melaporkan kondisi di lapangan melalui aplikasi, sementara sistem akan menampilkan data sensor air secara real-time dan mengirimkan notifikasi peringatan dini jika terjadi potensi banjir.

Dalam pengembangannya, proyek ini memanfaatkan tiga komponen utama: MySQL sebagai sistem manajemen basis data, Python sebagai bahasa pemrograman utama untuk membangun logika backend, serta Figma sebagai alat utama dalam perancangan dan pengujian antarmuka pengguna (UI/UX). Pemilihan ketiga tool ini tidak dilakukan secara sembarangan, melainkan berdasarkan pengalaman dan hasil evaluasi dari tugas besar semester sebelumnya. MySQL dipilih karena mampu menyimpan data dalam jumlah besar secara terstruktur, seperti laporan warga, data sensor, dan akun pengguna. Python dipilih karena mudah diintegrasikan dengan database dan cocok untuk membangun API serta logika backend, sementara Figma digunakan untuk memastikan tampilan dan alur interaksi aplikasi mudah dipahami oleh pengguna.

Sistem Drainase Pintar ini dirancang agar mudah digunakan oleh berbagai kalangan, mulai dari masyarakat umum hingga pihak pengelola wilayah. Pengguna dapat login, membuat laporan terkait drainase yang tersumbat atau tergenang, melihat peta interaktif yang menampilkan kondisi air di berbagai titik, serta membaca pembaruan dari komunitas sekitar. Sementara itu, administrator atau petugas dapat memantau laporan secara terpusat, memberikan tanggapan, dan mengelola data sensor. Dalam versi akhir nanti, sistem juga akan menampilkan grafik perubahan ketinggian air secara waktu nyata (real-time monitoring), sehingga dapat digunakan untuk pengambilan keputusan cepat saat terjadi hujan lebat.

Selain aspek teknis, proyek ini juga menekankan pentingnya pengujian dan pengalaman pengguna (usability testing). Tim akan melibatkan sejumlah partisipan untuk mencoba prototype dan memberikan umpan balik terhadap desain maupun alur penggunaan sistem. Proses ini penting agar sistem yang dihasilkan tidak hanya berfungsi dengan baik, tetapi juga benar-benar membantu pengguna secara praktis di lapangan.

Secara keseluruhan, proyek ini tidak hanya menjadi latihan akademik, tetapi juga upaya nyata untuk menerapkan ilmu rekayasa perangkat lunak dalam menyelesaikan masalah sosial di lingkungan sekitar. Melalui Sistem Drainase Pintar, diharapkan warga Ketintang dapat berpartisipasi aktif dalam menjaga kebersihan dan kelancaran drainase, sementara pihak pengelola dapat mengambil keputusan berbasis data untuk mencegah bencana banjir secara lebih cepat dan efisien.

---

## 👥 Anggota Kelompok
| Nama | NIM | Tugas |
|------|------|-------|
| Khusnia Fitri | 1203230030 | Desain UI & Dokumentasi |
| Ahmad Assyifa Dzaky Rahman | 1203230058 | Database & Backend |
| Muhammad Fajri Dwi Prasetya Sybandi | 1203230076 | Notifikasi & Integrasi Frontend |

---

## 📁 Struktur Folder
sistem-drainase-pintar/
├─ pspec/ # Implementasi PSPEC per anggota
│ ├─ 1203230030-khusnia/
│ ├─ 1203230058-assyifa/
│ └─ 1203230076-fajri/
├─ frontend/ # Tampilan HTML/CSS/JS
├─ docs/ # Dokumen RPL, class diagram, database schema
├─ backend/ # Kode logika sistem
├─ figma/ # Desain UI/UX (link/screenshot)
└─ README.md # Penjelasan proyek
