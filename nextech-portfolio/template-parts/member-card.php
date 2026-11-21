<?php
/**
 * Member card used on the homepage (inside a WP_Query loop).
 *
 * @package NexTech_Portfolio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$nt_id     = get_the_ID();
$nt_role   = nextech_meta( $nt_id, '_nt_role' );
$nt_intro  = has_excerpt() ? get_the_excerpt() : wp_trim_words( wp_strip_all_tags( get_the_content() ), 24 );
$nt_skills = nextech_top_skills( $nt_id, 3 );
?>
<article class="card member-card tilt reveal">
	<div class="member-photo">
		<?php if ( has_post_thumbnail() ) : ?>
			<?php the_post_thumbnail( 'nextech-profile', array( 'loading' => 'lazy' ) ); ?>
		<?php else : ?>
			<span class="avatar-placeholder" aria-hidden="true"><?php echo esc_html( nextech_initials( get_the_title() ) ); ?></span>
		<?php endif; ?>
	</div>
	<div class="member-body">
		<h3><?php the_title(); ?></h3>
		<p class="member-role"><?php echo esc_html( $nt_role ? $nt_role : __( 'Role to be added', 'nextech-portfolio' ) ); ?></p>
		<p><?php echo esc_html( $nt_intro ); ?></p>
		<?php if ( $nt_skills ) : ?>
			<ul class="chips chips-sm">
				<?php foreach ( $nt_skills as $nt_skill ) : ?>
					<li class="chip"><?php echo esc_html( $nt_skill ); ?></li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
		<a class="btn btn-outline btn-sm" href="<?php the_permalink(); ?>">
			<?php esc_html_e( 'View Profile', 'nextech-portfolio' ); ?>
			<span class="screen-reader-text"> <?php echo esc_html( get_the_title() ); ?></span>
		</a>
	</div>
</article>
