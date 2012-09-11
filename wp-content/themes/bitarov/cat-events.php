<?php
get_header();

// -------------------------------------------------------------- Хлебные крошки

$categories_path = get_cat_path($current_category_id);
$siteurl = SITE_URL;
$breadcrumbs = "<span class='current'><a href='$siteurl'><ins></ins>bitarov.as</a></span>\n";
foreach ($categories_path as $category)
 {
 $category_link = get_category_link($category->term_id);
 $category_name = $category->name;
 $breadcrumbs .= "                        <span><a href='$category_link'>$category_name</a><ins class='r'></ins></span>\n";
 }

// --------------------------------------------------------------- Список постов

$posts_list = '';
while (have_posts())
 {
 the_post();
 $post_title = get_the_title();
 $post_excerpt = get_the_excerpt(); // аннотация
 $post_link = get_permalink($post->ID);
 $post_date = rusdate('j F Y', strtotime($post->post_date));
 $post_category_id = bt_post_category($post->ID);
 $post_category = get_category($post_category_id);
 $post_category_name = $post_category->name;
 $post_category_link = get_category_link($post_category_id);
 $post_tags = '';
 if (is_array($tags_raw=get_the_tags()))
  foreach ($tags_raw as $tag)
   {
   $tag_link = get_tag_link($tag->term_id);
   $tag_name = $tag->name;
   $post_tags .= "<a href='$tag_link'>$tag_name</a>, ";
   }
 if ($post_tags) $post_tags = "<img src='wp-content/themes/bitarov/images/ico/event-tag.png' class='tags-img' /> " . rtrim($post_tags, ', ');
 $post_category_show = ($current_cat_level<2) ? "<div class='breadcrumbs'><a href='$post_category_link'>$post_category_name</a> &rarr;</div>" : '';
 $posts_list .= <<<HTML
                    <div class='item'>
                        $post_category_show
                        <h3><a href='$post_link'>$post_title</a></h3>
                        <p>$post_excerpt</p>
                        <div class='more'><a href='$post_link'>подробнее</a></div>
                        <div class='date'>$post_date</div>
                        <div class='tag'>$post_tags</div>
                    </div>
HTML;
 }

// --------------------------------------- Шаблон поста для подгрузки через JSON

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

// ------------------------------------------------------------------- Пагинатор

$paginator = '';
if ($pages_count>1)
 {
 for ($page_number=1; $page_number<=$pages_count; $page_number++)
   if ($page_number==$current_page_number) $paginator .= "<a href='$current_cat_link/{$uri_year}page/$page_number/' class='current' id='page-$page_number'>$page_number</a> ";
   else $paginator .= "<a href='$current_cat_link/{$uri_year}page/$page_number/' id='page-$page_number'>$page_number</a> ";
 $paginator = <<<HTML

                    <div class='paginator' id='paginator-fixed'>
                        <div class='top-fixed'>
                            <div class='wrp-line' id='paginator-events'><div>
                                $paginator
                            </div></div>
                        </div>
                    </div>

HTML;
 }

// ---------------------------------------------------------------- Подкатегории

$subcategories_block = '';
if ($subcategories)
 {
 foreach ($subcategories as $category)
   if ($category['id']<>$current_category_id)
     $subcategories_block .= "<li><span><a href='$category[link]'>$category[name]</a></span></li>\n                            ";
   else
     $subcategories_block .= "<li class='current'><span><a href='$category[link]'>$category[name]</a></span></li>\n                            ";
 $subcategories_block = <<<HTML
                    <div class='rubrikator-fixed' id='rubrikator-fixed'>
                        <ul>
                        $subcategories_block
                        </ul>
                    </div>
HTML;
 }

// ------------------------------------------------------------------------ Года

$id_cat1 = $current_cat_path[0]->term_id;
$cat1_link = get_category_link($id_cat1);
$current_year = chkget('posts-year') ? intval($_GET['posts-year']) : 0;
$years = '';
$years_raw = get_years($id_cat1);
if (count($years_raw)>1)
 {
 foreach ($years_raw as $year)
   $years .= "<a href='{$cat1_link}year$year/' class='" . (($year==$current_year)?'current':'') . "'>$year</a> ";
 $years = "        <div class='podate'><span>по годам:</span> $years</div>";
 }

$h2_year = $current_year ? "за $current_year год" : '';

// ----------------------------------------------- Показать предыдущие сообщения

$display_more = ($pages_count>$current_page_number) ? 'block' : 'none';

echo <<<HTML
<script type='text/javascript'>
current_year = $current_year;
current_category_id = $current_category_id;
current_page_number = $current_page_number;
current_page_number_more = $current_page_number;
more_loading = false;
post_template = $json_post_template;
</script>

<!-- контент -->

    <div class='wrp-rubrikator-fixed' id='wrap-fixed'>
$paginator
$subcategories_block
        <div class='rubrikator-advanced' id='years-fixed'>
$years
        <p id='back-top'><a href='#top'><span></span></a></p>
        </div>
    </div>

    <div class='content'>
        <div class='event-header'>
            <div class='wrap'>
                <div class='b-top-left'>
                    <div class='breadcrumbs'>
$breadcrumbs
                    </div>
                    <h2>События $h2_year</h2>
                </div>
                <div class='clear'></div>
            </div>
        </div>
        <div class='event-bottom-img'></div>
        <div class='wrap event'>
            <div class='event-body'>
                <div class='list_items'>

$posts_list
                    <div id='posts_more'></div>
                    <div class='button-show-old' id='button-show-old' style='display:$display_more'>
                        <a href='#' onclick='showmore(); return false;'>Показать предыдущие события</a>
                        <img id='old-loader' src='wp-content/themes/bitarov/images/ico/loading.gif' alt='' />
                    </div>
                </div>
                <div class='clear'></div>
            </div>
        </div>
    </div>
HTML;

get_footer();
?>