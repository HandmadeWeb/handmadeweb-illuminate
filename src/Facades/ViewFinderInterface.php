<?php

namespace HandmadeWeb\Illuminate\Facades;

use HandmadeWeb\Illuminate\AbstractFacadeClass;

class ViewFinderInterface extends AbstractFacadeClass
{
    /**
     * The facaded instance.
     */
    protected static $instance;

    /**
     * Set the instance behind the facade.
     *
     * @return string
     */
    protected static function __setFacadeInstance()
    {
        add_filter('handmadeweb-illuminate_blade_view_paths', [static::class, 'bladeViewPaths'], 1);

        $viewPaths = apply_filters('handmadeweb-illuminate_blade_view_paths', []);

        foreach ($viewPaths as $viewPath) {
            locationExistsOrCreate($viewPath);
        }

        return new \Illuminate\View\FileViewFinder(Filesystem::__getFacadeInstance(), $viewPaths);
    }

    public static function bladeViewPaths($viewPaths = [])
    {
        /*
         * If current theme is a child theme, then add the blade-templates folder.
         */
        if (is_child_theme()) {
            $childThemeViewsPath = trailingslashit(get_stylesheet_directory()).'blade-templates/';
            $viewPaths['child-theme-blade'] = $childThemeViewsPath;
        }

        /*
         * Add current theme (or Parent Theme) blade-templates folder
         */
        $themeViewsPath = trailingslashit(get_template_directory()).'blade-templates/';
        $viewPaths['parent-theme-blade'] = $themeViewsPath;

        return $viewPaths;
    }
}
