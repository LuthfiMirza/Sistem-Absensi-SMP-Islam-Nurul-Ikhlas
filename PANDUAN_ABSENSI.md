# 📋 Panduan Lengkap Sistem Absensi

## 🎯 Cara Mengakses Absensi

### 1. **Login ke Sistem**
- Buka browser dan akses: `http://127.0.0.1:8000`
- Login menggunakan akun guru/karyawan
- Setelah login, Anda akan diarahkan ke halaman beranda

### 2. **Mengakses Halaman Absensi**

#### **Melalui Beranda:**
1. Di halaman beranda (`/home`), Anda akan melihat daftar absensi hari ini
2. Klik pada salah satu item absensi yang tersedia
3. Anda akan diarahkan ke halaman detail absensi

#### **Melalui Sidebar:**
1. Di sidebar kiri, lihat bagian **"ABSENSI"**
2. Klik pada salah satu absensi yang tersedia
3. Atau gunakan menu **"KELOLA ABSENSI"** untuk melihat detail

#### **URL Langsung:**
- Format: `/absensi/{id_attendance}`
- Contoh: `http://127.0.0.1:8000/absensi/1`

## 🕐 Cara Melakukan Absensi

### **A. Absensi dengan Tombol (Manual)**

#### **Absen Masuk:**
1. Masuk ke halaman absensi
2. Pastikan waktu absen masuk sudah dimulai
3. Klik tombol **"Masuk"** berwarna biru
4. Sistem akan mencatat waktu masuk Anda

#### **Absen Pulang:**
1. Pastikan Anda sudah absen masuk
2. Tunggu hingga waktu absen pulang dimulai
3. Klik tombol **"Pulang"** berwarna biru
4. Sistem akan mencatat waktu pulang Anda

### **B. Absensi dengan QR Code**

#### **Absen Masuk:**
1. Masuk ke halaman absensi
2. Klik tombol **"Scan QR Code Masuk"**
3. Izinkan akses kamera
4. Arahkan kamera ke QR Code absensi
5. Sistem otomatis mencatat kehadiran

#### **Absen Pulang:**
1. Pastikan Anda sudah absen masuk
2. Klik tombol **"Scan QR Code Pulang"**
3. Scan QR Code yang sama
4. Sistem akan mencatat waktu pulang

## 📝 Fitur Izin

### **Mengajukan Izin:**
1. Di halaman absensi, klik tombol **"Ajukan Izin"**
2. Isi form izin dengan lengkap:
   - Tanggal izin
   - Alasan izin
   - Keterangan tambahan
3. Submit form
4. Tunggu persetujuan dari admin/operator

### **Status Izin:**
- **Diproses**: Permintaan sedang menunggu persetujuan
- **Diterima**: Izin telah disetujui
- **Ditolak**: Izin tidak disetujui

## 📊 Melihat Riwayat Kehadiran

### **Di Halaman Absensi:**
1. Scroll ke bagian **"Riwayat Kehadiran"**
2. Lihat tabel dengan data 30 hari terakhir
3. Informasi yang ditampilkan:
   - Tanggal
   - Waktu masuk
   - Waktu pulang
   - Status (Hadir/Izin/Tidak Hadir)

### **Ringkasan Statistik:**
- **Hadir**: Total hari hadir
- **Izin**: Total hari izin
- **Tidak Hadir**: Total hari tidak hadir

## ⏰ Aturan Waktu Absensi

### **Waktu Absensi:**
- **Waktu Masuk**: Sesuai jadwal yang ditetapkan
- **Batas Waktu Masuk**: Batas maksimal absen masuk
- **Waktu Pulang**: Waktu mulai bisa absen pulang
- **Batas Waktu Pulang**: Batas maksimal absen pulang

### **Status Waktu:**
- **Hijau**: Sedang dalam waktu absensi
- **Merah**: Di luar waktu absensi
- **Kuning**: Mendekati batas waktu

## 🚨 Troubleshooting

### **Tidak Bisa Absen:**
1. **Periksa waktu**: Pastikan dalam jam absensi
2. **Periksa koneksi**: Pastikan internet stabil
3. **Refresh halaman**: Tekan F5 atau klik "Refresh Status"
4. **Hubungi admin**: Jika masalah berlanjut

### **QR Code Tidak Terbaca:**
1. **Pencahayaan**: Pastikan cahaya cukup
2. **Jarak**: Atur jarak kamera dengan QR Code
3. **Stabilitas**: Tahan kamera dengan stabil
4. **Browser**: Pastikan menggunakan browser modern

### **Sidebar Tidak Muncul:**
1. **Login ulang**: Logout dan login kembali
2. **Clear cache**: Hapus cache browser
3. **Periksa role**: Pastikan akun memiliki akses yang benar

## 📱 Akses Mobile

### **Responsive Design:**
- Sistem dapat diakses melalui smartphone
- Sidebar akan menjadi menu hamburger
- QR Code scanner berfungsi di mobile

### **Tips Mobile:**
1. Gunakan browser Chrome/Safari terbaru
2. Izinkan akses kamera untuk QR Code
3. Pastikan koneksi internet stabil

## 🔗 URL Penting

| Halaman | URL | Deskripsi |
|---------|-----|-----------|
| Beranda | `/home` | Halaman utama guru/karyawan |
| Absensi | `/absensi/{id}` | Detail absensi tertentu |
| Izin | `/absensi/{id}/permission` | Form pengajuan izin |
| Test Sidebar | `/test-sidebar` | Halaman debug sidebar |

## 👥 Kontak Support

Jika mengalami masalah:
1. **Admin Sistem**: Hubungi operator sekolah
2. **IT Support**: Untuk masalah teknis
3. **Kepala Sekolah**: Untuk kebijakan absensi

---

## 📋 Checklist Harian

### **Sebelum Berangkat:**
- [ ] Cek jadwal absensi hari ini
- [ ] Pastikan smartphone/laptop siap
- [ ] Cek koneksi internet

### **Saat Tiba:**
- [ ] Login ke sistem
- [ ] Lakukan absen masuk
- [ ] Cek status absensi berhasil

### **Saat Pulang:**
- [ ] Lakukan absen pulang
- [ ] Cek riwayat kehadiran
- [ ] Logout dari sistem

---

**💡 Tips:** Bookmark halaman absensi untuk akses cepat setiap hari!

**⚠️ Penting:** Selalu lakukan absensi sesuai waktu yang ditentukan untuk menghindari keterlambatan pencatatan.