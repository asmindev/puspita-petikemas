# Dokumentasi Sistem Antrian Petikemas

Folder ini berisi dokumentasi lengkap untuk Sistem Antrian Petikemas yang dibangun menggunakan Laravel.

## Struktur Dokumentasi

### 📋 [main.md](./main.md)

Dokumentasi utama yang menggabungkan semua aspek sistem dalam satu file komprehensif. File ini mencakup overview lengkap, workflow, algoritma, dan implementasi sistem.

### 🔄 [workflow.md](./workflow.md)

Dokumentasi detail tentang alur kerja aplikasi, termasuk:

-   Proses pendaftaran container
-   Pengaturan antrian dengan algoritma Priority + FCFS
-   Pemrosesan container
-   State management (pending → in_progress → completed)

### 🧮 [algoritma.md](./algoritma.md)

Dokumentasi mendalam tentang algoritma antrian Priority + FCFS, meliputi:

-   Implementasi algoritma prioritas (High > Normal)
-   Queue position calculation
-   Performance optimization
-   Contoh skenario real

### 💰 [denda-container.md](./denda-container.md)

Dokumentasi sistem perhitungan denda container, mencakup:

-   Database schema untuk penalty fields
-   Business logic implementation
-   Integration dengan Container model
-   Reporting dan analytics

### 📦 [container.md](./container.md)

Dokumentasi lengkap tentang entitas Container, termasuk:

-   Properties dan attributes (sesuai database schema aktual)
-   State management (pending/in_progress/completed/cancelled)
-   Business logic dan validation rules
-   Integration points

### 🏢 [customer.md](./customer.md)

Dokumentasi entitas Customer (JPT), meliputi:

-   Customer properties dan relationships
-   Analytics dan performance metrics
-   Integration dengan container management

## Cara Menggunakan Dokumentasi

### 1. Untuk Pemahaman Umum

Mulai dengan membaca **[main.md](./main.md)** untuk mendapatkan overview lengkap sistem.

### 2. Untuk Development

Baca dokumentasi spesifik berdasarkan komponen yang akan dikembangkan:

-   **Backend Development**: container.md, customer.md, algoritma.md
-   **Business Logic**: workflow.md, denda-container.md
-   **Queue System**: algoritma.md

### 3. Untuk Maintenance

Gunakan dokumentasi untuk:

-   Understanding business rules
-   Troubleshooting berdasarkan workflow
-   Performance optimization

## Teknologi & Framework

-   **Backend**: Laravel 11.x
-   **Database**: MySQL/PostgreSQL
-   **Cache**: Redis (optional)
-   **Queue**: Laravel Queue Worker

## Status Informasi Dokumentasi

### ✅ Informasi yang Akurat (Berdasarkan Kode Aktual)

-   Container model fields dan properties
-   Database schema sesuai migration
-   Priority levels (High, Normal)
-   Status values (pending, in_progress, completed, cancelled)
-   Queue algorithm implementation

### 📝 Informasi yang Perlu Verifikasi

-   Penalty calculation business rules (implementasi spesifik)
-   Customer portal features (belum fully implemented)
-   Advanced analytics features

## Quick Links

-   🚀 [Getting Started](../README.md)
-   📊 [Queue System Documentation](../QUEUE_SYSTEM_DOCUMENTATION.md)
-   🔧 [Demo Queue Service](../demo_queue_service.php)

## Kontribusi Dokumentasi

Untuk mengupdate atau menambah dokumentasi:

1. Edit file yang sesuai di folder `docs/`
2. Update `main.md` jika ada perubahan signifikan
3. Pastikan informasi sesuai dengan implementasi aktual
4. Update README.md ini jika ada file baru

## Versi Dokumentasi

-   **Version**: 1.0.0
-   **Last Updated**: July 3, 2025
-   **Compatibility**: Laravel 11.x
-   **Database Schema**: Berdasarkan migration files aktual

---

_Dokumentasi ini telah diperbaiki agar sesuai dengan implementasi kode yang ada di sistem._
