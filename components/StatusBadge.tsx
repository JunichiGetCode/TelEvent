import React from 'react';
import { Clock, CheckCircle2, XCircle, AlertCircle } from 'lucide-react';

interface StatusBadgeProps {
  status: string;
  size?: 'sm' | 'md';
}

export default function StatusBadge({ status, size = 'sm' }: StatusBadgeProps) {
  const norm = status?.toLowerCase() || 'pending';

  if (norm === 'approved') {
    return (
      <span
        className={`inline-flex items-center gap-1.5 font-semibold rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200/60 shadow-sm ${
          size === 'sm' ? 'px-2.5 py-0.5 text-xs' : 'px-3 py-1 text-sm'
        }`}
      >
        <CheckCircle2 className={size === 'sm' ? 'w-3.5 h-3.5' : 'w-4 h-4'} />
        Disetujui
      </span>
    );
  }

  if (norm === 'rejected') {
    return (
      <span
        className={`inline-flex items-center gap-1.5 font-semibold rounded-full bg-rose-50 text-rose-700 border border-rose-200/60 shadow-sm ${
          size === 'sm' ? 'px-2.5 py-0.5 text-xs' : 'px-3 py-1 text-sm'
        }`}
      >
        <XCircle className={size === 'sm' ? 'w-3.5 h-3.5' : 'w-4 h-4'} />
        Ditolak
      </span>
    );
  }

  return (
    <span
      className={`inline-flex items-center gap-1.5 font-semibold rounded-full bg-amber-50 text-amber-700 border border-amber-200/60 shadow-sm ${
        size === 'sm' ? 'px-2.5 py-0.5 text-xs' : 'px-3 py-1 text-sm'
      }`}
    >
      <Clock className={size === 'sm' ? 'w-3.5 h-3.5' : 'w-4 h-4'} />
      Menunggu Review
    </span>
  );
}
