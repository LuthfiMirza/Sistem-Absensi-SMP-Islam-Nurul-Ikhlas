# 📚 Sistem Absensi SMP Islam Nurul Ikhlas

<div align="center">
  <img src="public/assets/img/smp-logo.png" alt="SMP Islam Nurul Ikhlas Logo" width="120">
  
  <h3>Sistem Manajemen Absensi Digital</h3>
  <p>Aplikasi web untuk mengelola absensi guru dan karyawan dengan teknologi QR Code</p>

  ![Laravel](https://img.shields.io/badge/Laravel-10.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
  ![PHP](https://img.shields.io/badge/PHP-8.1+-777BB4?style=for-the-badge&logo=php&logoColor=white)
  ![MySQL](https://img.shields.io/badge/MySQL-8.0+-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
  ![Bootstrap](https://img.shields.io/badge/Bootstrap-5.2-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)
  ![Livewire](https://img.shields.io/badge/Livewire-2.x-4E56A6?style=for-the-badge&logo=livewire&logoColor=white)
</div>

---

## 📋 Daftar Isi

- [Tentang Proyek](#-tentang-proyek)
- [Fitur Utama](#-fitur-utama)
- [Tech Stack](#-tech-stack)
- [Persyaratan Sistem](#-persyaratan-sistem)
- [Instalasi](#-instalasi)
- [Konfigurasi](#-konfigurasi)
- [Penggunaan](#-penggunaan)
- [User Roles](#-user-roles)
- [API Documentation](#-api-documentation)
- [Screenshots](#-screenshots)
- [Contributing](#-contributing)
- [License](#-license)

---

## 🎯 Tentang Proyek

Sistem Absensi SMP Islam Nurul Ikhlas adalah aplikasi web modern yang dirancang untuk mengelola absensi guru dan karyawan secara digital. Sistem ini menggunakan teknologi QR Code untuk memudahkan proses absensi dan menyediakan dashboard yang komprehensif untuk monitoring kehadiran.

### 🌟 Keunggulan
- **Real-time Monitoring** - Pantau kehadiran secara langsung
- **QR Code Technology** - Absensi cepat dan akurat
- **Multi-Role System** - Operator, Guru, dan Karyawan
- **Responsive Design** - Dapat diakses dari berbagai perangkat
- **Comprehensive Reports** - Laporan kehadiran yang detail

---

## ✨ Fitur Utama

### 👨‍💼 **Untuk Operator/Admin**
- 📊 **Dashboard Analytics** - Statistik kehadiran real-time
- 👥 **Manajemen User** - Kelola data guru dan karyawan
- 📅 **Manajemen Absensi** - Buat dan atur jadwal absensi
- 🏢 **Manajemen Posisi** - Kelola divisi dan mata pelajaran
- 📈 **Laporan Kehadiran** - Export data dalam berbagai format
- 🎯 **Monitoring Real-time** - Pantau absensi secara langsung

### 👨‍🏫 **Untuk Guru/Karyawan**
- 🏠 **Dashboard Personal** - Ringkasan kehadiran pribadi
- ⏰ **Absensi Digital** - Absen masuk/pulang dengan tombol atau QR Code
- 📱 **QR Code Scanner** - Scan QR Code menggunakan kamera
- 📝 **Pengajuan Izin** - Submit permintaan izin online
- 📊 **Riwayat Kehadiran** - Lihat histori absensi 30 hari terakhir
- 🔔 **Notifikasi Status** - Update real-time status absensi

### 🔧 **Fitur Teknis**
- 🔐 **Authentication & Authorization** - Sistem login yang aman
- 📱 **Progressive Web App** - Dapat diinstall di mobile
- 🌐 **Multi-browser Support** - Kompatibel dengan semua browser modern
- 📊 **Data Visualization** - Grafik dan chart interaktif
- 🔄 **Auto-sync** - Sinkronisasi data real-time

---

## 🛠 Tech Stack

### **Backend**
- **Framework**: Laravel 10.x
- **Language**: PHP 8.1+
- **Database**: MySQL 8.0+
- **Real-time**: Livewire 2.x
- **Authentication**: Laravel Sanctum

### **Frontend**
- **CSS Framework**: Bootstrap 5.2
- **Icons**: Font Awesome 6.0
- **JavaScript**: Vanilla JS + ES6 Modules
- **QR Code**: HTML5-QRCode Library
- **Charts**: Chart.js (optional)

### **Tools & Libraries**
- **QR Code Generation**: SimpleSoftwareIO/simple-qrcode
- **PDF Generation**: DomPDF
- **Image Processing**: Intervention Image
- **Development**: Laravel Sail, Vite

### **Infrastructure**
- **Web Server**: Apache/Nginx
- **PHP**: 8.1+ with extensions (BCMath, Ctype, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML)
- **Database**: MySQL 8.0+ / MariaDB 10.3+
- **Cache**: Redis (optional)

---

## 📋 Persyaratan Sistem

### **Minimum Requirements**
- **PHP**: 8.1 atau lebih tinggi
- **Composer**: 2.0+
- **Node.js**: 16.0+ (untuk development)
- **MySQL**: 8.0+ atau MariaDB 10.3+
- **Web Server**: Apache 2.4+ atau Nginx 1.18+

### **PHP Extensions Required**
```bash
- BCMath PHP Extension
- Ctype PHP Extension
- cURL PHP Extension
- DOM PHP Extension
- Fileinfo PHP Extension
- JSON PHP Extension
- Mbstring PHP Extension
- OpenSSL PHP Extension
- PCRE PHP Extension
- PDO PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension
- GD PHP Extension (untuk QR Code)
```

### **Recommended**
- **RAM**: 2GB minimum, 4GB recommended
- **Storage**: 1GB free space
- **SSL Certificate**: Untuk production environment

---

## 🚀 Instalasi

### **1. Clone Repository**
```bash
git clone https://github.com/LuthfiMirza/Sistem-Absensi-SMP-Islam-Nurul-Ikhlas.git
cd Sistem-Absensi-SMP-Islam-Nurul-Ikhlas
```

### **2. Install Dependencies**
```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies (untuk development)
npm install
```

### **3. Environment Setup**
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### **4. Database Configuration**
Edit file `.env` dan sesuaikan konfigurasi database:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=absensi_smp
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### **5. Database Migration & Seeding**
```bash
# Create database
mysql -u root -p -e "CREATE DATABASE absensi_smp"

# Run migrations
php artisan migrate

# Seed initial data (optional)
php artisan db:seed
```

### **6. Storage Link**
```bash
# Create symbolic link for storage
php artisan storage:link
```

### **7. Build Assets (Development)**
```bash
# Compile assets
npm run dev

# Or for production
npm run build
```

### **8. Start Development Server**
```bash
php artisan serve
```

Aplikasi akan tersedia di: `http://localhost:8000`

---

## ⚙️ Konfigurasi

### **Environment Variables**
```env
# Application
APP_NAME="Sistem Absensi SMP Islam Nurul Ikhlas"
APP_ENV=local
APP_KEY=base64:your-app-key
APP_DEBUG=true
APP_URL=http://localhost:8000

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=absensi_smp
DB_USERNAME=root
DB_PASSWORD=

# Mail Configuration (optional)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls

# Queue (optional)
QUEUE_CONNECTION=database

# Cache (optional)
CACHE_DRIVER=file
SESSION_DRIVER=file
```

### **Web Server Configuration**

#### **Apache (.htaccess)**
```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
```

#### **Nginx**
```nginx
server {
    listen 80;
    server_name your-domain.com;
    root /path/to/your/project/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

---

## 📖 Penggunaan

### **🔐 Login Sistem**
1. Akses aplikasi melalui browser
2. Masukkan email dan password
3. Sistem akan mengarahkan sesuai role user

### **👨‍💼 Untuk Operator/Admin**

#### **Dashboard**
- Lihat statistik kehadiran real-time
- Monitor absensi hari ini
- Akses quick actions

#### **Manajemen Data**
```bash
# Kelola Posisi/Divisi
/positions - Daftar posisi
/positions/create - Tambah posisi baru
/positions/edit?id={id} - Edit posisi

# Kelola Guru/Karyawan
/employees - Daftar karyawan
/employees/create - Tambah karyawan baru
/employees/edit?id={id} - Edit data karyawan

# Kelola Absensi
/attendances - Daftar absensi
/attendances/create - Buat absensi baru
/attendances/{id} - Detail absensi
/attendances/edit?id={id} - Edit absensi

# Kelola Kehadiran
/presences - Data kehadiran
/presences/{attendance} - Detail kehadiran per absensi
/presences/qrcode - Generate QR Code
```

### **👨‍🏫 Untuk Guru/Karyawan**

#### **Beranda**
```bash
/home - Dashboard personal dengan daftar absensi hari ini
```

#### **Absensi**
```bash
# Akses absensi
/absensi/{id} - Halaman absensi tertentu

# Metode absensi:
1. Tombol Manual - Klik "Masuk" atau "Pulang"
2. QR Code Scanner - Scan QR Code dengan kamera
```

#### **Pengajuan Izin**
```bash
/absensi/{id}/permission - Form pengajuan izin
```

#### **Monitoring**
```bash
/absensi/{id}/detail - Detail kehadiran
/absensi/{id}/permissions - Data izin
/absensi/{id}/not-present - Yang belum absen
```

### **📱 QR Code Usage**

#### **Generate QR Code (Admin)**
1. Masuk ke menu Absensi
2. Edit absensi dan tambahkan kode QR
3. QR Code akan otomatis ter-generate
4. Download atau tampilkan QR Code

#### **Scan QR Code (User)**
1. Masuk ke halaman absensi
2. Klik "Scan QR Code Masuk/Pulang"
3. Izinkan akses kamera
4. Arahkan kamera ke QR Code
5. Sistem otomatis mencatat kehadiran

---

## 👥 User Roles

### **🔧 Operator/Admin**
**Permissions:**
- ✅ Akses dashboard admin
- ✅ CRUD semua data (posisi, karyawan, absensi)
- ✅ Lihat semua laporan kehadiran
- ✅ Generate QR Code
- ✅ Approve/reject izin
- ✅ Export data

**Default Login:**
```
Email: admin@smp.com
Password: password
```

### **👨‍🏫 Guru**
**Permissions:**
- ✅ Akses dashboard personal
- ✅ Absensi masuk/pulang
- ✅ Pengajuan izin
- ✅ Lihat riwayat kehadiran pribadi
- ✅ Scan QR Code

**Role ID:** 3

### **👨‍💼 Karyawan**
**Permissions:**
- ✅ Akses dashboard personal
- ✅ Absensi masuk/pulang
- ✅ Pengajuan izin
- ✅ Lihat riwayat kehadiran pribadi
- ✅ Scan QR Code

**Role ID:** 2

---

## 📊 API Documentation

### **Authentication**
```http
POST /login
Content-Type: application/json

{
    "email": "user@example.com",
    "password": "password"
}
```

### **QR Code Absensi**
```http
# Absen Masuk
POST /absensi/qrcode
Content-Type: application/x-www-form-urlencoded

code=QR_CODE_VALUE

# Absen Pulang
POST /absensi/qrcode/out
Content-Type: application/x-www-form-urlencoded

code=QR_CODE_VALUE
```

### **Response Format**
```json
{
    "success": true,
    "message": "Kehadiran berhasil dicatat",
    "data": {
        "user_id": 1,
        "attendance_id": 1,
        "presence_date": "2024-01-15",
        "presence_enter_time": "07:30:00"
    }
}
```

---

## 📸 Screenshots

### **Dashboard Admin**
![Dashboard Admin](docs/screenshots/admin-dashboard.png)

### **Dashboard Guru/Karyawan**
![Dashboard User](docs/screenshots/user-dashboard.png)

### **Halaman Absensi**
![Absensi Page](docs/screenshots/attendance-page.png)

### **QR Code Scanner**
![QR Scanner](docs/screenshots/qr-scanner.png)

### **Mobile View**
![Mobile View](docs/screenshots/mobile-view.png)

---

## 🔧 Development

### **Local Development**
```bash
# Start development server
php artisan serve

# Watch for file changes
npm run dev

# Run tests
php artisan test

# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

### **Database Management**
```bash
# Create migration
php artisan make:migration create_table_name

# Create model
php artisan make:model ModelName -m

# Create seeder
php artisan make:seeder TableSeeder

# Fresh migration with seeding
php artisan migrate:fresh --seed
```

### **Livewire Components**
```bash
# Create Livewire component
php artisan make:livewire ComponentName

# Publish Livewire assets
php artisan livewire:publish --assets
```

---

## 🚀 Deployment

### **Production Setup**
```bash
# Optimize for production
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Set proper permissions
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### **Environment Production**
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

# Use production database
DB_HOST=your-production-host
DB_DATABASE=your-production-db

# Configure mail for production
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
```

---

## 🤝 Contributing

Kami menyambut kontribusi dari komunitas! Berikut cara berkontribusi:

### **Getting Started**
1. Fork repository ini
2. Create feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to branch (`git push origin feature/AmazingFeature`)
5. Open Pull Request

### **Coding Standards**
- Ikuti PSR-12 coding standards
- Gunakan meaningful variable names
- Tambahkan comments untuk logic yang kompleks
- Write tests untuk fitur baru

### **Bug Reports**
Gunakan GitHub Issues untuk melaporkan bug dengan informasi:
- Deskripsi bug yang jelas
- Steps to reproduce
- Expected vs actual behavior
- Screenshots (jika applicable)
- Environment details

---

## 📝 Changelog

### **v1.0.0** (2024-01-15)
- ✨ Initial release
- ✅ Basic authentication system
- ✅ User management (Operator, Guru, Karyawan)
- ✅ Attendance management
- ✅ QR Code integration
- ✅ Permission system
- ✅ Responsive design

### **v1.1.0** (Coming Soon)
- 🔄 Real-time notifications
- 📊 Advanced reporting
- 📱 PWA support
- 🌐 Multi-language support

---

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

---

## 👨‍💻 Author

**Luthfi Mirza**
- GitHub: [@LuthfiMirza](https://github.com/LuthfiMirza)
- Email: luthfimirza@example.com

---

## 🙏 Acknowledgments

- **SMP Islam Nurul Ikhlas** - Untuk kepercayaan mengembangkan sistem ini
- **Laravel Community** - Framework yang luar biasa
- **Bootstrap Team** - UI framework yang responsive
- **Font Awesome** - Icon library yang lengkap

---

## 📞 Support

Jika Anda mengalami masalah atau memiliki pertanyaan:

1. **Documentation**: Baca dokumentasi lengkap di atas
2. **Issues**: Buat issue di GitHub repository
3. **Email**: Hubungi developer melalui email
4. **Community**: Join diskusi di GitHub Discussions

---

<div align="center">
  <p>Made with ❤️ for SMP Islam Nurul Ikhlas</p>
  <p>© 2024 Luthfi Mirza. All rights reserved.</p>
</div>