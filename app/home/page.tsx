import React from 'react';
import Link from 'next/link';
import { redirect } from 'next/navigation';
import {
  Calendar,
  Clock,
  CheckCircle2,
  XCircle,
  PlusCircle,
  ArrowRight,
  FileText,
  User,
  Sparkles,
  Layers,
} from 'lucide-react';
import { getCurrentUser } from '@/lib/auth';
import prisma from '@/lib/prisma';
import { serializeData } from '@/lib/serialize';
import StatusBadge from '@/components/StatusBadge';
import EventCard from '@/components/EventCard';

async function getUserDashboardData(userId: number) {
  try {
    const myEvents = await prisma.event.findMany({
      where: { user_id: BigInt(userId) },
      orderBy: { created_at: 'desc' },
      take: 5,
    });

    const totalEvents = await prisma.event.count({ where: { user_id: BigInt(userId) } });
    const pendingEvents = await prisma.event.count({
      where: { user_id: BigInt(userId), status: 'pending' },
    });
    const approvedEvents = await prisma.event.count({
      where: { user_id: BigInt(userId), status: 'approved' },
    });
    const rejectedEvents = await prisma.event.count({
      where: { user_id: BigInt(userId), status: 'rejected' },
    });

    // Also get upcoming campus approved events
    const upcomingEvents = await prisma.event.findMany({
      where: { status: 'approved' },
      orderBy: { created_at: 'desc' },
      take: 3,
      include: {
        user: { select: { name: true, avatar: true } },
      },
    });

    return {
      myEvents: serializeData(myEvents),
      stats: { totalEvents, pendingEvents, approvedEvents, rejectedEvents },
      upcomingEvents: serializeData(upcomingEvents),
    };
  } catch (err) {
    console.error(err);
    return {
      myEvents: [],
      stats: { totalEvents: 0, pendingEvents: 0, approvedEvents: 0, rejectedEvents: 0 },
      upcomingEvents: [],
    };
  }
}

export default async function UserHomePage() {
  const user = await getCurrentUser();
  if (!user) {
    redirect('/login');
  }

  const { myEvents, stats, upcomingEvents } = await getUserDashboardData(user.id);

  return (
    <div className="min-h-screen bg-slate-50 py-10">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        {/* Welcome Header */}
        <div className="flex flex-col sm:flex-row sm:items-center justify-between pb-6 border-b border-slate-200/80 gap-4">
          <div>
            <div className="flex items-center gap-2 mb-1">
              <span className="text-xs font-bold uppercase tracking-wider text-telu-600">
                Dashboard Kepanitiaan
              </span>
              <span className="px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-slate-200 text-slate-700">
                {user.role}
              </span>
            </div>
            <h1 className="text-3xl font-black text-slate-900 tracking-tight">
              Selamat Datang, {user.name}! 👋
            </h1>
            <p className="text-xs text-slate-500 mt-1">
              Pantau status verifikasi proposal dan kelola kegiatan Anda dengan praktis.
            </p>
          </div>

          <div className="flex items-center gap-3">
            <Link
              href="/events/create"
              className="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-telu-600 hover:bg-telu-700 text-white text-xs font-bold shadow-md hover:shadow-lg transition-all"
            >
              <PlusCircle className="w-4 h-4" />
              Ajukan Acara Baru
            </Link>
          </div>
        </div>

        {/* Stats Grid */}
        <div className="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
          <div className="p-5 rounded-2xl bg-white border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
              <p className="text-xs font-semibold text-slate-500 uppercase tracking-wider">
                Total Diajukan
              </p>
              <p className="text-2xl font-black text-slate-900 mt-1">{stats.totalEvents}</p>
            </div>
            <div className="w-11 h-11 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center font-bold">
              <Layers className="w-5 h-5" />
            </div>
          </div>

          <div className="p-5 rounded-2xl bg-white border border-amber-200/80 shadow-sm flex items-center justify-between">
            <div>
              <p className="text-xs font-semibold text-amber-700 uppercase tracking-wider">
                Menunggu Review
              </p>
              <p className="text-2xl font-black text-amber-800 mt-1">{stats.pendingEvents}</p>
            </div>
            <div className="w-11 h-11 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold">
              <Clock className="w-5 h-5" />
            </div>
          </div>

          <div className="p-5 rounded-2xl bg-white border border-emerald-200/80 shadow-sm flex items-center justify-between">
            <div>
              <p className="text-xs font-semibold text-emerald-700 uppercase tracking-wider">
                Disetujui
              </p>
              <p className="text-2xl font-black text-emerald-800 mt-1">{stats.approvedEvents}</p>
            </div>
            <div className="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
              <CheckCircle2 className="w-5 h-5" />
            </div>
          </div>

          <div className="p-5 rounded-2xl bg-white border border-rose-200/80 shadow-sm flex items-center justify-between">
            <div>
              <p className="text-xs font-semibold text-rose-700 uppercase tracking-wider">
                Ditolak
              </p>
              <p className="text-2xl font-black text-rose-800 mt-1">{stats.rejectedEvents}</p>
            </div>
            <div className="w-11 h-11 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center font-bold">
              <XCircle className="w-5 h-5" />
            </div>
          </div>
        </div>

        {/* My Proposals Section */}
        <div className="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6 sm:p-8">
          <div className="flex items-center justify-between pb-4 border-b border-slate-100 mb-6">
            <div>
              <h2 className="text-lg font-bold text-slate-900">Proposal Terbaru Anda</h2>
              <p className="text-xs text-slate-500">Daftar pengajuan kegiatan yang baru saja Anda kirimkan.</p>
            </div>
            <Link
              href="/profile"
              className="text-xs font-bold text-telu-600 hover:text-telu-700 flex items-center gap-1"
            >
              Lihat Semua di Profil
              <ArrowRight className="w-3.5 h-3.5" />
            </Link>
          </div>

          {myEvents.length > 0 ? (
            <div className="divide-y divide-slate-100">
              {myEvents.map((ev: any) => (
                <div
                  key={ev.id}
                  className="py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:bg-slate-50/60 rounded-xl px-2 transition-colors"
                >
                  <div className="flex items-start sm:items-center gap-3">
                    <div className="w-10 h-10 rounded-xl bg-telu-50 text-telu-600 flex items-center justify-center flex-shrink-0 font-bold">
                      <FileText className="w-5 h-5" />
                    </div>
                    <div>
                      <Link
                        href={`/events/${ev.id}`}
                        className="text-sm font-bold text-slate-900 hover:text-telu-600 transition-colors line-clamp-1"
                      >
                        {ev.title}
                      </Link>
                      <div className="flex items-center gap-3 text-xs text-slate-400 mt-0.5">
                        <span className="font-semibold text-slate-600">{ev.type}</span>
                        <span>•</span>
                        <span>{ev.created_at ? new Date(ev.created_at).toLocaleDateString('id-ID') : '-'}</span>
                      </div>
                    </div>
                  </div>

                  <div className="flex items-center gap-3 self-end sm:self-center">
                    <StatusBadge status={ev.status} size="sm" />
                    <Link
                      href={`/events/${ev.id}`}
                      className="px-3 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition-colors"
                    >
                      Buka Detail
                    </Link>
                  </div>
                </div>
              ))}
            </div>
          ) : (
            <div className="text-center py-10">
              <FileText className="w-10 h-10 text-slate-300 mx-auto mb-2" />
              <p className="text-xs font-bold text-slate-700">Anda belum mengajukan proposal acara</p>
              <p className="text-xs text-slate-400 mt-0.5">Mulai dengan mengajukan proposal kegiatan ormawa Anda.</p>
              <Link
                href="/events/create"
                className="mt-4 inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-telu-600 text-white text-xs font-bold hover:bg-telu-700 transition-all"
              >
                <PlusCircle className="w-3.5 h-3.5" />
                Ajukan Sekarang
              </Link>
            </div>
          )}
        </div>

        {/* Upcoming Events Highlights */}
        {upcomingEvents.length > 0 && (
          <div>
            <div className="flex items-center justify-between mb-4">
              <h2 className="text-lg font-bold text-slate-900">Acara Kampus yang Sedang Berjalan</h2>
              <Link
                href="/events"
                className="text-xs font-bold text-telu-600 hover:text-telu-700 flex items-center gap-1"
              >
                Lihat Direktori
                <ArrowRight className="w-3.5 h-3.5" />
              </Link>
            </div>
            <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
              {upcomingEvents.map((ev: any) => (
                <EventCard key={ev.id} event={ev} showStatus={false} />
              ))}
            </div>
          </div>
        )}
      </div>
    </div>
  );
}
