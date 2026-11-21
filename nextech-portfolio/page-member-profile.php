<?php
/**
 * Template Name: Member Profile
 * Description: Reusable profile page for each NexTech group member.
 *
 * @package NexTech_Portfolio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();

	$pid     = get_the_ID();
	$role    = nextech_meta( $pid, '_nt_role' );
	$links   = array(
		'GitHub'   => nextech_meta( $pid, '_nt_github' ),
		'LinkedIn' => nextech_meta( $pid, '_nt_linkedin' ),
		'Facebook' => nextech_meta( $pid, '_nt_facebook' ),
	);
	$email   = nextech_meta( $pid, '_nt_email' );
	$has_any = is_email( $email ) || array_filter( $links );

	?>

	<section class="profile-hero">
		<div class="container profile-hero-inner">
			<div class="profile-photo">
				<?php if ( has_post_thumbnail() ) : ?>
					<?php the_post_thumbnail( 'nextech-profile' ); ?>
				<?php else : ?>
					<span class="avatar-placeholder avatar-lg" aria-hidden="true"><?php echo esc_html( nextech_initials( get_the_title() ) ); ?></span>
				<?php endif; ?>
			</div>

			<div class="profile-intro">
				<a class="back-link" href="<?php echo esc_url( home_url( '/#team' ) ); ?>">← <?php esc_html_e( 'Back to Team', 'nextech-portfolio' ); ?></a>
				<h1><?php the_title(); ?></h1>
				<p class="member-role member-role-light"><?php echo esc_html( $role ? $role : __( 'Role to be added', 'nextech-portfolio' ) ); ?></p>
				<div class="profile-bio"><?php the_content(); ?></div>
			</div>
		</div>
	</section>

	<section class="section">
		<div class="container">

			<div class="section-head reveal">
				<p class="eyebrow eyebrow-dark"><?php esc_html_e( 'Skills', 'nextech-portfolio' ); ?></p>
				<h2><?php esc_html_e( 'What I work with', 'nextech-portfolio' ); ?></h2>
			</div>

			<div class="skill-layout">
				<article class="card panel skill-panel skill-panel-wide reveal">
					<h3><span class="panel-icon" aria-hidden="true">&lt;/&gt;</span><?php esc_html_e( 'Programming Languages', 'nextech-portfolio' ); ?></h3>
					<?php nextech_render_languages( nextech_meta( $pid, '_nt_languages' ) ); ?>
				</article>

				<article class="card panel skill-panel reveal">
					<h3><span class="panel-icon" aria-hidden="true">✦</span><?php esc_html_e( 'Other Technical Skills', 'nextech-portfolio' ); ?></h3>
					<?php nextech_render_skill_list( nextech_meta( $pid, '_nt_skills' ) ); ?>
				</article>

				<article class="card panel skill-panel reveal">
					<h3><span class="panel-icon" aria-hidden="true">⚙</span><?php esc_html_e( 'Technologies and Tools', 'nextech-portfolio' ); ?></h3>
					<?php nextech_render_tools( nextech_meta( $pid, '_nt_tools' ) ); ?>
				</article>

				<article class="card panel skill-panel-wide reveal">
					<h3><span class="panel-icon" aria-hidden="true">◈</span><?php esc_html_e( 'Project Contributions', 'nextech-portfolio' ); ?></h3>
					<?php nextech_render_list( nextech_meta( $pid, '_nt_contributions' ) ); ?>
				</article>

				<?php if ( $has_any ) : ?>
					<article class="card panel panel-wide reveal">
						<h3><span class="panel-icon" aria-hidden="true">✉</span><?php esc_html_e( 'Contact', 'nextech-portfolio' ); ?></h3>
						<p class="profile-links">
							<?php
							if ( is_email( $email ) ) {
								echo '<a class="social-link" href="mailto:' . esc_attr( antispambot( $email ) ) . '">' . esc_html( antispambot( $email ) ) . '</a>';
							}
							foreach ( $links as $label => $url ) {
								if ( $url ) {
									echo '<a class="social-link" href="' . esc_url( $url ) . '" target="_blank" rel="noopener noreferrer">' . esc_html( $label ) . '</a>';
								}
							}
							?>
						</p>
					</article>
				<?php endif; ?>
			</div>

			<p class="profile-back reveal">
				<a class="btn btn-primary" href="<?php echo esc_url( home_url( '/#team' ) ); ?>">← <?php esc_html_e( 'Back to Team', 'nextech-portfolio' ); ?></a>
			</p>
		</div>
	</section>

<?php
endwhile;

get_footer();
