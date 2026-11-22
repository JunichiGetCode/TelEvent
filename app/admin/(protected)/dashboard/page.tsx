import React from 'react';
import Link from 'next/link';
import {
  Calendar,
  Clock,
  CheckCircle2,
  XCircle,
  Users,
  ArrowRight,
  ExternalLink,
  Shield,
  FileText,
} from 'lucide-react';
import prisma from '@/lib/prisma';
import { serializeData } from '@/lib/serialize';
import StatusBadge from '@/components/StatusBadge';
import AdminStatusButtons from '../events/AdminRowActions';

export const dynamic = 'force-dynamic';

async function getAdminDashboardData() {
  try {
    const pendingEvents = await prisma.event.findMany({
      where: { status: 'pending' },
      orderBy: { created_at: 'desc' },
      include: {
        user: { select: { name: true, email: true, phone: true } },
      },
    });

    const totalEvents = await prisma.event.count();
    const approvedCount = await prisma.event.count({ where: { status: 'approved' } });
    const pendingCount = pendingEvents.length;
    const rejectedCount = await prisma.event.count({ where: { status: 'rejected' } });
    const userCount = await prisma.user.count();

    const recentEvents = await prisma.event.findMany({
      orderBy: { created_at: 'desc' },
      take: 6,
      include: {
        user: { select: { name: true, email: true } },
      },
    });

    return {
      pendingEvents: serializeData(pendingEvents),
      recentEvents: serializeData(recentEvents),
      stats: {
        totalEvents,
        approvedCount,
        pendingCount,
        rejectedCount,
        userCount,
      },
    };
  } catch (err) {
    console.error(err);
    return {
      pendingEvents: [],
      recentEvents: [],
      stats: { totalEvents: 0, approvedCount: 0, pendingCount: 0, rejectedCount: 0, userCount: 0 },
    };
  }
}

export default async function AdminDashboardPage() {
  const { pendingEvents, recentEvents, stats } = await getAdminDashboardData();

  return (
    <div className="space-y-8 max-w-7xl mx-auto">
      {/* Top Header */}
      <div className="flex flex-col sm:flex-row sm:items-center justify-between pb-6 border-b border-slate-200/80 gap-4">
        <div>
          <div className="inline-flex items-center gap-1.5 text-xs font-bold uppercase tracking-wider text-telu-600 mb-1">
            <Shield className="w-3.5 h-3.5 stroke-[1.75]" />
            Pusat Kendali Administrasi
          </div>
          <h1 className="text-3xl font-black text-slate-900 tracking-tight">
            Dashboard Utama Admin
          </h1>
          <p className="text-xs text-slate-500 mt-1">
            Pantau dan lakukan verifikasi berkas permohonan acara ormawa mahasiswa.
          </p>
        </div>

        <Link
          href="/admin/events"
          className="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-telu-600 hover:bg-telu-700 text-white text-xs font-bold transition-all shadow-md hover:shadow-lg self-start sm:self-auto"
        >
          Lihat Semua Acara
          <ArrowRight className="w-4 h-4 stroke-[1.75]" />
        </Link>
      </div>

      {/* KPI Stats Cards */}
      <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        {/* Pending Review Card */}
        <div className="p-6 rounded-3xl bg-white border border-amber-200/80 shadow-sm relative overflow-hidden">
          <div className="flex items-center justify-between">
            <div>
              <p className="text-xs font-bold uppercase tracking-wider text-amber-700">
                Menunggu Review
              </p>
              <p className="text-3xl font-black text-slate-900 mt-1">{stats.pendingCount}</p>
            </div>
            <div className="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 border border-amber-200/60 flex items-center justify-center font-bold">
              <Clock className="w-6 h-6 stroke-[1.75]" />
            </div>
          </div>
          <p className="text-[11px] text-slate-500 mt-3 font-medium">Perlu tindakan verifikasi admin</p>
        </div>

        {/* Approved Card */}
        <div className="p-6 rounded-3xl bg-white border border-emerald-200/80 shadow-sm relative overflow-hidden">
          <div className="flex items-center justify-between">
            <div>
              <p className="text-xs font-bold uppercase tracking-wider text-emerald-700">
                Disetujui
              </p>
              <p className="text-3xl font-black text-slate-900 mt-1">{stats.approvedCount}</p>
            </div>
            <div className="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 border border-emerald-200/60 flex items-center justify-center font-bold">
              <CheckCircle2 className="w-6 h-6 stroke-[1.75]" />
            </div>
          </div>
          <p className="text-[11px] text-slate-500 mt-3 font-medium">Aktif di direktori publik</p>
        </div>

        {/* Rejected Card */}
        <div className="p-6 rounded-3xl bg-white border border-rose-200/80 shadow-sm relative overflow-hidden">
          <div className="flex items-center justify-between">
            <div>
              <p className="text-xs font-bold uppercase tracking-wider text-rose-700">
                Ditolak
              </p>
              <p className="text-3xl font-black text-slate-900 mt-1">{stats.rejectedCount}</p>
            </div>
            <div className="w-12 h-12 rounded-2xl bg-rose-50 text-rose-600 border border-rose-200/60 flex items-center justify-center font-bold">
              <XCircle className="w-6 h-6 stroke-[1.75]" />
            </div>
          </div>
          <p className="text-[11px] text-slate-500 mt-3 font-medium">Tidak memenuhi persyaratan</p>
        </div>

        {/* Total Events */}
        <div className="p-6 rounded-3xl bg-white border border-slate-200/80 shadow-sm relative overflow-hidden">
          <div className="flex items-center justify-between">
            <div>
              <p className="text-xs font-bold uppercase tracking-wider text-slate-600">
                Total Proposal Masuk
              </p>
              <p className="text-3xl font-black text-slate-900 mt-1">{stats.totalEvents}</p>
            </div>
            <div className="w-12 h-12 rounded-2xl bg-slate-50 text-slate-700 border border-slate-200/60 flex items-center justify-center font-bold">
              <Calendar className="w-6 h-6 stroke-[1.75]" />
            </div>
          </div>
          <p className="text-[11px] text-slate-500 mt-3 font-medium">Dari {stats.userCount} ormawa / panitia</p>
        </div>
      </div>

      {/* ACTION QUEUE: Menunggu Review */}
      <div className="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6 sm:p-8">
        <div className="flex items-center justify-between pb-4 border-b border-slate-100 mb-6">
          <div className="flex items-center gap-2.5">
            <div className="w-3 h-3 rounded-full bg-amber-500 animate-pulse" />
            <div>
              <h2 className="text-lg font-bold text-slate-900">
                Antrean Proposal Menunggu Verifikasi ({pendingEvents.length})
              </h2>
              <p className="text-xs text-slate-500">
                Lakukan persetujuan atau penolakan dengan sekali klik.
              </p>
            </div>
          </div>

          <Link
            href="/admin/events?status=pending"
            className="text-xs font-bold text-telu-600 hover:text-telu-700 flex items-center gap-1"
          >
            Lihat Semua Antrean
            <ArrowRight className="w-3.5 h-3.5 stroke-[1.75]" />
          </Link>
        </div>

        {pendingEvents.length > 0 ? (
          <div className="divide-y divide-slate-100">
            {pendingEvents.map((ev: any) => (
              <div
                key={ev.id}
                className="py-4 flex flex-col lg:flex-row lg:items-center justify-between gap-4 hover:bg-slate-50 px-3 rounded-2xl transition-colors"
              >
                <div className="flex items-start gap-4">
                  <div className="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 border border-amber-200/60 flex items-center justify-center flex-shrink-0 font-bold">
                    <FileText className="w-5 h-5 stroke-[1.75]" />
                  </div>
                  <div>
                    <Link
                      href={`/events/${ev.id}`}
                      className="text-sm font-bold text-slate-900 hover:text-telu-600 transition-colors"
                    >
                      {ev.title}
                    </Link>
                    <div className="flex flex-wrap items-center gap-3 text-xs text-slate-500 mt-1 font-medium">
                      <span className="text-slate-700 font-semibold">{ev.type}</span>
                      <span>•</span>
                      <span>Oleh: {ev.user?.name || 'Panitia'} ({ev.user?.email})</span>
                      <span>•</span>
                      <span>{ev.created_at ? new Date(ev.created_at).toLocaleDateString('id-ID') : '-'}</span>
                    </div>
                  </div>
                </div>

                <div className="flex items-center gap-2 self-end lg:self-center">
                  <Link
                    href={`/events/${ev.id}`}
                    target="_blank"
                    className="px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-xs font-bold text-slate-700 transition-colors flex items-center gap-1.5 border border-slate-200/60"
                  >
                    Cek Berkas
                    <ExternalLink className="w-3 h-3 stroke-[1.75]" />
                  </Link>
                  <AdminStatusButtons eventId={ev.id} />
                </div>
              </div>
            ))}
          </div>
        ) : (
          <div className="text-center py-12">
            <CheckCircle2 className="w-12 h-12 text-emerald-500 mx-auto mb-3 stroke-[1.75]" />
            <h3 className="text-base font-bold text-slate-900">Semua Proposal Telah Ditinjau!</h3>
            <p className="text-xs text-slate-500 mt-1">
              Tidak ada permohonan baru yang tertunda saat ini.
            </p>
          </div>
        )}
      </div>

      {/* Recent Proposals Table */}
      <div className="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6 sm:p-8">
        <div className="pb-4 border-b border-slate-100 mb-6">
          <h2 className="text-lg font-bold text-slate-900">Aktivitas Proposal Terbaru</h2>
          <p className="text-xs text-slate-500">Seluruh proposal yang masuk ke dalam sistem.</p>
        </div>

        <div className="overflow-x-auto">
          <table className="w-full text-left text-xs text-slate-700">
            <thead>
              <tr className="border-b border-slate-200 text-slate-400 uppercase text-[10px] tracking-wider font-bold bg-slate-50/50">
                <th className="py-3 px-4">Nama Acara</th>
                <th className="py-3 px-4">Penyelenggara</th>
                <th className="py-3 px-4">Kategori</th>
                <th className="py-3 px-4">Status</th>
                <th className="py-3 px-4 text-right">Aksi</th>
              </tr>
            </thead>
            <tbody className="divide-y divide-slate-100 font-medium">
              {recentEvents.map((ev: any) => (
                <tr key={ev.id} className="hover:bg-slate-50 transition-colors">
                  <td className="py-4 px-4 font-bold text-slate-900">
                    <Link href={`/events/${ev.id}`} className="hover:text-telu-600 transition-colors">
                      {ev.title}
                    </Link>
                  </td>
                  <td className="py-4 px-4 text-slate-600">{ev.user?.name || '-'}</td>
                  <td className="py-4 px-4 text-slate-600">{ev.type}</td>
                  <td className="py-4 px-4">
                    <StatusBadge status={ev.status} size="sm" />
                  </td>
                  <td className="py-4 px-4 text-right">
                    <Link
                      href={`/admin/events/${ev.id}/edit`}
                      className="px-3 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-[11px] font-bold text-slate-700 transition-colors border border-slate-200/60"
                    >
                      Kelola
                    </Link>
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      </div>
    </div>
  );
}
