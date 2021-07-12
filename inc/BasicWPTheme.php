<?php

declare(strict_types = 1);

use Timber\Site;
use Timber\Menu;
use Twig\Environment;
use Twig\Extension\StringLoaderExtension;

/**
 * Class BasicWPTheme
 */
class BasicWPTheme extends Site
{
    public const BASIC_WP_THEME_VERSION = '1.0.0';

    public function __construct()
    {
        add_filter('timber/context', [$this, 'addToContext']);
        add_filter('timber/twig', [$this, 'addToTwig']);

        add_action('after_setup_theme', [$this, 'themeConfig']);
        add_action('widgets_init', [$this, 'themeWidgets']);
        add_action('wp_enqueue_scripts', [$this, 'themeEnqueues']);

        parent::__construct();
    }

    /**
     * Add custom data to Twig's $context.
     *
     * @param array $context context['this'] being Twig's {{ this }}.
     *
     * @return array
     */
    public function addToContext(array $context): array
    {
        $context['site'] = $this;
        $context['menu'] = new Menu();

        return $context;
    }

    /**
     * Add custom functions/functionality to Twig.
     *
     * @param \Twig\Environment $twig The Twig environment.
     *
     * @return \Twig\Environment
     */
    public function addToTwig(Environment $twig): Environment
    {
        $twig->addExtension(new StringLoaderExtension());

        return $twig;
    }

    /**
     * Configure the theme.
     */
    public function themeConfig()
    {
        // Add default posts and comments RSS feed links to head.
        add_theme_support('automatic-feed-links');

        /**
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support('title-tag');

        /**
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
         */
        add_theme_support('post-thumbnails');

        // Register navigation menus.
        register_nav_menus(
            [
                'primary' => esc_html__('Primary', 'basic-wp-theme'),
            ]
        );

        /**
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support(
            'html5',
            [
                'search-form',
                'comment-form',
                'comment-list',
                'gallery',
                'caption',
                'style',
                'script',
            ]
        );

        // Add theme support for selective refresh for widgets.
        add_theme_support('customize-selective-refresh-widgets');

        /**
         * Add support for core custom logo.
         *
         * @link https://codex.wordpress.org/Theme_Logo
         */
        add_theme_support(
            'custom-logo',
            [
                'height' => 250,
                'width' => 250,
                'flex-width' => true,
                'flex-height' => true,
            ]
        );
    }

    /**
     * Add custom widgets to the theme.
     *
     * @see https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
     */
    public function themeWidgets()
    {
        register_sidebar(
            [
                'name' => esc_html__('Sidebar', 'basic-wp-theme'),
                'id' => 'sidebar-1',
                'description' => esc_html__('Add widgets here.', 'basic-wp-theme'),
                'before_widget' => '<aside class="%2$s">',
                'after_widget' => '</aside>',
                'before_title' => '<h2>',
                'after_title' => '</h2>',
            ]
        );
    }

    /**
     * Add custom theme CSS/JS.
     */
    public function themeEnqueues()
    {
        wp_enqueue_style('basic-wp-theme-style', get_stylesheet_uri(), [], self::BASIC_WP_THEME_VERSION);

        if ((!is_admin()) && is_singular() && comments_open() && get_option('thread_comments')) {
            wp_enqueue_script('comment-reply');
        }
    }
}

new BasicWPTheme();
