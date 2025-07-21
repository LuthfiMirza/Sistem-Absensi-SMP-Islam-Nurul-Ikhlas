# 🔍 Debug Sidebar - Panduan Troubleshooting

## ✅ **Perubahan yang Telah Dilakukan:**

### 1. **Layout Home Diperbaiki**
- ✅ Mengubah `layouts/home.blade.php` untuk menggunakan sidebar yang sama dengan admin
- ✅ Menambahkan include navbar dan sidebar
- ✅ Menambahkan main-content wrapper

### 2. **Navbar Diperbaiki**
- ✅ Link navbar brand sekarang dinamis berdasarkan role user
- ✅ Admin/Operator → `dashboard.index`
- ✅ Guru/Karyawan → `home.index`

### 3. **CSS Diperbaiki**
- ✅ Menambahkan width dan overflow-y untuk sidebar
- ✅ Menambahkan responsive CSS untuk mobile
- ✅ Menambahkan transition untuk sidebar toggle

### 4. **JavaScript Ditambahkan**
- ✅ Sidebar toggle functionality untuk mobile
- ✅ Click outside to close sidebar

### 5. **Routes Ditambahkan**
- ✅ Route untuk mengakses halaman presence management dari role guru/karyawan

---

## 🧪 **Langkah Testing:**

### **1. Clear Cache Browser**
```bash
# Tekan Ctrl + Shift + R atau Cmd + Shift + R
# Atau buka Developer Tools (F12) → Network → Disable cache
```

### **2. Cek Console Browser**
```bash
# Buka Developer Tools (F12)
# Lihat tab Console untuk error JavaScript
# Lihat tab Network untuk file CSS/JS yang gagal load
```

### **3. Cek URL yang Benar**
```bash
# Login sebagai guru/karyawan di:
http://127.0.0.1:8000/login

# Setelah login, pastikan redirect ke:
http://127.0.0.1:8000/home

# Bukan ke dashboard (yang untuk admin)
```

### **4. Cek Role User**
Pastikan user yang login memiliki:
- `role_id = 2` (Karyawan) atau `role_id = 3` (Guru)
- `position_id` yang valid (tidak null)

---

## 🔧 **Jika Sidebar Masih Tidak Muncul:**

### **Kemungkinan Masalah 1: CSS Tidak Load**
```bash
# Cek apakah file CSS ter-load di browser
# Buka Developer Tools → Network → Refresh halaman
# Pastikan file app.css status 200 (berhasil load)
```

### **Kemungkinan Masalah 2: Layout Tidak Benar**
```bash
# Pastikan halaman home menggunakan @extends('layouts.home')
# Dan layouts.home sudah include sidebar
```

### **Kemungkinan Masalah 3: User Role Salah**
```sql
-- Cek role user di database
SELECT id, name, email, role_id, position_id FROM users WHERE email = 'email_anda';

-- Pastikan role_id = 2 atau 3 (bukan 1)
-- Pastikan position_id tidak null
```

### **Kemungkinan Masalah 4: Middleware Route**
```bash
# Pastikan user bisa mengakses route home.*
# Cek di routes/web.php middleware 'role:karyawan,guru'
```

---

## 🎯 **Test Sidebar Menu:**

Setelah sidebar muncul, test menu berikut:

### **Menu Utama:**
- ✅ **Beranda** → `/home`
- ✅ **[Nama Absensi]** → `/absensi/{attendance_id}`

### **Menu Kelola Absensi:**
- ✅ **Detail Kehadiran** → `/absensi/{attendance_id}/detail`
- ✅ **Data Izin** → `/absensi/{attendance_id}/permissions`
- ✅ **Belum Absen** → `/absensi/{attendance_id}/not-present`

### **Menu Aksi Cepat:**
- ✅ **Ajukan Izin** → `/absensi/{attendance_id}/permission`
- ✅ **QR Code Absensi** → `/presences/qrcode?code={code}` (new tab)

---

## 📱 **Test Mobile Responsiveness:**

1. **Resize browser** ke ukuran mobile (< 768px)
2. **Klik hamburger menu** di navbar (3 garis)
3. **Sidebar harus slide in** dari kiri
4. **Klik di luar sidebar** untuk menutup

---

## 🚨 **Jika Masih Bermasalah:**

### **Langkah Darurat:**
1. **Restart server** Laravel (`php artisan serve`)
2. **Clear cache** Laravel:
   ```bash
   php artisan cache:clear
   php artisan config:clear
   php artisan view:clear
   ```
3. **Hard refresh** browser (Ctrl+Shift+R)

### **Cek File Penting:**
- ✅ `resources/views/layouts/home.blade.php`
- ✅ `resources/views/partials/sidebar.blade.php`
- ✅ `public/css/app.css`
- ✅ `routes/web.php`

---

## 📞 **Informasi Debug:**

Jika sidebar masih tidak muncul, berikan informasi berikut:

1. **Browser yang digunakan** (Chrome, Firefox, etc.)
2. **URL yang diakses** setelah login
3. **Role user** yang login (guru/karyawan)
4. **Error di console** browser (jika ada)
5. **Screenshot** halaman yang bermasalah

---

**Sidebar seharusnya sudah muncul dengan menu lengkap untuk guru/karyawan! 🎉**