<?php
get_header();

$res = db_query("SELECT id, caption, text FROM pref_bt_thanks");
$slides_count = $res['cnt'] / 4;
if (is_float($slides_count)) $slides_count = intval($slides_count)+1;
$thank_slides = '';
for ($current_slide=1; $current_slide<=$slides_count; $current_slide++)
 {
 $miniblock1 = $miniblock2 = $miniblock3 = $miniblock4 = '';
 for ($j=1; $j<=4; $j++) if (extract(db_result($res, 'i,h,h')))
  {
  $var = "miniblock$j";
  $$var = <<<HTML
                                        <td class='miniblock'><dl>
                                            <dt><img src='wp-content/uploads/thanks/$id.png' width='100' height='100' alt='' /></dt>
                                            <dd>
                                                <span class='name'>$caption</span>
                                                <span class='text'>$text</span>
                                            </dd>
                                        </dl></td>
HTML;
  }

 $thank_slides .= <<<HTML
                        <div class='slide1'>
                            <table>
                                <tbody>
                                    <tr>
$miniblock1
$miniblock2
                                    </tr>
                                    <tr>
$miniblock3
$miniblock4
                                    </tr>
                                </tbody>
                            </table>
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
                        <span class='current'><a href='/'><ins></ins>bitarov.as</a></span>
                        <span><a href='/category/fund/'>Благотворительный фонд</a><ins class='r'></ins></span>
                        <span><a href='/category/fund/thanks/'>Слова благодарности</a><ins class='r'></ins></span>
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
                        <li><a href='/category/fund/actions/'>Мероприятия</a></li>
                        <li><a href='/category/fund/thanks/' class='current'>Слова благодарности</a></li>
                    </ul>
                </div>
                <div class='slider_container'>
                    <div id='fond-slider'>
$thank_slides
                    </div>
                    <div class='border-bottom'><img src="wp-content/themes/Bitarov/images/css/bitarov_fond-slova_border_bottom.png" width="1000" height="4" alt="" /></div>
                </div>
            </div>
        </div>
    </div>

HTML;

get_footer();
?>