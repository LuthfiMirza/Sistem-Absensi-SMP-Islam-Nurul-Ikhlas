# 📋 Panduan Sidebar untuk Role Guru dan Karyawan

## 🎯 **Fitur Sidebar yang Telah Ditambahkan**

Sidebar telah diperbaiki untuk memberikan akses mudah ke semua halaman yang telah dimodernisasi untuk role **Guru** dan **Karyawan**.

---

## 🏠 **Struktur Menu Sidebar**

### **1. BERANDA**
- **Beranda** - Halaman utama untuk guru/karyawan
  - Route: `/home`
  - Fungsi: Dashboard utama dengan ringkasan absensi

### **2. ABSENSI**
Menampilkan daftar absensi yang tersedia untuk posisi user yang login:
- **[Nama Absensi]** - Halaman absensi spesifik
  - Route: `/absensi/{attendance}`
  - Badge "Aktif" untuk absensi yang sedang berjalan
  - Fungsi: Melakukan absensi masuk/keluar

### **3. KELOLA ABSENSI**
Menu untuk mengakses halaman-halaman yang telah diperbaiki:

#### **📊 Detail Kehadiran**
- Route: `/absensi/{attendance}/detail`
- Fungsi: Melihat detail data kehadiran semua karyawan
- Fitur:
  - Header dengan gradient modern
  - Info cards dengan jadwal absensi
  - Tabel data kehadiran dengan Livewire
  - Action buttons untuk izin, belum absen, dan QR code

#### **📝 Data Izin**
- Route: `/absensi/{attendance}/permissions`
- Fungsi: Melihat dan mengelola pengajuan izin
- Fitur:
  - Filter berdasarkan tanggal
  - Stats card dengan ringkasan
  - Tabel izin dengan status persetujuan
  - Modal detail izin
  - Action untuk menerima izin

#### **❌ Belum Absen**
- Route: `/absensi/{attendance}/not-present`
- Fungsi: Melihat daftar karyawan yang belum absen
- Fitur:
  - Filter berdasarkan tanggal
  - Grouping berdasarkan tanggal
  - Action untuk menandai hadir manual
  - Empty state yang informatif

### **4. AKSI CEPAT**

#### **🏥 Ajukan Izin**
- Route: `/absensi/{attendance}/permission`
- Fungsi: Form untuk mengajukan izin tidak masuk

#### **📱 QR Code Absensi**
- Route: `/presences/qrcode?code={code}`
- Fungsi: Menampilkan QR Code untuk absensi
- Target: `_blank` (buka di tab baru)
- Fitur:
  - QR Code dengan animasi pulse
  - Multiple download options (PDF, PNG)
  - Print functionality
  - Copy URL feature
  - Instructions step-by-step

### **5. PROFIL**
Informasi user yang sedang login:
- **Nama Lengkap**
- **Posisi/Jabatan**
- **Email**

---

## 🔐 **Akses dan Permissions**

### **Role yang Dapat Mengakses:**
- ✅ **Guru** (role_id: 3)
- ✅ **Karyawan** (role_id: 2)

### **Role yang Tidak Dapat Mengakses:**
- ❌ **Operator** (role_id: 1) - Memiliki menu terpisah

### **Pembatasan Akses:**
- Hanya dapat melihat absensi sesuai dengan `position_id` user
- Tidak dapat mengubah data kehadiran orang lain (read-only)
- Tidak dapat menghapus data absensi

---

## 🎨 **Fitur UI/UX yang Ditambahkan**

### **Visual Enhancements:**
- **Section Headers** dengan border dan typography yang konsisten
- **Active States** untuk menu yang sedang dibuka
- **Badges** untuk status (Aktif, dll.)
- **Icons** yang konsisten menggunakan Font Awesome
- **External Link Indicator** untuk QR Code

### **Responsive Design:**
- Mobile-friendly sidebar
- Collapsible pada layar kecil
- Touch-friendly navigation

### **Interactive Elements:**
- Hover effects pada menu items
- Smooth transitions
- Loading states
- Profile info tanpa hover effect

---

## 🚀 **Cara Mengakses**

### **1. Login sebagai Guru/Karyawan**
```
URL: http://127.0.0.1:8000/login
```

### **2. Setelah Login, Anda akan diarahkan ke:**
```
URL: http://127.0.0.1:8000/home
```

### **3. Gunakan Sidebar untuk Navigasi:**
- Klik menu yang diinginkan di sidebar kiri
- Menu akan highlight saat aktif
- Gunakan section "KELOLA ABSENSI" untuk mengakses halaman yang telah diperbaiki

---

## �� **URL Langsung untuk Testing**

Setelah login sebagai guru/karyawan, Anda dapat mengakses:

```bash
# Detail Kehadiran
http://127.0.0.1:8000/absensi/{attendance_id}/detail

# Data Izin
http://127.0.0.1:8000/absensi/{attendance_id}/permissions

# Belum Absen
http://127.0.0.1:8000/absensi/{attendance_id}/not-present

# QR Code (ganti {code} dengan kode QR yang valid)
http://127.0.0.1:8000/presences/qrcode?code={code}
```

**Note:** Ganti `{attendance_id}` dengan ID absensi yang valid dari database Anda.

---

## 🔧 **Troubleshooting**

### **Jika Menu Tidak Muncul:**
1. Pastikan user memiliki `position_id` yang valid
2. Pastikan ada data `Attendance` yang aktif untuk posisi tersebut
3. Clear cache browser dan refresh halaman

### **Jika Terjadi Error 403:**
1. Pastikan user login dengan role "guru" atau "karyawan"
2. Pastikan middleware role sudah benar di routes

### **Jika Sidebar Tidak Responsive:**
1. Pastikan CSS app.css sudah ter-load
2. Pastikan Bootstrap JavaScript sudah ter-load
3. Check console browser untuk error JavaScript

---

## ✨ **Fitur Tambahan yang Tersedia**

1. **Auto-refresh** pada halaman belum absen (setiap 5 menit)
2. **Confirmation dialogs** untuk aksi penting
3. **Loading states** untuk semua button actions
4. **Toast notifications** untuk feedback user
5. **Print functionality** untuk QR Code
6. **Download options** (PDF, PNG) untuk QR Code
7. **Smooth animations** dan transitions
8. **Empty states** yang informatif

---

Sidebar sekarang memberikan akses lengkap ke semua halaman yang telah dimodernisasi dengan UI/UX yang konsisten dan user-friendly! 🎉