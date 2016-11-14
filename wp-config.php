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
define('AUTH_KEY',         '4GN[s.*h}c5i#<`(0WFmUiq:>9~ayYfSP-*Xw{pMhey8W-B0U-82,&4ONY+rx, p');
define('SECURE_AUTH_KEY',  'gH{}!lMg=@]9i``[kO^^m3~6`]nluDBd5%q NfoakPc-2:Nzeq5(_pf?YF}KaBqB');
define('LOGGED_IN_KEY',    '(*^t`R]?1[=hR&0[^6vvpl$i|/6>)S5ay<,fq92Q@#Zp!84Al?zCd`oJr)|KfXhU');
define('NONCE_KEY',        ';[ZYT 8XzfXpbd`_l 4b 2Z/nADA$7fxvPsc C`VdhO[Y3. *)[^9U~w==V+Lik,');
define('AUTH_SALT',        './Jt6S%My%k:s2!>9:([v.VHt7cMxLru1$>jQW#6%G$In`]E:07jXo<[;%k|N-!!');
define('SECURE_AUTH_SALT', 'ipLKiX/s+QQZ(YQe[~C8GT6p!1_&Yu+=e-8G3@ht96xJ65_0Spr&T1,HuDiS/Isr');
define('LOGGED_IN_SALT',   'QXi]GP1q8jH2sg,c-E;5Y8:[J;bW2 r;RHW735ExQoI~CqNxFX=V@qYdAB{#QM@v');
define('NONCE_SALT',       'sdcH1yH>+mB~Tm}pJ,#AVV{26HXlwcYQD4CdC(QP|%kPQUSY1dD*K QkGWz&>>C`');

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
