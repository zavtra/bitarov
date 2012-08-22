<?php
get_header();

// ------------------------------------------------------------ Контент страницы
the_post();
$page_content = bt_post_content($post->ID);

// -------------------------------------------------------------- Хлебные крошки
$breadcrumbs_enabled = intval(get_post_meta($post->ID, 'bt_page_breadcrumbs', true));
$page_breadcrumbs = '';
if ($breadcrumbs_enabled)
 {
 $page_breadcrumbs = breadcrumbs_page($post);
 $page_breadcrumbs = <<<HTML
                    <div class='breadcrumbs'>
                        $page_breadcrumbs
                    </div>
HTML;
 }

// ---------------------------------------------------------- Заголовок страницы
$title_enabled = intval(get_post_meta($post->ID, 'bt_page_title', true));
$page_title = '';
if ($title_enabled) $page_title = "                    <h2>{$post->post_title}</h2>";


// --------------------- Панель навигации (если есть хлеб. крошки или заголовок)
$navigation_panel = '';
if ($page_breadcrumbs or $page_title) $navigation_panel = <<<HTML
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

// -------------------------------------------------------------- Вывод страницы

echo <<<HTML
<!-- контент -->
    <div class='content'>

$navigation_panel

        <div class='wrap'>
            <div class='contacts'>
$page_content
            </div>
        </div>

    </div>
HTML;

get_footer();
?>