'use client';

import React, { useState } from 'react';
import Link from 'next/link';
import { useRouter } from 'next/navigation';
import {
  Calendar,
  FileText,
  FileSpreadsheet,
  Clock,
  Image as ImageIcon,
  Paperclip,
  ArrowRight,
  AlertCircle,
  CheckCircle2,
  UploadCloud,
  ArrowLeft,
} from 'lucide-react';

export default function CreateEventPage() {
  const router = useRouter();
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState('');

  // Form states
  const [title, setTitle] = useState('');
  const [type, setType] = useState('Seminar');
  const [startDate, setStartDate] = useState('');
  const [endDate, setEndDate] = useState('');

  // Files
  const [proposal, setProposal] = useState<File | null>(null);
  const [timeline, setTimeline] = useState<File | null>(null);
  const [budgeting, setBudgeting] = useState<File | null>(null);
  const [poster, setPoster] = useState<File | null>(null);
  const [otherData, setOtherData] = useState<File | null>(null);

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setError('');

    if (!title.trim()) {
      setError('Nama kegiatan wajib diisi.');
      return;
    }

    if (!proposal || !timeline || !budgeting) {
      setError('Tiga dokumen wajib (Proposal, Timeline, dan Budgeting) harus diunggah.');
      return;
    }

    setLoading(true);

    try {
      const formData = new FormData();
      formData.append('title', title);
      formData.append('type', type);
      if (startDate) formData.append('start_date', startDate);
      if (endDate) formData.append('end_date', endDate);

      formData.append('proposal', proposal);
      formData.append('timeline', timeline);
      formData.append('budgeting', budgeting);
      if (poster) formData.append('poster', poster);
      if (otherData) formData.append('other_data', otherData);

      const res = await fetch('/api/events', {
        method: 'POST',
        body: formData,
      });

      const data = await res.json();

      if (!res.ok) {
        setError(data.error || 'Gagal mengajukan acara. Silakan cek kembali input Anda.');
        setLoading(false);
        return;
      }

      router.push('/profile?success=event_created');
      router.refresh();
    } catch (err: any) {
      console.error(err);
      setError('Terjadi kendala jaringan saat mengunggah berkas.');
      setLoading(false);
    }
  };

  return (
    <div className="min-h-screen bg-slate-50 py-10">
      <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <Link
          href="/home"
          className="inline-flex items-center gap-2 text-xs font-bold text-slate-500 hover:text-telu-600 transition-colors mb-6"
        >
          <ArrowLeft className="w-4 h-4" />
          Kembali ke Dashboard
        </Link>

        {/* Page Title */}
        <div className="mb-8">
          <div className="inline-flex items-center gap-2 text-xs font-bold text-telu-600 uppercase tracking-wider mb-1">
            <Calendar className="w-4 h-4" />
            Pengajuan Acara Baru
          </div>
          <h1 className="text-3xl font-black text-slate-900 tracking-tight">
            Formulir Proposal Kegiatan
          </h1>
          <p className="text-xs text-slate-500 mt-1">
            Lengkapi data kegiatan dan lampirkan dokumen pendukung untuk diverifikasi oleh admin kemahasiswaan.
          </p>
        </div>

        {error && (
          <div className="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200/60 flex items-start gap-3 text-rose-700 text-xs font-medium">
            <AlertCircle className="w-4 h-4 text-rose-500 flex-shrink-0 mt-0.5" />
            <span>{error}</span>
          </div>
        )}

        <form onSubmit={handleSubmit} className="space-y-6">
          {/* 1. INFORMASI DASAR */}
          <div className="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm space-y-5">
            <div className="flex items-center gap-3 pb-3 border-b border-slate-100">
              <div className="w-8 h-8 rounded-xl bg-telu-50 text-telu-600 flex items-center justify-center font-bold">
                1
              </div>
              <h3 className="text-sm font-bold text-slate-900">Rincian Informasi Acara</h3>
            </div>

            <div className="grid grid-cols-1 sm:grid-cols-3 gap-4">
              <div className="sm:col-span-2">
                <label className="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                  Nama Kegiatan / Acara <span className="text-telu-600">*</span>
                </label>
                <input
                  type="text"
                  required
                  value={title}
                  onChange={(e) => setTitle(e.target.value)}
                  placeholder="Contoh: Telkom University Tech Summit 2026"
                  className="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-telu-500 placeholder-slate-400"
                />
              </div>

              <div>
                <label className="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                  Jenis Acara <span className="text-telu-600">*</span>
                </label>
                <select
                  value={type}
                  onChange={(e) => setType(e.target.value)}
                  className="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-telu-500 bg-white cursor-pointer"
                >
                  <option value="Seminar">📚 Seminar</option>
                  <option value="Webinar">💻 Webinar</option>
                  <option value="Lomba">🏆 Lomba</option>
                  <option value="Festival">🎪 Festival</option>
                  <option value="Exhibition">🏛 Exhibition</option>
                </select>
              </div>

              <div>
                <label className="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                  Tanggal Mulai
                </label>
                <input
                  type="date"
                  value={startDate}
                  onChange={(e) => setStartDate(e.target.value)}
                  className="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-telu-500 bg-white"
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
                  className="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-telu-500 bg-white"
                />
              </div>
            </div>
          </div>

          {/* 2. DOKUMEN WAJIB */}
          <div className="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm space-y-5">
            <div className="flex items-center gap-3 pb-3 border-b border-slate-100">
              <div className="w-8 h-8 rounded-xl bg-telu-50 text-telu-600 flex items-center justify-center font-bold">
                2
              </div>
              <div>
                <h3 className="text-sm font-bold text-slate-900">Dokumen Wajib Pengajuan</h3>
                <p className="text-[11px] text-slate-400">Format yang didukung: PDF, DOC, DOCX</p>
              </div>
            </div>

            <div className="grid grid-cols-1 sm:grid-cols-3 gap-4">
              {/* Proposal */}
              <div className="p-4 rounded-2xl border border-dashed border-slate-300 hover:border-telu-500 transition-colors bg-slate-50/50 flex flex-col justify-between">
                <div>
                  <div className="flex items-center gap-2 text-xs font-bold text-slate-800 mb-1">
                    <FileText className="w-4 h-4 text-rose-500" />
                    Proposal Utama <span className="text-telu-600">*</span>
                  </div>
                  <p className="text-[11px] text-slate-400 mb-3">Rencana kegiatan lengkap</p>
                </div>

                <div>
                  <input
                    type="file"
                    id="proposal-file"
                    required
                    accept=".pdf,.doc,.docx"
                    onChange={(e) => setProposal(e.target.files?.[0] || null)}
                    className="hidden"
                  />
                  <label
                    htmlFor="proposal-file"
                    className="w-full py-2 px-3 rounded-lg text-xs font-bold text-center block cursor-pointer bg-white border border-slate-200 hover:bg-slate-100 text-slate-700 transition-colors truncate"
                  >
                    {proposal ? proposal.name : 'Pilih File Proposal'}
                  </label>
                </div>
              </div>

              {/* Timeline */}
              <div className="p-4 rounded-2xl border border-dashed border-slate-300 hover:border-telu-500 transition-colors bg-slate-50/50 flex flex-col justify-between">
                <div>
                  <div className="flex items-center gap-2 text-xs font-bold text-slate-800 mb-1">
                    <Clock className="w-4 h-4 text-blue-500" />
                    Timeline Kegiatan <span className="text-telu-600">*</span>
                  </div>
                  <p className="text-[11px] text-slate-400 mb-3">Rundown & jadwal kerja</p>
                </div>

                <div>
                  <input
                    type="file"
                    id="timeline-file"
                    required
                    accept=".pdf,.doc,.docx"
                    onChange={(e) => setTimeline(e.target.files?.[0] || null)}
                    className="hidden"
                  />
                  <label
                    htmlFor="timeline-file"
                    className="w-full py-2 px-3 rounded-lg text-xs font-bold text-center block cursor-pointer bg-white border border-slate-200 hover:bg-slate-100 text-slate-700 transition-colors truncate"
                  >
                    {timeline ? timeline.name : 'Pilih File Timeline'}
                  </label>
                </div>
              </div>

              {/* Budgeting */}
              <div className="p-4 rounded-2xl border border-dashed border-slate-300 hover:border-telu-500 transition-colors bg-slate-50/50 flex flex-col justify-between">
                <div>
                  <div className="flex items-center gap-2 text-xs font-bold text-slate-800 mb-1">
                    <FileSpreadsheet className="w-4 h-4 text-emerald-500" />
                    Rencana RAB <span className="text-telu-600">*</span>
                  </div>
                  <p className="text-[11px] text-slate-400 mb-3">Rincian anggaran biaya</p>
                </div>

                <div>
                  <input
                    type="file"
                    id="budgeting-file"
                    required
                    accept=".pdf,.doc,.docx"
                    onChange={(e) => setBudgeting(e.target.files?.[0] || null)}
                    className="hidden"
                  />
                  <label
                    htmlFor="budgeting-file"
                    className="w-full py-2 px-3 rounded-lg text-xs font-bold text-center block cursor-pointer bg-white border border-slate-200 hover:bg-slate-100 text-slate-700 transition-colors truncate"
                  >
                    {budgeting ? budgeting.name : 'Pilih File Budgeting'}
                  </label>
                </div>
              </div>
            </div>
          </div>

          {/* 3. DOKUMEN TAMBAHAN / POSTER */}
          <div className="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm space-y-5">
            <div className="flex items-center gap-3 pb-3 border-b border-slate-100">
              <div className="w-8 h-8 rounded-xl bg-telu-50 text-telu-600 flex items-center justify-center font-bold">
                3
              </div>
              <div>
                <h3 className="text-sm font-bold text-slate-900">Media Promosi & Pendukung (Opsional)</h3>
                <p className="text-[11px] text-slate-400">Poster akan ditampilkan pada katalog acara.</p>
              </div>
            </div>

            <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div>
                <label className="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                  Poster Kegiatan (JPG, PNG)
                </label>
                <input
                  type="file"
                  accept="image/png,image/jpeg,image/jpg"
                  onChange={(e) => setPoster(e.target.files?.[0] || null)}
                  className="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200 cursor-pointer"
                />
              </div>

              <div>
                <label className="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                  Lampiran Tambahan (PDF, DOC)
                </label>
                <input
                  type="file"
                  accept=".pdf,.doc,.docx"
                  onChange={(e) => setOtherData(e.target.files?.[0] || null)}
                  className="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200 cursor-pointer"
                />
              </div>
            </div>
          </div>

          {/* Submit Action */}
          <div className="flex items-center justify-end gap-3 pt-4">
            <Link
              href="/home"
              className="px-5 py-3 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-200/80 transition-colors"
            >
              Batal
            </Link>
            <button
              type="submit"
              disabled={loading}
              className="px-8 py-3.5 rounded-xl text-xs font-bold bg-telu-600 hover:bg-telu-700 text-white shadow-md hover:shadow-lg transition-all flex items-center gap-2 disabled:opacity-60"
            >
              {loading ? 'Mengunggah & Memproses...' : 'Kirimkan Proposal Sekarang'}
              <ArrowRight className="w-4 h-4" />
            </button>
          </div>
        </form>
      </div>
    </div>
  );
}
