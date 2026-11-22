import { NextResponse } from 'next/server';
import prisma from '@/lib/prisma';
import { comparePassword, signToken, COOKIE_NAME } from '@/lib/auth';
import { serializeData } from '@/lib/serialize';

export async function POST(req: Request) {
  try {
    const { email, password } = await req.json();

    if (!email || !password) {
      return NextResponse.json(
        { error: 'Email dan password wajib diisi.' },
        { status: 400 }
      );
    }

    const user = await prisma.user.findUnique({
      where: { email: email.trim().toLowerCase() },
    });

    if (!user) {
      return NextResponse.json(
        { error: 'Email atau kata sandi tidak sesuai.' },
        { status: 401 }
      );
    }

    const isValid = comparePassword(password, user.password);
    if (!isValid) {
      return NextResponse.json(
        { error: 'Email atau kata sandi tidak sesuai.' },
        { status: 401 }
      );
    }

    const userSerialized = serializeData(user);

    const token = signToken({
      userId: userSerialized.id,
      email: userSerialized.email,
      role: userSerialized.role,
      name: userSerialized.name,
    });

    const response = NextResponse.json({
      success: true,
      message: 'Login berhasil!',
      user: {
        id: userSerialized.id,
        name: userSerialized.name,
        email: userSerialized.email,
        role: userSerialized.role,
        avatar: userSerialized.avatar,
      },
    });

    response.cookies.set(COOKIE_NAME, token, {
      httpOnly: true,
      secure: process.env.NODE_ENV === 'production',
      sameSite: 'lax',
      path: '/',
      maxAge: 7 * 24 * 60 * 60, // 7 days
    });

    return response;
  } catch (error: any) {
    console.error('Login error:', error);
    return NextResponse.json(
      { error: error?.message || 'Terjadi kesalahan pada server saat login.' },
      { status: 500 }
    );
  }
}
