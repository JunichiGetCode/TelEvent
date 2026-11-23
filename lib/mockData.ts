// In-memory mock store for Vercel preview deployment
// Automatically used when MySQL connection is unavailable or unconfigured

export interface MockUser {
  id: number;
  name: string;
  email: string;
  role: string;
  phone?: string;
  avatar?: string;
  created_at?: string;
}

export interface MockEvent {
  id: number;
  user_id: number;
  type: string;
  title: string;
  start_date: string;
  end_date: string;
  proposal: string;
  poster: string;
  timeline: string;
  budgeting: string;
  other_data?: string | null;
  status: 'pending' | 'approved' | 'rejected';
  created_at: string;
  updated_at: string;
  user?: {
    name: string;
    email?: string;
    avatar?: string;
    phone?: string;
  };
}

const INITIAL_USERS: MockUser[] = [
  {
    id: 1,
    name: 'BEM Telkom University',
    email: 'panitia@telkomuniversity.ac.id',
    role: 'panitia',
    phone: '081234567890',
    avatar: null as any,
    created_at: new Date('2026-01-01').toISOString(),
  },
  {
    id: 2,
    name: 'Direktorat Kemahasiswaan',
    email: 'admin@telkomuniversity.ac.id',
    role: 'admin',
    phone: '081298765432',
    avatar: null as any,
    created_at: new Date('2026-01-01').toISOString(),
  },
  {
    id: 3,
    name: 'Administrator Utama',
    email: 'admin@login.com',
    role: 'admin',
    phone: '081211223344',
    avatar: null as any,
    created_at: new Date('2026-01-01').toISOString(),
  },
];

const INITIAL_EVENTS: MockEvent[] = [
  {
    id: 101,
    user_id: 1,
    type: 'Seminar',
    title: 'Telkom Tech Innovation Summit 2026',
    start_date: '2026-12-05',
    end_date: '2026-12-06',
    proposal: '/storage/proposals/45REilJF9iN2IJLV9ayS7AMXo3uDGJfhMHGjxonT.pdf',
    poster: '/storage/posters/8JlKNsNqtkmlayp13SWkgVAxZ4FJRWCki2FDqK85.jpg',
    timeline: '/storage/timelines/1eHJadVLyvBV6JxkitNSLN373F64JiY2aSWJR9ZF.pdf',
    budgeting: '/storage/budgeting/1i2gfGG4GiosV2we3KrfallWkwptY50VUnqlpa',
    status: 'approved',
    created_at: new Date('2026-11-10').toISOString(),
    updated_at: new Date('2026-11-11').toISOString(),
    user: {
      name: 'BEM Telkom University',
      email: 'panitia@telkomuniversity.ac.id',
      phone: '081234567890',
    },
  },
  {
    id: 102,
    user_id: 1,
    type: 'Webinar',
    title: 'AI & Machine Learning Career Preparation',
    start_date: '2026-12-10',
    end_date: '2026-12-10',
    proposal: '/storage/proposals/4lU1pIAJZa65ovwsj8sPKFROduf5hdJOy6c3J2Q3.pdf',
    poster: '/storage/posters/dt8DKBmZtDkIe7qLOmja8V5pIfX6J0b8FtNaMAKb.png',
    timeline: '/storage/timelines/257S6tqUmRWUrRds33Wur9MHE8SqGaI4hy5Ddgue.pdf',
    budgeting: '/storage/budgeting/1i2gfGG4GiosV2we3KrfallWkwptY50VUnqlpa',
    status: 'approved',
    created_at: new Date('2026-11-12').toISOString(),
    updated_at: new Date('2026-11-13').toISOString(),
    user: {
      name: 'HIMA Informatika Tel-U',
      email: 'hima.if@telkomuniversity.ac.id',
      phone: '081345678901',
    },
  },
  {
    id: 103,
    user_id: 1,
    type: 'Lomba',
    title: 'Telkom National Hackathon & Data Quest',
    start_date: '2026-12-18',
    end_date: '2026-12-20',
    proposal: '/storage/proposals/ASXnF86fVErHFyIqAum7SNzgTSp2C6Y3SoOrksoC.pdf',
    poster: '/storage/posters/EdGPC8NtvooZH6VHZNDhcCSQENNnf8wPTLGbSL8d.png',
    timeline: '/storage/timelines/65nKzCkvpvbNqYmhok8UnXsVicEOQQDtBYMw9qvk.pdf',
    budgeting: '/storage/budgeting/1i2gfGG4GiosV2we3KrfallWkwptY50VUnqlpa',
    status: 'approved',
    created_at: new Date('2026-11-14').toISOString(),
    updated_at: new Date('2026-11-15').toISOString(),
    user: {
      name: 'UKM Riset & Rekayasa',
      email: 'ukm.rr@telkomuniversity.ac.id',
      phone: '081456789012',
    },
  },
  {
    id: 104,
    user_id: 1,
    type: 'Festival',
    title: 'Festival Budaya Nusantara Telkom University',
    start_date: '2026-12-22',
    end_date: '2026-12-23',
    proposal: '/storage/proposals/DSkhA7Ggel6V9kmX3AFpkh2bVUiW35yFwN1LvwoH.pdf',
    poster: '/storage/posters/f1pnOt1t6SUvSj5trMFLflov03vGrTITvFHRF8t8.png',
    timeline: '/storage/timelines/LnLnn4ASiJTaEY2KBlPZyI36cLKrnZSX7OA1m98B.pdf',
    budgeting: '/storage/budgeting/1i2gfGG4GiosV2we3KrfallWkwptY50VUnqlpa',
    status: 'approved',
    created_at: new Date('2026-11-15').toISOString(),
    updated_at: new Date('2026-11-16').toISOString(),
    user: {
      name: 'BEM Kema Telkom University',
      email: 'kema@telkomuniversity.ac.id',
      phone: '081567890123',
    },
  },
  {
    id: 105,
    user_id: 1,
    type: 'Exhibition',
    title: 'Exhibition Karya Inovasi & Tugas Akhir Mahasiswa',
    start_date: '2026-12-28',
    end_date: '2026-12-29',
    proposal: '/storage/proposals/JaPHM0HR6OvAzM7ngP9ewtH3PYM73LKJGpVjjUUM.pdf',
    poster: '/storage/posters/fX9pkU7sxe15ynoexfLGMh7xcMXAQr3SJPDapaXj.jpg',
    timeline: '/storage/timelines/TpR5SQBuhceIiWrn2rEMztZyjD77U0AT7N1bpeQz.pdf',
    budgeting: '/storage/budgeting/1i2gfGG4GiosV2we3KrfallWkwptY50VUnqlpa',
    status: 'approved',
    created_at: new Date('2026-11-16').toISOString(),
    updated_at: new Date('2026-11-17').toISOString(),
    user: {
      name: 'Fakultas Informatika',
      email: 'fif@telkomuniversity.ac.id',
      phone: '081678901234',
    },
  },
  {
    id: 106,
    user_id: 1,
    type: 'Seminar',
    title: 'Cybersecurity Red Teaming Hands-on Workshop',
    start_date: '2027-01-10',
    end_date: '2027-01-11',
    proposal: '/storage/proposals/LEnRigwETq5TWALVsmP84XBM1Rf9swlXD8xGgrmF.pdf',
    poster: '/storage/posters/g6x0hwPV598cMFO41GZEqfhgzZrKe4X2xhZeeQ81.png',
    timeline: '/storage/timelines/Z5H3nwO4ThIkTOhBZz8ewHxcDoURK71EHVsYhNvT.pdf',
    budgeting: '/storage/budgeting/1i2gfGG4GiosV2we3KrfallWkwptY50VUnqlpa',
    status: 'approved',
    created_at: new Date('2026-11-17').toISOString(),
    updated_at: new Date('2026-11-18').toISOString(),
    user: {
      name: 'Cyber Security Community (CSC)',
      email: 'csc@telkomuniversity.ac.id',
      phone: '081789012345',
    },
  },
  {
    id: 107,
    user_id: 1,
    type: 'Lomba',
    title: 'Telkom National UI/UX & Product Design Arena',
    start_date: '2027-01-15',
    end_date: '2027-01-17',
    proposal: '/storage/proposals/UJNrpEesJoDnzIhpvUMgfcDAXt73ikcSMHlNTQKG.pdf',
    poster: '/storage/posters/gYQNm7XpqdqgtcrN68Wv2xJpX0V6cZG82Ywv9ImT.png',
    timeline: '/storage/timelines/bM4f6fCn7WKt9oRFzsqBoW8mS5aNl6dRRO2RLvFM.pdf',
    budgeting: '/storage/budgeting/1i2gfGG4GiosV2we3KrfallWkwptY50VUnqlpa',
    status: 'pending',
    created_at: new Date('2026-11-18').toISOString(),
    updated_at: new Date('2026-11-18').toISOString(),
    user: {
      name: 'HIMA Desain Komunikasi Visual',
      email: 'hima.dkv@telkomuniversity.ac.id',
      phone: '081890123456',
    },
  },
  {
    id: 108,
    user_id: 1,
    type: 'Webinar',
    title: 'Strategi Membangun Startup Digital dari Bangku Kuliah',
    start_date: '2027-01-20',
    end_date: '2027-01-20',
    proposal: '/storage/proposals/XMTgQsmB5i8zjI6SsJ5qYhnaFif1hpQYZiQWOYfR.pdf',
    poster: '/storage/posters/JlQ0wFDxQrrF39iyHqgKG4RRggET6HsM1MPviUqR.png',
    timeline: '/storage/timelines/jsDBo9ojat2749nL3eSq8MObEJP5du2DMI707wYB.pdf',
    budgeting: '/storage/budgeting/1i2gfGG4GiosV2we3KrfallWkwptY50VUnqlpa',
    status: 'pending',
    created_at: new Date('2026-11-19').toISOString(),
    updated_at: new Date('2026-11-19').toISOString(),
    user: {
      name: 'Bandung Techno Park Student Chapter',
      email: 'btp.sc@telkomuniversity.ac.id',
      phone: '081901234567',
    },
  },
  {
    id: 109,
    user_id: 1,
    type: 'Festival',
    title: 'Bandung Student Indie Music & Art Festival 2027',
    start_date: '2027-01-25',
    end_date: '2027-01-26',
    proposal: '/storage/proposals/Y2NnZg1VmMnuwgetRVnEIhVJTSxwYsSZoxqPq6Bj.pdf',
    poster: '/storage/posters/l9jFEhoV8s687AOHnhWZL7BHfNPIW0YBbNSmrzrJ.png',
    timeline: '/storage/timelines/oaXyw9EktmSVzyvkeMfhy9QatjNSL0JkYKt1V8Mk.pdf',
    budgeting: '/storage/budgeting/1i2gfGG4GiosV2we3KrfallWkwptY50VUnqlpa',
    status: 'pending',
    created_at: new Date('2026-11-20').toISOString(),
    updated_at: new Date('2026-11-20').toISOString(),
    user: {
      name: 'UKM Musik Telkom University',
      email: 'ukm.musik@telkomuniversity.ac.id',
      phone: '081912345678',
    },
  },
];

// Attach to globalThis to retain state across API calls in the same serverless container
const globalStore = globalThis as unknown as {
  __mockUsers__?: MockUser[];
  __mockEvents__?: MockEvent[];
};

if (!globalStore.__mockUsers__) {
  globalStore.__mockUsers__ = [...INITIAL_USERS];
}

if (!globalStore.__mockEvents__) {
  globalStore.__mockEvents__ = [...INITIAL_EVENTS];
}

export const mockUsers = globalStore.__mockUsers__;
export const mockEvents = globalStore.__mockEvents__;

export function getMockEvents(params?: {
  status?: string;
  type?: string;
  q?: string;
  userId?: number;
  limit?: number;
}) {
  let list = [...globalStore.__mockEvents__!];

  if (params?.status && params.status !== 'all') {
    list = list.filter((e) => e.status === params.status);
  }

  if (params?.type && params.type !== 'all') {
    list = list.filter((e) => e.type.toLowerCase() === params.type!.toLowerCase());
  }

  if (params?.q) {
    const qLower = params.q.toLowerCase();
    list = list.filter(
      (e) =>
        e.title.toLowerCase().includes(qLower) ||
        (e.user?.name && e.user.name.toLowerCase().includes(qLower))
    );
  }

  if (params?.userId) {
    list = list.filter((e) => e.user_id === Number(params.userId));
  }

  list.sort((a, b) => new Date(b.created_at).getTime() - new Date(a.created_at).getTime());

  if (params?.limit) {
    list = list.slice(0, params.limit);
  }

  return list;
}

export function getMockEventById(id: number) {
  return globalStore.__mockEvents__!.find((e) => e.id === Number(id)) || null;
}

export function addMockEvent(eventData: Partial<MockEvent> & { title: string; type: string; user_id: number }) {
  const newId = Date.now();
  const user = globalStore.__mockUsers__!.find((u) => u.id === Number(eventData.user_id)) || {
    name: 'Panitia Telkom University',
    email: 'panitia@telkomuniversity.ac.id',
  };

  const newEvent: MockEvent = {
    id: newId,
    user_id: eventData.user_id,
    type: eventData.type,
    title: eventData.title,
    start_date: eventData.start_date || new Date().toISOString().split('T')[0],
    end_date: eventData.end_date || new Date().toISOString().split('T')[0],
    proposal: eventData.proposal || '/storage/proposals/45REilJF9iN2IJLV9ayS7AMXo3uDGJfhMHGjxonT.pdf',
    poster: eventData.poster || '/storage/posters/8JlKNsNqtkmlayp13SWkgVAxZ4FJRWCki2FDqK85.jpg',
    timeline: eventData.timeline || '/storage/timelines/1eHJadVLyvBV6JxkitNSLN373F64JiY2aSWJR9ZF.pdf',
    budgeting: eventData.budgeting || '/storage/budgeting/1i2gfGG4GiosV2we3KrfallWkwptY50VUnqlpa',
    other_data: eventData.other_data || null,
    status: (eventData.status as any) || 'pending',
    created_at: new Date().toISOString(),
    updated_at: new Date().toISOString(),
    user: {
      name: user.name,
      email: user.email,
    },
  };

  globalStore.__mockEvents__!.unshift(newEvent);
  return newEvent;
}

export function updateMockEventStatus(id: number, status: 'pending' | 'approved' | 'rejected') {
  const event = globalStore.__mockEvents__!.find((e) => e.id === Number(id));
  if (event) {
    event.status = status;
    event.updated_at = new Date().toISOString();
    return event;
  }
  return null;
}

export function updateMockEvent(id: number, updates: Partial<MockEvent>) {
  const event = globalStore.__mockEvents__!.find((e) => e.id === Number(id));
  if (event) {
    Object.assign(event, updates, { updated_at: new Date().toISOString() });
    return event;
  }
  return null;
}

export function deleteMockEvent(id: number) {
  const index = globalStore.__mockEvents__!.findIndex((e) => e.id === Number(id));
  if (index !== -1) {
    globalStore.__mockEvents__!.splice(index, 1);
    return true;
  }
  return false;
}

export function getMockUserByEmail(email: string) {
  const cleanEmail = email.trim().toLowerCase();
  return globalStore.__mockUsers__!.find((u) => u.email.toLowerCase() === cleanEmail) || null;
}

export function getMockUserById(id: number) {
  return globalStore.__mockUsers__!.find((u) => u.id === Number(id)) || null;
}

export function addMockUser(user: { name: string; email: string; role?: string; phone?: string }) {
  const existing = getMockUserByEmail(user.email);
  if (existing) return existing;

  const newUser: MockUser = {
    id: Date.now(),
    name: user.name,
    email: user.email.trim().toLowerCase(),
    role: user.role || 'panitia',
    phone: user.phone || '',
    avatar: null as any,
    created_at: new Date().toISOString(),
  };

  globalStore.__mockUsers__!.push(newUser);
  return newUser;
}
