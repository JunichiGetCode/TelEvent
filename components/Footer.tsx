import React from 'react';
import Link from 'next/link';
import { Calendar, Heart } from 'lucide-react';

export default function Footer() {
  return (
    <footer className="bg-slate-900 text-slate-400 text-sm mt-auto border-t border-slate-800">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div className="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
          {/* Brand Col */}
          <div className="space-y-3 md:col-span-1">
            <div className="flex items-center gap-2">
              <div className="w-8 h-8 rounded-lg bg-telu-600 flex items-center justify-center text-white">
                <Calendar className="w-4 h-4" />
              </div>
              <span className="text-xl font-black text-white">
                Tel<span className="text-amber-400">EVent</span>
              </span>
            </div>
            <p className="text-xs text-slate-400 leading-relaxed">
              Platform terintegrasi pengelolaan proposal, jadwal, anggaran, dan publikasi kegiatan kampus di lingkungan Telkom University.
            </p>
          </div>

          {/* Quick Links */}
          <div>
            <h4 className="text-white font-bold text-xs uppercase tracking-wider mb-3">Navigasi</h4>
            <ul className="space-y-2 text-xs">
              <li>
                <Link href="/" className="hover:text-white transition-colors">
                  Beranda
                </Link>
              </li>
              <li>
                <Link href="/events" className="hover:text-white transition-colors">
                  Katalog Acara
                </Link>
              </li>
              <li>
                <Link href="/events/create" className="hover:text-white transition-colors">
                  Ajukan Proposal Baru
                </Link>
              </li>
              <li>
                <Link href="/about" className="hover:text-white transition-colors">
                  Tentang Platform
                </Link>
              </li>
            </ul>
          </div>

          {/* Categories */}
          <div>
            <h4 className="text-white font-bold text-xs uppercase tracking-wider mb-3">Kategori Acara</h4>
            <ul className="space-y-2 text-xs">
              <li>
                <Link href="/events?type=Seminar" className="hover:text-white transition-colors">
                  Seminar & Workshop
                </Link>
              </li>
              <li>
                <Link href="/events?type=Webinar" className="hover:text-white transition-colors">
                  Webinar Daring
                </Link>
              </li>
              <li>
                <Link href="/events?type=Lomba" className="hover:text-white transition-colors">
                  Kompetisi & Lomba
                </Link>
              </li>
              <li>
                <Link href="/events?type=Festival" className="hover:text-white transition-colors">
                  Festival & Expo
                </Link>
              </li>
              <li>
                <Link href="/events?type=Exhibition" className="hover:text-white transition-colors">
                  Pameran Karya
                </Link>
              </li>
            </ul>
          </div>

          {/* Contact & Support */}
          <div>
            <h4 className="text-white font-bold text-xs uppercase tracking-wider mb-3">Kontak & Dukungan</h4>
            <p className="text-xs text-slate-400 leading-relaxed">
              Direktorat Kemahasiswaan & Bagian Kegiatan Kampus
              <br />
              Jl. Telekomunikasi No. 1, Terusan Buahbatu, Bandung, Jawa Barat.
            </p>
            <div className="mt-3">
              <span className="inline-block px-3 py-1 rounded-full text-[11px] font-semibold bg-telu-900/60 text-telu-300 border border-telu-700/50">
                Next.js Modern Architecture
              </span>
            </div>
          </div>
        </div>

        <div className="pt-8 border-t border-slate-800/80 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500 gap-4">
          <p>© {new Date().getFullYear()} TelEVent. All rights reserved.</p>
          <p className="flex items-center gap-1">
            Dibuat untuk ekosistem kemahasiswaan Telkom University.
          </p>
        </div>
      </div>
    </footer>
  );
}
