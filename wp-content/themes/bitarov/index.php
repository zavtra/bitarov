<?php
get_header();

// ---------------------------------------------------------------------- Мнение

$bt_opinion_cat = $cats = get_option('bt_opinion_cat', 1);
$bt_opinion_cats_arr = get_categories(array('child_of'=>$bt_opinion_cat));
foreach ($bt_opinion_cats_arr as $cat) $cats .= ',' . $cat->term_id;
$bt_opinion_pp = get_option('bt_opinion_pp', 5);
$posts_op = new WP_Query(array('cat'=>$cats, 'posts_per_page'=>$bt_opinion_pp));
$opinion = '';
while ($posts_op->have_posts())
 {
 $posts_op->the_post();
 $title = get_the_title();
 $link = get_permalink();
 $date = rusdate('j F', strtotime($posts_op->post->post_date));
 $opinion .= <<<HTML
                            <div class='view'>
                                <a href='$link'>$title</a>
                                <span class='date'>$date</span>
                            </div>
HTML;
 }

// --------------------------------------------------------------------- Слайдер

$res = db_query("SELECT id, caption, text FROM pref_bt_slider ORDER BY pos, id");
$slides = '';
while (extract(db_result($res, 'i,h,h'))) $slides .= <<<HTML
                <div class='slide1' style='background-image:url(wp-content/uploads/slider/$id.jpg)'>
                    <h4>$caption</h4>
                    <div class='content'>$text</div>
                </div>
HTML;

// ---------------------------------------------------------------- Большой пост

$posts_raw = new WP_Query(array('meta_key'=>'bt_eventbig', 'posts_per_page'=>1));
$big_ids = array(); // Потом может несколько будет выводиться
$posts_big = '';
if ($posts_raw->have_posts())
 {
 $posts_raw->the_post();
 $big_ids[] = $posts_raw->post->ID;
 $title = get_the_title();
 $link = get_permalink();
 $excerpt = get_the_excerpt();
 $cat_id = get_cat_path(bt_post_category($posts_raw->post->ID));
 $cat_id = $cat_id[key($cat_id)]->term_id;
 $cat_name = get_cat_name($cat_id);
 $cat_link = get_category_link($cat_id);
 $date = rusdate('j F Y', strtotime($posts_raw->post->post_date));
 $posts_big = <<<HTML
                    <div class='top_news'>
                        <div class='tdate'>$date</div><div class='ttag'><a href='$cat_link'>$cat_name</a></div>
                        <div class='title'><a href='$link'>$title</a></div>
                        <div class='photo'><img src='wp-content/uploads/event/{$posts_raw->post->ID}-big.jpg' width='589' height='198' alt='' /></div>
                        <div class='text'>
                        $excerpt
                        </div>
                    </div>
HTML;
 }
unset($posts_raw);

// --------------------------------------------------------------- Средние посты

$posts_raw = new WP_Query(array('meta_key'=>'bt_eventmed', 'posts_per_page'=>2, 'post__not_in'=>$big_ids));
$posts_med = '';
while ($posts_raw->have_posts())
 {
 $posts_raw->the_post();
 $title = get_the_title();
 $link = get_permalink();
 $excerpt = get_the_excerpt();
 $cat_id = get_cat_path(bt_post_category($posts_raw->post->ID));
 $cat_id = $cat_id[key($cat_id)]->term_id;
 $cat_name = get_cat_name($cat_id);
 $cat_link = get_category_link($cat_id);
 $date = rusdate('j F Y', strtotime($posts_raw->post->post_date));
 $posts_med .= <<<HTML
                        <div class='item'>
                            <div class='odate'>$date</div><div class='otag'><a href='$cat_link'>$cat_name</a></div>
                            <div class='clear'></div>
                            <div class='title'><a href='$link'>$title</a></div>
                            <div class='photo'><img src='wp-content/uploads/event/{$posts_raw->post->ID}-med.jpg' alt='' /></div>
                            <div class='text'>
                            $excerpt
                            </div>
                        </div>
HTML;
 }
unset($posts_raw);

// -------------------------------------------------------------- Вывод страницы

echo <<<HTML
<!-- контент -->
    <div class='content'>
        <div class='wrap'>
            <div id='featured'>
$slides
            </div>
            <div class='rightside'> <!-- правая колонка -->
                <div class='advice'>
                    <div class='head'>
                        <dl>
                            <dt><img src="wp-content/themes/bitarov/images/css/index_owner-mnenie.jpg" width="98" height="111" alt="" /></dt>
                            <dd>
                            <a href='/opinion/'><span class='head'>Мнение</span>
                            <span class='owner'>Александра Битарова</span>
                            </a>
                            </dd>
                        </dl>
                    </div>
                    <div class='clear'></div>
                    <div class='news_views'>
$opinion
                    </div>
                </div>

                <div class='fond-main'>
                    <div class='fond'>
                        <img src='wp-content/themes/bitarov/images/css/index-fond.png' width='230' height='94' alt='' />
                        <div class='send'><a href='/fund/#message'>оставить обращение</a></div>
                        <dl>
                            <dt><a href='https://twitter.com/bitarovas' target='_blank'><img src='wp-content/themes/bitarov/images/ico/twit.png' width='39' height='31' alt='' /></a> <a href='http://www.facebook.com/bitarovas' target='_blank'><img src='wp-content/themes/bitarov/images/ico/facebook.png' width='33' height='33' alt='' /></a></dt>
                            <dd>Представительства <br />в социальных медиа</dd>
                        </dl>
                    </div>
                </div>
            </div> <!-- off правая колонка -->
            <div class='strip_news'>
                <div class='dl'>
                    <div class='ikonka'><img src='wp-content/themes/bitarov/images/ico/i-strip.png' width='28' height='26' alt='' /></div>
                    <div class='lenta-top'>лента событий</div>
                </div>
                <div class='clear'></div>
                <div class='body'>
                <div class='top'></div>
                <div class="substrate">
                    <div class='top_news'>
$posts_big
                    </div>
                    <div class='other_news'>
$posts_med
                    </div>
                    <div class='clear'></div>
                </div>
                <div class='bottom'></div>
                </div>
            </div>
        </div>
        <div class='clear'></div>
    </div>
HTML;

get_footer();
?>