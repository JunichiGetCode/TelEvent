import { NextResponse } from 'next/server';
import prisma from '@/lib/prisma';
import { hashPassword, signToken, COOKIE_NAME } from '@/lib/auth';
import { serializeData } from '@/lib/serialize';

export async function POST(req: Request) {
  try {
    const { name, email, password, phone, role } = await req.json();

    if (!name || !email || !password) {
      return NextResponse.json(
        { error: 'Nama, email, dan password wajib diisi.' },
        { status: 400 }
      );
    }

    // Check if email already exists
    const existing = await prisma.user.findUnique({
      where: { email: email.trim().toLowerCase() },
    });

    if (existing) {
      return NextResponse.json(
        { error: 'Email sudah terdaftar. Silakan gunakan email lain atau login.' },
        { status: 409 }
      );
    }

    const hashedPassword = hashPassword(password);

    const newUser = await prisma.user.create({
      data: {
        name: name.trim(),
        email: email.trim().toLowerCase(),
        password: hashedPassword,
        phone: phone ? phone.trim() : null,
        role: role === 'admin' ? 'panitia' : role || 'panitia', // safety: only allow admin created via db or specified
      },
    });

    const userSerialized = serializeData(newUser);

    const token = signToken({
      userId: userSerialized.id,
      email: userSerialized.email,
      role: userSerialized.role,
      name: userSerialized.name,
    });

    const response = NextResponse.json({
      success: true,
      message: 'Registrasi berhasil!',
      user: {
        id: userSerialized.id,
        name: userSerialized.name,
        email: userSerialized.email,
        role: userSerialized.role,
      },
    });

    // Set HTTP-only cookie
    response.cookies.set(COOKIE_NAME, token, {
      httpOnly: true,
      secure: process.env.NODE_ENV === 'production',
      sameSite: 'lax',
      path: '/',
      maxAge: 7 * 24 * 60 * 60, // 7 days
    });

    return response;
  } catch (error: any) {
    console.error('Registration error:', error);
    return NextResponse.json(
      { error: error?.message || 'Terjadi kesalahan pada server saat registrasi.' },
      { status: 500 }
    );
  }
}
