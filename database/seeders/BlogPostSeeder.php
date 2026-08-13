<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Page;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Find the first user or default to ID 1
        $userId = User::first()?->id ?? 1;

        // Fetch categories by slug mapping
        $laravelCategory     = Category::where('slug', 'laravel')->first()?->id;
        $vueCategory         = Category::where('slug', 'vue-js')->first()?->id;
        $livewireCategory    = Category::where('slug', 'livewire')->first()?->id;
        $filamentCategory    = Category::where('slug', 'filament-php')->first()?->id;
        $codeigniterCategory = Category::where('slug', 'codeigniter')->first()?->id;
        $tailwindCategory    = Category::where('slug', 'tailwind-css')->first()?->id;
        $fullstackCategory   = Category::where('slug', 'full-stack-development')->first()?->id;
        $devopsCategory      = Category::where('slug', 'devops-apis')->first()?->id;

        // Fallback to first available category if specific slug is missing
        $fallbackCategoryId  = Category::first()?->id ?? 1;

        $postsData = [
            [
                'title'       => 'Mastering Laravel 11: Modern Architecture, Actions, and Minimal Configuration',
                'category_id' => $laravelCategory ?? $fallbackCategoryId,
                'is_featured' => true,
                'resume'      => 'Explore Laravel 11\'s streamlined application structure, native SQLite defaults, per-route rate limiting, and writing clean Action classes for domain-driven design.',
                'content'     => <<<'HTML'
<h2>Introduction to Laravel 11</h2>
<p>Laravel 11 introduces a revolutionized directory structure designed to reduce boilerplate and maximize developer velocity. By streamlining file structures in <code>app/Providers</code> and moving middleware configuration into <code>bootstrap/app.php</code>, Laravel 11 provides a lean foundation for modern web applications.</p>

<h3>Key Architectural Changes</h3>
<ul>
    <li><strong>Slimmer Directory Structure:</strong> Middleware, exception handlers, and console routing are consolidated cleanly in <code>bootstrap/app.php</code>.</li>
    <li><strong>Native Health Checking:</strong> Route endpoint <code>/up</code> is enabled out of the box with zero setup.</li>
    <li><strong>Model Pruning & Dump Helpers:</strong> Upgraded debugging and automated maintenance tools.</li>
</ul>

<h3>Writing Clean Action Classes</h3>
<p>In modern Laravel engineering, separating controller logic into single-responsibility Action classes yields highly testable code:</p>
<pre><code>namespace App\Actions\Order;

use App\Models\Order;
use App\Models\User;

class CreateOrderAction
{
    public function execute(User $user, array $orderItems): Order
    {
        return \DB::transaction(function () use ($user, $orderItems) {
            $order = $user->orders()->create([
                'status' => 'pending',
                'total'  => collect($orderItems)->sum('price'),
            ]);

            return $order;
        });
    }
}
</code></pre>
<p>Adopting Action classes combined with Laravel 11's lightweight bootstrap layer guarantees scalable, enterprise-grade architecture.</p>
HTML,
            ],
            [
                'title'       => 'Building Reactive UIs with Vue 3 Composition API & Script Setup',
                'category_id' => $vueCategory ?? $fallbackCategoryId,
                'is_featured' => true,
                'resume'      => 'Master Vue 3\'s Composition API and <script setup> syntax for building scalable, high-performance user interfaces with clean reactivity primitives.',
                'content'     => <<<'HTML'
<h2>Why Vue 3 Composition API Changes Everything</h2>
<p>Vue 3's Composition API coupled with <code>&lt;script setup&gt;</code> drastically reduces code verbosity compared to the legacy Options API. It enables seamless code organization by logical feature rather than component lifecycle hooks.</p>

<h3>Understanding Reactivity Primitives: ref vs reactive</h3>
<p>Choosing between <code>ref()</code> for primitive values and <code>reactive()</code> for complex nested objects is essential for clean state management:</p>
<pre><code>&lt;script setup&gt;
import { ref, reactive, computed } from 'vue';

const searchQuery = ref('');
const state = reactive({
  items: [],
  isLoading: false,
});

const filteredItems = computed(() => {
  return state.items.filter(item => 
    item.name.toLowerCase().includes(searchQuery.value.toLowerCase())
  );
});
&lt;/script&gt;

&lt;template&gt;
  &lt;div class="search-container"&gt;
    &lt;input v-model="searchQuery" placeholder="Search components..." /&gt;
    &lt;ul&gt;
      &lt;li v-for="item in filteredItems" :key="item.id"&gt;{{ item.name }}&lt;/li&gt;
    &lt;/ul&gt;
  &lt;/div&gt;
&lt;/template&gt;
</code></pre>
<p>By leveraging composables, Vue 3 allows sharing stateful logic across multiple components without mixin collision risks.</p>
HTML,
            ],
            [
                'title'       => 'Livewire 3 Deep Dive: Dynamic Full-Stack Components Without JavaScript Overkill',
                'category_id' => $livewireCategory ?? $fallbackCategoryId,
                'is_featured' => true,
                'resume'      => 'Discover Livewire 3\'s powerful features including Alpine.js unification, wire:navigate SPA routing, and lazy-loaded reactive components in Laravel.',
                'content'     => <<<'HTML'
<h2>The Evolution of Livewire in Laravel</h2>
<p>Livewire 3 brings a monumental performance upgrade to full-stack Laravel developers. Built directly on Alpine.js v3, Livewire handles client-side DOM diffing and state synchronization with blistering speed.</p>

<h3>Key Features in Livewire 3</h3>
<ul>
    <li><strong>Wire:navigate:</strong> Instantaneous page transitions mimicking a single page application (SPA).</li>
    <li><strong>Lazy Loading:</strong> Defer component rendering until visible on screen using <code>#[Lazy]</code> attributes.</li>
    <li><strong>Form Objects:</strong> Extract validation rules and state into separate form handler classes.</li>
</ul>

<h3>Example: Reactive Livewire Search Component</h3>
<pre><code>namespace App\Livewire;

use Livewire\Component;
use App\Models\Post;

class BlogSearch extends Component
{
    public string $query = '';

    public function render()
    {
        $posts = Post::query()
            ->when($this->query, fn($q) => $q->where('title', 'like', "%{$this->query}%"))
            ->latest()
            ->take(5)
            ->get();

        return view('livewire.blog-search', [
            'posts' => $posts,
        ]);
    }
}
</code></pre>
<p>Livewire 3 bridged the gap between server-rendered HTML and client-side reactive interactivity without requiring complex JavaScript build steps.</p>
HTML,
            ],
            [
                'title'       => 'Enterprise Admin Dashboards with Filament PHP v3',
                'category_id' => $filamentCategory ?? $fallbackCategoryId,
                'is_featured' => true,
                'resume'      => 'Build beautiful, feature-packed Laravel admin panels, resource tables, and form schema builders using Filament PHP v3.',
                'content'     => <<<'HTML'
<h2>Why Choose Filament PHP v3?</h2>
<p>Filament PHP has rapidly become the gold standard for constructing Laravel backoffices, admin portals, and internal tools. Utilizing TALL stack (Tailwind, Alpine, Laravel, Livewire), Filament provides an intuitive fluent PHP schemabuilder.</p>

<h3>Crafting a Filament Resource Schema</h3>
<p>Defining a resource table and form fields takes just a few lines of clean PHP code:</p>
<pre><code>namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Resource;
use App\Models\Project;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')->required()->maxLength(255),
            Forms\Components\Select::make('category_id')
                ->relationship('category', 'name')
                ->searchable()
                ->required(),
            Forms\Components\RichEditor::make('content'),
        ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('name')->sortable()->searchable(),
            Tables\Columns\TextColumn::make('category.name')->badge(),
            Tables\Columns\IconColumn::make('is_active')->boolean(),
        ]);
    }
}
</code></pre>
<p>Filament 3 empowers teams to ship robust internal software in record time while preserving full customization capabilities.</p>
HTML,
            ],
            [
                'title'       => 'CodeIgniter 4 vs Laravel 11: Architectural Benchmarks & Use-Cases',
                'category_id' => $codeigniterCategory ?? $fallbackCategoryId,
                'is_featured' => false,
                'resume'      => 'A performance, memory consumption, and developer experience comparison between CodeIgniter 4 and Laravel 11 for modern web applications.',
                'content'     => <<<'HTML'
<h2>Comparing PHP Powerhouses</h2>
<p>When selecting a framework for PHP projects, understanding the design trade-offs between CodeIgniter 4's lightweight core and Laravel 11's rich ecosystem is vital.</p>

<h3>Performance & Resource Consumption</h3>
<table border="1" style="width:100%; border-collapse: collapse; text-align: left;">
    <thead>
        <tr style="background:#f3f4f6;">
            <th style="padding: 8px;">Feature</th>
            <th style="padding: 8px;">CodeIgniter 4</th>
            <th style="padding: 8px;">Laravel 11</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="padding: 8px;">Footprint & Memory</td>
            <td style="padding: 8px;">Minimal (~2MB RAM per request)</td>
            <td style="padding: 8px;">Moderate (~12MB RAM per request)</td>
        </tr>
        <tr>
            <td style="padding: 8px;">ORM Engine</td>
            <td style="padding: 8px;">Built-in Model / Entity</td>
            <td style="padding: 8px;">Eloquent ORM</td>
        </tr>
        <tr>
            <td style="padding: 8px;">Admin Tooling</td>
            <td style="padding: 8px;">Custom / Community</td>
            <td style="padding: 8px;">Filament / Nova</td>
        </tr>
    </tbody>
</table>

<h3>CodeIgniter 4 Controller Blueprint</h3>
<pre><code>namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class ApiProjects extends ResourceController
{
    protected $modelName = 'App\Models\ProjectModel';
    protected $format    = 'json';

    public function index()
    {
        return $this->respond($this->model->findAll());
    }
}
</code></pre>
<p>CodeIgniter 4 shines in lightweight microservices and shared hosting, while Laravel 11 excels in rapid application development for feature-rich web applications.</p>
HTML,
            ],
            [
                'title'       => 'Building Full-Stack SPAs with Laravel 11, Inertia.js & Vue 3',
                'category_id' => $fullstackCategory ?? $fallbackCategoryId,
                'is_featured' => true,
                'resume'      => 'Bypass API creation boilerplate by linking Laravel 11 controllers directly to Vue 3 page components with Inertia.js.',
                'content'     => <<<'HTML'
<h2>The Inertia.js Paradigm Shift</h2>
<p>Inertia.js allows building single-page Vue 3 applications without writing complex REST APIs or client-side routers. Laravel controllers return Inertia render calls containing props directly into Vue views.</p>

<h3>Controller Implementation</h3>
<pre><code>namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Post;

class BlogController extends Controller
{
    public function index()
    {
        return Inertia::render('Blog/Index', [
            'posts' => Post::with('category')->latest()->paginate(10),
        ]);
    }
}
</code></pre>

<h3>Vue 3 Component Consumer</h3>
<pre><code>&lt;script setup&gt;
defineProps({
  posts: Object,
});
&lt;/script&gt;

&lt;template&gt;
  &lt;div class="max-w-4xl mx-auto py-8"&gt;
    &lt;h1 class="text-3xl font-bold mb-6"&gt;Latest Blog Articles&lt;/h1&gt;
    &lt;div v-for="post in posts.data" :key="post.id" class="mb-4 p-4 border rounded"&gt;
      &lt;h2 class="text-xl font-semibold"&gt;{{ post.title }}&lt;/h2&gt;
      &lt;p class="text-gray-600"&gt;{{ post.resume }}&lt;/p&gt;
    &lt;/div&gt;
  &lt;/div&gt;
&lt;/template&gt;
</code></pre>
<p>With Inertia.js, developers retain Laravel\'s authentication, routing, and ORM power while offering users smooth client-side SPA navigation.</p>
HTML,
            ],
            [
                'title'       => 'Tailwind CSS v3 Design Systems for Modern Laravel & Vue Applications',
                'category_id' => $tailwindCategory ?? $fallbackCategoryId,
                'is_featured' => false,
                'resume'      => 'Create scalable design tokens, dark mode variants, and responsive component libraries using Tailwind CSS v3 in Blade and Vue components.',
                'content'     => <<<'HTML'
<h2>Building a Unified Design System</h2>
<p>Tailwind CSS v3's JIT (Just-In-Time) compiler unlocks infinite flexibility when designing sleek, dark-mode-ready web application layouts.</p>

<h3>Configuring Design Tokens in Tailwind</h3>
<pre><code>// tailwind.config.js
module.exports = {
  darkMode: 'class',
  theme: {
    extend: {
      colors: {
        brand: {
          50: '#eff6ff',
          500: '#3b82f6',
          900: '#1e3a8a',
        },
      },
    },
  },
};
</code></pre>
<p>Combining CSS custom properties with Tailwind utility classes ensures seamless theme switching and responsive accessibility across mobile, tablet, and desktop viewports.</p>
HTML,
            ],
            [
                'title'       => 'Securing RESTful APIs in Laravel 11 with Sanctum & Throttling',
                'category_id' => $devopsCategory ?? $fallbackCategoryId,
                'is_featured' => false,
                'resume'      => 'Implement bulletproof API security using Laravel Sanctum bearer tokens, rate limiting throttles, and structured JSON exception responses.',
                'content'     => <<<'HTML'
<h2>API Security Best Practices</h2>
<p>API endpoints require robust authentication and request rate limiting to protect databases against credential stuffing and DDoS attacks.</p>

<h3>Sanctum Token Authentication Flow</h3>
<pre><code>use App\Models\User;
use Illuminate\Support\Facades\Hash;

public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    $token = $user->createToken('api-token')->plainTextToken;

    return response()->json(['token' => $token, 'user' => $user]);
}
</code></pre>
<p>Enforcing rate limiting with <code>RateLimiter::for('api')</code> protects application throughput while ensuring high availability.</p>
HTML,
            ],
            [
                'title'       => 'Laravel Eloquent Masterclass: Eager Loading & Query Optimization',
                'category_id' => $laravelCategory ?? $fallbackCategoryId,
                'is_featured' => false,
                'resume'      => 'Prevent N+1 query performance bottlenecks in Laravel apps using eager loading, lazy eager loading, and subquery selections.',
                'content'     => <<<'HTML'
<h2>Diagnosing & Resolving Database Bottlenecks</h2>
<p>The N+1 query bug occurs when an application executes one query to retrieve a dataset, followed by N separate queries to fetch related models inside a loop.</p>

<h3>Before Eager Loading (N+1 Problem):</h3>
<pre><code>$posts = Post::all(); // 1 Query
foreach ($posts as $post) {
    echo $post->category->name; // N Queries!
}
</code></pre>

<h3>After Eager Loading (Optimal 2 Queries):</h3>
<pre><code>$posts = Post::with('category')->get();
foreach ($posts as $post) {
    echo $post->category->name; // Zero additional queries!
}
</code></pre>
<p>Utilizing <code>withCount()</code> and <code>selectSub()</code> further optimizes memory allocation when dealing with large-scale relational datasets.</p>
HTML,
            ],
            [
                'title'       => 'Livewire 3 Form Objects & Real-Time Client Validation',
                'category_id' => $livewireCategory ?? $fallbackCategoryId,
                'is_featured' => false,
                'resume'      => 'Organize complex form handling in Livewire 3 using dedicated Form Objects, automatic real-time validation rules, and optimistic field states.',
                'content'     => <<<'HTML'
<h2>Extracting Form Logic in Livewire 3</h2>
<p>Livewire 3 introduced Form Objects to keep component classes clean by encapsulating input state and validation logic.</p>

<pre><code>namespace App\Livewire\Forms;

use Livewire\Form;
use Livewire\Attributes\Validate;

class ContactForm extends Form
{
    #[Validate('required|min:3')]
    public string $name = '';

    #[Validate('required|email')]
    public string $email = '';

    #[Validate('required|min:10')]
    public string $message = '';
}
</code></pre>
<p>This pattern provides clean, reusable validation routines that work dynamically with Alpine.js frontends.</p>
HTML,
            ],
            [
                'title'       => 'Advanced Filament PHP Customization: Custom Widgets & Action Modals',
                'category_id' => $filamentCategory ?? $fallbackCategoryId,
                'is_featured' => false,
                'resume'      => 'Take Filament PHP admin panels further by creating dynamic ApexCharts widgets, custom action slide-overs, and custom table column formatters.',
                'content'     => <<<'HTML'
<h2>Extending Filament Admin Panels</h2>
<p>Beyond standard CRUD resources, Filament 3 allows embedding customized real-time charts and multi-step action modals directly into dashboards.</p>

<h3>Building a Stat Overview Widget</h3>
<pre><code>namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AnalyticsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Projects', '42')->description('3 new this week')->descriptionIcon('heroicon-m-arrow-trending-up')->color('success'),
            Stat::make('Blog Readers', '12.4k')->description('18% increase')->color('primary'),
        ];
    }
}
</code></pre>
<p>Custom widgets turn static admin panels into comprehensive business intelligence command centers.</p>
HTML,
            ],
            [
                'title'       => 'Upgrading Legacy CodeIgniter 3 Projects to Modern CodeIgniter 4',
                'category_id' => $codeigniterCategory ?? $fallbackCategoryId,
                'is_featured' => false,
                'resume'      => 'A practical step-by-step roadmap for refactoring CodeIgniter 3 codebases into modern PSR-4 namespaced CodeIgniter 4 applications.',
                'content'     => <<<'HTML'
<h2>Modernizing Legacy PHP Codebases</h2>
<p>Upgrading from CodeIgniter 3 to CodeIgniter 4 brings support for PHP 8.2+, modern OOP namespaces, dependency injection, and integrated CLI migration tools.</p>

<h3>Migration Checklist</h3>
<ol>
    <li><strong>Namespacing:</strong> Convert procedural models and libraries to PSR-4 class structures in <code>App\Models</code> and <code>App\Libraries</code>.</li>
    <li><strong>Database Queries:</strong> Replace legacy Active Record methods with CI4 QueryBuilder or Entity classes.</li>
    <li><strong>Routing:</strong> Define explicit route definitions in <code>app/Config/Routes.php</code>.</li>
</ol>
<p>Upgrading ensures legacy applications gain long-term security maintenance, microsecond execution speeds, and modern developer tooling.</p>
HTML,
            ],
        ];

        // Clear existing posts & associated pages first to avoid duplicates
        Post::query()->delete();

        foreach ($postsData as $index => $data) {
            $post = Post::create([
                'user_id'     => $userId,
                'category_id' => $data['category_id'],
                'content'     => $data['content'],
                'resume'      => $data['resume'],
                'is_active'   => true,
                'is_featured' => $data['is_featured'],
                'style'       => 'default',
            ]);

            Page::create([
                'post_id'    => $post->id,
                'user_id'    => $userId,
                'title'      => $data['title'],
                'slug'       => 'blog/post/'.Str::slug($data['title']).'.html',
                'style'      => 'blog',
                'layout'     => 'default',
                'blocks'     => [
                    [
                        'data' => [],
                        'type' => 'blog.post',
                    ],
                ],
                'is_active'  => true,
                'created_at' => now()->subDays(12 - $index),
                'updated_at' => now()->subDays(rand(0, 2)),
            ]);
        }
    }
}
