'use client';

import React, { useState, useEffect } from 'react';
import Link from 'next/link';
import { useRouter } from 'next/navigation';
import { ArrowLeft, Save, AlertCircle, CheckCircle2, Shield } from 'lucide-react';

export default function AdminEditEventPage({ params }: { params: { id: string } }) {
  const router = useRouter();
  const eventId = params.id;

  const [title, setTitle] = useState('');
  const [type, setType] = useState('Seminar');
  const [startDate, setStartDate] = useState('');
  const [endDate, setEndDate] = useState('');
  const [status, setStatus] = useState('pending');

  const [loading, setLoading] = useState(true);
  const [saving, setSaving] = useState(false);
  const [error, setError] = useState('');
  const [success, setSuccess] = useState('');

  useEffect(() => {
    fetch(`/api/events/${eventId}`)
      .then((res) => {
        if (!res.ok) throw new Error();
        return res.json();
      })
      .then((data) => {
        if (data.event) {
          setTitle(data.event.title || '');
          setType(data.event.type || 'Seminar');
          setStartDate(data.event.start_date ? data.event.start_date.split('T')[0] : '');
          setEndDate(data.event.end_date ? data.event.end_date.split('T')[0] : '');
          setStatus(data.event.status || 'pending');
        }
      })
      .catch(() => {
        setError('Gagal memuat data event.');
      })
      .finally(() => setLoading(false));
  }, [eventId]);

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setError('');
    setSuccess('');
    setSaving(true);

    try {
      const formData = new FormData();
      formData.append('title', title);
      formData.append('type', type);
      if (startDate) formData.append('start_date', startDate);
      if (endDate) formData.append('end_date', endDate);
      formData.append('status', status);

      const res = await fetch(`/api/events/${eventId}`, {
        method: 'PUT',
        body: formData,
      });

      const data = await res.json();

      if (!res.ok) {
        setError(data.error || 'Gagal menyimpan perubahan.');
        setSaving(false);
        return;
      }

      setSuccess('Data proposal berhasil diperbarui!');
      setTimeout(() => {
        router.push('/admin/events');
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
      <div className="flex items-center justify-center min-h-[50vh]">
        <p className="text-xs text-slate-400 font-bold">Memuat rincian acara...</p>
      </div>
    );
  }

  return (
    <div className="max-w-3xl mx-auto space-y-6">
      <Link
        href="/admin/events"
        className="inline-flex items-center gap-2 text-xs font-bold text-slate-500 hover:text-slate-800 transition-colors"
      >
        <ArrowLeft className="w-4 h-4 stroke-[1.75]" />
        Kembali ke Daftar Acara
      </Link>

      <div className="bg-white rounded-3xl p-6 sm:p-10 border border-slate-200/80 shadow-sm">
        <div className="pb-6 border-b border-slate-100 mb-6">
          <div className="inline-flex items-center gap-1.5 text-[10px] font-bold uppercase tracking-wider text-telu-600 mb-1">
            <Shield className="w-3.5 h-3.5 stroke-[1.75]" />
            Penyesuaian Berkas
          </div>
          <h1 className="text-2xl font-black text-slate-900 mt-1">Edit Rincian Acara Admin</h1>
          <p className="text-xs text-slate-500 mt-1">
            Ubah status verifikasi, jenis kegiatan, atau jadwal pelaksanaan secara manual.
          </p>
        </div>

        {error && (
          <div className="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200/60 flex items-start gap-3 text-rose-700 text-xs font-medium">
            <AlertCircle className="w-4 h-4 text-rose-500 flex-shrink-0 mt-0.5 stroke-[1.75]" />
            <span>{error}</span>
          </div>
        )}

        {success && (
          <div className="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200/60 flex items-start gap-3 text-emerald-700 text-xs font-medium">
            <CheckCircle2 className="w-4 h-4 text-emerald-500 flex-shrink-0 mt-0.5 stroke-[1.75]" />
            <span>{success}</span>
          </div>
        )}

        <form onSubmit={handleSubmit} className="space-y-5">
          <div>
            <label className="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
              Status Proposal
            </label>
            <select
              value={status}
              onChange={(e) => setStatus(e.target.value)}
              className="w-full px-4 py-2.5 rounded-xl bg-white border border-slate-200 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-telu-500 cursor-pointer font-medium"
            >
              <option value="pending">Menunggu Review (Pending)</option>
              <option value="approved">Disetujui (Approved)</option>
              <option value="rejected">Ditolak (Rejected)</option>
            </select>
          </div>

          <div>
            <label className="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
              Nama Kegiatan
            </label>
            <input
              type="text"
              required
              value={title}
              onChange={(e) => setTitle(e.target.value)}
              className="w-full px-4 py-2.5 rounded-xl bg-white border border-slate-200 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-telu-500"
            />
          </div>

          <div>
            <label className="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
              Jenis Kegiatan
            </label>
            <select
              value={type}
              onChange={(e) => setType(e.target.value)}
              className="w-full px-4 py-2.5 rounded-xl bg-white border border-slate-200 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-telu-500 cursor-pointer font-medium"
            >
              <option value="Seminar">Seminar</option>
              <option value="Webinar">Webinar</option>
              <option value="Lomba">Lomba</option>
              <option value="Festival">Festival</option>
              <option value="Exhibition">Exhibition</option>
            </select>
          </div>

          <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label className="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                Tanggal Mulai
              </label>
              <input
                type="date"
                value={startDate}
                onChange={(e) => setStartDate(e.target.value)}
                className="w-full px-4 py-2.5 rounded-xl bg-white border border-slate-200 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-telu-500"
              />
            </div>

            <div>
              <label className="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                Tanggal Selesai
              </label>
              <input
                type="date"
                value={endDate}
                onChange={(e) => setEndDate(e.target.value)}
                className="w-full px-4 py-2.5 rounded-xl bg-white border border-slate-200 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-telu-500"
              />
            </div>
          </div>

          <div className="flex items-center justify-end gap-3 pt-6 border-t border-slate-100">
            <Link
              href="/admin/events"
              className="px-4 py-2.5 rounded-xl text-xs font-bold text-slate-500 hover:text-slate-800 transition-colors"
            >
              Batal
            </Link>
            <button
              type="submit"
              disabled={saving}
              className="px-6 py-2.5 rounded-xl text-xs font-bold bg-telu-600 hover:bg-telu-700 text-white shadow-md hover:shadow-lg transition-all flex items-center gap-2 disabled:opacity-60 cursor-pointer"
            >
              <Save className="w-4 h-4 stroke-[1.75]" />
              {saving ? 'Menyimpan...' : 'Simpan Perubahan'}
            </button>
          </div>
        </form>
      </div>
    </div>
  );
}
