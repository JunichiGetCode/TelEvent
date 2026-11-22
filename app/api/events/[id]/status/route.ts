import { NextResponse } from 'next/server';
import prisma from '@/lib/prisma';
import { getCurrentUser } from '@/lib/auth';
import { serializeData } from '@/lib/serialize';

export async function POST(req: Request, { params }: { params: { id: string } }) {
  try {
    const currentUser = await getCurrentUser();
    if (!currentUser) {
      return NextResponse.json({ error: 'Unauthorized' }, { status: 401 });
    }

    if (currentUser.role !== 'admin') {
      return NextResponse.json({ error: 'Hanya admin yang dapat menyetujui atau menolak proposal.' }, { status: 403 });
    }

    const { status } = await req.json();
    if (!['pending', 'approved', 'rejected', 'draft', 'submitted'].includes(status)) {
      return NextResponse.json({ error: 'Status tidak valid.' }, { status: 400 });
    }

    const id = BigInt(params.id);
    const updated = await prisma.event.update({
      where: { id },
      data: { status },
    });

    return NextResponse.json({
      success: true,
      message: `Status proposal berhasil diubah menjadi "${status}".`,
      event: serializeData(updated),
    });
  } catch (error: any) {
    console.error('Error changing event status:', error);
    return NextResponse.json(
      { error: error?.message || 'Gagal mengubah status proposal.' },
      { status: 500 }
    );
  }
}
