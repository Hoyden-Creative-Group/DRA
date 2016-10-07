<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */


define('DB_HOST', 'localhost');
define('DB_CHARSET', 'utf8mb4');
define('DB_COLLATE', '');

if( preg_match("/^www\.aerotropolis\.com/", $_SERVER['HTTP_HOST']) ) {
  define('ENVIRONMENT', 'PROD');
  define('WP_DEBUG', false);
  define('DB_NAME', '');
  define('DB_USER', '');
  define('DB_PASSWORD', '');
} elseif ( $_SERVER['HTTP_HOST'] == "aerotropolis.hoydencreative.com" ) {
  define('ENVIRONMENT', 'STAGING');
  define('WP_DEBUG', true);
  define('DB_NAME', 'mollymas_aerotropolis');
  define('DB_USER', 'mollymas_aero');
  define('DB_PASSWORD', 'hoyden_aero');
} else {
  define('ENVIRONMENT', 'LOCAL');
  define('WP_DEBUG', true);
  define('DB_NAME', 'aerotropolis');
  define('DB_USER', 'root');
  define('DB_PASSWORD', 'root');
}


/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'be`xDbwJzL?BmaM[KZNwylyvDAet>5qXkCh~bKGlD_&tOZ<Ups:$&b:h[&vS0isa');
define('SECURE_AUTH_KEY',  ',%{k%LH=Lc`[}p57X;@]dS=Yke.qN@m/m=0]3?(^`#AU[+PEe1IEsh.u1-}E0);e');
define('LOGGED_IN_KEY',    '.Q:Nf;T*@{>x]eZ*wXYw9imHZ)~2u9!UMbP}k.qq8e}ncj@#=oT.@~[,:%8Lpw}@');
define('NONCE_KEY',        'DJ-~^$X%p~=W 3(Ini/_hWeA)AC`F6vL8{u?%IZ}Y=Kv|tWRTQY&@yjMp!M/ rHG');
define('AUTH_SALT',        '~mZ3OX!qImqGo2Z10,0PD{RIRTC0yeV2<p[-yz]YU6>+Ag[tQ;l)C<sw~miT`?-J');
define('SECURE_AUTH_SALT', '21b4&|-?EjlI:YmSOakIfv.E{-8OHP,@t[@m^><^3Zq!!C?T`+HJ[s36i&oSyZM-');
define('LOGGED_IN_SALT',   '{2p%NU#o8B:r112M/Vg3pA1>{>.be)c$/>r4Y+]y&zI%5UG,J}^ >?[!<b(%Ok;*');
define('NONCE_SALT',       '[&=5.%kC8o`1~ZKUwl1/CNQL4DjGn]OB:NulnGTU}T0OEE9X<`X[1pEZ72_E2Mb9');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
  define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
