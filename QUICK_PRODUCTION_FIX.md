# 🚨 Quick Fix for DomPDF Error in Production

## Error yang Dihadapi:
```
Class "Barryvdh\DomPDF\ServiceProvider" not found
index.php :17
```

## ⚡ Solusi Cepat (Pilih Salah Satu):

### **Option 1: Linux/Unix Server**
```bash
chmod +x production_fix.sh
./production_fix.sh
```

### **Option 2: Windows Server**
```powershell
.\production_fix.ps1
```

### **Option 3: Manual Commands**
```bash
# 1. Clear everything
rm -rf vendor/
rm -rf bootstrap/cache/*
rm -rf storage/framework/cache/*
rm -rf storage/framework/sessions/*
rm -rf storage/framework/views/*

# 2. Reinstall dependencies
composer install --no-dev --optimize-autoloader --no-cache

# 3. Regenerate autoload
composer dump-autoload --optimize

# 4. Clear Laravel caches
php artisan optimize:clear

# 5. Cache for production
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 🔍 Jika Masih Error, Jalankan Debug:
```bash
php debug_dompdf.php
```

## 📋 Checklist Production:
- [ ] PHP version >= 8.1
- [ ] Composer installed
- [ ] File permissions: `chmod -R 755 storage bootstrap/cache`
- [ ] .env file exists and configured
- [ ] All dependencies installed

## 🎯 Hasil yang Diharapkan:
- ✅ Website berjalan normal di https://odetune.shop/
- ✅ Error DomPDF teratasi
- ✅ Semua fitur berfungsi (homepage, profil, admin)
- ✅ Lightbox modal untuk gambar Visi & Misi

## 📞 Jika Masih Bermasalah:
1. Check server error logs
2. Verify PHP version dan extensions
3. Pastikan semua file ter-upload dengan benar
4. Contact hosting provider jika diperlukan
