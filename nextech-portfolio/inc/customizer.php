<?php
/**
 * NexTech Portfolio – inc/customizer.php
 *
 * @package NexTech_Portfolio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* -------------------------------------------------------------------------
 * 2. Editable site content (Appearance → Customize → NexTech Content)
 * ---------------------------------------------------------------------- */

function nextech_content_fields() {
	return array(
		'hero_eyebrow' => array( __( 'Hero small label (leave empty to hide)', 'nextech-portfolio' ), 'text', '' ),
		'hero_title'   => array( __( 'Hero headline', 'nextech-portfolio' ), 'text', 'Turning Ideas Into Digital Solutions.' ),
		'hero_text'    => array(
			__( 'Hero introduction (leave a blank line between paragraphs)', 'nextech-portfolio' ),
			'textarea',
			"We are NexTech, a team of three aspiring Information Technology professionals passionate about technology, creativity, and innovation.\n\nWe transform ideas into meaningful digital solutions through collaboration, technical knowledge, and continuous learning.",
		),
		'hero_rotate'  => array(
			__( 'Hero rotating words after "We build" (separate with |, leave empty to hide)', 'nextech-portfolio' ),
			'text',
			'web systems|mobile apps|IoT solutions|reliable networks',
		),
		'about_text'   => array(
			__( 'About Us text (leave a blank line between paragraphs)', 'nextech-portfolio' ),
			'textarea',
			"NexTech is a collaborative team of three Information Technology students dedicated to exploring technology and developing innovative digital solutions. We bring together our individual knowledge, creativity, and technical skills to design and develop systems that address real-world needs.\n\nThrough teamwork, problem-solving, and continuous learning, we aim to transform ideas into functional and meaningful technological solutions.",
		),
		'mission'      => array(
			__( 'Mission', 'nextech-portfolio' ),
			'textarea',
			'To develop practical, innovative, and user-centered technological solutions while continuously improving our technical knowledge, creativity, and teamwork.',
		),
		'vision'       => array(
			__( 'Vision', 'nextech-portfolio' ),
			'textarea',
			'To become a capable and innovative team of IT professionals who contribute to technological advancement through meaningful digital solutions.',
		),
		'core_values'  => array(
			__( 'Core Values (one per line: Value|Description)', 'nextech-portfolio' ),
			'textarea',
			"Innovation|Exploring creative technological ideas.\nCollaboration|Working together to achieve shared goals.\nExcellence|Producing quality work and solutions.\nIntegrity|Practicing responsibility and honesty.\nGrowth|Continuously learning and improving.",
		),
		'skills_list'  => array(
			__( 'Our Skills (one per line: Skill|Short description)', 'nextech-portfolio' ),
			'textarea',
			"Web Development|Building responsive websites and web-based systems.\nMobile Development|Creating mobile applications for everyday needs.\nIoT|Connecting devices and sensors to build smart, data-driven solutions.\nNetworking|Designing, configuring, and maintaining computer networks.\nDatabase Management|Designing databases that keep information organized and reliable.\nUI/UX Design|Crafting clean, user-friendly interfaces and experiences.\nSystem Analysis and Design|Studying requirements and planning systems that meet real needs.\nTechnical Documentation|Writing clear system documentation and reports.",
		),
		'email'        => array( __( 'Group email address', 'nextech-portfolio' ), 'email', '' ),
		'facebook'     => array( __( 'Facebook URL', 'nextech-portfolio' ), 'url', '' ),
		'github'       => array( __( 'GitHub URL', 'nextech-portfolio' ), 'url', '' ),
		'linkedin'     => array( __( 'LinkedIn URL', 'nextech-portfolio' ), 'url', '' ),
		'footer_text'  => array( __( 'Footer text (optional)', 'nextech-portfolio' ), 'text', '' ),
	);
}

function nextech_sanitizer( $type ) {
	switch ( $type ) {
		case 'textarea':
			return 'sanitize_textarea_field';
		case 'email':
			return 'sanitize_email';
		case 'url':
			return 'esc_url_raw';
		default:
			return 'sanitize_text_field';
	}
}

function nextech_customize( $wp_customize ) {
	$wp_customize->add_section(
		'nextech_content',
		array(
			'title'       => __( 'NexTech Content', 'nextech-portfolio' ),
			'description' => __( 'Edit the text, email and social links shown on the homepage.', 'nextech-portfolio' ),
			'priority'    => 30,
		)
	);

	foreach ( nextech_content_fields() as $key => $field ) {
		$wp_customize->add_setting(
			$key,
			array(
				'default'           => $field[2],
				'sanitize_callback' => nextech_sanitizer( $field[1] ),
			)
		);
		$wp_customize->add_control(
			$key,
			array(
				'label'   => $field[0],
				'section' => 'nextech_content',
				'type'    => $field[1],
			)
		);
	}
}
add_action( 'customize_register', 'nextech_customize' );

function nextech_opt( $key ) {
	$fields  = nextech_content_fields();
	$default = isset( $fields[ $key ] ) ? $fields[ $key ][2] : '';
	return get_theme_mod( $key, $default );
}
