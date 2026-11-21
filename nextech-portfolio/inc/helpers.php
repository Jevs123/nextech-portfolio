<?php
/**
 * NexTech Portfolio – inc/helpers.php
 *
 * @package NexTech_Portfolio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* -------------------------------------------------------------------------
 * 5. Helpers used by templates
 * ---------------------------------------------------------------------- */

function nextech_meta( $post_id, $key ) {
	return get_post_meta( $post_id, $key, true );
}

function nextech_items( $text, $split_commas = false ) {
	$pattern = $split_commas ? '/[\r\n,]+/' : '/\r\n|\r|\n/';
	$items   = preg_split( $pattern, (string) $text );
	return array_values( array_filter( array_map( 'trim', $items ), 'strlen' ) );
}

function nextech_initials( $text ) {
	// Ignore anything in brackets, e.g. "Member 1 (Placeholder)" -> "Member 1".
	$text  = preg_replace( '/[\(\[].*?[\)\]]/u', '', wp_strip_all_tags( $text ) );
	$words = preg_split( '/[^\p{L}\p{N}]+/u', trim( $text ), -1, PREG_SPLIT_NO_EMPTY );

	if ( empty( $words ) ) {
		return 'NT';
	}
	if ( count( $words ) > 1 ) {
		$out = '';
		foreach ( array_slice( $words, 0, 3 ) as $w ) {
			$out .= mb_strtoupper( mb_substr( $w, 0, 1 ) );
		}
		return $out;
	}
	return mb_strtoupper( mb_substr( $words[0], 0, 2 ) );
}

function nextech_empty_note() {
	echo '<p class="muted">' . esc_html__( 'Information to be added.', 'nextech-portfolio' ) . '</p>';
}

function nextech_render_list( $text ) {
	$items = nextech_items( $text );
	if ( ! $items ) {
		nextech_empty_note();
		return;
	}
	echo '<ul class="check-list">';
	foreach ( $items as $item ) {
		echo '<li>' . esc_html( $item ) . '</li>';
	}
	echo '</ul>';
}

function nextech_render_chips( $text ) {
	$items = nextech_items( $text, true );
	if ( ! $items ) {
		nextech_empty_note();
		return;
	}
	echo '<ul class="chips">';
	foreach ( $items as $item ) {
		echo '<li class="chip">' . esc_html( $item ) . '</li>';
	}
	echo '</ul>';
}

function nextech_status_class( $status ) {
	return 'status-' . sanitize_html_class( strtolower( str_replace( ' ', '-', (string) $status ) ) );
}

/** The three member pages (pages that use the Member Profile template). */
function nextech_get_members() {
	return new WP_Query(
		array(
			'post_type'      => 'page',
			'post_status'    => 'publish',
			'posts_per_page' => 3,
			'meta_key'       => '_wp_page_template',
			'meta_value'     => NEXTECH_MEMBER_TEMPLATE,
			'orderby'        => array(
				'menu_order' => 'ASC',
				'title'      => 'ASC',
			),
			'no_found_rows'  => true,
		)
	);
}

function nextech_get_projects( $limit = 6 ) {
	return new WP_Query(
		array(
			'post_type'      => 'nextech_project',
			'post_status'    => 'publish',
			'posts_per_page' => $limit,
			'orderby'        => array(
				'menu_order' => 'ASC',
				'date'       => 'DESC',
			),
			'no_found_rows'  => true,
		)
	);
}

/* ---- Skills (tags or bars) ------------------------------------------- */

/** Turns "Python|85" lines into array( array( 'name' => 'Python', 'level' => 85 ), ... ). */
function nextech_parse_skills( $text ) {
	$out = array();
	foreach ( nextech_items( $text, true ) as $item ) {
		$bits  = array_map( 'trim', explode( '|', $item, 2 ) );
		$level = null;
		if ( isset( $bits[1] ) && is_numeric( $bits[1] ) ) {
			$level = max( 0, min( 100, (int) $bits[1] ) );
		}
		if ( '' !== $bits[0] ) {
			$out[] = array(
				'name'  => $bits[0],
				'level' => $level,
			);
		}
	}
	return $out;
}

/** Shows skills with a level as animated bars, and the rest as tags. */
function nextech_render_skills( $text ) {
	$skills = nextech_parse_skills( $text );
	if ( ! $skills ) {
		nextech_empty_note();
		return;
	}

	$bars = array();
	$tags = array();
	foreach ( $skills as $skill ) {
		if ( null === $skill['level'] ) {
			$tags[] = $skill;
		} else {
			$bars[] = $skill;
		}
	}

	if ( $bars ) {
		echo '<ul class="skill-bars">';
		foreach ( $bars as $skill ) {
			echo '<li class="skill-row">';
			echo '<span class="skill-label"><span>' . esc_html( $skill['name'] ) . '</span><span class="skill-pct">' . (int) $skill['level'] . '%</span></span>';
			echo '<span class="skill-track" role="img" aria-label="' . esc_attr( $skill['name'] . ' ' . $skill['level'] . '%' ) . '"><span class="skill-fill" style="--lvl:' . (int) $skill['level'] . '%"></span></span>';
			echo '</li>';
		}
		echo '</ul>';
	}

	if ( $tags ) {
		echo '<ul class="chips">';
		foreach ( $tags as $skill ) {
			echo '<li class="chip">' . esc_html( $skill['name'] ) . '</li>';
		}
		echo '</ul>';
	}
}

/** A few skill names for the small tags on the homepage member card. */
function nextech_top_skills( $post_id, $limit = 3 ) {
	$names = array();
	foreach ( array( '_nt_skills', '_nt_languages', '_nt_tools' ) as $key ) {
		foreach ( nextech_parse_skills( nextech_meta( $post_id, $key ) ) as $skill ) {
			$names[] = $skill['name'];
		}
	}
	return array_slice( $names, 0, $limit );
}

/** Number of skills listed in the Customizer. */
function nextech_skill_count() {
	return count( nextech_pairs( nextech_opt( 'skills_list' ) ) );
}

/* ---- Global navigation ------------------------------------------------ */

/**
 * The single source of truth for the main navigation.
 * Home always uses home_url(), so it works from any nested page.
 */
function nextech_nav_items() {
	$items = array(
		'home'     => array( __( 'Home', 'nextech-portfolio' ), home_url( '/' ) ),
		'about'    => array( __( 'About', 'nextech-portfolio' ), home_url( '/#about' ) ),
		'team'     => array( __( 'Team', 'nextech-portfolio' ), home_url( '/#team' ) ),
		'projects' => array( __( 'Projects', 'nextech-portfolio' ), home_url( '/#projects' ) ),
		'skills'   => array( __( 'Skills', 'nextech-portfolio' ), home_url( '/#skills' ) ),
		'contact'  => array( __( 'Contact', 'nextech-portfolio' ), home_url( '/#contact' ) ),
	);
	return apply_filters( 'nextech_nav_items', $items );
}

/**
 * Which nav item is active for the page being rendered.
 * On the homepage this is only the starting state; scroll tracking (main.js) takes over.
 */
function nextech_active_nav() {
	if ( is_front_page() ) {
		return 'home';
	}
	if ( is_singular( 'nextech_project' ) ) {
		return 'projects';
	}
	if ( is_page_template( NEXTECH_MEMBER_TEMPLATE ) ) {
		return 'team';
	}
	foreach ( array( 'about', 'team', 'projects', 'skills', 'contact' ) as $slug ) {
		if ( is_page( $slug ) ) {
			return $slug;
		}
	}
	return '';
}

/* ---- Text helpers for the editable content ---------------------------- */

/** Prints each blank-line separated paragraph as its own <p>. */
function nextech_paragraphs( $text, $class = '' ) {
	$parts = preg_split( '/\R{2,}/', trim( (string) $text ) );
	foreach ( $parts as $part ) {
		$part = trim( $part );
		if ( '' !== $part ) {
			echo '<p' . ( $class ? ' class="' . esc_attr( $class ) . '"' : '' ) . '>' . esc_html( preg_replace( '/\s*\R\s*/', ' ', $part ) ) . '</p>';
		}
	}
}

/** Lines such as "Name|Description" become array( array( 'Name', 'Description' ), ... ). */
function nextech_pairs( $text ) {
	$out = array();
	foreach ( nextech_items( $text ) as $line ) {
		$bits = array_map( 'trim', explode( '|', $line, 2 ) );
		if ( '' !== $bits[0] ) {
			$out[] = array( $bits[0], isset( $bits[1] ) ? $bits[1] : '' );
		}
	}
	return $out;
}

/** "Feature name – description" (en dash, hyphen or |) becomes array( name, description ). */
function nextech_split_feature( $line ) {
	$bits = preg_split( '/\s+[–—-]\s+|\s*\|\s*/u', trim( $line ), 2 );
	return array( trim( $bits[0] ), isset( $bits[1] ) ? trim( $bits[1] ) : '' );
}

/** A simple line icon chosen from the skill's name. */
function nextech_skill_icon( $title ) {
	$icons = array(
		'code'     => '<polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/>',
		'phone'    => '<rect x="7" y="2" width="10" height="20" rx="2"/><line x1="11" y1="18" x2="13" y2="18"/>',
		'chip'     => '<rect x="6" y="6" width="12" height="12" rx="2"/><rect x="9.5" y="9.5" width="5" height="5"/><path d="M9 2v4M15 2v4M9 18v4M15 18v4M2 9h4M2 15h4M18 9h4M18 15h4"/>',
		'network'  => '<circle cx="12" cy="5" r="2.5"/><circle cx="5" cy="19" r="2.5"/><circle cx="19" cy="19" r="2.5"/><path d="M12 7.5v4M12 11.5l-5.5 5.5M12 11.5l5.5 5.5"/>',
		'database' => '<ellipse cx="12" cy="5" rx="8" ry="3"/><path d="M4 5v6c0 1.7 3.6 3 8 3s8-1.3 8-3V5M4 11v6c0 1.7 3.6 3 8 3s8-1.3 8-3v-6"/>',
		'layout'   => '<rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/>',
		'flow'     => '<rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/><path d="M10 6.5h4a3 3 0 0 1 3 3V14"/>',
		'doc'      => '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6M8 13h8M8 17h8"/>',
		'star'     => '<polygon points="12 2 15 9 22 9.5 16.5 14 18 21 12 17.5 6 21 7.5 14 2 9.5 9 9"/>',
	);
	$map = array(
		'web' => 'code', 'mobile' => 'phone', 'iot' => 'chip', 'internet of things' => 'chip', 'network' => 'network',
		'database' => 'database', 'analysis' => 'flow', 'ui' => 'layout', 'ux' => 'layout', 'design' => 'layout', 'doc' => 'doc',
	);
	$key = 'star';
	foreach ( $map as $word => $icon ) {
		if ( false !== stripos( $title, $word ) ) {
			$key = $icon;
			break;
		}
	}
	return '<svg class="skill-svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">' . $icons[ $key ] . '</svg>';
}

/** True when a project has a real status (not the "To be confirmed" placeholder). */
function nextech_has_status( $status ) {
	return '' !== (string) $status && 'To be confirmed' !== $status;
}

/* ---- Member profile: languages, skills and tools ----------------------- */

/** URL of the bundled logo for a language or tool (falls back to a neutral icon). */
function nextech_logo_url( $name ) {
	$n   = strtolower( $name );
	$map = array(
		'phpmyadmin' => 'tool', 'microsoft project' => 'microsoft-project', 'javascript' => 'javascript',
		'html' => 'html', 'css' => 'css', 'java' => 'java', 'php' => 'php', 'python' => 'python',
		'github' => 'github', 'visual studio' => 'vscode', 'vs code' => 'vscode', 'vscode' => 'vscode',
		'xampp' => 'xampp', 'xammp' => 'xampp', 'google drive' => 'google-drive', 'google docs' => 'google-docs',
		'hostinger' => 'hostinger', 'railway' => 'railway', 'deepseek' => 'deepseek', 'zotero' => 'zotero',
		'draw.io' => 'drawio', 'drawio' => 'drawio', 'lucid' => 'lucidchart', 'visio' => 'microsoft-visio',
		'word' => 'microsoft-word', 'excel' => 'microsoft-excel', 'trello' => 'trello', 'notion' => 'notion',
		'uml' => 'diagram', 'dfd' => 'diagram', 'use case' => 'diagram', 'flowchart' => 'diagram',
	);
	$file = 'tool';
	foreach ( $map as $word => $icon ) {
		if ( false !== strpos( $n, $word ) ) {
			$file = $icon;
			break;
		}
	}
	return get_template_directory_uri() . '/assets/icons/' . $file . '.svg';
}

/** Programming languages: logo, name and an animated level bar ("PHP|85"). */
function nextech_render_languages( $text ) {
	$skills = nextech_parse_skills( $text );
	if ( ! $skills ) {
		nextech_empty_note();
		return;
	}
	echo '<ul class="lang-grid">';
	foreach ( $skills as $skill ) {
		$level = null === $skill['level'] ? 0 : (int) $skill['level'];
		echo '<li class="lang-row">';
		echo '<span class="logo-tile"><img src="' . esc_url( nextech_logo_url( $skill['name'] ) ) . '" alt="" width="28" height="28" loading="lazy"></span>';
		echo '<span class="lang-main"><span class="skill-label"><span>' . esc_html( $skill['name'] ) . '</span>';
		if ( $level ) {
			echo '<span class="skill-pct">' . $level . '%</span>';
		}
		echo '</span>';
		if ( $level ) {
			echo '<span class="skill-track" role="img" aria-label="' . esc_attr( $skill['name'] . ' ' . $level . '%' ) . '"><span class="skill-fill" style="--lvl:' . $level . '%"></span></span>';
		}
		echo '</span></li>';
	}
	echo '</ul>';
}

/** Tools: a neat grid of logo tiles with the tool name underneath. */
function nextech_render_tools( $text ) {
	$items = nextech_items( $text );
	if ( ! $items ) {
		nextech_empty_note();
		return;
	}
	echo '<ul class="tool-grid">';
	foreach ( $items as $item ) {
		echo '<li class="tool-item"><span class="logo-tile logo-tile-lg"><img src="' . esc_url( nextech_logo_url( $item ) ) . '" alt="" width="34" height="34" loading="lazy"></span><span class="tool-name">' . esc_html( $item ) . '</span></li>';
	}
	echo '</ul>';
}

/** Other technical skills: an even two-column list with check marks. */
function nextech_render_skill_list( $text ) {
	$items = nextech_items( $text );
	if ( ! $items ) {
		nextech_empty_note();
		return;
	}
	echo '<ul class="skill-list">';
	foreach ( $items as $item ) {
		echo '<li>' . esc_html( $item ) . '</li>';
	}
	echo '</ul>';
}
