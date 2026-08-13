@props(['name', 'href' => null, 'size' => 'default'])

@php
    $url = null;
    if ($href) {
        $url = preg_match('~^https?://~i', $href) ? $href : 'https://' . $href;
    }
@endphp

<div class="inline-flex">
    @if ($url)
    <a href="{{ $url }}" target="_blank">
        @endif
        @if ($name)
        <ion-icon name="{{ 'logo-' . $name }}"
            class="{{ $size === 'default' ? 'text-2xl' : ($size === 'big' ? 'text-3xl' : 'text-xl') }} transition-all duration-300 hover:opacity-30 active:opacity-10">
        </ion-icon>
        @if ($url)
    </a>
    @endif
    @endif
</div>

