<?php
if (!chkget('bt_json')) exit;
$action = $_GET['bt_json'];

switch ($action):
case 'get_posts':
  if (!chkget('category_id,pg')) die('требуются параметры category_id, pg');
  extract(eg('category_id>>i,pg>>i'));
  $args = array('paged' => $pg, 'cat'=>$category_id);
  if (chkget('year')) $args['year'] = intval($_GET['year']);
  query_posts($args);
  $response = array();
  while (have_posts())
   {
   the_post();
   $response[] = array(
     'post_id' => $post->ID,
     'post_title' => get_the_title();
     'post_excerpt' =>
   );
   }
  echo json_encode($response);
  break;
endswitch;

exit;

?>