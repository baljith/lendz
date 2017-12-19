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
define('DB_NAME', 'technocr_lendz');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '*technoadmin#');

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
define('AUTH_KEY',         'uXwY*=_2|z6%bW0 b$#ev96k%`>>0$luEbp<}Ibb/$LdEF$l+Wdx]f(yHv U3w#/');
define('SECURE_AUTH_KEY',  'zA(p[eXT^ DfhuuUrl|R*}(g+.aSpaBCP1_VQLLy1XJ!5&lw&x1uzRgN~Nb~[Q_B');
define('LOGGED_IN_KEY',    'gd*6n?T{6DPXcNc[(jN2/&t?GF>{&ZlbsTpz~J7N~v]%u)<B-FnY%rT#&gBgZ%EK');
define('NONCE_KEY',        'GxgC}+Yy>r+-u@14e(*M_#^v]/NVtV6!Tcs0YQ1]ALxyy@p)Ilo.+dLB`buH}HyR');
define('AUTH_SALT',        'L(-A;&`PK!Udb^@p{YB(2zXM?60hA=!}-`connjMsO&hJ8KMzE*-WT.m/g(!PPiW');
define('SECURE_AUTH_SALT', '2edayoQXjB~lOjbe1Y3;A`uTz9GmyjzJ:9h/rTdr)S}Q50>$(+W:o`K;<RPgV7,&');
define('LOGGED_IN_SALT',   '[9lOq@CXa:rsHUtj,mnzI1FZf:F/$2+%w>6V57H4pXu|k<C rV9i=`=2,6K}X^Y|');
define('NONCE_SALT',       'MXs#{b,M.! i!S]zw|/VS:YBV,@z}F|Ekio)o(Os-a6g&ny4g_H`E=`h-9H2.-uE');

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
