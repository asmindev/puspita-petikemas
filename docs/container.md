# Container

## Data Container

### Info Dasar

-   **container_number**: Nomor unik container
-   **customer_id**: ID customer (JPT)
-   **status**: pending/in_progress/completed/cancelled
-   **priority**: Normal/High

### Waktu

-   **entry_date**: Kapan container masuk
-   **exit_date**: Kapan seharusnya keluar
-   **process_start_time**: Kapan mulai diproses
-   **process_end_time**: Kapan selesai diproses

### Denda

-   **penalty_status**: Ada denda atau tidak (true/false)
-   **penalty_amount**: Jumlah denda (Rupiah)
-   **penalty_notes**: Catatan denda

### Catatan

-   **notes**: Catatan tambahan

## Status Container

**pending** - Menunggu antrian
**in_progress** - Sedang diproses
**completed** - Sudah selesai
**cancelled** - Dibatalkan

## Priority

**High** - Prioritas tinggi, diproses dulu
**Normal** - Prioritas biasa

## Database

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

## Validasi

-   container_number harus unik
-   customer_id harus ada di table customers
-   status harus sesuai enum
-   priority harus sesuai enum

## Cara Kerja

## Workflow Container

1. Daftar container baru → status `pending`
2. Mulai proses → status `in_progress`, catat process_start_time
3. Selesai → status `completed`, catat process_end_time
4. Hitung denda kalau exit_date terlewati

## Model Container

```php
// Ambil container yang pending, urutkan priority + FCFS
$containers = Container::where('status', 'pending')
    ->orderBy('priority')
    ->orderBy('entry_date')
    ->get();

// Cek posisi antrian
$position = $queueService->getQueuePosition($container);

// Update status
$container->update(['status' => 'in_progress']);
```

Container sederhana dengan status dan priority untuk mengelola antrian.
