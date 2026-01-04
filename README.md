# 🌿 Website Penglipuran

Website Penglipuran adalah aplikasi **pemesanan tiket wisata Desa Penglipuran Bali** yang dibangun dengan arsitektur **backend–frontend terpisah (monorepo)**.

Project ini mencakup:
- 🎫 Sistem paket tiket (anak & dewasa, lokal & mancanegara)
- 🧾 Manajemen data melalui dashboard admin
- 💳 Integrasi pembayaran online (Midtrans – sandbox)
- 🌐 Frontend modern menggunakan React

---

## 🧱 Tech Stack

### Backend
- Laravel
- Filament Admin Panel
- MySQL / MariaDB
- REST API
- Midtrans (Sandbox)

### Frontend
- React.js
- Vite
- Axios
- CSS / Tailwind (opsional)

---

## 📂 Struktur Project



website-penglipuran/
├── backend/ # Laravel Backend + Admin Panel
├── frontend/ # React Frontend
├── .gitignore
└── README.md


---

## ⚙️ Setup Backend (Laravel)

### 1️⃣ Masuk folder backend
```bash
cd backend

2️⃣ Install dependency
composer install

3️⃣ Setup environment
cp .env.example .env
php artisan key:generate


Sesuaikan database di file .env:

DB_DATABASE=nama_database
DB_USERNAME=root
DB_PASSWORD=

4️⃣ Migrasi & Seeder
php artisan migrate --seed


Seeder akan membuat:

Paket tiket

Kategori tiket (Lokal & Mancanegara)

Ticket version (Anak & Dewasa)

5️⃣ Jalankan server
php artisan serve


Backend akan berjalan di:

http://127.0.0.1:8000

🎛️ Admin Panel (Filament)

Akses dashboard admin:

http://127.0.0.1:8000/admin


Fitur admin:

Kelola paket wisata

Kelola kategori & harga tiket

Kelola order

Monitoring transaksi

⚙️ Setup Frontend (React)
1️⃣ Masuk folder frontend
cd frontend

2️⃣ Install dependency
npm install

3️⃣ Setup environment
cp .env.example .env


Contoh isi .env:

VITE_API_URL=http://127.0.0.1:8000/api
VITE_MIDTRANS_CLIENT_KEY=

4️⃣ Jalankan frontend
npm run dev


Frontend akan berjalan di:

http://localhost:5173

💳 Pembayaran (Midtrans)

Project ini menggunakan Midtrans Sandbox untuk pembayaran online.

Pastikan di backend .env:

MIDTRANS_SERVER_KEY=
MIDTRANS_CLIENT_KEY=
MIDTRANS_IS_PRODUCTION=false

🔐 Keamanan Environment

File .env TIDAK DIUPLOAD ke GitHub

File .env.example digunakan sebagai template konfigurasi

Semua API key & credential bersifat lokal

🚀 Tujuan Project

Website ini dibuat untuk:

Digitalisasi pemesanan tiket wisata Penglipuran

Memudahkan wisatawan lokal & mancanegara

Menyediakan sistem administrasi terpusat

Menjadi project pembelajaran Laravel & React skala nyata

👨‍💻 Developer

Project ini dikembangkan sebagai bagian dari pembelajaran & pengembangan sistem web modern menggunakan Laravel + React.

📌 Catatan

Project ini masih dapat dikembangkan lebih lanjut:

QR Code tiket

Email notifikasi

Report transaksi

Mode production Midtrans
