<?php
/**
 * Single project detail page.
 *
 * @package NexTech_Portfolio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();

	$pid      = get_the_ID();
	$type     = nextech_meta( $pid, '_nt_type' );
	$status   = nextech_meta( $pid, '_nt_status' );
	$users    = nextech_meta( $pid, '_nt_users' );
	$problem  = nextech_meta( $pid, '_nt_problem' );
	$features = nextech_items( nextech_meta( $pid, '_nt_features' ) );
	$category = nextech_meta( $pid, '_nt_category' );
		$client   = nextech_meta( $pid, '_nt_client' );
	$demo     = nextech_meta( $pid, '_nt_demo' );
	$repo     = nextech_meta( $pid, '_nt_repo' );
	?>

	<section class="page-hero project-hero">
		<div class="container">
			<a class="back-link" href="<?php echo esc_url( home_url( '/#projects' ) ); ?>">← <?php esc_html_e( 'Back to Projects', 'nextech-portfolio' ); ?></a>
			<h1><?php the_title(); ?></h1>
			<?php if ( $type || nextech_has_status( $status ) ) : ?>
			<p class="hero-badges">
				<?php if ( $type ) : ?>
					<span class="type-badge type-inline"><?php echo esc_html( $type ); ?></span>
				<?php endif; ?>
				<?php if ( nextech_has_status( $status ) ) : ?>
					<span class="status-badge status-inline <?php echo esc_attr( nextech_status_class( $status ) ); ?>"><?php echo esc_html( $status ); ?></span>
				<?php endif; ?>
			</p>
			<?php endif; ?>
		</div>
	</section>

	<section class="section">
		<div class="container project-detail">

			<div class="project-detail-main">
				<div class="project-hero-media reveal">
					<?php if ( has_post_thumbnail() ) : ?>
						<?php the_post_thumbnail( 'large' ); ?>
					<?php else : ?>
						<span class="media-placeholder"><?php esc_html_e( 'Project screenshot placeholder', 'nextech-portfolio' ); ?></span>
					<?php endif; ?>
				</div>

				<div class="entry-content reveal">
					<h2><?php esc_html_e( 'Overview', 'nextech-portfolio' ); ?></h2>
					<?php the_content(); ?>
				</div>

				<div class="reveal">
					<h2><?php esc_html_e( 'Problem Addressed', 'nextech-portfolio' ); ?></h2>
					<?php
					if ( $problem ) {
						echo '<p>' . esc_html( $problem ) . '</p>';
					} else {
						nextech_empty_note();
					}
					?>
				</div>

				<div>
					<h2 class="reveal"><?php esc_html_e( 'Main Features', 'nextech-portfolio' ); ?></h2>
					<?php if ( $features ) : ?>
						<ol class="feature-grid">
							<?php
								foreach ( $features as $i => $feature ) :
									$parts = nextech_split_feature( $feature );
									?>
								<li class="card feature-card tilt reveal">
										<span class="feature-num" aria-hidden="true"><?php echo esc_html( str_pad( (string) ( $i + 1 ), 2, '0', STR_PAD_LEFT ) ); ?></span>
										<span class="feature-text">
											<strong><?php echo esc_html( $parts[0] ); ?></strong>
											<?php if ( '' !== $parts[1] ) : ?>
												<span><?php echo esc_html( $parts[1] ); ?></span>
											<?php endif; ?>
										</span>
									</li>
							<?php endforeach; ?>
						</ol>
					<?php else : ?>
						<?php nextech_empty_note(); ?>
					<?php endif; ?>
				</div>
			</div>

			<aside class="project-detail-side">
				<article class="card panel reveal">
					<h3><?php esc_html_e( 'At a Glance', 'nextech-portfolio' ); ?></h3>
					<dl class="glance">
							<?php if ( $type ) : ?>
								<dt><?php esc_html_e( 'Project type', 'nextech-portfolio' ); ?></dt>
								<dd><?php echo esc_html( $type ); ?></dd>
							<?php endif; ?>
							<?php if ( $category ) : ?>
								<dt><?php esc_html_e( 'Category', 'nextech-portfolio' ); ?></dt>
								<dd><?php echo esc_html( $category ); ?></dd>
							<?php endif; ?>
							<?php if ( $client ) : ?>
								<dt><?php esc_html_e( 'Client', 'nextech-portfolio' ); ?></dt>
								<dd><?php echo esc_html( $client ); ?></dd>
							<?php endif; ?>
							<?php if ( $users ) : ?>
								<dt><?php esc_html_e( 'Target users', 'nextech-portfolio' ); ?></dt>
								<dd><?php echo esc_html( $users ); ?></dd>
							<?php endif; ?>
							<dt><?php esc_html_e( 'Main features', 'nextech-portfolio' ); ?></dt>
							<dd><?php echo esc_html( (string) count( $features ) ); ?></dd>
							<?php if ( nextech_has_status( $status ) ) : ?>
								<dt><?php esc_html_e( 'Status', 'nextech-portfolio' ); ?></dt>
								<dd><?php echo esc_html( $status ); ?></dd>
							<?php endif; ?>
						</dl>
				</article>

				<?php if ( $demo || $repo ) : ?>
					<p class="project-links">
						<?php if ( $demo ) : ?>
							<a class="btn btn-primary btn-sm" href="<?php echo esc_url( $demo ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Live demo', 'nextech-portfolio' ); ?></a>
						<?php endif; ?>
						<?php if ( $repo ) : ?>
							<a class="btn btn-outline btn-sm" href="<?php echo esc_url( $repo ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Repository', 'nextech-portfolio' ); ?></a>
						<?php endif; ?>
					</p>
				<?php endif; ?>
			</aside>
		</div>

		<?php
		$prev = get_previous_post();
		$next = get_next_post();
		if ( $prev || $next ) :
			?>
			<nav class="container project-pager" aria-label="<?php esc_attr_e( 'More projects', 'nextech-portfolio' ); ?>">
				<?php if ( $prev ) : ?>
					<a class="pager-link" href="<?php echo esc_url( get_permalink( $prev ) ); ?>">← <?php echo esc_html( get_the_title( $prev ) ); ?></a>
				<?php else : ?>
					<span></span>
				<?php endif; ?>
				<?php if ( $next ) : ?>
					<a class="pager-link pager-next" href="<?php echo esc_url( get_permalink( $next ) ); ?>"><?php echo esc_html( get_the_title( $next ) ); ?> →</a>
				<?php endif; ?>
			</nav>
		<?php endif; ?>
	</section>

<?php
endwhile;

get_footer();
