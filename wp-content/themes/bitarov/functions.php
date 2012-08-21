<?php

ini_set('display_errors', 'off');
error_reporting(0);

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

function rusdate($format, $timestamp)
 {
 $months = array(
   'january' => 'января',
   'february' => 'февраля',
   'march' => 'марта',
   'april' => 'апреля',
   'may' => 'мая',
   'june' => 'июня',
   'july' => 'июля',
   'august' => 'августа',
   'september' => 'сентября',
   'october' => 'октября',
   'november' => 'ноября',
   'december' => 'декабря'
 );
 $result = date($format, $timestamp);
 foreach ($months as $month_en=>$month_ru)
  {
  $month_en = preg_quote($month_en, '/');
  $result = preg_replace("/$month_en/iu", $month_ru, $result);
  }
 return $result;
 }

function bt_post_category($id_post)
 {
 $cats = wp_get_post_categories($id_post);
 if (count($cats)<1) return false;
 $result = 0;
 foreach ($cats as $cat) if ($cat>$result) $result = $cat;
 return $result;
 }

function bt_post_content()
 {
 ob_start();
 the_content();
 $result = ob_get_contents();
 ob_end_clean();
 return $result;
 }

function get_cat_path($id_cat)
 {
 $id_cat = intval($id_cat);
 static $cache;
 if (isset($cache[$id_cat])) return $cache[$id_cat];
 $cache[$id_cat] = array();
 $result = &$cache[$id_cat];
 for ($j=0; $j<32; $j++)
  {
  $cat = get_category($id_cat);
  if (!$cat) break;
  $result[] = $cat;
  if ($cat->category_parent<=1) break;
  $id_cat = $cat->category_parent;
  }
 $result = array_reverse($result);
 return $result;
 }

function bt_installed()
 {
 if (!defined('WP_ADMIN') or !chkget('activated')) return;
 //db_query("DROP TABLE pref_bt_media");
 db_query("CREATE TABLE pref_bt_media(id INTEGER UNSIGNED AUTO_INCREMENT PRIMARY KEY, typ TINYINT UNSIGNED, name VARCHAR(50))");
 //db_query("DROP TABLE pref_bt_slider");
 db_query("CREATE TABLE wp_bt_slider(id INTEGER UNSIGNED AUTO_INCREMENT PRIMARY KEY, pos TINYINT UNSIGNED, caption VARCHAR(255), text BLOB)");
 //db_query("DROP TABLE pref_bt_thanks");
 db_query("CREATE TABLE wp_bt_thanks(id INTEGER UNSIGNED AUTO_INCREMENT PRIMARY KEY, pos TINYINT UNSIGNED, caption VARCHAR(50), text BLOB)");

 db_query("DROP TABLE wp_bt_category_cache");
 db_query("CREATE TABLE wp_bt_category_cache(id_cat INTEGER UNSIGNED PRIMARY KEY, expire INTEGER UNSIGNED, data VARCHAR(255))");
 }

function gen_pages($current_page, $pages_count, $range)
 {
 $left = $current_page - $range;
 $right = $current_page + $range;
 $result = array();
 //if ($left-$range>0) $result[] = '<';
 for ($p=$left; $p<=$right; $p++) if ($p>0 and $p<= $pages_count) $result[] = $p;
 //if ($right+$range<$pages_count) $result[] = '>';
 return $result;
 }

function get_years($id_cat)
 {
 $clean_interval = 3600;
 $cache_period = 86400;
 $id_cat = intval($id_cat);
 $bt_category_cache_cleantime = get_option('bt_category_cache_cleantime', 0);
 if (time()-$bt_category_cache_cleantime>$clean_interval)
  {
  db_query("DELETE FROM pref_bt_category_cache WHERE expire<'?1'", time());
  update_option('bt_category_cache_cleantime', time());
  }
 $res = db_query("SELECT data AS years FROM pref_bt_category_cache WHERE id_cat='?1' AND expire>'?2'", $id_cat, time());
 if ($res['cnt']>0)
  {
  extract(db_result($res));
  $years = unserialize($years);
  }
 else
  {
  $res = db_query("SELECT DISTINCT year(post_date) AS year
  FROM pref_posts, pref_term_relationships
  WHERE pref_term_relationships.object_id=pref_posts.ID AND pref_term_relationships.term_taxonomy_id='?1'", $id_cat);
  $years = array();
  while (extract(db_result($res, 'i'))) $years[] = $year;
  db_query("REPLACE INTO pref_bt_category_cache VALUES('?1', '?2', '?3')", $id_cat, time()+$cache_period, serialize($years));
  }
 return $years;
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
