{{-- Quick View Modal --}}
<div x-data="{
    show: false,
    project: null,
    baseUrl: '{{ config('app.url') }}',
    toggleBodyScroll() {
        if (this.show) {
            document.body.style.overflow = 'hidden';
        } else {
            document.body.style.overflow = '';
        }
    }
}" @open-quick-view.window="
    project = $event.detail;
    show = true;
    toggleBodyScroll();
    $nextTick(() => $refs.dialog.focus());
" @keydown.escape.window="show = false; toggleBodyScroll()"
    @keydown.tab.prevent="$event.shiftKey ? $refs.closeBtn.focus() : $refs.closeBtn.focus()">

    {{-- Backdrop with Blur --}}
    <div x-show="show" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 bg-black/40 backdrop-blur-sm dark:bg-black/60"
        @click="show = false; toggleBodyScroll()">
    </div>

    {{-- Modal Dialog --}}
    <div x-show="show" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6"
        @click.self="show = false; toggleBodyScroll()">

        {{-- Close Button (Moved Outside the Card) --}}
        <button x-ref="closeBtn" @click="show = false; toggleBodyScroll()"
            class="absolute right-6 top-6 z-50 flex h-8 w-8 items-center justify-center rounded-full bg-white/90 transition-colors hover:bg-white shadow-lg dark:bg-secondary-900/90 dark:hover:bg-secondary-900">
            <span class="sr-only">{{ __('Close modal') }}</span>
            <x-ui.ionicon icon="close-outline" class="h-4 w-4 text-secondary-700 dark:text-secondary-300" />
        </button>

        <div x-ref="dialog" role="dialog" aria-modal="true" :aria-labelledby="'modal-title-' + project?.id"
            class="relative w-full max-w-2xl overflow-hidden rounded-xl focus:outline-none border border-secondary-200 dark:border-secondary-800 shadow-xl">

            {{-- Project Content --}}
            <div class="relative bg-white dark:bg-secondary-900 rounded-xl overflow-hidden shadow-2xl">
                {{-- Project Image --}}
                <div class="aspect-[16/9] w-full overflow-hidden bg-secondary-100 dark:bg-secondary-950 relative">
                    <template x-if="project && project.image_cover">
                        <img :src="'/storage/' + project.image_cover" :alt="project.title"
                            class="h-full w-full object-cover">
                    </template>

                    {{-- Category Badge --}}
                    <div class="absolute top-4 left-4 z-10">
                        <div class="flex items-center gap-1.5 w-fit rounded-full px-3 py-1 text-xs font-semibold text-white shadow-md"
                            x-bind:style="(project && project.category) ?
                            `background-color: ${project.category.hex_color}; border-color: ${project.category.hex_color};`
                            : 'background-color: rgb(17, 24, 39); border-color: rgb(17, 24, 39);'">
                            <span x-show="project && project.category && project.category.icon">
                                <x-ui.ionicon :icon="'bookmark-sharp'" class="h-3.5 w-3.5" />
                            </span>
                            <span x-text="(project && project.category) ? project.category.name : ''"></span>
                        </div>
                    </div>
                </div>

                {{-- Project Details Section --}}
                <div class="p-6">
                    <h3 x-bind:id="'modal-title-' + (project ? project.id : '')"
                        class="text-xl font-bold tracking-tight text-secondary-900 dark:text-white"
                        x-text="project ? project.title : ''">
                    </h3>

                    <template x-if="project && project.short_description">
                        <p class="mt-2 text-sm text-secondary-600 dark:text-secondary-400 leading-relaxed"
                           x-text="project.short_description"></p>
                    </template>

                    <div class="mt-5 flex items-center justify-between gap-4 pt-4 border-t border-secondary-100 dark:border-secondary-800">
                        <a x-bind:href="baseUrl + '/' + (project ? project.slug : '')"
                           class="inline-flex items-center gap-2 rounded-lg bg-black text-white dark:bg-white dark:text-black px-4 py-2 text-sm font-semibold transition-all hover:opacity-80 shadow-sm">
                            <span>{{ __('View Full Project') }}</span>
                            <x-ui.ionicon icon="arrow-forward-outline" class="h-4 w-4" />
                        </a>

                        <template x-if="project && project.external_link">
                            <a x-bind:href="project.external_link" target="_blank" rel="noopener noreferrer"
                               class="inline-flex items-center gap-1.5 text-xs font-medium text-secondary-500 hover:text-secondary-700 dark:text-secondary-400 dark:hover:text-white">
                                <span>{{ __('External Link') }}</span>
                                <x-ui.ionicon icon="open-outline" class="h-3.5 w-3.5" />
                            </a>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
