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
        if (is_child_theme()) {
            $childThemeViewsPath = trailingslashit(get_stylesheet_directory()).'blade-templates/';
            $viewPaths['child-theme-blade'] = $childThemeViewsPath;
        }

        $themeViewsPath = trailingslashit(get_template_directory()).'blade-templates/';
        $viewPaths['parent-theme-blade'] = $themeViewsPath;

        return new \Illuminate\View\FileViewFinder(Filesystem::__getFacadeInstance(), $viewPaths);
    }
}
