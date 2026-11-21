<?php
/**
 * NexTech Portfolio – theme functions (loader).
 *
 * The code is split into small files inside /inc so it is easy to find things:
 *   setup.php       theme supports, menus, CSS/JS enqueue
 *   customizer.php  editable homepage text, email, social links
 *   post-types.php  Projects and private Messages
 *   meta-boxes.php  member and project fields in the dashboard
 *   helpers.php     small functions used by the templates
 *   contact.php     contact form handler
 *   seed.php        one-time labelled placeholder content
 *
 * @package NexTech_Portfolio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'NEXTECH_VERSION', '2.3.1' );
define( 'NEXTECH_MEMBER_TEMPLATE', 'page-member-profile.php' );

$nextech_includes = array(
	'setup',
	'customizer',
	'post-types',
	'meta-boxes',
	'helpers',
	'contact',
	'seed',
);

foreach ( $nextech_includes as $nextech_file ) {
	require_once get_template_directory() . '/inc/' . $nextech_file . '.php';
}
unset( $nextech_includes, $nextech_file );
