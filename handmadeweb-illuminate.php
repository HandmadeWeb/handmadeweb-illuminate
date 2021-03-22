<?php
/*
Plugin Name: Handmade Web - Illuminate
Plugin URI: https://
Description:
Author:
Version: 1.0.0
Author URI: https://
*/

use HandmadeWeb\Illuminate\PluginLoader;

defined('ABSPATH') || exit;

define('ILLUMINATE_ROOT', __DIR__);

/**
 * Composer.
 */
require_once __DIR__.'/vendor/autoload.php';

/**
 * https://actionscheduler.org/.
 */
require_once __DIR__.'/vendor/woocommerce/action-scheduler/action-scheduler.php';

/**
 * HandmadeWeb - Illuminate Helpers.
 */
require_once __DIR__.'/helpers.php';

add_action('plugins_loaded', [PluginLoader::class, 'boot'], -1);
