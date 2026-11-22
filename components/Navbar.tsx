'use client';

import React, { useState, useEffect } from 'react';
import Link from 'next/link';
import { usePathname, useRouter } from 'next/navigation';
import {
  Calendar,
  PlusCircle,
  User,
  Shield,
  LogOut,
  Menu,
  X,
  Compass,
  Info,
  ChevronDown,
  LayoutDashboard,
} from 'lucide-react';

export default function Navbar() {
  const pathname = usePathname();
  const router = useRouter();
  const [user, setUser] = useState<any>(null);
  const [loading, setLoading] = useState(true);
  const [mobileMenuOpen, setMobileMenuOpen] = useState(false);
  const [dropdownOpen, setDropdownOpen] = useState(false);

  useEffect(() => {
    fetch('/api/auth/me')
      .then((res) => {
        if (res.ok) return res.json();
        return { user: null };
      })
      .then((data) => {
        setUser(data?.user || null);
      })
      .catch(() => setUser(null))
      .finally(() => setLoading(false));
  }, [pathname]);

  const handleLogout = async () => {
    try {
      await fetch('/api/auth/logout', { method: 'POST' });
      setUser(null);
      setDropdownOpen(false);
      router.push('/');
      router.refresh();
    } catch (err) {
      console.error('Logout error:', err);
    }
  };

  const navLinks = [
    { name: 'Beranda', href: '/', icon: Calendar },
    { name: 'Katalog Acara', href: '/events', icon: Compass },
    { name: 'Tentang', href: '/about', icon: Info },
  ];

  return (
    <header className="sticky top-0 z-50 bg-gradient-to-r from-telu-700 via-telu-600 to-telu-800 shadow-md">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="flex items-center justify-between h-16">
          {/* Brand Logo */}
          <Link href="/" className="flex items-center gap-2.5 group">
            <div className="w-10 h-10 rounded-xl bg-white/10 backdrop-blur-md flex items-center justify-center text-white border border-white/20 shadow-sm group-hover:scale-105 transition-transform">
              <Calendar className="w-5 h-5 text-white" />
            </div>
            <div className="flex flex-col">
              <span className="text-xl font-black text-white tracking-tight flex items-center gap-1">
                Tel<span className="text-amber-300">EVent</span>
              </span>
              <span className="text-[10px] text-white/70 font-medium tracking-wider -mt-1 uppercase">
                Telkom University
              </span>
            </div>
          </Link>

          {/* Desktop Navigation */}
          <nav className="hidden md:flex items-center gap-1">
            {navLinks.map((link) => {
              const isActive = pathname === link.href;
              const Icon = link.icon;
              return (
                <Link
                  key={link.name}
                  href={link.href}
                  className={`flex items-center gap-2 px-3.5 py-2 rounded-lg text-sm font-semibold transition-all ${
                    isActive
                      ? 'bg-white/20 text-white shadow-sm'
                      : 'text-white/80 hover:text-white hover:bg-white/10'
                  }`}
                >
                  <Icon className="w-4 h-4" />
                  {link.name}
                </Link>
              );
            })}
          </nav>

          {/* Desktop Action / Auth */}
          <div className="hidden md:flex items-center gap-3">
            {user ? (
              <>
                <Link
                  href="/events/create"
                  className="flex items-center gap-1.5 px-4 py-2 rounded-full text-xs font-bold bg-white text-telu-700 hover:bg-amber-50 hover:text-telu-800 transition-all shadow-sm hover:shadow"
                >
                  <PlusCircle className="w-4 h-4 text-telu-600" />
                  Ajukan Acara
                </Link>

                {/* User Dropdown */}
                <div className="relative">
                  <button
                    onClick={() => setDropdownOpen(!dropdownOpen)}
                    className="flex items-center gap-2.5 px-3 py-1.5 rounded-full bg-black/20 hover:bg-black/30 text-white text-sm font-medium border border-white/10 transition-colors"
                  >
                    {user.avatar ? (
                      <img
                        src={user.avatar.startsWith('http') || user.avatar.startsWith('/') ? user.avatar : `/uploads/profile/${user.avatar}`}
                        alt={user.name}
                        className="w-7 h-7 rounded-full object-cover border border-white/40"
                      />
                    ) : (
                      <div className="w-7 h-7 rounded-full bg-white/20 flex items-center justify-center text-xs font-bold">
                        {user.name.charAt(0).toUpperCase()}
                      </div>
                    )}
                    <span className="font-semibold text-xs max-w-[120px] truncate">{user.name}</span>
                    <ChevronDown className="w-3.5 h-3.5 text-white/70" />
                  </button>

                  {dropdownOpen && (
                    <div className="absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-2xl py-2 border border-slate-100 z-50 animate-in fade-in slide-in-from-top-2 duration-150">
                      <div className="px-4 py-2 border-b border-slate-100">
                        <p className="text-xs text-slate-500 font-medium">Masuk sebagai</p>
                        <p className="text-sm font-bold text-slate-800 truncate">{user.name}</p>
                        <span className="inline-block mt-1 px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-telu-50 text-telu-700">
                          {user.role}
                        </span>
                      </div>

                      {user.role === 'admin' ? (
                        <Link
                          href="/admin/dashboard"
                          onClick={() => setDropdownOpen(false)}
                          className="flex items-center gap-2.5 px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50 font-medium"
                        >
                          <Shield className="w-4 h-4 text-telu-600" />
                          Panel Admin
                        </Link>
                      ) : (
                        <Link
                          href="/home"
                          onClick={() => setDropdownOpen(false)}
                          className="flex items-center gap-2.5 px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50 font-medium"
                        >
                          <LayoutDashboard className="w-4 h-4 text-telu-600" />
                          Dashboard Saya
                        </Link>
                      )}

                      <Link
                        href="/profile"
                        onClick={() => setDropdownOpen(false)}
                        className="flex items-center gap-2.5 px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50 font-medium"
                      >
                        <User className="w-4 h-4 text-slate-500" />
                        Profil & Proposal
                      </Link>

                      <div className="border-t border-slate-100 my-1" />

                      <button
                        onClick={handleLogout}
                        className="w-full flex items-center gap-2.5 px-4 py-2.5 text-sm text-rose-600 hover:bg-rose-50 font-medium text-left"
                      >
                        <LogOut className="w-4 h-4" />
                        Keluar
                      </button>
                    </div>
                  )}
                </div>
              </>
            ) : (
              <>
                <Link
                  href="/login"
                  className="px-4 py-2 rounded-full text-xs font-bold text-white hover:bg-white/10 transition-colors"
                >
                  Masuk
                </Link>
                <Link
                  href="/register"
                  className="px-4 py-2 rounded-full text-xs font-bold bg-white text-telu-700 hover:bg-amber-50 hover:text-telu-800 transition-all shadow-sm"
                >
                  Daftar
                </Link>
              </>
            )}
          </div>

          {/* Mobile Menu Button */}
          <div className="flex md:hidden items-center gap-2">
            <button
              onClick={() => setMobileMenuOpen(!mobileMenuOpen)}
              className="p-2 rounded-xl text-white hover:bg-white/10 transition-colors"
              aria-label="Toggle menu"
            >
              {mobileMenuOpen ? <X className="w-6 h-6" /> : <Menu className="w-6 h-6" />}
            </button>
          </div>
        </div>
      </div>

      {/* Mobile Drawer */}
      {mobileMenuOpen && (
        <div className="md:hidden bg-telu-800 border-t border-white/10 px-4 pt-3 pb-6 space-y-3">
          <nav className="space-y-1">
            {navLinks.map((link) => {
              const Icon = link.icon;
              return (
                <Link
                  key={link.name}
                  href={link.href}
                  onClick={() => setMobileMenuOpen(false)}
                  className="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold text-white/90 hover:bg-white/10"
                >
                  <Icon className="w-4 h-4" />
                  {link.name}
                </Link>
              );
            })}
          </nav>

          <div className="pt-3 border-t border-white/10 space-y-2">
            {user ? (
              <>
                <Link
                  href="/events/create"
                  onClick={() => setMobileMenuOpen(false)}
                  className="flex items-center justify-center gap-2 w-full py-2.5 rounded-xl text-xs font-bold bg-white text-telu-700"
                >
                  <PlusCircle className="w-4 h-4" />
                  Ajukan Acara Baru
                </Link>
                {user.role === 'admin' ? (
                  <Link
                    href="/admin/dashboard"
                    onClick={() => setMobileMenuOpen(false)}
                    className="flex items-center gap-2.5 px-3 py-2 text-sm text-white/90 font-medium"
                  >
                    <Shield className="w-4 h-4 text-amber-300" />
                    Panel Admin
                  </Link>
                ) : (
                  <Link
                    href="/home"
                    onClick={() => setMobileMenuOpen(false)}
                    className="flex items-center gap-2.5 px-3 py-2 text-sm text-white/90 font-medium"
                  >
                    <LayoutDashboard className="w-4 h-4" />
                    Dashboard Saya
                  </Link>
                )}
                <Link
                  href="/profile"
                  onClick={() => setMobileMenuOpen(false)}
                  className="flex items-center gap-2.5 px-3 py-2 text-sm text-white/90 font-medium"
                >
                  <User className="w-4 h-4" />
                  Profil & Proposal
                </Link>
                <button
                  onClick={() => {
                    setMobileMenuOpen(false);
                    handleLogout();
                  }}
                  className="flex items-center gap-2.5 px-3 py-2 text-sm text-rose-300 font-medium w-full text-left"
                >
                  <LogOut className="w-4 h-4" />
                  Keluar
                </button>
              </>
            ) : (
              <div className="grid grid-cols-2 gap-2">
                <Link
                  href="/login"
                  onClick={() => setMobileMenuOpen(false)}
                  className="flex items-center justify-center py-2.5 rounded-xl text-xs font-bold text-white border border-white/20"
                >
                  Masuk
                </Link>
                <Link
                  href="/register"
                  onClick={() => setMobileMenuOpen(false)}
                  className="flex items-center justify-center py-2.5 rounded-xl text-xs font-bold bg-white text-telu-700"
                >
                  Daftar
                </Link>
              </div>
            )}
          </div>
        </div>
      )}
    </header>
  );
}
