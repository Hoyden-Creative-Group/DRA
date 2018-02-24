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
					'theme_location' => 'footer_menu_1',
					'menu_class'     => 'footer_menu',
				 ) );
			?>
			<?php
				wp_nav_menu( array(
					'theme_location' => 'footer_menu_2',
					'menu_class'     => 'footer_menu',
				 ) );
			?>
		</nav>

		<div class="footer-social">
			<?php get_search_form(); ?>

			<div class="social-links">
			<?php
				$linkedin = get_option('linkedin');
				$twitter = 'https://twitter.com/'. preg_replace("/^@/", "", get_option('twitter'));

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

		<div class="footer-latest-news">
			<?php $latestMeetingInfo = get_latest_meeting(); ?>
			<p class="title">
				<a href="<?php echo $latestMeetingInfo['permalink']; ?>"><?php echo $latestMeetingInfo['title']; ?></a>
			</p>
			<p class="date"><?php echo $latestMeetingInfo['date']; ?></p>
			<p class="excerpt"><?php echo $latestMeetingInfo['excerpt']; ?></p>
			<a class="button outline white" href="<?php echo $latestMeetingInfo['permalink']; ?>">Read More</a>
		</div>

	</div>
</footer>

<?php wp_footer(); ?>

<script>
(function($) {
$(document).ready(function() {
$('.menu-item-has-children a, .mobile .sf-menu .menu-item-has-children::after').not(".sub-menu a").on("click", function (e) {
e.preventDefault();
});         
});
}) (jQuery);
</script>

<style>
.sf-menu a { font:16px/16px latoheavy; }
.sf-menu li.menu-item-has-children a, .mobile .sf-menu .menu-item-has-children::after { cursor: none; }
.mobile .sf-menu li.menu-item-has-children a { cursor: pointer; }
	.sf-menu li.menu-item-has-children .sub-menu li a { cursor:pointer; }
</style>

</body>

</html>