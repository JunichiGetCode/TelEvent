import React from 'react';
import Link from 'next/link';
import { Calendar, Tag, User, ArrowRight } from 'lucide-react';
import StatusBadge from './StatusBadge';

interface EventCardProps {
  event: {
    id: number;
    title: string;
    type: string;
    start_date?: string | null;
    end_date?: string | null;
    poster?: string | null;
    status: string;
    user?: {
      name: string;
      avatar?: string | null;
    };
  };
  showStatus?: boolean;
}

const typeGradients: Record<string, string> = {
  Exhibition: 'from-blue-600 to-indigo-800',
  Festival: 'from-amber-500 to-rose-600',
  Lomba: 'from-purple-600 to-pink-600',
  Seminar: 'from-emerald-600 to-teal-800',
  Webinar: 'from-cyan-600 to-blue-700',
};

export default function EventCard({ event, showStatus = false }: EventCardProps) {
  const gradient = typeGradients[event.type] || 'from-telu-600 to-telu-900';

  const formatDate = (dateStr?: string | null) => {
    if (!dateStr) return 'Tanggal belum ditentukan';
    const d = new Date(dateStr);
    return d.toLocaleDateString('id-ID', {
      day: 'numeric',
      month: 'short',
      year: 'numeric',
    });
  };

  return (
    <div className="group relative flex flex-col bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden">
      {/* Banner / Poster Section */}
      <div className={`relative h-48 w-full overflow-hidden bg-gradient-to-br ${gradient}`}>
        {event.poster ? (
          <img
            src={event.poster}
            alt={event.title}
            className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
          />
        ) : (
          <div className="absolute inset-0 flex flex-col items-center justify-center p-6 text-center">
            <span className="text-white/40 text-5xl font-black mb-2 select-none">
              {event.type.charAt(0)}
            </span>
            <span className="text-white font-bold text-lg drop-shadow line-clamp-2 px-2">
              {event.title}
            </span>
          </div>
        )}

        {/* Gradient Overlay */}
        <div className="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-black/20" />

        {/* Type Badge */}
        <div className="absolute top-3 left-3">
          <span className="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold tracking-wide uppercase bg-black/40 backdrop-blur-md text-white border border-white/20">
            <Tag className="w-3 h-3 text-telu-300" />
            {event.type}
          </span>
        </div>

        {/* Status Badge (if enabled) */}
        {showStatus && (
          <div className="absolute top-3 right-3">
            <StatusBadge status={event.status} size="sm" />
          </div>
        )}
      </div>

      {/* Content Section */}
      <div className="flex-1 p-5 flex flex-col justify-between">
        <div>
          <div className="flex items-center gap-2 text-xs font-medium text-slate-500 mb-2">
            <Calendar className="w-3.5 h-3.5 text-telu-600" />
            <span>
              {formatDate(event.start_date)}
              {event.end_date && event.end_date !== event.start_date && (
                <> - {formatDate(event.end_date)}</>
              )}
            </span>
          </div>

          <h3 className="font-bold text-slate-900 text-lg group-hover:text-telu-600 transition-colors line-clamp-2 leading-snug">
            {event.title}
          </h3>
        </div>

        <div className="mt-5 pt-4 border-t border-slate-100 flex items-center justify-between">
          <div className="flex items-center gap-2 text-xs text-slate-500">
            {event.user?.avatar ? (
              <img
                src={event.user.avatar.startsWith('http') || event.user.avatar.startsWith('/') ? event.user.avatar : `/uploads/profile/${event.user.avatar}`}
                alt={event.user.name}
                className="w-5 h-5 rounded-full object-cover"
              />
            ) : (
              <div className="w-5 h-5 rounded-full bg-slate-100 flex items-center justify-center text-[10px] font-bold text-slate-600">
                {event.user?.name ? event.user.name.charAt(0).toUpperCase() : 'U'}
              </div>
            )}
            <span className="truncate max-w-[120px] font-medium">{event.user?.name || 'Panitia'}</span>
          </div>

          <Link
            href={`/events/${event.id}`}
            className="inline-flex items-center gap-1 text-xs font-bold text-telu-600 hover:text-telu-700 transition-colors"
          >
            Detail Acara
            <ArrowRight className="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform" />
          </Link>
        </div>
      </div>
    </div>
  );
}
