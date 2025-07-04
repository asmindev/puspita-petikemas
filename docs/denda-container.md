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

## Sistem Perhitungan Denda

### Container 40ft

-   **Masa 1 (hari 1-5)**: Rp.15.125 (flat rate) - beban Pelayaran
-   **Masa 1.2 (hari 6-10)**: Rp.15.125/hari (mulai hitung dari hari ke-6) - beban JPT
-   **Masa 2 (hari 11+)**: Rp.30.250/hari (mulai hitung dari hari ke-11) - beban JPT

### Container 20ft

-   **Masa 1 (hari 1-5)**: Rp.7.600 (flat rate) - beban Pelayaran
-   **Masa 1.2 (hari 6-10)**: Rp.7.600/hari (mulai hitung dari hari ke-6) - beban JPT
-   **Masa 2 (hari 11+)**: Rp.15.200/hari (mulai hitung dari hari ke-11) - beban JPT

### Contoh Perhitungan

Container 40ft terlambat 12 hari:

-   Masa 1: Rp.15.125 (flat untuk hari 1-5)
-   Masa 1.2: 5 hari × Rp.15.125 = Rp.75.625 (hari 6-10)
-   Masa 2: 2 hari × Rp.30.250 = Rp.60.500 (hari 11-12)
-   **Total**: Rp.151.250

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
