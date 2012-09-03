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

global $media_types;
$media_types = array(
  1 => 'Газета',
  2 => 'Телеканал',
  3 => 'Информ. агентство',
  4 => 'Веб-сайт'
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

 if (chkpost('bt_event_w1,bt_event_h1,bt_opinion_h1,bt_opinion_w1,bt_opinion_cat,bt_opinion_pp,bt_liked_pp,bt_event_bigh,bt_event_bigw,bt_event_medh,bt_event_medw,bt_fund_text'))
  {
  extract(ep('bt_event_w1>>i,bt_event_h1>>i,bt_opinion_h1>>i,bt_opinion_w1>>i,bt_opinion_cat>>i,bt_opinion_pp>>i,bt_liked_pp>>i,bt_event_bigh>>i,bt_event_bigw>>i,bt_event_medh>>i,bt_event_medw>>i,bt_fund_text'));
  if ($bt_event_w1<10) $bt_event_w1 = BT_EVENT_W1;
  if ($bt_event_h1<10) $bt_event_h1 = BT_EVENT_H1;
  if ($bt_event_bigw<10) $bt_event_bigw = BT_EVENT_BIGW;
  if ($bt_event_bigh<10) $bt_event_bigh = BT_EVENT_BIGH;
  if ($bt_event_medw<10) $bt_event_medw = BT_EVENT_MEDW;
  if ($bt_event_medh<10) $bt_event_medh = BT_EVENT_MEDH;
  if ($bt_opinion_h1<10) $bt_opinion_h1 = BT_OPINION_W1;
  if ($bt_opinion_w1<10) $bt_opinion_w1 = BT_OPINION_H1;
  if ($bt_opinion_pp<1) $bt_opinion_pp = 5;
  if ($bt_liked_pp<1) $bt_liked_pp = 5;
  update_option('bt_event_w1', $bt_event_w1);
  update_option('bt_event_h1', $bt_event_h1);
  update_option('bt_event_bigw', $bt_event_bigw);
  update_option('bt_event_bigh', $bt_event_bigh);
  update_option('bt_event_medw', $bt_event_medw);
  update_option('bt_event_medh', $bt_event_medh);
  update_option('bt_opinion_w1', $bt_opinion_w1);
  update_option('bt_opinion_h1', $bt_opinion_h1);
  update_option('bt_opinion_cat', $bt_opinion_cat);
  update_option('bt_opinion_pp', $bt_opinion_pp);
  update_option('bt_liked_pp', $bt_liked_pp);
  update_option('bt_fund_text', $bt_fund_text);
  set_user_setting('urlbutton', 'none');
  $okmsg = okmsg('Настройки сохранены');
  }

 $bt_event_w1 = get_option('bt_event_w1', BT_EVENT_W1);
 $bt_event_h1 = get_option('bt_event_h1', BT_EVENT_H1);
 $bt_event_bigw = get_option('bt_event_bigw', BT_EVENT_BIGW);
 $bt_event_bigh = get_option('bt_event_bigh', BT_EVENT_BIGH);
 $bt_event_medw = get_option('bt_event_medw', BT_EVENT_MEDW);
 $bt_event_medh = get_option('bt_event_medh', BT_EVENT_MEDH);
 $bt_opinion_h1 = get_option('bt_opinion_w1', BT_OPINION_W1);
 $bt_opinion_w1 = get_option('bt_opinion_h1', BT_OPINION_H1);
 $bt_opinion_cat = get_option('bt_opinion_cat', 1);
 $bt_opinion_pp = get_option('bt_opinion_pp', 5);
 $bt_liked_pp = get_option('bt_liked_pp', 5);
 $bt_fund_text = htmltext(get_option('bt_fund_text'));

 $cats_arr = get_categories(array('hide_empty'=>0));
 $cats = '';
 foreach ($cats_arr as $cat) $cats .= "<option value='" . intval($cat->term_id) . "'".($cat->term_id==$bt_opinion_cat ? ' selected' : '').">" . htmltext($cat->name) . "</option>";

 return print <<<HTML
<form method='POST' name='form1' action='' class='wrap'>
  <div id='icon-options-general' class='icon32'></div>
  <h2>Настройки</h2>
  $okmsg
  <table style='margin-top:6px'>
  <tr><td>Оригинальная картинка события, ширина:</td><td><input type='text' name='bt_event_w1' size='5' value='$bt_event_w1'> px</td></tr>
  <tr><td>Оригинальная картинка события, высота:</td><td><input type='text' name='bt_event_h1' size='5' value='$bt_event_h1'> px</td></tr>
  <tr><td>Большая картинка события, ширина:</td><td><input type='text' name='bt_event_bigw' size='5' value='$bt_event_bigw'> px</td></tr>
  <tr><td>Большая картинка события, высота:</td><td><input type='text' name='bt_event_bigh' size='5' value='$bt_event_bigh'> px</td></tr>
  <tr><td>Средняя картинка события, ширина:</td><td><input type='text' name='bt_event_medw' size='5' value='$bt_event_medw'> px</td></tr>
  <tr><td>Средняя картинка события, высота:</td><td><input type='text' name='bt_event_medh' size='5' value='$bt_event_medh'> px</td></tr>
  <tr><td>Мнение, ширина картинки:</td><td><input type='text' name='bt_opinion_h1' size='5' value='$bt_opinion_h1'> px</td></tr>
  <tr><td>Мнение, высота картинки:</td><td><input type='text' name='bt_opinion_w1' size='5' value='$bt_opinion_w1'> px</td></tr>
  <tr><td>Мнение, рубрика:</td><td><select name='bt_opinion_cat'>$cats</select></td></tr>
  <tr><td>Мнение, заголовков на главной:</td><td><input type='text' name='bt_opinion_pp' size='5' value='$bt_opinion_pp'></td></tr>
  <tr><td>Число похожих записей:</td><td><input type='text' name='bt_liked_pp' size='5' value='$bt_liked_pp'></td></tr>
  <tr><td colspan='2'>
    Благотворительный фонд, аннотация (HTML):<br>
    <textarea rows='6' cols='80' name='bt_fund_text' style='width:100%'>$bt_fund_text</textarea>
  </td></tr>
  <tr><td colspan='2'><input type='submit' class='button-primary' name='submitbtn' value='Сохранить настройки'></td></tr>
  </table>

  <!--
  <div style='margin-top:10px; padding-top:4px; border-top:1px dotted #AAA'>
  <input type='button' class='button' value='Проверить года' onclick='rebuild_years(this)'> - эта функция заново составляет список годов всех записей имеющихся на сайте. Выполнение операции может занять длительное время (1-5 минут) в зависимости от размера базы данных сайта. Функция выполняется автоматически 1 января каждого года.
  </div>
  -->
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
  unlink(BASEDIR . "wp-content/uploads/thanks/$id_thank.png");
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
  if (!$err and !imagepng($ih_dst['ih'], BASEDIR . "wp-content/uploads/thanks/$id_thank.png")) $err = 'Ошибка загрузки фотографии (2)';
  if ($err)
   {
   db_query("DELETE FROM pref_thanks WHERE id='?1'", $id_thank);
   return print errmsg($err);
   }
  $okmsg = okmsg('Отзыв успешно добавлен');
  }

 if (chkpost('save,caption,text,bt_thank_h,bt_thank_w'))
  {
  extract(ep('save>id_thank>i,caption,text,bt_thank_h>>i,bt_thank_w>>i'));
  if (!chklen($caption, 2, 100)) return print errmsg('Имя должно иметь длину от 2 до 50 символова');
  db_query("UPDATE pref_bt_thanks SET caption='?1', text='?2' WHERE id='?3'", $caption, $text, $id_thank);
  if ($bt_thank_w<10) $bt_thank_w = BT_THANK_W;
  if ($bt_thank_h<10) $bt_thank_h = BT_THANK_H;
  update_option('bt_thank_w', $bt_thank_w);
  update_option('bt_thank_h', $bt_thank_h);
  $err = '';
  if (!empty($_FILES['pic']['tmp_name']))
   {
   if (!$err and !is_array($ih_src=imagecreatefromfile($_FILES['pic']['tmp_name']))) $err = 'Ошибка загрузки фотографии (1)';
   if (!$err and !is_array($ih_dst=thumb($ih_src['ih'], $bt_thank_w, $bt_thank_h))) $err = 'Ошибка загрузки фотографии (2)';
   //if (!$err and !is_resource($ih_dst['ih']=centrize($ih_dst['ih'], $bt_thank_w, $bt_thank_h))) $err = 'Ошибка загрузки фотографии (3)';
   if (!$err and !imagepng($ih_dst['ih'], BASEDIR . "wp-content/uploads/thanks/$id_thank.png")) $err = 'Ошибка загрузки фотографии (2)';
   }
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
  <tr><td valign='top'>Фотография:&nbsp;&nbsp;</td><td><img style='border:1px solid #DDD; border-radius:3px' src='/wp-content/uploads/thanks/$id_thank.png'></td></tr>
  <tr><td>Новая фотография:</td><td><input type='file' style='width:100%' name='pic'></td></tr>
  <tr><td>Уменьшить до:</td><td><input type='text' size='5' name='bt_thank_w' value='$bt_thank_w'> x <input type='text' size='5' name='bt_thank_h' value='$bt_thank_h'></td></tr>
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
 global $media_types;
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
  if (!isset($media_types[$typ])) return print errmsg('Тип источника информации  указан неверно');
  db_query("UPDATE pref_bt_media SET typ='?1', name='?2' WHERE id='?3'", $typ, $name, $id_media);
  $okmsg = okmsg('Источник информации сохранён');
  }

 if (chkget('edit'))
  {
  $id_media = intval($_GET['edit']);
  $res =db_query("SELECT typ, name FROM pref_bt_media WHERE id='?1'", $id_media);
  if ($res['cnt']<1) return print errmsg('Указанный вами источник информации не существует');
  extract(db_result($res, 'i,h'));
  $sel_medias = optlist($media_types, $typ);
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
  if (!chklen($name, 2, 50)) return print errmsg('Название источника информации должно иметь длину от 2 до 50 символов');
  if (!isset($media_types[$typ])) return print errmsg('Тип источника информации указан неверно');
  if ($id_media<0) return print errmsg('Идентификатор источника информации не может быть отрицательным');
  if (extract(db_result(db_query("SELECT name AS namex FROM pref_bt_media WHERE id='?1'", $id_media), 'h'))) return print errmsg("Источник информации с идентификатором $id_media уже занят источником $namex");
  db_insert('bt_media', $id_media, $typ, $name);
  $okmsg = okmsg('Источник информации добавлен');
  }

 if (chkget('new'))
  {
  $sel_types = optlist($media_types);
  extract(db_result(db_query("SELECT max(id)+1 AS id_media FROM pref_bt_media")));
  return print <<<HTML
<form method='POST' action='?page=bt_media' class='wrap'>
  <div id='icon-options-general' class='icon32'></div>
  <h2>Список СМИ &raquo; Новый источник информации</h2>
  <table>
  <tr><td>Название:</td><td><input type='text' size='50' name='name'></td></tr>
  <tr><td>Тип:</td><td><select name='typ'>$sel_types</select></td></tr>
  <tr><td>ID:</td><td><input type='text' name='addmedia' value='$id_media' size='3'></td></tr>
  <tr><td colspan='2'><input type='submit' class='button-primary' value='Добавить'></td></tr>
  </table>
</form>
HTML;
  }

 $media_list = '';
 $res = db_query("SELECT id AS id_media, typ, name FROM pref_bt_media ORDER BY typ, id");
 while (extract(db_result($res, 'i,i,h'))) $media_list .= "  <li>$name ($media_types[$typ]) &nbsp;&nbsp;&nbsp; [ <a href='?page=bt_media&edit=$id_media'>Редактировать</a> | <a href='?page=bt_media&del=$id_media' onclick=\"return confirm('Вы действительно хотите удалить этот источник информации?')\">Удалить</a> ]</li>\n";
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

// ------------------------------------------- Область видимости картинки (crop)

function bt_crop()
 {
 $id_post = intval($_GET['bt_crop']);
 $srcsize = get_post_meta($id_post, 'bt_eventimg', true);
 if (!$srcsize) die("Картинка с таким идентификатором поста не найдена");
 $bigw = get_option('bt_event_bigw', BT_EVENT_BIGW);
 $bigh = get_option('bt_event_bigh', BT_EVENT_BIGH);
 $medw = get_option('bt_event_medw', BT_EVENT_MEDW);
 $medh = get_option('bt_event_medh', BT_EVENT_MEDH);
 $bigk = round($bigw/$bigh, 3);
 $medk = round($medw/$medh, 3);
 $bigcrop = get_post_meta($id_post, 'bt_eventbig', true);
 $medcrop = get_post_meta($id_post, 'bt_eventmed', true);
 $bigcrop = '[' . (is_array($bigcrop) ? implode(',',$bigcrop) : "0,0,$bigw,$bigh") . ']';
 $medcrop = '[' . (is_array($medcrop) ? implode(',',$medcrop) : "0,0,$medw,$medh") . ']';
 $bigscale = get_post_meta($id_post, 'bt_eventbig-scale', true);
 $medscale = get_post_meta($id_post, 'bt_eventmed-scale', true);
 $bigscale = ($bigscale==='') ? 1: intval($bigscale);
 $medscale = ($medscale==='') ? 1: intval($medscale);

 echo <<<HTML
<link rel='stylesheet' href='../wp-content/themes/bitarov/jquery.Jcrop.css' type='text/css' />
<script src='../wp-content/themes/bitarov/js/jquery.min.js'></script>
<script src='../wp-content/themes/bitarov/js/jquery.Jcrop.min.js'></script>

<style type='text/css'>
html, head {padding-top:0 !important; min-width:100%; min-height:100%}
#topmenu {border-bottom: 1px solid #DDD; padding:4px 0 0 15px; background:#F8F8F8; background:-o-linear-gradient(top,#F8F8F8, #EEE); font-size:13px; overflow:hidden; height:22px; position:fixed; z-index:1000; width:100%}
#topmenu span {float:left}
#topmenu label {float:right; margin:2px 27px 0 0;}
table {width:100%; height:100%; border-collapse:collapse}
table td {padding:0; text-align:center}
.center {width:$srcsize[0]px; height:$srcsize[1]px; margin:0 auto}
#saving_span {display:none; float:none !important}
</style>

<script type='text/javascript'>
id_post = $id_post;

bigcrop = $bigcrop;
medcrop = $medcrop;
bigscale = $bigscale;
medscale = $medscale;
saving = false;

bigw = $bigw;
bigh = $bigh;
medw = $medw;
medh = $medh;
bigk = $bigk;
medk = $medk;
selected = function(){}

function elem(id) {return document.getElementById(id)}
function coord_big(c) {bigcrop=[c.x,c.y,c.x2,c.y2]}
function coord_med(c) {medcrop=[c.x,c.y,c.x2,c.y2]}
function set_api() {crop_api=this}

function bigpic(setscale)
 {
 if (setscale) bigscale = elem('scalable').checked;
 else elem('scalable').checked = bigscale;
 var opt = {setSelect:bigcrop, onChange:coord_big, onSelect:coord_big}
 if (bigscale) {opt.aspectRatio=$bigk, opt.minSize=[$bigw,$bigh]}
 else {opt.aspectRatio=false; opt.minSize=[$bigw,100]}
 if (crop_api) crop_api.destroy();
 $('#cropimg').Jcrop(opt, set_api);
 $('#topmenu a').css('font-weight', 'normal');
 $('#biglink').css('font-weight', 'bold');
 selected = bigpic;
 return false;
 }

function medpic(setscale)
 {
 if (setscale) medscale = elem('scalable').checked;
 else elem('scalable').checked = medscale;
 var opt = {setSelect:medcrop, onChange:coord_med, onSelect:coord_med}
 if (medscale) {opt.aspectRatio=$medk, opt.minSize=[$medw,$medh]}
 else {opt.aspectRatio=false; opt.minSize=[$medw,100]}
 if (crop_api) crop_api.destroy();
 $('#cropimg').Jcrop(opt, set_api);
 $('#topmenu a').css('font-weight', 'normal');
 $('#medlink').css('font-weight', 'bold');
 selected = medpic;
 return false;
 }

function savecrop()
 {
 if (saving) return false;
 saving = true;
 $('#saving_span').css('display', 'inline');
 var url = 'index.php?bt_savecrop=' + id_post;
 url += '&bigx='  + bigcrop[0];
 url += '&bigy='  + bigcrop[1];
 url += '&bigx2=' + bigcrop[2];
 url += '&bigy2=' + bigcrop[3];
 url += '&medx='  + medcrop[0];
 url += '&medy='  + medcrop[1];
 url += '&medx2=' + medcrop[2];
 url += '&medy2=' + medcrop[3];
 url += '&bigscale=' + bigscale;
 url += '&medscale=' + medscale;
 //alert(url);
 httpget(url);
 window.close();
 return false;
 }

function httpget(url, callback)
 {
 var xhr, result;
 if (window.XMLHttpRequest) xhr = new XMLHttpRequest();
 else xhr = new ActiveXObject("Microsoft.XMLHTTP");
 if (callback)
  {
  xhr.cbfunc = callback;
  xhr.onreadystatechange = function () {if (this.readyState==4 && typeof(this.cbfunc)=='function') this.cbfunc(this.responseText, this)};
  xhr.open('GET', url, true);
  xhr.send(null);
  return true;
  }
 xhr.open('GET', url, false);
 xhr.send(null);
 if ((xhr.status<200) || (xhr.status>299)) result = false;
 else result = xhr.responseText;
 delete xhr;
 return result;
 }

$(window).ready(function(){
  window.crop_api = false;
  bigpic();
});
</script>

</head>
<body>

<div id='topmenu'>
  <span>
    [ <a href='#' onclick='return bigpic()' id='biglink'>Большая картинка</a>
    | <a href='#' onclick='return medpic()' id='medlink'>Средняя картинка</a>
    | <a href='#' onclick='return savecrop()'>Сохранить и закрыть</a>
    ] <span id='saving_span'>Сохранение области видимости...</span></span>
  <label><input type='checkbox' id='scalable' onclick='selected(true)'> Пропорционально</label>
</div>
<table><tr><td>
  <div class='center'><img src='../wp-content/uploads/event/$id_post-src.png' id='cropimg'></div>
</td></tr></table>
</body></html>
HTML;
 exit;
 }

function bt_savecrop()
 {
 extract(eg('bt_savecrop>id_post>i,bigx>>i,bigy>>i,bigx2>>i,bigy2>>i,medx>>i,medy>>i,medx2>>i,medy2>>i,bigscale>>i,medscale>>i'));
 if (!file_exists(BASEDIR . "wp-content/uploads/event/$id_post-src.png")) die("$id_post-src.png not exists");
 is_array($ih_src=imagecreatefromfile(BASEDIR . "wp-content/uploads/event/$id_post-src.png")) or die('cant parse image file as png');
 // Большая картинка
 $new_w = $bigx2 - $bigx;
 $new_h = $bigy2 - $bigy;
 if ($new_w<10) die('wrong bigX coordinates');
 if ($new_h<10) die('wrong bigY coordinates');
 $bt_event_bigw = get_option('bt_event_bigw', BT_EVENT_BIGW);
 $ih_dst = imagecreatetruecolor($new_w, $new_h);
 imagecopyresampled($ih_dst, $ih_src['ih'], 0, 0, $bigx, $bigy, $new_w, $new_h, $new_w, $new_h);
 $ih_dst = thumb($ih_dst, $bt_event_bigw, 0);
 imagejpeg($ih_dst['ih'], BASEDIR . "wp-content/uploads/event/$id_post-big.jpg", 90);
 update_post_meta($id_post, 'bt_eventbig', array($bigx, $bigy, $bigx2, $bigy2));
 update_post_meta($id_post, 'bt_eventbig-scale', $bigscale ? 1 : 0);
 // Средняя картинка
 $new_w = $medx2 - $medx;
 $new_h = $medy2 - $medy;
 if ($new_w<10) die('wrong medX coordinates');
 if ($new_h<10) die('wrong medY coordinates');
 $bt_event_medw = get_option('bt_event_medw', BT_EVENT_MEDW);
 $ih_dst = imagecreatetruecolor($new_w, $new_h);
 imagecopyresampled($ih_dst, $ih_src['ih'], 0, 0, $medx, $medy, $new_w, $new_h, $new_w, $new_h);
 $ih_dst = thumb($ih_dst, $bt_event_medw, 0);
 imagejpeg($ih_dst['ih'], BASEDIR . "wp-content/uploads/event/$id_post-med.jpg", 90);
 update_post_meta($id_post, 'bt_eventmed', array($medx, $medy, $medx2, $medy2));
 update_post_meta($id_post, 'bt_eventmed-scale', $medscale ? 1 : 0);
 // Всё пучком
 die('ok');
 }

// -------------------------------------------------------- Метабоксы для постов

function bt_event_metabox($post)
 {
 $bt_event_w1 = get_option('bt_event_w1', BT_EVENT_W1);
 $bt_event_h1 = get_option('bt_event_h1', BT_EVENT_H1);
 $bt_eventimg = get_post_meta($post->ID, 'bt_eventimg', true);
 $croplink = '';
 if ($bt_eventimg) $croplink = "<div style='margin-bottom:4px; font-weight:bold'>Есть картинка размером $bt_eventimg[0]x$bt_eventimg[1]. <a href='index.php?bt_crop={$post->ID}' target='_blank'>Выбрать область видимости</a></div>
 <div style='margin-bottom:4px'><label><input type='checkbox' name='deleventpic'> Удалить при сохранении записи</label></div>";

 //if (intval(get_post_meta($post->ID, 'bt_event-big', true))) $linksbig = "<label><input type='checkbox' name='delbig'> Удалить</labell> | <a href='/wp-content/uploads/event/{$post->ID}-big.jpg' target='_blank'>Посмотреть</a>";
 //if (intval(get_post_meta($post->ID, 'bt_event-med', true))) $linksmed = "<label><input type='checkbox' name='delmed'> Удалить</labell> | <a href='/wp-content/uploads/event/{$post->ID}-med.jpg' target='_blank'>Посмотреть</a>";

 echo <<<HTML
$croplink
Новая картинка: <input type='file' size='40' name='eventpic'> (уменьшится до {$bt_event_w1}x{$bt_event_h1})
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
 $bt_opinionpic = get_post_meta($post->ID, 'bt_opinionpic', true);
 $pic = $pic_line = '';
 $pics = "<option value=''>&lt;Не выбрано&gt;</option><option value='new'>&lt;Новая&gt;</option>";
 foreach (scandir(BASEDIR . 'wp-content/uploads/opinion/') as $node) if ($node!='.' and $node!='..' and is_file(BASEDIR . "wp-content/uploads/opinion/$node"))
   $pics .= "<option" . ($node==$bt_opinionpic ? ' selected' : '') . ">" . htmltext($node) . "</option>";
 echo <<<HTML
<table><tr>
<td width='100%'><div id='opinionborder'><textarea name='bt_opinion' cols='60' rows='6' style='width:100%'>$bt_opinion</textarea></div></td>
<td valign='top' id='opinion-img'>$pic</td></tr></table>
<table>
<tr><td>Картинка:</td><td><select name='opinionpic' id='opinionpic' onchange='opinionpic_select()'>$pics</select></td><tr>
<tr id='newpic1'><td>Файл:</td><td><input type='file' name='opinionfile' size='30'> (уменьшится до {$bt_opinion_w1}x{$bt_opinion_h1})</td></tr>
<tr id='newpic2'><td>Имя файла картинки:</td><td><input type='text' name='opinionfilename' size='30'> .png</td></tr>
</table>

<script type='text/javascript'>
function opinionpic_select()
 {
 var pic = document.getElementById('opinionpic').value;
 var display = '';
 var imgview = '';
 var style = '';
 if (pic=='new') imgview = '';
 else if (pic)
  {
  display = 'none';
  style = 'border-right:1px dashed #DDD; padding-right:8px';
  imgview = "<div style='text-align:center; white-space:nowrap; padding:2px 0 0 3px'><img src='/wp-content/uploads/opinion/" + pic + "'><br><label><input type='checkbox' name='opinionpic-del'> Удалить</label></div>";
  }
 else display='none';
 document.getElementById('opinion-img').innerHTML = imgview;
 document.getElementById('opinionborder').style = style;
 document.getElementById('newpic1').style.display = display;
 document.getElementById('newpic2').style.display = display;
 }
opinionpic_select();
</script>

HTML;
 }

function bt_media_metabox($post)
 {
 global $media_types;
 $res = db_query("SELECT id, typ, name FROM pref_bt_media ORDER BY typ, id");
 $mediaz = array(0=>'<Не выбрано>', -1=>'<Новый источник>');
 while (extract(db_result($res, 'i,i,h'))) $mediaz[$id] = "$name ($media_types[$typ])";
 $bt_id_media = intval(get_post_meta($post->ID, 'bt_id_media', true));
 $sel_medias = optlist($mediaz, $bt_id_media);
 $media_types = optlist($media_types);
 $bt_youtube_id = htmltext(get_post_meta($post->ID, 'bt_youtube_id', true));
 $youtube_link = $bt_youtube_id ? "http://www.youtube.com/watch?v=$bt_youtube_id" : '';

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
<tr><td>Ссылка Youtube:</td><td><input type='text' name='youtube_link' value='$youtube_link' size='55'></td></tr>
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
 if (!empty($_POST['opinionpic']))
  {
  $opinionpic = ffilt($_POST['opinionpic']);
  if (file_exists(BASEDIR . "wp-content/uploads/opinion/$opinionpic"))
    if (chkpost('opinionpic-del'))
      {unlink(BASEDIR . "wp-content/uploads/opinion/$opinionpic");
      delete_post_meta($id_post, 'bt_opinionpic');}
    else update_post_meta($id_post, 'bt_opinionpic', $opinionpic);
  }
 elseif (!empty($_FILES['opinionfile']['tmp_name']))
  {
  $filename = empty($_POST['opinionfilename']) ? '' : $_POST['opinionfilename'];
  if (!$filename and !empty($_POST['opinionfile']['name'])) $filename = fname($_POST['opinionfile']['name']);
  if (!$filename) $filename = keygen(8);
  $filename = contrive(BASEDIR . 'wp-content/uploads/opinion/', "$filename.png");
  if (is_array($ih_src=imagecreatefromfile($_FILES['opinionfile']['tmp_name'])))
   if (is_array($ih_dst=thumb($ih_src['ih'], $bt_opinion_w1, $bt_opinion_h1)))
    if (imagepng($ih_dst['ih'], $filename))
     update_post_meta($id_post, 'bt_opinionpic', basename($filename));
  }
 else delete_post_meta($id_post, 'bt_opinionpic');

 // --- Картинка события
 $bt_event_w1 = get_option('bt_event_w1', BT_EVENT_W1);
 $bt_event_h1 = get_option('bt_event_h1', BT_EVENT_H1);
 $bigw = get_option('bt_event_bigw', BT_EVENT_BIGW);
 $bigh = get_option('bt_event_bigh', BT_EVENT_BIGH);
 $medw = get_option('bt_event_medw', BT_EVENT_MEDW);
 $medh = get_option('bt_event_medh', BT_EVENT_MEDH);
 if (chkpost('deleventpic'))
  {
  unlink(BASEDIR . "wp-content/uploads/event/$id_post-src.png");
  unlink(BASEDIR . "wp-content/uploads/event/$id_post-big.jpg");
  unlink(BASEDIR . "wp-content/uploads/event/$id_post-med.jpg");
  delete_post_meta($id_post, 'bt_eventimg');
  delete_post_meta($id_post, 'bt_eventbig');
  delete_post_meta($id_post, 'bt_eventmed');
  delete_post_meta($id_post, 'bt_eventbig-scale');
  delete_post_meta($id_post, 'bt_eventmed-scale');
  }
 elseif (!empty($_FILES['eventpic']['tmp_name']))
  if (is_array($ih_src=imagecreatefromfile($_FILES['eventpic']['tmp_name'])))
    if (is_array($ih_dst=thumb($ih_src['ih'], $bt_event_w1, $bt_event_h1)))
     if ($ih_dst['w']>=$bigw and $ih_dst['w']>=$medw and $ih_dst['h']>=$bigh and $ih_dst['h']>=$medh)
      if (imagepng($ih_dst['ih'], BASEDIR . "wp-content/uploads/event/$id_post-src.png"))
       {
       update_post_meta($id_post, 'bt_eventimg', array($ih_dst['w'], $ih_dst['h']));
       $big = $med = false;
       // Сохраняем большую картинку
       $by_width = thumb($ih_src['ih'], $bigw, 0);
       $ih_big = imagecreatetruecolor($bigw, $bigh);
       if (imagecopyresampled($ih_big, $by_width['ih'], 0, 0, 0, intval(($by_width['h']-$bigh)/2), $bigw, $bigh, $bigw, $bigh))
        if (imagejpeg($ih_big, BASEDIR . "wp-content/uploads/event/$id_post-big.jpg", 90)) $big = true;
       // Сохраняем среднюю картинку
       $by_width = thumb($ih_src['ih'], $medw, 0);
       $ih_med = imagecreatetruecolor($medw, $medh);
       if (imagecopyresampled($ih_med, $by_width['ih'], 0, 0, 0, intval(($by_width['h']-$medh)/2), $medw, $medh, $medw, $medh))
        if (imagejpeg($ih_med, BASEDIR . "wp-content/uploads/event/$id_post-med.jpg", 90)) $med = true;
       update_post_meta($id_post, 'bt_eventbig', true);
       update_post_meta($id_post, 'bt_eventmed', true);
       }

 // --- Новость из СМИ
 $id_media = chkpost('bt_id_media') ? intval($_POST['bt_id_media']) : 0;
 if ($id_media==-1 and chkpost('newmedia,typ'))
  {
  extract(ep('newmedia>name,typ>>i'));
  if (chklen($name, 2, 50) and isset($medias[$typ])) $id_media = db_insert_lid('bt_media', 0, $typ, $name);
  }
 if ($id_media>0) update_post_meta($id_post, 'bt_id_media', $id_media);
 else delete_post_meta($id_post, 'bt_id_media');
 // Youtube ↓
 $bt_youtube_id = '';
 if (chkpost('youtube_link'))
  {
  $youtube_link = stripslashes($_POST['youtube_link']);
  if (preg_match('/^(https?\:\/\/)?(www\.)?youtube\.com\/.*[\?\&]v\=([a-z0-9\_\.\-\%]{8,16})(\&|$)/i', $youtube_link, $m)) $bt_youtube_id = $m[3];
  elseif (preg_match('/^(https?\:\/\/)?(www\.)?youtu\.be\/([a-z0-9\_\.\-\%]{8,16})$/i', $youtube_link, $m)) $bt_youtube_id = $m[3];
  elseif (preg_match('/^(https?\:\/\/)?(www\.)?youtube\.com\/embed\/([a-z0-9\_\.\-\%]{8,16})$/i', $youtube_link, $m)) $bt_youtube_id = $m[3];
  elseif (preg_match('/^[a-z0-9\_\.\-\%]{8,16}$/i', $youtube_link, $m)) $bt_youtube_id = $m[0];
  }
 if ($bt_youtube_id) update_post_meta($id_post, 'bt_youtube_id', $bt_youtube_id);
 else delete_post_meta($id_post, 'bt_youtube_id');

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
 add_menu_page('Настройки', 'Надстройки CMS', 0, 'bt_options', 'bt_options');
 add_submenu_page('bt_options', 'СМИ', 'Список СМИ', 0, 'bt_media', 'bt_media');
 add_submenu_page('bt_options', 'Слайдер на главной', 'Слайдер на главной', 0, 'bt_slider', 'bt_slider');
 add_submenu_page('bt_options', 'Благодарности', 'Благодарности', 0, 'bt_thanks', 'bt_thanks');
 global $submenu;
 if (!empty($submenu['bt_options'][0][0]) and $submenu['bt_options'][0][0]=='Надстройки CMS') $submenu['bt_options'][0][0] = 'Настройки';
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
if (chkget('bt_crop')) add_action('admin_head', 'bt_crop', 1000);
if (chkget('bt_savecrop,bigx,bigy,bigx2,bigy2,medx,medy,medx2,medy2,bigscale,medscale')) bt_savecrop();
add_action('shutdown', 'bt_shutdown'); // Для тестов

?>