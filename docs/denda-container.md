# Denda Container

## Field Denda

Container punya 3 field untuk denda:

-   **penalty_status**: Ada denda atau tidak (true/false)
-   **penalty_amount**: Jumlah denda (Rupiah)
-   **penalty_notes**: Catatan denda

## Cara Kerja

1. Container punya `exit_date` (tanggal seharusnya keluar)
2. Kalau container terlambat keluar, sistem otomatis hitung denda
3. Denda tersimpan di field `penalty_amount`
4. Status denda otomatis berubah jadi `true` kalau ada denda

## Database

```sql
penalty_status BOOLEAN DEFAULT FALSE,
penalty_amount DECIMAL(10,2) DEFAULT 0,
penalty_notes TEXT NULL
```

## Service

Ada `PenaltyCalculationService` untuk hitung denda otomatis berdasarkan keterlambatan.

## Query

```php
// Container yang kena denda
Container::where('penalty_status', true)->get();

// Total denda
Container::sum('penalty_amount');
```

Sistem denda sederhana: otomatis dihitung berdasarkan keterlambatan container.
