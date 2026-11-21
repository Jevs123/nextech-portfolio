<?php
/**
 * Fallback template (blog, archives, search, 404 and plain pages).
 *
 * @package NexTech_Portfolio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<section class="page-hero">
	<div class="container">
		<h1>
			<?php
			if ( is_search() ) {
				/* translators: %s: search query */
				printf( esc_html__( 'Search results for "%s"', 'nextech-portfolio' ), esc_html( get_search_query() ) );
			} elseif ( is_404() ) {
				esc_html_e( 'Page not found', 'nextech-portfolio' );
			} elseif ( is_singular() ) {
				single_post_title();
			} elseif ( is_archive() ) {
				the_archive_title();
			} else {
				esc_html_e( 'Latest updates', 'nextech-portfolio' );
			}
			?>
		</h1>
	</div>
</section>

<section class="section">
	<div class="container narrow">
		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry reveal' ); ?>>
					<?php if ( ! is_singular() ) : ?>
						<h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<div class="entry-content"><?php the_excerpt(); ?></div>
						<a class="btn btn-outline btn-sm" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Read more', 'nextech-portfolio' ); ?></a>
					<?php else : ?>
						<div class="entry-content"><?php the_content(); ?></div>
					<?php endif; ?>
				</article>
			<?php endwhile; ?>

			<?php the_posts_pagination(); ?>
		<?php else : ?>
			<p class="reveal"><?php esc_html_e( 'Nothing was found here.', 'nextech-portfolio' ); ?></p>
			<a class="btn btn-primary" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Back to home', 'nextech-portfolio' ); ?></a>
		<?php endif; ?>
	</div>
</section>

<?php
get_footer();
