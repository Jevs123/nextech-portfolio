<?php
/**
 * NexTech Portfolio – inc/contact.php
 *
 * @package NexTech_Portfolio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* -------------------------------------------------------------------------
 * 6. Contact form handler (stores the message AND emails it)
 * ---------------------------------------------------------------------- */

function nextech_contact_redirect( $status ) {
	$base = wp_get_referer();
	$base = $base ? $base : home_url( '/' );
	$base = strtok( $base, '#' );
	$base = remove_query_arg( 'contact', $base );
	wp_safe_redirect( add_query_arg( 'contact', $status, $base ) . '#contact' );
	exit;
}

function nextech_handle_contact() {
	if ( ! isset( $_POST['nextech_contact_nonce'] ) ||
		! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nextech_contact_nonce'] ) ), 'nextech_contact' ) ) {
		nextech_contact_redirect( 'error' );
	}

	// Honeypot: real visitors never fill this hidden field.
	if ( ! empty( $_POST['website'] ) ) {
		nextech_contact_redirect( 'sent' );
	}

	$ip       = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : 'unknown';
	$throttle = 'nextech_contact_' . md5( $ip );
	if ( get_transient( $throttle ) ) {
		nextech_contact_redirect( 'wait' );
	}

	$name    = isset( $_POST['contact_name'] ) ? sanitize_text_field( wp_unslash( $_POST['contact_name'] ) ) : '';
	$email   = isset( $_POST['contact_email'] ) ? sanitize_email( wp_unslash( $_POST['contact_email'] ) ) : '';
	$subject = isset( $_POST['contact_subject'] ) ? sanitize_text_field( wp_unslash( $_POST['contact_subject'] ) ) : '';
	$message = isset( $_POST['contact_message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['contact_message'] ) ) : '';

	if ( '' === $name || mb_strlen( $name ) > 100 || ! is_email( $email ) || mb_strlen( $message ) < 10 || mb_strlen( $message ) > 3000 || mb_strlen( $subject ) > 150 ) {
		nextech_contact_redirect( 'invalid' );
	}

	$subject = '' !== $subject ? $subject : __( 'New message from the portfolio', 'nextech-portfolio' );

	// 1) Save in the dashboard so a message is never lost, even if mail is not configured.
	$saved = wp_insert_post(
		array(
			'post_type'    => 'nextech_message',
			'post_status'  => 'private',
			'post_title'   => wp_strip_all_tags( $name . ' – ' . $subject ),
			'post_content' => sprintf( "From: %s <%s>\n\n%s", $name, $email, $message ),
		),
		true
	);

	// 2) Email the group.
	$to = nextech_opt( 'email' );
	$to = is_email( $to ) ? $to : get_option( 'admin_email' );

	$headers = array(
		'Content-Type: text/plain; charset=UTF-8',
		'Reply-To: ' . str_replace( array( ',', '<', '>', '"' ), '', $name ) . ' <' . $email . '>',
	);
	$body    = sprintf( "Name: %s\nEmail: %s\n\n%s", $name, $email, $message );
	$mailed  = wp_mail( $to, '[NexTech Portfolio] ' . $subject, $body, $headers );

	if ( is_wp_error( $saved ) && ! $mailed ) {
		nextech_contact_redirect( 'error' );
	}

	set_transient( $throttle, 1, 30 );
	nextech_contact_redirect( 'sent' );
}
add_action( 'admin_post_nopriv_nextech_contact', 'nextech_handle_contact' );
add_action( 'admin_post_nextech_contact', 'nextech_handle_contact' );
