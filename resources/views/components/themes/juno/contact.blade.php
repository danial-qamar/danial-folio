<div class="px-4">
    @if($is_heading_visible)
    <x-themes.juno.partials.header :$title :$subtitle />
    @endif
    @if(isset($content['google_map']))
    <div class="relative min-h-[600px]">
        <!-- Google Maps Background -->
        <div
            class="absolute grayscale inset-0 w-full h-full pointer-events-none hover:pointer-events-auto transition-all duration-300">
            <iframe src="{{ $content['google_map'] }}" class="w-full h-full border-0" allowfullscreen="false"
                loading="lazy" referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
        <!-- Contact Info Overlay -->
        <div class="relative z-10 p-8 grid grid-cols-1 md:grid-cols-2">
            <div class="hidden md:block"></div>
            <div
                class="max-w-md bg-white/95 dark:bg-secondary-800/95 rounded-lg shadow-lg p-8 backdrop-blur-sm ml-auto">
                <div class="space-y-4">
                    @isset($content['address'])
                    <div class="flex items-start gap-3">
                        <x-ui.ionicon class="mt-1 h-5 w-5" icon="location-outline" />
                        <div>
                            <p class="text-sm font-medium">{{ __('Address') }}</p>
                            <p>{!! $content['address'] ?? null !!}</p>
                        </div>
                    </div>
                    @endisset

                    @isset($content['phone'])
                    <div class="flex items-start gap-3">
                        <x-ui.ionicon class="mt-1 h-5 w-5" icon="call-outline" />
                        <div>
                            <p class="text-sm font-medium">Phone</p>
                            <p class="mt-1 text-sm">{!! $content['phone'] !!}</p>
                        </div>
                    </div>
                    @endisset

                    @isset($content['email'])
                    <div class="flex items-start gap-3">
                        <x-ui.ionicon class="mt-1 h-5 w-5" icon="mail-outline" />
                        <div>
                            <p class="text-sm font-medium">Email</p>
                            <p class="mt-1 text-sm">{{ $content['email'] ?? null }}</p>
                        </div>
                    </div>
                    @endisset

                    @isset($content['business_hour'])
                    <div class="flex items-start gap-3">
                        <x-ui.ionicon class="mt-1 h-5 w-5" icon="time-outline" />
                        <div>
                            <p class="text-sm font-medium">Business Hours</p>
                            <p class="mt-1 text-sm">{!! $content['business_hour'] !!}</p>
                        </div>
                    </div>
                    @endisset

                    @if ($calendlyUrl)
                    <div class="flex items-start gap-3">
                        <x-ui.ionicon class="mt-1 h-5 w-5" icon="calendar-outline" />
                        <div>
                            <p class="text-sm font-medium">{{ __('Schedule a Meeting') }}</p>
                            <a href="{{ $calendlyUrl }}" target="_blank" rel="noopener noreferrer" class="mt-1 inline-flex items-center gap-1 text-sm hover:underline text-secondary-600 dark:text-secondary-400">
                                <span>{{ __('Book time on Calendly') }}</span>
                                <x-ui.ionicon icon="open-outline" class="h-3.5 w-3.5 opacity-70" />
                            </a>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Contact Form -->
                <div class="mt-6">
                    @if ($calendlyUrl)
                    <div class="mb-4">
                        <a href="{{ $calendlyUrl }}" target="_blank" rel="noopener noreferrer" class="block">
                            <button type="button" class="saturn-btn-secondary w-full justify-center text-xs font-medium py-2">
                                <x-ui.ionicon icon="calendar-outline" class="h-4 w-4 mr-1" />
                                <span>{{ __('Book a Meeting') }}</span>
                                <x-ui.ionicon icon="open-outline" class="h-3 w-3 ml-1 opacity-70" />
                            </button>
                        </a>
                    </div>
                    @endif
                    @livewire('mail.create-mail')
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="grid gap-8 md:grid-cols-2">
        <!-- Contact Info Column -->
        <div class="space-y-6">
            <div>
                <div class="space-y-4">
                    @isset($content['address'])
                    <div class="flex items-start gap-3">
                        <x-ui.ionicon class="mt-1 h-5 w-5" icon="location-outline" />
                        <div>
                            <p class="text-sm font-medium">
                                {{ __('Address') }}</p>
                            <p>{!! $content['address'] ?? null !!} </p>
                        </div>
                    </div>
                    @endisset
                    @isset($content['phone'])
                    <div class="flex items-start gap-3">
                        <x-ui.ionicon class="mt-1 h-5 w-5" icon="call-outline" />
                        <div>
                            <p class="text-sm font-medium ">
                                Phone</p>
                            <p class="mt-1 text-sm  ">
                                {!! $content['phone'] !!}</p>
                        </div>
                    </div>
                    @endisset
                    @isset($content['email'])
                    <div class="flex items-start gap-3">
                        <x-ui.ionicon class="mt-1 h-5 w-5" icon="mail-outline" />
                        <div>
                            <p class="text-sm font-medium ">
                                Email</p>
                            <p class="mt-1 text-sm  ">
                                {{ $content['email'] ?? null }}</p>
                        </div>
                    </div>
                    @endisset
                    @isset($content['business_hour'])
                    <div class="flex items-start gap-3">
                        <x-ui.ionicon class="mt-1 h-5 w-5" icon="time-outline" />
                        <div>
                            <p class="text-sm font-medium ">
                                Business Hours</p>
                            <p class="mt-1 text-sm">
                                {!! $content['business_hour'] !!}
                            </p>
                        </div>
                    </div>
                    @endisset
                    @if ($calendlyUrl)
                    <div class="flex items-start gap-3">
                        <x-ui.ionicon class="mt-1 h-5 w-5" icon="calendar-outline" />
                        <div>
                            <p class="text-sm font-medium">{{ __('Schedule a Meeting') }}</p>
                            <a href="{{ $calendlyUrl }}" target="_blank" rel="noopener noreferrer" class="mt-1 inline-flex items-center gap-1 text-sm hover:underline text-secondary-600 dark:text-secondary-400">
                                <span>{{ __('Book time on Calendly') }}</span>
                                <x-ui.ionicon icon="open-outline" class="h-3.5 w-3.5 opacity-70" />
                            </a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <!-- Contact Form Column -->
        <div>
            @if ($calendlyUrl)
            <div class="mb-6 rounded-xl border border-secondary-200 dark:border-secondary-700 bg-secondary-50/50 dark:bg-secondary-800/50 p-5 shadow-sm">
                <div class="flex items-start gap-3">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-secondary-900 text-white dark:bg-secondary-100 dark:text-secondary-950">
                        <x-ui.ionicon icon="calendar-outline" class="h-5 w-5" />
                    </div>
                    <div class="flex-1">
                        <h3 class="text-sm font-semibold text-secondary-900 dark:text-secondary-100">{{ __('Schedule a Meeting') }}</h3>
                        <p class="mt-0.5 text-xs text-secondary-600 dark:text-secondary-400">{{ __('Prefer to talk directly? Pick a time on my calendar.') }}</p>
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
                    <div class="w-full border-t border-secondary-200 dark:border-secondary-700"></div>
                </div>
                <span class="relative bg-white dark:bg-secondary-900 px-3 text-xs uppercase tracking-wider text-secondary-500">{{ __('Or send a message') }}</span>
            </div>
            @endif
            @livewire('mail.create-mail')
        </div>
    </div>
    @endif
</div>
