<?php


if (!defined('_S_VERSION')) {
	// Replace the version number of the theme on each release.
	define('_S_VERSION', '1.0.0');
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function vlprime_setup()
{
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on vlprime, use a find and replace
	 * to change 'vlprime' to the name of your theme in all the template files.
	 */
	load_theme_textdomain('vlprime', get_template_directory() . '/languages');

	// Add default posts and comments RSS feed links to head.
	add_theme_support('automatic-feed-links');

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support('title-tag');

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support('post-thumbnails');

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'header' => 'Шапка',
			'footer' => 'Подвал',
		)
	);
	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'vlprime_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support('customize-selective-refresh-widgets');


}
add_action('after_setup_theme', 'vlprime_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function vlprime_content_width()
{
	$GLOBALS['content_width'] = apply_filters('vlprime_content_width', 640);
}
add_action('after_setup_theme', 'vlprime_content_width', 0);


/**
 * Enqueue scripts and styles.
 */
function vlprime_scripts()
{
	wp_enqueue_style('vlprime-style', get_stylesheet_uri(), array(), _S_VERSION);
	wp_enqueue_style('vlprime-style-main', get_template_directory_uri() . '/css/style.css', array(), _S_VERSION);
	wp_enqueue_style('vlprime-style-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Montserrat:wght@400;500;600;700&family=Poppins:wght@600&display=swap', array(), _S_VERSION);
	wp_enqueue_script('vlprime-script-main', get_template_directory_uri() . '/js/script.js', array(), _S_VERSION, true);

	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
}
add_action('wp_enqueue_scripts', 'vlprime_scripts');


if (function_exists('acf_add_options_page')) {

	acf_add_options_page(array(
		'page_title' => 'Основные настройки',
		'menu_title' => 'Настройки темы',
		'menu_slug' => 'theme-general-settings',
		'capability' => 'edit_posts',
		'redirect' => false,
	));

	acf_add_options_sub_page(array(
		'page_title' => 'Настройки шапки',
		'menu_title' => 'Header',
		'parent_slug' => 'theme-general-settings',
	));

	acf_add_options_sub_page(array(
		'page_title' => 'Настройки подвала',
		'menu_title' => 'Footer',
		'parent_slug' => 'theme-general-settings',
	));

}
function custom_menu_link_class($atts, $item, $args)
{
	if ($args->theme_location == 'header') {
		$atts['class'] = 'nav__link';
	}
	return $atts;
}
add_filter('nav_menu_link_attributes', 'custom_menu_link_class', 10, 3);

function allow_svg_upload($mimes)
{
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
add_filter('upload_mimes', 'allow_svg_upload');

add_filter('excerpt_length', function () {
	return 25;
});

add_filter('excerpt_more', function ($more) {
	return '...';
});