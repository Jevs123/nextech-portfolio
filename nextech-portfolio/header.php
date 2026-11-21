<?php
/**
 * Site header and primary navigation.
 *
 * @package NexTech_Portfolio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="theme-color" content="#0a1730">
	<script>document.documentElement.className += ' js';</script>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<?php get_template_part( 'template-parts/site-bg' ); ?>
<a class="skip-link" href="#main"><?php esc_html_e( 'Skip to content', 'nextech-portfolio' ); ?></a>

<div class="scroll-progress" id="scroll-progress" aria-hidden="true"></div>

<header class="site-header" id="site-header">
	<div class="container header-inner">

		<?php if ( has_custom_logo() ) : ?>
			<div class="brand brand-logo"><?php the_custom_logo(); ?></div>
		<?php else : ?>
			<a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php esc_attr_e( 'NexTech IT Group – home', 'nextech-portfolio' ); ?>">
				<span class="brand-mark" aria-hidden="true">N</span>
				<span class="brand-text">Nex<span>Tech</span> <small>IT Group</small></span>
			</a>
		<?php endif; ?>

		<button class="nav-toggle" id="nav-toggle" type="button" aria-expanded="false" aria-controls="primary-nav">
			<span class="screen-reader-text"><?php esc_html_e( 'Menu', 'nextech-portfolio' ); ?></span>
			<span class="nav-toggle-bar" aria-hidden="true"></span>
		</button>

		<nav class="primary-nav" id="primary-nav" aria-label="<?php esc_attr_e( 'Primary', 'nextech-portfolio' ); ?>">
			<?php $nt_active = nextech_active_nav(); ?>
			<ul class="nav-list">
				<?php foreach ( nextech_nav_items() as $nt_key => $nt_item ) : ?>
					<li>
						<a class="nav-link<?php echo $nt_key === $nt_active ? ' is-active' : ''; ?>"
							href="<?php echo esc_url( $nt_item[1] ); ?>"
							data-nav="<?php echo esc_attr( $nt_key ); ?>"
							<?php echo $nt_key === $nt_active ? 'aria-current="page"' : ''; ?>>
							<?php echo esc_html( $nt_item[0] ); ?>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
			<a class="btn btn-primary btn-sm nav-cta" href="<?php echo esc_url( home_url( '/#contact' ) ); ?>"><?php esc_html_e( 'Get in touch', 'nextech-portfolio' ); ?></a>
		</nav>
	</div>
</header>

<main id="main" class="site-main">
