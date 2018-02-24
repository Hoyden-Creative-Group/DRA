<?php

/**
 * @package Aerotropolis Theme
 * @author  Bryan Stanley <bstanley.0811@gmail.com>
 *
 * Functions.
 */

define('AERO_FOOTER_SLUG', 'meetings');
define('AERO_FOOTER_TRANSIENT', 'aero_latest_meeting');
define('AERO_TESTIMONIALS_SLUG', 'testimonials');
define('AERO_TESTIMONIALS_TRANSIENT', 'aero_testimonials');
// NOTE: CACHE_BUSTER is defined in env.php on the root

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
		'main_menu'                       => 'Main Menu',
		'secondary_menu'                  => 'Secondary Main Menu',
		'sticky_side_menu_home'           => 'Sticky Side Menu - HOME',
		'sticky_side_menu_dra'            => 'Sticky Side Menu - WHY DRA',
		'sticky_side_menu_about'          => 'Sticky Side Menu - ABOUT',
		'sticky_side_menu_site_selection' => 'Sticky Side Menu - SITE SELECTION',
		'sticky_side_menu_industries'     => 'Sticky Side Menu - INDUSTRIES',
		'footer_menu_1'                   => 'Footer Menu 1',
		'footer_menu_2'                   => 'Footer Menu 2',
		'footer_social'                   => 'Footer Social'
	));

	// Add custom image resizes
	add_image_size('aero-news-excerpt', 1000, 322, true); // roughly retina (620x200)

	// Switch default core markup to use HTML5
	add_theme_support( 'html5', array(
		'search-form'
	));
}
add_action( 'after_setup_theme', 'theme_setup' );


/**
 * Send HTML emails
 */
add_filter( 'wp_mail_content_type', 'set_content_type' );
function set_content_type( $content_type ){
	return 'text/html';
}


/**
 * Remove ellipsis from blog posts
 */
add_filter('excerpt_more','__return_false');


/**
 * Enqueues scripts and styles.
 */
function aerotropolis_scripts() {
	$jsPath = getEnvVar('jsPath');

	// Theme stylesheet
	wp_enqueue_style( 'aerotropolis-desktop', get_template_directory_uri() . '/assets/dist/desktop.css', array(), CACHE_BUSTER);

	wp_register_script( 'aero_testimonials', get_template_directory_uri() . '/assets/js/vc_extend/testimonialsSlideshow.js', array('jquery'), CACHE_BUSTER, false );

	if (!is_admin()) {
		wp_register_script('aerotropolis', get_template_directory_uri() . $jsPath . '/desktop.js', array('jquery'), CACHE_BUSTER);
		wp_enqueue_script('aerotropolis');

		// add recaptcha to contact page
		if (is_page('contact')) {
			wp_register_script('aero_recaptcha', 'https://www.google.com/recaptcha/api.js');
			wp_enqueue_script('aero_recaptcha');
		}
	}
}
add_action('wp_enqueue_scripts', 'aerotropolis_scripts');


/**
 * A one time function to list out all script handles the current theme is using.
 * NOT FOR PRODUCTION USE
 */

/*
function aero_detect_enqueued_scripts() {
	global $wp_scripts;
	foreach( $wp_scripts->queue as $handle ) :
		echo $handle . ' | ';
	endforeach;
}
add_action( 'wp_print_scripts', 'aero_detect_enqueued_scripts' );
*/

/**
 * Appends async to declared scripts
 */
function aero_async_scripts($tag, $handle, $src) {
	$async_scripts = array(
		'aerotropolis',
		'popup-maker-site',
		'aero_recaptcha'
	);

	if ( in_array( $handle, $async_scripts ) ) {
		return '<script src="' . $src . '" async></script>' . "\n";
	}

	return $tag;
}
add_filter('script_loader_tag', 'aero_async_scripts', 10, 3);


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


/**
 * Utility function to get attachment metadata
 */
function wp_get_attachment( $attachment_id ) {
	$attachment = get_post( $attachment_id );
	return array(
		'alt' => get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
		'caption' => $attachment->post_excerpt,
		'description' => $attachment->post_content,
		'href' => get_permalink( $attachment->ID ),
		'src' => $attachment->guid,
		'title' => $attachment->post_title
	);
}


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
 * Testimonials query for home page slider
 */
function get_testimonials($numberToShow, $category) {
	$cachedTestimonials = get_transient(AERO_TESTIMONIALS_TRANSIENT);

	if (!$cachedTestimonials) {
		// defaults
		$testimonials = array();
		$expires = 60*60*1;

		// query for the testimonials
		$args = array(
			'post_type' => 'testimonials',
			'showposts' => $numberToShow,
			'orderby' => 'rand',
			'testimonial-categories' => $category
		);
		$query = new WP_Query($args);

		while ($query->have_posts()) {
			$query->the_post();

			array_push(
				$testimonials,
				array(
					"testimonial" => get_the_content(),
					"author" => get_field('author')
				)
			);

			// reset the expires to be further out
			$expires = 60*60*6;
		}
		wp_reset_postdata();

		// save to cache
		set_transient( AERO_TESTIMONIALS_TRANSIENT, $testimonials, $expires );

		$cachedTestimonials = $testimonials;
	}

	return $cachedTestimonials;
}


/**
 * Latest meeting query for footer
 */
function get_latest_meeting() {
	$cachedMeetingPost = get_transient(AERO_FOOTER_TRANSIENT);

	if (!$cachedMeetingPost) {
		// defaults
		$meeting = array(
			"title" => "",
			"excerpt" => "",
			"permalink" => "",
			"date" => ""
		);
		$expires = 60*60*1;

		// query for the latest post in the meeting category
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
				"post" => get_the_content(),
				"permalink" => esc_url(get_permalink()),
				"date" => get_the_date('M d, Y')
			);
			// reset the expires to be further out
			$expires = 60*60*6;
		}
		wp_reset_postdata();

		// save to cache
		set_transient( AERO_FOOTER_TRANSIENT, $meeting, $expires );

		$cachedMeetingPost = $meeting;
	}

	return $cachedMeetingPost;
}

/**
 * Cache buster when post is created or saved
 */
add_action( 'save_post', 'save_post_function', 10, 3 );
function save_post_function( $postID, $post, $update ) {
	if ($post->post_type == AERO_TESTIMONIALS_SLUG) {
		delete_transient(AERO_TESTIMONIALS_TRANSIENT);
		return;
	}

	$categories = wp_get_post_categories($postID, array('fields' => 'all'));
	foreach ($categories as $category) {
		if ($category->slug == AERO_FOOTER_SLUG) {
			delete_transient(AERO_FOOTER_TRANSIENT);
			break;
		}
	}
}

/**
 * Gravity Forms for Editors
 */

function add_grav_forms(){
    $role = get_role('editor');
    $role->add_cap('gform_full_access');
}
add_action('admin_init','add_grav_forms');




/**
 * Mailchimp API Subscribe Request
 */
function aero_mailchimp_do_subscribe( $apiKey, $listID, $emailAddress, $metaData = array() ){
	if (empty($apiKey) || empty($listID)) {
		return array("error" => true, "success" => false, "message" => "Missing API Key and/or list ID.");
	}

	// get the data center from the api key
	$dc = explode('-', $apiKey);
	if (sizeof($dc) != 2) {
		return array("error" => true, "success" => false, "message" => "Invalid API Key");
	}

	// build our payload
	$payload = array(
		'apikey'        => $apiKey,
		'email_type'		=> 'html',
		'email_address' => $emailAddress,
		'status'				=> 'subscribed',
		'ip_signup'			=> $_SERVER['REMOTE_ADDR'],
		'timestamp_signup' => $_SERVER['REQUEST_TIME']
	);

	if (!empty($metaData)) {
		$payload['merge_fields'] = $metaData;
	}

	// build our request
	$request = curl_init();
	curl_setopt($request, CURLOPT_URL, 'https://' . $dc[1] . '.api.mailchimp.com/3.0/lists/' . $listID . '/members/');
	curl_setopt($request, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization: Basic '.base64_encode( 'aerotropolis:'.$apiKey )));
	curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($request, CURLOPT_CUSTOMREQUEST, 'POST');
	curl_setopt($request, CURLOPT_TIMEOUT, 10);
	curl_setopt($request, CURLOPT_POST, true);
	curl_setopt($request, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($request, CURLOPT_POSTFIELDS, json_encode($payload) );

	// send the request
	$result = curl_exec($request);

	return $result;
}


/**
 * Change the WP admin login logo
 */
function aero_login_logo() { ?>
	<style>
			#login h1 a, .login h1 a {
				background-image: url(<?php echo get_template_directory_uri(); ?>/assets/img/desktop/login-logo.png);
				padding-bottom: 30px;
				background-size: 180px auto;
				height: 150px;
				width: 200px;
			}
	</style>
<?php }
add_action( 'login_enqueue_scripts', 'aero_login_logo' );

function aero_login_logo_url() {
	 return home_url();
}
add_filter( 'login_headerurl', 'aero_login_logo_url' );

function aero_login_logo_url_title() {
		return 'Detroit Aerotropolis';
}
add_filter( 'login_headertitle', 'aero_login_logo_url_title' );