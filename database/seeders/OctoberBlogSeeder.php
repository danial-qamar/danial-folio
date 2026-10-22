<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Page;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class OctoberBlogSeeder extends Seeder
{
    /**
     * Run the database seeds for October 2026 Laravel News articles.
     */
    public function run(): void
    {
        $userId = User::first()?->id ?? 1;

        // Ensure categories exist
        $categoriesData = [
            'news' => [
                'name'       => 'News',
                'slug'       => 'news',
                'icon'       => 'newspaper-outline',
                'hex_color'  => '#3B82F6',
                'is_blog'    => true,
                'is_project' => false,
                'is_active'  => true,
            ],
            'laravel-packages' => [
                'name'       => 'Laravel Packages',
                'slug'       => 'laravel-packages',
                'icon'       => 'cube-outline',
                'hex_color'  => '#8B5CF6',
                'is_blog'    => true,
                'is_project' => true,
                'is_active'  => true,
            ],
            'laravel-tutorials' => [
                'name'       => 'Laravel Tutorials',
                'slug'       => 'laravel-tutorials',
                'icon'       => 'school-outline',
                'hex_color'  => '#10B981',
                'is_blog'    => true,
                'is_project' => false,
                'is_active'  => true,
            ],
            'sponsor' => [
                'name'       => 'Sponsor',
                'slug'       => 'sponsor',
                'icon'       => 'star-outline',
                'hex_color'  => '#EC4899',
                'is_blog'    => true,
                'is_project' => false,
                'is_active'  => true,
            ],
            'laravel' => [
                'name'       => 'Laravel',
                'slug'       => 'laravel',
                'icon'       => 'logo-laravel',
                'hex_color'  => '#FF2D20',
                'is_blog'    => true,
                'is_project' => true,
                'is_active'  => true,
            ],
        ];

        $categories = [];
        foreach ($categoriesData as $key => $data) {
            $categories[$key] = Category::updateOrCreate(
                ['slug' => $data['slug']],
                $data
            )->id;
        }

        $fallbackCategoryId = Category::first()?->id ?? 1;

        // Ensure storage directory for post cover images exists
        $storageDir = storage_path('app/public/posts');
        if (!file_exists($storageDir)) {
            mkdir($storageDir, 0755, true);
        }

        $articles = [
            [
                'title'        => 'PHP Security Releases Fix Two Critical RCE Vulnerabilities',
                'category_key' => 'news',
                'author'       => 'Eric L. Barnes',
                'date'         => '2026-10-21 16:30:00',
                'theme'        => 'rose',
                'is_featured'  => true,
                'resume'       => 'The PHP development team has released urgent security updates across all active release branches addressing two critical remote code execution vulnerabilities.',
                'content'      => <<<'HTML'
<h2>PHP Security Releases Fix Two Critical RCE Vulnerabilities</h2>
<p>The PHP core development team announced urgent security updates for all supported PHP versions. These releases remediate two critical vulnerabilities that could allow remote attackers to achieve arbitrary code execution under specific server environments.</p>

<h3>Vulnerability Overview</h3>
<p>The reported issues involve memory corruption during multipart form-data parsing and an integer overflow vulnerability within the multibyte string extension (<code>mbstring</code>). Systems parsing untrusted file uploads or processing complex Unicode encodings are strongly advised to patch immediately.</p>

<ul>
    <li><strong>CVE-2026-4821:</strong> Remote code execution via crafted multipart form boundaries.</li>
    <li><strong>CVE-2026-4822:</strong> Heap buffer overflow in <code>mb_ereg_*</code> functions during regex evaluation.</li>
</ul>

<h3>Recommended Action</h3>
<p>All developers and infrastructure operators should upgrade their runtime environments immediately:</p>
<pre><code># Ubuntu / Debian
sudo apt-get update && sudo apt-get --only-upgrade install php8.3 php8.2

# Alpine Linux / Docker
apk update && apk upgrade php83
</code></pre>

<p>Ensure that all web worker processes (PHP-FPM, RoadRunner, FrankenPHP, Swoole) are fully restarted after applying the updates to load the patched shared libraries.</p>
HTML,
            ],
            [
                'title'        => 'Prevent Stale Database Reads in Laravel 13.38',
                'category_key' => 'news',
                'author'       => 'Paul Redmond',
                'date'         => '2026-10-21 11:00:00',
                'theme'        => 'blue',
                'is_featured'  => true,
                'resume'       => 'Laravel 13.38 introduces dedicated primary connection pinning helpers to safeguard high-concurrency read-write replica setups against replication lag.',
                'content'      => <<<'HTML'
<h2>Prevent Stale Database Reads in Laravel 13.38</h2>
<p>Managing database read-write replicas is a standard architectural choice for scaling Laravel applications. However, replication lag can sometimes cause a user to perform an action (e.g. updating profile details) and immediately see outdated data fetched from an un-synced replica.</p>

<h3>Introducing Strict Primary Read Guarantees</h3>
<p>Laravel 13.38 introduces dedicated helpers to pin read operations to the primary write connection immediately following a mutation within the request lifecycle:</p>

<pre><code>use App\Models\User;
use Illuminate\Support\Facades\DB;

// Pin current request reads to primary connection
DB::useWriteConnectionForReads(function () {
    $user = User::find(auth()->id());
    // Guaranteed fresh data directly from primary DB
});
</code></pre>

<h3>Automatic Session-Based Read Pinning</h3>
<p>You can also configure automatic read-pinning in your database configuration to ensure any writes performed by a user automatically route subsequent reads for that session to the primary database for a configurable duration:</p>

<pre><code>// config/database.php
'mysql' => [
    'sticky' => true,
    'sticky_duration' => 5, // duration in seconds
],
</code></pre>

<p>This update eliminates an entire class of race conditions without requiring manual transaction wrapping.</p>
HTML,
            ],
            [
                'title'        => 'Critical PHP Security Release Coming Tomorrow (October 21)',
                'category_key' => 'news',
                'author'       => 'Paul Redmond',
                'date'         => '2026-10-20 16:30:00',
                'theme'        => 'amber',
                'is_featured'  => false,
                'resume'       => 'Advance warning from the PHP security team advising teams to prepare for emergency runtime patches across all production environments.',
                'content'      => <<<'HTML'
<h2>Critical PHP Security Release Coming Tomorrow (October 21)</h2>
<p>The PHP Group has issued an advance advisory warning regarding emergency security point releases scheduled for rollout across PHP 8.1, 8.2, 8.3, and 8.4 branches.</p>

<h3>Preparation Checklist for Engineering Teams</h3>
<p>Teams running production Laravel workloads are encouraged to verify automated deployment workflows and staging rollout procedures:</p>
<ol>
    <li>Audit base container images to ensure package mirrors are responsive.</li>
    <li>Review staging rollback protocols and database migration safety.</li>
    <li>Schedule operational readiness windows during off-peak traffic hours.</li>
</ol>
<p>Stay tuned for complete release notes and vulnerability breakdowns as soon as the upstream advisories become public.</p>
HTML,
            ],
            [
                'title'        => 'Critical Token Guard Auth Bypass Fixed in Laravel 13.29 and 12.68',
                'category_key' => 'news',
                'author'       => 'Paul Redmond',
                'date'         => '2026-10-20 10:45:00',
                'theme'        => 'rose',
                'is_featured'  => true,
                'resume'       => 'An urgent security fix addresses an authentication bypass vulnerability affecting legacy TokenGuard configurations when handling malformed bearer headers.',
                'content'      => <<<'HTML'
<h2>Critical Token Guard Auth Bypass Fixed in Laravel 13.29 and 12.68</h2>
<p>The Laravel security team has published patch releases for both the Laravel 12.x and 13.x branches. This release mitigates a security bypass scenario within the legacy <code>TokenGuard</code> authentication driver.</p>

<h3>Vulnerability Details</h3>
<p>Applications relying on the default <code>token</code> driver with database-backed API keys could under specific PHP string comparison quirks authenticate an incoming request when receiving empty or specifically structured bearer tokens.</p>

<pre><code>// Composer command to apply the security update
composer update laravel/framework:^13.29.0
</code></pre>

<h3>Sanctum and Passport Users</h3>
<p>Applications utilizing <strong>Laravel Sanctum</strong> or <strong>Laravel Passport</strong> are not affected by this vulnerability, as they implement independent, cryptographically secure hash verification mechanisms. However, upgrading to the latest framework patch is recommended for all projects.</p>
HTML,
            ],
            [
                'title'        => 'Run Large PlanetScale Queries in Laravel With DB::olap()',
                'category_key' => 'laravel-tutorials',
                'author'       => 'Paul Redmond',
                'date'         => '2026-10-19 15:00:00',
                'theme'        => 'cyan',
                'is_featured'  => false,
                'resume'       => 'Learn how to leverage PlanetScale OLAP database engines within Laravel using the new dedicated connection routing query wrappers.',
                'content'      => <<<'HTML'
<h2>Run Large PlanetScale Queries in Laravel With DB::olap()</h2>
<p>Analytical workloads such as multi-tenant aggregations and monthly financial rollups can overwhelm traditional transactional (OLTP) tables. PlanetScale's integrated columnar analytics engine allows developers to query millions of rows in seconds without burdening the transactional cluster.</p>

<h3>Using the DB::olap() Wrapper</h3>
<p>In modern Laravel setups, routing analytical queries to the analytical node is as simple as chaining through the query builder:</p>

<pre><code>use Illuminate\Support\Facades\DB;

$monthlyRevenue = DB::olap('planetscale')
    ->table('invoices')
    ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, SUM(amount) as total')
    ->where('status', 'paid')
    ->groupBy('month')
    ->get();
</code></pre>

<p>This approach keeps analytical query memory isolated, ensuring zero latency spikes for front-facing user transactions.</p>
HTML,
            ],
            [
                'title'        => 'Fluent Rule Builders for All Laravel Validation Rules',
                'category_key' => 'laravel-tutorials',
                'author'       => 'Paul Redmond',
                'date'         => '2026-10-16 11:15:00',
                'theme'        => 'blue',
                'is_featured'  => false,
                'resume'       => 'Discover how modern fluent rule builders eliminate string typos, enhance IDE autocompletion, and simplify complex conditional validation.',
                'content'      => <<<'HTML'
<h2>Fluent Rule Builders for All Laravel Validation Rules</h2>
<p>For years, Laravel developers have defined validation rules using delimited strings such as <code>'required|string|max:255|unique:users,email'</code>. With modern fluent rule builders, every validation rule now offers type-safe, chainable method syntax.</p>

<h3>Cleaner, Typosafe Validation Rules</h3>
<pre><code>use Illuminate\Validation\Rule;

$validated = $request->validate([
    'email' => [
        Rule::required(),
        Rule::string()->max(255),
        Rule::email()->rfcCompliant(),
        Rule::unique('users', 'email')->ignore($user->id),
    ],
    'age' => [
        Rule::numeric()->between(18, 99),
    ],
]);
</code></pre>

<p>Fluent builders provide full autocompletion, compile-time static analysis with PHPStan, and cleaner refactoring capabilities across large teams.</p>
HTML,
            ],
            [
                'title'        => 'Laravel URL AI Transformer: Extract Structured Data From URLs',
                'category_key' => 'laravel-packages',
                'author'       => 'Paul Redmond',
                'date'         => '2026-10-15 13:30:00',
                'theme'        => 'emerald',
                'is_featured'  => false,
                'resume'       => 'Turn any public website or article URL into clean, schema-validated PHP DTOs using AI transformer pipelines in Laravel.',
                'content'      => <<<'HTML'
<h2>Laravel URL AI Transformer: Extract Structured Data From URLs</h2>
<p>Scraping unstructured websites and converting messy HTML into reliable application data is traditionally painful. The new <code>laravel-url-ai-transformer</code> package leverages headless rendering combined with LLM function calling to convert web pages into validated Eloquent models or Spatie Data Transfer Objects.</p>

<h3>Installation and Basic Usage</h3>
<pre><code>composer require developer/laravel-url-ai-transformer
</code></pre>

<pre><code>use App\Data\ProductDto;
use LaravelAi\UrlTransformer\Facades\UrlTransformer;

$product = UrlTransformer::from('https://store.example.com/item/42')
    ->schema(ProductDto::class)
    ->extract();

// Returns strongly-typed ProductDto instance
echo $product->title;
echo $product->price;
</code></pre>

<p>Automate product ingestion, content syndication, and competitor research with reliable, type-safe data outputs.</p>
HTML,
            ],
            [
                'title'        => 'Rule Builders for Every Validation Rule in Laravel 13.36',
                'category_key' => 'news',
                'author'       => 'Paul Redmond',
                'date'         => '2026-10-14 14:00:00',
                'theme'        => 'amber',
                'is_featured'  => false,
                'resume'       => 'Laravel 13.36 expands fluent validation rules across the entire framework catalog, bringing first-class static analysis support.',
                'content'      => <<<'HTML'
<h2>Rule Builders for Every Validation Rule in Laravel 13.36</h2>
<p>The release of Laravel 13.36 completes the migration of all built-in validation rules to fluent builder classes. Whether validating UUIDs, IP addresses, dates, or file mime-types, developers no longer need to look up legacy string parameters in the documentation.</p>

<h3>Key Additions</h3>
<ul>
    <li><code>Rule::uuid()</code> and <code>Rule::ulid()</code></li>
    <li><code>Rule::ip()->ipv4()->private()</code></li>
    <li><code>Rule::date()->afterOrEqual('today')</code></li>
    <li><code>Rule::file()->image()->max('5MB')</code></li>
</ul>

<p>Upgrade to Laravel 13.36 today via <code>composer update laravel/framework</code> to start using fluent validation across your entire application.</p>
HTML,
            ],
            [
                'title'        => 'PHP News: A New Site for PHP Releases, RFCs, and Packages',
                'category_key' => 'news',
                'author'       => 'Eric L. Barnes',
                'date'         => '2026-10-13 15:45:00',
                'theme'        => 'blue',
                'is_featured'  => false,
                'resume'       => 'Announcing PHP News, a centralized community portal tracking PHP RFC votes, core internals discussions, package highlights, and engine updates.',
                'content'      => <<<'HTML'
<h2>PHP News: A New Site for PHP Releases, RFCs, and Packages</h2>
<p>Keeping track of PHP language evolution across mailing lists, GitHub discussions, and PHP Foundation updates can be overwhelming. We are thrilled to introduce <strong>PHP News</strong>, a modern curated publication dedicated to the wider PHP ecosystem.</p>

<h3>What You Will Find</h3>
<ul>
    <li><strong>RFC Radar:</strong> Track active Voting RFCs and upcoming language features for PHP 8.4 and beyond.</li>
    <li><strong>Engine Performance Benchmarks:</strong> Deep dives into JIT compiler enhancements and opcode optimizations.</li>
    <li><strong>Package Spotlights:</strong> Hand-picked libraries elevating the quality of modern PHP codebases.</li>
</ul>

<p>Bookmark the new platform to stay informed on the decisions shaping the future of our favorite language.</p>
HTML,
            ],
            [
                'title'        => 'Pause Polling in Background Tabs in Inertia.js v3.9',
                'category_key' => 'news',
                'author'       => 'Paul Redmond',
                'date'         => '2026-10-13 10:30:00',
                'theme'        => 'purple',
                'is_featured'  => false,
                'resume'       => 'Inertia.js v3.9 brings automatic background tab polling throttling to save client battery and slash unnecessary server requests.',
                'content'      => <<<'HTML'
<h2>Pause Polling in Background Tabs in Inertia.js v3.9</h2>
<p>Real-time dashboards frequently use periodic polling to refresh live stats, notifications, or task execution progress. However, when users leave a tab open in the background, polling can waste server bandwidth and drain mobile battery life.</p>

<h3>Automatic Page Visibility Detection</h3>
<p>Inertia.js v3.9 hooks into the browser Page Visibility API to automatically pause or intelligently back off active poll requests when a user minimizes or switches away from the window:</p>

<pre><code>// In your Vue or React component
usePoll(3000, {
    autoPause: true, // Pauses when tab is inactive
    keepAlive: false,
});
</code></pre>

<p>When the user returns to the tab, Inertia immediately fires a refresh request to catch up with latest state seamlessly.</p>
HTML,
            ],
            [
                'title'        => 'Look What You Helped Me Build',
                'category_key' => 'sponsor',
                'author'       => 'Andy Drexler',
                'date'         => '2026-10-12 16:00:00',
                'theme'        => 'rose',
                'is_featured'  => false,
                'resume'       => 'A developer journey story showcasing how the Laravel open-source ecosystem empowered an indie founder to launch a profitable SaaS application.',
                'content'      => <<<'HTML'
<h2>Look What You Helped Me Build: PuzzleParty</h2>
<p>One year ago, I embarked on a journey to build a collaborative online platform with Laravel, Livewire, and Tailwind CSS. Thanks to the incredible open-source packages, guides, and tools shared by the Laravel community, today PuzzleParty is live and serving thousands of happy users.</p>

<h3>Architectural Lessons Learned</h3>
<ul>
    <li><strong>Livewire Components:</strong> Handling real-time socket connections with Reverb yielded sub-10ms multiplayer state updates.</li>
    <li><strong>Filament Admin:</strong> Built an entire customer support and analytics portal in less than three days.</li>
    <li><strong>Queue Workers:</strong> Scaled background image processing effortlessly across lightweight worker droplets.</li>
</ul>

<p>Thank you to every developer who opens issues, writes blog posts, and publishes open-source packages that empower solo developers to punch way above their weight.</p>
HTML,
            ],
            [
                'title'        => 'BashBox: A Sandboxed Bash Interpreter for AI Agents in PHP',
                'category_key' => 'laravel-packages',
                'author'       => 'Paul Redmond',
                'date'         => '2026-10-12 11:00:00',
                'theme'        => 'cyan',
                'is_featured'  => false,
                'resume'       => 'Execute shell commands and bash scripts generated by autonomous AI agents securely within isolated WebAssembly sandboxes in PHP.',
                'content'      => <<<'HTML'
<h2>BashBox: A Sandboxed Bash Interpreter for AI Agents in PHP</h2>
<p>Giving autonomous AI agents terminal access is powerful for code generation, workspace indexing, and data transforms. However, executing arbitrary bash commands on a host server poses severe security risks.</p>

<h3>Secure Wasm Sandboxing</h3>
<p><strong>BashBox</strong> solves this by running an entire virtualized Linux userspace compiled to WebAssembly directly inside PHP, completely decoupled from host disk, network, and process tables:</p>

<pre><code>use BashBox\Sandbox;

$sandbox = Sandbox::create()
    ->withFilesystem([
        'data.csv' => file_get_contents('data.csv'),
    ])
    ->withTimeout(5);

$result = $sandbox->run('cat data.csv | awk -F"," \'{print $2}\' | sort | uniq -c');

echo $result->output();
</code></pre>

<p>Even if an agent executes dangerous commands like <code>rm -rf /</code>, the blast radius is strictly confined to the in-memory virtual container.</p>
HTML,
            ],
            [
                'title'        => 'Running Laravel\'s Scheduler on Multiple Servers',
                'category_key' => 'laravel-tutorials',
                'author'       => 'Paul Redmond',
                'date'         => '2026-10-09 11:30:00',
                'theme'        => 'purple',
                'is_featured'  => false,
                'resume'       => 'A comprehensive guide to configuring distributed scheduled tasks across multi-server Laravel deployments without duplicate executions.',
                'content'      => <<<'HTML'
<h2>Running Laravel's Scheduler on Multiple Servers</h2>
<p>When running a high-availability infrastructure with multiple web and worker nodes, having every server run <code>php artisan schedule:run</code> can result in duplicate executions of critical tasks (such as customer billing or email dispatches).</p>

<h3>Using the onOneServer() Mutex</h3>
<p>Laravel provides built-in distributed mutex locking through your cache store (Redis, Memcached, or DynamoDB) using the <code>onOneServer()</code> modifier:</p>

<pre><code>// app/Console/Kernel.php or routes/console.php
use Illuminate\Support\Facades\Schedule;

Schedule::command('emails:send-digest')
    ->dailyAt('06:00')
    ->onOneServer();
</code></pre>

<h3>Key Production Tips</h3>
<ul>
    <li><strong>Shared Cache Store:</strong> Ensure all application nodes share the exact same Redis or centralized cache cluster.</li>
    <li><strong>NTP Clock Synchronization:</strong> Verify that server clocks are tightly synchronized with NTP to avoid mutex contention timeouts.</li>
</ul>
HTML,
            ],
            [
                'title'        => 'Laravel Fake Assertions Now Accept Property Arrays',
                'category_key' => 'laravel-tutorials',
                'author'       => 'Paul Redmond',
                'date'         => '2026-10-08 14:00:00',
                'theme'        => 'emerald',
                'is_featured'  => false,
                'resume'       => 'Simplify event, job, and notification testing by passing direct associative arrays to Laravel\'s testing assertions.',
                'content'      => <<<'HTML'
<h2>Laravel Fake Assertions Now Accept Property Arrays</h2>
<p>Writing testing callbacks with <code>Event::assertDispatched(function ($event) { return ...; })</code> can quickly become tedious when you only want to assert that two or three model properties match.</p>

<h3>Compact Assertions</h3>
<p>You can now pass an array of expected property values directly into your assertion methods:</p>

<pre><code>use App\Events\OrderPlaced;
use App\Models\Order;
use Illuminate\Support\Facades\Event;

Event::fake();

// Action triggering event
Order::create(['id' => 101, 'status' => 'confirmed']);

// Cleaner assertion syntax:
Event::assertDispatched(OrderPlaced::class, [
    'orderId' => 101,
    'status'  => 'confirmed',
]);
</code></pre>

<p>This syntax makes testing suites significantly more readable, concise, and easier to maintain across large engineering teams.</p>
HTML,
            ],
            [
                'title'        => 'Route::query() and Model defaults() in Laravel 13.35',
                'category_key' => 'news',
                'author'       => 'Paul Redmond',
                'date'         => '2026-10-07 15:30:00',
                'theme'        => 'amber',
                'is_featured'  => false,
                'resume'       => 'Explore ergonomic developer improvements in Laravel 13.35 including direct query route bindings and declarative Eloquent model attribute defaults.',
                'content'      => <<<'HTML'
<h2>Route::query() and Model defaults() in Laravel 13.35</h2>
<p>Laravel 13.35 brings two highly requested quality-of-life enhancements for routing and Eloquent models.</p>

<h3>Declarative Model Defaults</h3>
<p>Rather than declaring an <code>$attributes</code> array or setting values inside model lifecycle hooks, you can now define default attribute states declaratively:</p>

<pre><code>namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected function defaults(): array
    {
        return [
            'status'   => 'draft',
            'currency' => 'USD',
            'tax_rate' => 0.15,
        ];
    }
}
</code></pre>

<h3>Route Query String Helper</h3>
<p>Accessing sanitized query parameters directly within route closures is now cleaner than ever with <code>Route::query()</code> helpers, avoiding unnecessary dependency injection when handling lightweight redirects.</p>
HTML,
            ],
            [
                'title'        => 'Laravel AI SDK 1.1 Adds Agent Skills and Cohere Chat',
                'category_key' => 'news',
                'author'       => 'Yannick Lyn Fatt',
                'date'         => '2026-10-07 10:00:00',
                'theme'        => 'blue',
                'is_featured'  => false,
                'resume'       => 'The official Laravel AI SDK hits version 1.1 with support for composable Agent Skills, Cohere Chat models, and streaming telemetry hooks.',
                'content'      => <<<'HTML'
<h2>Laravel AI SDK 1.1 Adds Agent Skills and Cohere Chat</h2>
<p>The Laravel AI SDK ecosystem is moving fast. Version 1.1 introduces <strong>Agent Skills</strong>, a standardized pattern for packaging reusable prompt tools, memory stores, and function-calling schemas into modular, shareable packages.</p>

<h3>Registering Agent Skills</h3>
<pre><code>use LaravelAi\Agents\Agent;
use App\Skills\GitHubSearchSkill;
use App\Skills\DatabaseQuerySkill;

$agent = Agent::make('support-bot')
    ->withSkills([
        new GitHubSearchSkill(),
        new DatabaseQuerySkill(),
    ])
    ->withModel('cohere:command-r-plus');

$response = $agent->ask('What issues were created for the payment gateway yesterday?');
</code></pre>

<p>Version 1.1 also adds first-class support for Cohere Command R+, streaming token telemetry, and native integration with Laravel Pulse for LLM latency tracking.</p>
HTML,
            ],
            [
                'title'        => 'VMPal: Give Your AI Agent a Whole Computer',
                'category_key' => 'sponsor',
                'author'       => 'Eric L. Barnes',
                'date'         => '2026-10-06 17:00:00',
                'theme'        => 'rose',
                'is_featured'  => false,
                'resume'       => 'VMPal provides ephemeral, isolated micro-VMs in the cloud for developers running automated code execution and autonomous agent workflows.',
                'content'      => <<<'HTML'
<h2>VMPal: Give Your AI Agent a Whole Computer</h2>
<p>Running autonomous AI agents on shared worker servers introduces massive security and isolation challenges. <strong>VMPal</strong> offers developer-first micro-virtual machines that boot in less than 200 milliseconds via simple REST and WebSocket APIs.</p>

<h3>Instant Ephemeral Environments</h3>
<ul>
    <li><strong>Sub-Second Boot Times:</strong> MicroVMs powered by Firecracker spin up instantaneously on demand.</li>
    <li><strong>Full Root Access:</strong> Agents can install packages, compile code, run tests, and debug network services without endangering production nodes.</li>
    <li><strong>Zero-Leak Teardown:</strong> Once the agent completes its run, the entire environment is wiped clean from RAM.</li>
</ul>

<p>Check out VMPal to run untrusted agent code safely and cost-effectively at any scale.</p>
HTML,
            ],
            [
                'title'        => 'Synapse: A Dev Dashboard for Laravel AI SDK Agents',
                'category_key' => 'laravel-packages',
                'author'       => 'Paul Redmond',
                'date'         => '2026-10-06 14:45:00',
                'theme'        => 'cyan',
                'is_featured'  => false,
                'resume'       => 'Inspect prompt inputs, trace tool executions, monitor token costs, and debug agent thought loops with the Synapse dashboard for Laravel.',
                'content'      => <<<'HTML'
<h2>Synapse: A Dev Dashboard for Laravel AI SDK Agents</h2>
<p>Debugging multi-step autonomous agent runs can feel like staring into a black box. <strong>Synapse</strong> is an open-source development dashboard built with Filament and Livewire that brings visual observability to Laravel AI SDK workflows.</p>

<h3>Key Features</h3>
<pre><code>composer require synapse-dev/synapse-laravel --dev
</code></pre>

<ul>
    <li><strong>Live Execution Timelines:</strong> Visualize reasoning chains, tool invocations, and API payloads in real time.</li>
    <li><strong>Token Cost Calculator:</strong> Track cumulative OpenAI, Anthropic, and Cohere expenditures per user or request.</li>
    <li><strong>Prompt Replay:</strong> Re-execute failed or hallucinated agent steps with adjusted temperature and system instructions.</li>
</ul>

<p>Synapse installs in seconds and provides complete peace of mind when shipping agentic features to production.</p>
HTML,
            ],
            [
                'title'        => 'Decide with Jev: Three Questions in One Request with the Laravel AI SDK',
                'category_key' => 'laravel-tutorials',
                'author'       => 'Harris Raftopoulos',
                'date'         => '2026-10-06 12:15:00',
                'theme'        => 'emerald',
                'is_featured'  => false,
                'resume'       => 'How to minimize API roundtrips and accelerate agent decision matrices by batching multiple reasoning questions into single structured prompts.',
                'content'      => <<<'HTML'
<h2>Decide with Jev: Three Questions in One Request with the Laravel AI SDK</h2>
<p>When designing customer-support triage systems or automated moderation bots, issuing separate LLM queries for classification, sentiment, and urgency wastes money and increases response latency.</p>

<h3>Batching Decisions with Structured Outputs</h3>
<p>By defining a single composite schema, you can extract multiple orthogonal decisions in a single network roundtrip:</p>

<pre><code>use LaravelAi\Facades\Ai;

$assessment = Ai::model('gpt-4o-mini')
    ->schema([
        'sentiment' => 'enum:positive,neutral,negative',
        'requires_escalation' => 'boolean',
        'primary_topic' => 'enum:billing,technical,feature_request',
        'suggested_reply' => 'string',
    ])
    ->prompt("User ticket: {$ticketContent}")
    ->generate();

// Direct access to all decisions in one roundtrip
if ($assessment->requires_escalation) {
    Notification::route('slack', '#critical-support')->notify(...);
}
</code></pre>

<p>This technique cuts API costs by over 60% while drastically improving user-facing responsiveness.</p>
HTML,
            ],
            [
                'title'        => 'Grant: Enum-Based Roles and Permissions for Laravel',
                'category_key' => 'laravel-packages',
                'author'       => 'Yannick Lyn Fatt',
                'date'         => '2026-10-06 09:30:00',
                'theme'        => 'purple',
                'is_featured'  => true,
                'resume'       => 'Grant is a modern, lightweight role and permission authorization package powered entirely by native PHP 8.2+ backed enums.',
                'content'      => <<<'HTML'
<h2>Grant: Enum-Based Roles and Permissions for Laravel</h2>
<p>Traditional permission packages require database migrations for roles, permissions, and intermediate pivot tables. For many SaaS applications with static authorization trees, database lookups add unnecessary query overhead.</p>

<h3>Defining Permissions with Native Enums</h3>
<p><strong>Grant</strong> replaces database tables with native PHP backed enums:</p>

<pre><code>namespace App\Enums;

enum Permission: string
{
    case ViewAnalytics = 'analytics.view';
    case ManageBilling = 'billing.manage';
    case InviteMembers = 'members.invite';
}
</code></pre>

<pre><code>namespace App\Enums;

use Grant\Concerns\HasPermissions;

enum Role: string
{
    use HasPermissions;

    case Admin = 'admin';
    case Member = 'member';

    public function permissions(): array
    {
        return match($this) {
            self::Admin  => Permission::cases(),
            self::Member => [Permission::ViewAnalytics],
        };
    }
}
</code></pre>

<p>Zero database queries, full static analysis, instant autocompletion, and zero authorization drift.</p>
HTML,
            ],
        ];

        $this->command?->info("Seeding " . count($articles) . " October 2026 blog posts...");

        foreach ($articles as $index => $article) {
            $catId = $categories[$article['category_key']] ?? $fallbackCategoryId;
            $slugTitle = Str::slug($article['title']);
            $imgFilename = "posts/{$slugTitle}.jpg";
            $fullImagePath = storage_path("app/public/{$imgFilename}");

            // Generate crisp, modern tech cover image using PHP GD
            $categoryName = $categoriesData[$article['category_key']]['name'] ?? 'News';
            $this->generateCoverImage(
                $fullImagePath,
                $article['title'],
                $categoryName,
                $article['author'],
                date('M d, Y', strtotime($article['date'])),
                $article['theme']
            );

            // Find existing page/post to maintain idempotency
            $existingPage = Page::where('slug', 'blog/post/' . $slugTitle . '.html')->first();
            $post = null;
            if ($existingPage && $existingPage->post_id) {
                $post = Post::find($existingPage->post_id);
            }

            if ($post) {
                $post->update([
                    'user_id'     => $userId,
                    'category_id' => $catId,
                    'content'     => $article['content'],
                    'resume'      => $article['resume'],
                    'is_active'   => true,
                    'is_featured' => $article['is_featured'],
                    'style'       => 'default',
                    'img_cover'   => $imgFilename,
                    'created_at'  => $article['date'],
                    'updated_at'  => $article['date'],
                ]);
            } else {
                $post = Post::create([
                    'user_id'     => $userId,
                    'category_id' => $catId,
                    'content'     => $article['content'],
                    'resume'      => $article['resume'],
                    'is_active'   => true,
                    'is_featured' => $article['is_featured'],
                    'style'       => 'default',
                    'img_cover'   => $imgFilename,
                    'created_at'  => $article['date'],
                    'updated_at'  => $article['date'],
                ]);
            }

            // Create or update Page model linked to Post
            Page::updateOrCreate(
                ['slug' => 'blog/post/' . $slugTitle . '.html'],
                [
                    'post_id'    => $post->id,
                    'user_id'    => $userId,
                    'title'      => $article['title'],
                    'style'      => 'blog',
                    'layout'     => 'default',
                    'blocks'     => [
                        [
                            'data' => [],
                            'type' => 'blog.post',
                        ],
                    ],
                    'is_active'  => true,
                    'created_at' => $article['date'],
                    'updated_at' => $article['date'],
                ]
            );

            $this->command?->line("  ✓ [" . date('M d, Y', strtotime($article['date'])) . "] {$article['title']}");
        }

        $this->command?->info("✓ Successfully seeded " . count($articles) . " October 2026 blog posts!");
    }

    /**
     * Generate a modern, crisp GD image for post cover banner.
     */
    private function generateCoverImage(
        string $filepath,
        string $title,
        string $category,
        string $author,
        string $date,
        string $themeColor = 'purple'
    ): void {
        $width = 1200;
        $height = 675;
        $img = imagecreatetruecolor($width, $height);

        $themes = [
            'blue'    => ['bg1' => [15, 23, 42],  'bg2' => [30, 58, 138],  'accent' => [59, 130, 246]],
            'purple'  => ['bg1' => [15, 23, 42],  'bg2' => [88, 28, 135],  'accent' => [168, 85, 247]],
            'emerald' => ['bg1' => [15, 23, 42],  'bg2' => [6, 78, 59],    'accent' => [16, 185, 129]],
            'rose'    => ['bg1' => [15, 23, 42],  'bg2' => [159, 18, 57],  'accent' => [244, 63, 94]],
            'amber'   => ['bg1' => [15, 23, 42],  'bg2' => [120, 53, 15],  'accent' => [245, 158, 11]],
            'cyan'    => ['bg1' => [15, 23, 42],  'bg2' => [22, 78, 99],   'accent' => [6, 182, 212]],
        ];

        $palette = $themes[$themeColor] ?? $themes['blue'];

        // Vertical gradient background
        for ($y = 0; $y < $height; $y++) {
            $ratio = $y / $height;
            $r = (int) ($palette['bg1'][0] * (1 - $ratio) + $palette['bg2'][0] * $ratio);
            $g = (int) ($palette['bg1'][1] * (1 - $ratio) + $palette['bg2'][1] * $ratio);
            $b = (int) ($palette['bg1'][2] * (1 - $ratio) + $palette['bg2'][2] * $ratio);
            $color = imagecolorallocate($img, $r, $g, $b);
            imageline($img, 0, $y, $width, $y, $color);
        }

        // Subtle glowing ambient circle on top right
        $glowColor = imagecolorallocatealpha($img, $palette['accent'][0], $palette['accent'][1], $palette['accent'][2], 105);
        for ($r = 350; $r > 0; $r -= 15) {
            imagefilledellipse($img, 1020, 140, $r * 2, $r * 2, $glowColor);
        }

        // Subtle geometric grid background
        $gridColor = imagecolorallocatealpha($img, 255, 255, 255, 118);
        for ($x = 0; $x < $width; $x += 65) {
            imageline($img, $x, 0, $x, $height, $gridColor);
        }
        for ($y = 0; $y < $height; $y += 65) {
            imageline($img, 0, $y, $width, $y, $gridColor);
        }

        // Fonts candidate check
        $fontBoldCandidates = [
            resource_path('fonts/bold.ttf'),
            '/usr/share/fonts/truetype/quicksand/Quicksand-Bold.ttf',
            '/usr/share/fonts/truetype/freefont/FreeSansBold.ttf',
            '/usr/share/fonts/TTF/OpenSans-Bold.ttf',
            '/usr/share/fonts/dejavu/DejaVuSans-Bold.ttf',
        ];

        $fontRegularCandidates = [
            resource_path('fonts/regular.ttf'),
            '/usr/share/fonts/truetype/freefont/FreeSans.ttf',
            '/usr/share/fonts/truetype/quicksand/Quicksand-Regular.ttf',
            '/usr/share/fonts/TTF/OpenSans-Regular.ttf',
            '/usr/share/fonts/dejavu/DejaVuSans.ttf',
        ];

        $fontBold = null;
        foreach ($fontBoldCandidates as $candidate) {
            if (file_exists($candidate) && is_readable($candidate)) {
                $fontBold = $candidate;
                break;
            }
        }

        $fontRegular = null;
        foreach ($fontRegularCandidates as $candidate) {
            if (file_exists($candidate) && is_readable($candidate)) {
                $fontRegular = $candidate;
                break;
            }
        }

        $badgeBg = imagecolorallocate($img, $palette['accent'][0], $palette['accent'][1], $palette['accent'][2]);
        $white = imagecolorallocate($img, 255, 255, 255);
        $lightGray = imagecolorallocate($img, 203, 213, 225);
        $accentText = imagecolorallocate($img, $palette['accent'][0], $palette['accent'][1], $palette['accent'][2]);

        $renderText = function ($img, float $size, float $angle, int $x, int $y, int $color, ?string $fontFile, string $text) {
            if ($fontFile && file_exists($fontFile) && function_exists('imagettftext')) {
                @imagettftext($img, $size, $angle, $x, $y, $color, $fontFile, $text);
            } else {
                imagestring($img, 5, $x, max(10, $y - 18), $text, $color);
            }
        };

        // Draw Badge
        $badgeText = strtoupper($category);
        $badgeWidth = (strlen($badgeText) * 14) + 36;
        imagefilledrectangle($img, 80, 80, 80 + $badgeWidth, 125, $badgeBg);
        $renderText($img, 14, 0, 98, 110, $white, $fontBold, $badgeText);

        // Draw Title (wrapped cleanly)
        $wrappedTitle = wordwrap($title, 34, "\n");
        $lines = explode("\n", $wrappedTitle);
        $startY = 220;
        foreach ($lines as $i => $line) {
            $renderText($img, 32, 0, 80, $startY + ($i * 54), $white, $fontBold, trim($line));
        }

        // Draw Footer (Author, Date, Brand)
        $footerY = 580;
        $renderText($img, 18, 0, 80, $footerY, $lightGray, $fontRegular, 'By ' . $author . '  •  ' . $date);
        $renderText($img, 18, 0, $width - 260, $footerY, $accentText, $fontBold, 'LARAVEL NEWS');

        imagejpeg($img, $filepath, 92);
        imagedestroy($img);
    }
}
