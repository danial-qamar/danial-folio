<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Setting;
use Illuminate\Http\Response;
use Z3d0X\FilamentFabricator\Facades\FilamentFabricator;

class SitemapController extends Controller
{
    /**
     * Generate and return the XML sitemap.
     */
    public function index(): Response
    {
        $urls = $this->collectSitemapUrls();
        $xml = view('sitemap', compact('urls'))->render();

        return response($xml, 200, [
            'Content-Type' => 'application/xml; charset=UTF-8',
        ]);
    }

    /**
     * Collect all crawlable URLs for the sitemap.
     */
    public function collectSitemapUrls(): array
    {
        $pages = Page::query()
            ->where('is_active', true)
            ->where('is_password_protected', false)
            ->with(['post', 'project'])
            ->orderBy('id', 'asc')
            ->get();

        $urls = [];
        $seen = [];

        foreach ($pages as $page) {
            $path = FilamentFabricator::getPageUrlFromId($page->id);

            if ($path === null) {
                continue;
            }

            // Normalise path and construct full URL
            $fullUrl = url($path);

            if (isset($seen[$fullUrl])) {
                continue;
            }
            $seen[$fullUrl] = true;

            $isHome = ($path === '/' || empty($path));
            $isBlogOrProjectsIndex = in_array($path, ['/blog', '/projects', '/portfolio', '/docs']);
            $isPostOrProject = str_starts_with($path, '/blog/post/') || str_starts_with($path, '/project/') || str_starts_with($path, '/projects/');

            if ($isHome) {
                $priority = '1.0';
                $freq = 'daily';
            } elseif ($isBlogOrProjectsIndex) {
                $priority = '0.9';
                $freq = 'daily';
            } elseif ($isPostOrProject) {
                $priority = '0.8';
                $freq = 'weekly';
            } else {
                $priority = '0.6';
                $freq = 'monthly';
            }

            $lastmod = ($page->updated_at ?? $page->created_at ?? now())->toAtomString();

            $urls[] = [
                'loc'        => $fullUrl,
                'lastmod'    => $lastmod,
                'changefreq' => $freq,
                'priority'   => $priority,
            ];
        }

        return $urls;
    }

    /**
     * Generate dynamic robots.txt content.
     */
    public function robots(): Response
    {
        $content = $this->buildRobotsContent();

        return response($content, 200, [
            'Content-Type' => 'text/plain; charset=UTF-8',
        ]);
    }

    /**
     * Build the robots.txt text content.
     */
    public function buildRobotsContent(): string
    {
        $sitemapUrl = url('/sitemap.xml');

        $disallowed = [
            '/admin',
            '/admin/',
            '/login',
            '/_ignition/',
            '/livewire/',
            '/api/',
            '/sanctum/',
        ];

        $lines = [
            'User-agent: *',
            'Allow: /',
            'Allow: /build/',
            'Allow: /css/',
            'Allow: /js/',
            'Allow: /img/',
            'Allow: /storage/',
        ];

        foreach ($disallowed as $path) {
            $lines[] = "Disallow: {$path}";
        }

        $lines[] = '';
        $lines[] = "Sitemap: {$sitemapUrl}";

        return implode("\n", $lines) . "\n";
    }
}
