<?php

ini_set('display_errors', 'off'); error_reporting(0);
//ini_set('display_errors', 'on'); error_reporting(E_ALL);

require dirname(__FILE__) . '/libpascal.php';

define('BT_EVENT_W1', 1024);
define('BT_EVENT_H1', 768);
define('BT_EVENT_BIGW', 589);
define('BT_EVENT_BIGH', 198);
define('BT_EVENT_MEDW', 271);
define('BT_EVENT_MEDH', 174);
define('BT_EVENT_W2', 270);
define('BT_EVENT_H2', 170);
define('BT_OPINION_H1', 56);
define('BT_OPINION_W1', 63);
define('BT_SLIDE_W', 1017);
define('BT_SLIDE_H', 296);
define('BT_THANK_W', 100);
define('BT_THANK_H', 100);

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

function breadcrumbs_category($category_id)
 {
 $categories_path = get_cat_path($category_id);
 $siteurl = SITE_URL;
 $breadcrumbs = "<span class='current'><a href='$siteurl'><ins></ins>bitarov.as</a></span>\n";
 foreach ($categories_path as $category)
  {
  $category_link = get_category_link($category->term_id);
  $category_name = $category->name;
  $breadcrumbs .= "                        <span><a href='$category_link'>$category_name</a><ins class='r'></ins></span>\n";
  }
 return $breadcrumbs;
 }

function breadcrumbs_post($post_object)
 {
 $siteurl = SITE_URL;
 $breadcrumbs = "<span class='current'><a href='$siteurl'><ins></ins>bitarov.as</a></span>";
 foreach (get_cat_path(bt_post_category($post_object->ID)) as $cat)
  {
  $breadcrumb_link = get_category_link($cat->term_id);
  $breadcrumb_text = $cat->name;
  $breadcrumbs .= "<span><a href='$breadcrumb_link'>$breadcrumb_text</a><ins class='r'></ins></span>";
  }
 return $breadcrumbs;
 }

function breadcrumbs_page($page_object)
 {
 $current_page = $page_object;
 $breadcrumbs = '';
 while (true)
  {
  $link = get_permalink($current_page->ID);
  $breadcrumbs = "<span><a href='$link'>{$current_page->post_title}</a><ins class='r'></ins></span>$breadcrumbs";
  if ($current_page->post_parent<1) break;
  else $current_page = get_post($current_page->post_parent);
  }
 $siteurl = SITE_URL;
 $breadcrumbs = "<span class='current'><a href='$siteurl'><ins></ins>bitarov.as</a></span>$breadcrumbs";
 return $breadcrumbs;
 }

function bt_installed()
 {
 if (!defined('WP_ADMIN') or !chkget('activated')) return;
 //db_query("DROP TABLE pref_bt_media");
 db_query("CREATE TABLE pref_bt_media(id INTEGER UNSIGNED AUTO_INCREMENT PRIMARY KEY, typ TINYINT UNSIGNED, name VARCHAR(50))");
 //db_query("DROP TABLE pref_bt_slider");
 db_query("CREATE TABLE wp_bt_slider(id INTEGER UNSIGNED AUTO_INCREMENT PRIMARY KEY, pos TINYINT UNSIGNED, caption VARCHAR(255), text BLOB)");
 //db_query("DROP TABLE pref_bt_thanks");
 db_query("CREATE TABLE wp_bt_thanks(id INTEGER UNSIGNED AUTO_INCREMENT PRIMARY KEY, pos TINYINT UNSIGNED, caption VARCHAR(100), text BLOB)");

 //db_query("DROP TABLE wp_bt_category_cache");
 db_query("CREATE TABLE wp_bt_category_cache(id_cat INTEGER UNSIGNED PRIMARY KEY, expire INTEGER UNSIGNED, data VARCHAR(255))");
 }

function gen_pages($current_page, $pages_count, $range)
 {
 $left = $current_page - $range;
 $right = $current_page + $range;
 $max_range = $range*2+1;
 $possible_min = $current_page - $max_range - 1;
 $possible_max = $current_page + $max_range - 1;
 $pages = array();
 for ($p=$left; $p<$current_page; $p++) if ($p>0) $pages[] = $p;
 for ($p=$current_page; $p<=$right; $p++) if ($p<=$pages_count) $pages[] = $p;
 $pages_generated = count($pages);
 $pages_need = $max_range - $pages_generated;
 if ($pages_need<1) return $pages;
  {
  $first_page = min($pages);
  $last_page = max($pages);
  for ($j=$last_page+1; ($j<=$possible_max and $pages_generated<$max_range); $j++) if ($j<=$pages_count) {$pages[]=$j; $pages_generated++;}
  for ($j=$first_page-1; ($j>=$possible_min and $pages_generated<$max_range); $j--) if ($j>0) {$pages[]=$j; $pages_generated++;}
  }
 sort($pages);
 return $pages;
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
