<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'portfolio');     // <-- đổi từ 'wpdb' sang 'portfolio'
define('DB_USER', 'wpuser');
define('DB_PASSWORD', 'wppass');
define('DB_HOST', 'db:3306');       // db là tên service MySQL trong docker-compose


define('WP_HOME',    'http://localhost:8081');
define('WP_SITEURL', 'http://localhost:8081');
/** Database charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The database collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

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
define('AUTH_KEY', 'zv|@HsWx$v{(<x_DZ?.WD=JjhdrJLd%VFZ7UIKlw4&& 3wf1jmZ[O){Lg8b]<s7x');
define('SECURE_AUTH_KEY', 'ZVM8vq)<O&x*DZq4@=G;,A*f,08cB#53Ml+(a>X]!R{C%U76KFb%U1A7ebTwp>Mg');
define('LOGGED_IN_KEY', '/tm)A)Xcz#Vj}wq{e^*Bi.K[@QjSL569(*P-d]2*d]W)7PgoKr,Q8&u{ceV)X<4%');
define('NONCE_KEY', 'vN=@IU;kg2z|rWY6Uw9Kqui9=s{$M:$WD7~<inV(D$VfCXhR6pW_Sj!5r ]ZSn!E');
define('AUTH_SALT', 'MP|Mc~Y.N^s`8s0^wW=-G2tQ)!:<(.s1;{$zoIA;nEq=8)=ckEXhlLnz}m-80{X!');
define('SECURE_AUTH_SALT', 'Y%[@Z^D (3H$4#=q>I{=XlLA+X6K2+9Rq^9atp~)<59&7>@gnH7M6|8?b`7/d..1');
define('LOGGED_IN_SALT', '<rl_H_%k+kj07em5d:>0F9WWR#rS0A/0h84QtWAPG!8?UO!7hUUZ4j+o&s8D0&DE');
define('NONCE_SALT', '<<X (E82~uE}!VHahz@m1^}gQ*h_mVt< O{#tX}.4:[sIO /#Y}VD3UO&yV4a78M');

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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define('WP_DEBUG', false);

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if (!defined('ABSPATH')) {
	define('ABSPATH', __DIR__ . '/');
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
