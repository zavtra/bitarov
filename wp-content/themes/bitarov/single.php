<?php

if (chkget('framed')) require TEMPLATEPATH . '/single-framed.php';
get_header();

// -------------------------------------------------- Информация о текущем посте
the_post();
$post_id = $post->ID;
$post_category_id = bt_post_category($post->ID);
$post_category = get_category($post_category_id);
$post_category_link = get_category_link($post_category_id);
$post_title = get_the_title();
$post_content = bt_post_content();
$post_date = rusdate('j F Y', strtotime($post->post_date));

// --- Мнение (если есть)
$opinion = get_post_meta($post_id, 'bt_opinion', true);
if ($opinion) $opinion = <<<HTML
                    <div class='wrp_substrate'>
                        <div class='top'></div>
                        <div class='substrate'><dl>
                            <dt></dt>
                            <dd>$opinion</dd>
                        </dl></div>
                        <div class='bottom'></div>
                    </div>
HTML;

// -------------------------------------------------------------- Хлебные крошки
$breadcrumbs = breadcrumbs_post($post);

// ----------------------------------------------------------------- Комментарии
ob_start();
comments_template();
$comments = ob_get_contents();
ob_end_clean();

// --------------------------------------------------------------- Похожие посты
$liked_raw = new WP_Query(array('posts_per_page'=>get_option('bt_liked_pp', 5), 'cat'=>$post_category_id, 'post__not_in'=>array($post->ID)));
$liked = '';
while ($liked_raw->have_posts())
 {
 $liked_raw->the_post();
 $liked_link = get_permalink($liked_raw->post->ID);
 $liked_title = get_the_title();
 $liked .= "<li><a href='$liked_link'>$liked_title</a></li>\n                        ";
 }
if ($liked) $liked = <<<HTML
                <div class='like_records'>
                    <h3><strong>похожие записи</strong></h3>
                    <span>из рубрики <a href="$post_category_link">{$post_category->name}</a></span>
                    <ul>
                        $liked
                    </ul>
                </div>
HTML;

// -------------------------------------------------------------- Вывод страницы

echo <<<HTML

<!-- контент -->
    <div class='content'>
        <div class='event-header'>
            <div class='wrap'>
                <div class='b-top-left'>
                    <div class='breadcrumbs'>
$breadcrumbs
                    </div>
                    <h2>$post_title</h2>
                </div>
                <div class='clear'></div>
            </div>
        </div>
        <div class='event-bottom-img'></div>
        <div class='wrap'>
            <div class='wrp_article'>
                <div class='right_float_article'>
$liked
                </div>
                <div class='left_float_article'>
                <div class='article'>
                    <div class='date'>$post_date</div>
$opinion
$post_content
                </div>
$comments
                </div>
            </div>
            <div class='clear'></div>
        </div>
    </div>

HTML;

get_footer();
?>