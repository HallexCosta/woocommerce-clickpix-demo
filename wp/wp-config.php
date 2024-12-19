<?php
define( 'WP_CACHE', true /* Modified by NitroPack */ );

require_once ABSPATH . 'wp-env.php';

// a helper function to lookup "env_FILE", "env", then fallback
if (!function_exists('getenv_docker')) {
	// https://github.com/docker-library/wordpress/issues/588 (WP-CLI will load this file 2x)
	function getenv_docker($env, $default) {
		if ($fileEnv = getenv($env . '_FILE')) {
			return rtrim(file_get_contents($fileEnv), "\r\n");
		}
		else if (($val = getenv($env)) !== false) {
			return $val;
		}
		else {
			return $default;
		}
	}
}

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', $_ENV['DATABASE'] );

/** Database username */
define( 'DB_USER', $_ENV['USERNAME'] );

/** Database password */
define( 'DB_PASSWORD', $_ENV['PASSWORD'] );

/**
 * Docker image fallback values above are sourced from the official WordPress installation wizard:
 * https://github.com/WordPress/WordPress/blob/1356f6537220ffdc32b9dad2a6cdbe2d010b7a88/wp-admin/setup-config.php#L224-L238
 * (However, using "example username" and "example password" in your database is strongly discouraged.  Please use strong, random credentials!)
 */

/** Database hostname */
define( 'DB_HOST', $_ENV['HOST'] );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', $_ENV['DB_CHARSET'] );

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
define( 'AUTH_KEY',         $_ENV['AUTH_KEY'] );
define( 'SECURE_AUTH_KEY',  $_ENV['SECURE_AUTH_KEY'] );
define( 'LOGGED_IN_KEY',    $_ENV['LOGGED_IN_KEY'] );
define( 'NONCE_KEY',        $_ENV['NONCE_KEY'] );
define( 'AUTH_SALT',        $_ENV['AUTH_SALT'] );
define( 'SECURE_AUTH_SALT', $_ENV['SECURE_AUTH_SALT'] );
define( 'LOGGED_IN_SALT',   $_ENV['LOGGED_IN_SALT'] );
define( 'NONCE_SALT',       $_ENV['NONCE_SALT'] );
// (See also https://wordpress.stackexchange.com/a/152905/199287)

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

 // How to prevent WordPress not loading CSS over HTTPS issue?
 // https://www.malcare.com/blog/wordpress-not-loading-css-over-https/
 if ($_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {  
  $_SERVER['HTTPS'] = 'on';
} else {
  $_SERVER['HTTPS'] = 'off';
}

define('WP_DEBUG', filter_var($_ENV['WP_DEBUG'], FILTER_VALIDATE_BOOLEAN));
define('WP_DEBUG_LOG', filter_var($_ENV['WP_DEBUG_LOG'], FILTER_VALIDATE_BOOLEAN));
define('FORCE_SSL_ADMIN', filter_var($_ENV['FORCE_SSL'], FILTER_VALIDATE_BOOLEAN));  
define('FORCE_SSL_LOGIN', filter_var($_ENV['FORCE_SSL'], FILTER_VALIDATE_BOOLEAN));
define('CONCATENATE_SCRIPTS', filter_var($_ENV['CONCATENATE_SCRIPTS'], FILTER_VALIDATE_BOOLEAN));
define('SCRIPT_DEBUG', filter_var($_ENV['SCRIPT_DEBUG'], FILTER_VALIDATE_BOOLEAN));

define('WP_SITEURL', $_ENV['BASE_URL']);
define('WP_HOME', $_ENV['BASE_URL']);
define('FS_METHOD', $_ENV['FS_METHOD']);

if ($configExtra = getenv_docker('WORDPRESS_CONFIG_EXTRA', '')) {
	eval($configExtra);
}

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
