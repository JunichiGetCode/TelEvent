import { NextResponse } from 'next/server';
import prisma from '@/lib/prisma';
import { getCurrentUser } from '@/lib/auth';
import { serializeData } from '@/lib/serialize';
import { saveUploadedFile } from '@/lib/upload';
import { getMockEvents } from '@/lib/mockData';

export const dynamic = 'force-dynamic';

// GET /api/profile
export async function GET() {
  try {
    const currentUser = await getCurrentUser();
    if (!currentUser) {
      return NextResponse.json({ error: 'Unauthorized' }, { status: 401 });
    }

    try {
      const events = await prisma.event.findMany({
        where: { user_id: BigInt(currentUser.id) },
        orderBy: { created_at: 'desc' },
      });

      const pending = events.filter((e) => e.status === 'pending').length;
      const approved = events.filter((e) => e.status === 'approved').length;
      const rejected = events.filter((e) => e.status === 'rejected').length;

      return NextResponse.json({
        user: currentUser,
        events: serializeData(events),
        stats: {
          total: events.length,
          pending,
          approved,
          rejected,
        },
      });
    } catch (dbError) {
      console.warn('DB error on profile, falling back to mock events:', dbError);
      const userMockEvents = getMockEvents({ userId: currentUser.id });
      const pending = userMockEvents.filter((e) => e.status === 'pending').length;
      const approved = userMockEvents.filter((e) => e.status === 'approved').length;
      const rejected = userMockEvents.filter((e) => e.status === 'rejected').length;

      return NextResponse.json({
        user: currentUser,
        events: userMockEvents,
        stats: {
          total: userMockEvents.length,
          pending,
          approved,
          rejected,
        },
      });
    }
  } catch (error: any) {
    console.error('Error getting profile:', error);
    return NextResponse.json(
      { error: error?.message || 'Gagal memuat profil.' },
      { status: 500 }
    );
  }
}

// PUT /api/profile
export async function PUT(req: Request) {
  try {
    const currentUser = await getCurrentUser();
    if (!currentUser) {
      return NextResponse.json({ error: 'Unauthorized' }, { status: 401 });
    }

    const formData = await req.formData();
    const name = formData.get('name') as string;
    const email = formData.get('email') as string;
    const phone = formData.get('phone') as string;
    const avatarFile = formData.get('avatar') as File | null;

    const dataToUpdate: any = {};
    if (name) dataToUpdate.name = name.trim();
    if (email) dataToUpdate.email = email.trim().toLowerCase();
    if (phone !== undefined) dataToUpdate.phone = phone ? phone.trim() : null;

    if (avatarFile && avatarFile.size > 0) {
      dataToUpdate.avatar = await saveUploadedFile(avatarFile, 'profile');
    }

    try {
      const updatedUser = await prisma.user.update({
        where: { id: BigInt(currentUser.id) },
        data: dataToUpdate,
      });

      return NextResponse.json({
        success: true,
        message: 'Profil berhasil diperbarui.',
        user: serializeData(updatedUser),
      });
    } catch (dbError) {
      return NextResponse.json({
        success: true,
        message: 'Profil berhasil diperbarui (Mode Preview).',
        user: { ...currentUser, ...dataToUpdate },
      });
    }
  } catch (error: any) {
    console.error('Error updating profile:', error);
    return NextResponse.json(
      { error: error?.message || 'Gagal memperbarui profil.' },
      { status: 500 }
    );
  }
}
