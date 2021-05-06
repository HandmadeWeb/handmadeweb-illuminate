<?php

namespace HandmadeWeb\Illuminate\Facades;

use HandmadeWeb\Illuminate\Filter;

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
        Filter::add('illuminate_blade_view_paths', [static::class, 'bladeViewPaths'], 10);

        $viewPaths = Filter::run('illuminate_blade_view_paths', []);

        foreach ($viewPaths as $viewPath) {
            locationExistsOrCreate($viewPath);
        }

        return new \Illuminate\View\FileViewFinder(Filesystem::__getFacadeInstance(), $viewPaths);
    }

    public static function bladeViewPaths($viewPaths = [])
    {
        $additionalViewPaths = [];

        /*
         * If current theme is a child theme, then add the blade-templates folder.
         */
        if (is_child_theme()) {
            $additionalViewPaths['child-theme-blade'] = trailingslashit(get_stylesheet_directory()).'blade-templates/';
        }

        /*
         * Add current theme (or Parent Theme) buildy-views folder
         */
        $additionalViewPaths['parent-theme-blade'] = trailingslashit(get_template_directory()).'blade-templates/';

        return array_merge($viewPaths, $additionalViewPaths);
    }
}
