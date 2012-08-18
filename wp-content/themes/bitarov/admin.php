<?php

function errmsg($msg, $escape=true)
 {
 if ($escape) $msg = htmltext($msg);
 return "<div class='error settings-error' style='margin-top:22px'><p><strong>
   $msg</strong><br>
   <strong>[</strong> <a href='javascript:history.back(-1)'>Назад</a> <strong>]</strong>
</p></div>\r\n";
 }

function okmsg($msg, $escape=true)
 {
 if ($escape) $msg = htmltext($msg);
 return "<div id='setting-error-settings_updated' class='updated settings-error'>
<p><strong>$msg</strong></p></div>\r\n";
 }

global $medias;
$medias = array(
  1 => 'Газета',
  2 => 'Телеканал'
);

// ------------------------------------------------------------------- Настройки

function bt_head()
 {
 echo "<script type='text/javascript' src='/wp-content/themes/bitarov/jquery.js'></script>\n";
 echo "<script type='text/javascript' src='/wp-content/themes/bitarov/admin.js'></script>\n";
 }

function bt_options()
 {
 $okmsg = '';

 if (chkpost('bt_event_w1,bt_event_h1,bt_event_w2,bt_event_h2,bt_opinion_h1,bt_opinion_w1,bt_opinion_cat,bt_opinion_pp'))
  {
  extract(ep('bt_event_w1>>i,bt_event_h1>>i,bt_event_w2>>i,bt_event_h2>>i,bt_opinion_h1>>i,bt_opinion_w1>>i,bt_opinion_cat>>i,bt_opinion_pp>>i'));
  if ($bt_event_w1<10) $bt_event_w1 = BT_EVENT_W1;
  if ($bt_event_h1<10) $bt_event_h1 = BT_EVENT_H1;
  if ($bt_event_w2<10) $bt_event_w2 = BT_EVENT_W2;
  if ($bt_event_h2<10) $bt_event_h2 = BT_EVENT_H2;
  if ($bt_opinion_h1<10) $bt_opinion_h1 = BT_OPINION_W1;
  if ($bt_opinion_w1<10) $bt_opinion_w1 = BT_OPINION_H1;
  if ($bt_opinion_pp<1) $bt_opinion_pp = 5;
  update_option('bt_event_w1', $bt_event_w1);
  update_option('bt_event_h1', $bt_event_h1);
  update_option('bt_event_w2', $bt_event_w2);
  update_option('bt_event_h2', $bt_event_h2);
  update_option('bt_opinion_w1', $bt_opinion_w1);
  update_option('bt_opinion_h1', $bt_opinion_h1);
  update_option('bt_opinion_cat', $bt_opinion_cat);
  update_option('bt_opinion_pp', $bt_opinion_pp);
  $okmsg = okmsg('Настройки сохранены');
  }

 $bt_event_w1 = get_option('bt_event_w1', BT_EVENT_W1);
 $bt_event_h1 = get_option('bt_event_h1', BT_EVENT_H1);
 $bt_event_w2 = get_option('bt_event_w2', BT_EVENT_W2);
 $bt_event_h2 = get_option('bt_event_h2', BT_EVENT_H2);
 $bt_opinion_h1 = get_option('bt_opinion_w1', BT_OPINION_W1);
 $bt_opinion_w1 = get_option('bt_opinion_h1', BT_OPINION_H1);
 $bt_opinion_cat = get_option('bt_opinion_cat', 1);
 $bt_opinion_pp = get_option('bt_opinion_pp', 5);

 $cats_arr = get_categories(array('hide_empty'=>0));
 $cats = '';
 foreach ($cats_arr as $cat) $cats .= "<option value='" . intval($cat->term_id) . "'".($cat->term_id==$bt_opinion_cat ? ' selected' : '').">" . htmltext($cat->name) . "</option>";

 return print <<<HTML
<form method='POST' name='form1' action='' class='wrap'>
  <div id='icon-options-general' class='icon32'></div>
  <h2>Настройки</h2>
  $okmsg
  <table style='margin-top:6px'>
  <tr><td>Большая картинка события, ширина:</td><td><input type='text' name='bt_event_w1' size='5' value='$bt_event_w1'> px</td></tr>
  <tr><td>Большая картинка события, высота:</td><td><input type='text' name='bt_event_h1' size='5' value='$bt_event_h1'> px</td></tr>
  <tr><td>Средняя картинка события, ширина:</td><td><input type='text' name='bt_event_w2' size='5' value='$bt_event_w2'> px</td></tr>
  <tr><td>Средняя картинка события, высота:</td><td><input type='text' name='bt_event_h2' size='5' value='$bt_event_h2'> px</td></tr>
  <tr><td>Мнение, ширина картинки:</td><td><input type='text' name='bt_opinion_h1' size='5' value='$bt_opinion_h1'> px</td></tr>
  <tr><td>Мнение, высота картинки:</td><td><input type='text' name='bt_opinion_w1' size='5' value='$bt_opinion_w1'> px</td></tr>
  <tr><td>Мнение, рубрика:</td><td><select name='bt_opinion_cat'>$cats</select></td></tr>
  <tr><td>Мнение, заголовков на главной:</td><td><input type='text' name='bt_opinion_pp' size='5' value='$bt_opinion_pp'></td></tr>
  <tr><td colspan='2'><input type='submit' class='button-primary' value='Сохранить настройки'></td></tr>
  </table>
</form>
HTML;
 }

// --------------------------------------------------------------------- Слайдер

function bt_slider()
 {
 $okmsg = '';
 $bt_slide_w = get_option('bt_slide_w', BT_SLIDE_W);
 $bt_slide_h = get_option('bt_slide_h', BT_SLIDE_H);

 if (chkget('del'))
  {
  $id_slide = intval($_GET['del']);
  db_query("DELETE FROM pref_bt_slider WHERE id='?1'", $id_slide);
  unlink(BASEDIR . "wp-content/uploads/slider/$id_slide.jpg");
  $okmsg = okmsg('Слайд удалён');
  }

 if (chkpost('addslide,text,bt_slide_w,bt_slide_h'))
  {
  extract(ep('addslide>caption,text,bt_slide_w>>i,bt_slide_h>>i'));
  if (!chklen($caption, 2, 100)) return print errmsg('Заголовок слайда должен иметь длину от 2 до 100 символова');
  if ($bt_slide_w<10) $bt_slide_w = BT_SLIDE_W;
  if ($bt_slide_h<10) $bt_slide_h = BT_SLIDE_H;
  update_option('bt_slide_w', $bt_slide_w);
  update_option('bt_slide_h', $bt_slide_h);
  extract(db_result(db_query("SELECT max(pos) AS pos FROM wp_bt_slider")));
  $id_slide = db_insert_lid('bt_slider', 0, ++$pos, $caption, $text);
  $err = '';
  if (empty($_FILES['pic']['tmp_name'])) $err = 'Файл картинки не загружен';
  if (!$err and !is_array($ih_src=imagecreatefromfile($_FILES['pic']['tmp_name']))) $err = 'Ошибка загрузки картинки (1)';
  if (!$err and !is_array($ih_dst=thumb($ih_src['ih'], $bt_slide_w, $bt_slide_h))) $err = 'Ошибка загрузки картинки (2)';
  if (!$err and !is_resource($ih_dst['ih']=centrize($ih_dst['ih'], $bt_slide_w, $bt_slide_h))) $err = 'Ошибка загрузки картинки (3)';
  if (!$err and !imagejpeg($ih_dst['ih'], BASEDIR . "wp-content/uploads/slider/$id_slide.jpg", 90)) $err = 'Ошибка загрузки картинки (2)';
  if ($err)
   {
   db_query("DELETE FROM pref_slider WHERE id='?1'", $id_slide);
   return print errmsg($err);
   }
  $okmsg = okmsg('Слайд успешно добавлен');
  }

 if (chkpost('save,caption,text'))
  {
  extract(ep('save>id_slide>i,caption,text'));
  if (!chklen($caption, 2, 100)) return print errmsg('Заголовок слайда должен иметь длину от 2 до 100 символова');
  db_query("UPDATE pref_bt_slider SET caption='?1', text='?2' WHERE id='?3'", $caption, $text, $id_slide);
  $okmsg = okmsg('Слайн сохранён');
  }

 if (chkget('edit'))
  {
  $id_slide = intval($_GET['edit']);
  $res = db_query("SELECT caption, text FROM pref_bt_slider WHERE id='?1'", $id_slide);
  if ($res['cnt']<1) return print errmsg('Указанный вами слайд не существует');
  extract(db_result($res, 'h,h'));
  return print <<<HTML
<form method='POST' action='' enctype='multipart/form-data' class='wrap'>
  <input type='hidden' name='save' value='$id_slide'>
  <div id='icon-options-general' class='icon32'></div>
  <h2>Слайдер на главной &raquo; Редактирование слайда</h2>
  $okmsg
  <table>
  <tr><td>Заголовок слайда:</td><td><input type='text' size='50' name='caption' value='$caption'></td></tr>
  <tr><td>Текст слайда:</td><td><textarea rows='4' style='width:100%' name='text'>$text</textarea></td></tr>
  <tr><td colspan='2'><input type='submit' class='button-primary' value='Сохранить слайд'></td></tr>
  </table>
  <table width='0'><tr><td width='50%'><hr></td><td><nobr>[ Картинка ]</nobr></td><td width='50%'><hr></td></tr>
  <tr><td colspan='3'><img src='/wp-content/uploads/slider/$id_slide.jpg'></td></tr></table>
</form>
HTML;
  }

 if (chkget('new')) return print <<<HTML
<form method='POST' action='?page=bt_slider' enctype='multipart/form-data' class='wrap'>
  <div id='icon-options-general' class='icon32'></div>
  <h2>Слайдер на главной &raquo; Новый слайд</h2>
  $okmsg
  <table>
  <tr><td>Заголовок слайда:</td><td><input type='text' size='50' name='addslide'></td></tr>
  <tr><td>Текст слайда:</td><td><textarea rows='4' style='width:100%' name='text'></textarea></td></tr>
  <tr><td>Картинка:</td><td><input type='file' style='width:100%' name='pic'></td></tr>
  <tr><td>Уменьшить до:</td><td><input type='text' size='5' name='bt_slide_w' value='$bt_slide_w'> x <input type='text' size='5' name='bt_slide_h' value='$bt_slide_h'></td></tr>
  <tr><td colspan='2'><input type='submit' class='button-primary' value='Добавить слайд'></td></tr>
  </table>
</form>
HTML;

 if (chkpost('savepos'))
  {
  foreach ($_POST as $k=>$v) if (preg_match('/^pos([0-9+])$/', $k, $id_slide))
    db_query("UPDATE pref_bt_slider SET pos='?1' WHERE id='?2'", intval($v), intval($id_slide[1]));
  $okmsg = okmsg('Порядок отображения слайдов сохранён');
  }

 $slides = '';
 $res = db_query("SELECT id AS id_slide, pos, caption FROM pref_bt_slider ORDER BY pos, id");
 while (extract(db_result($res, 'i,i,h'))) $slides .= "<tr><td>$caption</td><td style='padding-left:6px; padding-rihgt:6px'><input type='text' name='pos$id_slide' value='$pos' size='3'</td><td>[ <a href='?page=bt_slider&edit=$id_slide'>Редактировать</a> | <a href='?page=bt_slider&del=$id_slide' onclick=\"return confirm('Вы действительно хотите удалить этот слайд?')\">Удалить</a> ]</td></tr>\n";
 if ($res['cnt']<1) $slides = "<tr><td colspan='3'><i>Нет слайдов</i></td></tr>\n";
 echo <<<HTML
<form method='POST' name='form1' action='?page=bt_slider' class='wrap'>
  <div id='icon-options-general' class='icon32'></div>
  <h2>Слайдер на главной <a href='?page=bt_slider&new' class='add-new-h2'>Новый слайд</a></h2>
  $okmsg
<form method='POST'><table style='margin-top:6px'>
<tr><th>Заголовок</th><th style='padding-left:6px; padding-rihgt:6px'>Позиция</th><th>Действие</th></tr>
$slides
<tr><td colspan='3'><hr></td></tr>
</table>
<input type='submit' class='button-primary' value='Сохранить позиции' name='savepos'>
</form>
HTML;
 }

// --------------------------------------------------------------- Благодарности

function bt_thanks()
 {
 $okmsg = '';
 $bt_thank_w = get_option('bt_thank_w', BT_THANK_W);
 $bt_thank_h = get_option('bt_thank_h', BT_THANK_H);

 if (chkget('del'))
  {
  $id_thank = intval($_GET['del']);
  db_query("DELETE FROM pref_bt_thanks WHERE id='?1'", $id_thank);
  unlink(BASEDIR . "wp-content/uploads/thanks/$id_thank.jpg");
  $okmsg = okmsg('Отзыв удалён');
  }

 if (chkpost('addthank,text,bt_thank_w,bt_thank_h'))
  {
  extract(ep('addthank>caption,text,bt_thank_w>>i,bt_thank_h>>i'));
  if (!chklen($caption, 2, 50)) return print errmsg('Имя должно иметь длину от 2 до 50 символова');
  if ($bt_thank_w<10) $bt_thank_w = BT_THANK_W;
  if ($bt_thank_h<10) $bt_thank_h = BT_THANK_H;
  update_option('bt_thank_w', $bt_thank_w);
  update_option('bt_thank_h', $bt_thank_h);
  extract(db_result(db_query("SELECT max(pos) AS pos FROM wp_bt_thanks")));
  $id_thank = db_insert_lid('bt_thanks', 0, ++$pos, $caption, $text);
  $err = '';
  if (empty($_FILES['pic']['tmp_name'])) $err = 'Файл фотографии не загружен';
  if (!$err and !is_array($ih_src=imagecreatefromfile($_FILES['pic']['tmp_name']))) $err = 'Ошибка загрузки фотографии (1)';
  if (!$err and !is_array($ih_dst=thumb($ih_src['ih'], $bt_thank_w, $bt_thank_h))) $err = 'Ошибка загрузки фотографии (2)';
//if (!$err and !is_resource($ih_dst['ih']=centrize($ih_dst['ih'], $bt_thank_w, $bt_thank_h))) $err = 'Ошибка загрузки фотографии (3)';
  if (!$err and !imagejpeg($ih_dst['ih'], BASEDIR . "wp-content/uploads/thanks/$id_thank.jpg", 90)) $err = 'Ошибка загрузки фотографии (2)';
  if ($err)
   {
   db_query("DELETE FROM pref_thanks WHERE id='?1'", $id_thank);
   return print errmsg($err);
   }
  $okmsg = okmsg('Отзыв успешно добавлен');
  }

 if (chkpost('save,caption,text'))
  {
  extract(ep('save>id_thank>i,caption,text'));
  if (!chklen($caption, 2, 100)) return print errmsg('Имя должно иметь длину от 2 до 50 символова');
  db_query("UPDATE pref_bt_thanks SET caption='?1', text='?2' WHERE id='?3'", $caption, $text, $id_thank);
  $okmsg = okmsg('Отзыв сохранён');
  }

 if (chkget('edit'))
  {
  $id_thank = intval($_GET['edit']);
  $res = db_query("SELECT caption, text FROM pref_bt_thanks WHERE id='?1'", $id_thank);
  if ($res['cnt']<1) return print errmsg('Указанный вами отзыв не существует');
  extract(db_result($res, 'h,h'));
  return print <<<HTML
<form method='POST' action='' enctype='multipart/form-data' class='wrap'>
  <input type='hidden' name='save' value='$id_thank'>
  <div id='icon-options-general' class='icon32'></div>
  <h2>Благодарности &raquo; Редактирование отзыва</h2>
  $okmsg
  <table>
  <tr><td>Имя:</td><td><input type='text' size='70' name='caption' value='$caption'></td></tr>
  <tr><td valign='top'>Отзыв:</td><td><textarea rows='4' style='width:100%' name='text'>$text</textarea></td></tr>
  <tr><td valign='top'>Фотография:&nbsp;&nbsp;</td><td><img style='border:1px solid #DDD; border-radius:3px' src='/wp-content/uploads/thanks/$id_thank.jpg'></td></tr>
  <tr><td colspan='2'><hr></td></tr>
  <tr><td colspan='2'><input type='submit' class='button-primary' value='Сохранить отзыв'></td></tr>
  </table>
</form>
HTML;
  }

 if (chkget('new')) return print <<<HTML
<form method='POST' action='?page=bt_thanks' enctype='multipart/form-data' class='wrap'>
  <div id='icon-options-general' class='icon32'></div>
  <h2>Благодарности &raquo; Новый отзыв</h2>
  $okmsg
  <table>
  <tr><td>Имя:</td><td><input type='text' size='50' name='addthank'></td></tr>
  <tr><td>Отзыв:</td><td><textarea rows='4' style='width:100%' name='text'></textarea></td></tr>
  <tr><td>Фотография:</td><td><input type='file' style='width:100%' name='pic'></td></tr>
  <tr><td>Уменьшить до:</td><td><input type='text' size='5' name='bt_thank_w' value='$bt_thank_w'> x <input type='text' size='5' name='bt_thank_h' value='$bt_thank_h'></td></tr>
  <tr><td colspan='2'><input type='submit' class='button-primary' value='Добавить отзыв'></td></tr>
  </table>
</form>
HTML;

 if (chkpost('savepos'))
  {
  foreach ($_POST as $k=>$v) if (preg_match('/^pos([0-9+])$/', $k, $id_thank))
    db_query("UPDATE pref_bt_thanks SET pos='?1' WHERE id='?2'", intval($v), intval($id_thank[1]));
  $okmsg = okmsg('Порядок отображения отзывов сохранён');
  }

 $thanks = '';
 $res = db_query("SELECT id AS id_thank, pos, caption FROM pref_bt_thanks ORDER BY pos, id");
 while (extract(db_result($res, 'i,i,h'))) $thanks .= "<tr><td>$caption</td><td style='padding-left:6px; padding-rihgt:6px'><input type='text' name='pos$id_thank' value='$pos' size='3'</td><td>[ <a href='?page=bt_thanks&edit=$id_thank'>Редактировать</a> | <a href='?page=bt_thanks&del=$id_thank' onclick=\"return confirm('Вы действительно хотите удалить этот отзыв?')\">Удалить</a> ]</td></tr>\n";
 if ($res['cnt']<1) $thanks = "<tr><td colspan='3'><i>Нет отзывов</i></td></tr>\n";
 echo <<<HTML
<form method='POST' name='form1' action='?page=bt_thanks' class='wrap'>
  <div id='icon-options-general' class='icon32'></div>
  <h2>Благодарности <a href='?page=bt_thanks&new' class='add-new-h2'>Добавить отзыв</a></h2>
  $okmsg
<form method='POST'><table style='margin-top:6px'>
<tr><th>Заголовок</th><th style='padding-left:6px; padding-rihgt:6px'>Позиция</th><th>Действие</th></tr>
$thanks
<tr><td colspan='3'><hr></td></tr>
</table>
<input type='submit' class='button-primary' value='Сохранить позиции' name='savepos'>
</form>
HTML;
 }

// ------------------------------------------------------------------ Список СМИ

function bt_media()
 {
 global $medias;
 $okmsg = '';

 if (chkget('del'))
  {
  db_query("DELETE FROM pref_bt_media WHERE id='?1'", intval($_GET['del']));
  $okmsg = okmsg('Источник информации удалён');
  }

 if (chkpost('savemedia,name,typ'))
  {
  extract(ep('savemedia>id_media>i,name,typ>>i'));
  if (!chklen($name, 2, 50)) return print errmsg('Название источника информации  должно иметь длину от 2 до 50 символов');
  if (!isset($medias[$typ])) return print errmsg('Тип источника информации  должно иметь длину от 2 до 50 символов');
  db_query("UPDATE pref_bt_media SET typ='?1', name='?2' WHERE id='?3'", $typ, $name, $id_media);
  $okmsg = okmsg('Источник информации сохранён');
  }

 if (chkget('edit'))
  {
  $id_media = intval($_GET['edit']);
  $res =db_query("SELECT typ, name FROM pref_bt_media WHERE id='?1'", $id_media);
  if ($res['cnt']<1) return print errmsg('Указанный вами источник информации не существует');
  extract(db_result($res, 'i,h'));
  $sel_medias = optlist($medias, $typ);
  return print <<<HTML
<form method='POST' action='?page=bt_media' class='wrap'><input type='hidden' name='savemedia' value='$id_media'>
  <div id='icon-options-general' class='icon32'></div>
  <h2>Список СМИ &raquo; Новый источник информации</h2>
  <table>
  <tr><td>Название:</td><td><input type='text' size='50' name='name' value='$name'></td></tr>
  <tr><td>Тип:</td><td><select name='typ'>$sel_medias</select></td></tr>
  <tr><td colspan='2'><input type='submit' class='button-primary' value='Сохранить'></td></tr>
  </table>
</form>
HTML;
  }

 if (chkpost('addmedia,typ'))
  {
  extract(ep('addmedia>id_media>i,name,typ>>i'));
  if (!chklen($name, 2, 50)) return print errmsg('Название источника информации  должно иметь длину от 2 до 50 символов');
  if (!isset($medias[$typ])) return print errmsg('Тип источника информации  должно иметь длину от 2 до 50 символов');
  if ($id_media<0) return print errmsg('Идентификатор источника информации не может быть отрицательным');
  if (extract(db_result(db_query("SELECT name AS namex FROM pref_bt_media WHERE id='?1'", $id_media), 'h'))) return print errmsg("Источник информации с идентификатором $id_media уже занят источником $namex");
  db_insert('bt_media', $id_media, $typ, $name);
  $okmsg = okmsg('Источник информации добавлен');
  }

 if (chkget('new'))
  {
  $sel_medias = optlist($medias);
  extract(db_result(db_query("SELECT max(id)+1 AS id_media FROM pref_bt_media")));
  return print <<<HTML
<form method='POST' action='?page=bt_media' class='wrap'>
  <div id='icon-options-general' class='icon32'></div>
  <h2>Список СМИ &raquo; Новый источник информации</h2>
  <table>
  <tr><td>Название:</td><td><input type='text' size='50' name='name'></td></tr>
  <tr><td>Тип:</td><td><select name='typ'>$sel_medias</select></td></tr>
  <tr><td>ID:</td><td><input type='text' name='addmedia' value='$id_media' size='3'></td></tr>
  <tr><td colspan='2'><input type='submit' class='button-primary' value='Добавить'></td></tr>
  </table>
</form>
HTML;
  }

 $media_list = '';
 $res = db_query("SELECT id AS id_media, typ, name FROM pref_bt_media ORDER BY typ, id");
 while (extract(db_result($res, 'i,i,h'))) $media_list .= "  <li>$name ($medias[$typ]) &nbsp;&nbsp;&nbsp; [ <a href='?page=bt_media&edit=$id_media'>Редактировать</a> | <a href='?page=bt_media&del=$id_media' onclick=\"return confirm('Вы действительно хотите удалить этот источник информации?')\">Удалить</a> ]</li>\n";
 echo <<<HTML
<div method='POST' class='wrap'>
  <div id='icon-options-general' class='icon32'></div>
  <h2>Список СМИ <a href='?page=bt_media&new' class='add-new-h2'>Добавить источник информации</a></h2>
  $okmsg
  <ol>
  $media_list
  </ol>
</div>
HTML;
 }

// -------------------------------------------------------- Метабоксы для постов

function bt_event_metabox($post)
 {
 $bt_event_w1 = get_option('bt_event_w1', BT_EVENT_W1);
 $bt_event_h1 = get_option('bt_event_h1', BT_EVENT_H1);
 $bt_event_w2 = get_option('bt_event_w2', BT_EVENT_W2);
 $bt_event_h2 = get_option('bt_event_h2', BT_EVENT_H2);

 $linksbig = $linksmed = '';
 if (intval(get_post_meta($post->ID, 'bt_event-big', true))) $linksbig = "<label><input type='checkbox' name='delbig'> Удалить</labell> | <a href='/wp-content/uploads/event/{$post->ID}-big.jpg' target='_blank'>Посмотреть</a>";
 if (intval(get_post_meta($post->ID, 'bt_event-med', true))) $linksmed = "<label><input type='checkbox' name='delmed'> Удалить</labell> | <a href='/wp-content/uploads/event/{$post->ID}-med.jpg' target='_blank'>Посмотреть</a>";

 echo <<<HTML
<table width='100%'>
<tr><td>Событие, большая картинка:</td><td><input type='file' name='bigpic'> (уменьшится до {$bt_event_w1}x{$bt_event_h1})</td><td align='right'>$linksbig</td></tr>
<tr><td>Событие, средняя картинка:</td><td><input type='file' name='medpic'> (уменьшится до {$bt_event_w2}x{$bt_event_h2})</td><td align='right'>$linksmed</td></tr>
</table>
HTML;
 }

function bt_fund_announce_metabox($post)
 {
 $d = intval(get_post_meta($post->ID, 'bt_fund_announce_d', true));
 $m = intval(get_post_meta($post->ID, 'bt_fund_announce_m', true));
 $days = array(0=>'<День>', 1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31);
 $mons = array(
   0  => '<Месяц>',
   1  => 'Января',
   2  => 'Февраля',
   3  => 'Марта',
   4  => 'Апреля',
   5  => 'Мая',
   6  => 'Июня',
   7  => 'Июля',
   8  => 'Августа',
   9  => 'Сентября',
   10 => 'Октября',
   11 => 'Ноября',
   12 => 'Декабря'
 );
 $days = optlist($days, $d);
 $mons = optlist($mons, $m);
 echo "Дата: <select name='bt_fund_announce_d'>$days</select> <select name='bt_fund_announce_m'>$mons</select>";
 }

function bt_opinion_matabox($post)
 {
 $bt_opinion_w1 = get_option('bt_opinion_w1', BT_OPINION_W1);
 $bt_opinion_h1 = get_option('bt_opinion_h1', BT_OPINION_H1);
 $bt_opinion = get_post_meta($post->ID, 'bt_opinion', true);
 $pic = $pic_line = '';
 if (intval(get_post_meta($post->ID, 'bt_opinionpic', true)))
  {
  $pic = "<div style='text-align:center; white-space:nowrap; padding:2px 0 0 3px'><img src='/wp-content/uploads/opinion/{$post->ID}.png'><div><label><input type='checkbox' name='opinionpic-del'> Удалить</label></div>";
  $pic_line = " style='border-right:1px dashed #DDD; padding-right:8px'";
  }
 echo <<<HTML
<table><tr>
<td width='100%'><div$pic_line><textarea name='bt_opinion' cols='60' rows='6' style='width:100%'>$bt_opinion</textarea></div></td>
<td valign='top'>$pic</td></tr></table>
Картинка: <input type='file' name='opinionpic'> (уменьшится до {$bt_opinion_w1}x{$bt_opinion_h1})
HTML;
 }

function bt_media_metabox($post)
 {
 global $medias;
 $res = db_query("SELECT id, typ, name FROM pref_bt_media ORDER BY typ, id");
 $mediaz = array(0=>'<Не выбрано>', -1=>'<Новый источник>');
 while (extract(db_result($res, 'i,i,h'))) $mediaz[$id] = "$name ($medias[$typ])";
 $bt_id_media = intval(get_post_meta($post->ID, 'bt_id_media', true));
 $sel_medias = optlist($mediaz, $bt_id_media);
 $media_types = optlist($medias);

 echo <<<HTML
<script type='text/javascript'>
function chmedia(sel)
 {
 var id = parseInt(sel.value);
 if (id==-1)
  {
  elem('new1').style.display = '';
  elem('new2').style.display = '';
  document.post.newmedia.disabled = false;
  document.post.typ.disabled = false;
  }
 else
  {
  elem('new1').style.display = 'none';
  elem('new2').style.display = 'none';
  document.post.newmedia.disabled = true;
  document.post.typ.disabled = true;
  }
 }
</script>
<table>
<tr><td>Источник информации:</td><td><select name='bt_id_media' onchange='chmedia(this)'>$sel_medias</select></td></tr>
<tr id='new1' style='display:none'><td>Название:</td><td><input type='text' name='newmedia' size='35'></td></tr>
<tr id='new2' style='display:none'><td>Тип:</td><td><select name='typ'>$media_types</select></td></tr>
</table>
HTML;
 }

function bt_postform_improve()
 {
 echo ' enctype="multipart/form-data"';
 }

function post_submitbox_improve()
 {
 global $post;
 if ($post->post_type!='page') return;
 $bt_page_breadcrumbs = intval(get_post_meta($post->ID, 'bt_page_breadcrumbs', true)) ? ' checked' : '';
 $bt_page_title = intval(get_post_meta($post->ID, 'bt_page_title', true)) ? ' checked' : '';
 echo <<<HTML
<div class='misc-pub-section'>
  <div><label><input type='checkbox' name='bt_page_breadcrumbs'$bt_page_breadcrumbs> Добавить полосу навигации</label></div>
  <div><label><input type='checkbox' name='bt_page_title'$bt_page_title> Добавить заголовок страницы</label></div>
</div>
HTML;
 }

function bt_post_saved($id_post)
 {
 global $medias;

 // --- Мнение
 $bt_opinion_h1 = get_option('bt_opinion_w1', BT_OPINION_W1);
 $bt_opinion_w1 = get_option('bt_opinion_h1', BT_OPINION_H1);
 if (empty($_POST['bt_opinion'])) delete_post_meta($id_post, 'bt_opinion');
 else update_post_meta($id_post, 'bt_opinion', stripslashes($_POST['bt_opinion']));
 if (chkpost('opinionpic-del'))
  {
  unlink(BASEDIR . "wp-content/uploads/opinion/$id_post.png");
  delete_post_meta($id_post, 'bt_opinionpic');
  }
 elseif (!empty($_FILES['opinionpic']['tmp_name']))
  if (is_array($ih_src=imagecreatefromfile($_FILES['opinionpic']['tmp_name'])))
   if (is_array($ih_dst=thumb($ih_src['ih'], $bt_opinion_w1, $bt_opinion_h1)))
    if (imagepng($ih_dst['ih'], BASEDIR . "wp-content/uploads/opinion/$id_post.png"))
     update_post_meta($id_post, 'bt_opinionpic', 1);

 // --- Событие, большая картинка
 $bt_event_w1 = get_option('bt_event_w1', BT_EVENT_W1);
 $bt_event_h1 = get_option('bt_event_h1', BT_EVENT_H1);
 if (chkpost('delbig'))
  {
  unlink(BASEDIR . "wp-content/uploads/event/$id_post-big.jpg");
  delete_post_meta($id_post, 'bt_event-big');
  }
 elseif (!empty($_FILES['bigpic']['tmp_name']))
  if (is_array($ih_src=imagecreatefromfile($_FILES['bigpic']['tmp_name'])))
   if (is_array($ih_dst=thumb($ih_src['ih'], $bt_event_w1, 0)))
    if (is_resource($ih_dst['ih']=centrize($ih_dst['ih'], $bt_event_w1, $bt_event_h1)))
     if (imagejpeg($ih_dst['ih'], BASEDIR . "wp-content/uploads/event/$id_post-big.jpg"))
      update_post_meta($id_post, 'bt_event-big', 1);

 // --- Событие, средняя картинка
 $bt_event_w2 = get_option('bt_event_w2', BT_EVENT_W2);
 $bt_event_h2 = get_option('bt_event_h2', BT_EVENT_H2);
 if (chkpost('delmed'))
  {
  unlink(BASEDIR . "wp-content/uploads/event/$id_post-med.jpg");
  delete_post_meta($id_post, 'bt_event-med');
  }
 if (!empty($_FILES['medpic']['tmp_name']))
  if (is_array($ih_src=imagecreatefromfile($_FILES['medpic']['tmp_name'])))
   if (is_array($ih_dst=thumb($ih_src['ih'], $bt_event_w2, 0)))
    if (is_resource($ih_dst['ih']=centrize($ih_dst['ih'], $bt_event_w2, $bt_event_h2)))
     if (imagejpeg($ih_dst['ih'], BASEDIR . "wp-content/uploads/event/$id_post-med.jpg"))
      update_post_meta($id_post, 'bt_event-med', 1);

 // --- Новость из СМИ
 $id_media = chkpost('bt_id_media') ? intval($_POST['bt_id_media']) : 0;
 if ($id_media==-1 and chkpost('newmedia,typ'))
  {
  extract(ep('newmedia>name,typ>>i'));
  if (chklen($name, 2, 50) and isset($medias[$typ])) $id_media = db_insert_lid('bt_media', 0, $typ, $name);
  }
 if ($id_media>0) update_post_meta($id_post, 'bt_id_media', $id_media);
 else delete_post_meta($id_post, 'bt_id_media');

 // --- Благотворительный фонд, анонс
 if (chkpost('bt_fund_announce_d,bt_fund_announce_m'))
  {
  extract(ep('bt_fund_announce_d>>i,bt_fund_announce_m>>i'));
  if ($bt_fund_announce_d>=1 and $bt_fund_announce_d<=31) update_post_meta($id_post, 'bt_fund_announce_d', $bt_fund_announce_d);
  else delete_post_meta($id_post, 'bt_fund_announce_d');
  if ($bt_fund_announce_m>=1 and $bt_fund_announce_m<=12) update_post_meta($id_post, 'bt_fund_announce_m', $bt_fund_announce_m);
  else delete_post_meta($id_post, 'bt_fund_announce_m');
  }

 // --- Параметры статической страницы
 if (chkpost('bt_page_breadcrumbs')) update_post_meta($id_post, 'bt_page_breadcrumbs', 1);
 else delete_post_meta($id_post, 'bt_page_breadcrumbs');
 if (chkpost('bt_page_title')) update_post_meta($id_post, 'bt_page_title', 1);
 else delete_post_meta($id_post, 'bt_page_title');
 }

// --------------------------------------------------------------- Инициализация

function bt_admin_menu_handler()
 {
 add_menu_page('Настройки', 'Битаров', 0, 'bt_options', 'bt_options');
 add_submenu_page('bt_options', 'СМИ', 'Список СМИ', 0, 'bt_media', 'bt_media');
 add_submenu_page('bt_options', 'Слайдер на главной', 'Слайдер на главной', 0, 'bt_slider', 'bt_slider');
 add_submenu_page('bt_options', 'Благодарности', 'Благодарности', 0, 'bt_thanks', 'bt_thanks');
 global $submenu;
 if (!empty($submenu['bt_options'][0][0]) and $submenu['bt_options'][0][0]=='Битаров') $submenu['bt_options'][0][0] = 'Настройки';
 }

function bt_metaboxes()
 {
 add_meta_box('bt_opinion_matabox', 'Мнение', 'bt_opinion_matabox', 'post');
 add_meta_box('bt_event_metabox', 'Картинки для главной страницы', 'bt_event_metabox', 'post');
 add_meta_box('bt_fund_announce_metabox', 'Благотворительный фонд, анонс', 'bt_fund_announce_metabox', 'post');
 add_meta_box('bt_media', 'Новость из СМИ', 'bt_media_metabox', 'post');
 }

function bt_shutdown()
 {
 return;
 echo "<div>";
 print_r(get_included_files());
 echo "</div>";
 }

add_action('admin_menu', 'bt_admin_menu_handler');
add_action('admin_head', 'bt_head');
add_action('edit_post', 'bt_post_saved');
add_action('add_meta_boxes', 'bt_metaboxes');
add_action('post_edit_form_tag', 'bt_postform_improve');
add_action('post_submitbox_misc_actions', 'post_submitbox_improve');
add_action('shutdown', 'bt_shutdown'); // Для тестов

?>