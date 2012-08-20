<?php

function drop_filters()
 {
 remove_filter('the_content', 'wptexturize');
 remove_filter('the_content', 'convert_smilies');
 remove_filter('the_content', 'wpautop');
 remove_filter('the_content', 'shortcode_unautop');
 remove_filter('the_content', 'capital_P_dangit');
 }
//add_action('init', 'drop_filters');

function bt_init()
 {
 if (chkget('bt_json'))
  {
  require TEMPLATEPATH . '/json.php';
  exit;
  }
 }
add_action('init', 'bt_init');

function bt_modify_query()
 {
 global $wp_query;
 if (chkget('posts-year')) $wp_query->set('year', intval($_GET['posts-year']));
 }
add_action('parse_query', 'bt_modify_query');

global $posts_year;
if (preg_match('/\/year([0-9]+)(\/|$)/', $_SERVER['REQUEST_URI'], $year))
 {
 $_GET['posts-year'] = $year[1];
 $_SERVER['REQUEST_URI'] = preg_replace('/\/year([0-9]+)(\/|$)/', '/', $_SERVER['REQUEST_URI']);
 }

?>