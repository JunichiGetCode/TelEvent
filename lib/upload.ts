import fs from 'fs';
import path from 'path';

export async function saveUploadedFile(file: File, folderName: string): Promise<string> {
  const bytes = await file.arrayBuffer();
  const buffer = Buffer.from(bytes);

  // Target directory inside public/uploads/[folderName]
  const uploadDir = path.join(process.cwd(), 'public', 'uploads', folderName);
  if (!fs.existsSync(uploadDir)) {
    fs.mkdirSync(uploadDir, { recursive: true });
  }

  // Generate safe unique filename
  const ext = path.extname(file.name) || '';
  const baseName = path.basename(file.name, ext).replace(/[^a-zA-Z0-9-_]/g, '_');
  const uniqueName = `${Date.now()}_${baseName}${ext}`;
  const filePath = path.join(uploadDir, uniqueName);

  await fs.promises.writeFile(filePath, buffer);

  // Return relative web path
  return `/uploads/${folderName}/${uniqueName}`;
}
