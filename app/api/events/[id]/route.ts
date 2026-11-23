import { NextResponse } from 'next/server';
import prisma from '@/lib/prisma';
import { getCurrentUser } from '@/lib/auth';
import { serializeData } from '@/lib/serialize';
import { saveUploadedFile } from '@/lib/upload';
import { getMockEventById, updateMockEvent, deleteMockEvent } from '@/lib/mockData';

export const dynamic = 'force-dynamic';

// GET /api/events/[id]
export async function GET(req: Request, { params }: { params: { id: string } }) {
  try {
    const numId = Number(params.id);

    try {
      const id = BigInt(params.id);
      const event = await prisma.event.findUnique({
        where: { id },
        include: {
          user: {
            select: {
              id: true,
              name: true,
              email: true,
              avatar: true,
              phone: true,
              role: true,
            },
          },
        },
      });

      if (event) {
        return NextResponse.json({ event: serializeData(event) });
      }
    } catch (dbError) {
      console.warn('DB error, checking mock store:', dbError);
    }

    // Mock fallback
    const mock = getMockEventById(numId);
    if (mock) {
      return NextResponse.json({ event: mock });
    }

    return NextResponse.json({ error: 'Event tidak ditemukan.' }, { status: 404 });
  } catch (error: any) {
    console.error('Error fetching event by id:', error);
    return NextResponse.json(
      { error: error?.message || 'Gagal memuat detail event.' },
      { status: 500 }
    );
  }
}

// PUT /api/events/[id] (Update event)
export async function PUT(req: Request, { params }: { params: { id: string } }) {
  try {
    const currentUser = await getCurrentUser();
    if (!currentUser) {
      return NextResponse.json({ error: 'Unauthorized' }, { status: 401 });
    }

    const numId = Number(params.id);
    const formData = await req.formData();
    const title = formData.get('title') as string;
    const type = formData.get('type') as string;
    const start_date = formData.get('start_date') as string;
    const end_date = formData.get('end_date') as string;
    const status = formData.get('status') as string;

    const dataToUpdate: any = {};
    if (title) dataToUpdate.title = title.trim();
    if (type) dataToUpdate.type = type.trim();
    if (start_date) dataToUpdate.start_date = start_date;
    if (end_date) dataToUpdate.end_date = end_date;
    if (currentUser.role === 'admin' && status) dataToUpdate.status = status;

    try {
      const id = BigInt(params.id);
      const updated = await prisma.event.update({
        where: { id },
        data: {
          ...dataToUpdate,
          start_date: start_date ? new Date(start_date) : undefined,
          end_date: end_date ? new Date(end_date) : undefined,
        },
      });

      return NextResponse.json({
        success: true,
        message: 'Event berhasil diperbarui.',
        event: serializeData(updated),
      });
    } catch (dbError) {
      console.warn('DB update failed, updating mock store:', dbError);
      const mockUpdated = updateMockEvent(numId, dataToUpdate);
      if (mockUpdated) {
        return NextResponse.json({
          success: true,
          message: 'Event berhasil diperbarui (Mode Preview).',
          event: mockUpdated,
        });
      }
      return NextResponse.json({ error: 'Event tidak ditemukan.' }, { status: 404 });
    }
  } catch (error: any) {
    console.error('Error updating event:', error);
    return NextResponse.json(
      { error: error?.message || 'Gagal memperbarui event.' },
      { status: 500 }
    );
  }
}

// DELETE /api/events/[id]
export async function DELETE(req: Request, { params }: { params: { id: string } }) {
  try {
    const currentUser = await getCurrentUser();
    if (!currentUser) {
      return NextResponse.json({ error: 'Unauthorized' }, { status: 401 });
    }

    const numId = Number(params.id);

    try {
      const id = BigInt(params.id);
      await prisma.event.delete({ where: { id } });
      return NextResponse.json({ success: true, message: 'Event berhasil dihapus.' });
    } catch (dbError) {
      console.warn('DB delete failed, deleting from mock store:', dbError);
      const deleted = deleteMockEvent(numId);
      if (deleted) {
        return NextResponse.json({ success: true, message: 'Event berhasil dihapus (Mode Preview).' });
      }
      return NextResponse.json({ error: 'Event tidak ditemukan.' }, { status: 404 });
    }
  } catch (error: any) {
    console.error('Error deleting event:', error);
    return NextResponse.json(
      { error: error?.message || 'Gagal menghapus event.' },
      { status: 500 }
    );
  }
}
