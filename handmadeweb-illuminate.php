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

require_once __DIR__.'/vendor/autoload.php';

add_action('plugins_loaded', [PluginLoader::class, 'boot'], 1);
