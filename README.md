# 🚀 TelEVent - Platform Manajemen Acara Telkom University (Next.js Edition)

Proyek ini merupakan hasil migrasi penuh dari **Laravel 11** ke **Next.js 14 (App Router) + React + TypeScript + Tailwind CSS**.

---

## ✨ Fitur & Peningkatan Baru
- **⚡ Fullstack Next.js (App Router):** Performa tinggi dengan Server Components dan Client Components yang terisolasi.
- **🎨 Desain Modern & Responsif:**
  - Menggunakan **Tailwind CSS** dengan palet warna resmi Telkom University (*Telkom Red `#C60C30`*).
  - Ikon modern menggunakan **Lucide React**.
  - Tampilan card acara dengan badge status, preview poster, dan transisi halus.
  - Sidebar gelap elegan untuk panel administrasi (`/admin`).
- **🗄️ Database & Prisma ORM:**
  - Terhubung langsung ke database MySQL Laragon (`TELEVENT`).
  - Menggunakan tabel yang sama: `users`, `events`, `documents`.
  - Kompatibel 100% dengan hash password Laravel (`bcrypt`).
- **🔐 Autentikasi JWT & Role Protection:**
  - Login & Register dengan verifikasi HTTP-only cookie.
  - Hak akses peran: **Admin** dan **Panitia**.
- **📁 Manajemen Berkas & Dokumen:**
  - Mendukung berkas warisan dari Laravel (`storage/app/public/...`) serta unggahan berkas baru Next.js.
  - Pengunggahan Proposal, Timeline Kegiatan, Rencana Anggaran Biaya (RAB), dan Poster.

---

## 🛠️ Panduan Menjalankan

### 1. Masuk ke Folder Next.js
```bash
cd televent-next
```

### 2. Pastikan Laragon MySQL Berjalan
Pastikan MySQL di Laragon aktif di port `3307` (atau sesuaikan di `.env` jika menggunakan port `3306`).

File `.env`:
```env
DATABASE_URL="mysql://root:@127.0.0.1:3307/TELEVENT"
JWT_SECRET="televent_super_secure_jwt_secret_key_9921_next"
NEXT_PUBLIC_APP_URL="http://localhost:3000"
```

### 3. Jalankan Server Development
```bash
npm run dev
```
Buka browser di **[http://localhost:3000](http://localhost:3000)**.

---

## 👥 Akun Bawaan (Jika menggunakan Seed)
Jika Anda ingin menambahkan akun uji coba baru:
```bash
npx tsx prisma/seed.ts
```

| Peran | Email | Kata Sandi |
| :--- | :--- | :--- |
| **Admin** | `admin@telkomuniversity.ac.id` | `password123` |
| **Panitia** | `panitia@telkomuniversity.ac.id` | `password123` |

*(Catatan: Akun-akun lama yang sudah terdaftar di database MySQL Laravel Anda tetap bisa langsung login dengan email dan password aslinya!)*

---

## 🗺️ Peta Halaman (Routes)
- `/` : Halaman Beranda (Landing page modern dengan statistik, pencarian cepat, dan daftar acara pilihan).
- `/events` : Katalog seluruh kegiatan kampus dengan filter kategori dan kata kunci.
- `/events/[id]` : Rincian lengkap acara, unduh dokumen proposal/RAB/timeline, serta panel verifikasi cepat untuk Admin.
- `/events/create` : Formulir pengajuan proposal kegiatan baru beserta unggah berkas.
- `/about` : Halaman informasi dan panduan alur pengajuan acara.
- `/login` & `/register` : Autentikasi pengguna.
- `/home` : Dashboard panitia untuk memantau proposal miliknya.
- `/profile` & `/profile/edit` : Manajemen profil, kontak, dan riwayat proposal.
- `/admin/dashboard` : Dashboard admin berisi metrik KPI dan antrean verifikasi proposal.
- `/admin/events` : Manajemen dan aksi verifikasi (Setujui / Tolak / Edit / Hapus).
