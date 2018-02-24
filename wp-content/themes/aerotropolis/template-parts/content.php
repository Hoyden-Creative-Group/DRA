<?php
/**
 * @package Aerotropolis Theme
 * @author  Bryan Stanley <bstanley.0811@gmail.com>
 *
 * Template Part: All News
 * Description: Shows all the news entry excerpts
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('post-preview'); ?>>
  <?php if(has_post_thumbnail()):?>
    <figure class="image-box"><a href="<?php echo esc_url(get_permalink(get_the_id()));?>"><?php the_post_thumbnail('aero-news-excerpt');?></a></figure>
  <?php endif;?>
  

  <?php //the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

  <?php
  $title = get_the_title();
  $categories = get_the_category();
  $separator = ' ';
  $hasCategories = false;
  $prefix = sizeof($categories) > 1 ? "Categories" : "Category";
  $output = '<p class="categories">'. $prefix .': ';
  if ( ! empty( $categories ) ) {
    $hasCategories = true;
    foreach( $categories as $category ) {
      $output .= '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '">' . esc_html( $category->name ) . '</a>' . $separator;
    }
  }
  $output .= "</p>";
  echo $hasCategories ? trim( $output, $separator ) : "";
  ?>
  
<?php echo '<h2 class="entry-title"><a href="'.get_permalink().'"><span class="title-cat">' . $categories[0]->name . ': </span>' . $title."</a></h2>"; ?>  
  

  <div class="post-meta"><?php echo get_the_date('M d, Y');?></div>

  <div class="teaser">
    <div class="excerpt"><?php the_excerpt();?></div>
    <a href="<?php echo esc_url(get_permalink(get_the_id()));?>" class="button outline blue">Read More</a>
  </div>
</article>