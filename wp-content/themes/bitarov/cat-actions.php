<?php
get_header();

// ----------------------------------------------------------------- Шапка фонда
ob_start();
require TEMPLATEPATH . '/fund-header.php';
$fund_header = ob_get_contents();
ob_end_clean();

// --------------------------------------------- Список постов текущей категории
$posts_list = '';
$first_post_id = 0;
while (have_posts()):
  the_post();
  $post_link = get_permalink($post->ID);
  $post_title = get_the_title();
  $post_date = rusdate('j F', strtotime($post->post_date));
  if ($first_post_id==0) {$first_post_id=$post->ID; $current='current';}
  else $current = '';
  $posts_list .= <<<HTML
                                        <div class='news $current'>
                                            <div class='date'>$post_date</div>
                                            <a href='$post_link' target='actionsFrame' onclick='return actFrameNavigate(this)'>$post_title</a>
                                        </div>
HTML;
endwhile;

// ------------------------------------------------------------------- Пагинатор
$paginator = '';
if ($category_paginagor)
 {
 foreach ($category_paginagor as $page_number)
   if ($page_number==$current_page_number) $paginator .= "                                                <li><a href='$current_cat_link/page/$page_number/' class='current'>$page_number</a></li>\n";
   else $paginator .= "                                                <li><a href='$current_cat_link/page/$page_number/'>$page_number</a></li>\n";
 $paginator = <<<HTML
                                         <div class='paginator'>
                                            <ul>
$paginator
                                                <!--<li><span><a href='#'>раньше</a>&nbsp;&rarr;</span></li>-->
                                            </ul>
                                        </div>
HTML;
 }

// --------------------------------------------- Ссылка на первый пост во фрейме
$first_post_link = $first_post_id ? rtrim(get_permalink($first_post_id), '/') . '/framed/' : 'about:blank';

// -------------------------------------------------------------- Вывод страницы

echo <<<HTML

<!-- контент -->
    <div class='content'>

$fund_header

                <div class='wrp-activity'>
                    <table>
                        <tbody>
                            <tr>
                                <td class='left-menu'>
                                    <div class='list_news'>

$posts_list

$paginator
                                    </div>
                                    <div class='fade'><img src='wp-content/themes/bitarov/images/css/content_fade.png' width='733' height='46' alt='' /></div>
                                </td>

                                <td class='content'>
                                    <iframe id='actionsFrame' frameborder='0' width='729' height='600' src='$first_post_link'></iframe>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>

        </div>
    </div>

HTML;

get_footer();
?>