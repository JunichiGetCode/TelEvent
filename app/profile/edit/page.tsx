'use client';

import React, { useState, useEffect } from 'react';
import Link from 'next/link';
import { useRouter } from 'next/navigation';
import { User, Mail, Phone, Upload, ArrowLeft, AlertCircle, CheckCircle2 } from 'lucide-react';

export default function EditProfilePage() {
  const router = useRouter();
  const [name, setName] = useState('');
  const [email, setEmail] = useState('');
  const [phone, setPhone] = useState('');
  const [currentAvatar, setCurrentAvatar] = useState<string | null>(null);
  const [avatarFile, setAvatarFile] = useState<File | null>(null);

  const [loading, setLoading] = useState(true);
  const [saving, setSaving] = useState(false);
  const [error, setError] = useState('');
  const [success, setSuccess] = useState('');

  useEffect(() => {
    fetch('/api/auth/me')
      .then((res) => {
        if (!res.ok) throw new Error();
        return res.json();
      })
      .then((data) => {
        if (data.user) {
          setName(data.user.name || '');
          setEmail(data.user.email || '');
          setPhone(data.user.phone || '');
          setCurrentAvatar(data.user.avatar || null);
        }
      })
      .catch(() => {
        router.push('/login');
      })
      .finally(() => setLoading(false));
  }, [router]);

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setError('');
    setSuccess('');
    setSaving(true);

    try {
      const formData = new FormData();
      formData.append('name', name);
      formData.append('email', email);
      formData.append('phone', phone);
      if (avatarFile) {
        formData.append('avatar', avatarFile);
      }

      const res = await fetch('/api/profile', {
        method: 'PUT',
        body: formData,
      });

      const data = await res.json();

      if (!res.ok) {
        setError(data.error || 'Gagal memperbarui profil.');
        setSaving(false);
        return;
      }

      setSuccess('Profil berhasil diperbarui!');
      setTimeout(() => {
        router.push('/profile');
        router.refresh();
      }, 1000);
    } catch (err: any) {
      console.error(err);
      setError('Terjadi kendala jaringan.');
      setSaving(false);
    }
  };

  if (loading) {
    return (
      <div className="min-h-screen bg-slate-50 flex items-center justify-center">
        <p className="text-xs font-bold text-slate-400">Memuat data profil...</p>
      </div>
    );
  }

  return (
    <div className="min-h-screen bg-slate-50 py-10">
      <div className="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <Link
          href="/profile"
          className="inline-flex items-center gap-2 text-xs font-bold text-slate-500 hover:text-telu-600 transition-colors mb-6"
        >
          <ArrowLeft className="w-4 h-4" />
          Kembali ke Profil
        </Link>

        <div className="bg-white rounded-3xl p-6 sm:p-10 border border-slate-200/80 shadow-sm">
          <div className="pb-6 border-b border-slate-100 mb-6">
            <h1 className="text-2xl font-black text-slate-900">Edit Profil Akun</h1>
            <p className="text-xs text-slate-500 mt-1">
              Perbarui identitas dan kontak perwakilan ormawa Anda.
            </p>
          </div>

          {error && (
            <div className="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200/60 flex items-start gap-3 text-rose-700 text-xs font-medium">
              <AlertCircle className="w-4 h-4 text-rose-500 flex-shrink-0 mt-0.5" />
              <span>{error}</span>
            </div>
          )}

          {success && (
            <div className="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200/60 flex items-start gap-3 text-emerald-700 text-xs font-medium">
              <CheckCircle2 className="w-4 h-4 text-emerald-500 flex-shrink-0 mt-0.5" />
              <span>{success}</span>
            </div>
          )}

          <form onSubmit={handleSubmit} className="space-y-5">
            {/* Avatar Preview & Upload */}
            <div>
              <label className="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-3">
                Foto Profil / Logo Ormawa
              </label>
              <div className="flex items-center gap-4">
                {avatarFile ? (
                  <div className="w-16 h-16 rounded-2xl overflow-hidden border border-slate-200 bg-slate-100">
                    <img
                      src={URL.createObjectURL(avatarFile)}
                      alt="Preview"
                      className="w-full h-full object-cover"
                    />
                  </div>
                ) : currentAvatar ? (
                  <img
                    src={currentAvatar.startsWith('http') || currentAvatar.startsWith('/') ? currentAvatar : `/uploads/profile/${currentAvatar}`}
                    alt="Current Avatar"
                    className="w-16 h-16 rounded-2xl object-cover border border-slate-200"
                  />
                ) : (
                  <div className="w-16 h-16 rounded-2xl bg-telu-100 text-telu-700 font-bold flex items-center justify-center text-xl">
                    {name ? name.charAt(0).toUpperCase() : 'U'}
                  </div>
                )}

                <div>
                  <input
                    type="file"
                    id="avatar-upload"
                    accept="image/png,image/jpeg,image/jpg"
                    onChange={(e) => setAvatarFile(e.target.files?.[0] || null)}
                    className="hidden"
                  />
                  <label
                    htmlFor="avatar-upload"
                    className="px-4 py-2 rounded-xl border border-slate-200 hover:bg-slate-50 text-xs font-bold text-slate-700 cursor-pointer transition-colors inline-block"
                  >
                    Ganti Foto
                  </label>
                  <p className="text-[11px] text-slate-400 mt-1">Maksimal 2MB (JPG/PNG)</p>
                </div>
              </div>
            </div>

            <div>
              <label className="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                Nama Lengkap / Nama Ormawa
              </label>
              <div className="relative">
                <User className="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" />
                <input
                  type="text"
                  required
                  value={name}
                  onChange={(e) => setName(e.target.value)}
                  className="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-telu-500"
                />
              </div>
            </div>

            <div>
              <label className="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                Alamat Email
              </label>
              <div className="relative">
                <Mail className="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" />
                <input
                  type="email"
                  required
                  value={email}
                  onChange={(e) => setEmail(e.target.value)}
                  className="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-telu-500"
                />
              </div>
            </div>

            <div>
              <label className="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                Nomor WhatsApp
              </label>
              <div className="relative">
                <Phone className="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" />
                <input
                  type="tel"
                  value={phone}
                  onChange={(e) => setPhone(e.target.value)}
                  placeholder="08123456789"
                  className="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-telu-500"
                />
              </div>
            </div>

            <div className="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
              <Link
                href="/profile"
                className="px-4 py-2 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-100 transition-colors"
              >
                Batal
              </Link>
              <button
                type="submit"
                disabled={saving}
                className="px-6 py-2.5 rounded-xl text-xs font-bold bg-telu-600 hover:bg-telu-700 text-white shadow-md transition-all disabled:opacity-60"
              >
                {saving ? 'Menyimpan...' : 'Simpan Perubahan'}
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  );
}
