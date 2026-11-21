<?php
/**
 * NexTech Portfolio – inc/setup.php
 *
 * @package NexTech_Portfolio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* -------------------------------------------------------------------------
 * 1. Theme setup & assets
 * ---------------------------------------------------------------------- */

function nextech_setup() {
	load_theme_textdomain( 'nextech-portfolio', get_template_directory() . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 80,
			'width'       => 260,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	// Pages get a manual excerpt, used as the short intro on member cards.
	add_post_type_support( 'page', 'excerpt' );

	add_image_size( 'nextech-card', 720, 480, true );
	add_image_size( 'nextech-profile', 800, 800, true );

	// The main navigation is defined once in inc/helpers.php (nextech_nav_items) so every page shares it.
}
add_action( 'after_setup_theme', 'nextech_setup' );

function nextech_asset_version( $relative ) {
	$path = get_template_directory() . '/' . $relative;
	return file_exists( $path ) ? filemtime( $path ) : NEXTECH_VERSION;
}

function nextech_assets() {
	$uri = get_template_directory_uri();

	wp_enqueue_style( 'nextech-style', get_stylesheet_uri(), array(), nextech_asset_version( 'style.css' ) );
	wp_enqueue_style( 'nextech-animations', $uri . '/assets/css/animations.css', array( 'nextech-style' ), nextech_asset_version( 'assets/css/animations.css' ) );

	wp_enqueue_script( 'nextech-main', $uri . '/assets/js/main.js', array(), nextech_asset_version( 'assets/js/main.js' ), true );
	wp_enqueue_script( 'nextech-animations', $uri . '/assets/js/animations.js', array(), nextech_asset_version( 'assets/js/animations.js' ), true );
}
add_action( 'wp_enqueue_scripts', 'nextech_assets' );

/** Lets you confirm the active version: View Source and search for "nextech-theme-version". */
function nextech_version_meta() {
	echo '<meta name="nextech-theme-version" content="' . esc_attr( NEXTECH_VERSION ) . '">' . "\n";
}
add_action( 'wp_head', 'nextech_version_meta', 1 );
