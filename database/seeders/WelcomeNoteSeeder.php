<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Page;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class WelcomeNoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categoryId = Category::where('slug', 'laravel')->first()?->id ?? Category::first()?->id ?? 1;
        $userId     = User::first()?->id ?? 1;

        $post = Post::create([
            'category_id' => $categoryId,
            'user_id'     => $userId,
            'resume'      => 'Welcome to your portfolio workspace! Explore tutorials and insights on Laravel 11, Vue 3, Livewire 3, Filament PHP, and CodeIgniter.',
            'content'     => $this->getContent(),
            'is_active'   => true,
            'is_featured' => false,
            'style'       => 'default',
        ]);

        Page::create([
            'post_id' => $post->id,
            'user_id' => $userId,
            'title'   => 'Welcome to DanialFolio 🚀',
            'slug'    => 'blog/post/welcome-to-danialfolio.html',
            'style'   => 'blog',
            'layout'  => 'default',
            'blocks'  => [
                [
                    'data' => [],
                    'type' => 'blog.post',
                ],
            ],
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    private function getContent(): string
    {
        return <<<'HTML'
<h2>Welcome to Your Developer Hub! 🌟</h2>
<p>DanialFolio is your all-in-one platform for showcasing technical skills, publishing in-depth articles, and managing portfolio projects built with cutting-edge tech stacks.</p>

<h3>Core Stack Highlights:</h3>
<ul>
    <li><strong>Laravel 11:</strong> Modern backend actions, Eloquent ORM, and Sanctum API security.</li>
    <li><strong>Vue.js 3:</strong> Reactive SPAs with Composition API and Inertia.js integration.</li>
    <li><strong>Livewire 3:</strong> Real-time dynamic frontend components without complex JavaScript build pipelines.</li>
    <li><strong>Filament PHP v3:</strong> Enterprise admin dashboards, resource tables, and form schema builders.</li>
    <li><strong>CodeIgniter 4:</strong> High-speed, lightweight PHP microservices and REST endpoints.</li>
</ul>

<p>Start organizing your blog posts, updating project showcases, and customizing your personal developer portfolio today!</p>
HTML;
    }
}
