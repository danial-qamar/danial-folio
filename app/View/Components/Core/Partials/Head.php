<?php

namespace App\View\Components\Core\Partials;

use App\Models\Setting;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class Head extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public mixed $page = null,
        public ?string $metaTitle = null,
        public ?string $metaDescription = null,
        public ?string $metaKeywords = null,
        public ?string $metaAuthor = null,
        public ?string $metaRobots = null,
        public ?string $canonicalUrl = null,
        public ?string $ogImage = null,
        public ?string $ogType = null,

        public ?string $favicon = null,

        public ?string $headerScripts = null,
        public ?string $bodyScripts = null,

        public ?string $googleSiteVerification = null,
        public ?string $googleAnalytics = null,
        public ?string $googleFonts = null,
        public ?string $googleFontsCode = null,
        public ?array $jsonLd = null,
    ) {
        $setting = Setting::first(['meta', 'application', 'design', 'google', 'scripts']);
        $appName = $setting?->application['name'] ?? config('app.name', 'DanialFolio');

        // Resolve Page Title
        if (!empty($this->metaTitle)) {
            // Use explicitly provided prop
        } elseif ($this->page && !empty($this->page->meta_title)) {
            $this->metaTitle = $this->page->meta_title;
        } elseif ($this->page && ($this->page->slug === '/' || empty($this->page->slug))) {
            $globalTitle = $setting?->meta['meta_title'] ?? null;
            if (empty($globalTitle) || in_array($globalTitle, ['Danial Qamar | Portfolio', 'Danial Qamar | Portfolio.', 'Default Title'])) {
                $this->metaTitle = 'Danial Qamar | Full Stack Laravel Developer';
            } else {
                $this->metaTitle = $globalTitle;
            }
        } elseif ($this->page && !empty($this->page->title)) {
            $this->metaTitle = $this->page->title . ' | ' . $appName;
        } else {
            $globalTitle = $setting?->meta['meta_title'] ?? null;
            if (empty($globalTitle) || in_array($globalTitle, ['Danial Qamar | Portfolio', 'Danial Qamar | Portfolio.', 'Default Title'])) {
                $this->metaTitle = 'Danial Qamar | Full Stack Laravel Developer';
            } else {
                $this->metaTitle = $globalTitle;
            }
        }

        // Resolve Meta Description
        if (!empty($this->metaDescription)) {
            // Use explicit prop
        } elseif ($this->page && !empty($this->page->meta_description)) {
            $this->metaDescription = $this->page->meta_description;
        } elseif ($this->page && $this->page->post && !empty($this->page->post->resume)) {
            $this->metaDescription = Str::limit(strip_tags($this->page->post->resume), 160);
        } elseif ($this->page && $this->page->project && !empty($this->page->project->short_description)) {
            $this->metaDescription = Str::limit(strip_tags($this->page->project->short_description), 160);
        } elseif (!empty($setting?->meta['meta_description']) && $setting->meta['meta_description'] !== 'Default description') {
            $this->metaDescription = $setting->meta['meta_description'];
        } else {
            $this->metaDescription = 'Explore developer portfolio, enterprise Laravel projects, and technical deep dives by Danial Qamar, Full Stack Software Engineer.';
        }

        // Resolve Meta Keywords
        if (!empty($this->metaKeywords)) {
            // Use explicit prop
        } elseif ($this->page && !empty($this->page->meta_keywords)) {
            $this->metaKeywords = $this->page->meta_keywords;
        } elseif ($this->page && $this->page->project && !empty($this->page->project->tags) && is_array($this->page->project->tags)) {
            $this->metaKeywords = implode(', ', $this->page->project->tags);
        } elseif (!empty($setting?->meta['meta_keywords']) && $setting->meta['meta_keywords'] !== 'Default keywords') {
            $this->metaKeywords = $setting->meta['meta_keywords'];
        } else {
            $this->metaKeywords = 'Danial Qamar, Laravel 11, PHP, Filament, Livewire, Vue.js, Tailwind CSS, Full Stack Developer, Software Engineer, Portfolio';
        }

        // Resolve Meta Author
        if (empty($this->metaAuthor)) {
            $this->metaAuthor = (!empty($setting?->meta['meta_author'])) ? $setting->meta['meta_author'] : 'Danial Qamar';
        }

        // Canonical URL
        if (empty($this->canonicalUrl)) {
            $this->canonicalUrl = url()->current();
        }

        // Robots Meta
        if (empty($this->metaRobots)) {
            if ($this->page && (!$this->page->is_active || !empty($this->page->is_password_protected))) {
                $this->metaRobots = 'noindex, nofollow';
            } else {
                $this->metaRobots = (!empty($setting?->meta['meta_robots'])) ? $setting->meta['meta_robots'] : 'index, follow';
            }
        }

        // Open Graph Type
        if (empty($this->ogType)) {
            $this->ogType = ($this->page && ($this->page->style === 'blog' || !empty($this->page->post_id))) ? 'article' : 'website';
        }

        // Open Graph Image
        if (empty($this->ogImage)) {
            $cover = null;
            if ($this->page?->post?->img_cover) {
                $cover = $this->page->post->img_cover;
            } elseif ($this->page?->project?->image_cover) {
                $cover = $this->page->project->image_cover;
            }

            if ($cover) {
                $this->ogImage = Str::startsWith($cover, 'http') ? $cover : asset('storage/' . Str::after($cover, 'public/'));
            } elseif (file_exists(public_path('img/core/demo/default-landing-image.png'))) {
                $this->ogImage = asset('img/core/demo/default-landing-image.png');
            } else {
                $this->ogImage = asset('img/core/favicon.png');
            }
        }

        // Favicon
        $rawFavicon = $setting?->design['favicon'] ?? null;
        $this->favicon = $rawFavicon ? Str::after($rawFavicon, 'public/') : null;

        // Scripts aggregation (global + page specific)
        $headerScriptsArray = [];
        if (!empty($setting?->scripts['header_scripts'])) {
            $headerScriptsArray[] = $setting->scripts['header_scripts'];
        }
        if ($this->page && !empty($this->page->header_scripts)) {
            $headerScriptsArray[] = $this->page->header_scripts;
        }
        $this->headerScripts = !empty($headerScriptsArray) ? implode("\n", $headerScriptsArray) : null;
        $this->bodyScripts = $setting?->scripts['body_scripts'] ?? null;

        // Google Integrations
        $this->googleSiteVerification = $setting?->google['tag'] ?? null;
        $this->googleAnalytics = $setting?->google['analytics'] ?? null;
        $this->googleFonts = $setting?->google['font_name'] ?? 'Inter';
        $this->googleFontsCode = $setting?->google['fonts_code'] ?? null;

        // JSON-LD Structured Data
        $this->jsonLd = $this->buildJsonLd($setting, $appName);
    }

    /**
     * Build Schema.org JSON-LD structured data.
     */
    protected function buildJsonLd(?Setting $setting, string $appName): array
    {
        $schema = [
            '@context' => 'https://schema.org',
        ];

        if ($this->page && ($this->page->style === 'blog' || !empty($this->page->post_id))) {
            $schema['@type'] = 'BlogPosting';
            $schema['headline'] = $this->metaTitle;
            $schema['description'] = $this->metaDescription;
            $schema['mainEntityOfPage'] = [
                '@type' => 'WebPage',
                '@id' => $this->canonicalUrl,
            ];
            if ($this->ogImage) {
                $schema['image'] = $this->ogImage;
            }
            $schema['datePublished'] = $this->page->post?->created_at?->toIso8601String() ?? $this->page->created_at?->toIso8601String();
            $schema['dateModified'] = $this->page->post?->updated_at?->toIso8601String() ?? $this->page->updated_at?->toIso8601String();
            $schema['author'] = [
                '@type' => 'Person',
                'name' => $this->metaAuthor,
            ];
            $schema['publisher'] = [
                '@type' => 'Organization',
                'name' => $appName,
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => asset('img/core/favicon.png'),
                ],
            ];
        } else {
            $schema['@type'] = 'WebSite';
            $schema['name'] = $appName;
            $schema['url'] = url('/');
            $schema['description'] = $this->metaDescription;
            $schema['author'] = [
                '@type' => 'Person',
                'name' => $this->metaAuthor,
                'jobTitle' => 'Full Stack Developer',
            ];
        }

        return $schema;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.core.partials.head');
    }
}
