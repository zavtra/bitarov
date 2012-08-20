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

global $posts_year;
if (preg_match('/\/year\-([0-9]+)(\/|$)/', $_SERVER['REQUEST_URI'], $year))
 {
 $posts_year = intval($year[1]);
 $_SERVER['REQUEST_URI'] = preg_replace('/\/year\-([0-9]+)(\/|$)/', '/', $_SERVER['REQUEST_URI']);
 }
elseif (chkget('year')) $posts_year = intval($_GET['year']);

?>