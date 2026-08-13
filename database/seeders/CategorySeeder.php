<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name'       => 'Laravel',
                'slug'       => 'laravel',
                'icon'       => 'logo-laravel',
                'hex_color'  => '#FF2D20',
                'is_blog'    => true,
                'is_project' => true,
                'is_active'  => true,
            ],
            [
                'name'       => 'Vue.js',
                'slug'       => 'vue-js',
                'icon'       => 'logo-vue',
                'hex_color'  => '#4FC08D',
                'is_blog'    => true,
                'is_project' => true,
                'is_active'  => true,
            ],
            [
                'name'       => 'Livewire',
                'slug'       => 'livewire',
                'icon'       => 'flash-outline',
                'hex_color'  => '#FB70A9',
                'is_blog'    => true,
                'is_project' => true,
                'is_active'  => true,
            ],
            [
                'name'       => 'Filament PHP',
                'slug'       => 'filament-php',
                'icon'       => 'options-outline',
                'hex_color'  => '#F59E0B',
                'is_blog'    => true,
                'is_project' => true,
                'is_active'  => true,
            ],
            [
                'name'       => 'CodeIgniter',
                'slug'       => 'codeigniter',
                'icon'       => 'flame-outline',
                'hex_color'  => '#EE4623',
                'is_blog'    => true,
                'is_project' => true,
                'is_active'  => true,
            ],
            [
                'name'       => 'Tailwind CSS',
                'slug'       => 'tailwind-css',
                'icon'       => 'color-palette-outline',
                'hex_color'  => '#06B6D4',
                'is_blog'    => true,
                'is_project' => true,
                'is_active'  => true,
            ],
            [
                'name'       => 'Full Stack Development',
                'slug'       => 'full-stack-development',
                'icon'       => 'code-slash-outline',
                'hex_color'  => '#6366F1',
                'is_blog'    => true,
                'is_project' => true,
                'is_active'  => true,
            ],
            [
                'name'       => 'DevOps & APIs',
                'slug'       => 'devops-apis',
                'icon'       => 'server-outline',
                'hex_color'  => '#10B981',
                'is_blog'    => true,
                'is_project' => true,
                'is_active'  => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}
