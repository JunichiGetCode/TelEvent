/**
 * Helper to normalize file paths stored in database.
 * If path was saved by Laravel (e.g. "proposals/xyz.pdf"), convert to "/storage/proposals/xyz.pdf".
 */
export function normalizeFilePath(filePath?: string | null): string | null {
  if (!filePath) return null;
  if (
    filePath.startsWith('http://') ||
    filePath.startsWith('https://') ||
    filePath.startsWith('/') ||
    filePath.startsWith('data:')
  ) {
    return filePath;
  }
  return `/storage/${filePath}`;
}

/**
 * Helper to recursively convert BigInt fields to numbers/strings
 * and Date fields to ISO strings so Next.js server components and
 * JSON.stringify never throw serialization errors.
 */
export function serializeData<T>(data: T): any {
  if (data === null || data === undefined) {
    return data;
  }

  if (typeof data === 'bigint') {
    return Number(data);
  }

  if (data instanceof Date) {
    return data.toISOString();
  }

  if (Array.isArray(data)) {
    return data.map((item) => serializeData(item));
  }

  if (typeof data === 'object') {
    const res: Record<string, any> = {};
    for (const [key, value] of Object.entries(data)) {
      // Normalize file fields on events or users
      if (['proposal', 'timeline', 'budgeting', 'poster', 'other_data', 'avatar'].includes(key) && typeof value === 'string') {
        res[key] = normalizeFilePath(value);
      } else {
        res[key] = serializeData(value);
      }
    }
    return res;
  }

  return data;
}
