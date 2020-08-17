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

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'bookings' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'eXnQVs]*)D9Im3v|>O9?-H*h+|n+qD$VPz$K$p{9%G[p9t-Ix3c~NBO Cn6>1G,E' );
define( 'SECURE_AUTH_KEY',  '$Qv%*3e/za|)}(LOO`@veAK-A(M!:q1Jfl&fICNldAv;[oRBK&{E>QL<0#o}Czr?' );
define( 'LOGGED_IN_KEY',    'd!-%2|RGg;+b 8A#ZoijAFik8v_+<g3jiPM~jlz_`N_fC C>XVwSl)s?vb&p!,2{' );
define( 'NONCE_KEY',        '>AN ;zwb`QE`T?C7/EqhJuO|+if.NRR7TcErqQ~osO#@gn56_i(C[is=JH3]L~J$' );
define( 'AUTH_SALT',        '@713xQPRj3EkM[Q+wJ@CGA5MRO=Yw/mLNc95z)`f8j#ogA-N4of4,,R7D^:-{,j{' );
define( 'SECURE_AUTH_SALT', 'TF3Zh>;nX:Z-T(He[/x@G|uzqT!m@-_7(Cv_VFP,gW@?LQbXg#obg{HTcgX6US%j' );
define( 'LOGGED_IN_SALT',   '[KQUl+wx?ivWV>A9$qEKcP4$b83#Ei]&ymIyBT]j?:0[[U5~?#{lJqz<{4w-W;EM' );
define( 'NONCE_SALT',       'aUdz79 ohE?!;. gxOjio6$_ddyiNb*MHZMfcZha,F#=),4?mzpzd.E_J}Q6TGg(' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
