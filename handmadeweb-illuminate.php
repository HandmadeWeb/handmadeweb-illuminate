<?php

/**
 * Plugin Name: Handmade Web - Illuminate
 * Plugin URI: https://github.com/handmadeweb/handmadeweb-illuminate
 * Description: Handmade Web - Illuminate
 * Author: Handmade Web
 * Version: 1.0.1
 * Author URI: https://www.handmadeweb.com.au/
 * GitHub Plugin URI: https://github.com/handmadeweb/handmadeweb-illuminate
 * Primary Branch: main
 * Requires at least: 5.0
 * Requires PHP: 7.3
 * Go: Enjoy.
 */

use HandmadeWeb\Illuminate\PluginLoader;

defined('ABSPATH') || exit;

define('ILLUMINATE_ROOT', trailingslashit(__DIR__));
define('ILLUMINATE_URL', plugin_dir_url(__FILE__));

/**
 * Composer.
 */
require __DIR__.'/vendor/autoload.php';

/**
 * https://actionscheduler.org/.
 */
require __DIR__.'/vendor/woocommerce/action-scheduler/action-scheduler.php';

/**
 * HandmadeWeb - Illuminate Helpers.
 */
require __DIR__.'/helpers.php';

add_action('plugins_loaded', [PluginLoader::class, 'boot'], -1);

/*
 * Disable translations for speed improvement.
 */
if (!defined('ENABLE_TRANSLATIONS') || defined('ENABLE_TRANSLATIONS') && !ENABLE_TRANSLATIONS) {
    add_filter('override_load_textdomain', '__return_true');
}
