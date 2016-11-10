<?php
/**
 * Template for displaying search forms in Twenty Sixteen
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */
?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
  <input type="search" class="search-field" placeholder="Search" value="<?php echo get_search_query(); ?>" name="s" />
  <button type="submit" class="search-submit"><span class="icon-search"></span></button>
</form>