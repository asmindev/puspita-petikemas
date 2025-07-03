# Logo dan Asset Management

## Struktur Folder

```
public/images/
├── brand/              # Logo utama dan branding
│   ├── logo.png           # Logo utama (recommended: 512x512px)
│   ├── logo-light.png     # Logo untuk dark background
│   ├── logo-dark.png      # Logo untuk light background
│   ├── logo-small.png     # Logo kecil (64x64px)
│   └── favicon.ico        # Favicon
├── icons/              # Icon dan graphic kecil
│   └── favicon.ico
├── backgrounds/        # Background images
└── misc/              # Asset lainnya
```

## Cara Upload Logo

### Method 1: Manual Upload

1. Buka folder: `/home/labubu/Projects/antrian-petikemas/public/images/brand/`
2. Upload file PNG Anda dengan nama: `logo.png`
3. Pastikan ukuran optimal: 512x512px atau 256x256px

### Method 2: Via Terminal

```bash
# Copy logo dari folder lokal
cp /path/to/your/logo.png /home/labubu/Projects/antrian-petikemas/public/images/brand/

# Atau download dari URL
wget -O /home/labubu/Projects/antrian-petikemas/public/images/brand/logo.png "https://example.com/logo.png"
```

## Penggunaan di Blade Templates

### Basic Usage

```blade
<img src="{{ asset('images/brand/logo.png') }}" alt="Logo" class="w-20 h-20">
```

### Dengan Fallback

```blade
<img src="{{ asset('images/brand/logo.png') }}"
     alt="Logo"
     class="w-20 h-20"
     onerror="this.src='{{ asset('images/brand/default.png') }}'">
```

### Responsive Logo

```blade
<img src="{{ asset('images/brand/logo.png') }}"
     alt="Logo"
     class="w-16 h-16 md:w-20 md:h-20 lg:w-24 lg:h-24 object-contain">
```

### Using Helper (if registered)

```blade
<img src="{{ App\Helpers\AssetHelper::logo() }}" alt="Logo" class="w-20 h-20">
```

## Rekomendasi Format dan Ukuran

### Logo Utama

-   Format: PNG dengan background transparent
-   Ukuran: 512x512px atau 256x256px
-   Maksimal file size: 200KB

### Favicon

-   Format: ICO atau PNG
-   Ukuran: 32x32px, 16x16px
-   Nama file: favicon.ico

### Logo Variants

-   `logo.png` - Logo utama
-   `logo-light.png` - Untuk background gelap
-   `logo-dark.png` - Untuk background terang
-   `logo-small.png` - Logo kecil (64x64px)

## Testing

Setelah upload logo, test di:

1. Halaman login: http://localhost:8000/login
2. Dashboard: http://localhost:8000/dashboard
3. Semua halaman yang menggunakan layout utama

## Troubleshooting

### Logo tidak muncul?

1. Cek path file: `public/images/brand/logo.png`
2. Cek permission folder: `chmod 755 public/images/`
3. Clear cache: `php artisan cache:clear`

### Logo terpotong atau tidak proporsional?

1. Gunakan class `object-contain` atau `object-cover`
2. Set aspect ratio yang tepat
3. Pastikan ukuran logo konsisten

### Performance

1. Compress PNG sebelum upload
2. Gunakan format WebP untuk browser modern
3. Implement lazy loading untuk gambar besar
