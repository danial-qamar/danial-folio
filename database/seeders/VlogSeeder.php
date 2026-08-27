<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Page;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class VlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Get or fallback User ID
        $userId = User::first()?->id ?? 1;

        // 2. Ensure Categories exist with clean slugs, names, icons, and hex colors
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

        // 3. Articles published AFTER August 17, 2026 (Aug 18 - Aug 26, 2026)
        $vlogs = [
            [
                'title'       => 'Compile PHP to Native Binaries with TypePHP',
                'category_key'=> 'news',
                'author'      => 'Eric L. Barnes',
                'date'        => '2026-08-26 16:30:00',
                'theme'       => 'purple',
                'is_featured' => true,
                'resume'      => 'TypePHP enables ahead-of-time (AOT) compilation of typed PHP source code into standalone, self-contained native machine binaries without embedding an entire PHP runtime.',
                'content'     => <<<'HTML'
<h2>Ahead-Of-Time Native Binaries for Modern PHP</h2>
<p>The PHP community has taken a monumental leap forward with <strong>TypePHP</strong>, an open-source toolchain that compiles strictly typed PHP source code into native, standalone binary executables for Linux (x86_64, arm64) and macOS.</p>

<p>Unlike traditional tools such as Micro-PHP or Static-PHP CLI which bundle a minimized PHP C engine alongside user scripts, TypePHP translates PHP AST directly into LLVM IR. The result is zero-dependency machine code with microsecond startup times and drastically reduced memory footprints.</p>

<h3>Key Architectural Features</h3>
<ul>
    <li><strong>AOT Native Compilation:</strong> Eliminates opcode compilation overhead by compiling typed PHP classes into machine code.</li>
    <li><strong>Zero-Dependency Distribution:</strong> Target binaries run without requiring PHP, FPM, or external extensions pre-installed on host systems.</li>
    <li><strong>Strict Typing Enforcement:</strong> Leverages PHP 8.4 property types, return types, and generics syntax for aggressive optimizer passes.</li>
</ul>

<h3>Compiling Your First Binary</h3>
<p>Here is an example of compiling a CLI utility written in PHP into a native executable:</p>

<pre><code>// src/main.php
declare(strict_types=1);

namespace App;

final class Benchmark
{
    public static function run(int $iterations): float
    {
        $start = microtime(true);
        $sum = 0;
        for ($i = 0; $i &lt; $iterations; $i++) {
            $sum += $i;
        }
        return microtime(true) - $start;
    }
}

$elapsed = Benchmark::run(10000000);
echo "Executed in {$elapsed} seconds\n";
</code></pre>

<p>Building the executable with the TypePHP compiler CLI:</p>

<pre><code>$ typephp build src/main.php --output bin/benchmark --optimize=O3
Building target: bin/benchmark [x86_64-linux-gnu]
[1/3] Parsing AST & type checking... Done.
[2/3] Generating LLVM IR & applying O3 optimization... Done.
[3/3] Linking native binary... Done (Size: 4.2 MB).

$ ./bin/benchmark
Executed in 0.00312 seconds
</code></pre>

<p>TypePHP opens up exciting possibilities for building high-performance CLI tools, edge workers, and lightweight microservices using familiar PHP syntax.</p>
HTML,
            ],
            [
                'title'       => 'State of Laravel 2026 Survey Is Now Open',
                'category_key'=> 'news',
                'author'      => 'Eric L. Barnes',
                'date'        => '2026-08-26 14:15:00',
                'theme'       => 'rose',
                'is_featured' => true,
                'resume'      => 'The official State of Laravel 2026 community survey is live. Share your experience with Laravel 13, server deployments, AI tools, and frontend stacks.',
                'content'     => <<<'HTML'
<h2>Participate in the Annual State of Laravel Survey</h2>
<p>The annual <strong>State of Laravel 2026</strong> community survey is officially open for responses. Hosted by Laravel News, this survey collects benchmark data from tens of thousands of developers worldwide to map ecosystem growth, framework trends, and tooling preferences.</p>

<h3>Key Focus Areas for 2026</h3>
<p>This year’s survey explores several major shifts across the Laravel ecosystem:</p>
<ul>
    <li><strong>Laravel 13 & PHP 8.4 Adoption:</strong> Upgrades, adoption blockers, and performance gains reported across production applications.</li>
    <li><strong>Frontend Stacks:</strong> Comparative usage rates between Livewire 3, Inertia.js (Vue 3 / React), traditional Blade components, and hybrid mobile solutions like NativePHP.</li>
    <li><strong>Application Runtimes & Deployment:</strong> Transition rates towards FrankenPHP, Laravel Herd Pro, Docker containers, and serverless architectures like Laravel Vapor.</li>
    <li><strong>AI Integration:</strong> How developers are utilizing the official Laravel AI SDK, local LLM integrations, and AI coding agents inside their teams.</li>
</ul>

<h3>How to Take the Survey</h3>
<p>The survey takes approximately 5 minutes to complete and is completely anonymous. Aggregated survey results and interactive charts will be published next month.</p>
HTML,
            ],
            [
                'title'       => 'Testing Best Practices Skill in Laravel Boost v2.6.0',
                'category_key'=> 'news',
                'author'      => 'Yannick Lyn Fatt',
                'date'        => '2026-08-26 11:00:00',
                'theme'       => 'blue',
                'is_featured' => false,
                'resume'      => 'Laravel Boost v2.6.0 introduces an automated testing audit skill for Pest PHP and PHPUnit, enforcing AAA patterns, clean dataset generation, and isolated state assertions.',
                'content'     => <<<'HTML'
<h2>Automated Test Suite Auditing with Laravel Boost v2.6.0</h2>
<p>The latest release of <strong>Laravel Boost (v2.6.0)</strong> adds a dedicated <em>Testing Best Practices Skill</em>. This feature automates code quality reviews across Pest PHP and PHPUnit suites to guarantee clean test architecture and prevent flaky test suites.</p>

<h3>Enforced Testing Principles</h3>
<ul>
    <li><strong>Arrange-Act-Assert (AAA) Discipline:</strong> Enforces distinct visual and logical boundaries between test setup, code invocation, and state verification.</li>
    <li><strong>Dataset Generator Optimization:</strong> Replaces hardcoded loops with expressive Pest dataset generators.</li>
    <li><strong>Database Isolation Verification:</strong> Flags missing <code>RefreshDatabase</code> or <code>DatabaseTransactions</code> traits on tests that mutate persistent state.</li>
    <li><strong>Precise Mocking Assertions:</strong> Detects over-mocking and ensures container facade mocks assert exact argument shapes.</li>
</ul>

<h3>Pest Best Practices Example</h3>
<pre><code>// Refactored Pest AAA Pattern
it('dispatches welcome notification upon registration', function () {
    // Arrange
    Notification::fake();
    $payload = User::factory()->raw(['password' => 'secret123']);

    // Act
    $response = $this->post(route('register'), $payload);

    // Assert
    $response->assertRedirect(route('dashboard'));
    Notification::assertSentTo(
        User::where('email', $payload['email'])->first(),
        WelcomeNotification::class
    );
});
</code></pre>
HTML,
            ],
            [
                'title'       => 'Query Binding Masking and whereBinary() in Laravel 13.27',
                'category_key'=> 'news',
                'author'      => 'Paul Redmond',
                'date'        => '2026-08-26 09:45:00',
                'theme'       => 'emerald',
                'is_featured' => false,
                'resume'      => 'Laravel 13.27 introduces automatic sensitive binding masking in query logs and Telescope, alongside a dedicated whereBinary() builder method.',
                'content'     => <<<'HTML'
<h2>Enhanced Privacy & Binary Queries in Laravel 13.27</h2>
<p>Laravel 13.27 brings two major database improvements: <strong>Query Binding Masking</strong> for masking secret attributes in database logs and a new <code>whereBinary()</code> method on the Eloquent Query Builder.</p>

<h3>Masking Sensitive Query Bindings</h3>
<p>When logging executed SQL queries in development or production diagnostics, sensitive parameters (like passwords, API keys, or SSNs) could previously leak into plain text logs. With Laravel 13.27, attributes marked as hidden or sensitive on models are automatically redacted in query logs:</p>

<pre><code>use App\Models\User;
use Illuminate\Support\Facades\DB;

// Query logging with automatic masking enabled
DB::listen(function ($query) {
    logger()->info($query->sql, $query->maskedBindings());
});

User::where('api_token', 'secret_token_12345')->first();
// Log Output: select * from "users" where "api_token" = [REDACTED]
</code></pre>

<h3>Using the <code>whereBinary()</code> Builder Method</h3>
<pre><code>use App\Models\Document;

$hash = hash('sha256', 'payload-contents', true); // Raw binary

$document = Document::whereBinary('checksum', '=', $hash)->first();
</code></pre>
HTML,
            ],
            [
                'title'       => 'Laravel AI: Load Tools On Demand With ToolSearch',
                'category_key'=> 'news',
                'author'      => 'Yannick Lyn Fatt',
                'date'        => '2026-08-26 08:00:00',
                'theme'       => 'purple',
                'is_featured' => false,
                'resume'      => 'Reduce context window bloat in AI agents by dynamically loading tools on demand using ToolSearch in Laravel AI SDK.',
                'content'     => <<<'HTML'
<h2>Dynamic Tool Discovery in Laravel AI</h2>
<p>When building complex AI agents with hundreds of available functions (such as CRM actions, database queries, and external APIs), sending every tool schema in the system prompt wastes context window tokens and increases response latency.</p>

<p>The Laravel AI SDK solves this with <strong>ToolSearch</strong>, allowing agents to dynamically query and activate only the tools necessary for the user's specific request.</p>

<pre><code>use Laravel\AI\Agent;
use Laravel\AI\Tools\ToolSearch;
use App\AI\Tools\CreateInvoice;
use App\AI\Tools\SendSlackNotification;

class SupportAgent extends Agent
{
    public function tools(): array
    {
        return [
            ToolSearch::make([
                CreateInvoice::class,
                SendSlackNotification::class,
            ])->threshold(0.75),
        ];
    }
}
</code></pre>
HTML,
            ],
            [
                'title'       => 'Laravel Auditor Audits Your App With Your Own AI Agent',
                'category_key'=> 'laravel-packages',
                'author'      => 'Paul Redmond',
                'date'        => '2026-08-25 15:20:00',
                'theme'       => 'amber',
                'is_featured' => true,
                'resume'      => 'Laravel Auditor is an open-source package that deploys an autonomous AI security agent to scan routes, middleware policies, and database bottlenecks.',
                'content'     => <<<'HTML'
<h2>Autonomous Security & Performance Audits in Laravel</h2>
<p><strong>Laravel Auditor</strong> is a new open-source package designed to run automated security, vulnerability, and performance audits on your application codebase using local or cloud AI models.</p>

<h3>Key Audit Capabilities</h3>
<ul>
    <li><strong>Authorization Policy Checks:</strong> Scans routes and controllers to flag missing policy checks.</li>
    <li><strong>N+1 Query Detection:</strong> Analyzes Blade templates and API resources for un-eager-loaded relationships.</li>
    <li><strong>Mass Assignment & Input Hygiene:</strong> Identifies unvalidated request arrays passed into Eloquent calls.</li>
</ul>

<pre><code>$ php artisan audit:run --deep

[+] Analyzing Application Routes (142 routes)...
[+] Auditing Authorization Policies...
[+] Scanning Eloquent Queries...
    [ALERT] Potential N+1 query in resources/views/orders/index.blade.php:34
</code></pre>
HTML,
            ],
            [
                'title'       => 'A simple form builder that stays out of your way',
                'category_key'=> 'sponsor',
                'author'      => 'Andreas M.',
                'date'        => '2026-08-24 17:00:00',
                'theme'       => 'cyan',
                'is_featured' => false,
                'resume'      => 'Discover a lightweight Blade form builder component library focused on accessibility, custom markup freedom, and zero framework clutter.',
                'content'     => <<<'HTML'
<h2>Clean, Accessible Blade Forms Without the Bloat</h2>
<p>Building forms in Blade can quickly become repetitive, yet heavy form builder packages often restrict HTML markup and force opinionated CSS styling. <strong>FormCraft Blade</strong> offers a developer-friendly middle ground.</p>

<pre><code>&lt;x-form action="{{ route('profile.update') }}" method="PUT" class="space-y-6"&gt;
    &lt;x-form-input name="username" label="Username" :value="$user-&gt;username" required /&gt;
    &lt;x-form-email name="email" label="Email Address" :value="$user-&gt;email" required /&gt;
    &lt;x-form-submit class="btn-primary"&gt;Save Changes&lt;/x-form-submit&gt;
&lt;/x-form&gt;
</code></pre>
HTML,
            ],
            [
                'title'       => 'Laravel AI: Trace Agent Runs With Lifecycle Events',
                'category_key'=> 'news',
                'author'      => 'Yannick Lyn Fatt',
                'date'        => '2026-08-24 13:30:00',
                'theme'       => 'purple',
                'is_featured' => false,
                'resume'      => 'Hook into agent execution pipelines with real-time lifecycle events in Laravel AI SDK for custom metrics, WebSockets, and audit logging.',
                'content'     => <<<'HTML'
<h2>Real-time Telemetry with Laravel AI Lifecycle Events</h2>
<p>As AI agents become core components of enterprise Laravel applications, gaining visibility into every step of an agent's execution loop is crucial. The latest Laravel AI SDK updates introduce fine-grained <strong>Lifecycle Events</strong>.</p>

<h3>Dispatched Lifecycle Events</h3>
<ul>
    <li><code>AgentStarting</code>: Fired when an agent run initiates with prompt context.</li>
    <li><code>ToolExecuting</code>: Fired immediately before a tool function is invoked.</li>
    <li><code>ToolExecuted</code>: Fired after a tool returns execution results.</li>
    <li><code>AgentCompleted</code>: Fired when the agent completes its response pipeline.</li>
</ul>
HTML,
            ],
            [
                'title'       => 'Laravel AI: Get Raw HTTP Responses and Rate Limits',
                'category_key'=> 'news',
                'author'      => 'Yannick Lyn Fatt',
                'date'        => '2026-08-24 10:15:00',
                'theme'       => 'blue',
                'is_featured' => false,
                'resume'      => 'Inspect provider response headers, token usage quotas, and raw JSON payloads directly through the Laravel AI HTTP client.',
                'content'     => <<<'HTML'
<h2>Inspecting HTTP Headers & Quotas in Laravel AI</h2>
<p>Debugging AI model integrations requires visibility into low-level HTTP responses, rate limit reset times, and exact token counts returned by providers like OpenAI, Anthropic, and Ollama.</p>

<pre><code>use Laravel\AI\Facades\AI;

$response = AI::agent('coder')
    ->prompt('Write a PHP regex pattern for emails')
    ->withRawResponse()
    ->run();

$statusCode = $response->status(); // 200
$remainingRequests = $response->header('x-ratelimit-remaining-requests');
$tokenUsage = $response->usage();
</code></pre>
HTML,
            ],
            [
                'title'       => 'Agent Run Observability in Laravel AI SDK 0.11',
                'category_key'=> 'news',
                'author'      => 'Yannick Lyn Fatt',
                'date'        => '2026-08-21 16:00:00',
                'theme'       => 'rose',
                'is_featured' => false,
                'resume'      => 'Laravel AI SDK 0.11 brings native OpenTelemetry support, flame-graphs for multi-turn agent chains, and integrated latency tracing.',
                'content'     => <<<'HTML'
<h2>OpenTelemetry & Flame-Graphs for AI Agents</h2>
<p>The release of <strong>Laravel AI SDK 0.11</strong> focuses on production observability. Developers can now trace multi-turn agent conversations across distributed microservices with native OpenTelemetry integrations.</p>

<pre><code>// config/ai.php
return [
    'observability' => [
        'enabled'  => env('AI_OBSERVABILITY_ENABLED', true),
        'driver'   => 'opentelemetry',
        'endpoint' => env('OTEL_EXPORTER_OTLP_ENDPOINT', 'http://localhost:4318'),
    ],
];
</code></pre>
HTML,
            ],
            [
                'title'       => 'Debounced Queued Event Listeners in Laravel',
                'category_key'=> 'news',
                'author'      => 'Paul Redmond',
                'date'        => '2026-08-21 11:30:00',
                'theme'       => 'emerald',
                'is_featured' => false,
                'resume'      => 'Prevent queue flooding by defining $debounce durations on queued event listeners in Laravel.',
                'content'     => <<<'HTML'
<h2>Native Event Listener Debouncing in Laravel</h2>
<p>When user actions trigger frequent database updates, dispatching queued event listeners for every single update can flood queue workers. Laravel now supports native listener debouncing directly on queued event listeners.</p>

<pre><code>namespace App\Listeners;

use App\Events\UserProfileUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReindexUserProfile implements ShouldQueue
{
    public int $debounce = 30;

    public function handle(UserProfileUpdated $event): void
    {
        IndexingService::reindex($event->user);
    }
}
</code></pre>
HTML,
            ],
            [
                'title'       => 'Statamic Mailables Viewer Previews Laravel Emails in the Control Panel',
                'category_key'=> 'news',
                'author'      => 'Eric L. Barnes',
                'date'        => '2026-08-20 18:00:00',
                'theme'       => 'purple',
                'is_featured' => false,
                'resume'      => 'Statamic\'s new Mailables Viewer addon allows content managers and developers to preview and test Laravel Blade emails directly inside the control panel.',
                'content'     => <<<'HTML'
<h2>Interactive Email Previews in Statamic</h2>
<p>Statamic has released <strong>Mailables Viewer</strong>, an official addon that embeds interactive Laravel email previews directly inside the Statamic Control Panel.</p>

<pre><code>$ composer require statamic/mailables-viewer --dev
</code></pre>
HTML,
            ],
            [
                'title'       => 'Laravel Tackle: Run an AI Coding Agent in Your Laravel App',
                'category_key'=> 'laravel-packages',
                'author'      => 'Yannick Lyn Fatt',
                'date'        => '2026-08-20 14:10:00',
                'theme'       => 'amber',
                'is_featured' => false,
                'resume'      => 'Laravel Tackle is an embedded coding agent package that automates migrations, refactoring, and Pest tests via artisan commands.',
                'content'     => <<<'HTML'
<h2>Automated Coding Tasks with Laravel Tackle</h2>
<p><strong>Laravel Tackle</strong> brings an autonomous coding assistant into your local Laravel environment. Designed for rapid iteration, Tackle can create database migrations, write controller actions, and generate Pest test suites.</p>

<pre><code>$ php artisan tackle:make "Create a subscription billing migration and model with status and renewal_date"
</code></pre>
HTML,
            ],
            [
                'title'       => 'Queue::forward(): Reroute Laravel Queues in One Place',
                'category_key'=> 'news',
                'author'      => 'Paul Redmond',
                'date'        => '2026-08-20 09:30:00',
                'theme'       => 'blue',
                'is_featured' => false,
                'resume'      => 'Simplify queue management with Queue::forward(), allowing dynamic job rerouting to high-priority workers or dead-letter queues.',
                'content'     => <<<'HTML'
<h2>Dynamic Job Routing with Queue::forward()</h2>
<p>Rerouting failed jobs or forwarding specific background tasks based on payload attributes previously required modifying individual job classes. Laravel introduces <code>Queue::forward()</code> to handle centralized job routing.</p>

<pre><code>use Illuminate\Support\Facades\Queue;
use App\Jobs\ProcessVideoUpload;

Queue::forward(ProcessVideoUpload::class, function (ProcessVideoUpload $job) {
    if ($job->fileSize > 500 * 1024 * 1024) {
        return 'heavy-video-processing';
    }
    return 'default';
});
</code></pre>
HTML,
            ],
            [
                'title'       => 'Laravel Read-Through Filesystem: Lazy Storage Migration',
                'category_key'=> 'news',
                'author'      => 'Paul Redmond',
                'date'        => '2026-08-19 15:45:00',
                'theme'       => 'emerald',
                'is_featured' => false,
                'resume'      => 'Seamlessly migrate local storage assets to S3 cloud buckets on demand with Laravel\'s Read-Through Filesystem adapter.',
                'content'     => <<<'HTML'
<h2>Lazy File Migration with Read-Through Filesystem</h2>
<p>Migrating millions of user uploads from local disks to AWS S3 or Cloudflare R2 often involves risky script deployments. Laravel's new <strong>Read-Through Filesystem</strong> driver simplifies cloud migrations by lazily transferring files on request.</p>

<pre><code>'disks' => [
    's3_read_through' => [
        'driver'       => 'read-through',
        'primary'      => 's3',
        'fallback'     => 'local',
        'auto_migrate' => true,
    ],
],
</code></pre>
HTML,
            ],
            [
                'title'       => 'Read-Through Disks and Debounced Listeners in Laravel 13.26',
                'category_key'=> 'news',
                'author'      => 'Paul Redmond',
                'date'        => '2026-08-19 10:20:00',
                'theme'       => 'cyan',
                'is_featured' => false,
                'resume'      => 'Explore the highlights of Laravel 13.26 including read-through storage drivers, debounced listeners, and Pest 3 test assertions.',
                'content'     => <<<'HTML'
<h2>Laravel 13.26 Release Notes</h2>
<p>Laravel 13.26 is officially available! This release packs powerful storage and queuing features along with several developer experience enhancements.</p>

<ul>
    <li><strong>Read-Through Disks:</strong> Native lazy storage migration between local and cloud disks.</li>
    <li><strong>Debounced Listeners:</strong> Granular control over event listener execution windows.</li>
    <li><strong>Pest 3 Assertions:</strong> Added <code>assertDispatchedTimes()</code> and improved mock type hints.</li>
</ul>
HTML,
            ],
            [
                'title'       => 'Lerd: A Free, Open Source Herd Alternative for Linux and macOS',
                'category_key'=> 'sponsor',
                'author'      => 'George Dumitrescu',
                'date'        => '2026-08-18 16:50:00',
                'theme'       => 'purple',
                'is_featured' => false,
                'resume'      => 'Lerd is an open-source development environment manager for Linux and macOS with native FrankenPHP, Nginx, and PHP multi-version support.',
                'content'     => <<<'HTML'
<h2>Lightweight Local Development with Lerd</h2>
<p>Linux developers looking for a fast, native local development environment manager can now use <strong>Lerd</strong>, an open-source alternative to Laravel Herd built for Linux (Ubuntu, Debian, Fedora, Arch) and macOS.</p>

<pre><code>$ lerd park
$ lerd link my-app
$ lerd isolate 8.4
</code></pre>
HTML,
            ],
            [
                'title'       => 'Let\'s Encrypt HTTPS on an IP Address With FrankenPHP',
                'category_key'=> 'news',
                'author'      => 'Yannick Lyn Fatt',
                'date'        => '2026-08-18 12:10:00',
                'theme'       => 'rose',
                'is_featured' => false,
                'resume'      => 'Learn how to configure automatic Let\'s Encrypt TLS certificates directly on public IP addresses using FrankenPHP.',
                'content'     => <<<'HTML'
<h2>Automated TLS on Raw IP Addresses with FrankenPHP</h2>
<p>Traditionally, obtaining automated Let's Encrypt TLS certificates required a fully qualified domain name (FQDN). With recent ACME protocol updates and FrankenPHP's integrated Caddy web server, obtaining HTTPS certificates directly on public IP addresses is now straightforward.</p>

<pre><code># Caddyfile
203.0.113.45 {
    tls admin@example.com
    
    frankenphp {
        web_root /var/www/html/public
    }
}
</code></pre>
HTML,
            ],
            [
                'title'       => 'Laravel Chores: Resumable Data Operations and Cleanups',
                'category_key'=> 'laravel-packages',
                'author'      => 'Paul Redmond',
                'date'        => '2026-08-18 08:30:00',
                'theme'       => 'amber',
                'is_featured' => false,
                'resume'      => 'Laravel Chores is a package for executing idempotent, resumable background data cleanup operations with state persistence.',
                'content'     => <<<'HTML'
<h2>Idempotent Data Operations with Laravel Chores</h2>
<p>Running multi-hour database cleanups or data backfills in production can be prone to network timeouts or queue worker restarts. <strong>Laravel Chores</strong> provides a resilient structure for defining resumable background operations.</p>

<pre><code>namespace App\Chores;

use Laravel\Chores\Chore;

class PruneOldAuditLogs extends Chore
{
    public int $chunkSize = 5000;

    public function handle(): void
    {
        AuditLog::where('created_at', '<', now()->subYears(2))
            ->chunkById($this->chunkSize, function ($logs) {
                foreach ($logs as $log) {
                    $log->delete();
                    $this->advance();
                }
            });
    }
}
</code></pre>
HTML,
            ],
        ];

        foreach ($vlogs as $index => $vlog) {
            $catId = $categories[$vlog['category_key']] ?? $fallbackCategoryId;
            $slugTitle = Str::slug($vlog['title']);
            $imgFilename = "posts/{$slugTitle}.jpg";
            $fullImagePath = storage_path("app/public/{$imgFilename}");

            // Generate crisp, modern tech cover image using PHP GD
            $categoryName = $categoriesData[$vlog['category_key']]['name'] ?? 'News';
            $this->generateCoverImage(
                $fullImagePath,
                $vlog['title'],
                $categoryName,
                $vlog['author'],
                date('M d, Y', strtotime($vlog['date'])),
                $vlog['theme']
            );

            // Create or update Post model
            $post = Post::create([
                'user_id'     => $userId,
                'category_id' => $catId,
                'content'     => $vlog['content'],
                'resume'      => $vlog['resume'],
                'is_active'   => true,
                'is_featured' => $vlog['is_featured'],
                'style'       => 'default',
                'img_cover'   => $imgFilename,
                'created_at'  => $vlog['date'],
                'updated_at'  => $vlog['date'],
            ]);

            // Create Page model linked to Post (updateOrCreate to ensure idempotency)
            Page::updateOrCreate(
                ['slug' => 'blog/post/' . $slugTitle . '.html'],
                [
                    'post_id'    => $post->id,
                    'user_id'    => $userId,
                    'title'      => $vlog['title'],
                    'style'      => 'blog',
                    'layout'     => 'default',
                    'blocks'     => [
                        [
                            'data' => [],
                            'type' => 'blog.post',
                        ],
                    ],
                    'is_active'  => true,
                    'created_at' => $vlog['date'],
                    'updated_at' => $vlog['date'],
                ]
            );
        }
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

        // Fonts candidate check: repository bundled fonts first, then server system fonts
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
                // GD Built-in font fallback (font 5)
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
