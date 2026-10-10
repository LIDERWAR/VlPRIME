<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Enqueue scripts and styles.
 */
function vl_prime_scripts()
{
    // Google Fonts
    wp_enqueue_style('vl-prime-google-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Montserrat:wght@700&family=Poppins:wght@600&display=swap', array(), null);

    // Main CSS
    // We use filemtime for versioning to bust cache on updates
    wp_enqueue_style('vl-prime-style', get_template_directory_uri() . '/assets/css/style.css', array(), filemtime(get_template_directory() . '/assets/css/style.css'));

    // Main JS
    wp_enqueue_script('vl-prime-script', get_template_directory_uri() . '/assets/js/script.js', array(), filemtime(get_template_directory() . '/assets/js/script.js'), true);
}
add_action('wp_enqueue_scripts', 'vl_prime_scripts');

/**
 * Theme Setup
 */
function vl_prime_setup()
{
    // Register Menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'vl-prime'),
        'footer' => __('Footer Menu', 'vl-prime'),
    ));

    // Add theme support
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo');
}
add_action('after_setup_theme', 'vl_prime_setup');

/**
 * Include ACF Fields
 */
require_once get_template_directory() . '/includes/acf-fields.php';
