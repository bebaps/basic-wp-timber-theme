<?php
/**
 * If you are installing Timber as a Composer dependency in your theme, you'll need this block
 * to load your dependencies and initialize Timber. If you are using Timber via the WordPress.org
 * plug-in, you can safely delete this block.
 */
$composer_autoload = __DIR__ . '/vendor/autoload.php';

if (file_exists($composer_autoload)) {
    require_once $composer_autoload;
    $timber = new Timber\Timber();
}

/**
 * This ensures that Timber is loaded and available as a PHP class.
 * If not, it gives an error message to help direct developers on where to activate.
 */
if (!class_exists('Timber')) {
    add_action(
        'admin_notices',
        function() {
            echo '<div class="error"><p>This theme will not work until Timber is activated. <a href="' . esc_url(admin_url('plugins.php#timber')) . '">Activate the plugin</a> or install it as a dependency via Composer.</p></div>';
        }
    );

    add_filter(
        'template_include',
        function($template) {
            return get_theme_file_path('static/timber.html');
        }
    );
    return;
}

/**
 * Sets the directories (inside your theme) to find .twig files
 */
Timber::$dirname = ['templates'];

/**
 * By default, Timber does NOT autoescape values. Want to enable Twig's autoescape?
 * No prob! Just set this value to true
 */
Timber::$autoescape = false;

/**
 * Add a custom route for blog posts.
 * They can be visited via /post-name as well as /blog/post-name.
 *
 * See https://timber.github.io/docs/guides/routing
 */
Routes::map('blog/:name', function($params) {
    $query = 'post_type=post&name=' . $params['name'];
    Routes::load('single.php', null, $query, 200);
});

/**
 * Cache compiled Twig files.
 * This does not cache the contents of the variables.
 * Best to set to true only when going to production.
 *
 * See https://timber.github.io/docs/guides/performance/#cache-the-twig-file-but-not-the-data
 */
Timber::$cache = false;

/**
 * Instantiate the core theme class.
 */
require_once __DIR__ . '/inc/BasicWPTheme.php';
