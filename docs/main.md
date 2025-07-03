# Dokumentasi Sistem Antrian Petikemas

## Daftar Isi

1. [Overview Sistem](#overview-sistem)
2. [Workflow Aplikasi](#workflow-aplikasi)
3. [Algoritma Antrian](#algoritma-antrian)
4. [Container](#container)
5. [Customer (JPT)](#customer-jpt)
6. [Database Schema](#database-schema)

---

## Overview Sistem

Sistem Antrian Petikemas adalah aplikasi Laravel untuk mengelola antrian container di pelabuhan. Sistem menggunakan algoritma **Priority + FCFS** (High priority dulu, lalu urut berdasarkan waktu masuk).

### Fitur Utama

-   Manajemen antrian container otomatis
-   Prioritas High dan Normal
-   Tracking status container

### Teknologi

-   Laravel 11.x
-   MySQL/PostgreSQL

---

## Workflow Aplikasi

### Alur Sederhana

1. **Daftar Container** → Status: `pending`
2. **Mulai Proses** → Status: `in_progress`
3. **Selesai** → Status: `completed`
4. **Bisa Dibatalkan** → Status: `cancelled`

### Aturan Antrian

-   Container dengan priority `High` diproses dulu
-   Kalau priority sama, yang masuk duluan diproses dulu
-   Hanya 1 container yang bisa `in_progress` dalam satu waktu

---

## Algoritma Antrian

### Priority Order

```php
const PRIORITY_ORDER = [
    'High' => 1,      // Prioritas tinggi
    'Normal' => 2     // Prioritas normal
];
```

### Cara Kerja

1. Urutkan berdasarkan priority (High dulu)
2. Kalau priority sama, urutkan berdasarkan entry_date (yang lama dulu)

### Contoh

```
Container A: Normal, masuk 09:00
Container B: High, masuk 10:00
Container C: Normal, masuk 08:30

Urutan antrian:
1. Container B (High, 10:00) - priority tinggi
2. Container C (Normal, 08:30) - masuk lebih dulu
3. Container A (Normal, 09:00)
```

---

## Container

### Data Utama

-   **container_number**: Nomor unik container
-   **customer_id**: ID customer (JPT)
-   **status**: pending/in_progress/completed/cancelled
-   **priority**: Normal/High
-   **entry_date**: Kapan container masuk
-   **exit_date**: Kapan seharusnya keluar (untuk hitung denda)

### Waktu Proses

-   **process_start_time**: Kapan mulai diproses
-   **process_end_time**: Kapan selesai diproses

### Denda

-   **penalty_status**: Apakah kena denda (true/false)
-   **penalty_amount**: Jumlah denda (Rupiah)
-   **penalty_notes**: Catatan denda

---

## Customer (JPT)

### Data Customer

-   **name**: Nama JPT/perusahaan
-   **container_count**: Jumlah container (otomatis dihitung)

### Relasi

-   1 Customer punya banyak Container
-   Container wajib punya Customer

---

## Database Schema

### Table: containers

```sql
CREATE TABLE containers (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    container_number VARCHAR(255) UNIQUE NOT NULL,
    customer_id BIGINT NOT NULL,
    status ENUM('pending', 'in_progress', 'completed', 'cancelled') DEFAULT 'pending',
    priority ENUM('Normal', 'High') DEFAULT 'Normal',
    entry_date TIMESTAMP NULL,
    exit_date TIMESTAMP NULL,
    penalty_status BOOLEAN DEFAULT FALSE,
    penalty_amount DECIMAL(10,2) DEFAULT 0,
    penalty_notes TEXT NULL,
    process_start_time TIMESTAMP NULL,
    process_end_time TIMESTAMP NULL,
    notes TEXT NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,

    FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE CASCADE
);
```

### Table: customers

```sql
CREATE TABLE customers (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    container_count INT DEFAULT 0,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

---

## Service Utama

### ContainerQueueService

Mengatur antrian container:

-   `getNextContainer()` - Ambil container berikutnya untuk diproses
-   `getQueuePosition()` - Lihat posisi container di antrian
-   `sortByPriorityAndFCFS()` - Urutkan container sesuai aturan

### PenaltyCalculationService

Hitung denda container yang terlambat keluar.

---

## Cara Install

```bash
# Clone dan setup
composer install
cp .env.example .env
php artisan key:generate

# Database
php artisan migrate
php artisan db:seed

# Jalankan
php artisan serve
```

---

Sistem ini sederhana: daftar container → antri berdasarkan prioritas → proses → selesai.
