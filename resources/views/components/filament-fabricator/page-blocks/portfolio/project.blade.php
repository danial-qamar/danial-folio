@aware(['page'])

<x-core.layout :with_padding="true">
    @if ($page->project->is_active ?? false)
        <div x-data="{ isOpen: false, imgModalSrc: '' }">
            <header class="mx-auto max-w-5xl">
                <div class="flex flex-col items-start justify-between gap-4 md:flex-row md:items-center">
                    <div>
                        <h1 class="text-2xl font-bold tracking-tighter md:text-3xl lg:text-4xl">{{ $page->title ?? null }}</h1>
                        @if ($page->project->short_description ?? false)
                            <h3 class="my-2 text-base text-secondary-600 dark:text-secondary-400">{{ $page->project->short_description }}</h3>
                        @endif

                        <div class="mt-3 flex flex-wrap items-center gap-3">
                            @if ($page->project->category ?? false)
                                <span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-semibold text-white shadow-sm"
                                      style="background-color: {{ $page->project->category->hex_color ?? '#3b82f6' }};">
                                    @if ($page->project->category->icon ?? false)
                                        <x-ui.ionicon :icon="$page->project->category->icon" class="h-3.5 w-3.5" />
                                    @endif
                                    <span>{{ __(ucfirst($page->project->category->name)) }}</span>
                                </span>
                            @endif

                            @if ($page->project->client ?? false)
                                <span class="inline-flex items-center gap-1.5 text-xs text-secondary-600 dark:text-secondary-400 font-medium">
                                    <x-ui.ionicon icon="person-outline" class="h-4 w-4" />
                                    <span>{{ $page->project->client }}</span>
                                </span>
                            @endif

                            @if ($page->project->external_link ?? false)
                                <a href="{{ $page->project->external_link }}" target="_blank" rel="noopener noreferrer"
                                   class="inline-flex items-center gap-1.5 text-xs font-semibold text-primary-600 hover:text-primary-700 dark:text-primary-400 hover:underline">
                                    <span>{{ __('Live Demo / Link') }}</span>
                                    <x-ui.ionicon icon="open-outline" class="h-3.5 w-3.5" />
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Cover Image --}}
                @if ($page->project->image_cover ?? false)
                    @php
                        $coverImageUrl = asset('storage/' . $page->project->image_cover);
                    @endphp
                    <div class="relative my-8 overflow-hidden rounded-2xl border border-black/10 bg-secondary-100 shadow-xl dark:border-white/10 dark:bg-secondary-900 group">
                        <img src="{{ $coverImageUrl }}"
                             alt="{{ $page->title ?? 'Project Cover' }}"
                             class="w-full h-auto max-h-[650px] object-cover transition-transform duration-500 group-hover:scale-[1.01] cursor-pointer"
                             @click="isOpen = true; imgModalSrc = '{{ $coverImageUrl }}'" />

                        <!-- View Full Size Overlay Button -->
                        <button @click="isOpen = true; imgModalSrc = '{{ $coverImageUrl }}'" 
                                type="button" 
                                class="absolute bottom-4 right-4 flex items-center gap-2 rounded-full bg-black/70 px-4 py-2 text-xs font-medium text-white backdrop-blur-md transition-all hover:bg-black/90 active:scale-95 shadow-md">
                            <x-ui.ionicon icon="expand-outline" class="h-4 w-4" />
                            <span>{{ __('View Full Size') }}</span>
                        </button>
                    </div>
                @endif
            </header>

            <!-- Main Content -->
            <main class="mx-auto mt-8 max-w-5xl">
                <div class="mt-8">
                    <div class="project-content text-sm leading-relaxed" id="project-content">
                        {!! $page->project->content ?? null !!}
                    </div>
                    @if ($page->project->tags ?? false)
                        <div class="mt-8 flex flex-wrap gap-2">
                            @foreach ($page->project->tags as $tags)
                                <div
                                    class="flex w-auto rounded-md border border-black/30 px-2 py-1 text-sm lowercase transition-all duration-300 hover:opacity-30 dark:border-white/30">
                                    <div>{{ $tags }}</div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </main>

            <!-- Lightbox / Full Size Image Modal -->
            <template x-teleport="body">
                <div x-show="isOpen" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     @keydown.escape.window="isOpen = false"
                     class="fixed inset-0 z-50 flex items-center justify-center bg-black/90 p-4 backdrop-blur-md"
                     style="display: none;">
                    
                    <!-- Close Button -->
                    <button @click="isOpen = false" 
                            type="button"
                            class="absolute top-4 right-4 z-50 flex h-11 w-11 items-center justify-center rounded-full bg-white/10 text-white transition-colors hover:bg-white/20">
                        <x-ui.ionicon icon="close-outline" class="h-6 w-6" />
                    </button>

                    <!-- Open Original Image Button -->
                    <a :href="imgModalSrc" 
                       target="_blank" 
                       class="absolute top-4 right-18 z-50 flex items-center gap-2 rounded-full bg-white/10 px-4 py-2 text-xs font-medium text-white transition-colors hover:bg-white/20">
                        <x-ui.ionicon icon="open-outline" class="h-4 w-4" />
                        <span>{{ __('Open Original') }}</span>
                    </a>

                    <!-- Image Display Container -->
                    <div class="relative max-h-full max-w-full overflow-auto p-2" @click.away="isOpen = false">
                        <img :src="imgModalSrc" 
                             alt="Full Size Project Image" 
                             class="max-h-[90vh] max-w-[90vw] rounded-lg object-contain shadow-2xl" />
                    </div>
                </div>
            </template>

            <!-- Footer -->
            <footer class="mx-auto mt-16 max-w-5xl pb-16">
                <!-- Profile section with line -->
                <div class="relative mb-8 flex justify-center">
                    <div class="absolute left-0 right-0 top-1/2 h-px bg-black/10 dark:bg-white/10"></div>
                    <div
                        class="relative z-10 h-20 w-20 overflow-hidden rounded-full border-4 border-white shadow-md dark:border-secondary-800 dark:bg-secondary-950">
                        <img alt="User avatar" class="h-full w-full object-cover"
                            src="{{ $page->user->profile->avatar ? asset('storage/' . $page->user->profile->avatar) : asset('img/core/profile-picture.png') }}">
                    </div>
                </div>
                <!-- Bio -->
                <div class="mx-auto mb-12 max-w-2xl text-center">
                    <h2 class="text-lg font-semibold">{{ $page->user->name }}</h2>
                    <p class="mb-4 text-sm">
                        {!! ($page->user->profile->job_position ?? null) . ' • ' . ($page->user->profile->localization ?? null) !!}
                    </p>
                    <x-ui.social-network :justify="'center'" />
                </div>
            </footer>

            <!-- Gallery -->
            <div class="flex flex-wrap items-center justify-start gap-2">
                <x-ui.ionicon :icon="'bookmark'" />
                <h3 class="text-xl font-semibold">{{ __('More from ') . ($page->user->name ?? null) }}</h3>
            </div>
            @livewire('portfolio.gallery')
        </div>
    @else
        <x-blog.post.not-found />
    @endif
</x-core.layout>

