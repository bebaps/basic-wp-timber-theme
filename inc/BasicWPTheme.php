<?php

use Timber\Site;
use Timber\Menu;
use Twig\Extension\StringLoaderExtension;

class BasicWPTheme extends Site
{
    public function __construct()
    {
        add_action('after_setup_theme', [$this, 'addThemeSupport']);
        add_filter('timber/context', [$this, 'addToContext']);
        add_filter('timber/twig', [$this, 'addToTwig']);
        add_action('wp_enqueue_scripts', [$this, 'enqueues']);

        parent::__construct();
    }

    /**
     * This is where you add some context.
     *
     * @param  string  $context  context['this'] Being the Twig's {{ this }}.
     *
     * @return mixed
     */
    public function addToContext($context)
    {
        $context['site'] = $this;
        $context['menu'] = new Menu();

        return $context;
    }

    /**
     * Theme supports.
     *
     * @return void
     */
    public function addThemeSupport()
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

        add_theme_support('menus');

        /**
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support(
            'html5',
            [
                'comment-form',
                'comment-list',
                'gallery',
                'caption',
            ]
        );
    }

    /**
     * This is where you can add your own functions to twig.
     *
     * @param  string  $twig  get extension.
     *
     * @return mixed
     */
    public function addToTwig($twig)
    {
        $twig->addExtension(new StringLoaderExtension());

        return $twig;
    }

    /**
     * Enqueue theme assets.
     *
     * @return void
     */
    public function enqueues()
    {
        // Make use of the default WordPress comment script.
        if ((!is_admin()) && is_singular() && comments_open() && get_option('thread_comments')) {
            wp_enqueue_script('comment-reply');
        }
    }
}

new BasicWPTheme();
