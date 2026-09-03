<?php

namespace App\View\Components\Themes\Juno;

use App\Models\Profile;
use App\Models\Setting;
use App\Traits\SectionLoader;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Contact extends Component
{
    /**
     * Create a new component instance.
     */
    use SectionLoader;

    public ?string $calendlyUrl;

    public function __construct()
    {
        $this->loadSection('contact');
        $this->calendlyUrl = $this->resolveCalendlyUrl();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.themes.juno.contact');
    }

    public function contactData()
    {
        $contact = Setting::first();
        $data = [
            'email' => $contact->email,
        ];

        return $data;
    }

    public function resolveCalendlyUrl(): ?string
    {
        if (! empty($this->content['calendly_url'])) {
            $url = $this->content['calendly_url'];

            return preg_match('~^https?://~i', $url) ? $url : 'https://' . $url;
        }

        $profile = Profile::first();
        if ($profile && $profile->resolved_calendly_url) {
            return $profile->resolved_calendly_url;
        }

        return null;
    }
}

