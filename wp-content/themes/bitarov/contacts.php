<?php
/* Template Name: Контакты */
get_header();
?>

<!-- контент -->
    <div class='content'>
    <div class='overlay'></div>
<?php
$bt_page_breadcrumbs = intval(get_post_meta($post->ID, 'bt_page_breadcrumbs', true));
$bt_page_title = intval(get_post_meta($post->ID, 'bt_page_title', true));
$page_breadcrumbs = $page_title = '';
if ($bt_page_breadcrumbs)
 {
 $current_post = $post;
 $breadcrumbs = '';
 while (true)
  {
  $link = get_permalink($current_post->ID);
  $breadcrumbs = "<span><a href='$link'>{$current_post->post_title}</a><ins class='r'></ins></span>$breadcrumbs";
  if ($current_post->post_parent<1) break;
  else $current_post = get_post($current_post->post_parent);
  }
 $breadcrumbs = "<span class='current'><a href='" . SITE_URL . "'><ins></ins>bitarov.as</a></span>$breadcrumbs";
 $page_breadcrumbs = "                    <div class='breadcrumbs'>\n                        $breadcrumbs\n                    </div>\n";
 }
if ($bt_page_title) $page_title = "                    <h2>{$post->post_title}</h2>";

if ($page_breadcrumbs or $page_title) echo <<<HTML
<div class='event-header'>
            <div class='wrap'>
                <div class='b-top-left'>
$page_breadcrumbs
$page_title
                </div>
                <div class='clear'></div>
            </div>
</div>
<div class='event-bottom-img'></div>
HTML;

?>
        <div class='wrap'>
        <div class='overLayer contacts' id='feedbackShadow' style='display:none' onclick='feedbackClose()'></div>
            <div class='contacts'>
                <div class='wrp-karta'>
                    <div class='karta'>
<!-- Этот блок кода нужно вставить в ту часть страницы, где вы хотите разместить карту (начало) -->
<div id="ymaps-map-id_1345180514674467712684"></div>
<script type="text/javascript">function fid_1345180514674467712684(ymaps) {var map = new ymaps.Map("ymaps-map-id_1345180514674467712684", {center: [104.3067226206029, 52.278715433952186], zoom: 16, type: "yandex#map"});map.controls.add("smallZoomControl");map.geoObjects.add(new ymaps.Placemark([104.30762384282879, 52.27895804140832]));};</script>
<script type="text/javascript" src="http://api-maps.yandex.ru/2.0/?coordorder=longlat&load=package.full&wizard=constructor&lang=ru-RU&onload=fid_1345180514674467712684"></script>
<!-- Этот блок кода нужно вставить в ту часть страницы, где вы хотите разместить карту (конец) -->

                    </div>
                </div>
                <div class='rekviziti'>
<?php
the_post();
the_content();
?>
                <div class="wrp-send-message">
                    <div class="send_message">
                        <img width="25" height="19" alt="" src="wp-content/themes/bitarov/images/ico/send_message.png">
                        <a href="#" onclick='return feedbackOpen()'>Оставить обращение</a><span>&darr;</span>
                        <div class='send_ok' id='send_ok'>Ваше обращение успешно отправлено</div>
                        <div class="wrp-window-comment" style="display:none" id='feedbackBox'>
                            <div class="window-comment">
                                <a class="exit" href="#" onclick='return feedbackClose()'></a>
                            <form name='feedbackform' onsubmit='return feedbackSend()'>
                            <div class="msg">
                                <textarea name="message" placeholder='Ваше обращение' onfocus="this.className='active'" onblur="this.className='idle'"></textarea>
                            </div>
                            <div class="email">
                                <input type="text" name="email" placeholder='Ваш e-mail' onfocus="this.className='active'" onblur="this.className='idle'">
                            </div>
                            <div class="name">
                                <input type="text" name="_name" placeholder='Ваше имя' onfocus="this.className='active'" onblur="this.className='idle'">
                            </div>
                            <div class="phone">
                                <input type="text" name="phone" placeholder='Ваш телефон' onfocus="this.className='active'" onblur="this.className='idle'">
                            </div>
                            <div class="clear"></div>
                            <div id="feedback-errmsg"><strong>Обнаружены ошибки:</strong></div>
                            <ol id="feedback-errors">
                              <li>Адрес e-mail указан неверно</li>
                              <li>Пожалуйста укажите номер телефона</li>
                              <li>Пожалуйста, идите нафиг</li>
                            </ol>
                            <div class="send">
                                <input type="submit" name="sendbtn" value="">
                                <input type='hidden' name='form' value='contacts'>
                            </div>
                            <img id='msg-loader' src='wp-content/themes/bitarov/images/css/feedback-loader.gif' alt='' />
                            </form>
                            </div>
                        </div>
                    </div>
            </div>
                </div>
            </div>
        </div>

    </div>
<?php get_footer(); ?>