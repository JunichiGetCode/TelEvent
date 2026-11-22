'use client';

import React, { useState, useEffect, Suspense } from 'react';
import Link from 'next/link';
import { useRouter, useSearchParams } from 'next/navigation';
import { Calendar, Mail, Lock, ArrowRight, AlertCircle, ArrowLeft, Shield } from 'lucide-react';

function AdminLoginForm() {
  const router = useRouter();
  const searchParams = useSearchParams();

  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [error, setError] = useState('');
  const [loading, setLoading] = useState(false);

  useEffect(() => {
    if (searchParams.get('error') === 'unauthorized') {
      setError('Akses ditolak. Akun Anda tidak memiliki hak akses Administrator.');
    }
  }, [searchParams]);

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setError('');
    setLoading(true);

    try {
      const res = await fetch('/api/auth/login', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ email, password, requireAdmin: true }),
      });

      const data = await res.json();

      if (!res.ok) {
        setError(data.error || 'Login gagal. Silakan periksa kembali email dan kata sandi Anda.');
        setLoading(false);
        return;
      }

      router.push('/admin/dashboard');
      router.refresh();
    } catch (err: any) {
      console.error(err);
      setError('Terjadi kendala jaringan saat menghubungi server.');
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
        <div className="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-telu-50 text-telu-700 border border-telu-200/60 mb-3">
          <Shield className="w-3.5 h-3.5" />
          Portal Khusus Administrator
        </div>
        <h2 className="text-3xl font-black text-slate-900 tracking-tight">
          Masuk ke Akun Admin
        </h2>
        <p className="mt-2 text-xs text-slate-500">
          Verifikasi proposal kegiatan dan kelola agenda kampus Telkom University.
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

          <form onSubmit={handleSubmit} className="space-y-5">
            <div>
              <label className="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                Alamat Email Administrator
              </label>
              <div className="relative">
                <Mail className="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" />
                <input
                  type="email"
                  required
                  value={email}
                  onChange={(e) => setEmail(e.target.value)}
                  placeholder="admin@telkomuniversity.ac.id"
                  className="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-telu-500 transition-all placeholder-slate-400"
                />
              </div>
            </div>

            <div>
              <div className="flex items-center justify-between mb-2">
                <label className="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                  Kata Sandi Admin
                </label>
              </div>
              <div className="relative">
                <Lock className="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" />
                <input
                  type="password"
                  required
                  value={password}
                  onChange={(e) => setPassword(e.target.value)}
                  placeholder="••••••••"
                  className="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-telu-500 transition-all placeholder-slate-400"
                />
              </div>
            </div>

            <button
              type="submit"
              disabled={loading}
              className="w-full py-3.5 px-4 rounded-xl text-xs font-bold bg-telu-600 hover:bg-telu-700 text-white shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2 disabled:opacity-60 cursor-pointer"
            >
              {loading ? 'Memverifikasi...' : 'Masuk sebagai Admin'}
              <ArrowRight className="w-4 h-4" />
            </button>
          </form>

          <div className="mt-8 pt-6 border-t border-slate-100 flex flex-col gap-2.5 text-center text-xs text-slate-500">
            <div>
              Bukan pengelola / administrator?{' '}
              <Link href="/login" className="font-bold text-telu-600 hover:text-telu-700">
                Masuk ke Portal Panitia / Mahasiswa
              </Link>
            </div>
            <div className="pt-2.5 border-t border-slate-100">
              <Link
                href="/"
                className="inline-flex items-center justify-center gap-1.5 font-semibold text-slate-500 hover:text-slate-800 transition-colors"
              >
                <ArrowLeft className="w-3.5 h-3.5" />
                Kembali ke Beranda Utama
              </Link>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}

export default function AdminLoginPage() {
  return (
    <Suspense
      fallback={
        <div className="min-h-screen bg-slate-50 flex items-center justify-center">
          <p className="text-xs font-bold text-slate-400">Memuat formulir login admin...</p>
        </div>
      }
    >
      <AdminLoginForm />
    </Suspense>
  );
}
