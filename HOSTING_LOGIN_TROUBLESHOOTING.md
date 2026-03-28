# 🔧 Troubleshooting Login di Hosting

## Masalah yang Ditemukan

Login berfungsi dengan baik di local environment, tetapi ada masalah di hosting https://odetune.shop/login.

## 🔍 Analisis Masalah

1. **Environment Mismatch**: Local menggunakan `http://localhost` sedangkan hosting menggunakan `https://odetune.shop`
2. **Session Configuration**: Perbedaan konfigurasi session antara local dan hosting
3. **Database Connection**: Hosting mungkin menggunakan database connection yang berbeda
4. **CSRF Token**: Masalah CSRF token di hosting environment

## 🚀 Solusi untuk Hosting

### 1. Update Environment Variables

Pastikan file `.env` di hosting memiliki konfigurasi berikut:

```env
APP_NAME="SMP Negeri 01 Namrole"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://odetune.shop

SESSION_DRIVER=database
SESSION_LIFETIME=1440
SESSION_DOMAIN=odetune.shop
SESSION_SECURE_COOKIE=true
SESSION_HTTP_ONLY=false
SESSION_SAME_SITE=lax
```

### 2. Clear Cache di Hosting

Jalankan perintah berikut di hosting:

```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### 3. Periksa Database Connection

Pastikan database connection di hosting berfungsi:

```bash
php artisan migrate:status
```

### 4. Periksa Session Table

Pastikan sessions table ada dan berfungsi:

```bash
php artisan session:table
php artisan migrate
```

### 5. Test Login Functionality

Gunakan kredensial berikut untuk test login:

**Admin Account:**
- Email: `admin@smpnamrole.sch.id`
- Password: `admin123`

**Teacher Account:**
- Email: `ode@gmail.com`
- Password: `password`

## 🔧 Script Otomatis

Gunakan script `fix-hosting-login.php` untuk memperbaiki konfigurasi secara otomatis:

```bash
php fix-hosting-login.php
```

## 📋 Checklist Troubleshooting

- [ ] Environment variables sudah benar
- [ ] Cache sudah di-clear
- [ ] Database connection berfungsi
- [ ] Sessions table ada
- [ ] User data tersedia
- [ ] Password hash tersedia
- [ ] CSRF token berfungsi
- [ ] Session configuration benar

## 🚨 Masalah Umum di Hosting

1. **File Permissions**: Pastikan folder `storage` dan `bootstrap/cache` writable
2. **Database Connection**: Periksa kredensial database di hosting
3. **Session Storage**: Pastikan sessions table ada dan berfungsi
4. **Environment Variables**: Pastikan semua environment variables benar
5. **SSL Certificate**: Pastikan SSL certificate valid untuk HTTPS

## 📞 Support

Jika masih ada masalah, periksa:
1. Hosting logs
2. Laravel logs di `storage/logs/laravel.log`
3. Browser console untuk error JavaScript
4. Network tab untuk error HTTP

## 🎯 Kredensial Login yang Tersedia

1. **Admin**: `admin@smpnamrole.sch.id` / `admin123`
2. **Teacher**: `ode@gmail.com` / `password`
3. **Student**: `PPDB20250001@student.smpnamrole.sch.id` / `password`

## ✅ Verifikasi

Setelah memperbaiki konfigurasi, test login di:
- https://odetune.shop/login
- Pastikan redirect ke dashboard sesuai role
- Pastikan session persist
- Pastikan tidak ada error 419 Page Expired
