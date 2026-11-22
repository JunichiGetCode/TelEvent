import React from 'react';
import Link from 'next/link';
import {
  Calendar,
  Search,
  ArrowRight,
  ShieldCheck,
  FileCheck,
  Users,
  BookOpen,
  MonitorPlay,
  Trophy,
  Music,
  Building2,
  Tag,
  CheckCircle2,
} from 'lucide-react';
import prisma from '@/lib/prisma';
import { serializeData } from '@/lib/serialize';
import EventCard from '@/components/EventCard';

export const dynamic = 'force-dynamic';

async function getFeaturedEvents() {
  try {
    const events = await prisma.event.findMany({
      where: { status: 'approved' },
      orderBy: { created_at: 'desc' },
      take: 6,
      include: {
        user: {
          select: {
            name: true,
            avatar: true,
          },
        },
      },
    });
    return serializeData(events);
  } catch (error) {
    console.error('Error fetching landing events:', error);
    return [];
  }
}

async function getEventStats() {
  try {
    const totalEvents = await prisma.event.count();
    const approvedEvents = await prisma.event.count({ where: { status: 'approved' } });
    const pendingEvents = await prisma.event.count({ where: { status: 'pending' } });
    const totalUsers = await prisma.user.count();
    return { totalEvents, approvedEvents, pendingEvents, totalUsers };
  } catch (e) {
    return { totalEvents: 12, approvedEvents: 8, pendingEvents: 4, totalUsers: 35 };
  }
}

export default async function HomePage() {
  const events = await getFeaturedEvents();
  const stats = await getEventStats();

  const categories = [
    { name: 'Seminar', icon: BookOpen, count: 'Workshop & Edukasi' },
    { name: 'Webinar', icon: MonitorPlay, count: 'Sesi Online' },
    { name: 'Lomba', icon: Trophy, count: 'Kompetisi Mahasiswa' },
    { name: 'Festival', icon: Music, count: 'Seni & Kebudayaan' },
    { name: 'Exhibition', icon: Building2, count: 'Pameran Karya' },
  ];

  return (
    <div className="flex flex-col min-h-screen">
      {/* HERO SECTION */}
      <section className="relative overflow-hidden bg-gradient-to-br from-telu-700 via-telu-600 to-slate-950 text-white py-20 lg:py-28">
        {/* Glow & Backdrop decor */}
        <div className="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 rounded-full bg-telu-400/20 blur-3xl pointer-events-none" />
        <div className="absolute bottom-0 left-0 -ml-20 -mb-20 w-96 h-96 rounded-full bg-amber-400/10 blur-3xl pointer-events-none" />

        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
          <div className="max-w-3xl">
            {/* Tagline Badge */}
            <div className="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-xs font-semibold tracking-wide uppercase text-amber-300 mb-6 shadow-sm">
              <Calendar className="w-3.5 h-3.5" />
              Sistem Manajemen Acara Kampus Modern
            </div>

            {/* Main Headline */}
            <h1 className="text-4xl sm:text-5xl lg:text-6xl font-black tracking-tight leading-[1.15] mb-6">
              Wujudkan Acara Kampus Impianmu Bersama{' '}
              <span className="text-transparent bg-clip-text bg-gradient-to-r from-amber-300 to-amber-100">
                TelEVent
              </span>
            </h1>

            <p className="text-base sm:text-lg text-white/85 leading-relaxed mb-8 max-w-2xl font-normal">
              Kelola dan pantau seluruh alur persetujuan proposal, penjadwalan, rencana anggaran biaya (RAB), hingga promosi publik kegiatan Telkom University dalam satu platform terpadu.
            </p>

            {/* CTAs */}
            <div className="flex flex-wrap items-center gap-4">
              <Link
                href="/events/create"
                className="px-6 py-3.5 rounded-xl text-sm font-bold bg-white text-telu-700 hover:bg-amber-50 hover:text-telu-800 shadow-xl hover:shadow-2xl hover:-translate-y-0.5 transition-all flex items-center gap-2"
              >
                Ajukan Proposal Acara
                <ArrowRight className="w-4 h-4 text-telu-600" />
              </Link>
              <Link
                href="/events"
                className="px-6 py-3.5 rounded-xl text-sm font-bold bg-white/10 hover:bg-white/20 border border-white/20 text-white backdrop-blur-md transition-all flex items-center gap-2"
              >
                <Search className="w-4 h-4 text-white/80" />
                Jelajahi Acara
              </Link>
            </div>
          </div>

          {/* Quick Search Card overlay */}
          <div className="mt-12 p-3 sm:p-4 rounded-2xl bg-white/10 backdrop-blur-xl border border-white/15 shadow-2xl max-w-4xl">
            <form action="/events" method="GET" className="flex flex-col sm:flex-row gap-3">
              <div className="relative flex-1">
                <Search className="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400" />
                <input
                  type="text"
                  name="q"
                  placeholder="Cari nama webinar, workshop, festival, atau kompetisi..."
                  className="w-full pl-12 pr-4 py-3.5 rounded-xl bg-white text-slate-900 placeholder-slate-400 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-telu-500 shadow-inner"
                />
              </div>
              <select
                name="type"
                className="px-4 py-3.5 rounded-xl bg-white text-slate-800 text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-telu-500 cursor-pointer shadow-inner"
              >
                <option value="">Semua Kategori</option>
                <option value="Seminar">Seminar</option>
                <option value="Webinar">Webinar</option>
                <option value="Lomba">Lomba</option>
                <option value="Festival">Festival</option>
                <option value="Exhibition">Exhibition</option>
              </select>
              <button
                type="submit"
                className="px-6 py-3.5 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-slate-950 font-bold text-sm shadow-md transition-all flex items-center justify-center gap-2"
              >
                Cari Acara
              </button>
            </form>
          </div>
        </div>
      </section>

      {/* STATS SECTION */}
      <section className="bg-white border-b border-slate-100 py-8">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="grid grid-cols-2 md:grid-cols-4 gap-6">
            <div className="flex items-center gap-4 p-4 rounded-xl bg-slate-50 border border-slate-100/80">
              <div className="w-12 h-12 rounded-xl bg-telu-100 text-telu-600 flex items-center justify-center font-bold">
                <Calendar className="w-6 h-6" />
              </div>
              <div>
                <p className="text-2xl font-black text-slate-900">{stats.approvedEvents}</p>
                <p className="text-xs text-slate-500 font-medium">Acara Aktif & Terlaksana</p>
              </div>
            </div>

            <div className="flex items-center gap-4 p-4 rounded-xl bg-slate-50 border border-slate-100/80">
              <div className="w-12 h-12 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center font-bold">
                <FileCheck className="w-6 h-6" />
              </div>
              <div>
                <p className="text-2xl font-black text-slate-900">{stats.totalEvents}</p>
                <p className="text-xs text-slate-500 font-medium">Proposal Diajukan</p>
              </div>
            </div>

            <div className="flex items-center gap-4 p-4 rounded-xl bg-slate-50 border border-slate-100/80">
              <div className="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold">
                <ShieldCheck className="w-6 h-6" />
              </div>
              <div>
                <p className="text-2xl font-black text-slate-900">100%</p>
                <p className="text-xs text-slate-500 font-medium">Verifikasi Resmi Kampus</p>
              </div>
            </div>

            <div className="flex items-center gap-4 p-4 rounded-xl bg-slate-50 border border-slate-100/80">
              <div className="w-12 h-12 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center font-bold">
                <Users className="w-6 h-6" />
              </div>
              <div>
                <p className="text-2xl font-black text-slate-900">{stats.totalUsers || '50+'}</p>
                <p className="text-xs text-slate-500 font-medium">Panitia & Ormawa</p>
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* CATEGORIES PILLS SECTION */}
      <section className="py-12 bg-slate-50">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="flex items-center justify-between mb-8">
            <div>
              <span className="text-xs font-bold uppercase tracking-wider text-telu-600">Kategori Populer</span>
              <h2 className="text-2xl font-black text-slate-900 mt-1">Jelajahi Berbagai Jenis Kegiatan</h2>
            </div>
            <Link
              href="/events"
              className="text-xs font-bold text-telu-600 hover:text-telu-700 flex items-center gap-1"
            >
              Lihat Semua
              <ArrowRight className="w-3.5 h-3.5" />
            </Link>
          </div>

          <div className="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
            {categories.map((cat) => {
              const Icon = cat.icon;
              return (
                <Link
                  key={cat.name}
                  href={`/events?type=${cat.name}`}
                  className="p-5 rounded-2xl bg-white border border-slate-200/70 hover:border-telu-500 hover:shadow-lg transition-all group flex flex-col items-center text-center"
                >
                  <div className="w-12 h-12 rounded-xl bg-slate-50 text-slate-700 group-hover:bg-telu-50 group-hover:text-telu-600 flex items-center justify-center mb-3 transition-colors">
                    <Icon className="w-6 h-6 stroke-[1.75]" />
                  </div>
                  <span className="font-bold text-slate-900 text-sm group-hover:text-telu-600 transition-colors">
                    {cat.name}
                  </span>
                  <span className="text-[11px] text-slate-400 mt-1 font-medium">{cat.count}</span>
                </Link>
              );
            })}
          </div>
        </div>
      </section>

      {/* FEATURED / UPCOMING EVENTS */}
      <section className="py-16 bg-white">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="flex flex-col sm:flex-row sm:items-end justify-between mb-10 gap-4">
            <div>
              <span className="text-xs font-bold uppercase tracking-wider text-telu-600">Acara Telah Diverifikasi</span>
              <h2 className="text-3xl font-black text-slate-900 mt-1">Kegiatan Kampus Mendatang</h2>
              <p className="text-sm text-slate-500 mt-2">
                Temukan seminar, pameran, dan kompetisi yang siap kamu ikuti.
              </p>
            </div>
            <Link
              href="/events"
              className="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold transition-all shadow-sm"
            >
              Buka Katalog Lengkap
              <ArrowRight className="w-3.5 h-3.5" />
            </Link>
          </div>

          {events.length > 0 ? (
            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
              {events.map((event: any) => (
                <EventCard key={event.id} event={event} showStatus={false} />
              ))}
            </div>
          ) : (
            <div className="text-center py-16 px-4 bg-slate-50 rounded-3xl border border-dashed border-slate-200">
              <Calendar className="w-12 h-12 text-slate-300 mx-auto mb-3" />
              <h3 className="font-bold text-slate-700 text-base">Belum ada acara yang dipublikasikan</h3>
              <p className="text-xs text-slate-500 mt-1 max-w-sm mx-auto">
                Proposal acara yang baru diajukan sedang dalam tahap verifikasi oleh admin.
              </p>
              <Link
                href="/events/create"
                className="mt-4 inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-telu-600 text-white text-xs font-bold hover:bg-telu-700 transition-colors"
              >
                Ajukan Acara Pertama Anda
              </Link>
            </div>
          )}
        </div>
      </section>

      {/* WORKFLOW GUIDE SECTION */}
      <section className="py-20 bg-slate-900 text-white relative overflow-hidden">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
          <div className="text-center max-w-2xl mx-auto mb-16">
            <span className="text-xs font-bold uppercase tracking-wider text-amber-400">Mudah & Transparan</span>
            <h2 className="text-3xl sm:text-4xl font-black mt-2">Alur Pengajuan Proposal TelEVent</h2>
            <p className="text-slate-400 text-sm mt-3">
              Kini pengajuan izin dan anggaran kegiatan mahasiswa tidak lagi memakan waktu berbelit-belit.
            </p>
          </div>

          <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div className="p-8 rounded-3xl bg-slate-800/60 border border-slate-700/60 relative flex flex-col">
              <div className="w-12 h-12 rounded-2xl bg-telu-600 text-white font-black text-xl flex items-center justify-center mb-6 shadow-glow">
                1
              </div>
              <h3 className="text-lg font-bold text-white mb-2">Unggah Berkas Digital</h3>
              <p className="text-slate-400 text-xs leading-relaxed">
                Isi form rincian acara, lampirkan file proposal (PDF/DOC), timeline kegiatan, serta estimasi rincian biaya (budgeting).
              </p>
            </div>

            <div className="p-8 rounded-3xl bg-slate-800/60 border border-slate-700/60 relative flex flex-col">
              <div className="w-12 h-12 rounded-2xl bg-amber-500 text-slate-950 font-black text-xl flex items-center justify-center mb-6">
                2
              </div>
              <h3 className="text-lg font-bold text-white mb-2">Review & Validasi Admin</h3>
              <p className="text-slate-400 text-xs leading-relaxed">
                Pihak kemahasiswaan atau verifikator memeriksa kelayakan berkas, kesesuaian waktu, dan alokasi anggaran secara langsung di dashboard admin.
              </p>
            </div>

            <div className="p-8 rounded-3xl bg-slate-800/60 border border-slate-700/60 relative flex flex-col">
              <div className="w-12 h-12 rounded-2xl bg-emerald-500 text-white font-black text-xl flex items-center justify-center mb-6">
                3
              </div>
              <h3 className="text-lg font-bold text-white mb-2">Status Approved & Publikasi</h3>
              <p className="text-slate-400 text-xs leading-relaxed">
                Setelah disetujui, acara otomatis tayang di direktori publik TelEVent untuk disebarluaskan kepada seluruh sivitas akademika.
              </p>
            </div>
          </div>
        </div>
      </section>

      {/* FINAL CALL TO ACTION */}
      <section className="py-20 bg-gradient-to-r from-telu-800 via-telu-700 to-telu-900 text-white text-center">
        <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
          <h2 className="text-3xl sm:text-4xl font-black mb-4">
            Punya Rencana Acara atau Lomba Menarik?
          </h2>
          <p className="text-white/80 text-sm sm:text-base mb-8 max-w-xl mx-auto">
            Segera submit berkas proposal kepanitiaanmu sekarang dan dapatkan persetujuan resmi dengan cepat.
          </p>
          <div className="flex flex-wrap items-center justify-center gap-4">
            <Link
              href="/events/create"
              className="px-8 py-4 rounded-xl text-sm font-bold bg-white text-telu-700 hover:bg-amber-50 hover:text-telu-800 shadow-xl transition-all"
            >
              Mulai Ajukan Proposal
            </Link>
            <Link
              href="/about"
              className="px-8 py-4 rounded-xl text-sm font-bold bg-white/10 hover:bg-white/20 border border-white/20 text-white transition-all"
            >
              Pelajari Panduan
            </Link>
          </div>
        </div>
      </section>
    </div>
  );
}
