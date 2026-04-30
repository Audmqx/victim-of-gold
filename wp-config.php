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
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'victim_of_gold');
define('DB_USER', 'wpuser');
define('DB_PASSWORD', 'MotDePasseSecurise123!');
define('DB_HOST', 'localhost');

/** Database charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY',         'pqw0BrdNIZ7YPLWriMHbukPSxURieP1trIq8C1SeltJ9GhdrsGvBxYNIm3fspv');
define('SECURE_AUTH_KEY',  'SqvVFdFPc6JmITUoagYgKR9BXIcxUMSm0wDmnkKV2SctWbEKRAf2uossxYyoyH8q');
define('LOGGED_IN_KEY',    'gGeBSFUNe4aoKpzEqwXBwidCuP73peil7HXDU2A6kWjkxbwgPwed9F6GYGLTt');
define('NONCE_KEY',        'EtSQXSRTOG43e9xSgI1oXyQaMW8KJwgcvZJfi3XJe9Di2ZAPJKgrImPdSJ8AqX');
define('AUTH_SALT',        'J1C6mK0kMLX5RSxFJYtAVjthqtiyuzdga7VsJmWSOj7JEhxKySZFFPrJXpEXC');
define('SECURE_AUTH_SALT', 'kPlfwXUwobzkUgLwqZHFAGzpwioRHxTesHdN8MebApAFYIKBQoPZwf3b0oOVHG');
define('LOGGED_IN_SALT',   'OBXzRkPcsg3Gkh08eaXuHu4l7ZZQpkT7KLAAc5GbLsbAI51oLQ7zZ2CRv2OOdBLN');
define('NONCE_SALT',       'WkclbQ0PI5ablUymhqlNbjWJaIiymyuaJNPabLD2N8IyAKVSNabAOeEqihz5Pu');

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define('WP_DEBUG', false);

/* Add any custom values between this line and the "stop editing" line. */

// Sécurité
define('DISALLOW_FILE_EDIT', true);        // Désactive l'éditeur de fichiers dans l'admin
define('WP_DEBUG_DISPLAY', false);         // Ne jamais afficher les erreurs en production
define('FORCE_SSL_ADMIN', true);           // Admin toujours en HTTPS
ini_set('display_errors', 0);

// Performance
define('WP_POST_REVISIONS', 5);            // Limite les révisions en base
define('AUTOSAVE_INTERVAL', 120);          // Autosave toutes les 2 min (défaut : 60s)
define('WP_CACHE', true);                  // Activé pour les plugins de cache

// Configuration de la langue française
define('WPLANG', 'fr_FR');

// Forcer la langue française pour tous les utilisateurs
define('WP_LANG_DIR', __DIR__ . '/wp-content/languages');


/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if (! defined('ABSPATH')) {
    define('ABSPATH', __DIR__ . '/');
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
