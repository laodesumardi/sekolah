# Fitur Upload Gambar Visi & Misi

## Deskripsi
Fitur ini memungkinkan admin untuk mengunggah gambar yang terkait dengan Visi & Misi sekolah. Gambar akan disimpan di database dan dapat ditampilkan di berbagai halaman.

## Fitur yang Ditambahkan

### 1. Database
- Menambahkan field `image` ke tabel `vision_missions`
- Field ini menyimpan path file gambar yang diupload

### 2. Model
- Menambahkan `image` ke `$fillable` array di model `VisionMission`

### 3. Controller
- **Store method**: Menangani upload gambar saat membuat Visi & Misi baru
- **Update method**: Menangani upload gambar saat mengupdate Visi & Misi
- **Destroy method**: Menghapus gambar dari storage saat menghapus Visi & Misi
- Validasi file: JPEG, PNG, JPG, GIF dengan maksimal 2MB

### 4. Views
- **Create form**: Field upload gambar dengan preview
- **Edit form**: Field upload gambar dengan preview dan tampilan gambar saat ini
- **Show view**: Menampilkan gambar yang diupload
- **Index view**: Thumbnail gambar di tabel dan mobile cards

### 5. Storage
- Gambar disimpan di `storage/app/public/vision-missions/`
- Nama file dibuat unik dengan timestamp dan random string
- File disimpan dengan format: `{timestamp}_{random_string}.{extension}`

## Cara Penggunaan

### Upload Gambar Baru
1. Buka halaman "Tambah Visi & Misi"
2. Isi form Visi dan Misi
3. Pilih gambar di field "Upload Gambar"
4. Preview gambar akan muncul otomatis
5. Klik "Simpan Visi & Misi"

### Update Gambar
1. Buka halaman "Edit Visi & Misi"
2. Lihat gambar saat ini (jika ada)
3. Pilih gambar baru di field "Upload Gambar Baru"
4. Preview gambar baru akan muncul
5. Klik "Perbarui Visi & Misi"

### Melihat Gambar
- Di halaman daftar: Thumbnail gambar ditampilkan di kolom "Gambar"
- Di halaman detail: Gambar ditampilkan dalam ukuran penuh
- Di mobile: Thumbnail gambar ditampilkan di card

## Validasi File
- Format yang didukung: JPEG, PNG, JPG, GIF
- Ukuran maksimal: 2MB
- File harus berupa gambar yang valid

## Struktur File
```
storage/app/public/vision-missions/
├── .gitkeep
└── {timestamp}_{random_string}.{extension}
```

## Dependencies
- Laravel Storage facade
- File validation
- Image preview dengan JavaScript

## Catatan Penting
- Gambar lama akan dihapus otomatis saat mengupload gambar baru
- Gambar akan dihapus dari storage saat menghapus Visi & Misi
- Pastikan direktori `storage/app/public/vision-missions/` memiliki permission yang tepat
- Symbolic link `public/storage` harus ada untuk akses gambar
