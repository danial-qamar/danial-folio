<?php

namespace App\Providers;

use App\Models\Core;
use App\Models\Maintenance;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Z3d0X\FilamentFabricator\Facades\FilamentFabricator;
use Z3d0X\FilamentFabricator\PageBlocks\PageBlock;
use Z3d0X\FilamentFabricator\Services\PageRoutesService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (request()->header('X-Forwarded-Proto') === 'https' || app()->environment('production')) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        Route::bind('filamentFabricatorPage', function ($value) {
            $routesService = resolve(PageRoutesService::class);
            $uri           = blank($value) ? '/' : (string) $value;

            return $routesService->findPageOrFail($uri);
        });

        FilamentFabricator::registerLayout(\App\Filament\Fabricator\Layouts\DefaultLayout::class);
        FilamentFabricator::registerLayout(\App\Filament\Fabricator\Layouts\Juno::class);

        $this->registerPageBlocks();

        if (Schema::hasTable('settings')) {
            $maintenance = optional(Maintenance::first(['is_active', 'is_discovery']));
            view()->share([
                'discovery'   => $maintenance->is_discovery ?? false,
                'maintenance' => $maintenance->is_active ?? false,
            ]);
        }

        if (Schema::hasTable('cores')) {
            $data = Core::first([
                'footer',
                'header',
            ]);
            view()
                ->share([
                    'footer_core' => $data->footer ?? false,
                    'header_core' => $data->header ?? false,
                ]);
        }
    }

    protected function registerPageBlocks(): void
    {
        $blocksPath = app_path('Filament/Fabricator/PageBlocks');
        if (! file_exists($blocksPath)) {
            return;
        }

        $filesystem = new Filesystem();
        foreach ($filesystem->allFiles($blocksPath) as $file) {
            $relativePath = str_replace(['/', '.php'], ['\\', ''], $file->getRelativePathname());
            $class        = 'App\\Filament\\Fabricator\\PageBlocks\\' . $relativePath;
            if (class_exists($class) && is_subclass_of($class, PageBlock::class)) {
                FilamentFabricator::registerPageBlock($class);
            }
        }
    }
}
