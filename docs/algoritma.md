# Algoritma Antrian Container

## Cara Kerja

Sistem menggunakan **Priority + FCFS** (First Come First Serve):

1. Container `High` priority diproses dulu
2. Kalau priority sama, yang masuk duluan diproses dulu

## Priority Level

**High** - Prioritas tinggi
**Normal** - Prioritas biasa

## Algoritma

```php
const PRIORITY_ORDER = [
    'High' => 1,      // Diproses dulu
    'Normal' => 2     // Diproses setelah High
];

protected function sortByPriorityAndFCFS(Collection $containers): Collection
{
    return $containers->sort(function ($a, $b) {
        // Cek priority dulu
        $priorityA = self::PRIORITY_ORDER[$a->priority] ?? 999;
        $priorityB = self::PRIORITY_ORDER[$b->priority] ?? 999;

        if ($priorityA !== $priorityB) {
            return $priorityA <=> $priorityB;
        }

        // Kalau priority sama, cek entry_date
        $entryDateA = $a->entry_date ? $a->entry_date->timestamp : 0;
        $entryDateB = $b->entry_date ? $b->entry_date->timestamp : 0;

        return $entryDateA <=> $entryDateB;
    })->values();
}
```

## Contoh

Container yang ada:

-   Container A: Normal, masuk 09:00
-   Container B: High, masuk 10:00
-   Container C: Normal, masuk 08:30

Urutan antrian:

1. Container B (High, 10:00) - priority tinggi
2. Container C (Normal, 08:30) - masuk lebih dulu dari A
3. Container A (Normal, 09:00)

## Service Queue

```php
// Ambil container berikutnya untuk diproses
$nextContainer = $queueService->getNextContainer();

// Lihat posisi container di antrian
$position = $queueService->getQueuePosition($container);

// Statistik antrian
$stats = $queueService->getQueueStatistics();
```

Sistem sederhana: urutkan berdasarkan priority, lalu waktu masuk.
