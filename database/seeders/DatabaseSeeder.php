<?php

namespace Database\Seeders;

use App\Models\Alert;
use App\Models\Course;
use App\Models\Mail;
use App\Models\Newsletter;
use App\Models\Setting;
use App\Models\User;
use Database\Seeders\BlogPostSeeder;
use Database\Seeders\BlogSeeder;
use Database\Seeders\CategorySeeder;
use Database\Seeders\DocumentationPageSeeder;
use Database\Seeders\HeroSectionSeeder;
use Database\Seeders\LandingPageSeeder;
use Database\Seeders\ProjectSeeder;
use Database\Seeders\SectionSeeder;
use Database\Seeders\WelcomeNoteSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * DanialFolio app seeder.
     * Seed the application's database.
     * Be careful with the order of the factories, because some of them have foreign keys.
     */
    public function run(): void
    {
        $user = User::updateOrCreate(
            ['email' => 'admin@danialfolio.com'],
            ['name' => 'DanialFolio', 'password' => '$2y$10$opNa/fk5BPLxxxPzbBkure5cZpti.uUZaYkJhikDvvTNp0wlU1Fdu']
        );

        if (! $user->profile->exists) {
            $user->profile()->create([
                'localization' => 'Lahore, Pakistan',
                'job_position' => 'Senior Full-Stack Developer',
                'public_email' => 'admin@danialfolio.com',
                'company'      => 'Power Information Technology Company (PITC)',
                'skills'       => 'Laravel 11, Vue.js 3, Livewire 3, Filament 3, CodeIgniter 4, Tailwind CSS, Inertia.js',
                'about'        => 'Passionate software architect and open-source contributor building modern web applications with Laravel, Vue.js, Livewire, Filament PHP, and CodeIgniter.',
            ]);
        }

        if (Setting::where('user_id', $user->id)->count() === 0) {
            Setting::factory()
                ->hasLayout()
                ->hasNavigation()
                ->create([
                    'user_id' => $user->id,
                ]);
        }

        if (Mail::count() === 0) {
            Mail::factory()->create();
        }

        if (Newsletter::where('email', 'admin@danialfolio.com')->count() === 0) {
            Newsletter::factory()->create(['email' => 'admin@danialfolio.com']);
        }

        if (Course::count() === 0) {
            Course::factory()->create();
        }

        if (Alert::count() === 0) {
            Alert::factory()->create();
        }

        /** Call Seeders in strict dependency order */
        $this->call([
            CategorySeeder::class,
            ProjectSeeder::class,
            LandingPageSeeder::class,
            DocumentationPageSeeder::class,
            BlogSeeder::class,
            WelcomeNoteSeeder::class,
            BlogPostSeeder::class,
            SectionSeeder::class,
            HeroSectionSeeder::class,
        ]);
    }
}
