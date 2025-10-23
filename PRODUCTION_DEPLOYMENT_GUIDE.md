# Production Deployment Guide - Fix DomPDF Error

## 🚨 Error yang Dihadapi
```
Class "Barryvdh\DomPDF\ServiceProvider" not found
index.php :17
```

## 🔧 Solusi Lengkap untuk Production

### 1. **Upload Semua File ke Server**
Pastikan semua file project sudah di-upload ke server production, termasuk:
- `vendor/` directory (atau jalankan `composer install` di server)
- `bootstrap/` directory
- `config/` directory
- `app/` directory

### 2. **Jalankan Script Deployment**

#### Untuk Linux/Unix Server:
```bash
chmod +x deploy_production.sh
./deploy_production.sh
```

#### Untuk Windows Server:
```powershell
.\deploy_production.ps1
```

#### Manual Commands (jika script tidak bisa dijalankan):
```bash
# Clear all caches
php artisan optimize:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

# Reinstall dependencies
composer install --no-dev --optimize-autoloader --no-cache

# Regenerate autoload
composer dump-autoload --optimize

# Run package discovery
php artisan package:discover

# Publish DomPDF config
php artisan vendor:publish --provider="Barryvdh\DomPDF\ServiceProvider" --tag=config

# Cache everything for production
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 3. **Periksa Environment Production**

Jalankan script check:
```bash
php check_production.php
```

### 4. **Pastikan .htaccess Benar**

Copy file `.htaccess_production` ke `public/.htaccess` di server production.

### 5. **Set Permissions yang Benar**

```bash
# Set permissions untuk storage dan cache
chmod -R 755 storage
chmod -R 755 bootstrap/cache
chown -R www-data:www-data storage
chown -R www-data:www-data bootstrap/cache
```

### 6. **Environment Variables**

Pastikan file `.env` di production memiliki:
```env
APP_ENV=production
APP_DEBUG=false
```

### 7. **Troubleshooting**

Jika masih error, coba langkah berikut:

1. **Hapus semua cache:**
```bash
rm -rf bootstrap/cache/*
rm -rf storage/framework/cache/*
rm -rf storage/framework/sessions/*
rm -rf storage/framework/views/*
```

2. **Reinstall composer dependencies:**
```bash
rm -rf vendor/
composer install --no-dev --optimize-autoloader
```

3. **Regenerate semua cache:**
```bash
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 8. **Verifikasi**

Setelah deployment, test halaman-halaman berikut:
- Homepage: `https://yourdomain.com/`
- Profil: `https://yourdomain.com/profil`
- Admin: `https://yourdomain.com/admin/school-profile/3/edit`

## 📝 Catatan Penting

1. **Pastikan PHP version >= 8.1** (DomPDF memerlukan PHP 8.1+)
2. **Pastikan Composer terinstall** di server production
3. **Pastikan semua dependencies terinstall** dengan `composer install`
4. **Jangan lupa set permissions** untuk storage dan cache directories
5. **Clear semua cache** setelah deployment

## 🆘 Jika Masih Error

Jika masih mengalami error yang sama:

1. Periksa log error di `storage/logs/laravel.log`
2. Pastikan semua file vendor ter-upload dengan benar
3. Coba jalankan `composer install --no-cache` di server
4. Pastikan server memiliki akses write ke storage dan cache directories
