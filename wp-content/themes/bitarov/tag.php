<?php
get_header();

// --- Хлебные крошки
$siteurl = SITE_URL;
$tag = get_queried_object();
$tag_name = $tag->name;
$tag_link = get_tag_link($tag->term_id);

$breadcrumbs = "<span class='current'><a href='$siteurl'><ins></ins>bitarov.as</a></span>
                <span><a href='$tag_link'>Метка &laquo;$tag_name&raquo;</a><ins class='r'></ins></span>";

// --- Список постов
$posts_list = '';
while (have_posts())
 {
 the_post();
 $post_title = get_the_title();
 $post_excerpt = get_the_excerpt(); // аннотация
 $post_link = get_permalink($post->ID);
 $post_date = rusdate('j F Y', strtotime($post->post_date));
 $post_tags = '';
 $post_category_id = bt_post_category($post->ID);
 $post_category = get_category($post_category_id);
 $post_category_name = $post_category->name;
 $post_category_link = get_category_link($post_category_id);
 if (is_array($tags_raw=get_the_tags()))
  foreach ($tags_raw as $tag)
   {
   $tag_link = get_tag_link($tag->term_id);
   $tag_name = $tag->name;
   $post_tags .= "<a href='$tag_link'>$tag_name</a> ";
   }
 $posts_list .= <<<HTML
                    <div class='item'>
                        <div class='breadcrumbs'><a href='$post_category_link'>$post_category_name</a> &rarr;</div>
                        <h3><a href='$post_link'>$post_title</a></h3>
                        <p>$post_excerpt</p>
                        <div class='more'><a href='$post_link'>подробнее</a></div>
                        <div class='date'>$post_date</div>
                        <div class='tag'>$post_tags</div>
                    </div>
HTML;
 }

/* надеюсь не понадобится
// --- Шаблон поста для подгрузки через JSON
$json_post_template = <<<HTML
                    <div class='item'>
                        <div class='breadcrumbs'><a href='__CATEGORY_LINK__'>__CATEGORY_NAME__</a> &rarr;</div>
                        <h3><a href='__POST_LINK__'>__POST_TITLE__</a></h3>
                        <p>__POST_EXCERPT__</p>
                        <div class='more'><a href='__POST_LINK__'>подробнее</a></div>
                        <div class='date'>__POST_DATE__</div>
                        <div class='tag'>__TAGS__</div>
                    </div>
HTML;
$json_post_template = json_encode($json_post_template);
*/

// Число страниц категории
$current_page_number = intval(get_query_var('paged'));
if ($current_page_number<1) $current_page_number = 1;
$per_page = intval(get_query_var('posts_per_page'));
$total_posts = intval($wp_query->found_posts);
if ($per_page>0 and $total_posts>0)
 {
 $pages_count = $total_posts / $per_page;
 if (is_float($pages_count)) $pages_count = intval($pages_count)+1;
 }
else $pages_count = 1;
$category_paginagor = ($pages_count>1) ? gen_pages($current_page_number, $pages_count, 3) : array();

// --- Пагинатор
$paginator = '';
if ($category_paginagor)
 {
 $width = count($category_paginagor)*20; // ширина линии
 $margin = ($current_page_number-1) * 20; // маргин указателя страницы
 foreach ($category_paginagor as $page_number)
   if ($page_number==$current_page_number) $paginator .= "<a href='$current_cat_link/{$uri_year}page/$page_number/' class='current'>$page_number</a> ";
   else $paginator .= "<a href='$current_cat_link/{$uri_year}page/$page_number/'>$page_number</a> ";
 $paginator = <<<HTML
                    <div class='paginator' id='paginator-fixed'>
                        <div class='top-fixed'>
                            <div class='wrp-line'>
                                $paginator
                                <div class='poloska' style='width:{$width}px'>
                                    <div class='underline' style='margin-left:{$margin}px'><ins></ins></div>
                                </div>
                            </div>
                        </div>
                    </div>
HTML;
 }

/* вроде не нужны
// --- Года
$years = '';
$years_raw = get_years($current_category_id);
if (count($years_raw)>1)
 {
 foreach ($years_raw as $year) $years .= "<a href='$current_cat_link/year$year/'>$year</a> ";
 $years = "        <div class='podate'><span>по годам:</span> $years</div>";
 }
*/

// --- Показать предыдущие сообщения
//$display_more = ($pages_count>$current_page_number) ? 'block' : 'none';

echo <<<HTML
<!-- контент -->

    <div class='wrp-rubrikator-fixed' id='wrap-fixed'>
$paginator
    </div>

    <div class='content'>
        <div class='event-header'>
            <div class='wrap'>
                <div class='b-top-left'>
                    <div class='breadcrumbs'>
$breadcrumbs
                    </div>
                    <h2>Записи отмеченные тегом &laquo;$tag_name&raquo;</h2>
                </div>
                <div class='clear'></div>
            </div>
        </div>
        <div class='event-bottom-img'></div>
        <div class='wrap event'>
            <div class='event-body'>
                <div class='list_items' id='posts_list'>

$posts_list

                </div>
                <div class='clear'></div>
            </div>
        </div>
    </div>
HTML;

get_footer();
?>