'use client';

import React, { useState } from 'react';
import { useRouter } from 'next/navigation';
import { Check, X, Trash2 } from 'lucide-react';

export default function AdminRowActions({
  eventId,
  showDelete = false,
}: {
  eventId: number;
  showDelete?: boolean;
}) {
  const router = useRouter();
  const [loading, setLoading] = useState(false);

  const handleStatus = async (status: string) => {
    setLoading(true);
    try {
      const res = await fetch(`/api/events/${eventId}/status`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ status }),
      });

      if (!res.ok) {
        const d = await res.json();
        alert(d.error || 'Gagal mengubah status');
        return;
      }

      router.refresh();
    } catch (e) {
      alert('Terjadi kesalahan jaringan');
    } finally {
      setLoading(false);
    }
  };

  const handleDelete = async () => {
    if (!confirm('Apakah Anda yakin ingin menghapus proposal acara ini secara permanen?')) {
      return;
    }

    setLoading(true);
    try {
      const res = await fetch(`/api/events/${eventId}`, {
        method: 'DELETE',
      });

      if (!res.ok) {
        const d = await res.json();
        alert(d.error || 'Gagal menghapus event');
        return;
      }

      router.refresh();
    } catch (e) {
      alert('Terjadi kesalahan jaringan');
    } finally {
      setLoading(false);
    }
  };

  return (
    <div className="flex items-center gap-1.5">
      <button
        onClick={() => handleStatus('approved')}
        disabled={loading}
        className="px-3 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold flex items-center gap-1 transition-colors disabled:opacity-50 shadow-sm cursor-pointer"
        title="Setujui Proposal"
      >
        <Check className="w-3.5 h-3.5 stroke-[2]" />
        Setujui
      </button>

      <button
        onClick={() => handleStatus('rejected')}
        disabled={loading}
        className="px-3 py-1.5 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200/80 text-xs font-bold flex items-center gap-1 transition-colors disabled:opacity-50 cursor-pointer"
        title="Tolak Proposal"
      >
        <X className="w-3.5 h-3.5 stroke-[2]" />
        Tolak
      </button>

      {showDelete && (
        <button
          onClick={handleDelete}
          disabled={loading}
          className="p-1.5 rounded-xl bg-slate-100 hover:bg-rose-50 text-slate-500 hover:text-rose-600 border border-slate-200 transition-colors disabled:opacity-50 cursor-pointer"
          title="Hapus Acara"
        >
          <Trash2 className="w-3.5 h-3.5 stroke-[1.75]" />
        </button>
      )}
    </div>
  );
}
