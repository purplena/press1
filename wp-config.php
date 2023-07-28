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
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'master' );

/** Database username */
define( 'DB_USER', 'admin' );

/** Database password */
define( 'DB_PASSWORD', 'admin' );

/** Database hostname */
define( 'DB_HOST', 'database' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

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
define( 'AUTH_KEY',          'w:,>`r&:gb7riaM*IN2ycnH6.BnK=!PW}A5ZT^-,Xw9zIdG/K=+F.LV2V+TY_ilT' );
define( 'SECURE_AUTH_KEY',   '@TPUw12rh,LQ%`}y+9;cl<%Sh&31,a*m]:WC`8=a4xW{#jstgeu~29</lV<$<b;h' );
define( 'LOGGED_IN_KEY',     'OZI4T~A/&C+PoCI>BOIxQLj;mIAk{mQs^cMMM=y?RG{u375hR0Ye2ne{[ S@|qw3' );
define( 'NONCE_KEY',         '6]o_~6V0FoGSU7{R==cM>n9nyTeL18Sw.ppBJ[H)U]OM<?hIbq~7:C5Q-^#85MRx' );
define( 'AUTH_SALT',         'Y5~>,z]zKF7tRa^Y#BTG3C4>Rv!r2f#8O#lG)T_>&5Qi/x_&X=(3CwY%@h;[SQ-q' );
define( 'SECURE_AUTH_SALT',  'fy^UbzolhVPp!~HdTQ^L#sV}UePP*$EM?-bUs4h%{rr*G9T-G&%?K4V{q*rhu4A)' );
define( 'LOGGED_IN_SALT',    'VaPis~9,6%DfBuQ{?%:dP(?,tXk_c!e2zr%!-VsDJ~SR8MuHOO0]<PXp}N33@zcr' );
define( 'NONCE_SALT',        'B>Voz/5eLNjFRFSR2yo4cm=/X1DgE[H;(Y,m9jEreK-qDK+LWn5H5ZwasU00^HLF' );
define( 'WP_CACHE_KEY_SALT', 'lwg  {q,z#d~Sq!s[IC Yoh[;~tKIcphO/4OZOGM.8EI8ad<fa<tMIaiy5bN:-;n' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



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
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
