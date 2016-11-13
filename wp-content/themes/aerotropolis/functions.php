<?php

/**
 * @package Aerotropolis Theme
 * @author  Bryan Stanley <bstanley.0811@gmail.com>
 *
 * Functions.
 */


define('AERO_FOOTER_SLUG', 'meetings');
define('AERO_FOOTER_TRANSIENT', 'aero_latest_meeting');


/**
 * Helper method. Gets the proper variable based on the environment.
 */
function getEnvVar( $key ){
	// Production
	$envVars = array(
		'jsPath' => '/assets/dist'
	);

	// Local
	if (strpos($_SERVER['HTTP_HOST'], 'dev.') !== false) {
		$envVars = array(
			'jsPath' => '/assets/js/bundled'
		);
	}

	return array_key_exists( $key, $envVars ) ? $envVars[ $key ] : '';
}


/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 *
 */
function theme_setup() {
	// Let WordPress manage the document title.
	add_theme_support( 'title-tag' );

	// Register our desired menu sections
	register_nav_menus( array(
		'main_menu'							=> 'Main Menu',
		'secondary_menu'				=> 'Secondary Main Menu',
		'sticky_side_menu_home'	=> 'Sticky Side Menu - HOME',
		'sticky_side_menu_dra'	=> 'Sticky Side Menu - WHY DRA',
		'footer_menu'						=> 'Footer Menu',
		'footer_social'					=> 'Footer Social'
	));

	// Add custom image resizes
	add_image_size('aero-news-excerpt', 1000, 322, true); // roughly retina (620x200)

	// Switch default core markup to use HTML5
	add_theme_support( 'html5', array(
		'search-form'
	));

	// Enable support for Post Formats.
	// add_theme_support( 'post-formats', array(
	// 	'image',
	// 	'video',
	// 	'quote',
	// 	'link',
	// 	'gallery'
	// ) );
}
add_action( 'after_setup_theme', 'theme_setup' );



/**
 * Enqueues scripts and styles.
 */
function aerotropolis_scripts() {
	$jsPath = getEnvVar('jsPath');

	// Theme stylesheet
	wp_enqueue_style( 'aerotropolis-desktop', get_template_directory_uri() . '/assets/dist/desktop.css' );

	/**
	 * If not in the admin, don't load the outdated version of jquery that comes with WP.
	 * Our generated js script file will contain a version of jquery, which we want to
	 * always be loaded; however, to prevent plugins trying to load another version of
	 * jQuery, we're going to register our generated as jQuery. Even though the script will
	 * contain other combined JS files.  We mainly do this to prevent additional http requests.
	 */
	if (!is_admin()) {
		wp_deregister_script('jquery');
		wp_deregister_script('jquery-core');
		wp_deregister_script('jquery-migrate');
		wp_register_script('jquery', get_template_directory_uri() . $jsPath . '/desktop.js' );
		wp_enqueue_script('jquery');
	}
}
add_action( 'wp_enqueue_scripts', 'aerotropolis_scripts' );


/**
 * Registers sidebars
 */
function aero_sidebars_init() {
	register_sidebar( array(
		'name'          => 'Footer Contact Bar',
		'id'            => 'footer-contact-bar',
		'description'   => 'Appears at the bottom of the content on posts and pages.',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => 'News Side Bar',
		'id'            => 'news-side-bar',
		'description'   => 'Appears on the side of news posts.',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'aero_sidebars_init' );



function wpb_force_empty_cats($cat_args) {
	$cat_args['hide_empty'] = 0;
	return $cat_args;
}
add_filter( 'widget_categories_args', 'wpb_force_empty_cats' );


/**
 * Admin page customizations
 */

// remove unused sidebar menus
function custom_admin_menu() {
		remove_menu_page( 'edit-comments.php' );
}
add_action( 'admin_menu', 'custom_admin_menu' );

// remove the WP customizer button
function custom_admin_bar($wp_admin_bar) {
	$wp_admin_bar->remove_menu('customize');
}
add_action( 'admin_bar_menu', 'custom_admin_bar', 999 );



/**
 * Latest meeting query for footer
 */
function get_latest_meeting() {
	$cachedMeetingPost = get_transient(AERO_FOOTER_TRANSIENT);

	if (!$cachedMeetingPost) {
		$args = array(
			'posts_per_page' => 1,
			'category_name' => AERO_FOOTER_SLUG
		);
		$query = new WP_Query($args);

		while ($query->have_posts()) {
			$query->the_post();
			$meeting = array(
				"title" => get_the_title(),
				"excerpt" => get_field('footer_excerpt'),
				"permalink" => esc_url(get_permalink()),
				"date" => get_the_date('M d, Y')
			);
		}
		wp_reset_postdata();

		// save to cache
		set_transient( AERO_FOOTER_TRANSIENT, $meeting, 60*60*6 );
	}

	return $cachedMeetingPost;
}

/**
 * Latest meeting cache buster when post is created or saved
 */
add_action( 'save_post', 'save_post_function', 10, 3 );
function save_post_function( $post_ID, $post, $update ) {
	$categories = wp_get_post_categories($post_ID, array('fields' => 'all'));
	foreach ($categories as $category) {
		if ($category->slug == AERO_FOOTER_SLUG) {
			delete_transient(AERO_FOOTER_TRANSIENT);
			break;
		}
	}
}




