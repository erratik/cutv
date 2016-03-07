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
define('DB_NAME', 'wp_cutv');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database username */
define('DB_PORT', '3306');

/** MySQL database password */
define('DB_PASSWORD', 'root');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '1 AqA!}p*>7i;QLoYhq}KRMBOG<,k@9vNg>dumEZ@nL#gZ!LB#?*8O4,QPkh&QUP');
define('SECURE_AUTH_KEY',  'Q*iT=:!b^wJ:{7Z UAztkXb&p&3_Fk%h ~k_-pqt%ETf7Q|lWyh|GFj#d}.);VeZ');
define('LOGGED_IN_KEY',    'aU=^zq{rYSf~@Cwn<77K08U?| Y**^uPqus:}9EpupCl~cvEFH)44DfDSAYb[s8C');
define('NONCE_KEY',        'wU|LY88`L9%n#7w6LVvaN0q5-qv>tJW@*k>39H|`B@J!0(X{mEYI!vsv,9b4X{=w');
define('AUTH_SALT',        'W_8%A8|61}O8uhUZ8H-BB$9qzAf.GT-YB`IP:swXHv.UlvN^1nTR%$tOBaZHb45l');
define('SECURE_AUTH_SALT', '!5I`p4<Di{QDK:}=q:[n&<(Oq{7YF8P)zjA#@1hr1 )?La;LB^dB5_5]gTfg00Mw');
define('LOGGED_IN_SALT',   'gJ+5?01Q/x#fBbx(W=zwW7ntM|[7Sy7taZ.wHWI9,+.jl{o,z].w0j)Cb k&/XjX');
define('NONCE_SALT',       'x~,4Y2z-K)=?NWZ[ord;,pgT^`So3nPj6z|)3~d`|mg4WzMOXb;Ik.B{]l9#I/s2');

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
