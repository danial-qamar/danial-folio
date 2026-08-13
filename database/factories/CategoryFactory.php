<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $techNames = [
            'Laravel Framework',
            'Vue.js Ecosystem',
            'Livewire Components',
            'Filament PHP Admin',
            'CodeIgniter Tools',
            'Tailwind Styling',
            'Full Stack Architecture',
            'DevOps & Microservices',
        ];

        $name = $this->faker->randomElement($techNames);

        return [
            'name'       => $name,
            'slug'       => Str::slug($name.'-'.rand(100, 999)),
            'is_active'  => true,
            'is_blog'    => true,
            'is_project' => true,
            'hex_color'  => $this->faker->randomElement(['#FF2D20', '#4FC08D', '#FB70A9', '#F59E0B', '#EE4623', '#06B6D4', '#6366F1']),
            'icon'       => $this->faker->randomElement([
                'logo-laravel',
                'logo-vue',
                'flash-outline',
                'options-outline',
                'flame-outline',
                'color-palette-outline',
                'code-slash-outline',
            ]),
        ];
    }
}
