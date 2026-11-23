import { NextResponse } from 'next/server';
import prisma from '@/lib/prisma';
import { getCurrentUser } from '@/lib/auth';
import { serializeData } from '@/lib/serialize';
import { saveUploadedFile } from '@/lib/upload';
import { getMockEvents, addMockEvent } from '@/lib/mockData';

export const dynamic = 'force-dynamic';

// GET /api/events
export async function GET(req: Request) {
  try {
    const { searchParams } = new URL(req.url);
    const q = searchParams.get('q');
    const type = searchParams.get('type');
    const status = searchParams.get('status');
    const myEvents = searchParams.get('my');
    const limit = searchParams.get('limit') ? parseInt(searchParams.get('limit')!) : undefined;

    const currentUser = await getCurrentUser();

    const where: any = {};

    // Filter by my events if requested
    if (myEvents === 'true') {
      if (!currentUser) {
        return NextResponse.json({ error: 'Unauthorized' }, { status: 401 });
      }
      where.user_id = BigInt(currentUser.id);
    } else if (status) {
      where.status = status;
    } else {
      where.status = 'approved';
    }

    if (type && type !== 'all') {
      where.type = type;
    }

    if (q) {
      where.title = {
        contains: q,
      };
    }

    try {
      const events = await prisma.event.findMany({
        where,
        orderBy: { created_at: 'desc' },
        take: limit,
        include: {
          user: {
            select: {
              id: true,
              name: true,
              email: true,
              avatar: true,
              role: true,
            },
          },
        },
      });

      return NextResponse.json({ events: serializeData(events) });
    } catch (dbError) {
      console.warn('DB query failed, returning mock events for preview:', dbError);
      const mockResult = getMockEvents({
        status: myEvents === 'true' ? undefined : (status || 'approved'),
        type: type || undefined,
        q: q || undefined,
        userId: myEvents === 'true' ? currentUser?.id : undefined,
        limit,
      });
      return NextResponse.json({ events: mockResult });
    }
  } catch (error: any) {
    console.error('Error fetching events:', error);
    return NextResponse.json(
      { error: error?.message || 'Gagal memuat data event.' },
      { status: 500 }
    );
  }
}

// POST /api/events (Multipart form-data: upload event proposal)
export async function POST(req: Request) {
  try {
    const currentUser = await getCurrentUser();
    if (!currentUser) {
      return NextResponse.json(
        { error: 'Anda harus login terlebih dahulu untuk mengajukan acara.' },
        { status: 401 }
      );
    }

    const formData = await req.formData();
    const title = formData.get('title') as string;
    const type = formData.get('type') as string;
    const start_date = formData.get('start_date') as string;
    const end_date = formData.get('end_date') as string;

    const proposalFile = formData.get('proposal') as File | null;
    const timelineFile = formData.get('timeline') as File | null;
    const budgetingFile = formData.get('budgeting') as File | null;
    const posterFile = formData.get('poster') as File | null;
    const otherDataFile = formData.get('other_data') as File | null;

    if (!title || !type) {
      return NextResponse.json(
        { error: 'Nama kegiatan dan jenis acara wajib diisi.' },
        { status: 400 }
      );
    }

    if (!proposalFile || !timelineFile || !budgetingFile) {
      return NextResponse.json(
        { error: 'Dokumen wajib (Proposal, Timeline, dan Budgeting) harus diunggah.' },
        { status: 400 }
      );
    }

    // Save files
    const proposalPath = await saveUploadedFile(proposalFile, 'proposals');
    const timelinePath = await saveUploadedFile(timelineFile, 'timelines');
    const budgetingPath = await saveUploadedFile(budgetingFile, 'budgeting');

    let posterPath: string | null = null;
    if (posterFile && posterFile.size > 0) {
      posterPath = await saveUploadedFile(posterFile, 'posters');
    }

    let otherDataPath: string | null = null;
    if (otherDataFile && otherDataFile.size > 0) {
      otherDataPath = await saveUploadedFile(otherDataFile, 'other_data');
    }

    try {
      const newEvent = await prisma.event.create({
        data: {
          user_id: BigInt(currentUser.id),
          title: title.trim(),
          type: type.trim(),
          start_date: start_date ? new Date(start_date) : null,
          end_date: end_date ? new Date(end_date) : null,
          proposal: proposalPath,
          timeline: timelinePath,
          budgeting: budgetingPath,
          poster: posterPath,
          other_data: otherDataPath,
          status: 'pending',
        },
      });

      return NextResponse.json({
        success: true,
        message: 'Event berhasil diajukan! Menunggu review admin.',
        event: serializeData(newEvent),
      });
    } catch (dbError) {
      console.warn('DB insert failed, saving to mock store for preview:', dbError);
      const mockEvent = addMockEvent({
        user_id: Number(currentUser.id),
        title: title.trim(),
        type: type.trim(),
        start_date,
        end_date,
        proposal: proposalPath,
        timeline: timelinePath,
        budgeting: budgetingPath,
        poster: posterPath || undefined,
        other_data: otherDataPath,
        status: 'pending',
      });

      return NextResponse.json({
        success: true,
        message: 'Event berhasil diajukan (Mode Preview)! Menunggu review admin.',
        event: mockEvent,
      });
    }
  } catch (error: any) {
    console.error('Error creating event:', error);
    return NextResponse.json(
      { error: error?.message || 'Gagal menyimpan proposal acara.' },
      { status: 500 }
    );
  }
}
