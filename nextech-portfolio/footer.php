<?php
/**
 * Site footer.
 *
 * @package NexTech_Portfolio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$socials = array(
	'GitHub'   => nextech_opt( 'github' ),
	'LinkedIn' => nextech_opt( 'linkedin' ),
	'Facebook' => nextech_opt( 'facebook' ),
);
$footer_text = nextech_opt( 'footer_text' );
?>
</main>

<footer class="site-footer">
	<div class="container footer-grid">
		<div class="footer-brand reveal">
			<a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
				<span class="brand-mark" aria-hidden="true">N</span>
				<span class="brand-text">Nex<span>Tech</span> <small>IT Group</small></span>
			</a>
			<p><?php esc_html_e( 'Turning ideas into digital solutions.', 'nextech-portfolio' ); ?></p>
		</div>

		<nav class="footer-links reveal" aria-label="<?php esc_attr_e( 'Footer', 'nextech-portfolio' ); ?>">
			<h2 class="footer-title"><?php esc_html_e( 'Explore', 'nextech-portfolio' ); ?></h2>
			<ul>
				<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'nextech-portfolio' ); ?></a></li>
				<li><a href="<?php echo esc_url( home_url( '/#about' ) ); ?>"><?php esc_html_e( 'About', 'nextech-portfolio' ); ?></a></li>
				<li><a href="<?php echo esc_url( home_url( '/#team' ) ); ?>"><?php esc_html_e( 'Team', 'nextech-portfolio' ); ?></a></li>
				<li><a href="<?php echo esc_url( home_url( '/#projects' ) ); ?>"><?php esc_html_e( 'Projects', 'nextech-portfolio' ); ?></a></li>
				<li><a href="<?php echo esc_url( home_url( '/#skills' ) ); ?>"><?php esc_html_e( 'Skills', 'nextech-portfolio' ); ?></a></li>
				<li><a href="<?php echo esc_url( home_url( '/#contact' ) ); ?>"><?php esc_html_e( 'Contact', 'nextech-portfolio' ); ?></a></li>
			</ul>
		</nav>

		<div class="footer-social reveal">
			<h2 class="footer-title"><?php esc_html_e( 'Connect', 'nextech-portfolio' ); ?></h2>
			<ul>
				<?php
				$shown = false;
				foreach ( $socials as $label => $url ) {
					if ( $url ) {
						$shown = true;
						echo '<li><a href="' . esc_url( $url ) . '" target="_blank" rel="noopener noreferrer">' . esc_html( $label ) . '</a></li>';
					}
				}
				if ( ! $shown ) {
					echo '<li class="muted-on-dark">' . esc_html__( 'Social links can be added in Appearance → Customize.', 'nextech-portfolio' ) . '</li>';
				}
				?>
			</ul>
		</div>
	</div>

	<div class="container footer-bottom">
		<p>
			<?php
			if ( $footer_text ) {
				echo esc_html( $footer_text );
			} else {
				/* translators: %s: current year */
				printf( esc_html__( '© %s NexTech IT Group. All rights reserved.', 'nextech-portfolio' ), esc_html( gmdate( 'Y' ) ) );
			}
			?>
		</p>
		<a class="to-top" href="#top"><?php esc_html_e( 'Back to top ↑', 'nextech-portfolio' ); ?></a>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
