<?php

/**
 * @package Aerotropolis Theme
 * @author  Bryan Stanley <bstanley.0811@gmail.com>
 *
 * Footer template.
 */
?>

<footer class="site-footer">
	<div class="content-wrapper">

		<nav class="footer-links">
			<?php
				wp_nav_menu( array(
					'theme_location' => 'footer_menu',
					'menu_class'     => 'footer_menu',
				 ) );
			?>
		</nav>

		<div class="footer-social">
			<?php get_search_form(); ?>

			<div class="social-links">
			<?php
				$linkedin = get_option('linkedin');
				$twitter = get_option('twitter');

				if (!empty($twitter)) {
					echo '<a class="icon-twitter" href="'. $twitter .'" title="Twitter"></a>';
				}

				if (!empty($linkedin)) {
					echo '<a class="icon-linkedin" href="'. $linkedin .'" title="LinkedIn"></a>';
				}
			?>
			</div>

			<p class="copyright">&copy <?php echo date("Y") . ' '. get_option('copyright'); ?> </p>
		</div>

	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
