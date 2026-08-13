<?php

namespace App\View\Components\Ui;

use App\Models\Setting;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Logo extends Component
{
    public ?string $logoUrl = null;
    public ?string $logoDarkUrl = null;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public mixed $logo = null,
        public mixed $logoDark = null,
        public ?string $logoSize = null,
        public ?string $link = null,
    ) {
        $setting = Setting::first(['design'])?->design ?? [];
        $logoVal = $this->logo ?? $setting['logo'] ?? null;
        $logoDarkVal = $this->logoDark ?? $setting['logo_dark_mode'] ?? $setting['logo_dark'] ?? null;

        $this->logoUrl = $this->resolveMediaUrl($logoVal);
        $this->logoDarkUrl = $this->resolveMediaUrl($logoDarkVal);
        $this->logoSize = $logoSize ?? $setting['logo_size'] ?? null;
        $this->link = $link ?? $setting['logo_link'] ?? config('app.url', env('APP_URL'));
    }

    private function resolveMediaUrl(mixed $value): ?string
    {
        if (blank($value)) {
            return null;
        }

        if (is_numeric($value) && class_exists(\Awcodes\Curator\Models\Media::class)) {
            $media = \Awcodes\Curator\Models\Media::find($value);
            if ($media) {
                return $media->url ?: asset('storage/' . \Illuminate\Support\Str::after($media->path, 'public/'));
            }
        }

        if (is_string($value)) {
            if (\Illuminate\Support\Str::startsWith($value, ['http://', 'https://'])) {
                return $value;
            }
            return asset('storage/' . \Illuminate\Support\Str::after($value, 'public/'));
        }

        return null;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.ui.logo');
    }
}
