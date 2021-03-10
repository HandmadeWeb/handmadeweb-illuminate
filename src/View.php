<?php

namespace HandmadeWeb\Illuminate;

class View
{
    protected static $factory;

    public function __construct(array $viewPaths = [])
    {
        $compiledViewPath = __DIR__.'/../compiled-blade-templates';
        $compiledViewPath = apply_filters('handmadeweb-illuminate_blade_compiled_view_path', $compiledViewPath);

        $this->locationExistsOrCreate($compiledViewPath);

        if (is_child_theme()) {
            $childThemeViewsPath = trailingslashit(get_stylesheet_directory()).'blade-templates/';

            $this->locationExistsOrCreate($childThemeViewsPath) ? $viewPaths['child-theme-blade'] = $childThemeViewsPath : null;
        }

        $themeViewsPath = trailingslashit(get_template_directory()).'blade-templates/';
        $this->locationExistsOrCreate($themeViewsPath) ? $viewPaths['parent-theme-blade'] = $themeViewsPath : null;

        $viewPaths = apply_filters('handmadeweb-illuminate_blade_view_paths', $viewPaths);

        $filesystem = new \Illuminate\Filesystem\Filesystem;
        $eventDispatcher = new \Illuminate\Events\Dispatcher();

        // Create View Factory capable of rendering PHP and Blade templates
        $viewResolver = new \Illuminate\View\Engines\EngineResolver;
        $bladeCompiler = new \Illuminate\View\Compilers\BladeCompiler($filesystem, $compiledViewPath);

        $viewResolver->register('blade', function () use ($bladeCompiler) {
            return new \Illuminate\View\Engines\CompilerEngine($bladeCompiler);
        });

        $viewFinder = new \Illuminate\View\FileViewFinder($filesystem, $viewPaths);
        static::$factory = new \Illuminate\View\Factory($viewResolver, $viewFinder, $eventDispatcher);
    }

    public static function getFactory()
    {
        return static::$factory;
    }

    public function locationExistsOrCreate(string $location): bool
    {
        return is_dir($location) ?: mkdir($location, 0755, true);
    }

    public function __call(string $method, array $parameters)
    {
        return static::$factory->$method(...$parameters);
    }

    public static function __callStatic($method, $parameters)
    {
        return static::$factory->$method(...$parameters);
    }
}
