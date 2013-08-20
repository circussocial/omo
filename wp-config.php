<?php

/**

 * The base configurations of the WordPress.

 *

 * This file has the following configurations: MySQL settings, Table Prefix,

 * Secret Keys, WordPress Language, and ABSPATH. You can find more information

 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing

 * wp-config.php} Codex page. You can get the MySQL settings from your web host.

 *

 * This file is used by the wp-config.php creation script during the

 * installation. You don't have to use the web site, you can just copy this file

 * to "wp-config.php" and fill in the values.

 *

 * @package WordPress

 */

define('DISABLE_WP_CRON', true);

// ** MySQL settings - You can get this info from your web host ** //

/** The name of the database for WordPress */

define('DB_NAME', 'ogilvya_unileverwp');



/** MySQL database username */

define('DB_USER', 'ogilvya_unilever');



/** MySQL database password */

define('DB_PASSWORD', '}y3vX]g-+4]%');



/** MySQL hostname */

define('DB_HOST', 'localhost');



/** Database Charset to use in creating database tables. */

define('DB_CHARSET', 'utf8');



/** The Database Collate type. Don't change this if in doubt. */

define('DB_COLLATE', 'utf8_unicode_ci');



/**#@+

 * Authentication Unique Keys and Salts.

 *

 * Change these to different unique phrases!

 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}

 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.

 *

 * @since 2.6.0

 */

define('AUTH_KEY',         'nY1-O=R~<plYK^_>|58kcnp^A`cJ s@xN9m>#v;*vT[`.L95ofVvFCiOc<1(A2]S');

define('SECURE_AUTH_KEY',  'AsB/u9|Q^WHJx!M;N$iS-(K]}Y$0pyh#+neWf/py4&wi(-*wmWkHGv h[u)FWznU');

define('LOGGED_IN_KEY',    '.}V11DtoV`p]W]Q+c5 /X@FLAau!2(+1-J<<yADa0ee@-go:p(+MDxK<Y9uRWFrH');

define('NONCE_KEY',        'JaZX(;B:0-m7g:w-VG~tZbLx+SD<=&t|_`4`>II=B$#p~-+tRq[GBf|YsDMF[/f0');

define('AUTH_SALT',        '-!GcEA4n^bmDBm{QDb*z|j_.A_<UM%jh3|aK{ S$s5lg1+o@C)}K[VuACy`md{97');

define('SECURE_AUTH_SALT', 'v<inbcE7>VR4:7U(-+=(O?|5(WowC+?IQQEG* fO4UNH~|r6MvIx=Qjt(<gn|A|3');

define('LOGGED_IN_SALT',   'J;LOzC<my1+e<=/7+.P8I^Fss,QG[c2G2#:3BT+;mb3PaQDmA]-Dn-mGj`n7xl t');

define('NONCE_SALT',       'TE|vtJi1b*%%b|3?*T||-R*=0)ji&r|Fyl{%DXL^-*SU8+s|f[Fqqy+5Sxcy#*F3');



/**#@-*/



/**

 * WordPress Database Table prefix.

 *

 * You can have multiple installations in one database if you give each a unique

 * prefix. Only numbers, letters, and underscores please!

 */

$table_prefix  = 'wp_';



/**

 * WordPress Localized Language, defaults to English.

 *

 * Change this to localize WordPress. A corresponding MO file for the chosen

 * language must be installed to wp-content/languages. For example, install

 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German

 * language support.

 */
define('WPLANG', 'en');




/**

 * For developers: WordPress debugging mode.

 *

 * Change this to true to enable the display of notices during development.

 * It is strongly recommended that plugin and theme developers use WP_DEBUG

 * in their development environments.

 */

define('WP_DEBUG', false);

define ('WPLANG', 'vi ');

/* That's all, stop editing! Happy blogging. */



/** Absolute path to the WordPress directory. */

if ( !defined('ABSPATH') )

	define('ABSPATH', dirname(__FILE__) . '/');



/** Sets up WordPress vars and included files. */

require_once(ABSPATH . 'wp-settings.php');

