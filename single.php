<?php

declare(strict_types = 1);

/**
 * The Template for displaying all single posts
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since    Timber 0.1
 */

$context = Timber::context();
$timber_post = Timber::query_post();

$context['post'] = $timber_post;
$context['sidebar'] = Timber::get_sidebar('sidebar.php');

if (post_password_required($timber_post->ID)) {
    Timber::render('single-password.twig', $context);
} else {
    Timber::render(
        [
            'single-' . $timber_post->ID . '.twig',
            'single-' . $timber_post->post_type . '.twig',
            'single-' . $timber_post->slug . '.twig',
            'single.twig',
        ],
        $context
    );
}
