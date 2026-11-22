'use client';

import React, { useState } from 'react';
import Link from 'next/link';
import { useRouter } from 'next/navigation';
import { Calendar, User, Mail, Lock, Phone, ArrowRight, AlertCircle, Shield } from 'lucide-react';

export default function RegisterPage() {
  const router = useRouter();
  const [name, setName] = useState('');
  const [email, setEmail] = useState('');
  const [phone, setPhone] = useState('');
  const [password, setPassword] = useState('');
  const [role, setRole] = useState('panitia');
  const [error, setError] = useState('');
  const [loading, setLoading] = useState(false);

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setError('');
    setLoading(true);

    try {
      const res = await fetch('/api/auth/register', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ name, email, phone, password, role }),
      });

      const data = await res.json();

      if (!res.ok) {
        setError(data.error || 'Registrasi gagal. Silakan coba lagi.');
        setLoading(false);
        return;
      }

      router.push('/home');
      router.refresh();
    } catch (err: any) {
      console.error(err);
      setError('Terjadi kendala jaringan saat registrasi.');
      setLoading(false);
    }
  };

  return (
    <div className="min-h-screen bg-slate-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
      <div className="sm:mx-auto sm:w-full sm:max-w-md text-center">
        <Link href="/" className="inline-flex items-center gap-2 mb-4 group">
          <div className="w-12 h-12 rounded-2xl bg-telu-600 flex items-center justify-center text-white shadow-glow group-hover:scale-105 transition-transform">
            <Calendar className="w-6 h-6" />
          </div>
        </Link>
        <h2 className="text-3xl font-black text-slate-900 tracking-tight">
          Buat Akun Kepanitiaan
        </h2>
        <p className="mt-2 text-xs text-slate-500">
          Daftarkan akun untuk mengajukan proposal dan mengelola kegiatan Anda.
        </p>
      </div>

      <div className="mt-8 sm:mx-auto sm:w-full sm:max-w-md px-4">
        <div className="bg-white py-8 px-6 sm:px-10 rounded-3xl shadow-sm border border-slate-200/80">
          {error && (
            <div className="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200/60 flex items-start gap-3 text-rose-700 text-xs font-medium">
              <AlertCircle className="w-4 h-4 text-rose-500 flex-shrink-0 mt-0.5" />
              <span>{error}</span>
            </div>
          )}

          <form onSubmit={handleSubmit} className="space-y-4">
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
                  placeholder="Contoh: HIMA IF Tel-U / John Doe"
                  className="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-telu-500 transition-all placeholder-slate-400"
                />
              </div>
            </div>

            <div>
              <label className="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                Email
              </label>
              <div className="relative">
                <Mail className="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" />
                <input
                  type="email"
                  required
                  value={email}
                  onChange={(e) => setEmail(e.target.value)}
                  placeholder="nama@telkomuniversity.ac.id"
                  className="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-telu-500 transition-all placeholder-slate-400"
                />
              </div>
            </div>

            <div>
              <label className="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                Nomor WhatsApp / Telepon
              </label>
              <div className="relative">
                <Phone className="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" />
                <input
                  type="tel"
                  value={phone}
                  onChange={(e) => setPhone(e.target.value)}
                  placeholder="08123456789"
                  className="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-telu-500 transition-all placeholder-slate-400"
                />
              </div>
            </div>

            <div>
              <label className="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                Peran Akun
              </label>
              <div className="relative">
                <Shield className="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" />
                <select
                  value={role}
                  onChange={(e) => setRole(e.target.value)}
                  className="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-telu-500 transition-all cursor-pointer bg-white"
                >
                  <option value="panitia">Panitia Pelaksana (HIMA/UKM)</option>
                  <option value="bendahara">Bendahara Kegiatan</option>
                </select>
              </div>
            </div>

            <div>
              <label className="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                Kata Sandi
              </label>
              <div className="relative">
                <Lock className="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" />
                <input
                  type="password"
                  required
                  value={password}
                  onChange={(e) => setPassword(e.target.value)}
                  placeholder="Minimal 6 karakter"
                  className="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-telu-500 transition-all placeholder-slate-400"
                />
              </div>
            </div>

            <button
              type="submit"
              disabled={loading}
              className="w-full py-3.5 px-4 rounded-xl text-xs font-bold bg-telu-600 hover:bg-telu-700 text-white shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2 mt-4 disabled:opacity-60"
            >
              {loading ? 'Mendaftarkan...' : 'Daftar Sekarang'}
              <ArrowRight className="w-4 h-4" />
            </button>
          </form>

          <div className="mt-6 pt-5 border-t border-slate-100 text-center text-xs text-slate-500">
            Sudah memiliki akun?{' '}
            <Link href="/login" className="font-bold text-telu-600 hover:text-telu-700">
              Masuk di sini
            </Link>
          </div>
        </div>
      </div>
    </div>
  );
}
