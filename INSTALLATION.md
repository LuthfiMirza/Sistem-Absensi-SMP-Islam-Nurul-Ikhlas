# 🚀 Panduan Instalasi Lengkap

## 📋 Daftar Isi
- [Persiapan Environment](#persiapan-environment)
- [Instalasi Step by Step](#instalasi-step-by-step)
- [Konfigurasi Database](#konfigurasi-database)
- [Setup Development](#setup-development)
- [Troubleshooting](#troubleshooting)

---

## 🔧 Persiapan Environment

### **Windows (XAMPP)**
1. **Download dan Install XAMPP**
   ```
   https://www.apachefriends.org/download.html
   - PHP 8.1+
   - MySQL 8.0+
   - Apache 2.4+
   ```

2. **Install Composer**
   ```
   https://getcomposer.org/download/
   ```

3. **Install Node.js**
   ```
   https://nodejs.org/en/download/
   - Version 16.0+
   ```

### **Linux (Ubuntu/Debian)**
```bash
# Update package list
sudo apt update

# Install PHP and extensions
sudo apt install php8.1 php8.1-cli php8.1-fpm php8.1-mysql php8.1-xml php8.1-curl php8.1-gd php8.1-mbstring php8.1-zip php8.1-bcmath

# Install MySQL
sudo apt install mysql-server

# Install Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# Install Node.js
curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
sudo apt-get install -y nodejs
```

### **macOS**
```bash
# Install Homebrew (if not installed)
/bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)"

# Install PHP
brew install php@8.1

# Install MySQL
brew install mysql

# Install Composer
brew install composer

# Install Node.js
brew install node
```

---

## 📦 Instalasi Step by Step

### **1. Clone Repository**
```bash
# Via HTTPS
git clone https://github.com/LuthfiMirza/Sistem-Absensi-SMP-Islam-Nurul-Ikhlas.git

# Via SSH (jika sudah setup SSH key)
git clone git@github.com:LuthfiMirza/Sistem-Absensi-SMP-Islam-Nurul-Ikhlas.git

# Masuk ke direktori project
cd Sistem-Absensi-SMP-Islam-Nurul-Ikhlas
```

### **2. Install Dependencies**
```bash
# Install PHP dependencies
composer install

# Jika ada error, coba:
composer install --ignore-platform-reqs

# Install Node.js dependencies
npm install

# Atau menggunakan Yarn
yarn install
```

### **3. Environment Configuration**
```bash
# Copy file environment
cp .env.example .env

# Generate application key
php artisan key:generate

# Set permissions (Linux/macOS)
chmod 755 -R storage bootstrap/cache
```

### **4. Edit Environment File**
Buka file `.env` dan sesuaikan konfigurasi:

```env
# Application Settings
APP_NAME="Sistem Absensi SMP Islam Nurul Ikhlas"
APP_ENV=local
APP_KEY=base64:your-generated-key
APP_DEBUG=true
APP_URL=http://localhost:8000

# Database Configuration
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=absensi_smp
DB_USERNAME=root
DB_PASSWORD=

# Timezone
APP_TIMEZONE=Asia/Jakarta

# Locale
APP_LOCALE=id
APP_FALLBACK_LOCALE=en
```

---

## 🗄️ Konfigurasi Database

### **1. Buat Database**

#### **Via MySQL Command Line**
```sql
mysql -u root -p
CREATE DATABASE absensi_smp CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
GRANT ALL PRIVILEGES ON absensi_smp.* TO 'root'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

#### **Via phpMyAdmin**
1. Buka `http://localhost/phpmyadmin`
2. Klik "New" untuk membuat database baru
3. Nama database: `absensi_smp`
4. Collation: `utf8mb4_unicode_ci`
5. Klik "Create"

### **2. Run Migrations**
```bash
# Jalankan migrasi database
php artisan migrate

# Jika ingin fresh install
php artisan migrate:fresh

# Dengan seeding data
php artisan migrate:fresh --seed
```

### **3. Create Storage Link**
```bash
# Buat symbolic link untuk storage
php artisan storage:link
```

---

## 🛠️ Setup Development

### **1. Build Assets**
```bash
# Development mode (dengan watch)
npm run dev

# Production build
npm run build

# Watch mode (auto-reload saat file berubah)
npm run watch
```

### **2. Start Development Server**
```bash
# Start Laravel development server
php artisan serve

# Custom host dan port
php artisan serve --host=0.0.0.0 --port=8080
```

### **3. Setup Queue (Optional)**
```bash
# Jika menggunakan queue
php artisan queue:work

# Atau dengan supervisor (production)
php artisan queue:restart
```

---

## 🎯 Seeding Data

### **Default Users**
```bash
# Jalankan seeder untuk membuat user default
php artisan db:seed --class=UserSeeder
```

**Default Login Credentials:**
```
Operator/Admin:
Email: admin@smp.com
Password: password

Guru:
Email: guru@smp.com  
Password: password

Karyawan:
Email: karyawan@smp.com
Password: password
```

### **Sample Data**
```bash
# Seed semua data sample
php artisan db:seed

# Seed specific seeder
php artisan db:seed --class=PositionSeeder
php artisan db:seed --class=AttendanceSeeder
```

---

## 🔧 Troubleshooting

### **Common Issues**

#### **1. Composer Install Error**
```bash
# Error: Platform requirements
composer install --ignore-platform-reqs

# Error: Memory limit
php -d memory_limit=2G /usr/local/bin/composer install
```

#### **2. Permission Errors (Linux/macOS)**
```bash
# Fix storage permissions
sudo chown -R $USER:www-data storage
sudo chown -R $USER:www-data bootstrap/cache
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

#### **3. Database Connection Error**
```bash
# Check MySQL service
sudo systemctl status mysql

# Start MySQL service
sudo systemctl start mysql

# Check database exists
mysql -u root -p -e "SHOW DATABASES;"
```

#### **4. NPM Install Error**
```bash
# Clear npm cache
npm cache clean --force

# Delete node_modules and reinstall
rm -rf node_modules package-lock.json
npm install

# Use different registry
npm install --registry https://registry.npmjs.org/
```

#### **5. Laravel Key Error**
```bash
# Generate new application key
php artisan key:generate

# Clear config cache
php artisan config:clear
```

### **Performance Issues**

#### **1. Optimize for Development**
```bash
# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Optimize autoloader
composer dump-autoload
```

#### **2. Debug Mode**
```env
# Enable debug mode in .env
APP_DEBUG=true
LOG_LEVEL=debug
```

---

## 🌐 Web Server Configuration

### **Apache Virtual Host**
```apache
<VirtualHost *:80>
    ServerName absensi-smp.local
    DocumentRoot /path/to/project/public
    
    <Directory /path/to/project/public>
        AllowOverride All
        Require all granted
    </Directory>
    
    ErrorLog ${APACHE_LOG_DIR}/absensi-error.log
    CustomLog ${APACHE_LOG_DIR}/absensi-access.log combined
</VirtualHost>
```

### **Nginx Configuration**
```nginx
server {
    listen 80;
    server_name absensi-smp.local;
    root /path/to/project/public;

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

## ✅ Verification

### **1. Check Installation**
```bash
# Check PHP version
php -v

# Check Composer
composer --version

# Check Node.js
node --version
npm --version

# Check Laravel
php artisan --version
```

### **2. Test Application**
```bash
# Start server
php artisan serve

# Open browser and visit:
http://localhost:8000

# Test login with default credentials
```

### **3. Run Tests**
```bash
# Run all tests
php artisan test

# Run specific test
php artisan test --filter=UserTest
```

---

## 📞 Getting Help

Jika mengalami masalah saat instalasi:

1. **Check Laravel Logs**
   ```bash
   tail -f storage/logs/laravel.log
   ```

2. **Enable Debug Mode**
   ```env
   APP_DEBUG=true
   ```

3. **Check System Requirements**
   ```bash
   php artisan about
   ```

4. **Community Support**
   - GitHub Issues: [Create Issue](https://github.com/LuthfiMirza/Sistem-Absensi-SMP-Islam-Nurul-Ikhlas/issues)
   - Laravel Documentation: [Laravel Docs](https://laravel.com/docs)

---

**🎉 Selamat! Instalasi berhasil. Aplikasi siap digunakan!**