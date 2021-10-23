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
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'comeon' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
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
define( 'AUTH_KEY',         'oAL+qe!v[e%Yr#JJd_~gD{92N}?K<%Zkgv{HOC>mv{wpT5qbs`bB]5yuOWzSZ_7{' );
define( 'SECURE_AUTH_KEY',  'xp|kQe2D8!>Q8t${?Mz:fZ/Qvy%w+B3^)Q@.L*SOvRm;#W#(![>NPSx/{j#u`ff[' );
define( 'LOGGED_IN_KEY',    '6Rmp&F,w#/.zYJ^L,;_Qc.cfd]LZ3!7O;gbZBAml%(t7eV<a0<0N33!ZygF[].#V' );
define( 'NONCE_KEY',        '!YcMMWQ2J*q-!ie@^7shNc9w5]v~p4Do(@,zm!c-YPCtuicQZ=eY!bnl1~N;r`9*' );
define( 'AUTH_SALT',        ';S2MO,48ewzRd(`-7e83:$TM@3hgv]?F(Y0[~+}dkZ<)N5T=3wA-KY;&;ldnN{4h' );
define( 'SECURE_AUTH_SALT', '^k:.X<ca,xHd]^p&5!;?2G!-nHqCN&X7[vJqHM<?o^Z6H@Xs%2~^.X%(#ZG-4{WA' );
define( 'LOGGED_IN_SALT',   '}ErNw:zh_E2p97&ur;vK<w&1Mow8Wydd0D<&.)Z}{Ig$UV(LfqgsG*o7@BLtYJY,' );
define( 'NONCE_SALT',       'Q`os w3_brRl]4%NP,j_u=/7L,,>@=Xw&0gpTK/TbsCDeX/`VTp_,SF4]k/7lz##' );

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
