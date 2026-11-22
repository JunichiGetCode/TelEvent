'use client';

import React, { useState } from 'react';
import { useRouter } from 'next/navigation';
import { Check, X, RotateCcw } from 'lucide-react';

export default function AdminStatusButtons({
  eventId,
  currentStatus,
}: {
  eventId: number;
  currentStatus: string;
}) {
  const router = useRouter();
  const [loading, setLoading] = useState(false);

  const handleStatusChange = async (newStatus: string) => {
    if (!confirm(`Apakah Anda yakin ingin mengubah status proposal menjadi "${newStatus}"?`)) {
      return;
    }

    setLoading(true);
    try {
      const res = await fetch(`/api/events/${eventId}/status`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ status: newStatus }),
      });

      if (!res.ok) {
        const data = await res.json();
        alert(data.error || 'Gagal mengubah status');
        return;
      }

      router.refresh();
    } catch (e) {
      console.error(e);
      alert('Terjadi kesalahan jaringan.');
    } finally {
      setLoading(false);
    }
  };

  return (
    <div className="flex items-center gap-2">
      {currentStatus !== 'approved' && (
        <button
          onClick={() => handleStatusChange('approved')}
          disabled={loading}
          className="flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-bold bg-emerald-600 hover:bg-emerald-500 text-white transition-all shadow-sm disabled:opacity-50"
        >
          <Check className="w-3.5 h-3.5" />
          Setujui Proposal
        </button>
      )}

      {currentStatus !== 'rejected' && (
        <button
          onClick={() => handleStatusChange('rejected')}
          disabled={loading}
          className="flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-bold bg-rose-600/80 hover:bg-rose-600 text-white transition-all shadow-sm disabled:opacity-50"
        >
          <X className="w-3.5 h-3.5" />
          Tolak Proposal
        </button>
      )}

      {currentStatus !== 'pending' && (
        <button
          onClick={() => handleStatusChange('pending')}
          disabled={loading}
          className="flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-semibold bg-slate-800 hover:bg-slate-700 text-slate-300 transition-all border border-slate-700 disabled:opacity-50"
          title="Kembalikan ke status review"
        >
          <RotateCcw className="w-3.5 h-3.5" />
          Reset Review
        </button>
      )}
    </div>
  );
}
