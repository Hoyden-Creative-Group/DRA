<?php

/**
 * @package Aerotropolis Theme Support Plugin
 * @author  Bryan Stanley <bstanley.0811@gmail.com>
 *
 * This page adds a custom post_type page in the admin section.
 */


// Register the Testimonials custom post type
function aero_register_testimonials() {

  $slug = apply_filters( 'aero_testimonials_rewrite_slug', 'testimonials' );

  $labels = array(
    'name'                  => 'Testimonials',
    'singular_name'         => 'Testimonial',
    'menu_name'             => 'Testimonials',
    'name_admin_bar'        => 'Testimonials',
    'archives'              => 'Item Archives',
    'parent_item_colon'     => 'Parent Item:',
    'all_items'             => 'All Testimonials',
    'add_new_item'          => 'Add New Testimonial',
    'add_new'               => 'Add New Testimonial',
    'new_item'              => 'New Testimonial',
    'edit_item'             => 'Edit Testimonial',
    'update_item'           => 'Update Testimonial',
    'view_item'             => 'View Testimonial',
    'search_items'          => 'Search Testimonial'
  );
  $args = array(
    'label'                 => 'Testimonial',
    'description'           => 'A post type for your testimonials',
    'labels'                => $labels,
    'supports'              => array( 'title', 'editor', 'thumbnail' ),
    'taxonomies'            => array( 'testimonial-categories' ),
    'hierarchical'          => false,
    'public'                => true,
    'show_ui'               => true,
    'show_in_menu'          => true,
    'menu_position'         => 26,
    'menu_icon'             => 'dashicons-heart',
    'show_in_admin_bar'     => true,
    'show_in_nav_menus'     => true,
    'can_export'            => true,
    'has_archive'           => true,
    'exclude_from_search'   => false,
    'publicly_queryable'    => true,
    'capability_type'       => 'page',
    'rewrite'               => array( 'slug' => $slug ),
  );
  register_post_type( 'testimonials', $args );
  register_taxonomy( 'testimonial-categories', 'testimonials', array ('hierarchical' => true, 'label' => __('Testimonial Category')));
}
add_action( 'init', 'aero_register_testimonials', 0 );