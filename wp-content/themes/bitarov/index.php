<?php get_header(); ?>

<!-- контент -->
    <div class='content'>
        <div class='wrap'>
            <div id='featured'>
                <div class='slide1'>
                    <h4>Город нашей мечты</h4>
                    <div class='content'>Сегодня у нас есть все возможности
                    сделать Иркутск лучше. И мы уверенно
                    двигаемся в этом направлении</div>
                </div>
                <div class='slide1'>
                    <h4>Город нашей мечты</h4>
                    <div class='content'>Сегодня у нас есть все возможности
                    сделать Иркутск лучше. И мы уверенно
                    двигаемся в этом направлении</div>
                </div>
                <div class='slide1'>
                    <h4>Город нашей мечты</h4>
                    <div class='content'>Сегодня у нас есть все возможности
                    сделать Иркутск лучше. И мы уверенно
                    двигаемся в этом направлении</div>
                </div>
            </div>
            <div class='rightside'> <!-- правая колонка -->
                <div class='advice'>
                    <div class='head'>
                        <dl>
                            <dt><img src='wp-content/themes/bitarov/images/css/rightside-owner.png' width='98' height='110' alt='' /></dt>
                            <dd>
                            <a href='#'>Мнение</a>
                            <div>Александра Битарова</div>
                            </dd>
                        </dl>
                    </div>
                    <div class='clear'></div>
                    <div class='news_views'>
<?php
$bt_opinion_cat = $cats = get_option('bt_opinion_cat', 1);
$bt_opinion_cats_arr = get_categories(array('child_of'=>$bt_opinion_cat));
foreach ($bt_opinion_cats_arr as $cat) $cats .= ',' . $cat->term_id;
$bt_opinion_pp = get_option('bt_opinion_pp', 5);
$posts_op = new WP_Query(array('cat'=>$cats, 'posts_per_page'=>$bt_opinion_pp));
while ($posts_op->have_posts())
 {
 $posts_op->the_post();
 $title = get_the_title();
 $link = get_permalink();
 $date = rusdate('d F', strtotime($posts_op->post->post_date));
echo <<<HTML
                            <div class='view'>
                                <a href='$link'>$title</a>
                                <span class='date'>$date</span>
                            </div>
HTML;
 }
?>
                    </div>
                </div>

                <div class='fond-main'>
                    <div class='fond'>
                        <img src='wp-content/themes/bitarov/images/css/index-fond.png' width='230' height='94' alt='' />
                        <div class='send'><a href='#'>оставить обращение</a></div>
                        <dl>
                            <dt><a href='#'><img src='wp-content/themes/bitarov/images/ico/twit.png' width='39' height='31' alt='' /></a> <a href='#'><img src='wp-content/themes/bitarov/images/ico/facebook.png' width='33' height='33' alt='' /></a></dt>
                            <dd>Представительства <br />в социальных медиа</dd>
                        </dl>
                    </div>
                </div>
            </div> <!-- off правая колонка -->
            <div class='strip_news'>
                <dl>
                    <dt><img src='wp-content/themes/bitarov/images/ico/i-strip.png' width='28' height='26' alt='' /></dt>
                    <dd><span>лента событий</span></dd>
                </dl>
                <div class='clear'></div>
                <div class='body'>
                    <div class='top_news'>
<?php
$posts_big = new WP_Query(array('meta_key'=>'bt_event-big', 'meta_value'=>'1', 'posts_per_page'=>1));
$big_ids = array(); // Потом может несколько будет выводиться
if ($posts_big->have_posts())
 {
 $posts_big->the_post();
 $big_ids[] = $posts_big->post->ID;
 $title = get_the_title();
 $link = get_permalink();
 $excerpt = get_the_excerpt();
 $cat_id = bt_post_category($posts_big->post->ID);
 $cat_name = get_cat_name($cat_id);
 $cat_link = get_category_link($cat_id);
 $date = rusdate('d F Y', strtotime($posts_big->post->post_date));
 echo <<<HTML
                    <div class='top_news'>
                        <div class='tdate'>$date</div><div class='ttag'><a href='$cat_link'>$cat_name</a></div>
                        <div class='title'><a href='$link'>$title</a></div>
                        <div class='photo'><img src='wp-content/uploads/event/{$posts_big->post->ID}-big.jpg' width='589' height='198' alt='' /></div>
                        <div class='text'>
                        $excerpt
                        </div>
                    </div>
HTML;
 }
unset($posts_big);
?>
                    </div>
                    <div class='other_news'>
<?php
$posts_med = new WP_Query(array('meta_key'=>'bt_event-med', 'meta_value'=>'1', 'posts_per_page'=>2, 'exclude'=>$big_ids));
while ($posts_med->have_posts())
 {
 $posts_med->the_post();
 $title = get_the_title();
 $link = get_permalink();
 $excerpt = get_the_excerpt();
 $cat_id = bt_post_category($posts_med->post->ID);
 $cat_name = get_cat_name($cat_id);
 $cat_link = get_category_link($cat_id);
 $date = rusdate('d F Y', strtotime($posts_med->post->post_date));
 echo <<<HTML
                        <div class='item'>
                            <div class='odate'>$date</div><div class='otag'><a href='$cat_link'>$cat_name</a></div>
                            <div class='clear'></div>
                            <div class='title'><a href='$link'>$title</a></div>
                            <div class='photo'><img src='wp-content/uploads/event/{$posts_med->post->ID}-med.jpg' alt='' /></div>
                            <div class='text'>
                            $excerpt
                            </div>
                        </div>
HTML;
 }
unset($posts_med);
?>
                    </div>
                    <div class='clear'></div>
                </div>
            </div>
        </div>
    </div>

<?php get_footer(); ?>