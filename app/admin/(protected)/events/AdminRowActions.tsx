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
        className="px-2.5 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-500 text-white text-[11px] font-bold flex items-center gap-1 transition-colors disabled:opacity-50"
        title="Setujui Proposal"
      >
        <Check className="w-3.5 h-3.5" />
        Setujui
      </button>

      <button
        onClick={() => handleStatus('rejected')}
        disabled={loading}
        className="px-2.5 py-1.5 rounded-lg bg-rose-600/80 hover:bg-rose-600 text-white text-[11px] font-bold flex items-center gap-1 transition-colors disabled:opacity-50"
        title="Tolak Proposal"
      >
        <X className="w-3.5 h-3.5" />
        Tolak
      </button>

      {showDelete && (
        <button
          onClick={handleDelete}
          disabled={loading}
          className="p-1.5 rounded-lg bg-slate-700 hover:bg-rose-900/60 text-slate-400 hover:text-rose-300 transition-colors disabled:opacity-50"
          title="Hapus Acara"
        >
          <Trash2 className="w-3.5 h-3.5" />
        </button>
      )}
    </div>
  );
}
