<?php
/**
 * WordPress Configuration - SQLite version for local development
 *
 * @package WordPress
 */

// ** SQLite settings ** //
define('DB_DIR', __DIR__ . '/wp-content/database/');
define('DB_FILE', '.ht.sqlite');

// ** MySQL settings - NOT USED with SQLite ** //
define('DB_NAME', 'neamob_wp');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_HOST', 'localhost');
define('DB_CHARSET', 'utf8mb4');
define('DB_COLLATE', '');

/**
 * Authentication unique keys and salts.
 */
define('AUTH_KEY',         '*6V9|*|Jp`C$_Lq*L6W:vqTr1-gYeF,r_Q6&tC|:3CB2d>wm,!|F8x=UuZ8zNK||');
define('SECURE_AUTH_KEY',  '>KcZ<SBCV>Lp5%;R#qm,?U&}+2Ac6xh#lU1U@gWv@tvR+aSt)-Oy!3JB}1EiQe^|');
define('LOGGED_IN_KEY',    '6+Ijc<)y|QrZH!x@-b[ofQh#drM-Fu@D~Czx*`{^F Ph*l7y@Uhi+0YcviSQ-#6O');
define('NONCE_KEY',        'umI(1`un^IP:?Dpar$tu0}-xfexZt0(BEZPooz%3O{&b9:h!}|pZ{xnN+ZFTh=N;');
define('AUTH_SALT',        'QjugXv0<QB-Tlb($a]O0$$7H0xH~# %4=n}4LU;FG7rxe[DH`l0JyvIT1nYU) e?');
define('SECURE_AUTH_SALT', '^r9vn=d&_pYc<e,_qQ|AI%_oy|rT3WBRZb9I|hXzj9]ss:~7k-`TAK|KZM#|rLi%');
define('LOGGED_IN_SALT',   'c?7/U092qg3c#DlheueA$5PFo=wIB;H{|Y}ON+!(5+;i0!iN8&(1jQ%y(zEVElQ8');
define('NONCE_SALT',       '3kOb-su8;hy0yd(at!{6oiPRl2X3N3Ww~^*uT|+!4O#N?pIDh^Q7SnSl$YN]oC&D');

/**
 * WordPress database table prefix.
 */
$table_prefix = 'wp_';

/**
 * Debugging mode - enabled for development
 */
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', true);

/**
 * Development settings
 */
define('WP_ENVIRONMENT_TYPE', 'local');
define('SCRIPT_DEBUG', true);

/* Add any custom values between this line and the "stop editing" line. */

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if (!defined('ABSPATH')) {
    define('ABSPATH', __DIR__ . '/');
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

