<?php

namespace App\Console\Commands;

use App\Http\Controllers\SitemapController;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class GenerateSitemapCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate {--sync-robots : Also update public/robots.txt with the sitemap location}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the XML sitemap file in the public directory and sync robots.txt';

    /**
     * Execute the console command.
     */
    public function handle(SitemapController $controller): int
    {
        $this->info('Collecting active pages for sitemap...');

        $urls = $controller->collectSitemapUrls();

        if (empty($urls)) {
            $this->warn('No active pages found to include in the sitemap.');
            return self::FAILURE;
        }

        $xml = view('sitemap', compact('urls'))->render();

        $sitemapPath = public_path('sitemap.xml');
        File::put($sitemapPath, $xml);

        $this->info("✓ Successfully generated sitemap with " . count($urls) . " URLs at {$sitemapPath}");

        // Sync robots.txt
        $robotsContent = $controller->buildRobotsContent();
        $robotsPath = public_path('robots.txt');
        File::put($robotsPath, $robotsContent);
        $this->info("✓ Successfully synced robots.txt at {$robotsPath}");

        return self::SUCCESS;
    }
}
