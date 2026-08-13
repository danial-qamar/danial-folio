<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Page;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userId = User::first()?->id ?? 1;

        $laravelCat     = Category::where('slug', 'laravel')->first()?->id;
        $vueCat         = Category::where('slug', 'vue-js')->first()?->id;
        $livewireCat    = Category::where('slug', 'livewire')->first()?->id;
        $filamentCat    = Category::where('slug', 'filament-php')->first()?->id;
        $codeigniterCat = Category::where('slug', 'codeigniter')->first()?->id;
        $fullstackCat   = Category::where('slug', 'full-stack-development')->first()?->id;

        $fallbackCatId  = Category::first()?->id ?? 1;

        $projects = [
            [
                'title'             => 'WarriorFolio - Developer Portfolio Builder',
                'category_id'       => $laravelCat ?? $fallbackCatId,
                'short_description' => 'A modular portfolio and blog builder engineered with Laravel 11, Livewire 3, Filament 3, and Tailwind CSS.',
                'content'           => '<p>WarriorFolio is a high-performance open-source personal website platform for developers. Features real-time block editing, dynamic blog feed, Juno visual components, and seamless GitHub project synchronization.</p>',
                'external_link'     => 'https://github.com/danial-qamar/danial-folio',
                'tags'              => ['Laravel 11', 'Livewire 3', 'Filament 3', 'Tailwind CSS'],
            ],
            [
                'title'             => 'ShopVue - Modern E-Commerce Platform',
                'category_id'       => $vueCat ?? $fallbackCatId,
                'short_description' => 'Single Page Application e-commerce marketplace powered by Vue 3 Composition API, Pinia state management, and Laravel REST API.',
                'content'           => '<p>ShopVue offers instantaneous client-side page rendering, real-time cart persistence, Stripe checkout integration, dynamic multi-filter searches, and responsive Tailwind UI styling.</p>',
                'external_link'     => 'https://vuejs.org',
                'tags'              => ['Vue 3', 'Inertia.js', 'Laravel API', 'Pinia', 'Tailwind CSS'],
            ],
            [
                'title'             => 'PulseMetrics - Real-Time SaaS Analytics Dashboard',
                'category_id'       => $livewireCat ?? $fallbackCatId,
                'short_description' => 'Real-time telemetry dashboard built with Livewire 3, Alpine.js, ApexCharts, and Laravel WebSockets.',
                'content'           => '<p>PulseMetrics processes real-time API logs, server health metrics, revenue breakdowns, and user activity without writing complex SPA JavaScript routing.</p>',
                'external_link'     => 'https://livewire.laravel.com',
                'tags'              => ['Livewire 3', 'Alpine.js', 'Laravel 11', 'ApexCharts'],
            ],
            [
                'title'             => 'FilamentERP - Enterprise Resource Planning Portal',
                'category_id'       => $filamentCat ?? $fallbackCatId,
                'short_description' => 'Comprehensive enterprise backoffice featuring custom Filament PHP v3 resources, dynamic form schema builders, and multi-tenant permissions.',
                'content'           => '<p>FilamentERP handles inventory control, customer relations, invoice PDF generation, automated email triggers, and granular role-based access control (RBAC).</p>',
                'external_link'     => 'https://filamentphp.com',
                'tags'              => ['Filament PHP 3', 'Laravel 11', 'PostgreSQL', 'Tailwind CSS'],
            ],
            [
                'title'             => 'IgniteCore - Lightweight REST microservice Engine',
                'category_id'       => $codeigniterCat ?? $fallbackCatId,
                'short_description' => 'Ultra-fast API gateway microservice built on CodeIgniter 4 framework delivering sub-15ms response times.',
                'content'           => '<p>IgniteCore delivers extreme performance under high-concurrency workloads using CodeIgniter 4\'s minimal footprint, Redis cache layer, and raw database optimization.</p>',
                'external_link'     => 'https://codeigniter.com',
                'tags'              => ['CodeIgniter 4', 'PHP 8.3', 'Redis', 'REST API'],
            ],
            [
                'title'             => 'TaskCraft - Full-Stack Team Collaboration Suite',
                'category_id'       => $fullstackCat ?? $fallbackCatId,
                'short_description' => 'Collaborative task management suite built with Laravel 11, Vue 3, Inertia.js, and Tailwind CSS.',
                'content'           => '<p>TaskCraft combines drag-and-drop Kanban boards, team activity logs, notifications, file attachments, and dynamic milestone tracking into a unified SPA interface.</p>',
                'external_link'     => 'https://laravel.com',
                'tags'              => ['Laravel 11', 'Vue 3', 'Inertia.js', 'Tailwind CSS'],
            ],
        ];

        Project::query()->delete();

        foreach ($projects as $projectData) {
            $project = Project::create([
                'user_id'           => $userId,
                'category_id'       => $projectData['category_id'],
                'short_description' => $projectData['short_description'],
                'content'           => $projectData['content'],
                'external_link'     => $projectData['external_link'],
                'tags'              => $projectData['tags'],
                'is_active'         => true,
            ]);

            Page::create([
                'project_id' => $project->id,
                'user_id'    => $userId,
                'title'      => $projectData['title'],
                'slug'       => 'projects/'.Str::slug($projectData['title']).'.html',
                'style'      => 'portfolio',
                'layout'     => 'default',
                'blocks'     => [
                    [
                        'data' => [],
                        'type' => 'portfolio.project',
                    ],
                ],
                'is_active'  => true,
            ]);
        }
    }
}
