<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'protechbw' );

/** Database username */
define( 'DB_USER', 'ben.rey' );

/** Database password */
define( 'DB_PASSWORD', '9Global#' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'K57?T~M!+L^!|fh|^Zqao@WQr)sL@k~0ll8g~nD({MMI/$Qr8x>TK2M4h^OB4@p)' );
define( 'SECURE_AUTH_KEY',  'l0y{](bGr_KY-G/XEKux:e-?n`HZA*Smzu_`HW8r-+`iI?!(mUPXrgC)^!2e^gT6' );
define( 'LOGGED_IN_KEY',    '@z#R(oGoX %( v([lxe-51X9b/*uvdkcaDZc`VLE3 ?rsY|yFP9w|Q(Dk7|C[RN5' );
define( 'NONCE_KEY',        'Y[@,>)!eL|]EW-=qyn2^1kx)cH%fsNRIoR]7O~t>p)tS?:FD.}laC8t_PY/DDOfC' );
define( 'AUTH_SALT',        ']%UFMWAcvjM ]JP+FTT^?eY%d!p5[q);~OC}H=8fq%*[T$1_S<e`H.x`e^& );If' );
define( 'SECURE_AUTH_SALT', '36}s*xW-q^tKN<sguav[Qnk[$}76*>*XzO5|gfe((dtS=t+hiS3xdwseoKcD@=Mk' );
define( 'LOGGED_IN_SALT',   'gaEk4N2-/T$`H;&ZMnxusk6phLLh7vXi!U>rQ_k<A>?GQUo=FEy@}|:Tnd ^md:k' );
define( 'NONCE_SALT',       'RkB|V>M#d5$xPVYfob`krqA{B!,ue[7XAI4U(w{Lbx/$o5x.A1IzE$$92?-Z~hcv' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
