<?php
/**
 * The ONE animated background that sits behind every page, top to bottom.
 * It is fixed to the screen, so the same moving network shows behind
 * About, Team, Projects, Technologies, Contact, member profiles and project pages.
 * assets/js/animations.js draws into the canvas; assets/css/animations.css styles the layers.
 *
 * @package NexTech_Portfolio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="site-bg" aria-hidden="true">
	<canvas id="site-bg-canvas"></canvas>
	<span class="site-glow g1"></span>
	<span class="site-glow g2"></span>
</div>
