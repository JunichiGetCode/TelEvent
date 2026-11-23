import { NextResponse } from 'next/server';
import prisma from '@/lib/prisma';
import { hashPassword, signToken, COOKIE_NAME } from '@/lib/auth';
import { serializeData } from '@/lib/serialize';
import { addMockUser, getMockUserByEmail } from '@/lib/mockData';

export async function POST(req: Request) {
  try {
    const { name, email, password, phone, role } = await req.json();

    if (!name || !email || !password) {
      return NextResponse.json(
        { error: 'Nama, email, dan password wajib diisi.' },
        { status: 400 }
      );
    }

    const cleanEmail = email.trim().toLowerCase();
    let createdUser: any = null;

    try {
      // Check if email already exists
      const existing = await prisma.user.findUnique({
        where: { email: cleanEmail },
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
          email: cleanEmail,
          password: hashedPassword,
          phone: phone ? phone.trim() : null,
          role: role === 'admin' ? 'panitia' : role || 'panitia',
        },
      });

      const userSerialized = serializeData(newUser);
      createdUser = {
        id: userSerialized.id,
        name: userSerialized.name,
        email: userSerialized.email,
        role: userSerialized.role,
      };
    } catch (dbError) {
      console.warn('DB error on register, falling back to mock user store:', dbError);
      // Fallback for Vercel preview without MySQL
      const mockExists = getMockUserByEmail(cleanEmail);
      if (mockExists) {
        return NextResponse.json(
          { error: 'Email sudah terdaftar di sesi preview. Silakan langsung login.' },
          { status: 409 }
        );
      }
      const newMock = addMockUser({
        name: name.trim(),
        email: cleanEmail,
        role: role === 'admin' ? 'panitia' : role || 'panitia',
        phone: phone?.trim(),
      });
      createdUser = newMock;
    }

    const token = signToken({
      userId: createdUser.id,
      email: createdUser.email,
      role: createdUser.role,
      name: createdUser.name,
    });

    const response = NextResponse.json({
      success: true,
      message: 'Registrasi berhasil!',
      user: createdUser,
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
    console.error('Register error:', error);
    return NextResponse.json(
      { error: error?.message || 'Terjadi kesalahan pada server saat registrasi.' },
      { status: 500 }
    );
  }
}
