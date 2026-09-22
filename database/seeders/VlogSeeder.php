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

        // 3. Articles published from September 04 to September 21, 2026
        $vlogs = [
            [
                'title'       => 'What We Know About Laravel 14',
                'category_key'=> 'news',
                'author'      => 'Paul Redmond',
                'date'        => '2026-09-21 16:00:00',
                'theme'       => 'rose',
                'is_featured' => true,
                'resume'      => 'An in-depth preview of what is coming in Laravel 14, including PHP 8.4+ requirement, enhanced container performance, updated defaults, and deprecation timelines.',
                'content'     => <<<'HTML'
<h2>What We Know About Laravel 14</h2>
<p>As the Laravel ecosystem continues its relentless pace of innovation, attention has begun turning toward the upcoming release of <strong>Laravel 14</strong>. Following the annual release cadence established in recent years, Laravel 14 brings modern language primitives, aggressive container optimizations, and clean developer workflows.</p>

<h3>PHP 8.4 Minimum Requirement</h3>
<p>Laravel 14 will officially require <strong>PHP 8.4</strong> or higher. This requirement unlocks several powerful PHP language improvements across framework internals:</p>
<ul>
    <li><strong>Property Hooks:</strong> Built-in property get/set hooks drastically reduce the boilerplate needed for custom Eloquent model accessors and mutators.</li>
    <li><strong>Asymmetric Visibility:</strong> Native <code>public private(set)</code> modifiers will enhance immutability on core framework value objects and events.</li>
    <li><strong>New Array Find Functions:</strong> Native <code>array_find()</code>, <code>array_find_key()</code>, and <code>array_any()</code> functions directly reduce auxiliary collection overhead.</li>
</ul>

<h3>Container & Dependency Injection Speedups</h3>
<p>Early benchmarks from core contributors show noticeable performance improvements in service container resolution. By taking advantage of pre-compiled reflection caches and streamlined pipeline middleware, application boot times and memory usage have been trimmed down across high-concurrency requests.</p>

<pre><code>// Utilizing PHP 8.4 property hooks in Laravel 14 models
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    public float $amount;

    public string $formattedAmount {
        get => '$' . number_format($this->amount, 2);
    }
}
</code></pre>

<h3>Deprecations and Smooth Upgrade Path</h3>
<p>Consistent with Laravel's commitment to developer ergonomics, Laravel 14 maintains an effortless upgrade path for apps on Laravel 13. Upgrading via Laravel Shift or Composer will take less than thirty minutes for most compliant applications.</p>
HTML,
            ],
            [
                'title'       => 'Difflock: Lint Laravel Migrations and Diff Your Schema',
                'category_key'=> 'laravel-packages',
                'author'      => 'Yannick Lyn Fatt',
                'date'        => '2026-09-18 14:30:00',
                'theme'       => 'purple',
                'is_featured' => true,
                'resume'      => 'Difflock is a migration linter and schema diffing tool for Laravel that flags destructive changes, dropped columns, and unindexed foreign keys in CI/CD before deployment.',
                'content'     => <<<'HTML'
<h2>Schema Safety with Difflock</h2>
<p>Database migrations are often the highest-risk step in continuous deployment pipelines. Accidental column renames, missing foreign key indexes, and table locking operations can cause unexpected downtime on production databases. <strong>Difflock</strong> is an open-source schema diffing and migration linting tool tailored specifically for Laravel.</p>

<h3>Catching Destructive Changes in CI/CD</h3>
<p>Difflock analyzes your migration files against a snapshot of your current production schema. It instantly detects risky patterns such as:</p>
<ul>
    <li>Dropping columns without zero-downtime deprecation steps.</li>
    <li>Adding non-nullable columns without fallback default values.</li>
    <li>Creating foreign keys without underlying indexes, leading to cascading table locks.</li>
    <li>Modifying large table structures on PostgreSQL or MySQL that trigger full table rewrites.</li>
</ul>

<h3>Running the Difflock Linter</h3>
<pre><code># Install Difflock via Composer
composer require --dev difflock/difflock-laravel

# Run migration lint check
php artisan difflock:lint

# Output:
# [FAIL] 2026_09_18_000001_update_orders_table.php
#   Line 18: Dropping column 'legacy_status' without a 2-step migration strategy.
#   Line 22: Added foreignId 'customer_id' missing index on large table 'orders'.
</code></pre>

<p>By embedding <code>php artisan difflock:lint</code> into your GitHub Actions workflow, your team can guarantee zero database regression accidents.</p>
HTML,
            ],
            [
                'title'       => 'Fresh Package: Laravel Package Skeleton with Testbench, CI, and Boost Integration',
                'category_key'=> 'laravel-packages',
                'author'      => 'Paul Redmond',
                'date'        => '2026-09-17 16:30:00',
                'theme'       => 'cyan',
                'is_featured' => false,
                'resume'      => 'Fresh Package provides a modern boilerplate for developing Laravel packages, equipped with Orchestra Testbench, GitHub Actions CI matrices, Pest PHP, and Laravel Boost.',
                'content'     => <<<'HTML'
<h2>Modern Package Development with Fresh Package</h2>
<p>Creating a reusable Laravel package often involves hours of repetitive setup: configuring Composer autoloaders, wiring Orchestra Testbench, authoring GitHub Actions test matrices, and writing service providers. <strong>Fresh Package</strong> is a streamlined skeleton repository that gives you a complete, production-ready package architecture in seconds.</p>

<h3>What’s Included in the Skeleton</h3>
<ul>
    <li><strong>Pest PHP 3 + Orchestra Testbench:</strong> Pre-wired testing environment supporting both feature and unit testing across multiple Laravel and PHP versions.</li>
    <li><strong>GitHub Actions Matrix:</strong> Automated continuous integration testing against PHP 8.3 and PHP 8.4 across current Laravel versions.</li>
    <li><strong>Laravel Boost Integration:</strong> Built-in support for Laravel Boost skills to ensure consistent formatting, static analysis (PHPStan level 9), and security audits.</li>
    <li><strong>Automatic Service Provider Discovery:</strong> Configured <code>composer.json</code> extra attributes ready for immediate installation.</li>
</ul>

<h3>Spinning Up a New Package</h3>
<pre><code># Create your new package using composer create-project
composer create-project fresh-package/laravel-skeleton my-laravel-package --prefer-dist

cd my-laravel-package

# Run test suite immediately
./vendor/bin/pest
</code></pre>

<p>Fresh Package removes the friction from open-source contribution and internal company package distribution.</p>
HTML,
            ],
            [
                'title'       => 'Inertia DevTools Now Available for Firefox',
                'category_key'=> 'news',
                'author'      => 'Paul Redmond',
                'date'        => '2026-09-17 11:15:00',
                'theme'       => 'amber',
                'is_featured' => false,
                'resume'      => 'Inertia.js developers on Firefox can now inspect component hierarchies, page props, real-time router events, and scroll positions with the newly released Firefox extension.',
                'content'     => <<<'HTML'
<h2>Inertia DevTools Expands to Mozilla Firefox</h2>
<p>Developers who prefer Mozilla Firefox for web development now have official access to <strong>Inertia DevTools</strong>. Previously available exclusively for Chromium-based browsers, the extension is now officially signed and listed on the Firefox Add-ons repository.</p>

<h3>Core DevTools Capabilities</h3>
<p>The Inertia DevTools tab integrates directly into the Firefox Developer Tools panel, offering real-time visibility into your frontend state:</p>
<ul>
    <li><strong>Page Props Explorer:</strong> Inspect all props passed from Laravel controllers into Vue, React, or Svelte page components.</li>
    <li><strong>Component Tree:</strong> Navigate visual component hierarchies and examine active route parameters.</li>
    <li><strong>Event Timeline:</strong> Track Inertia router visits, partial reloads, scroll state persistence, and cancelled requests in chronological order.</li>
    <li><strong>Form State Tracking:</strong> Inspect <code>useForm</code> dirty states, validation errors, and progress indicators live.</li>
</ul>

<h3>Installing on Firefox</h3>
<p>Visit the Firefox Add-ons site and search for <em>Inertia DevTools</em>, or install directly from the official Inertia.js documentation page. The extension immediately activates when an Inertia-powered application is detected in your active browser tab.</p>
HTML,
            ],
            [
                'title'       => 'Laravel Scalpel Scans for Filesystem Intrusion Evidence',
                'category_key'=> 'laravel-packages',
                'author'      => 'Yannick Lyn Fatt',
                'date'        => '2026-09-16 15:45:00',
                'theme'       => 'rose',
                'is_featured' => false,
                'resume'      => 'Laravel Scalpel is a security package that scans your project filesystem for indicators of compromise, webshell backdoors, unexpected executable files, and altered vendor code.',
                'content'     => <<<'HTML'
<h2>Auditing Filesystem Integrity with Laravel Scalpel</h2>
<p>Even with strict server configuration, compromised file uploads or third-party vulnerabilities can leave subtle webshells or rogue PHP scripts in storage or public directories. <strong>Laravel Scalpel</strong> is an incident response and forensic auditing tool built specifically for Laravel projects.</p>

<h3>Forensic Detection Engines</h3>
<p>Laravel Scalpel evaluates your application through multiple distinct security layers:</p>
<ul>
    <li><strong>Vendor Integrity Hashing:</strong> Compares files inside <code>vendor/</code> against Composer lockfile distribution hashes to verify that core vendor packages have not been tampered with.</li>
    <li><strong>Webshell Heuristics:</strong> Detects dangerous PHP functions (<code>eval()</code>, <code>base64_decode()</code>, <code>proc_open()</code>) concealed inside non-code asset directories.</li>
    <li><strong>Public Directory Verification:</strong> Alerts if executable PHP or shell scripts exist inside <code>public/storage</code> or file upload paths.</li>
    <li><strong>Hidden File Audits:</strong> Uncovers suspicious dotfiles and unusual file permission configurations across application roots.</li>
</ul>

<h3>Running an Intrusion Scan</h3>
<pre><code># Run complete filesystem scan
php artisan scalpel:scan --strict

# Schedule daily automated health checks
$schedule->command('scalpel:scan --notify-on-failure')->dailyAt('04:00');
</code></pre>
<p>Laravel Scalpel provides peace of mind for engineering teams operating mission-critical production environments.</p>
HTML,
            ],
            [
                'title'       => 'Mercure Broadcasting in Laravel 13.32',
                'category_key'=> 'news',
                'author'      => 'Paul Redmond',
                'date'        => '2026-09-16 10:20:00',
                'theme'       => 'blue',
                'is_featured' => false,
                'resume'      => 'Laravel 13.32 adds first-class support for the Mercure broadcasting protocol, delivering real-time Server-Sent Events (SSE) without dedicated WebSocket clusters.',
                'content'     => <<<'HTML'
<h2>Native Mercure Protocol Support in Laravel 13.32</h2>
<p>The release of <strong>Laravel 13.32</strong> introduces built-in driver support for the <strong>Mercure</strong> broadcasting protocol. Mercure enables real-time data streaming to browsers, mobile apps, and edge microservices using standard HTTP Server-Sent Events (SSE).</p>

<h3>Why Mercure?</h3>
<p>Unlike traditional WebSockets which require persistent bidirectional TCP connections, stateful proxy servers, and specialized client libraries, Mercure operates entirely over HTTP/2 and HTTP/3:</p>
<ul>
    <li><strong>No Node.js or Redis Socket Servers:</strong> Mercure runs effortlessly through FrankenPHP, Caddy, or standalone Docker instances.</li>
    <li><strong>Native Browser Support:</strong> Frontend applications can subscribe to event streams using standard browser <code>EventSource</code> APIs without large vendor bundles.</li>
    <li><strong>Battery & Firewall Friendly:</strong> SSE connections automatically reconnect, bypass enterprise proxy filters, and consume minimal mobile battery.</li>
</ul>

<h3>Configuring Mercure in Laravel</h3>
<pre><code>// config/broadcasting.php
'mercure' => [
    'driver' => 'mercure',
    'url'    => env('MERCURE_URL', 'http://127.0.0.1:2019/.well-known/mercure'),
    'secret' => env('MERCURE_JWT_SECRET'),
],

// Dispatching events as usual
event(new OrderStatusUpdated($order));
</code></pre>
HTML,
            ],
            [
                'title'       => 'Super Stack: Laravel Starter Kit With Filament and NativePHP',
                'category_key'=> 'laravel-packages',
                'author'      => 'Yannick Lyn Fatt',
                'date'        => '2026-09-15 16:00:00',
                'theme'       => 'emerald',
                'is_featured' => true,
                'resume'      => 'Super Stack is an opinionated boilerplate combining Laravel 13, Filament v3 admin panels, and NativePHP for building cross-platform desktop and mobile applications.',
                'content'     => <<<'HTML'
<h2>The Ultimate Desktop & Web Starter Kit</h2>
<p>Building an application that serves both as an enterprise web portal and as a native desktop application used to require separate frontend codebases and divergent API maintenance. <strong>Super Stack</strong> brings together Laravel 13, Filament v3, Livewire 3, and NativePHP into a unified development workflow.</p>

<h3>Core Highlights of Super Stack</h3>
<ul>
    <li><strong>Unified UI Components:</strong> Build once using Blade and Tailwind CSS; run seamlessly inside macOS, Windows, Linux, and web browsers.</li>
    <li><strong>Pre-configured Filament v3:</strong> Full administrative dashboard with user management, role-based permissions, and activity audits ready out of the box.</li>
    <li><strong>Native System Integrations:</strong> Access native system trays, global keyboard shortcuts, local SQLite storage, and notifications through NativePHP.</li>
    <li><strong>Automated App Packaging:</strong> Build desktop executables with a single command via <code>php artisan native:build</code>.</li>
</ul>

<h3>Example: Native Tray Integration</h3>
<pre><code>namespace App\Providers;

use Native\Laravel\Facades\MenuBar;
use Illuminate\Support\ServiceProvider;

class NativeAppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        MenuBar::create()
            ->icon(public_path('tray-icon.png'))
            ->route('desktop.dashboard')
            ->width(450)
            ->height(600);
    }
}
</code></pre>
HTML,
            ],
            [
                'title'       => 'Laravel MCP 1.0 Is Released',
                'category_key'=> 'news',
                'author'      => 'Eric L. Barnes',
                'date'        => '2026-09-15 13:30:00',
                'theme'       => 'purple',
                'is_featured' => true,
                'resume'      => 'The official 1.0 release of Laravel MCP brings Anthropic\'s Model Context Protocol to Laravel, connecting AI agents directly to artisan commands, routes, and database schemas.',
                'content'     => <<<'HTML'
<h2>Connecting Laravel to AI Agents with MCP 1.0</h2>
<p>The official <strong>1.0 release of Laravel MCP</strong> is now live! Model Context Protocol (MCP) is an open standard that allows AI assistants—including Claude Desktop, Cursor, and IDE agents—to securely connect with external tools, data sources, and runtime context.</p>

<h3>Supercharging AI Coding Workflows</h3>
<p>With Laravel MCP installed, your AI pair programmer can intelligently read and interact with your Laravel application context in real time:</p>
<ul>
    <li><strong>Schema Introspection:</strong> AI assistants inspect tables, foreign keys, and indexes directly from your database connection.</li>
    <li><strong>Route & Middleware Mapping:</strong> Instantly discover active route patterns, middleware pipelines, and controller bindings.</li>
    <li><strong>Artisan Command Execution:</strong> Run safe migrations, route lists, and test suites with guided confirmation.</li>
    <li><strong>Log & Error Diagnostics:</strong> Read Laravel log streams to diagnose runtime exceptions without copy-pasting stack traces.</li>
</ul>

<h3>Quick Setup</h3>
<pre><code># Install Laravel MCP server
composer require laravel/mcp --dev

# Start MCP Server
php artisan mcp:serve
</code></pre>
<p>Laravel MCP represents a major milestone in integrating artificial intelligence into day-to-day software development.</p>
HTML,
            ],
            [
                'title'       => 'Laravel Vet: Review Composer Code Before It Installs',
                'category_key'=> 'news',
                'author'      => 'Eric L. Barnes',
                'date'        => '2026-09-15 09:15:00',
                'theme'       => 'amber',
                'is_featured' => false,
                'resume'      => 'Laravel Vet is a Composer plugin that analyzes third-party package dependencies for supply chain risks, malicious scripts, and CVE vulnerabilities prior to package installation.',
                'content'     => <<<'HTML'
<h2>Supply Chain Security with Laravel Vet</h2>
<p>Open-source dependencies power modern web development, but supply chain attacks and package account takeovers have become increasingly sophisticated. <strong>Laravel Vet</strong> is an automated security gatekeeper that vets every Composer package before it touches your disk.</p>

<h3>Pre-Installation Protection</h3>
<p>Traditional security checkers run after packages have already been extracted and post-install hooks have executed. Laravel Vet intercepts Composer execution during resolution:</p>
<ul>
    <li><strong>Script Hook Verification:</strong> Warns when a package attempts to execute arbitrary shell scripts or downloads binaries in <code>post-autoload-dump</code> hooks.</li>
    <li><strong>Maintainer Reputation Checks:</strong> Flags freshly published package versions or sudden ownership reassignments.</li>
    <li><strong>CVE & Advisory Database Audits:</strong> Correlates dependencies with the FriendsOfPHP and GitHub Security Advisory databases.</li>
</ul>

<pre><code># Install Laravel Vet globally
composer global require laravel/vet

# Run safe package installation
composer require vendor/cool-package
# [VETTING] vendor/cool-package (v1.2.0)
#  ✓ Maintainer verified: JohnDoe (5 yrs active)
#  ✓ Zero reported CVEs
#  ✓ No suspicious install lifecycle hooks
# [STATUS] Package approved for installation.
</code></pre>
HTML,
            ],
            [
                'title'       => 'What\'s New in PHP 8.6',
                'category_key'=> 'news',
                'author'      => 'Paul Redmond',
                'date'        => '2026-09-14 15:00:00',
                'theme'       => 'blue',
                'is_featured' => true,
                'resume'      => 'Explore the upcoming features and syntax enhancements in PHP 8.6, including refined pattern matching, asymmetric visibility extensions, and core runtime optimizations.',
                'content'     => <<<'HTML'
<h2>Previewing Features and RFCs in PHP 8.6</h2>
<p>As PHP continues its annual release schedule, discussion on the PHP internals mailing list has crystalized around key RFCs targeting <strong>PHP 8.6</strong>. Let’s explore the syntax additions and performance milestones planned for this upcoming release.</p>

<h3>Pattern Matching Evolution</h3>
<p>PHP 8.6 expands on the <code>match</code> expression introduced in PHP 8.0, allowing pattern decomposition and structure destructuring directly in match branches:</p>

<pre><code>// Pattern matching with destructuring in PHP 8.6
$result = match ($response) {
    ['status' => 200, 'data' => $data] => processSuccess($data),
    ['status' => 404]                  => handleNotFound(),
    ['status' => 500, 'error' => $err] => logServerError($err),
    default                            => handleUnexpected(),
};
</code></pre>

<h3>Enhanced JIT and Memory Footprint</h3>
<ul>
    <li><strong>Hybrid Tracing JIT:</strong> Further refinements to the JIT compiler yield an additional 8-12% throughput improvement on CPU-bound PHP CLI workloads.</li>
    <li><strong>Compact Object Representation:</strong> Internal zval optimization reduces base object memory footprints by nearly 15%.</li>
    <li><strong>Typed Exceptions:</strong> RFC proposals for catching multiple typed exceptions with unified variable bindings.</li>
</ul>

<p>PHP 8.6 proves that PHP remains one of the fastest, most ergonomic server-side languages in the industry.</p>
HTML,
            ],
            [
                'title'       => 'Building EasyReply: How We Used Laravel to Unify Customer Support',
                'category_key'=> 'sponsor',
                'author'      => 'Emma Blake',
                'date'        => '2026-09-14 11:30:00',
                'theme'       => 'rose',
                'is_featured' => false,
                'resume'      => 'A technical deep-dive into how EasyReply leveraged Laravel, Livewire 3, and Horizon queues to build an enterprise shared inbox processing millions of emails each week.',
                'content'     => <<<'HTML'
<h2>Scaling a Shared Support Inbox with Laravel</h2>
<p>When building <strong>EasyReply</strong>—a high-volume shared support platform for SaaS companies—we needed an architecture capable of processing incoming email webhooks, coordinating agent responses in real time, and maintaining sub-second UI responsiveness.</p>

<h3>The Technical Stack</h3>
<ul>
    <li><strong>Laravel 13 & Octane:</strong> Powering our webhook ingestion endpoints, processing over 4,000 inbound emails per minute with microsecond overhead.</li>
    <li><strong>Livewire 3 & Alpine.js:</strong> Delivering a reactive inbox interface that updates conversation threads in real time without heavy Single Page Application complexity.</li>
    <li><strong>Laravel Horizon & Redis:</strong> Managing prioritized queue workers for email parsing, sentiment tagging, and customer notifications.</li>
    <li><strong>PostgreSQL Full-Text Search:</strong> Indexing millions of customer conversation histories with Gin indexing for instant search results.</li>
</ul>

<h3>Lessons Learned</h3>
<p>By relying heavily on first-party Laravel ecosystem tools, our four-person engineering team built a platform that competes directly with legacy enterprise support software. Laravel's expressive syntax and robust queueing system saved us months of infrastructure engineering.</p>
HTML,
            ],
            [
                'title'       => 'PostgreSQL Monitoring and Schema Linting for Laravel with Vacuum',
                'category_key'=> 'laravel-packages',
                'author'      => 'Paul Redmond',
                'date'        => '2026-09-11 14:45:00',
                'theme'       => 'cyan',
                'is_featured' => false,
                'resume'      => 'Keep your PostgreSQL databases performant with Vacuum, a Laravel package that tracks table bloat, autovacuum health, missing foreign key indexes, and slow query patterns.',
                'content'     => <<<'HTML'
<h2>Mastering PostgreSQL Performance with Vacuum</h2>
<p>PostgreSQL is a favorite database among Laravel developers, but high-write workloads can lead to dead tuple accumulation, unindexed foreign keys, and table bloat that degrades query performance. <strong>Vacuum</strong> is a purpose-built package for monitoring and tuning PostgreSQL databases inside Laravel applications.</p>

<h3>What Vacuum Checks</h3>
<ul>
    <li><strong>Dead Tuple & Table Bloat:</strong> Monitors table fragmentation and alerts when autovacuum routines fail to keep pace with record updates.</li>
    <li><strong>Missing Foreign Key Indexes:</strong> Identifies unindexed relation columns that trigger table-wide sequential scans during cascade operations.</li>
    <li><strong>Transaction ID Wraparound:</strong> Keeps track of database transaction age to prevent catastrophic database shutdown states.</li>
    <li><strong>Unused & Duplicate Indexes:</strong> Recommends obsolete indexes that consume write throughput and disk cache without improving query plans.</li>
</ul>

<h3>CLI Command Example</h3>
<pre><code># Run complete PostgreSQL health audit
php artisan vacuum:check

# Inspect bloat on specific table
php artisan vacuum:bloat users
</code></pre>
HTML,
            ],
            [
                'title'       => 'PayZephyr: One Payment API for Stripe, Paystack, and PayPal',
                'category_key'=> 'laravel-packages',
                'author'      => 'Paul Redmond',
                'date'        => '2026-09-10 16:15:00',
                'theme'       => 'emerald',
                'is_featured' => false,
                'resume'      => 'PayZephyr unifies Stripe, Paystack, and PayPal into a single, elegant Laravel payment abstraction with multi-currency checkouts and standardized webhook processing.',
                'content'     => <<<'HTML'
<h2>Unified Global Payments with PayZephyr</h2>
<p>Integrating multiple payment providers across international markets usually requires implementing separate SDKs, diverging webhook listeners, and inconsistent data models. <strong>PayZephyr</strong> provides a single, unified payment interface for Laravel that connects Stripe, Paystack, and PayPal seamlessly.</p>

<h3>Key Features</h3>
<ul>
    <li><strong>Single Fluent API:</strong> Charge cards, initialize checkouts, and generate payment links using identical PHP syntax across all supported gateways.</li>
    <li><strong>Standardized Webhook Dispatching:</strong> Unifies gateway-specific webhook events into consistent Laravel events (e.g. <code>PaymentReceived</code>, <code>SubscriptionRenewed</code>).</li>
    <li><strong>Automatic Currency Routing:</strong> Routes payments to the most cost-effective gateway based on customer country and currency.</li>
</ul>

<h3>Initiating a Payment</h3>
<pre><code>use PayZephyr\Facades\PayZephyr;

$payment = PayZephyr::gateway('stripe')
    ->amount(49.99)
    ->currency('USD')
    ->customer($user)
    ->description('Monthly SaaS Pro Plan')
    ->checkout();

return redirect($payment->checkoutUrl());
</code></pre>
HTML,
            ],
            [
                'title'       => 'Bifrost Turns One With AI Builds and New Workflows',
                'category_key'=> 'news',
                'author'      => 'Yannick Lyn Fatt',
                'date'        => '2026-09-10 13:00:00',
                'theme'       => 'purple',
                'is_featured' => false,
                'resume'      => 'Bifrost celebrates its first anniversary by unveiling automated AI build troubleshooting, preview pull-request environments, and zero-downtime deployment pipelines for Laravel.',
                'content'     => <<<'HTML'
<h2>Bifrost Celebrates One Year of Effortless Deployments</h2>
<p>One year after its launch, <strong>Bifrost</strong>—the dedicated deployment and CI/CD platform engineered for modern Laravel applications—has celebrated its first anniversary with a major release introducing AI-assisted build analysis and ephemeral preview environments.</p>

<h3>Key Additions in the Anniversary Release</h3>
<ul>
    <li><strong>AI Build Diagnostics:</strong> When a deployment script or migration fails, Bifrost's integrated AI analyzes deployment logs and pinpoints the exact fix, whether it's a missing environment variable or an unresolved Composer dependency.</li>
    <li><strong>Ephemeral Pull Request Environments:</strong> Automatically spins up isolated testing environments with sanitized database seeds for every opened GitHub pull request.</li>
    <li><strong>Zero-Downtime Atomic Swaps:</strong> Instant symlink switching ensures active user sessions and queue jobs experience zero interruptions during code updates.</li>
</ul>

<p>Bifrost continues to raise the bar for seamless Laravel continuous delivery.</p>
HTML,
            ],
            [
                'title'       => 'Preview Blade Templates in macOS Finder with Quick Blade',
                'category_key'=> 'laravel-packages',
                'author'      => 'Paul Redmond',
                'date'        => '2026-09-10 09:30:00',
                'theme'       => 'amber',
                'is_featured' => false,
                'resume'      => 'Quick Blade is a native macOS QuickLook extension that renders syntax-highlighted previews of Laravel Blade templates directly within Finder and Spotlight.',
                'content'     => <<<'HTML'
<h2>Instant Blade Previews in macOS Finder</h2>
<p>On macOS, selecting a file in Finder and tapping the Spacebar triggers QuickLook. However, files ending in <code>.blade.php</code> historically rendered as generic text icons without syntax highlighting. <strong>Quick Blade</strong> resolves this frustration for Mac-based Laravel developers.</p>

<h3>Features of Quick Blade</h3>
<ul>
    <li><strong>Full Blade Syntax Highlighting:</strong> Recognizes Blade directives (<code>@if</code>, <code>@foreach</code>, <code>@props</code>), HTML tags, and embedded PHP blocks with crisp colors.</li>
    <li><strong>Light & Dark Mode Support:</strong> Automatically matches your macOS system appearance.</li>
    <li><strong>Zero Performance Impact:</strong> Built natively using Swift and Apple's QuickLook framework for instantaneous opening with zero latency.</li>
</ul>

<pre><code># Install Quick Blade via Homebrew Cask
brew install --cask quick-blade

# Restart Finder QuickLook service
qlmanage -r
</code></pre>
HTML,
            ],
            [
                'title'       => 'Artisan Debugging Commands in Laravel Telescope 5.24.0',
                'category_key'=> 'news',
                'author'      => 'Yannick Lyn Fatt',
                'date'        => '2026-09-09 14:30:00',
                'theme'       => 'blue',
                'is_featured' => false,
                'resume'      => 'Laravel Telescope 5.24.0 introduces new CLI artisan commands to inspect logs, stream database queries in real-time, and manage storage directly from the terminal.',
                'content'     => <<<'HTML'
<h2>CLI Debugging in Laravel Telescope 5.24.0</h2>
<p>While Laravel Telescope's web dashboard is beloved by developers, logging into a remote staging server often means working purely within a terminal session. <strong>Telescope 5.24.0</strong> introduces dedicated CLI commands that bring Telescope's telemetry directly into your terminal.</p>

<h3>New Artisan Commands</h3>
<ul>
    <li><strong><code>php artisan telescope:tail</code>:</strong> Stream outgoing queries, executed jobs, and thrown exceptions directly to stdout in real time.</li>
    <li><strong><code>php artisan telescope:slow-queries</code>:</strong> Lists the slowest database queries recorded in Telescope with execution times and call traces.</li>
    <li><strong><code>php artisan telescope:prune --tag=billing</code>:</strong> Prune entries matching specific tags or time ranges without wiping the entire Telescope database.</li>
</ul>

<pre><code># Stream slow queries live during load testing
php artisan telescope:tail --filter=queries --slow-only
# [0.482s] SELECT * FROM orders WHERE status = 'pending' (App\Actions\ProcessOrders:34)
# [0.612s] UPDATE inventory SET stock = stock - 1 (App\Services\CheckoutService:88)
</code></pre>
HTML,
            ],
            [
                'title'       => 'Queue totalSize() and JobInterrupted Event in Laravel 13.31',
                'category_key'=> 'news',
                'author'      => 'Paul Redmond',
                'date'        => '2026-09-08 15:00:00',
                'theme'       => 'emerald',
                'is_featured' => false,
                'resume'      => 'Laravel 13.31 delivers Queue::totalSize() for aggregate multi-queue metrics and a dedicated JobInterrupted event for handling graceful worker terminations and container preemption.',
                'content'     => <<<'HTML'
<h2>Queue Improvements in Laravel 13.31</h2>
<p>The release of <strong>Laravel 13.31</strong> provides two significant enhancements for background queue management: aggregate queue size introspection and graceful worker interruption events.</p>

<h3>Aggregate Queue Sizing with <code>Queue::totalSize()</code></h3>
<p>Previously, monitoring aggregate queue depth required querying each queue name individually. Laravel 13.31 introduces <code>Queue::totalSize()</code>:</p>

<pre><code>use Illuminate\Support\Facades\Queue;

// Fetch total count across all queues on the default connection
$pendingJobs = Queue::totalSize();

// Or check specific connection
$redisDepth = Queue::connection('redis')->totalSize(['high', 'default', 'low']);
</code></pre>

<h3>Handling Worker Terminations with <code>JobInterrupted</code></h3>
<p>When running queue workers on Kubernetes or AWS ECS, spot instance terminations send SIGTERM signals to running containers. The new <code>JobInterrupted</code> event allows executing cleanup logic before workers terminate:</p>

<pre><code>use Illuminate\Queue\Events\JobInterrupted;
use Illuminate\Support\Facades\Event;

Event::listen(JobInterrupted::class, function (JobInterrupted $event) {
    logger()->warning("Job {$event->job->resolveName()} was interrupted by system signal.");
    // Release locks, update progress indicators, or send alerts
});
</code></pre>
HTML,
            ],
            [
                'title'       => 'Find Unexpected Test Inputs with Fuzz for Pest',
                'category_key'=> 'laravel-packages',
                'author'      => 'Yannick Lyn Fatt',
                'date'        => '2026-09-07 14:00:00',
                'theme'       => 'purple',
                'is_featured' => false,
                'resume'      => 'Fuzz for Pest brings automated fuzz testing to Pest PHP, discovering unhandled exceptions and security boundaries by throwing thousands of mutated inputs at your functions.',
                'content'     => <<<'HTML'
<h2>Automated Fuzz Testing in Pest PHP</h2>
<p>Traditional unit tests verify scenarios developers anticipate. Fuzz testing, by contrast, throws thousands of randomized, mutated, and edge-case inputs at your code to find unhandled crashes, memory leaks, and type errors. <strong>Fuzz for Pest</strong> brings first-class fuzzing directly into Pest PHP.</p>

<h3>Writing a Fuzz Test</h3>
<pre><code>// tests/Feature/ParserTest.php
it('safely parses user submitted markdown', function () {
    fuzz(function (string $input) {
        $result = app(MarkdownParser::class)->parse($input);
        expect($result)->toBeString();
    })->iterations(5000);
});
</code></pre>

<h3>What Fuzz Tests Uncover</h3>
<ul>
    <li>Invalid UTF-8 byte sequences causing string function crashes.</li>
    <li>Integer overflow edge cases in pricing algorithms.</li>
    <li>Infinite loops in recursive tree structures and regex evaluations.</li>
    <li>Unhandled JSON deserialization anomalies.</li>
</ul>

<p>Adding fuzz tests to critical financial or parsing logic dramatically increases software resilience.</p>
HTML,
            ],
            [
                'title'       => 'Laravel Rulebook: Business Rules That Change by Date',
                'category_key'=> 'laravel-packages',
                'author'      => 'Yannick Lyn Fatt',
                'date'        => '2026-09-04 16:30:00',
                'theme'       => 'amber',
                'is_featured' => false,
                'resume'      => 'Laravel Rulebook offers a clean architecture for managing time-sensitive business logic, such as holiday pricing, tax adjustments, and regulatory cutoffs, without messy conditional code.',
                'content'     => <<<'HTML'
<h2>Managing Temporal Business Logic with Laravel Rulebook</h2>
<p>When business rules change on a specific date—such as tax rate increases, holiday promotional discounts, or new compliance regulations—controllers often become cluttered with messy date comparisons:</p>

<pre><code>// The messy approach:
if (now()->between($blackFridayStart, $blackFridayEnd)) {
    $discount = 0.25;
} elseif (now()->isAfter($q4Cutoff)) {
    $discount = 0.15;
}
</code></pre>

<h3>The Rulebook Architecture</h3>
<p><strong>Laravel Rulebook</strong> introduces a clean, declarative approach to time-sensitive policy modeling:</p>

<pre><code>namespace App\Rules\Pricing;

use LaravelRulebook\Rule;

class HolidayDiscountRule extends Rule
{
    public function effectiveDate(): string
    {
        return '2026-11-25 to 2026-12-02';
    }

    public function apply($cart): void
    {
        $cart->discountPercentage = 25;
    }
}
</code></pre>

<p>Rulebook allows querying and testing rules against past, present, or future dates without touching system clocks.</p>
HTML,
            ],
            [
                'title'       => 'Taylor disabled GitHub Issues on most Laravel open-source packages.',
                'category_key'=> 'news',
                'author'      => 'Eric L. Barnes',
                'date'        => '2026-09-04 11:00:00',
                'theme'       => 'rose',
                'is_featured' => true,
                'resume'      => 'Taylor Otwell announces the transition of Laravel\'s open-source issue trackers to GitHub Discussions, focusing maintainer time on reproducible pull requests and community collaboration.',
                'content'     => <<<'HTML'
<h2>Refocusing Open-Source Collaboration in the Laravel Community</h2>
<p>In a blog post that generated widespread discussion across the software ecosystem, <strong>Taylor Otwell</strong> announced that GitHub Issues have been disabled across most primary Laravel open-source repositories.</p>

<h3>The Motivation Behind the Change</h3>
<p>As Laravel has grown to millions of active installations worldwide, issue trackers frequently became inundated with general support questions, configuration misunderstandings, and questions better suited for community forums. This high volume placed an unsustainable burden on core framework maintainers.</p>

<h3>The New Collaboration Model</h3>
<ul>
    <li><strong>GitHub Discussions:</strong> Questions, feature proposals, and open-ended technical ideas are now directed to repository GitHub Discussions.</li>
    <li><strong>Pull Requests with Reproductions:</strong> Verified bug reports are welcomed directly as pull requests featuring failing Pest or PHPUnit tests.</li>
    <li><strong>Dedicated Bug Triaging:</strong> Community contributors can collaborate on reproducing issues in Discussions before raising code fixes.</li>
</ul>

<p>This transition ensures that core maintainers can spend their energy enhancing the framework, accelerating code reviews, and building the future of Laravel.</p>
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
                    'content'     => $vlog['content'],
                    'resume'      => $vlog['resume'],
                    'is_active'   => true,
                    'is_featured' => $vlog['is_featured'],
                    'style'       => 'default',
                    'img_cover'   => $imgFilename,
                    'created_at'  => $vlog['date'],
                    'updated_at'  => $vlog['date'],
                ]);
            } else {
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
            }

            // Create or update Page model linked to Post
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
