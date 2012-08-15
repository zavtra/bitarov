<?php
ini_set('display_errors', 'on');
error_reporting(E_ALL);

require dirname(__FILE__) . '/libpascal.php';

define('BT_EVENT_W1', 590);
define('BT_EVENT_H1', 198);
define('BT_EVENT_W2', 270);
define('BT_EVENT_H2', 170);
define('BT_OPINION_H1', 56);
define('BT_OPINION_W1', 63);
define('BT_SLIDE_W', 1017);
define('BT_SLIDE_H', 296);
define('BT_THANK_W', 97);
define('BT_THANK_H', 97);

function bt_installed()
 {
 if (!defined('WP_ADMIN') or !chkget('activated')) return;
 db_query("DROP TABLE pref_bt_media");
 db_query("CREATE TABLE pref_bt_media(id INTEGER UNSIGNED AUTO_INCREMENT PRIMARY KEY, typ TINYINT UNSIGNED, name VARCHAR(50))");
 db_query("DROP TABLE pref_bt_slider");
 db_query("CREATE TABLE wp_bt_slider(id INTEGER UNSIGNED AUTO_INCREMENT PRIMARY KEY, pos TINYINT UNSIGNED, caption VARCHAR(255), text BLOB)");
 db_query("DROP TABLE pref_bt_thanks");
 db_query("CREATE TABLE wp_bt_thanks(id INTEGER UNSIGNED AUTO_INCREMENT PRIMARY KEY, pos TINYINT UNSIGNED, caption VARCHAR(50), text BLOB)");
 }

register_sidebar(array(
  'before_widget' => '<li id="%1$s" class="widget %2$s">',
  'after_widget' => '</li>',
  'before_title' => '',
  'after_title' => '',
));

add_action('after_setup_theme', 'bt_installed');

if (defined('WP_ADMIN')) require BASEDIR . 'wp-content/themes/bitarov/admin.php';
else require BASEDIR . 'wp-content/themes/bitarov/user.php';

?>
