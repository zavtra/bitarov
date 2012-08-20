<?php get_header(); ?>

<!-- контент -->
    <div class='content'>
        <div class='event-header'>
            <div class='wrap'>
                <div class='b-top-left'>
                    <div class='breadcrumbs'>
<?php
echo "                        <span class='current'><a href='" . SITE_URL . "'><ins></ins>bitarov.as</a></span>\n";
$categories_path = get_cat_path($id_cat);
foreach ($categories_path as $cat)
  echo "                        <span><a href='" . get_category_link($cat->term_id) . "'>{$cat->name}</a><ins class='r'></ins></span>\n";
?>
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

<?php
while (have_posts())
 {
 the_post();
 $title = get_the_title();
 $excerpt = get_the_excerpt();
 $link = get_permalink($post->ID);
 $date = rusdate('j F Y', strtotime($post->post_date));
 $tags = '';
 if (is_array($tags_arr=get_the_tags())) foreach ($tags_arr as $tag)
   $tags .= "<div class='tag'><a href='" . get_tag_link($tag->term_id) . "'>{$tag->name}</a></div> ";

 echo <<<HTML
                    <div class='item'>
                        <div class='breadcrumbs'><a href='#'>Фонд Битарова</a> &rarr;</div>
                        <h3><a href='$link'>$title</a></h3>
                        <p>$excerpt</p>
                        <div class='more'><a href='$link'>подробнее</a></div>
                        <div class='date'>$date</div>
                        $tags
                    </div>
HTML;
 }
?>

                    <div class='button-show-old'>
                        <a href='#'>Показать предыдущие события</a>
                        <img src='wp-content/themes/bitarov/images/ico/loading.gif' width='50' height='50' alt='' />
                    </div>
                </div>
                <div class='wrp-rubrikator-fixed'>

<?php
if ($category_paginagor)
 {
 $pages_html = '';
 $width = count($category_paginagor)*20;
 $margin = ($current_page-1) * 20;
 foreach ($category_paginagor as $p)
   if ($p==$current_page) $pages_html .= "<a href='$current_cat_link/page/$p/' class='current'>$p</a> ";
   else $pages_html .= "<a href='$current_cat_link/page/$p/'>$p</a> ";
 echo <<<HTML
                    <div class='paginator'>
                        <div class='top-fixed'>
                            <div class='wrp-line'>
$pages_html
                                <div class='poloska' style='width:{$width}px'>
                                    <div class='underline' style='margin-left:{$margin}px'><ins></ins></div>
                                </div>
                            </div>
                        </div>
                    </div>
HTML;
 }

if ($subcategories)
 {
 $subcategories_html = '';
 foreach ($subcategories as $cat)
   if ($cat['id']<>$id_cat) $subcategories_html .= "<li><span><a href='$cat[link]'>$cat[name]</a></span></li>\n                            ";
   else $subcategories_html .= "<li class='current'><span><a href='$cat[link]'>$cat[name]</a></span></li>\n                            ";
echo <<<HTML
                    <div class='rubrikator-fixed'>
                        <ul>
                        $subcategories_html
                        </ul>
                    </div>
HTML;
 }

?>
                    <div class='rubrikator-advanced'>
<?php

$years

?>
                        <p id='back-top'>
                            <a href='#top'><span></span></a>
                        </p>
                    </div>
                </div>
                <div class='clear'></div>
            </div>
        </div>
    </div>

<?php get_footer(); ?>