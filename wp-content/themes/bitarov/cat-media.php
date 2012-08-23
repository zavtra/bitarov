<?php
get_header();

// --- Хлебные крошки
$breadcrumbs = breadcrumbs_category($current_category_id);

// --------------------------------------------------------------- Список постов
$res = db_query("SELECT id, name FROM pref_bt_media ORDER BY typ, id");
$mediaz = array();
while (extract(db_result($res, 'i,h'))) $mediaz[$id] = $name;
$posts_list = $video_list = '';
for ($j=1; ($j<=6 and have_posts()); $j++)
 {
 the_post();
 $post_title = get_the_title();
 $post_excerpt = get_the_excerpt(); // аннотация
 $post_link = get_permalink($post->ID);
 $post_date = rusdate('j F Y', strtotime($post->post_date));
 $post_info = array();
 $bt_youtube_id = htmltext(get_post_meta($post->ID, 'bt_youtube_id', true));
 if ($bt_youtube_id)
   {$icon = 'avi';
   $link_more = "<a href='javascript:watchmedia({$post->ID})' class='video-more'><span>смотреть видео</span></a>";}
 else
   {$icon = 'txt';
   $link_more = "<a href='$post_link' class='read-more'>читать далее</a>";}
 $bt_id_media = intval(get_post_meta($post->ID, 'bt_id_media', true));
 if (isset($mediaz[$bt_id_media])) $post_info[] = $mediaz[$bt_id_media];
 $post_info[] = $post_date;
 $post_info = implode(', ', $post_info);
 $posts_list .= <<<HTML
                <div class='block'>
                    <div class='blocklimiter'>
                      <h3><a href='$post_link'>$post_title</a></h3>
                      <div class='depiction'><span class='$icon'>$post_info</span></div>
                      <p>$post_excerpt</p>
                    </div>
                    $link_more
                </div>
HTML;

 if (!$bt_youtube_id) continue;

 $video_list = <<<HTML
                <div class='video-window' id='video-{$post->ID}' style='display:none'>
                    <a href='#' class='exit' onclick='return mediaWindowSetClose()'></a>
                    <div class='video-left_b'>
                        <img src="wp-content/themes/bitarov/images/slider/bitarov_video.png" />
                    </div>
                    <div class='wrp-text-right_b'>
                        <div class='text-right_b'>
                            <div class='scroll-pane'>
                                <div class='padding'>
                                    <h1>День памяти и скорби</h1>
                                    <div class='date'>добавлено 05.06.2012</div>
                                    <p>В канун дня памяти и скорби торжественный вечер для
                                    ветеранов, совместно с администрацией округа, организовал
                                    фонд поддержки гражданских инициатив Александра Битарова.</p>
                                    <p>В канун дня памяти и скорби торжественный вечер для
                                    ветеранов, совместно с администрацией округа, организовал
                                    фонд поддержки гражданских инициатив Александра Битарова.</p>
                                    <p>В канун дня памяти и скорби торжественный вечер для
                                    ветеранов, совместно с администрацией округа, организовал
                                    фонд поддержки гражданских инициатив Александра Битарова.</p>
                                    <p>В канун дня памяти и скорби торжественный вечер для
                                    ветеранов, совместно с администрацией округа, организовал
                                    фонд поддержки гражданских инициатив Александра Битарова.</p>
                                    <p>В канун дня памяти и скорби торжественный вечер для
                                    ветеранов, совместно с администрацией округа, организовал
                                    фонд поддержки гражданских инициатив Александра Битарова.</p>
                                    <p>В канун дня памяти и скорби торжественный вечер для
                                    ветеранов, совместно с администрацией округа, организовал
                                    фонд поддержки гражданских инициатив Александра Битарова.</p>
                                    <p>В канун дня памяти и скорби торжественный вечер для
                                    ветеранов, совместно с администрацией округа, организовал
                                    фонд поддержки гражданских инициатив Александра Битарова.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class='clear'></div>
                </div>
HTML;

 }

// ------------------------------------------------------------------- Пагинатор
$paginator = '';
if ($category_paginagor)
 {
 foreach ($category_paginagor as $page_number)
   if ($page_number==$current_page_number) $paginator .= "                        <li><a class='current' href='$current_cat_link/{$uri_year}page/$page_number/'>$page_number</a>\n";
   else $paginator .= "                        <li><a href='$current_cat_link/{$uri_year}page/$page_number/'>$page_number</a>\n";
 $paginator = <<<HTML
                <div class="paginator">
                    <ul>
$paginator
                        <!--<li><span><a href="#">Раньше →</a></span></li>-->
                    </ul>
                </div>
HTML;
 }

// -------------------------------------------------------------- Вывод страницы

echo <<<HTML

<!-- контент -->
    <div class='content'>
        <div class='event-header'>
            <div class='wrap'>
                <div class='b-top-left'>
                    <div class='breadcrumbs'>$breadcrumbs</div>
                    <h2>{$current_category->name}</h2>
                </div>
                <div class='smi-parts-top'>
                    <a href='/media/' class='current'><span>Все</span></a>
                    <a href='/media/video/'><span>Видео</span></a>
                    <a href='/media/papers/'><span>Публикации</span></a>
                </div>
                <div class='clear'></div>
            </div>
        </div>
        <div class='event-bottom-img'></div>
        <div class='wrap'>
        <div class='overLayer smi'>
        </div>
            <div class='smi-body'>
$posts_list
<div class='clear'></div>
$paginator
$video_list
            </div>
        </div>
    </div>
HTML;

get_footer();
?>