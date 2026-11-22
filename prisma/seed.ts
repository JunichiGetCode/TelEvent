import { PrismaClient } from '@prisma/client';
import bcrypt from 'bcryptjs';

const prisma = new PrismaClient();

async function main() {
  console.log('Seeding database for TelEVent Next.js...');

  const passwordHash = bcrypt.hashSync('password123', 10);

  // 1. Create or update Admin
  const admin = await prisma.user.upsert({
    where: { email: 'admin@telkomuniversity.ac.id' },
    update: {},
    create: {
      name: 'Administrator Kemahasiswaan',
      email: 'admin@telkomuniversity.ac.id',
      password: passwordHash,
      role: 'admin',
      phone: '081234567890',
    },
  });

  // 2. Create or update Panitia sample user
  const panitia = await prisma.user.upsert({
    where: { email: 'panitia@telkomuniversity.ac.id' },
    update: {},
    create: {
      name: 'HIMA S1 Informatika',
      email: 'panitia@telkomuniversity.ac.id',
      password: passwordHash,
      role: 'panitia',
      phone: '089876543210',
    },
  });

  // 3. Create sample events if none exist
  const count = await prisma.event.count();
  if (count === 0) {
    await prisma.event.createMany({
      data: [
        {
          user_id: panitia.id,
          title: 'Telkom University National Hackathon 2026',
          type: 'Lomba',
          start_date: new Date('2026-12-10'),
          end_date: new Date('2026-12-12'),
          proposal: '/uploads/sample_proposal.pdf',
          timeline: '/uploads/sample_timeline.pdf',
          budgeting: '/uploads/sample_budget.pdf',
          status: 'approved',
        },
        {
          user_id: panitia.id,
          title: 'International Seminar on Artificial Intelligence & IoT',
          type: 'Seminar',
          start_date: new Date('2026-12-18'),
          end_date: new Date('2026-12-18'),
          proposal: '/uploads/sample_proposal.pdf',
          timeline: '/uploads/sample_timeline.pdf',
          budgeting: '/uploads/sample_budget.pdf',
          status: 'approved',
        },
        {
          user_id: panitia.id,
          title: 'Telkom Music & Art Festival 2026',
          type: 'Festival',
          start_date: new Date('2026-12-24'),
          end_date: new Date('2026-12-25'),
          proposal: '/uploads/sample_proposal.pdf',
          timeline: '/uploads/sample_timeline.pdf',
          budgeting: '/uploads/sample_budget.pdf',
          status: 'pending',
        },
        {
          user_id: panitia.id,
          title: 'Informatics Innovation & Project Exhibition',
          type: 'Exhibition',
          start_date: new Date('2026-12-28'),
          end_date: new Date('2026-12-29'),
          proposal: '/uploads/sample_proposal.pdf',
          timeline: '/uploads/sample_timeline.pdf',
          budgeting: '/uploads/sample_budget.pdf',
          status: 'approved',
        },
      ],
    });
    console.log('Sample events seeded!');
  }

  console.log('Seeding completed successfully!');
}

main()
  .catch((e) => {
    console.error(e);
    process.exit(1);
  })
  .finally(async () => {
    await prisma.$disconnect();
  });
