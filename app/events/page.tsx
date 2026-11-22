import React from 'react';
import Link from 'next/link';
import { Search, Filter, Tag, Calendar, PlusCircle } from 'lucide-react';
import prisma from '@/lib/prisma';
import { serializeData } from '@/lib/serialize';
import EventCard from '@/components/EventCard';

export const dynamic = 'force-dynamic';

interface EventsPageProps {
  searchParams: {
    q?: string;
    type?: string;
  };
}

async function getEvents(q?: string, type?: string) {
  try {
    const where: any = {
      status: 'approved',
    };

    if (type && type !== 'all') {
      where.type = type;
    }

    if (q) {
      where.title = {
        contains: q,
      };
    }

    const events = await prisma.event.findMany({
      where,
      orderBy: { created_at: 'desc' },
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
    console.error('Error fetching events catalog:', error);
    return [];
  }
}

export default async function EventsPage({ searchParams }: EventsPageProps) {
  const q = searchParams.q || '';
  const selectedType = searchParams.type || 'all';

  const events = await getEvents(q, selectedType);

  const categories = [
    { label: 'Semua Kategori', value: 'all' },
    { label: 'Seminar', value: 'Seminar' },
    { label: 'Webinar', value: 'Webinar' },
    { label: 'Lomba', value: 'Lomba' },
    { label: 'Festival', value: 'Festival' },
    { label: 'Exhibition', value: 'Exhibition' },
  ];

  return (
    <div className="min-h-screen bg-slate-50 py-10">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {/* Header Title */}
        <div className="flex flex-col md:flex-row md:items-center justify-between pb-8 border-b border-slate-200/80 gap-4">
          <div>
            <div className="inline-flex items-center gap-2 text-xs font-bold text-telu-600 uppercase tracking-wider mb-1">
              <Calendar className="w-4 h-4" />
              Direktori Kegiatan Kampus
            </div>
            <h1 className="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight">
              Katalog Acara TelEVent
            </h1>
            <p className="text-sm text-slate-500 mt-1">
              Temukan berbagai kegiatan akademik, kompetisi, seminar, dan festival terbaru.
            </p>
          </div>

          <Link
            href="/events/create"
            className="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-telu-600 hover:bg-telu-700 text-white text-xs font-bold shadow-md hover:shadow-lg transition-all self-start md:self-auto"
          >
            <PlusCircle className="w-4 h-4" />
            Ajukan Acara Baru
          </Link>
        </div>

        {/* Filter & Search Bar */}
        <div className="my-8 space-y-4">
          <form method="GET" className="flex flex-col sm:flex-row gap-3">
            <div className="relative flex-1">
              <Search className="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" />
              <input
                type="text"
                name="q"
                defaultValue={q}
                placeholder="Cari berdasarkan judul atau nama acara..."
                className="w-full pl-11 pr-4 py-3 rounded-xl bg-white border border-slate-200 text-slate-900 placeholder-slate-400 text-sm focus:outline-none focus:ring-2 focus:ring-telu-500 shadow-sm"
              />
            </div>

            {selectedType !== 'all' && (
              <input type="hidden" name="type" value={selectedType} />
            )}

            <button
              type="submit"
              className="px-6 py-3 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold transition-all shadow-sm flex items-center justify-center gap-2"
            >
              <Search className="w-3.5 h-3.5" />
              Cari
            </button>
          </form>

          {/* Category Tabs */}
          <div className="flex items-center gap-2 overflow-x-auto pb-2 scrollbar-none">
            {categories.map((cat) => {
              const isActive = selectedType === cat.value;
              return (
                <Link
                  key={cat.value}
                  href={`/events?${new URLSearchParams({
                    ...(q ? { q } : {}),
                    ...(cat.value !== 'all' ? { type: cat.value } : {}),
                  }).toString()}`}
                  className={`px-4 py-2 rounded-xl text-xs font-bold whitespace-nowrap transition-all ${
                    isActive
                      ? 'bg-telu-600 text-white shadow-sm'
                      : 'bg-white text-slate-600 border border-slate-200/80 hover:border-slate-300 hover:bg-slate-50'
                  }`}
                >
                  {cat.label}
                </Link>
              );
            })}
          </div>
        </div>

        {/* Event Grid */}
        {events.length > 0 ? (
          <div>
            <div className="text-xs font-semibold text-slate-500 mb-4">
              Menampilkan {events.length} acara yang ditemukan
            </div>
            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
              {events.map((ev: any) => (
                <EventCard key={ev.id} event={ev} showStatus={false} />
              ))}
            </div>
          </div>
        ) : (
          <div className="bg-white rounded-3xl p-12 text-center border border-slate-200/80 shadow-sm my-8">
            <div className="w-16 h-16 rounded-2xl bg-slate-100 flex items-center justify-center text-slate-400 mx-auto mb-4">
              <Search className="w-8 h-8" />
            </div>
            <h3 className="text-lg font-bold text-slate-800">Tidak ada acara yang cocok</h3>
            <p className="text-xs text-slate-500 mt-1 max-w-sm mx-auto">
              Coba gunakan kata kunci lain atau pilih kategori yang berbeda untuk menemukan acara yang Anda cari.
            </p>
            <Link
              href="/events"
              className="mt-5 inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition-colors"
            >
              Reset Filter Pencarian
            </Link>
          </div>
        )}
      </div>
    </div>
  );
}
