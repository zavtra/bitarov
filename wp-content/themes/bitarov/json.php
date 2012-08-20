<?php
if (!chkget('bt_json')) exit;
$action = $_GET['bt_json'];

switch ($action):
case 'get_posts':
  if (!chkget('category_id,pg')) die('требуются параметры category_id, pg');
  extract(eg('category_id>>i,pg>>i'));
  $args = array('paged'=>$pg, 'cat'=>$category_id);
  if (chkget('year')) $args['year'] = intval($_GET['year']);
  $posts = new WP_Query($args);
  $resp_items = array();
  while ($posts->have_posts())
   {
   $posts->the_post();
   $post_category_id = bt_post_category($posts->post->ID);
   $post_category = get_category($post_category_id);
   $item = array(
     'post_id' => $posts->post->ID,
     'post_title' => get_the_title(),
     'post_excerpt' => get_the_excerpt(),
     'post_content' => get_the_content(),
     'post_date' => rusdate('j F Y', strtotime($posts->post->post_date)),
     'post_link' => get_permalink($posts->post->ID),
     'category_id' => $post_category_id,
     'category_name' => $post_category->name,
     'category_link' => get_category_link($post_category_id)
   );
   $opinion = get_post_meta($posts->post->ID, 'bt_opinion', false);
   if ($opinion) $item['opinion'] = $opinion;
   $resp_items[] = $item;
   }
  unset($posts);
  $args['paged']++;
  $posts = new WP_Query($args);
  $resp_info = array(
    'next_page'=> ($posts->post_count>0 ? $args['paged'] : false)
  );
  echo json_encode(array(
    'items' => $resp_items,
    'info' => $resp_info
  ));
  break;
endswitch;

exit;

?>