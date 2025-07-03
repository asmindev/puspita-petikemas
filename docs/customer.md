# Customer (JPT)

## Data Customer

**name** - Nama JPT/perusahaan
**container_count** - Jumlah container (otomatis dihitung)

## Relasi

1 Customer punya banyak Container
Container wajib punya Customer

## Database

```sql
CREATE TABLE customers (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    container_count INT DEFAULT 0,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

## Cara Kerja

-   Customer daftar di system
-   Customer bisa punya banyak container
-   `container_count` otomatis update kalau ada container baru/dihapus
-   Kalau customer dihapus, container-nya juga ikut terhapus (cascade)

## Query

```php
// Ambil semua container dari customer
$customer->containers

// Update jumlah container
$customer->updateContainerCount()

// Cari customer by nama
Customer::where('name', 'like', '%nama%')->get()
```

Simple: Customer = JPT yang punya container.
