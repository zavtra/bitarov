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
  $var = "$miniblock$j";
  $$var = <<<HTML
                                                <dt><img src='wp-content/uploads/thanks/$id.jpg' width='100' height='100' alt='' /></dt>
                                                <dd>
                                                    <span class='name'>$caption</span>
                                                    <span class='text'>$text</span>
                                                </dd>
HTML;
  }

 $thank_slides .= <<<HTML
                        <div class='slide1'>
                            <table>
                                <tbody>
                                    <tr>
                                    <td class='miniblock'><dl>
$miniblock1
                                    </dl></td>
                                    <td class='miniblock'><dl>
$miniblock2
                                    </dl></td>
                                    </tr>
                                    <tr>
                                    <td class='miniblock'><dl>
$miniblock3
                                    </dl></td>
                                    <td class='miniblock'><dl>
$miniblock4
                                    </dl></td>
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
                        <span class='current'><a href='<?php echo SITE_URL; ?>'><ins></ins>bitarov.as</a></span>
                        <span><a href='http://bitarov/fund/'>Благотворительный фонд</a><ins class='r'></ins></span>
                    </div>
                    <h2>Благотворительный фонд Александра Битарова</h2>
                </div>
                <div class='clear'></div>
            </div>
        </div>
        <div class='event-bottom-img'></div>

        <div class='wrap'>
        <div class='overLayer blago' style='display:none'>
        </div>
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
                        <div class='wrp-window-comment' style='display:none'>
                        <div class='window-comment'>
                            <a href='#' class='exit'></a>
                            <form>
                                <div class='msg'>
                                    <textarea name="msg" placeholder='Ваше обращение' onfocus="this.className='active'" onblur="this.className='idle'"></textarea>
                                </div>
                                <div class='email'>
                                    <input type="text" name="email" placeholder='Ваш e-mail' onfocus="this.className='active'" onblur="this.className='idle'" />
                                </div>
                                <div class='name'>
                                    <input type="text" name="name" placeholder='Ваше имя' onfocus="this.className='active'" onblur="this.className='idle'" />
                                </div>
                                <div class='phone'>
                                    <input type="text" name="phone" placeholder='Ваш телефон' onfocus="this.className='active'" onblur="this.className='idle'" />
                                </div>
                                <div class='clear'></div>
                                <div class='send'>
                                    <input type='submit' value='' />
                                </div>
                            </form>
                        </div>
                        </div>
                    </div>
                </div>
                <div class='menu'>
                    <img src='wp-content/themes/bitarov/images/css/fond-menu-shadow.png' alt='' />
                    <ul>
                        <li><a href='/fund/' class='current'>Анонсы</a></li>
                        <li><a href='/fund/actions/'>Мероприятия</a></li>
                        <li><a href='/fund/thanks/'>Слова благодарности</a></li>
                    </ul>
                </div>
                <div class='items'>
                <div class='slider_container'>
                    <div id='fond-slider'>
$thank_slides
                    </div>
                    <div class='border-bottom'><img src="wp-content/themes/Bitarov/images/css/bitarov_fond-slova_border_bottom.png" width="1000" height="4" alt="" /></div>
                </div>

                </div>
            </div>

        </div>
    </div>

HTML;

get_footer();
?>