# Workflow Aplikasi Antrian Petikemas

## Overview

Aplikasi untuk mengelola antrian container di pelabuhan. Container diurutkan berdasarkan prioritas dan waktu masuk.

## Alur Kerja Sederhana

### 1. Daftar Container

-   Customer daftar container baru
-   System validasi data
-   Container masuk antrian dengan status `pending`

### 2. Antrian Otomatis

-   Container `High` priority diproses dulu
-   Kalau priority sama, yang masuk duluan diproses dulu
-   System otomatis atur urutan

### 3. Proses Container

-   Admin pilih container berikutnya
-   Status berubah ke `in_progress`
-   Catat waktu mulai proses
-   Hanya 1 container yang bisa diproses bersamaan

### 4. Selesai

-   Admin tandai selesai
-   Status berubah ke `completed`
-   Catat waktu selesai

## Status Container

**pending** - Menunggu antrian
**in_progress** - Sedang diproses
**completed** - Sudah selesai
**cancelled** - Dibatalkan

## Prioritas

**High** - Prioritas tinggi, diproses dulu
**Normal** - Prioritas biasa

## Komponen Sistem

### Backend (Laravel)

-   Model Container dan Customer
-   Service untuk antrian
-   Validasi data

### Database

-   Tabel containers
-   Tabel customers
-   Relasi foreign key

## Akses Admin

Admin bisa:

-   Input container baru
-   Update status container
-   Kelola data customer
-   Lihat antrian dan status
