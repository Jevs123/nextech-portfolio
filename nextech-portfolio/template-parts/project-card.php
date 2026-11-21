<?php
/**
 * Project card used on the homepage (inside a WP_Query loop).
 *
 * @package NexTech_Portfolio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$nt_id       = get_the_ID();
$nt_status   = nextech_meta( $nt_id, '_nt_status' );
$nt_type     = nextech_meta( $nt_id, '_nt_type' );
$nt_features = array_slice( nextech_items( nextech_meta( $nt_id, '_nt_features' ) ), 0, 3 );
?>
<article class="card project-card tilt reveal">
	<?php $nt_bg = has_post_thumbnail() ? get_the_post_thumbnail_url( null, 'medium' ) : ''; ?>
	<a class="project-media"<?php echo $nt_bg ? ' style="--media-bg:url(\'' . esc_url( $nt_bg ) . '\')"' : ''; ?> href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
		<?php if ( has_post_thumbnail() ) : ?>
			<?php the_post_thumbnail( 'large', array( 'loading' => 'lazy' ) ); ?>
		<?php else : ?>
			<span class="media-placeholder"><?php esc_html_e( 'Project screenshot placeholder', 'nextech-portfolio' ); ?></span>
		<?php endif; ?>
		<?php if ( nextech_has_status( $nt_status ) ) : ?>
			<span class="status-badge <?php echo esc_attr( nextech_status_class( $nt_status ) ); ?>"><?php echo esc_html( $nt_status ); ?></span>
		<?php endif; ?>
		<?php if ( $nt_type ) : ?>
			<span class="type-badge"><?php echo esc_html( $nt_type ); ?></span>
		<?php endif; ?>
		<span class="media-cta"><?php esc_html_e( 'View details →', 'nextech-portfolio' ); ?></span>
	</a>
	<div class="project-body">
		<h3><?php the_title(); ?></h3>
		<p><?php echo esc_html( wp_trim_words( wp_strip_all_tags( get_the_excerpt() ), 28 ) ); ?></p>

		<?php if ( $nt_features ) : ?>
			<ul class="check-list check-list-sm">
				<?php foreach ( $nt_features as $nt_feature ) : ?>
					<?php $nt_parts = nextech_split_feature( $nt_feature ); ?>
					<li><?php echo esc_html( $nt_parts[0] ); ?></li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>

		<a class="btn btn-outline btn-sm" href="<?php the_permalink(); ?>">
			<?php esc_html_e( 'View Details', 'nextech-portfolio' ); ?>
			<span class="screen-reader-text"> <?php echo esc_html( get_the_title() ); ?></span>
		</a>
	</div>
</article>
