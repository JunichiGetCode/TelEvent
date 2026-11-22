import { NextResponse } from 'next/server';
import prisma from '@/lib/prisma';
import { getCurrentUser } from '@/lib/auth';
import { serializeData } from '@/lib/serialize';
import { saveUploadedFile } from '@/lib/upload';

// GET /api/events/[id]
export async function GET(req: Request, { params }: { params: { id: string } }) {
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

    if (!event) {
      return NextResponse.json({ error: 'Event tidak ditemukan.' }, { status: 404 });
    }

    return NextResponse.json({ event: serializeData(event) });
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

    const id = BigInt(params.id);
    const existing = await prisma.event.findUnique({ where: { id } });
    if (!existing) {
      return NextResponse.json({ error: 'Event tidak ditemukan.' }, { status: 404 });
    }

    // Check ownership or admin
    const isOwner = Number(existing.user_id) === currentUser.id;
    const isAdmin = currentUser.role === 'admin';
    if (!isOwner && !isAdmin) {
      return NextResponse.json({ error: 'Anda tidak memiliki hak untuk mengubah event ini.' }, { status: 403 });
    }

    const formData = await req.formData();
    const title = formData.get('title') as string;
    const type = formData.get('type') as string;
    const start_date = formData.get('start_date') as string;
    const end_date = formData.get('end_date') as string;
    const status = formData.get('status') as string;

    const proposalFile = formData.get('proposal') as File | null;
    const timelineFile = formData.get('timeline') as File | null;
    const budgetingFile = formData.get('budgeting') as File | null;
    const posterFile = formData.get('poster') as File | null;
    const otherDataFile = formData.get('other_data') as File | null;

    const dataToUpdate: any = {};
    if (title) dataToUpdate.title = title.trim();
    if (type) dataToUpdate.type = type.trim();
    if (start_date) dataToUpdate.start_date = new Date(start_date);
    if (end_date) dataToUpdate.end_date = new Date(end_date);
    if (isAdmin && status) dataToUpdate.status = status;

    if (proposalFile && proposalFile.size > 0) {
      dataToUpdate.proposal = await saveUploadedFile(proposalFile, 'proposals');
    }
    if (timelineFile && timelineFile.size > 0) {
      dataToUpdate.timeline = await saveUploadedFile(timelineFile, 'timelines');
    }
    if (budgetingFile && budgetingFile.size > 0) {
      dataToUpdate.budgeting = await saveUploadedFile(budgetingFile, 'budgeting');
    }
    if (posterFile && posterFile.size > 0) {
      dataToUpdate.poster = await saveUploadedFile(posterFile, 'posters');
    }
    if (otherDataFile && otherDataFile.size > 0) {
      dataToUpdate.other_data = await saveUploadedFile(otherDataFile, 'other_data');
    }

    const updated = await prisma.event.update({
      where: { id },
      data: dataToUpdate,
    });

    return NextResponse.json({
      success: true,
      message: 'Event berhasil diperbarui.',
      event: serializeData(updated),
    });
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

    const id = BigInt(params.id);
    const existing = await prisma.event.findUnique({ where: { id } });
    if (!existing) {
      return NextResponse.json({ error: 'Event tidak ditemukan.' }, { status: 404 });
    }

    const isOwner = Number(existing.user_id) === currentUser.id;
    const isAdmin = currentUser.role === 'admin';
    if (!isOwner && !isAdmin) {
      return NextResponse.json({ error: 'Anda tidak memiliki akses untuk menghapus event ini.' }, { status: 403 });
    }

    await prisma.event.delete({ where: { id } });

    return NextResponse.json({ success: true, message: 'Event berhasil dihapus.' });
  } catch (error: any) {
    console.error('Error deleting event:', error);
    return NextResponse.json(
      { error: error?.message || 'Gagal menghapus event.' },
      { status: 500 }
    );
  }
}
