@props(['name', 'href' => null, 'size' => 'default'])

@php
    $url = null;
    if ($href) {
        $url = preg_match('~^https?://~i', $href) ? $href : 'https://' . $href;
    }
    $sizeClasses = $size === 'default' ? 'h-6 w-6 text-2xl' : ($size === 'big' ? 'h-8 w-8 text-3xl' : 'h-5 w-5 text-xl');
@endphp

<div class="inline-flex items-center justify-center">
    @if ($url)
    <a href="{{ $url }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center">
    @endif
    @if ($name)
        @if (strtolower($name) === 'calendly')
            <svg class="{{ $sizeClasses }} transition-all duration-300 hover:opacity-30 active:opacity-10 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M19.5 3H18V1.5a.75.75 0 0 0-1.5 0V3h-9V1.5a.75.75 0 0 0-1.5 0V3H4.5A2.25 2.25 0 0 0 2.25 5.25v13.5A2.25 2.25 0 0 0 4.5 21h15a2.25 2.25 0 0 0 2.25-2.25V5.25A2.25 2.25 0 0 0 19.5 3zm.75 15.75a.75.75 0 0 1-.75.75H4.5a.75.75 0 0 1-.75-.75V8.25h16.5v10.5zm0-12H3.75V5.25a.75.75 0 0 1 .75-.75H6V6a.75.75 0 0 0 1.5 0V4.5h9V6a.75.75 0 0 0 1.5 0V4.5h1.5a.75.75 0 0 1 .75.75v1.5z"/>
                <path d="M8.25 10.5h2.25v2.25H8.25zm5.25 0h2.25v2.25H13.5zm-5.25 4.5h2.25v2.25H8.25zm5.25 0h2.25v2.25H13.5z"/>
            </svg>
        @else
            <ion-icon name="{{ 'logo-' . $name }}"
                class="{{ $size === 'default' ? 'text-2xl' : ($size === 'big' ? 'text-3xl' : 'text-xl') }} transition-all duration-300 hover:opacity-30 active:opacity-10">
            </ion-icon>
        @endif
    @endif
    @if ($url)
    </a>
    @endif
</div>


