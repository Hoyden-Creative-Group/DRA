<?php
/**
 * @package Aerotropolis Theme
 * @author  Bryan Stanley <bstanley.0811@gmail.com>
 *
 * Template Part: Not Found
 * Description: The template part for displaying a single entry
 */
?>

<?php
	$subTitle = get_field('subtitle');
?>


<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		<?php if (!empty($subTitle)) { echo '<h6 class="entry-subtitle">'. $subTitle .'</h6>'; } ?>
	</header>

	<div class="entry-content">
		<p class="entry-date"><?php echo get_the_date('M d, Y');?></p>
		<?php the_content(); ?>
	</div>

	<footer class="entry-footer">

	</footer>
</article>
