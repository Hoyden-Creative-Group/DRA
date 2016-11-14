<?php

/**
 * @package Aerotropolis Theme Support Plugin
 * @author  Bryan Stanley <bstanley.0811@gmail.com>
 *
 * This page adds a custom "options" page in the admin section.  This is mainly
 * used for global variables across the website.
 */


function add_admin_options () {
  // add a sidebar menu option
  add_menu_page(
    'Aerotropolis Settings',
    'Global Settings',
    'manage_options',
    'aerotropolis_settings',
    'aero_theme_settings_page',
    'dashicons-admin-generic',
    26
  );

  // add a submenu page to the options
  add_submenu_page(
    'aerotropolis_settings',
    'Aerotropolis Settings',
    'Settings',
    'manage_options',
    'aerotropolis_settings',
    'aero_theme_settings_page'
  );

  // custom settings
  add_action('admin_init', 'aero_custom_settings');

}
add_action('admin_menu', 'add_admin_options');


/**
 * Page Templates
 */
function aero_theme_settings_page () {
  require_once( dirname(__FILE__) . '/templates/settings.php');
}


/**
 * Page Sections
 */


// Settings sections and fields
function aero_custom_settings () {
  register_setting('aero-settings-group', 'copyright');
  register_setting('aero-settings-group', 'phone_number', 'validate_phone_number');
  register_setting('aero-settings-group', 'email', 'validate_email');
  register_setting('aero-settings-group', 'address', 'validate_address');
  register_setting('aero-settings-group', 'contact_person_name');
  register_setting('aero-settings-group', 'contact_person_title');
  register_setting('aero-settings-group', 'linkedin');
  register_setting('aero-settings-group', 'twitter');

  add_settings_section('aero-general-settings', 'General Information', 'aero_general_settings', 'aerotropolis_settings');
  add_settings_field('copyright', 'Copyright Text', 'aero_copyright', 'aerotropolis_settings', 'aero-general-settings');

  add_settings_section('aero-contact-settings', 'Contact Information', 'aero_contact_settings', 'aerotropolis_settings');
  add_settings_field('phone_number', 'Phone Number', 'aero_phone_number', 'aerotropolis_settings', 'aero-contact-settings');
  add_settings_field('email', 'Email Address', 'aero_email', 'aerotropolis_settings', 'aero-contact-settings');
  add_settings_field('address', 'Address', 'aero_address', 'aerotropolis_settings', 'aero-contact-settings');
  add_settings_field('contact_person_name', 'Contact Person Name', 'aero_contact_person_name', 'aerotropolis_settings', 'aero-contact-settings');
  add_settings_field('contact_person_title', 'Contact Person Title', 'aero_contact_person_title', 'aerotropolis_settings', 'aero-contact-settings');

  add_settings_section('aero-social-media', 'Social Media', 'aero_social_media', 'aerotropolis_settings');
  add_settings_field('linkedin', 'LinkedIn', 'aero_linkedin', 'aerotropolis_settings', 'aero-social-media');
  add_settings_field('twitter', 'Twitter', 'aero_twitter', 'aerotropolis_settings', 'aero-social-media');
}

/**
 * Section titles
 */
function aero_general_settings () {
  echo 'Please set your general settings.';
}

function aero_contact_settings () {
  echo 'Please set your contact information.';
}

function aero_social_media () {
  echo 'Please set your social media information';
}


/**
 * Fields
 */
function aero_copyright () {
  $copyright = esc_attr( get_option('copyright') );
  echo '<input type="text" name="copyright" value="'. $copyright .'" placeholder="Copyright Text" class="regular-text" />';
  echo '<p class="description">The text to show up next to the copyright logo in the footer.</p>';
}

function aero_phone_number () {
  $phoneNumber = esc_attr( get_option('phone_number') );
  echo '<input type="text" name="phone_number" value="'. $phoneNumber .'" placeholder="Phone Number" class="regular-text" />';
  echo '<p class="description">Format phone number as 123-123-1234</p>';
}

function aero_email () {
  $email = esc_attr( get_option('email') );
  echo '<input type="text" name="email" value="'. $email .'" placeholder="Email Address" class="regular-text" />';
}

function aero_address () {
  $address = esc_attr( get_option('address') );
  echo '<textarea name="address" placeholder="Address" class="wide" cols="50" rows="5">'. $address .'</textarea>';
}

function aero_contact_person_name () {
  $contact_person_name = esc_attr( get_option('contact_person_name') );
  echo '<input type="text" name="contact_person_name" value="'. $contact_person_name .'" placeholder="Contact person name" class="regular-text" />';
}

function aero_contact_person_title () {
  $contact_person_title = esc_attr( get_option('contact_person_title') );
  echo '<input type="text" name="contact_person_title" value="'. $contact_person_title .'" placeholder="Contact person title" class="regular-text" />';
}

function aero_linkedin () {
  $linkedin = esc_attr( get_option('linkedin') );
  echo '<input type="text" name="linkedin" value="'. $linkedin .'" placeholder="LinkedIn Url" class="regular-text code" />';
}

function aero_twitter () {
  $twitter = esc_attr( get_option('twitter') );
  echo '<input type="text" name="twitter" value="'. $twitter .'" placeholder="Twitter Url" class="regular-text code" />';
}


/**
 * Validations
 */
function validate_phone_number ($phoneNumber) {
  if (!preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/", $phoneNumber)) {
    add_settings_error('phone_number', 'phone_number', 'Invalid phone number');
    return esc_attr( get_option('phone_number') );
  }

  return $phoneNumber;
}

function validate_email ($email) {
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    add_settings_error('email', 'email', 'Invalid email address');
    return esc_attr( get_option('email') );
  }

  return $email;
}

function validate_address ($address) {
  if (empty($address)) {
    add_settings_error('address', 'address', 'Address cannot be empty');
    return esc_attr( get_option('address') );
  }

  return $address;
}



