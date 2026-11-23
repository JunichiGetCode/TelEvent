'use client';

import React, { useState } from 'react';
import Link from 'next/link';
import { Info, X, Shield, Calendar } from 'lucide-react';

export default function PreviewBanner() {
  const [dismissed, setDismissed] = useState(false);

  if (dismissed) return null;

  return (
    <div className="bg-slate-900 text-white text-[11px] py-1.5 px-4 relative z-50 border-b border-slate-800">
      <div className="max-w-7xl mx-auto flex items-center justify-between gap-4">
        <div className="flex items-center gap-2 flex-wrap">
          <span className="px-1.5 py-0.5 rounded font-bold uppercase tracking-wider text-[9px] bg-telu-600 text-white">
            Vercel Preview
          </span>
          <span className="text-slate-300">
            Versi deployment preview aktif. Dilengkapi data demo kampus dan akun uji coba.
          </span>
        </div>

        <div className="flex items-center gap-3 shrink-0">
          <Link
            href="/login"
            className="text-amber-300 hover:text-amber-200 font-semibold underline underline-offset-2"
          >
            Info Akun Demo
          </Link>
          <button
            onClick={() => setDismissed(true)}
            className="text-slate-400 hover:text-white p-0.5"
            aria-label="Tutup Banner"
          >
            <X className="w-3.5 h-3.5" />
          </button>
        </div>
      </div>
    </div>
  );
}
