# Panduan Deploy Versi Preview ke Vercel

Branch `preview` ini dirancang khusus agar **siap dideploy langsung ke Vercel** tanpa memerlukan konfigurasi database yang rumit. 

---

### Fitur Versi Preview:
1. **Mode Demo Otomatis (Zero-Config):**
   - Jika `DATABASE_URL` belum dihubungkan ke cloud MySQL, aplikasi secara otomatis beralih ke dataset demo kampus Telkom University (lengkap dengan poster kegiatan, rincian proposal, dan jadwal).
2. **Akun Demo Bawaan:**
   - **Panitia / Pengguna:** `panitia@telkomuniversity.ac.id` | Kata Sandi: `password`
   - **Administrator Kampus:** `admin@telkomuniversity.ac.id` | Kata Sandi: `admin123`
   - Tombol **"Isi Otomatis"** tersedia di halaman login pengguna dan portal admin untuk kemudahan peninjauan.
3. **Fitur Pengujian Interaktif:**
   - Pengajuan proposal acara baru tetap berfungsi dan otomatis masuk ke antrean verifikasi.
   - Fitur persetujuan (*approval*) dan penolakan (*rejection*) proposal pada Dashboard Admin berfungsi langsung.
4. **Dukungan Cloud Database (Opsional):**
   - Jika Anda memiliki MySQL Cloud (TiDB Cloud, Railway, PlanetScale, atau Aiven), cukup isi environment variable `DATABASE_URL` di Vercel, dan sistem akan langsung beralih ke database nyata.

---

### Langkah Deploy di Dashboard Vercel:

1. **Buka [vercel.com](https://vercel.com) & Login.**
2. Klik tombol **"Add New..."** → **"Project"**.
3. Pilih repository GitHub: **`JunichiGetCode/TelEvent`**.
4. Pada bagian **Configuration**:
   - **Framework Preset:** `Next.js`
   - **Root Directory:** `./` (default)
5. Pada bagian **Environment Variables** (Opsional jika ingin pakai Database Cloud nyata):
   - `JWT_SECRET`: `televent_super_secret_jwt_key_2026`
   - `DATABASE_URL`: `mysql://user:password@host:port/database` *(biarkan kosong jika ingin memakai mode demo preview bawaan)*
6. Klik **Deploy**!
7. Setelah selesai, Anda akan mendapatkan URL preview seperti `https://televent-preview.vercel.app`.

---

### Perintah Push Branch Preview ke GitHub:

Jalankan perintah ini di terminal lokal Anda untuk mengirimkan branch `preview` ke GitHub:

```bash
git push -u origin preview
```
