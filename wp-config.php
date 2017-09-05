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
define('DB_NAME', 'pjstyle');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

define( 'WP_MEMORY_LIMIT', '512M' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'LG5srpRv`0@mrV`R~1!>[y$p}SPb#-5}/)|1{_c!R$_LBX4r.G?X^yhu;K~TFIEr');
define('SECURE_AUTH_KEY',  '_r$29YSg1Y:NVDL9V;^j?/D?p&p9%H]~37tAIcFK& fBEjXBb)gEb|Sxq6p2PP[6');
define('LOGGED_IN_KEY',    '1t60p08UDJe 4~7vWeBL:]gM$HHl4:+/}k`h`y:1sTxHXX`@77/)!$U:swzLe0PZ');
define('NONCE_KEY',        '5 <,V^3j9vfC]bT9rt#d8CRmDg5K~J1RS_s[6}9:EhLto`0PtKZ:`p0P$gMaY (0');
define('AUTH_SALT',        'F.#p-{ D{yBkeHdPUQ_HMkh3{]*!;7Ze=R1N!$x[ [spVhp_r2LQmFfn5?6QACc&');
define('SECURE_AUTH_SALT', 'h>u.{lHXyZ>dfv4[P:j/|r?RI_Gp>bQc]f.a{{;e1F6QVmOvvYtR$dbl.tC(=>js');
define('LOGGED_IN_SALT',   'UOI=qe^HhuD0IjqFdpjVg1Q#b:vD:#YO?-Bx8hKK_EovLBAgDMzRvv-]<TbgzV^N');
define('NONCE_SALT',       'YF9KZ%WH@6NhGvOw[s!8!pAafSv{nUBy!1VX8M,U@Jp5KF{jKLsjW^tw:uM!JNEK');

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
