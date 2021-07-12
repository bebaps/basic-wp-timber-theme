<?php

declare(strict_types = 1);

/**
 * The Template for the sidebar containing the main widget area
 *
 * This really depends on how you wish to implement sidebars,
 * see https://timber.github.io/docs/guides/sidebars/ for options.
 *
 * @package  WordPress
 * @subpackage  Timber
 */

$context = Timber::context();
$context['widget'] = dynamic_sidebar('sidebar-1');

Timber::render(['sidebar.twig'], $context);
