<?php

namespace OmniaDigital\CatalystForms;

use Filament\Support\Assets\AlpineComponent;
use Filament\Support\Assets\Asset;
use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Facades\FilamentIcon;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Illuminate\View\Compilers\BladeCompiler;
use Livewire\Component;
use Livewire\Features\SupportTesting\Testable;
use Livewire\Livewire;
use OmniaDigital\CatalystForms\Commands\CatalystFormsPluginCommand;
use OmniaDigital\CatalystForms\Testing\TestsCatalystFormsPlugin;
use ReflectionClass;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use SplFileInfo;

class CatalystFormsPluginServiceProvider extends PackageServiceProvider
{
    public static string $name = 'catalyst-forms-plugin';

    public static string $viewNamespace = 'catalyst-forms';

    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package->name(static::$name)
            ->hasCommands($this->getCommands())
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishConfigFile()
                    ->publishMigrations()
                    ->askToRunMigrations()
                    ->askToStarRepoOnGitHub('omnia-digital/catalyst-forms-plugin');
            });

        $configFileName = $package->shortName();

        if (file_exists($package->basePath("/../config/{$configFileName}.php"))) {
            $package->hasConfigFile();
        }

        if (file_exists($package->basePath('/../database/migrations'))) {
            $package->hasMigrations($this->getMigrations());
        }

        if (file_exists($package->basePath('/../resources/lang'))) {
            $package->hasTranslations();
        }

        if (file_exists($package->basePath('/../resources/views'))) {
            $package->hasViews(static::$viewNamespace);
        }

        if (file_exists($package->basePath('/Livewire'))) {
            $this->registerLivewireComponents($package);
        }
    }

    public function registerLivewireComponents($package)
    {
        $this->callAfterResolving(BladeCompiler::class, function () use ($package) {
            if (class_exists(Livewire::class) && file_exists($package->basePath('/Livewire'))) {
                $namespace = 'OmniaDigital\CatalystForms\Livewire';
                $_directory = Str::of($package->basePath('/Livewire'))
                    ->replace('\\', '/')
                    ->toString();

                $this->registerComponentDirectory($_directory, $namespace);
            }
        });
    }

    /**
     * Register component directory.
     *
     * @param string $directory
     * @param string $namespace
     * @param string $aliasPrefix
     *
     * @return void
     */
    protected function registerComponentDirectory(string $directory, string $namespace): void
    {
        $filesystem = new Filesystem();

        /**
         * Directory doesn't existS.
         */
        if (!$filesystem->isDirectory($directory)) {
            return;
        }

        $aliases = collect();

        collect($filesystem->allFiles($directory))
            ->map(fn(SplFileInfo $file) => Str::of($namespace)
                ->append("\\{$file->getRelativePathname()}")
                ->replace(['/', '.php'], ['\\', ''])
                ->toString())
            ->filter(fn($class) => (is_subclass_of($class,
                    Component::class) && !(new ReflectionClass($class))->isAbstract()))
            ->each(function ($class) use ($namespace, $aliases) {
                $alias = Str::of($class)
                    ->after($namespace . '\\')
                    ->replace(['/', '\\'], '.')
                    ->explode('.')
                    ->map([Str::class, 'kebab'])
                    ->implode('.');
                $aliases->push($alias);
                $this->registerSingleComponent($class, $namespace);
            });
    }

    /**
     * Register livewire single component.
     *
     * @param string $class
     * @param string $namespace
     * @param string $aliasPrefix
     *
     * @return void
     */
    private function registerSingleComponent(string $class, string $namespace): void
    {
        $alias = Str::of($class)
            ->after($namespace . '\\')
            ->replace(['/', '\\'], '.')
            ->explode('.')
            ->map([Str::class, 'kebab'])
            ->implode('.');

        $prefix = 'catalyst::';
        Livewire::component($alias, $class);

        Str::endsWith($class, ['\Index', '\index'])
            ? Livewire::component($prefix . Str::beforeLast($alias, '.index'), $class)
            : Livewire::component($prefix . $alias, $class);
    }


    public function packageRegistered(): void
    {
    }

    public function packageBooted(): void
    {
        // Asset Registration
        FilamentAsset::register(
            $this->getAssets(),
            $this->getAssetPackageName()
        );

        FilamentAsset::registerScriptData(
            $this->getScriptData(),
            $this->getAssetPackageName()
        );

        // Icon Registration
        FilamentIcon::register($this->getIcons());

        // Handle Stubs
        if (app()->runningInConsole()) {
            foreach (app(Filesystem::class)->files(__DIR__ . '/../stubs/') as $file) {
                $this->publishes([
                    $file->getRealPath() => base_path("stubs/catalyst-forms-plugin/{$file->getFilename()}"),
                ], 'catalyst-forms-plugin-stubs');
            }
        }

        // Testing
        Testable::mixin(new TestsCatalystFormsPlugin());
    }

    protected function getAssetPackageName(): ?string
    {
        return 'omnia-digital/catalyst-forms-plugin';
    }

    /**
     * @return array<Asset>
     */
    protected function getAssets(): array
    {
        return [
            // AlpineComponent::make('catalyst-forms-plugin', __DIR__ . '/../resources/dist/components/catalyst-forms-plugin.js'),
            Css::make('catalyst-forms-plugin-styles', __DIR__ . '/../resources/dist/catalyst-forms-plugin.css'),
            Js::make('catalyst-forms-plugin-scripts', __DIR__ . '/../resources/dist/catalyst-forms-plugin.js'),
        ];
    }

    /**
     * @return array<class-string>
     */
    protected function getCommands(): array
    {
        return [
            CatalystFormsPluginCommand::class,
        ];
    }

    /**
     * @return array<string>
     */
    protected function getIcons(): array
    {
        return [];
    }

    /**
     * @return array<string>
     */
    protected function getRoutes(): array
    {
        return [];
    }

    /**
     * @return array<string, mixed>
     */
    protected function getScriptData(): array
    {
        return [];
    }

    /**
     * @return array<string>
     */
    protected function getMigrations(): array
    {
        return [
            'create_catalyst-forms-plugin_table',
        ];
    }
}
