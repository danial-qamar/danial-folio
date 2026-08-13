<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'        => 'Advanced Full-Stack Web Development (Laravel, Vue.js, Livewire, Filament & CodeIgniter)',
            'institution' => 'MIT Computer Science & Software Architecture',
            'start_date'  => now()->subYears(2),
            'end_date'    => now(),
            'status'      => 'completed',
        ];
    }
}
