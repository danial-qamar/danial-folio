<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profile>
 */
class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'localization' => 'Lahore, Pakistan',
            'job_position' => 'Senior Full Stack Engineer',
            'public_email' => 'admin@danialfolio.com',
            'company'      => 'Power Information Technology Company (PITC)',
            'skills'       => 'Laravel 11, Vue.js 3, Livewire 3, Filament PHP 3, CodeIgniter 4, Tailwind CSS, Inertia.js, REST APIs',
            'about'        => '
                                🚀 Welcome to DanialFolio! <p></p>
                                Specializing in modern web applications, scalable backend APIs, reactive frontend component design, and enterprise admin dashboards built with Laravel, Vue.js, Livewire, Filament PHP, and CodeIgniter.<p></p>
                                🛠️ Core Tech Stack:
                                <p></p>
                                - <strong>Backend:</strong> Laravel 11, CodeIgniter 4, PHP 8.3, RESTful APIs, Sanctum Auth<br/>
                                - <strong>Frontend:</strong> Vue.js 3, Livewire 3, Inertia.js, Tailwind CSS, Alpine.js<br/>
                                - <strong>Dashboards & Tooling:</strong> Filament PHP v3, Docker, Git Workflows, CI/CD<p></p>
                                Explore articles, open-source projects, and technical guides!',
        ];
    }
}
