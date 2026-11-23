'use client';

import React from 'react';
import Link from 'next/link';
import { usePathname, useRouter } from 'next/navigation';
import {
  Calendar,
  LayoutDashboard,
  CalendarCheck,
  ArrowLeft,
  LogOut,
  Shield,
} from 'lucide-react';

export default function AdminSidebar({ user }: { user?: any }) {
  const pathname = usePathname();
  const router = useRouter();

  const handleLogout = async () => {
    try {
      await fetch('/api/auth/logout', { method: 'POST' });
      router.push('/admin/login');
      router.refresh();
    } catch (e) {
      console.error(e);
    }
  };

  const navItems = [
    {
      name: 'Overview Dashboard',
      href: '/admin/dashboard',
      icon: LayoutDashboard,
    },
    {
      name: 'Kelola Proposal Acara',
      href: '/admin/events',
      icon: CalendarCheck,
    },
  ];

  return (
    <aside className="w-64 bg-white text-slate-700 flex flex-col min-h-screen border-r border-slate-200/80 shrink-0">
      {/* Brand Header */}
      <div className="p-6 border-b border-slate-100">
        <Link href="/admin/dashboard" className="flex items-center gap-3">
          <div className="w-10 h-10 rounded-xl bg-telu-600 flex items-center justify-center p-1 shadow-sm">
            <img src="/favicon.svg" alt="TelEVent Logo" className="w-8 h-8" />
          </div>
          <div>
            <h2 className="text-base font-black text-slate-900 tracking-tight">
              Tel<span className="text-telu-600">EVent</span>
            </h2>
            <div className="inline-flex items-center gap-1 text-[10px] font-bold tracking-widest text-telu-700 uppercase">
              <Shield className="w-3 h-3 text-telu-600" />
              Portal Admin
            </div>
          </div>
        </Link>
      </div>

      {/* Nav List */}
      <div className="flex-1 px-4 py-6 space-y-1">
        <div className="text-[10px] font-bold uppercase tracking-wider text-slate-400 px-3 mb-2">
          Menu Utama
        </div>
        {navItems.map((item) => {
          const isActive = pathname === item.href;
          const Icon = item.icon;
          return (
            <Link
              key={item.name}
              href={item.href}
              className={`flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-bold transition-all ${
                isActive
                  ? 'bg-telu-50 text-telu-700 border border-telu-200/60 shadow-sm'
                  : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100'
              }`}
            >
              <Icon className={`w-4 h-4 stroke-[1.75] ${isActive ? 'text-telu-600' : 'text-slate-400'}`} />
              {item.name}
            </Link>
          );
        })}

        <div className="text-[10px] font-bold uppercase tracking-wider text-slate-400 px-3 mt-6 mb-2">
          Pintasan
        </div>
        <Link
          href="/"
          className="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition-colors"
        >
          <ArrowLeft className="w-4 h-4 text-slate-400 stroke-[1.75]" />
          Kembali ke Situs Utama
        </Link>
      </div>

      {/* Admin Profile Footer */}
      <div className="p-4 border-t border-slate-100 bg-slate-50/70">
        <div className="flex items-center gap-3 mb-3">
          <div className="w-9 h-9 rounded-xl bg-telu-100 text-telu-700 border border-telu-200/60 flex items-center justify-center font-bold text-xs shadow-sm">
            {user?.name ? user.name.charAt(0).toUpperCase() : 'A'}
          </div>
          <div className="flex-1 min-w-0">
            <p className="text-xs font-bold text-slate-900 truncate">{user?.name || 'Administrator'}</p>
            <p className="text-[11px] text-slate-500 truncate">{user?.email || 'admin@telkomuniversity.ac.id'}</p>
          </div>
        </div>

        <button
          onClick={handleLogout}
          className="w-full flex items-center justify-center gap-2 py-2 px-3 rounded-xl text-xs font-bold text-rose-700 bg-rose-50 hover:bg-rose-100 border border-rose-200/60 transition-colors cursor-pointer"
        >
          <LogOut className="w-3.5 h-3.5 stroke-[1.75]" />
          Keluar Admin
        </button>
      </div>
    </aside>
  );
}
