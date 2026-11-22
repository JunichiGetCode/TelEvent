import jwt from 'jsonwebtoken';
import bcrypt from 'bcryptjs';
import { cookies } from 'next/headers';
import prisma from './prisma';
import { serializeData } from './serialize';

const JWT_SECRET = process.env.JWT_SECRET || 'televent_default_secret_key_change_in_production';
const COOKIE_NAME = 'televent_token';

export interface TokenPayload {
  userId: number;
  email: string;
  role: string;
  name: string;
}

export function hashPassword(password: string): string {
  return bcrypt.hashSync(password, 10);
}

export function comparePassword(password: string, hash: string): boolean {
  if (!password || !hash) return false;
  // Laravel uses $2y$ prefix for bcrypt which bcryptjs can read if normalized to $2a$ or directly
  const normalizedHash = hash.replace(/^\$2y\$/, '$2a$');
  try {
    return bcrypt.compareSync(password, normalizedHash);
  } catch (err) {
    try {
      return bcrypt.compareSync(password, hash);
    } catch {
      return false;
    }
  }
}

export function signToken(payload: TokenPayload): string {
  return jwt.sign(payload, JWT_SECRET, { expiresIn: '7d' });
}

export function verifyToken(token: string): TokenPayload | null {
  try {
    return jwt.verify(token, JWT_SECRET) as TokenPayload;
  } catch (err) {
    return null;
  }
}

export async function getCurrentUser() {
  const cookieStore = cookies();
  const token = cookieStore.get(COOKIE_NAME)?.value;
  if (!token) return null;

  const payload = verifyToken(token);
  if (!payload) return null;

  try {
    const user = await prisma.user.findUnique({
      where: { id: BigInt(payload.userId) },
      select: {
        id: true,
        name: true,
        email: true,
        role: true,
        phone: true,
        avatar: true,
        created_at: true,
      },
    });

    if (!user) return null;
    return serializeData(user);
  } catch (error) {
    console.error('Error fetching current user:', error);
    return null;
  }
}

export { COOKIE_NAME };
