<?php
get_header();

// --- Список постов текущей категории

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

// --- Пагинатор
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

$first_post_link = $first_post_id ? rtrim(get_permalink($first_post_id), '/') . '/framed/' : 'about:blank';

echo <<<HTML

<!-- контент -->
    <div class='content'>
        <div class='event-header'>
            <div class='wrap'>
                <div class='b-top-left'>
                    <div class='breadcrumbs'>
                        <span class='current'><a href='#'><ins></ins>bitarov.as</a></span>
                        <span><a href='#'>Благотворительный фонд</a><ins class='r'></ins></span>
                    </div>
                    <h2>Благотворительный фонд Александра Битарова</h2>
                </div>
                <div class='clear'></div>
            </div>
        </div>
        <div class='event-bottom-img'></div>
        <div class='wrap'>
            <div class='fond-header'>
                <div class='content'>
                Благотворительная деятельность фонда «Кто, если не Я?» направлена на оказание помощи детям, находящихся в трудной жизненной ситуации, создание благоприятных условий для образования и развития детей-сирот в детских домах и повышение квалификации специалистов, работающих с детьми.
                </div>
            </div>
            <div class='fond-body'>
                <div class='wrp-send-message'>
                    <div class='send_message'>
                        <img src='wp-content/themes/bitarov/images/ico/send_message.png' width='25' height='19' alt='' />
                        <a href=''>Оставить обращение</a><span>&darr;</span>
                    </div>
                </div>
                <div class='menu'>
                    <img src='wp-content/themes/bitarov/images/css/fond-menu-shadow.png' alt='' />
                    <ul>
                        <li><a href='/category/fund/'>Анонсы</a></li>
                        <li><a href='/category/fund/actions/' class='current'>Мероприятия</a></li>
                        <li><a href='/category/thanks/'>Слова благодарности</a></li>
                    </ul>
                </div>

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
                                    <iframe name='actionsFrame' frameborder='0' width='729' height='600' src='$first_post_link'></iframe>
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