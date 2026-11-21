<?php
/**
 * Homepage.
 *
 * @package NexTech_Portfolio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$email    = nextech_opt( 'email' );
$socials  = array(
	'GitHub'   => nextech_opt( 'github' ),
	'LinkedIn' => nextech_opt( 'linkedin' ),
	'Facebook' => nextech_opt( 'facebook' ),
);
$status   = isset( $_GET['contact'] ) ? sanitize_key( wp_unslash( $_GET['contact'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification
$alerts   = array(
	'sent'    => array( 'success', __( 'Thank you! Your message was sent. We will get back to you soon.', 'nextech-portfolio' ) ),
	'invalid' => array( 'error', __( 'Please check your details: name, a valid email and a message of at least 10 characters are required.', 'nextech-portfolio' ) ),
	'wait'    => array( 'error', __( 'Please wait a few seconds before sending another message.', 'nextech-portfolio' ) ),
	'error'   => array( 'error', __( 'Sorry, something went wrong and your message could not be sent. Please try again.', 'nextech-portfolio' ) ),
);

$nt_eyebrow = trim( (string) nextech_opt( 'hero_eyebrow' ) );
$nt_words   = array_values( array_filter( array_map( 'trim', explode( '|', (string) nextech_opt( 'hero_rotate' ) ) ) ) );
$nt_skills  = nextech_pairs( nextech_opt( 'skills_list' ) );
?>

<!-- HERO -->
<section class="hero" id="home" data-nav-section="home">
	<div class="container hero-inner">
		<div class="hero-copy">
			<?php if ( '' !== $nt_eyebrow ) : ?>
				<p class="eyebrow"><?php echo esc_html( $nt_eyebrow ); ?></p>
			<?php endif; ?>
			<h1><?php echo esc_html( nextech_opt( 'hero_title' ) ); ?></h1>
			<?php if ( $nt_words ) : ?>
				<p class="hero-rotator">
					<?php esc_html_e( 'We build', 'nextech-portfolio' ); ?>
					<span class="rotator" data-words="<?php echo esc_attr( wp_json_encode( $nt_words ) ); ?>"><?php echo esc_html( $nt_words[0] ); ?></span><span class="caret" aria-hidden="true"></span>
				</p>
			<?php endif; ?>
			<div class="hero-text">
				<?php nextech_paragraphs( nextech_opt( 'hero_text' ), 'lead' ); ?>
			</div>
			<div class="hero-actions">
				<a class="btn btn-primary" href="#projects"><?php esc_html_e( 'View our projects', 'nextech-portfolio' ); ?></a>
				<a class="btn btn-ghost" href="#team"><?php esc_html_e( 'Meet the team', 'nextech-portfolio' ); ?></a>
			</div>
		</div>

		<div class="hero-visual" aria-hidden="true">
			<div class="window">
				<div class="window-bar"><i></i><i></i><i></i></div>
				<div class="window-body"><span style="width:80%"></span><span style="width:95%"></span><span style="width:60%"></span><span style="width:88%"></span><span style="width:45%"></span></div>
			</div>
			<?php foreach ( array_slice( $nt_skills, 0, 4 ) as $nt_ci => $nt_chip ) : ?>
				<span class="float-chip c<?php echo (int) ( $nt_ci + 1 ); ?>"><?php echo esc_html( $nt_chip[0] ); ?></span>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- ABOUT / MISSION / VISION / VALUES -->
<section class="section" id="about" data-nav-section="about">
	<div class="container">
		<div class="section-head reveal">
			<p class="eyebrow eyebrow-dark"><?php esc_html_e( 'About Us', 'nextech-portfolio' ); ?></p>
			<h2><?php esc_html_e( 'Who We Are', 'nextech-portfolio' ); ?></h2>
		</div>

		<div class="about-grid">
			<div class="about-text reveal">
				<?php nextech_paragraphs( nextech_opt( 'about_text' ) ); ?>
			</div>
			<div class="mv-cards">
				<article class="card mv-card reveal">
					<span class="icon-badge" aria-hidden="true">◎</span>
					<h3><?php esc_html_e( 'Our Mission', 'nextech-portfolio' ); ?></h3>
					<p><?php echo esc_html( nextech_opt( 'mission' ) ); ?></p>
				</article>
				<article class="card mv-card reveal">
					<span class="icon-badge" aria-hidden="true">◇</span>
					<h3><?php esc_html_e( 'Our Vision', 'nextech-portfolio' ); ?></h3>
					<p><?php echo esc_html( nextech_opt( 'vision' ) ); ?></p>
				</article>
			</div>
		</div>

	</div>
</section>

<!-- TEAM -->
<section class="section section-soft" id="team" data-nav-section="team">
	<div class="container">
		<div class="section-head reveal">
			<p class="eyebrow eyebrow-dark"><?php esc_html_e( 'The Team', 'nextech-portfolio' ); ?></p>
			<h2><?php esc_html_e( 'Meet our three members', 'nextech-portfolio' ); ?></h2>
		</div>

		<?php $members = nextech_get_members(); ?>
		<?php if ( $members->have_posts() ) : ?>
			<div class="grid grid-3">
				<?php
				while ( $members->have_posts() ) :
					$members->the_post();
					get_template_part( 'template-parts/member-card' );
				endwhile;
				?>
			</div>
		<?php else : ?>
			<p class="empty-state">
				<?php esc_html_e( 'No members yet. In the dashboard, create three Pages and choose the "Member Profile" template for each.', 'nextech-portfolio' ); ?>
			</p>
		<?php endif; ?>
		<?php wp_reset_postdata(); ?>
	</div>
</section>

<!-- PROJECTS -->
<section class="section" id="projects" data-nav-section="projects">
	<div class="container">
		<div class="section-head reveal">
			<p class="eyebrow eyebrow-dark"><?php esc_html_e( 'Featured Projects', 'nextech-portfolio' ); ?></p>
			<h2><?php esc_html_e( 'What we are building', 'nextech-portfolio' ); ?></h2>
		</div>

		<?php $projects = nextech_get_projects( 6 ); ?>
		<?php if ( $projects->have_posts() ) : ?>
			<div class="grid <?php echo 4 === (int) $projects->post_count ? 'grid-2' : 'grid-3'; ?>">
				<?php
				while ( $projects->have_posts() ) :
					$projects->the_post();
					get_template_part( 'template-parts/project-card' );
				endwhile;
				?>
			</div>
		<?php else : ?>
			<p class="empty-state"><?php esc_html_e( 'No projects yet. Add them in the dashboard under Projects → Add New.', 'nextech-portfolio' ); ?></p>
		<?php endif; ?>
		<?php wp_reset_postdata(); ?>
	</div>
</section>

<!-- OUR SKILLS -->
<section class="section section-dark" id="skills" data-nav-section="skills">
	<div class="container">
		<div class="section-head section-head-light reveal">
			<p class="eyebrow"><?php esc_html_e( 'What We Do', 'nextech-portfolio' ); ?></p>
			<h2><?php esc_html_e( 'Our Skills', 'nextech-portfolio' ); ?></h2>
		</div>

		<?php if ( $nt_skills ) : ?>
			<ul class="skills-showcase">
				<?php foreach ( $nt_skills as $nt_skill ) : ?>
					<li class="skill-card tilt reveal">
						<span class="skill-icon"><?php echo nextech_skill_icon( $nt_skill[0] ); // phpcs:ignore WordPress.Security.EscapeOutput -- static SVG built in helpers.php ?></span>
						<h3><?php echo esc_html( $nt_skill[0] ); ?></h3>
						<?php if ( '' !== $nt_skill[1] ) : ?>
							<p><?php echo esc_html( $nt_skill[1] ); ?></p>
						<?php endif; ?>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
	</div>
</section>

<!-- CONTACT -->
<section class="section" id="contact" data-nav-section="contact">
	<div class="container">
		<div class="section-head reveal">
			<p class="eyebrow eyebrow-dark"><?php esc_html_e( 'Contact', 'nextech-portfolio' ); ?></p>
			<h2><?php esc_html_e( 'Let\'s talk', 'nextech-portfolio' ); ?></h2>
		</div>

		<div class="contact-grid">
			<div class="contact-info reveal">
				<p><?php esc_html_e( 'Have a question or a project in mind? Send us a message and we will reply as soon as we can.', 'nextech-portfolio' ); ?></p>

				<dl class="contact-list">
					<dt><?php esc_html_e( 'Email', 'nextech-portfolio' ); ?></dt>
					<dd>
						<?php if ( is_email( $email ) ) : ?>
							<a href="mailto:<?php echo esc_attr( antispambot( $email ) ); ?>"><?php echo esc_html( antispambot( $email ) ); ?></a>
						<?php else : ?>
							<span class="muted"><?php esc_html_e( 'Email to be added (Appearance → Customize → NexTech Content)', 'nextech-portfolio' ); ?></span>
						<?php endif; ?>
					</dd>

					<dt><?php esc_html_e( 'Social', 'nextech-portfolio' ); ?></dt>
					<dd>
						<?php
						$any = false;
						foreach ( $socials as $label => $url ) {
							if ( $url ) {
								$any = true;
								echo '<a class="social-link" href="' . esc_url( $url ) . '" target="_blank" rel="noopener noreferrer">' . esc_html( $label ) . '</a>';
							}
						}
						if ( ! $any ) {
							echo '<span class="muted">' . esc_html__( 'Social links to be added', 'nextech-portfolio' ) . '</span>';
						}
						?>
					</dd>
				</dl>
			</div>

			<div class="contact-form-wrap card reveal">
				<?php if ( isset( $alerts[ $status ] ) ) : ?>
					<div class="alert alert-<?php echo esc_attr( $alerts[ $status ][0] ); ?>" role="<?php echo 'success' === $alerts[ $status ][0] ? 'status' : 'alert'; ?>">
						<?php echo esc_html( $alerts[ $status ][1] ); ?>
					</div>
				<?php endif; ?>

				<form id="contact-form" class="contact-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" novalidate>
					<input type="hidden" name="action" value="nextech_contact">
					<?php wp_nonce_field( 'nextech_contact', 'nextech_contact_nonce' ); ?>

					<div class="hp-field" aria-hidden="true">
						<label for="website">Website</label>
						<input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
					</div>

					<div class="field-row">
						<div class="field">
							<label for="contact_name"><?php esc_html_e( 'Your name', 'nextech-portfolio' ); ?> <span aria-hidden="true">*</span></label>
							<input type="text" id="contact_name" name="contact_name" maxlength="100" autocomplete="name" required aria-describedby="err-name">
							<span class="field-error" id="err-name" aria-live="polite"></span>
						</div>

						<div class="field">
							<label for="contact_email"><?php esc_html_e( 'Your email', 'nextech-portfolio' ); ?> <span aria-hidden="true">*</span></label>
							<input type="email" id="contact_email" name="contact_email" autocomplete="email" required aria-describedby="err-email">
							<span class="field-error" id="err-email" aria-live="polite"></span>
						</div>
					</div>

					<div class="field">
						<label for="contact_subject"><?php esc_html_e( 'Subject', 'nextech-portfolio' ); ?></label>
						<input type="text" id="contact_subject" name="contact_subject" maxlength="150">
					</div>

					<div class="field">
						<label for="contact_message"><?php esc_html_e( 'Message', 'nextech-portfolio' ); ?> <span aria-hidden="true">*</span></label>
						<textarea id="contact_message" name="contact_message" rows="4" maxlength="3000" required aria-describedby="err-message"></textarea>
						<span class="field-error" id="err-message" aria-live="polite"></span>
					</div>

					<button class="btn btn-primary" type="submit"><?php esc_html_e( 'Send message', 'nextech-portfolio' ); ?></button>
				</form>
			</div>
		</div>
	</div>
</section>

<?php
get_footer();
