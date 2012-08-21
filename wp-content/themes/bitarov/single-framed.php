<?php
require TEMPLATEPATH . '/head.php';

// --- Информация о текущем посте
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

// --- Комментарии
ob_start();
comments_template();
$comments = ob_get_contents();
ob_end_clean();

echo <<<HTML

<body>
<div class='scroll-container-main'>
                                        <div class='scroll-pane'>
                                            <div class='wrapper'>
                                            <div class='independen-item'>
                                                <h1>$post_title</h1>
$post_content
                                                <img src='wp-content/themes/bitarov/images/css/activity_content-item-borderbottom.png' width='680' height='3' alt='' />
$comments
                                            </div>
                                            <div class='clear'></div>
                                            </div>
                                        </div>
                                    </div>
</body></html>

HTML;

exit;

?>