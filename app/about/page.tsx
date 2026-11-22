import React from 'react';
import Link from 'next/link';
import { Calendar, CheckCircle2, Shield, Users, Sparkles, ArrowRight } from 'lucide-react';

export default function AboutPage() {
  const faqs = [
    {
      q: 'Siapa saja yang dapat mengajukan proposal di TelEVent?',
      a: 'Seluruh perwakilan Himpunan Mahasiswa (HIMA), Unit Kegiatan Mahasiswa (UKM), Komunitas Resmi, maupun kepanitiaan ad-hoc yang telah terdaftar di bawah naungan Direktorat Kemahasiswaan Telkom University.',
    },
    {
      q: 'Dokumen apa saja yang wajib dilampirkan?',
      a: 'Tiga dokumen utama yang wajib disertakan dalam format PDF/Word adalah: Dokumen Proposal Kegiatan, Jadwal/Timeline Pelaksanaan, dan Rencana Anggaran Biaya (RAB).',
    },
    {
      q: 'Berapa lama proses review oleh Admin?',
      a: 'Proses verifikasi dan validasi proposal oleh admin umumnya memakan waktu 1-3 hari kerja tergantung kelengkapan berkas yang diunggah.',
    },
    {
      q: 'Apakah acara otomatis dipublikasikan ke katalog setelah disetujui?',
      a: 'Ya, seluruh acara yang telah disetujui (Approved) akan langsung muncul di katalog publik dan siap disosialisasikan kepada mahasiswa.',
    },
  ];

  return (
    <div className="min-h-screen bg-slate-50 py-16">
      <div className="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-16">
        {/* Hero section */}
        <div className="text-center max-w-3xl mx-auto">
          <div className="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-telu-100 text-telu-700 text-xs font-bold uppercase tracking-wider mb-4">
            <Sparkles className="w-3.5 h-3.5" />
            Tentang TelEVent
          </div>
          <h1 className="text-4xl sm:text-5xl font-black text-slate-900 tracking-tight leading-tight">
            Digitalisasi & Transparansi Kegiatan Mahasiswa Telkom University
          </h1>
          <p className="text-base text-slate-600 mt-5 leading-relaxed">
            TelEVent hadir sebagai solusi modern untuk mengatasi birokrasi pengajuan kegiatan kampus, memudahkan pelacakan anggaran, dan memperluas jangkauan publikasi acara.
          </p>
        </div>

        {/* Feature Grid */}
        <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
          <div className="p-8 rounded-3xl bg-white border border-slate-200/80 shadow-sm flex flex-col">
            <div className="w-12 h-12 rounded-2xl bg-telu-50 text-telu-600 flex items-center justify-center font-bold mb-6">
              <Calendar className="w-6 h-6" />
            </div>
            <h3 className="text-lg font-bold text-slate-900 mb-2">Penjadwalan Terintegrasi</h3>
            <p className="text-slate-500 text-xs leading-relaxed">
              Mencegah bentrok jadwal antar himpunan dan unit kegiatan dengan direktori kalender acara terpusat.
            </p>
          </div>

          <div className="p-8 rounded-3xl bg-white border border-slate-200/80 shadow-sm flex flex-col">
            <div className="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold mb-6">
              <Shield className="w-6 h-6" />
            </div>
            <h3 className="text-lg font-bold text-slate-900 mb-2">Standarisasi Berkas</h3>
            <p className="text-slate-500 text-xs leading-relaxed">
              Penyimpanan berkas proposal, rundown, dan RAB yang aman, tersusun rapi, dan mudah diunduh verifikator.
            </p>
          </div>

          <div className="p-8 rounded-3xl bg-white border border-slate-200/80 shadow-sm flex flex-col">
            <div className="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold mb-6">
              <Users className="w-6 h-6" />
            </div>
            <h3 className="text-lg font-bold text-slate-900 mb-2">Kolaborasi Cepat</h3>
            <p className="text-slate-500 text-xs leading-relaxed">
              Komunikasi status approval yang transparan antara panitia mahasiswa dan admin kemahasiswaan kampus.
            </p>
          </div>
        </div>

        {/* FAQs */}
        <div className="bg-white rounded-3xl p-8 sm:p-12 border border-slate-200/80 shadow-sm">
          <div className="text-center max-w-xl mx-auto mb-10">
            <h2 className="text-2xl font-black text-slate-900">Pertanyaan yang Sering Diajukan (FAQ)</h2>
            <p className="text-xs text-slate-500 mt-2">
              Segala hal yang perlu kamu ketahui tentang alur kerja platform TelEVent.
            </p>
          </div>

          <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
            {faqs.map((faq, i) => (
              <div key={i} className="p-6 rounded-2xl bg-slate-50 border border-slate-100">
                <h4 className="font-bold text-slate-900 text-sm mb-2">{faq.q}</h4>
                <p className="text-xs text-slate-600 leading-relaxed">{faq.a}</p>
              </div>
            ))}
          </div>
        </div>

        {/* Bottom CTA */}
        <div className="p-10 rounded-3xl bg-gradient-to-r from-telu-700 to-telu-800 text-white text-center flex flex-col items-center">
          <h3 className="text-2xl font-black mb-3">Siap Mengadakan Acara?</h3>
          <p className="text-white/80 text-xs max-w-md mb-6">
            Masuk atau daftarkan akun kepanitiaanmu sekarang dan ajukan proposal acara pertamamu.
          </p>
          <Link
            href="/events/create"
            className="px-6 py-3 rounded-xl bg-white text-telu-700 text-xs font-bold hover:bg-amber-50 transition-colors shadow-lg flex items-center gap-2"
          >
            Ajukan Acara Baru
            <ArrowRight className="w-4 h-4" />
          </Link>
        </div>
      </div>
    </div>
  );
}
