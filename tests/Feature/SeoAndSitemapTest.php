<?php

namespace Tests\Feature;

use App\Models\Page;
use App\Models\Setting;
use Tests\TestCase;

class SeoAndSitemapTest extends TestCase
{
    /**
     * Test that dynamic /sitemap.xml route returns valid XML.
     */
    public function test_sitemap_xml_returns_valid_xml(): void
    {
        $response = $this->get('/sitemap.xml');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/xml; charset=UTF-8');
        $this->assertStringContainsString('<?xml version="1.0" encoding="UTF-8"?>', $response->getContent());
        $this->assertStringContainsString('<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"', $response->getContent());
        $this->assertStringContainsString('<loc>', $response->getContent());
    }

    /**
     * Test that dynamic /robots.txt route returns proper directives.
     */
    public function test_robots_txt_returns_proper_directives(): void
    {
        $response = $this->get('/robots.txt');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/plain; charset=UTF-8');
        $this->assertStringContainsString('User-agent: *', $response->getContent());
        $this->assertStringContainsString('Disallow: /admin', $response->getContent());
        $this->assertStringContainsString('Disallow: /login', $response->getContent());
        $this->assertStringContainsString('Sitemap:', $response->getContent());
    }

    /**
     * Test artisan sitemap:generate command.
     */
    public function test_artisan_sitemap_generate_command(): void
    {
        $this->artisan('sitemap:generate')
            ->assertSuccessful();

        $this->assertFileExists(public_path('sitemap.xml'));
        $this->assertFileExists(public_path('robots.txt'));

        $robots = file_get_contents(public_path('robots.txt'));
        $this->assertStringContainsString('Sitemap:', $robots);
        $this->assertStringContainsString('Disallow: /admin', $robots);
    }

    /**
     * Test homepage renders SEO and social tags.
     */
    public function test_homepage_renders_proper_seo_tags(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $content = $response->getContent();

        // Check canonical tag
        $this->assertStringContainsString('<link rel="canonical"', $content);

        // Check Open Graph tags
        $this->assertStringContainsString('<meta property="og:type"', $content);
        $this->assertStringContainsString('<meta property="og:title"', $content);
        $this->assertStringContainsString('<meta property="og:description"', $content);
        $this->assertStringContainsString('<meta property="og:url"', $content);

        // Check Twitter card tags
        $this->assertStringContainsString('<meta name="twitter:card" content="summary_large_image">', $content);
        $this->assertStringContainsString('<meta name="twitter:title"', $content);

        // Check JSON-LD
        $this->assertStringContainsString('application/ld+json', $content);
        $this->assertStringContainsString('schema.org', $content);
    }

    /**
     * Test blog page renders per-page metadata.
     */
    public function test_blog_post_renders_per_page_metadata(): void
    {
        $blogPage = Page::where('style', 'blog')
            ->where('is_active', true)
            ->first();

        if ($blogPage) {
            $response = $this->get('/' . ltrim($blogPage->slug, '/'));
            $response->assertStatus(200);
            $content = $response->getContent();

            $this->assertStringContainsString('<title>' . e($blogPage->title), $content);
            $this->assertStringContainsString('<meta property="og:type" content="article">', $content);
            $this->assertStringContainsString('BlogPosting', $content);
        } else {
            $this->assertTrue(true);
        }
    }
}
