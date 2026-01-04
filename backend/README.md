👇👇👇

# 📘 Project Ticket System
Laravel + Filament + Midtrans + React

Dokumentasi ini berisi **panduan instalasi dari awal sampai project siap dijalankan**.
Semua langkah ditulis **berurutan dan wajib diikuti**.

---

## 1️⃣ REQUIREMENTS

Pastikan software berikut sudah terinstall:

- PHP >= 8.1
- Composer
- Node.js >= 18
- NPM
- MySQL / MariaDB
- Git
- Web Server (Laragon / XAMPP / Nginx)

Cek versi:
```bash
php -v
composer -V
node -v
npm -v

2️⃣ INSTALL BACKEND (LARAVEL)
composer create-project laravel/laravel backend
cd backend
php artisan key:generate

3️⃣ KONFIGURASI DATABASE

Edit file .env:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=project_ticket
DB_USERNAME=root
DB_PASSWORD=
   

Jalankan:

php artisan migrate

4️⃣ INSTALL FILAMENT (ADMIN PANEL)
composer require filament/filament:"^3.0"
php artisan filament:install --panels
php artisan make:filament-user


Akses admin:

http://localhost/admin

5️⃣ INSTALL AUTH API (SANCTUM)
composer require laravel/sanctum
php artisan sanctum:install
php artisan migrate

6️⃣ INSTALL MIDTRANS
composer require midtrans/midtrans-php


Tambahkan ke .env:

MIDTRANS_SERVER_KEY=SB-Mid-server-XXXX
MIDTRANS_CLIENT_KEY=SB-Mid-client-XXXX
MIDTRANS_IS_PRODUCTION=false

7️⃣ SETUP EMAIL (SMTP)

Tambahkan ke .env:

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=example@gmail.com
MAIL_PASSWORD=APP_PASSWORD_DISINI
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=example@gmail.com
MAIL_FROM_NAME="Ticket System"

🔐 EMAIL SECURITY (WAJIB)

⚠️ DILARANG menggunakan password email asli

Gunakan Gmail App Password.

Link resmi Google:
https://myaccount.google.com/apppasswords

Langkah singkat:

Aktifkan 2-Step Verification

Buka link di atas

App: Mail

Device: Other → Laravel App

Generate password (16 karakter)

Masukkan ke:

MAIL_PASSWORD=AppPasswordDariGoogle


❌ Jangan share App Password
❌ Jangan gunakan password email biasa

8️⃣ INSTALL FRONTEND (REACT)
npm create vite@latest frontend -- --template react
cd frontend
npm install
npm install axios
npm run dev


Frontend:

http://localhost:5173

9️⃣ MENJALANKAN PROJECT

Backend:

php artisan serve


Akses:

Backend API → http://localhost:8000

Admin Panel → http://localhost/admin

Frontend → http://localhost:5173