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
  User,
  ShieldAlert,
} from 'lucide-react';

export default function AdminSidebar({ user }: { user?: any }) {
  const pathname = usePathname();
  const router = useRouter();

  const handleLogout = async () => {
    try {
      await fetch('/api/auth/logout', { method: 'POST' });
      router.push('/login');
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
    <aside className="w-64 bg-slate-950 text-slate-300 flex flex-col min-h-screen border-r border-slate-800">
      {/* Brand Header */}
      <div className="p-6 border-b border-slate-800/80">
        <Link href="/admin/dashboard" className="flex items-center gap-3">
          <div className="w-10 h-10 rounded-xl bg-telu-600 flex items-center justify-center text-white shadow-glow">
            <Calendar className="w-5 h-5" />
          </div>
          <div>
            <h2 className="text-base font-black text-white tracking-tight">
              Tel<span className="text-amber-400">EVent</span>
            </h2>
            <span className="text-[10px] font-bold tracking-widest text-telu-400 uppercase">
              Admin Portal
            </span>
          </div>
        </Link>
      </div>

      {/* Nav List */}
      <div className="flex-1 px-4 py-6 space-y-1">
        <div className="text-[10px] font-bold uppercase tracking-wider text-slate-500 px-3 mb-2">
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
                  ? 'bg-telu-600 text-white shadow-glow'
                  : 'text-slate-400 hover:text-white hover:bg-slate-900'
              }`}
            >
              <Icon className="w-4 h-4" />
              {item.name}
            </Link>
          );
        })}

        <div className="text-[10px] font-bold uppercase tracking-wider text-slate-500 px-3 mt-6 mb-2">
          Pintasan
        </div>
        <Link
          href="/"
          className="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold text-slate-400 hover:text-white hover:bg-slate-900 transition-colors"
        >
          <ArrowLeft className="w-4 h-4" />
          Kembali ke Situs Utama
        </Link>
      </div>

      {/* Admin Profile Footer */}
      <div className="p-4 border-t border-slate-800/80 bg-slate-900/50">
        <div className="flex items-center gap-3 mb-3">
          <div className="w-9 h-9 rounded-xl bg-gradient-to-tr from-telu-600 to-amber-500 flex items-center justify-center text-white font-bold text-xs shadow-sm">
            {user?.name ? user.name.charAt(0).toUpperCase() : 'A'}
          </div>
          <div className="flex-1 min-w-0">
            <p className="text-xs font-bold text-white truncate">{user?.name || 'Administrator'}</p>
            <p className="text-[11px] text-slate-500 truncate">{user?.email || 'admin@telkomuniversity.ac.id'}</p>
          </div>
        </div>

        <button
          onClick={handleLogout}
          className="w-full flex items-center justify-center gap-2 py-2 px-3 rounded-lg text-xs font-bold text-rose-400 bg-rose-950/40 hover:bg-rose-950/70 border border-rose-900/40 transition-colors"
        >
          <LogOut className="w-3.5 h-3.5" />
          Keluar Admin
        </button>
      </div>
    </aside>
  );
}
