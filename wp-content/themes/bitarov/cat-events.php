<?php
get_header();

// --- Хлебные крошки
$categories_path = get_cat_path($current_category_id);
$siteurl = SITE_URL;
$breadcrumbs = "<span class='current'><a href='$siteurl'><ins></ins>bitarov.as</a></span>\n";
foreach ($categories_path as $category)
 {
 $category_link = get_category_link($category->term_id);
 $category_name = $category->name;
 $breadcrumbs .= "                        <span><a href='$category_link'>$category_name</a><ins class='r'></ins></span>\n";
 }

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
 if (is_array($tags_raw=get_the_tags()))
  foreach ($tags_raw as $tag)
   {
   $tag_link = get_tag_link($tag->term_id);
   $tag_name = $tag->name;
   $post_tags .= "<div class='tag'><a href='$tag_link'>$tag_name</a></div> ";
   }
 $posts_list .= <<<HTML
                    <div class='item'>
                        <div class='breadcrumbs'><a href='#'>Фонд Битарова</a> &rarr;</div>
                        <h3><a href='$post_link'>$post_title</a></h3>
                        <p>$post_excerpt</p>
                        <div class='more'><a href='$post_link'>подробнее</a></div>
                        <div class='date'>$post_date</div>
                        $post_tags
                    </div>
HTML;
 }

// --- Пагинатор
$paginator = '';
if ($category_paginagor)
 {
 $width = count($category_paginagor)*20; // ширина линии
 $margin = ($current_page-1) * 20; // маргин указателя страницы
 foreach ($category_paginagor as $page_number)
   if ($page_number==$current_page) $paginator .= "<a href='$current_cat_link/page/$page_number/' class='current'>$page_number</a> ";
   else $paginator .= "<a href='$current_cat_link/page/$page_number/'>$page_number</a> ";
 $paginator = <<<HTML
                    <div class='paginator'>
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

// --- Подкатегории
$subcategories_block = '';
if ($subcategories)
 {
 foreach ($subcategories as $category)
   if ($category['id']<>$current_category_id)
     $subcategories_block .= "<li><span><a href='$category[link]'>$category[name]</a></span></li>\n                            ";
   else
     $subcategories_block .= "<li class='current'><span><a href='$category[link]'>$category[name]</a></span></li>\n                            ";
 $subcategories_block = <<<HTML
                    <div class='rubrikator-fixed'>
                        <ul>
                        $subcategories_block
                        </ul>
                    </div>
HTML;
 }

echo <<<HTML
<!-- контент -->
    <div class='content'>
        <div class='event-header'>
            <div class='wrap'>
                <div class='b-top-left'>
                    <div class='breadcrumbs'>
$breadcrumbs
                    </div>
                    <h2>События</h2>
                </div>
                <div class='clear'></div>
            </div>
        </div>
        <div class='event-bottom-img'></div>
        <div class='wrap event'>
            <div class='event-body'>
                <div class='list_items'>

$posts_list

                    <div class='button-show-old'>
                        <a href='#'>Показать предыдущие события</a>
                        <img src='wp-content/themes/bitarov/images/ico/loading.gif' width='50' height='50' alt='' />
                    </div>
                </div>
                <div class='wrp-rubrikator-fixed'>
$paginator
$subcategories_block

                    <div class='rubrikator-advanced'>
тут будут года
                        <p id='back-top'>
                            <a href='#top'><span></span></a>
                        </p>
                    </div>
                </div>
                <div class='clear'></div>
            </div>
        </div>
    </div>
HTML;

get_footer();
?>