<?php
/**
 * We're going to configure our theme inside of a subclass of Timber\Site
 * You can move this to its own file and include here via php's include("MySite.php")
 */

use Timber\Site;
use Timber\Menu;
use Twig\Extension\StringLoaderExtension;

class BasicWPTheme extends Site
{
    /**
     * Add timber support.
     */
    public function __construct()
    {
        add_action('after_setup_theme', [$this, 'theme_supports']);
        add_filter('timber/context', [$this, 'add_to_context']);
        add_filter('timber/twig', [$this, 'add_to_twig']);
        add_action('wp_enqueue_scripts', [$this, 'theme_assets']);
        add_action('init', [$this, 'register_post_types']);
        add_action('init', [$this, 'register_taxonomies']);

        parent::__construct();
    }

    /**
     * This is where you can register custom post types.
     *
     * @return void
     */
    public function register_post_types()
    {

    }

    /**
     * This is where you can register custom taxonomies.
     */
    public function register_taxonomies()
    {

    }

    /**
     * This is where you add some context.
     *
     * @param  string  $context  context['this'] Being the Twig's {{ this }}.
     *
     * @return mixed
     */
    public function add_to_context($context)
    {
        $context['menu'] = new Menu();
        $context['site'] = $this;

        return $context;
    }

    /**
     * Theme supports.
     *
     * @return void
     */
    public function theme_supports()
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

        add_theme_support('menus');
    }

    /**
     * This is where you can add your own functions to twig.
     *
     * @param  string  $twig  get extension.
     *
     * @return mixed
     */
    public function add_to_twig($twig)
    {
        $twig->addExtension(new StringLoaderExtension());

        return $twig;
    }

    /**
     * Enqueue theme assets.
     *
     * @return void
     */
    public function theme_assets()
    {
        // Make use of the default WordPress comment script.
        if ((!is_admin()) && is_singular() && comments_open() && get_option('thread_comments')) {
            wp_enqueue_script('comment-reply');
        }
    }
}

new BasicWPTheme();
