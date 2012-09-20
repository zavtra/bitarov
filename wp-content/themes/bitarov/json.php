<?php

function json_die($msg) {die(json_encode(array('err'=>array($msg))));}
if (!chkget('bt_json')) json_error('Требуется GET-параметр bt_json');
$action = $_GET['bt_json'];

switch ($action):
case 'get_posts':
  if (!chkget('category_id,pg')) json_die('Требуются GET-параметры category_id, pg');
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
   $post_date = strtotime($posts->post->post_date);
   $comments_count = wp_count_comments($posts->post->ID);
   $comments_count = $comments_count->approved>0
                   ? numberic($comments_count->approved, array('комментариев', 'комментарий', 'комментария'))
                   : 'Комментировать';
   $item = array(
     'post_id' => $posts->post->ID,
     'post_title' => get_the_title(),
     'post_excerpt' => get_the_excerpt(),
     'post_content' => bt_post_content(),
     'post_date_dm' => rusdate('j F', $post_date),
     'post_date_y' => rusdate('Y', $post_date),
     'post_link' => get_permalink($posts->post->ID),
     'category_id' => $post_category_id,
     'category_name' => $post_category->name,
     'category_link' => get_category_link($post_category_id),
     'opinion' => get_post_meta($posts->post->ID, 'bt_opinion', true),
     'comments_count' => $comments_count,
     'tags' => ''
   );
   if (is_array($tags_raw=get_the_tags()))
    foreach ($tags_raw as $tag)
     {
     $tag_link = get_tag_link($tag->term_id);
     $tag_name = $tag->name;
     $item['tags'] .= "<a href='$tag_link'>$tag_name</a> ";
     }

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

case 'feedback':
  if (!chkpost('form,message,name,phone,email')) json_die('Требуются POST-параметры form, message, name, phone, email');
  extract(ep('form,message,name,phone,email'));
  if ($form=='fund') $form = 'благотворительный фонд';
  elseif ($form=='contacts') $form = 'контакты';
  else json_die('Неверное значение параметра form');
  $errors = array();
  $len = strlen($message);
  if ($len<1) $errors[] = 'Пустой текст сообщения';
  elseif ($len<10) $errors[] = 'Текст сообщения не должен быть короче 10 символов';
  elseif ($len>3000) $errors[] = 'Текст сообщения не должен быть длинее 3000 символов';
  $message = correct_eol($message);
  $len = strlen($name);
  if ($len<1) $errors[] = 'Не указано имя';
  elseif ($len<2) $errors[] = 'Имя указано неверно';
  elseif ($len>40) $errors[] = 'Длина имени не должна превышать 40 символов';
  if ($email and !ismail($email)) $errors[] = 'Адрес e-mail указан неверно';
  if (!$phone) $errors[] = 'Пожалуйста, укажите номер телефона для связи с Вами';
  elseif (!chklen(preg_replace('/[^0-9]+/', '', $phone), 6, 20)) $errors[] = 'Номер телефона указан неверно';
  else $phone = ($phone[0]=='+' ? '+' : '') . trim(preg_replace('/[^0-9]+/', ' ', $phone));
  if ($errors) die(json_encode(array('err'=>$errors)));
  $letter  = "Сообщение отправлено со страницы $form\n";
  $letter .= "Телефон: $phone\n";
  if ($email) $letter .= "E-mail: $email\n";
  $letter .= is_int(strpos($message, "\n")) ? "\nСообщение:\n" : 'Сообщение: ';
  $letter .= $message;
  $to = get_option('bt_email', 'admin@' . REQUEST_HOST);
  $subj = 'Сообщение с сайта ' . REQUEST_HOST;
  $headers = 'Content-Type: text/plain; charset=utf-8';
  if ($email) $headers .= "\nFrom: $email";
  mail($to, $subj, $letter, $headers);
  //file_put_contents(BASEDIR . '/log.txt', "$to\n---\n$subj\n---\n$letter\n---\n$headers");
  echo json_encode(array('ok'=>'Ваше сообщение успешно отправлено'));
break;
endswitch;

exit;

?>