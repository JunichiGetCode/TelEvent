import React from 'react';
import Link from 'next/link';
import { notFound } from 'next/navigation';
import {
  Calendar,
  Clock,
  Tag,
  User,
  ArrowLeft,
  FileText,
  FileSpreadsheet,
  Download,
  CheckCircle,
  XCircle,
  ExternalLink,
  Shield,
  Layers,
} from 'lucide-react';
import prisma from '@/lib/prisma';
import { serializeData } from '@/lib/serialize';
import { getCurrentUser } from '@/lib/auth';
import StatusBadge from '@/components/StatusBadge';
import AdminStatusButtons from './AdminStatusButtons';

interface EventDetailPageProps {
  params: { id: string };
}

async function getEvent(id: string) {
  try {
    const event = await prisma.event.findUnique({
      where: { id: BigInt(id) },
      include: {
        user: {
          select: {
            id: true,
            name: true,
            email: true,
            phone: true,
            avatar: true,
            role: true,
          },
        },
      },
    });

    if (!event) return null;
    return serializeData(event);
  } catch (e) {
    console.error('Error fetching event detail:', e);
    return null;
  }
}

export default async function EventDetailPage({ params }: EventDetailPageProps) {
  const event = await getEvent(params.id);
  if (!event) {
    notFound();
  }

  const currentUser = await getCurrentUser();
  const isAdmin = currentUser?.role === 'admin';

  const formatDate = (dateStr?: string | null) => {
    if (!dateStr) return 'Belum ditentukan';
    return new Date(dateStr).toLocaleDateString('id-ID', {
      weekday: 'long',
      day: 'numeric',
      month: 'long',
      year: 'numeric',
    });
  };

  return (
    <div className="min-h-screen bg-slate-50 pb-16">
      {/* Back button */}
      <div className="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pt-8">
        <Link
          href="/events"
          className="inline-flex items-center gap-2 text-xs font-bold text-slate-500 hover:text-telu-600 transition-colors mb-6"
        >
          <ArrowLeft className="w-4 h-4" />
          Kembali ke Direktori Acara
        </Link>
      </div>

      {/* Admin Action Bar (Only visible if Admin) */}
      {isAdmin && (
        <div className="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 mb-6">
          <div className="p-4 rounded-2xl bg-slate-900 text-white flex flex-col sm:flex-row items-center justify-between gap-4 border border-slate-800 shadow-xl">
            <div className="flex items-center gap-3">
              <div className="w-9 h-9 rounded-xl bg-telu-600 flex items-center justify-center text-white font-bold">
                <Shield className="w-5 h-5" />
              </div>
              <div>
                <p className="text-xs font-bold text-white">Panel Aksi Verifikasi Admin</p>
                <p className="text-[11px] text-slate-400">
                  Ubah status proposal ini secara langsung tanpa perlu berpindah halaman.
                </p>
              </div>
            </div>

            <AdminStatusButtons eventId={event.id} currentStatus={event.status} />
          </div>
        </div>
      )}

      {/* Main Container */}
      <div className="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
          {/* Header Banner */}
          <div className="relative p-8 sm:p-12 bg-gradient-to-br from-telu-700 via-telu-600 to-slate-950 text-white overflow-hidden">
            <div className="relative z-10">
              <div className="flex flex-wrap items-center gap-3 mb-4">
                <span className="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-white/15 backdrop-blur-md border border-white/20">
                  <Tag className="w-3.5 h-3.5 text-amber-300" />
                  {event.type}
                </span>

                <StatusBadge status={event.status} size="md" />
              </div>

              <h1 className="text-3xl sm:text-4xl lg:text-5xl font-black tracking-tight leading-tight mb-6">
                {event.title}
              </h1>

              <div className="flex flex-wrap items-center gap-6 text-xs sm:text-sm text-white/80 font-medium">
                <div className="flex items-center gap-2">
                  <Calendar className="w-4 h-4 text-amber-300" />
                  <span>Mulai: {formatDate(event.start_date)}</span>
                </div>
                {event.end_date && (
                  <div className="flex items-center gap-2">
                    <Clock className="w-4 h-4 text-amber-300" />
                    <span>Selesai: {formatDate(event.end_date)}</span>
                  </div>
                )}
                <div className="flex items-center gap-2">
                  <User className="w-4 h-4 text-amber-300" />
                  <span>Diajukan oleh: {event.user?.name || 'Panitia'}</span>
                </div>
              </div>
            </div>

            {/* Decor blur */}
            <div className="absolute right-0 top-0 w-80 h-80 bg-white/5 rounded-full blur-3xl pointer-events-none" />
          </div>

          {/* Content Body Grid */}
          <div className="p-8 sm:p-12 grid grid-cols-1 lg:grid-cols-3 gap-10">
            {/* Left 2 Cols: Details & Documents */}
            <div className="lg:col-span-2 space-y-8">
              {/* Poster section if exists */}
              {event.poster && (
                <div>
                  <h3 className="text-sm font-bold uppercase tracking-wider text-slate-400 mb-3">
                    Poster Resmi Kegiatan
                  </h3>
                  <div className="rounded-2xl overflow-hidden border border-slate-100 shadow-md max-h-[480px]">
                    <img
                      src={event.poster}
                      alt={event.title}
                      className="w-full h-full object-cover"
                    />
                  </div>
                </div>
              )}

              {/* Berkas & Dokumen Terlampir */}
              <div>
                <div className="flex items-center gap-2 pb-3 border-b border-slate-100 mb-4">
                  <FileText className="w-5 h-5 text-telu-600" />
                  <h3 className="text-base font-bold text-slate-900">
                    Berkas & Dokumen Kegiatan
                  </h3>
                </div>

                <div className="space-y-3">
                  {/* Proposal */}
                  <a
                    href={event.proposal}
                    target="_blank"
                    rel="noreferrer"
                    className="flex items-center justify-between p-4 rounded-2xl border border-slate-200 hover:border-telu-500 hover:bg-slate-50 transition-all group"
                  >
                    <div className="flex items-center gap-3.5">
                      <div className="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center font-bold">
                        <FileText className="w-5 h-5" />
                      </div>
                      <div>
                        <p className="text-sm font-bold text-slate-800 group-hover:text-telu-600 transition-colors">
                          Dokumen Proposal Utama
                        </p>
                        <p className="text-xs text-slate-400">PDF / Dokumen resmi pengajuan</p>
                      </div>
                    </div>
                    <div className="flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-slate-100 group-hover:bg-telu-600 group-hover:text-white text-slate-700 text-xs font-bold transition-colors">
                      <Download className="w-3.5 h-3.5" />
                      Unduh Berkas
                    </div>
                  </a>

                  {/* Timeline */}
                  <a
                    href={event.timeline}
                    target="_blank"
                    rel="noreferrer"
                    className="flex items-center justify-between p-4 rounded-2xl border border-slate-200 hover:border-telu-500 hover:bg-slate-50 transition-all group"
                  >
                    <div className="flex items-center gap-3.5">
                      <div className="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold">
                        <Clock className="w-5 h-5" />
                      </div>
                      <div>
                        <p className="text-sm font-bold text-slate-800 group-hover:text-telu-600 transition-colors">
                          Timeline & Rundown Kegiatan
                        </p>
                        <p className="text-xs text-slate-400">Jadwal pelaksanaan & tahapan teknis</p>
                      </div>
                    </div>
                    <div className="flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-slate-100 group-hover:bg-telu-600 group-hover:text-white text-slate-700 text-xs font-bold transition-colors">
                      <Download className="w-3.5 h-3.5" />
                      Unduh Berkas
                    </div>
                  </a>

                  {/* Budgeting */}
                  <a
                    href={event.budgeting}
                    target="_blank"
                    rel="noreferrer"
                    className="flex items-center justify-between p-4 rounded-2xl border border-slate-200 hover:border-telu-500 hover:bg-slate-50 transition-all group"
                  >
                    <div className="flex items-center gap-3.5">
                      <div className="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                        <FileSpreadsheet className="w-5 h-5" />
                      </div>
                      <div>
                        <p className="text-sm font-bold text-slate-800 group-hover:text-telu-600 transition-colors">
                          Rencana Anggaran Biaya (Budgeting)
                        </p>
                        <p className="text-xs text-slate-400">Estimasi pemasukan dan pengeluaran</p>
                      </div>
                    </div>
                    <div className="flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-slate-100 group-hover:bg-telu-600 group-hover:text-white text-slate-700 text-xs font-bold transition-colors">
                      <Download className="w-3.5 h-3.5" />
                      Unduh Berkas
                    </div>
                  </a>

                  {/* Other Data if available */}
                  {event.other_data && (
                    <a
                      href={event.other_data}
                      target="_blank"
                      rel="noreferrer"
                      className="flex items-center justify-between p-4 rounded-2xl border border-slate-200 hover:border-telu-500 hover:bg-slate-50 transition-all group"
                    >
                      <div className="flex items-center gap-3.5">
                        <div className="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center font-bold">
                          <Layers className="w-5 h-5" />
                        </div>
                        <div>
                          <p className="text-sm font-bold text-slate-800 group-hover:text-telu-600 transition-colors">
                            Dokumen Pendukung Tambahan
                          </p>
                          <p className="text-xs text-slate-400">Lampiran pelengkap</p>
                        </div>
                      </div>
                      <div className="flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-slate-100 group-hover:bg-telu-600 group-hover:text-white text-slate-700 text-xs font-bold transition-colors">
                        <Download className="w-3.5 h-3.5" />
                        Unduh Berkas
                      </div>
                    </a>
                  )}
                </div>
              </div>
            </div>

            {/* Right 1 Col: Organizer Card & Info */}
            <div className="space-y-6">
              <div className="p-6 rounded-2xl bg-slate-50 border border-slate-200/80">
                <h4 className="text-xs font-bold uppercase tracking-wider text-slate-400 mb-4">
                  Informasi Penyelenggara
                </h4>

                <div className="flex items-center gap-3 mb-4">
                  {event.user?.avatar ? (
                    <img
                      src={event.user.avatar.startsWith('http') || event.user.avatar.startsWith('/') ? event.user.avatar : `/uploads/profile/${event.user.avatar}`}
                      alt={event.user.name}
                      className="w-12 h-12 rounded-full object-cover border border-slate-200"
                    />
                  ) : (
                    <div className="w-12 h-12 rounded-full bg-telu-100 text-telu-700 font-bold flex items-center justify-center text-lg">
                      {event.user?.name ? event.user.name.charAt(0).toUpperCase() : 'U'}
                    </div>
                  )}

                  <div>
                    <h5 className="font-bold text-slate-900 text-sm">{event.user?.name || 'Panitia'}</h5>
                    <p className="text-xs text-slate-500">{event.user?.email}</p>
                    {event.user?.phone && (
                      <p className="text-xs text-slate-500 mt-0.5">WA: {event.user.phone}</p>
                    )}
                  </div>
                </div>

                <div className="space-y-3 pt-3 border-t border-slate-200/60 text-xs">
                  <div className="flex justify-between">
                    <span className="text-slate-500">Peran Akun:</span>
                    <span className="font-bold text-slate-800 uppercase">{event.user?.role || 'Panitia'}</span>
                  </div>
                  <div className="flex justify-between">
                    <span className="text-slate-500">Diajukan pada:</span>
                    <span className="font-bold text-slate-800">
                      {event.created_at ? new Date(event.created_at).toLocaleDateString('id-ID') : '-'}
                    </span>
                  </div>
                  <div className="flex justify-between">
                    <span className="text-slate-500">Status Saat Ini:</span>
                    <span className="font-bold text-slate-800 capitalize">{event.status}</span>
                  </div>
                </div>
              </div>

              {/* Guidance Box */}
              <div className="p-5 rounded-2xl bg-amber-50/70 border border-amber-200/60 text-amber-900 text-xs leading-relaxed">
                <p className="font-bold mb-1 flex items-center gap-1.5">
                  <CheckCircle className="w-4 h-4 text-amber-600" />
                  Jaminan Keabsahan Proposal
                </p>
                Semua berkas yang terdaftar telah dienkripsi dan disimpan secara resmi di peladen TelEVent Telkom University.
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}
