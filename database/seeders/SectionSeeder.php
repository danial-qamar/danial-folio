<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SectionSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('sections')->truncate();

        $sections = [
            [
                'name'    => 'about me',
                'slug'    => 'about-me',
                'content' => [
                    'is_heading_visible' => 1,
                    'title'              => 'About Me',
                    'subtitle'           => 'Senior Full Stack Developer specializing in Laravel, Vue.js, Livewire, Filament PHP, and CodeIgniter.',
                ],
                'is_active'  => 1,
                'is_coupled' => 0,
            ],
            [
                'name'    => 'services',
                'slug'    => 'services',
                'content' => [
                    'title'    => 'Technical Services',
                    'subtitle' => 'Custom Laravel Web Apps, Vue.js SPAs, Livewire Reactive Interfaces, Filament Admin Panels & CodeIgniter Migrations.',
                ],
                'is_active'  => 1,
                'is_coupled' => 0,
            ],
            [
                'name'    => 'portfolio',
                'slug'    => 'portfolio',
                'content' => [
                    'is_heading_visible' => 1,
                    'title'              => 'Featured Projects',
                    'subtitle'           => 'Explore real-world software applications built with modern PHP and JavaScript ecosystems.',
                ],
                'is_active'  => 1,
                'is_coupled' => 0,
            ],
            [
                'name'    => 'contact',
                'slug'    => 'contact',
                'content' => [
                    'is_heading_visible' => 1,
                    'title'              => 'Get in Touch',
                    'subtitle'           => 'Have a project in mind or interested in collaborating? Send a direct message.',
                ],
                'is_active'  => 1,
                'is_coupled' => 0,
            ],
            [
                'name'    => 'blog',
                'slug'    => 'blog',
                'content' => [
                    'is_heading_visible' => 1,
                    'title'              => 'Technical Insights & Articles',
                    'subtitle'           => 'In-depth tutorials and architectural guides on Laravel, Vue.js, Livewire, Filament PHP, and CodeIgniter.',
                ],
                'is_active'  => 1,
                'is_coupled' => 0,
            ],
            [
                'name'    => 'hero',
                'slug'    => 'hero',
                'content' => [
                    'title'    => 'Welcome to My Portfolio',
                    'subtitle' => 'Building Scalable Web Solutions with Laravel, Vue.js, Livewire, Filament & CodeIgniter.',
                ],
                'is_active'  => 1,
                'is_coupled' => 0,
            ],
            [
                'name'    => 'clients',
                'slug'    => 'clients',
                'content' => [
                    'is_heading_visible' => 1,
                    'title'              => 'Trusted By Industry Leaders',
                    'subtitle'           => 'Collaborated with high-growth startups and enterprise engineering teams.',
                ],
                'is_active'  => 1,
                'is_coupled' => 0,
            ],
            [
                'name'    => 'newsletter',
                'slug'    => 'newsletter',
                'content' => [
                    'title'    => 'Subscribe to Tech Newsletter',
                    'subtitle' => 'Receive weekly articles on Laravel, Vue 3, Livewire 3, Filament, and PHP architecture.',
                ],
                'is_active'  => 1,
                'is_coupled' => 0,
            ],
            [
                'name'    => 'footer',
                'slug'    => 'footer',
                'content' => [
                    'title'    => 'DanialFolio Developer Hub',
                    'subtitle' => 'Crafted with Laravel, Livewire & Filament PHP.',
                ],
                'is_active'  => 1,
                'is_coupled' => 0,
            ],
            [
                'name'    => 'github-repositories',
                'slug'    => 'github-repositories',
                'content' => [
                    'is_heading_visible' => 1,
                    'title'              => 'Open Source Repositories',
                    'subtitle'           => 'Explore open-source Laravel packages, Vue composables, and Livewire components.',
                ],
                'is_active'  => 1,
                'is_coupled' => 0,
            ],
        ];

        foreach ($sections as $section) {
            $section['content'] = json_encode($section['content']);
            DB::table('sections')->insert($section);
        }
    }
}
