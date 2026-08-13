<?php

namespace Database\Seeders;

use App\Models\Hero;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HeroSectionSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing data
        Hero::truncate();

        // Create main Hero Section
        Hero::create([
            'is_active' => true,
            'title'     => 'Main Hero - DanialFolio',
            'content'   => [
                // General settings
                'theme'                           => 'sierra',
                'is_filled'                       => false,
                'social_network_module_is_active' => true,
                'is_mailing_active'               => true,

                // Headings
                'section_title'    => 'Building Modern Web Applications with <br /> Laravel, Vue.js, Livewire, Filament & CodeIgniter',
                'section_subtitle' => 'Senior Full-Stack Software Engineer & Open Source Developer',

                // Action buttons
                'buttons' => [
                    [
                        'button_title'  => 'Explore Articles',
                        'button_url'    => '/blog',
                        'button_style'  => 'primary',
                        'button_target' => '_self',
                        'icon'          => 'newspaper-outline',
                        'icon_before'   => true,
                    ],
                    [
                        'button_title'  => 'View Projects',
                        'button_url'    => '#portfolio',
                        'button_style'  => 'outlined',
                        'button_target' => '_self',
                        'icon'          => 'briefcase-outline',
                        'icon_before'   => true,
                    ],
                ],

                // Info Bumper
                'bumper_is_active'   => true,
                'bumper_is_animated' => true,
                'bumper_is_center'   => false,
                'bumper_tag'         => 'Tech Stack',
                'bumper_title'       => '🚀 Laravel 11, Vue 3, Livewire 3 & Filament 3',
                'bumper_icon'        => 'sparkles-outline',
                'bumper_link'        => '/blog',
                'bumper_target'      => '_self',
                'bumper_role'        => 'primary',

                // Featured image
                'featured_image_is_active' => true,
                'browser_border_is_active' => true,
                'browser_border_device'    => 'browser',
                'browser_border_url'       => 'https://laravel.com',

                // Background image
                'is_active'         => false,
                'is_upper'          => false,
                'is_highlight'      => false,
                'bg_position'       => 'bg-center',
                'bg_size'           => 'bg-cover',
                'bg_repeat'         => 'bg-no-repeat',
                'is_bg_grayscale'   => false,
                'is_bg_blur'        => false,
                'is_overlay_active' => false,
                'bg_overlay'        => 'hero-bg-overlay-default',

                // Background pattern
                'is_pattern_bg' => false,
                'pattern_name'  => 'cross',

                // Static slider
                'slider_is_active'  => true,
                'is_invert'         => true,
                'is_marquee'        => false,
                'marquee_speed'     => 'normal',
                'marquee_direction' => 'left',
                'slider_content'    => [
                    [
                        'slider_title'  => 'Laravel',
                        'slider_link'   => 'https://laravel.com',
                        'is_new_window' => true,
                        'caption'       => 'Framework PHP',
                    ],
                    [
                        'slider_title'  => 'Vue.js',
                        'slider_link'   => 'https://vuejs.org',
                        'is_new_window' => true,
                        'caption'       => 'Progressive Framework',
                    ],
                    [
                        'slider_title'  => 'Livewire',
                        'slider_link'   => 'https://livewire.laravel.com',
                        'is_new_window' => true,
                        'caption'       => 'Full-Stack Engine',
                    ],
                    [
                        'slider_title'  => 'Filament',
                        'slider_link'   => 'https://filamentphp.com',
                        'is_new_window' => true,
                        'caption'       => 'Admin Panel',
                    ],
                    [
                        'slider_title'  => 'CodeIgniter',
                        'slider_link'   => 'https://codeigniter.com',
                        'is_new_window' => true,
                        'caption'       => 'Lightweight Framework',
                    ],
                    [
                        'slider_title'  => 'TailwindCSS',
                        'slider_link'   => 'https://tailwindcss.com',
                        'is_new_window' => true,
                        'caption'       => 'Utility CSS',
                    ],
                ],
            ],
        ]);

        // Create alternative Hero Section
        Hero::create([
            'is_active' => false,
            'title'     => 'Alternative Hero - Creative Portfolio',
            'content'   => [
                // General settings
                'theme'                           => 'default',
                'is_filled'                       => true,
                'social_network_module_is_active' => false,
                'is_mailing_active'               => false,

                // Headings
                'section_title'    => '<span class="tl">Full Stack</span> Developer',
                'section_subtitle' => 'Specializing in <span class="dg">Laravel, Vue.js, Livewire, Filament & CodeIgniter</span>',

                // Action buttons
                'buttons' => [
                    [
                        'button_title'  => 'My Projects',
                        'button_url'    => '#projects',
                        'button_style'  => 'primary',
                        'button_target' => '_self',
                        'icon'          => 'code-slash-outline',
                        'icon_before'   => true,
                    ],
                    [
                        'button_title'  => 'Get in Touch',
                        'button_url'    => '#contact',
                        'button_style'  => 'secondary',
                        'button_target' => '_self',
                        'icon'          => 'mail-outline',
                        'icon_before'   => true,
                    ],
                ],

                // Info Bumper
                'bumper_is_active'   => true,
                'bumper_is_animated' => false,
                'bumper_is_center'   => true,
                'bumper_tag'         => 'Available',
                'bumper_title'       => '💼 Open for web development projects',
                'bumper_icon'        => 'briefcase-outline',
                'bumper_link'        => '#contact',
                'bumper_target'      => '_self',
                'bumper_role'        => 'info',

                // Featured image
                'featured_image_is_active' => true,
                'browser_border_is_active' => false,
                'browser_border_device'    => 'mobile',

                // Background image
                'is_active'         => true,
                'is_upper'          => true,
                'is_highlight'      => true,
                'bg_position'       => 'bg-center',
                'bg_size'           => 'bg-cover',
                'bg_repeat'         => 'bg-no-repeat',
                'is_bg_grayscale'   => false,
                'is_bg_blur'        => true,
                'is_overlay_active' => true,
                'bg_overlay'        => 'hero-bg-overlay-middle',

                // Background pattern
                'is_pattern_bg' => false,
                'pattern_name'  => 'dot',

                // Static slider
                'slider_is_active'  => true,
                'is_invert'         => false,
                'is_marquee'        => true,
                'marquee_speed'     => 'slow',
                'marquee_direction' => 'right',
                'slider_content'    => [
                    [
                        'slider_title' => 'Laravel 11',
                        'caption'      => 'Backend Framework',
                    ],
                    [
                        'slider_title' => 'Vue.js 3',
                        'caption'      => 'Frontend Framework',
                    ],
                    [
                        'slider_title' => 'Livewire 3',
                        'caption'      => 'Full-Stack Reactive UI',
                    ],
                    [
                        'slider_title' => 'Filament 3',
                        'caption'      => 'Enterprise Dashboard',
                    ],
                    [
                        'slider_title' => 'CodeIgniter 4',
                        'caption'      => 'High Performance PHP',
                    ],
                ],
            ],
        ]);
    }
}
