import React from 'react';
import Link from 'next/link';
import {
  Calendar,
  Search,
  Filter,
  PlusCircle,
  FileText,
  ExternalLink,
  Edit,
  Trash2,
} from 'lucide-react';
import prisma from '@/lib/prisma';
import { serializeData } from '@/lib/serialize';
import StatusBadge from '@/components/StatusBadge';
import AdminRowActions from './AdminRowActions';

interface AdminEventsPageProps {
  searchParams: {
    q?: string;
    status?: string;
    type?: string;
  };
}

async function getAdminEvents(q?: string, status?: string, type?: string) {
  try {
    const where: any = {};

    if (status && status !== 'all') {
      where.status = status;
    }

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
            email: true,
            phone: true,
          },
        },
      },
    });

    return serializeData(events);
  } catch (err) {
    console.error(err);
    return [];
  }
}

export default async function AdminEventsPage({ searchParams }: AdminEventsPageProps) {
  const q = searchParams.q || '';
  const status = searchParams.status || 'all';
  const type = searchParams.type || 'all';

  const events = await getAdminEvents(q, status, type);

  const statusOptions = [
    { label: 'Semua Status', value: 'all' },
    { label: 'Menunggu Review (Pending)', value: 'pending' },
    { label: 'Disetujui (Approved)', value: 'approved' },
    { label: 'Ditolak (Rejected)', value: 'rejected' },
  ];

  return (
    <div className="space-y-6 max-w-7xl mx-auto">
      {/* Header */}
      <div className="flex flex-col sm:flex-row sm:items-center justify-between pb-6 border-b border-slate-800 gap-4">
        <div>
          <span className="text-[11px] font-bold uppercase tracking-wider text-telu-400">
            Katalog & Manajemen
          </span>
          <h1 className="text-3xl font-black text-white tracking-tight mt-1">
            Kelola Seluruh Proposal Acara
          </h1>
          <p className="text-xs text-slate-400 mt-1">
            Daftar lengkap permohonan acara dari seluruh ormawa dan kepanitiaan Telkom University.
          </p>
        </div>
      </div>

      {/* Filter & Search Bar */}
      <div className="bg-slate-800/80 rounded-2xl p-4 border border-slate-700/80 shadow-md">
        <form method="GET" className="grid grid-cols-1 sm:grid-cols-4 gap-3">
          <div className="sm:col-span-2 relative">
            <Search className="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" />
            <input
              type="text"
              name="q"
              defaultValue={q}
              placeholder="Cari berdasarkan judul proposal..."
              className="w-full pl-10 pr-4 py-2.5 rounded-xl bg-slate-900 border border-slate-700 text-xs text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-telu-500"
            />
          </div>

          <div>
            <select
              name="status"
              defaultValue={status}
              className="w-full px-3 py-2.5 rounded-xl bg-slate-900 border border-slate-700 text-xs text-white focus:outline-none focus:ring-2 focus:ring-telu-500 cursor-pointer"
            >
              {statusOptions.map((opt) => (
                <option key={opt.value} value={opt.value}>
                  {opt.label}
                </option>
              ))}
            </select>
          </div>

          <div>
            <select
              name="type"
              defaultValue={type}
              className="w-full px-3 py-2.5 rounded-xl bg-slate-900 border border-slate-700 text-xs text-white focus:outline-none focus:ring-2 focus:ring-telu-500 cursor-pointer"
            >
              <option value="all">Semua Jenis Kegiatan</option>
              <option value="Seminar">Seminar</option>
              <option value="Webinar">Webinar</option>
              <option value="Lomba">Lomba</option>
              <option value="Festival">Festival</option>
              <option value="Exhibition">Exhibition</option>
            </select>
          </div>
        </form>
      </div>

      {/* Table */}
      <div className="bg-slate-800/80 rounded-3xl border border-slate-700/80 shadow-xl overflow-hidden">
        <div className="p-5 border-b border-slate-700/80 flex items-center justify-between">
          <span className="text-xs font-bold text-slate-300">
            Ditemukan {events.length} proposal acara
          </span>
        </div>

        {events.length > 0 ? (
          <div className="overflow-x-auto">
            <table className="w-full text-left text-xs text-slate-300">
              <thead>
                <tr className="border-b border-slate-700 text-slate-500 uppercase text-[10px] tracking-wider font-bold bg-slate-900/60">
                  <th className="py-3.5 px-4">Nama Acara</th>
                  <th className="py-3.5 px-4">Penyelenggara</th>
                  <th className="py-3.5 px-4">Jenis</th>
                  <th className="py-3.5 px-4">Pelaksanaan</th>
                  <th className="py-3.5 px-4">Status</th>
                  <th className="py-3.5 px-4">Berkas</th>
                  <th className="py-3.5 px-4 text-right">Aksi Verifikasi</th>
                </tr>
              </thead>
              <tbody className="divide-y divide-slate-700/50 font-medium">
                {events.map((ev: any) => (
                  <tr key={ev.id} className="hover:bg-slate-700/20 transition-colors">
                    <td className="py-4 px-4 font-bold text-white max-w-[200px] truncate">
                      <Link href={`/events/${ev.id}`} className="hover:text-telu-400 transition-colors">
                        {ev.title}
                      </Link>
                    </td>
                    <td className="py-4 px-4 text-slate-400">
                      <p className="font-semibold text-slate-200">{ev.user?.name || '-'}</p>
                      <p className="text-[10px] text-slate-500">{ev.user?.email}</p>
                    </td>
                    <td className="py-4 px-4 text-slate-300">{ev.type}</td>
                    <td className="py-4 px-4 text-slate-400 text-[11px]">
                      {ev.start_date ? new Date(ev.start_date).toLocaleDateString('id-ID') : '-'}
                    </td>
                    <td className="py-4 px-4">
                      <StatusBadge status={ev.status} size="sm" />
                    </td>
                    <td className="py-4 px-4">
                      <div className="flex items-center gap-2">
                        <a
                          href={ev.proposal}
                          target="_blank"
                          rel="noreferrer"
                          className="px-2 py-1 rounded bg-slate-700 hover:bg-slate-600 text-slate-200 text-[10px] font-bold"
                          title="Proposal"
                        >
                          Proposal
                        </a>
                        <a
                          href={ev.budgeting}
                          target="_blank"
                          rel="noreferrer"
                          className="px-2 py-1 rounded bg-slate-700 hover:bg-slate-600 text-slate-200 text-[10px] font-bold"
                          title="RAB"
                        >
                          RAB
                        </a>
                      </div>
                    </td>
                    <td className="py-4 px-4 text-right">
                      <div className="flex items-center justify-end gap-2">
                        <Link
                          href={`/admin/events/${ev.id}/edit`}
                          className="p-1.5 rounded-lg bg-slate-700 hover:bg-slate-600 text-slate-300 transition-colors"
                          title="Edit Rincian"
                        >
                          <Edit className="w-3.5 h-3.5" />
                        </Link>
                        <AdminRowActions eventId={ev.id} showDelete={true} />
                      </div>
                    </td>
                  </tr>
                ))}
              </tbody>
            </table>
          </div>
        ) : (
          <div className="text-center py-14">
            <FileText className="w-10 h-10 text-slate-600 mx-auto mb-2" />
            <h4 className="text-sm font-bold text-white">Tidak ada proposal yang sesuai</h4>
            <p className="text-xs text-slate-400 mt-1">
              Gunakan kata kunci pencarian atau filter yang berbeda.
            </p>
          </div>
        )}
      </div>
    </div>
  );
}
