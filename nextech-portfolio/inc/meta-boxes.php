<?php
/**
 * NexTech Portfolio – inc/meta-boxes.php
 *
 * @package NexTech_Portfolio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* -------------------------------------------------------------------------
 * 4. Meta boxes (member profile details, project details)
 * ---------------------------------------------------------------------- */

function nextech_member_fields() {
	return array(
		'_nt_role'          => array( 'label' => 'Position / role', 'type' => 'text' ),
		'_nt_languages'     => array( 'label' => 'Programming languages with a level, one per line as: Name|level (0-100), e.g. PHP|85', 'type' => 'textarea' ),
		'_nt_skills'        => array( 'label' => 'Other technical skills (one per line)', 'type' => 'textarea' ),
		'_nt_tools'         => array( 'label' => 'Technologies and tools (one per line; the logo is picked from the name)', 'type' => 'textarea' ),
		'_nt_contributions' => array( 'label' => 'Project contributions (one per line)', 'type' => 'textarea' ),
		'_nt_email'         => array( 'label' => 'Email (optional)', 'type' => 'email' ),
		'_nt_github'        => array( 'label' => 'GitHub URL (optional)', 'type' => 'url' ),
		'_nt_linkedin'      => array( 'label' => 'LinkedIn URL (optional)', 'type' => 'url' ),
		'_nt_facebook'      => array( 'label' => 'Facebook URL (optional)', 'type' => 'url' ),
	);
}

function nextech_project_fields() {
	return array(
		'_nt_type'     => array( 'label' => 'Project type (optional, e.g. Capstone Project)', 'type' => 'text' ),
		'_nt_category' => array( 'label' => 'Category (e.g. Hospitality Management System)', 'type' => 'text' ),
		'_nt_client'   => array( 'label' => 'Client / made for (optional)', 'type' => 'text' ),
		'_nt_users'    => array( 'label' => 'Target users (e.g. hotel personnel)', 'type' => 'text' ),
		'_nt_status'   => array(
			'label'   => 'Project status (hidden on the site while "To be confirmed")',
			'type'    => 'select',
			'options' => array( 'To be confirmed', 'Planned', 'In Progress', 'Completed' ),
		),
		'_nt_problem'  => array( 'label' => 'Problem addressed', 'type' => 'textarea' ),
		'_nt_features' => array( 'label' => 'Main features, one per line as: Feature name – short description', 'type' => 'textarea' ),
		'_nt_demo'     => array( 'label' => 'Live demo URL (optional)', 'type' => 'url' ),
		'_nt_repo'     => array( 'label' => 'Repository URL (optional)', 'type' => 'url' ),
	);
}

function nextech_render_fields( $post, $fields, $nonce ) {
	wp_nonce_field( $nonce, $nonce . '_field' );

	foreach ( $fields as $key => $f ) {
		$val = get_post_meta( $post->ID, $key, true );
		echo '<p><label for="' . esc_attr( $key ) . '"><strong>' . esc_html( $f['label'] ) . '</strong></label><br>';

		if ( 'textarea' === $f['type'] ) {
			echo '<textarea class="widefat" rows="4" id="' . esc_attr( $key ) . '" name="' . esc_attr( $key ) . '">' . esc_textarea( $val ) . '</textarea>';
		} elseif ( 'select' === $f['type'] ) {
			echo '<select id="' . esc_attr( $key ) . '" name="' . esc_attr( $key ) . '">';
			foreach ( $f['options'] as $opt ) {
				echo '<option value="' . esc_attr( $opt ) . '"' . selected( $val, $opt, false ) . '>' . esc_html( $opt ) . '</option>';
			}
			echo '</select>';
		} else {
			echo '<input class="widefat" type="' . esc_attr( $f['type'] ) . '" id="' . esc_attr( $key ) . '" name="' . esc_attr( $key ) . '" value="' . esc_attr( $val ) . '">';
		}
		echo '</p>';
	}
}

function nextech_save_fields( $post_id, $fields, $nonce ) {
	if ( ! isset( $_POST[ $nonce . '_field' ] ) ) {
		return;
	}
	if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST[ $nonce . '_field' ] ) ), $nonce ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	foreach ( $fields as $key => $f ) {
		$raw = isset( $_POST[ $key ] ) ? wp_unslash( $_POST[ $key ] ) : '';
		$raw = is_string( $raw ) ? $raw : '';

		switch ( $f['type'] ) {
			case 'textarea':
				$clean = sanitize_textarea_field( $raw );
				break;
			case 'email':
				$clean = sanitize_email( $raw );
				break;
			case 'url':
				$clean = esc_url_raw( $raw );
				break;
			case 'select':
				$clean = in_array( $raw, $f['options'], true ) ? $raw : $f['options'][0];
				break;
			default:
				$clean = sanitize_text_field( $raw );
		}

		update_post_meta( $post_id, $key, $clean );
	}
}

function nextech_add_meta_boxes() {
	add_meta_box(
		'nextech_member',
		__( 'Member Profile Details', 'nextech-portfolio' ),
		function ( $post ) {
			echo '<p class="description">' . esc_html__( 'Use the "Member Profile" page template. Profile picture = Featured image. Personal introduction = main editor. Short card intro = Excerpt.', 'nextech-portfolio' ) . '</p>';
			nextech_render_fields( $post, nextech_member_fields(), 'nextech_member_nonce' );
		},
		'page',
		'normal',
		'high'
	);

	add_meta_box(
		'nextech_project',
		__( 'Project Details', 'nextech-portfolio' ),
		function ( $post ) {
			nextech_render_fields( $post, nextech_project_fields(), 'nextech_project_nonce' );
		},
		'nextech_project',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'nextech_add_meta_boxes' );

add_action(
	'save_post_page',
	function ( $post_id ) {
		nextech_save_fields( $post_id, nextech_member_fields(), 'nextech_member_nonce' );
	}
);

add_action(
	'save_post_nextech_project',
	function ( $post_id ) {
		nextech_save_fields( $post_id, nextech_project_fields(), 'nextech_project_nonce' );
	}
);
