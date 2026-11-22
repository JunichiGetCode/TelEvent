import React from 'react';
import Link from 'next/link';
import { redirect } from 'next/navigation';
import {
  User,
  Mail,
  Phone,
  Shield,
  Edit3,
  Calendar,
  FileText,
  Clock,
  CheckCircle2,
  XCircle,
  ExternalLink,
  PlusCircle,
} from 'lucide-react';
import { getCurrentUser } from '@/lib/auth';
import prisma from '@/lib/prisma';
import { serializeData } from '@/lib/serialize';
import StatusBadge from '@/components/StatusBadge';

async function getProfileData(userId: number) {
  try {
    const user = await prisma.user.findUnique({
      where: { id: BigInt(userId) },
    });

    const events = await prisma.event.findMany({
      where: { user_id: BigInt(userId) },
      orderBy: { created_at: 'desc' },
    });

    const pending = events.filter((e) => e.status === 'pending').length;
    const approved = events.filter((e) => e.status === 'approved').length;
    const rejected = events.filter((e) => e.status === 'rejected').length;

    return {
      user: serializeData(user),
      events: serializeData(events),
      stats: { total: events.length, pending, approved, rejected },
    };
  } catch (err) {
    console.error(err);
    return null;
  }
}

export default async function ProfilePage() {
  const currentUser = await getCurrentUser();
  if (!currentUser) {
    redirect('/login');
  }

  const data = await getProfileData(currentUser.id);
  if (!data) {
    redirect('/login');
  }

  const { user, events, stats } = data;

  return (
    <div className="min-h-screen bg-slate-50 py-10">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        {/* Profile Card Header */}
        <div className="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
          <div className="flex items-center gap-5">
            {user.avatar ? (
              <img
                src={user.avatar.startsWith('http') || user.avatar.startsWith('/') ? user.avatar : `/uploads/profile/${user.avatar}`}
                alt={user.name}
                className="w-20 h-20 rounded-2xl object-cover border-2 border-telu-200 shadow-md"
              />
            ) : (
              <div className="w-20 h-20 rounded-2xl bg-gradient-to-br from-telu-600 to-telu-800 text-white font-black text-2xl flex items-center justify-center shadow-md">
                {user.name.charAt(0).toUpperCase()}
              </div>
            )}

            <div>
              <div className="flex items-center gap-2 mb-1">
                <h1 className="text-2xl font-black text-slate-900">{user.name}</h1>
                <span className="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-telu-100 text-telu-700">
                  {user.role}
                </span>
              </div>
              <div className="flex flex-wrap items-center gap-4 text-xs text-slate-500">
                <span className="flex items-center gap-1.5">
                  <Mail className="w-3.5 h-3.5 text-slate-400" />
                  {user.email}
                </span>
                {user.phone && (
                  <span className="flex items-center gap-1.5">
                    <Phone className="w-3.5 h-3.5 text-slate-400" />
                    {user.phone}
                  </span>
                )}
              </div>
            </div>
          </div>

          <div className="flex items-center gap-3">
            <Link
              href="/profile/edit"
              className="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-slate-200 hover:border-slate-300 bg-white text-slate-700 text-xs font-bold transition-all shadow-sm"
            >
              <Edit3 className="w-3.5 h-3.5" />
              Edit Profil
            </Link>
            <Link
              href="/events/create"
              className="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-telu-600 hover:bg-telu-700 text-white text-xs font-bold transition-all shadow-md"
            >
              <PlusCircle className="w-4 h-4" />
              Ajukan Acara Baru
            </Link>
          </div>
        </div>

        {/* Stats Summary */}
        <div className="grid grid-cols-2 md:grid-cols-4 gap-4">
          <div className="p-4 rounded-2xl bg-white border border-slate-200/80 shadow-sm text-center">
            <p className="text-xs font-semibold text-slate-400 uppercase">Total Proposal</p>
            <p className="text-2xl font-black text-slate-900 mt-1">{stats.total}</p>
          </div>
          <div className="p-4 rounded-2xl bg-white border border-amber-200/80 shadow-sm text-center">
            <p className="text-xs font-semibold text-amber-600 uppercase">Menunggu Review</p>
            <p className="text-2xl font-black text-amber-700 mt-1">{stats.pending}</p>
          </div>
          <div className="p-4 rounded-2xl bg-white border border-emerald-200/80 shadow-sm text-center">
            <p className="text-xs font-semibold text-emerald-600 uppercase">Disetujui</p>
            <p className="text-2xl font-black text-emerald-700 mt-1">{stats.approved}</p>
          </div>
          <div className="p-4 rounded-2xl bg-white border border-rose-200/80 shadow-sm text-center">
            <p className="text-xs font-semibold text-rose-600 uppercase">Ditolak</p>
            <p className="text-2xl font-black text-rose-700 mt-1">{stats.rejected}</p>
          </div>
        </div>

        {/* All Submitted Proposals Table */}
        <div className="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6 sm:p-8">
          <div className="pb-4 border-b border-slate-100 mb-6">
            <h2 className="text-lg font-bold text-slate-900">Riwayat Pengajuan Proposal Acara</h2>
            <p className="text-xs text-slate-500">
              Lacak setiap proposal kegiatan yang pernah diajukan oleh akun Anda.
            </p>
          </div>

          {events.length > 0 ? (
            <div className="overflow-x-auto">
              <table className="w-full text-left text-xs">
                <thead>
                  <tr className="border-b border-slate-100 text-slate-400 uppercase text-[10px] tracking-wider font-bold">
                    <th className="py-3 px-4">Nama Acara</th>
                    <th className="py-3 px-4">Kategori</th>
                    <th className="py-3 px-4">Tanggal Pengajuan</th>
                    <th className="py-3 px-4">Status</th>
                    <th className="py-3 px-4 text-right">Aksi</th>
                  </tr>
                </thead>
                <tbody className="divide-y divide-slate-100 font-medium">
                  {events.map((ev: any) => (
                    <tr key={ev.id} className="hover:bg-slate-50/60 transition-colors">
                      <td className="py-4 px-4 font-bold text-slate-900">
                        <Link href={`/events/${ev.id}`} className="hover:text-telu-600 transition-colors">
                          {ev.title}
                        </Link>
                      </td>
                      <td className="py-4 px-4 text-slate-600">{ev.type}</td>
                      <td className="py-4 px-4 text-slate-500">
                        {ev.created_at ? new Date(ev.created_at).toLocaleDateString('id-ID') : '-'}
                      </td>
                      <td className="py-4 px-4">
                        <StatusBadge status={ev.status} size="sm" />
                      </td>
                      <td className="py-4 px-4 text-right">
                        <Link
                          href={`/events/${ev.id}`}
                          className="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-[11px] transition-colors"
                        >
                          Lihat Detail
                          <ExternalLink className="w-3 h-3" />
                        </Link>
                      </td>
                    </tr>
                  ))}
                </tbody>
              </table>
            </div>
          ) : (
            <div className="text-center py-12">
              <FileText className="w-10 h-10 text-slate-300 mx-auto mb-2" />
              <p className="text-xs font-bold text-slate-700">Belum ada proposal yang diajukan</p>
              <Link
                href="/events/create"
                className="mt-3 inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-telu-600 text-white text-xs font-bold hover:bg-telu-700 transition-colors"
              >
                Ajukan Acara Baru
              </Link>
            </div>
          )}
        </div>
      </div>
    </div>
  );
}
