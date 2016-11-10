<?php

/**
 * @package Aerotropolis Theme
 * @author  Bryan Stanley <bstanley.0811@gmail.com>
 */


/**
 * Gets the proper variable based on the environment.
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
	) );

	// Switch default core markup to use HTML5
	add_theme_support( 'html5', array(
		'search-form'
	) );
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
		'name'          => __( 'Sidebar', 'twentysixteen' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Add widgets here to appear in your sidebar.', 'twentysixteen' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => __( 'Content Bottom 1', 'twentysixteen' ),
		'id'            => 'sidebar-2',
		'description'   => __( 'Appears at the bottom of the content on posts and pages.', 'twentysixteen' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => __( 'Content Bottom 2', 'twentysixteen' ),
		'id'            => 'sidebar-3',
		'description'   => __( 'Appears at the bottom of the content on posts and pages.', 'twentysixteen' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );


	register_sidebar( array(
		'name'          => 'Footer Contact Bar',
		'id'            => 'footer-contact-bar',
		'description'   => 'Appears at the bottom of the content on posts and pages.',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'aero_sidebars_init' );

