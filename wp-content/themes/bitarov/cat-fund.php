<?php get_header(); ?>

<!-- контент -->
    <div class='content'>
        <div class='event-header'>
            <div class='wrap'>
                <div class='b-top-left'>
                    <div class='breadcrumbs'>
                        <span class='current'><a href='<?php echo SITE_URL; ?>'><ins></ins><?php echo REQUEST_HOST; ?></a></span>
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
<?php
global $post;
$mons = array(
  1  => 'Января',
  2  => 'Февраля',
  3  => 'Марта',
  4  => 'Апреля',
  5  => 'Мая',
  6  => 'Июня',
  7  => 'Июля',
  8  => 'Августа',
  9  => 'Сентября',
  10 => 'Октября',
  11 => 'Ноября',
  12 => 'Декабря'
);

while (have_posts())
 {
 the_post();
 $d = intval(get_post_meta($post->ID, 'bt_fund_announce_d', true));
 $m = intval(get_post_meta($post->ID, 'bt_fund_announce_m', true));
 if (isset($mons[$m]) and $d>=1 and $d<=31) $date = "$d<span>$mons[$m]</span>";
 else $date = '';
 $title = get_the_title();
 $content = get_the_content();
 echo <<<HTML
                    <dl>
                        <dt><div>$date</div></dt>
                        <dd>
                            <h3>$title</h3>
                            <p>$content</p>
                        </dd>
                    </dl>
HTML;
 }
?>
                </div>
            </div>

        </div>
    </div>

<?php get_footer(); ?>