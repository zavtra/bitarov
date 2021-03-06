<?php
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
 $post_content = bt_post_content();
 $post_link = get_permalink($post->ID);
 $post_date = rusdate('d.m.Y', strtotime($post->post_date));
 $post_info = array();
 $bt_youtube_id = htmltext(get_post_meta($post->ID, 'bt_youtube_id', true));
 if ($bt_youtube_id)
   {$icon = 'avi';
   $link_more = "<a href='$post_link' onclick='return mediaWindowOpen({$post->ID})' class='video-more'><span>смотреть видео</span></a>";}
 else
   {$icon = 'txt';
   $link_more = "<a href='$post_link' onclick='return mediaWindowOpen({$post->ID})' class='read-more'>читать далее</a>";}
 $bt_id_media = intval(get_post_meta($post->ID, 'bt_id_media', true));
 if (isset($mediaz[$bt_id_media])) $post_info[] = $mediaz[$bt_id_media];
 $post_info[] = $post_date;
 $post_info = implode(', ', $post_info);
 $posts_list .= <<<HTML
                <div class='block'>
                    <div class='blocklimiter'>
                      <h3><a href='$post_link' id='post-link-{$post->ID}' onclick='return mediaWindowOpen({$post->ID})'>$post_title</a></h3>
                      <div class='depiction'><span class='$icon'>$post_info</span></div>
                      <p>$post_excerpt</p>
                    </div>
                    $link_more
                </div>
HTML;

 if ($bt_youtube_id) $blocks_list .= <<<HTML
                <div class='video-window' id='media-{$post->ID}'>
                    <a href='#' class='exit' onclick='return mediaWindowClose()'></a>
                    <div class='video-left_b'>
                        <iframe id="iframe-{$post->ID}" width="100%" height="100%" src="http://www.youtube.com/embed/$bt_youtube_id" frameborder="0" allowfullscreen></iframe>
                    </div>
                    <div class='wrp-text-right_b'>
                        <div class='text-right_b'>
                            <div class='scroll-pane'>
                                <div class='padding'>
                                    <h1 id='post-title-{$post->ID}'>$post_title</h1>
                                    <div class='date'>добавлено $post_date</div>
$post_content
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class='clear'></div>
                </div>
HTML;

 else $blocks_list .= <<<HTML
                <div class='video-window' id='media-{$post->ID}'>
                    <a href='#' class='exit' onclick='return mediaWindowClose()'></a>
                    <div class='wrp-text'>
                        <div class='text'>
                            <div class='scroll-pane'>
                                <div class='padding'>
                                    <h1 id='post-title-{$post->ID}'>$post_title</h1>
                                    <div class='date'>добавлено $post_date</div>
$post_content
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
 $linkback = ($current_page_number>1) ? "<li><span><a href='$current_cat_link/{$uri_year}page/".($current_page_number-1)."/'>&larr; Новее</a></span></li>" : '';
 $linknext = ($current_page_number<$pages_count) ? "<li><span><a href='$current_cat_link/{$uri_year}page/".($current_page_number+1)."/'>Раньше &rarr;</a></span></li>" : '';
 foreach ($category_paginagor as $page_number)
   if ($page_number==$current_page_number) $paginator .= "<li><a class='current' href='$current_cat_link/{$uri_year}page/$page_number/'>$page_number</a>\n";
   else $paginator .= "<li><a href='$current_cat_link/{$uri_year}page/$page_number/'>$page_number</a>\n";
 $paginator = <<<HTML
                <div class="paginator">
                    <ul>
$linkback
$paginator
$linknext
                    </ul>
                </div>
HTML;
 }

// ----------------------------------------- Если контент запрошен с помощью XHR
if (chkget('xhr'))
 {
 $result = array(
   'breadcrumbs' => $breadcrumbs,
   'posts_list' => $posts_list,
   'blocks_list' => $blocks_list,
   'paginator' => $paginator
 );
 die(json_encode($result));
 }

// ---------------------------------------------------------------- Верхнее меню

class mainMenuWalker extends Walker_Nav_Menu
 {
 function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 )
  {
  global $wp_query;
  $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
  $class_names = $value = '';
  $classes = empty( $item->classes ) ? array() : (array) $item->classes;
  $classes[] = 'menu-item-' . $item->ID;
  $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
  $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';
  $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
  $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';
  $output .= $indent . '<li' . $id . $value . $class_names .'>';
  $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
  $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
  $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
  $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
  $item_output = $args->before;
  $item_output .= '<a'. $attributes .'><span>';
  $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
  $item_output .= '</span></a>';
  $item_output .= $args->after;
  $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
  }
 }

$walker = new mainMenuWalker;
$media_menu = wp_nav_menu(array(
  'menu' => 'media',
  'walker' => $walker,
  'container' => '',
  'echo' => false,
  'items_wrap' => '%3$s'
));

// -------------------------------------------------------------- Вывод страницы

get_header();

echo <<<HTML

<img id='media-loader' src='wp-content/themes/bitarov/images/css/loader-circle.gif' />

<!-- контент -->
    <div class='content'>
        <div class='event-header'>
            <div class='wrap'>
                <div class='b-top-left'>
                    <div class='breadcrumbs'>
                    <div id='breadcrumbs'>$breadcrumbs
                    <span id='breadcrumb-x'><a onclick='return false'></a><ins class='r'></ins></span>
                    </div>
                    </div>
                    <h2>{$current_category->name}</h2>
                    <div class='smi-parts-top' id='smi-parts-top'><ol>

$media_menu

                </ol></div>
                </div>
                <div class='clear'></div>
            </div>
        </div>
        <div class='event-bottom-img'></div>
        <div class='wrap'>
        <div class='overLayer smi'>
        </div>
            <div class='smi-body'>

<div id='posts_list'>
$posts_list
</div>

<div class='clear'></div>

<div id='paginator'>
$paginator
</div>

<div id='blocks_list'>
$blocks_list
</div>

            </div>
        </div>
    </div>
HTML;

get_footer();
?>