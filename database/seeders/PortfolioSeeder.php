<?php

namespace Database\Seeders;

use App\Models\Education;
use App\Models\Experience;
use App\Models\PortfolioProfile;
use App\Models\Project;
use App\Models\Skill;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PortfolioSeeder extends Seeder
{
    public function run(): void
    {
        PortfolioProfile::query()->updateOrCreate(
            ['id' => 1],
            [
                'full_name' => "Muhammad Nafi'ur Rafi' Nurul Firdaus",
                'role' => 'Full-Stack Web Developer & Linux Enthusiast',
                'tagline' => 'Membangun aplikasi web modern yang cepat, skalabel, dan berorientasi pada pengalaman pengguna.',
                'bio' => 'Saya adalah seorang Full-Stack Web Developer yang berfokus pada pengembangan sistem berbasis Laravel, Livewire, dan ekosistem JavaScript modern. Terbiasa merancang arsitektur database yang bersih, API yang aman, serta antarmuka responsif menggunakan Tailwind CSS.',
                'location' => 'Malang, Jawa Timur, Indonesia',
                'available_for_work' => true,
                'cv_path' => 'uploads/cv/sample_cv.pdf',
                'email' => 'urnafi4@gmail.com',
                'linkedin_url' => 'https://linkedin.com/in/username',
                'github_url' => 'https://github.com/UrRafiFirdaus',
                'instagram_url' => 'https://instagram.com/naf.nf_',
            ]
        );

        if (Skill::count() === 0) {
            $skills = [
                ['name' => 'PHP', 'category' => 'Bahasa Pemrograman', 'icon_class' => 'devicon-php-plain colored', 'proficiency' => 92, 'sort_order' => 1],
                ['name' => 'JavaScript (ES6+)', 'category' => 'Bahasa Pemrograman', 'icon_class' => 'devicon-javascript-plain colored', 'proficiency' => 88, 'sort_order' => 2],
                ['name' => 'TypeScript', 'category' => 'Bahasa Pemrograman', 'icon_class' => 'devicon-typescript-plain colored', 'proficiency' => 80, 'sort_order' => 3],
                ['name' => 'SQL', 'category' => 'Bahasa Pemrograman', 'icon_class' => 'devicon-azuresqldatabase-plain colored', 'proficiency' => 88, 'sort_order' => 4],
                ['name' => 'Laravel', 'category' => 'Framework & Library', 'icon_class' => 'devicon-laravel-original colored', 'proficiency' => 95, 'sort_order' => 5],
                ['name' => 'Livewire', 'category' => 'Framework & Library', 'icon_class' => 'devicon-livewire-plain colored', 'proficiency' => 90, 'sort_order' => 6],
                ['name' => 'Tailwind CSS', 'category' => 'Framework & Library', 'icon_class' => 'devicon-tailwindcss-original colored', 'proficiency' => 94, 'sort_order' => 7],
                ['name' => 'Alpine.js', 'category' => 'Framework & Library', 'icon_class' => 'devicon-alpinejs-original colored', 'proficiency' => 86, 'sort_order' => 8],
                ['name' => 'Vue.js', 'category' => 'Framework & Library', 'icon_class' => 'devicon-vuejs-plain colored', 'proficiency' => 78, 'sort_order' => 9],
                ['name' => 'MySQL', 'category' => 'Database & Tools', 'icon_class' => 'devicon-mysql-original colored', 'proficiency' => 90, 'sort_order' => 10],
                ['name' => 'Git & GitHub', 'category' => 'Database & Tools', 'icon_class' => 'devicon-git-plain colored', 'proficiency' => 90, 'sort_order' => 11],
                ['name' => 'Docker', 'category' => 'Database & Tools', 'icon_class' => 'devicon-docker-plain colored', 'proficiency' => 75, 'sort_order' => 12],
            ];
            foreach ($skills as $skill) {
                Skill::create($skill);
            }
        }

        if (Experience::count() === 0) {
            Experience::create([
                'title' => 'Full-Stack Laravel Developer',
                'organization' => 'PT Solusi Digital Nusantara',
                'type' => 'Kerja',
                'location' => 'Remote / Jakarta',
                'start_date' => 'Jan 2024',
                'end_date' => null,
                'is_current' => true,
                'description' => 'Mengembangkan dan memelihara sistem ERP dan portal pelanggan berbasis Laravel 10 & Livewire. Mengoptimalkan query database sehingga waktu muat laporan berkurang hingga 45%.',
                'sort_order' => 1,
            ]);
            Experience::create([
                'title' => 'Backend Web Developer Intern',
                'organization' => 'CV Kreatif Teknologi',
                'type' => 'Magang',
                'location' => 'Malang, Jawa Timur',
                'start_date' => 'Jul 2023',
                'end_date' => 'Des 2023',
                'is_current' => false,
                'description' => 'Membangun RESTful API untuk aplikasi mobile inventaris gudang, integrasi payment gateway Midtrans, serta dokumentasi teknis API.',
                'sort_order' => 2,
            ]);
            Experience::create([
                'title' => 'Koordinator Divisi Riset & Teknologi',
                'organization' => 'Himpunan Mahasiswa Teknik Informatika',
                'type' => 'Organisasi',
                'location' => 'Kampus',
                'start_date' => 'Sep 2022',
                'end_date' => 'Agu 2023',
                'is_current' => false,
                'description' => 'Memimpin tim pengembangan website event tahunan kampus dan mengadakan bootcamp dasar pemrograman web untuk 120+ mahasiswa baru.',
                'sort_order' => 3,
            ]);
        }

        if (Education::count() === 0) {
            Education::create([
                'institution' => 'Universitas Negeri Malang',
                'degree' => 'S1 Teknik Informatika',
                'start_year' => '2025',
                'end_year' => '2024',
                'is_current' => false,
                'gpa' => '3.86 / 4.00',
                'description' => 'Fokus pada Rekayasa Perangkat Lunak dan Sistem Informasi. Tugas akhir mengenai arsitektur microservices pada platform e-learning.',
                'sort_order' => 1,
            ]);
            Education::create([
                'institution' => 'MAN Kota Mojokerto',
                'degree' => 'MIPA',
                'start_year' => '2022',
                'end_year' => '2025',
                'is_current' => false,
                'gpa' => null,
                'description' => 'Mempelajari dasar algoritma, pemrograman web (PHP, JavaScript), basis data relasional, dan manajemen proyek perangkat lunak.',
                'sort_order' => 2,
            ]);
        }

        if (Project::count() === 0) {
            Project::create([
                'title' => 'Sistem Manajemen Inventaris & POS Cloud',
                'slug' => Str::slug('Sistem Manajemen Inventaris & POS Cloud'),
                'short_description' => 'Aplikasi Point of Sale (POS) multi-cabang dengan pelacakan stok real-time, laporan laba rugi otomatis, dan cetak struk thermal.',
                'tech_stack' => ['Laravel 10', 'Livewire', 'Tailwind CSS', 'MySQL', 'Alpine.js'],
                'demo_url' => 'https://example.com',
                'github_url' => 'https://github.com/username/pos-cloud',
                'is_private' => false,
                'is_published' => true,
                'is_featured' => true,
                'sort_order' => 1,
            ]);
            Project::create([
                'title' => 'Portal Akademik & E-Learning Kampus',
                'slug' => Str::slug('Portal Akademik & E-Learning Kampus'),
                'short_description' => 'Platform pembelajaran daring lengkap dengan manajemen kelas, pengumpulan tugas, kuis interaktif berbatas waktu, dan rekap nilai otomatis.',
                'tech_stack' => ['Laravel', 'Tailwind CSS', 'Redis', 'MySQL'],
                'demo_url' => 'https://example.com',
                'github_url' => null,
                'is_private' => true,
                'is_published' => true,
                'is_featured' => true,
                'sort_order' => 2,
            ]);
            Project::create([
                'title' => 'API Gateway & Billing SaaS Starter',
                'slug' => Str::slug('API Gateway & Billing SaaS Starter'),
                'short_description' => 'Boilerplate aplikasi SaaS multi-tenant dengan manajemen langganan otomatis, webhook pembayaran, dan analitik penggunaan API.',
                'tech_stack' => ['PHP 8.2', 'Laravel Sanctum', 'Tailwind CSS', 'Docker'],
                'demo_url' => null,
                'github_url' => 'https://github.com/username/saas-starter',
                'is_private' => false,
                'is_published' => true,
                'is_featured' => false,
                'sort_order' => 3,
            ]);
        }
    }
}
