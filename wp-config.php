<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link https://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wordpress');

/** MySQL database username */
define('DB_USER', 'username');

/** MySQL database password */
define('DB_PASSWORD', 'password');

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
define('AUTH_KEY',         '%%tPUe^zB ?`|_dp#WB$NSoxP97jL=B*)V=Zj=EERoT|#KUg-a2zK?%d*Oxw*uY:');
define('SECURE_AUTH_KEY',  'J]Z|>MY1|^vC:7*T63^gJZ{$|XMp-WXg;!-exXe!H[.P 2Rk+Uo$7u/roZ4XZ*DX');
define('LOGGED_IN_KEY',    'E{ABV-<W$nrEsA0j-MK=2AwS1]@<y0_!Gj+_(1h,-JPfuI)m1`&-nUy()9VBtn5%');
define('NONCE_KEY',        'Ha<mN]6}OYwNAs`t@S#:5%=OcgS]Z_Q%d7Mc.q$cI5f(>Kpg^t!Erc)JoM,WI%/5');
define('AUTH_SALT',        '%Z>3%F/.uR0$cz_|rqb^9Yc4r6q-|&X# hOFI@]GNm+%y[08]dl<}Y>Pj!4+&>rz');
define('SECURE_AUTH_SALT', '-}Tz|m&w_7->nTjq?wL{qvv-&]AS[a,|&fhqrmO-|`Z/^rcPOH<W~et0#-s-[kjF');
define('LOGGED_IN_SALT',   'jg{%u(}iUygkJMRbH[Unvb>aU7->C*pE<Fu$%^9q?Hfx+)/:>LIMc~*s+3@,nEJ(');
define('NONCE_SALT',       'dB{4y+m?X`U]M7G+gt@(L@SdX3;]H@Y^Eja+{_oj7+Q|^<(,]pF cTKPYfI=T+;?');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
