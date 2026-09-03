@if($is_active)
<x-core.layout :$is_filled :$with_padding :$module_name :$button_header :$button_url :$is_centered :$title :$subtitle
    :$is_section_filled_inverted :$is_heading_visible :$button_icon :$module_slug>
    <section class="mx-auto my-12 flex flex-wrap justify-between" id="contact-wrapper">
        <div class="w-full lg:w-2/3 pr-8">
            @if ($content['google_map'] ?? null)
            <div
                class="{{ $is_section_filled_inverted ? 'bg-secondary-950 text-secondary-50 dark:bg-secondary-50 dark:text-secondary-950' : ' bg-secondary-50 dark:bg-secondary-950' }} relative flex h-96 items-end justify-start overflow-hidden rounded-lg p-10 lg:h-full">
                <iframe class="absolute inset-0" frameborder="0" height="100%" marginheight="0" marginwidth="0"
                    scrolling="no" src="{{ $content['google_map'] ?? null }}"
                    style="filter: grayscale(1) contrast(1) opacity(0.9);" title="map" width="100%">
                </iframe>
                <div
                    class="{{ $is_section_filled_inverted ? 'bg-secondary-950 text-secondary-50 dark:bg-secondary-50 dark:text-secondary-950' : ' bg-secondary-50 dark:bg-secondary-950' }} relative flex flex-wrap rounded py-6 text-xs">
                    <div class="px-6">
                        <h2 class="font-semibold uppercase tracking-widest">{{ __('Address') }}</h2>
                        <p class="mt-3">{!! $content['address'] ?? null !!}</p>
                    </div>
                    <div class="mt-4 px-6 lg:mt-0">
                        <h2 class="mb-1 font-semibold uppercase tracking-widest">{{ __('E-mail') }}</h2>
                        <a class="leading-relaxed">{{ $content['email'] }}</a>
                        <h2 class="mb-1 mt-4 font-semibold uppercase tracking-widest">{{ __('Phone') }}</h2>
                        <p class="leading-relaxed">{{ $content['phone'] }}</p>
                    </div>
                </div>
            </div>
            @else
            {{-- Address without Google Maps --}}
            <div class="mx-auto grid pr-8">
                @if ($content['address'] ?? null)
                <x-ui.info-box icon="business" title="{{ __('Headquarter') }}">
                    <p>{!! $content['address'] ?? null !!}</p>
                    <p>{!! $content['business_hours'] ?? null !!}</p>
                </x-ui.info-box>
                @endif
                <div class="flex flex-wrap">
                    @if ($content['phone'] ?? null)
                    <span class="w-1/2">
                        <x-ui.info-box icon="call" title="{{ __('Phone') }}">
                            <p>{!! '+' . config('MOBILE_COUNTRY_CODE') . ' ' . ($content['phone'] ?? null)
                                !!}
                            </p>
                        </x-ui.info-box>
                    </span>
                    @endif
                    @if ($content['email'] ?? null)
                    <span class="w-1/2">
                        <x-ui.info-box icon="mail-open" title="{{ __('Mail') }}">
                            <p>{!! $content['email'] ?? null !!}</p>
                        </x-ui.info-box>
                    </span>
                    @endif
                </div>
                {{-- Social Network --}}
                @if ($socialNetwork)
                <x-ui.info-box icon="infinite" title="{{ __('Follow') }}">
                    <x-ui.social-network justify="start" />
                </x-ui.info-box>
                @endif
                {{-- End Social Network --}}
                {{-- Calendly Info Box --}}
                @if ($calendlyUrl)
                <x-ui.info-box icon="calendar-outline" title="{{ __('Schedule a Meeting') }}">
                    <a href="{{ $calendlyUrl }}" target="_blank" rel="noopener noreferrer"
                        class="inline-flex items-center gap-2 text-sm font-medium saturn-text hover:opacity-80 transition-all">
                        <x-ui.ionicon icon="calendar-outline" class="h-4 w-4" />
                        <span>{{ __('Book time on Calendly') }}</span>
                        <x-ui.ionicon icon="open-outline" class="h-3.5 w-3.5 opacity-70" />
                    </a>
                </x-ui.info-box>
                @endif
                {{-- End Calendly Info Box --}}
                {{-- Empty Fields --}}
                @if (
                ($content['address'] ?? null) == null ||
                (($content['phone'] ?? null) == null && ($content['email'] ?? null) == null))
                <x-ui.empty-address :data="$content" />
                @endif
                {{-- End Empty Fields --}}
            </div>
            @endif
        </div>
        {{-- Livewire: Message Form & Calendly --}}
        <div class="w-full p-4 lg:w-1/3 lg:p-8">
            @if ($calendlyUrl)
            {{-- Calendly Schedule Card --}}
            <div class="mb-6 rounded-xl border saturn-border saturn-bg-accent/40 p-5 shadow-sm backdrop-blur-sm transition-all hover:border-saturn-500/50">
                <div class="flex items-start gap-3">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-secondary-900 text-white dark:bg-secondary-100 dark:text-secondary-950">
                        <x-ui.ionicon icon="calendar-outline" class="h-5 w-5" />
                    </div>
                    <div class="flex-1">
                        <h3 class="text-sm font-semibold saturn-text">{{ __('Schedule a Meeting') }}</h3>
                        <p class="mt-0.5 text-xs saturn-text-accent">{{ __('Prefer to talk directly? Pick a time on my calendar.') }}</p>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ $calendlyUrl }}" target="_blank" rel="noopener noreferrer" class="block">
                        <button type="button" class="saturn-btn-secondary w-full justify-center text-xs font-medium py-2.5">
                            <x-ui.ionicon icon="calendar-outline" class="h-4 w-4 mr-1" />
                            <span>{{ __('Book a Meeting') }}</span>
                            <x-ui.ionicon icon="open-outline" class="h-3 w-3 ml-1 opacity-70" />
                        </button>
                    </a>
                </div>
            </div>
            <div class="relative my-6 text-center">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t saturn-border"></div>
                </div>
                <span class="relative bg-white px-3 text-xs uppercase tracking-wider text-secondary-500 dark:bg-secondary-950 saturn-text-accent">{{ __('Or send a message') }}</span>
            </div>
            @endif
            <livewire:mail.create-mail :$is_section_filled_inverted />
        </div>
    </section>
</x-core.layout>
@endif
