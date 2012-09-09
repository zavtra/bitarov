<?php

$bt_fund_text = get_option('bt_fund_text');

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

// ------------------------------------------------------------------ Меню фонда

$fund_menu = wp_nav_menu(array(
  'menu'=>'fund',
  'container' => '',
  'echo' => false,
  'items_wrap' => '%3$s'
));

echo <<<HTML
        <div class='event-header'>
            <div class='wrap'>
                <div class='b-top-left'>
                    <div class='breadcrumbs'>
$breadcrumbs
                    </div>
                    <h2>Благотворительный фонд Александра Битарова</h2>
                </div>
                <div class='clear'></div>
            </div>
        </div>
        <div class='event-bottom-img'></div>

        <div class='wrap'>
        <div class='overLayer blago' id='feedbackShadow' style='display:none' onclick='feedbackClose()'></div>
            <div class='fond-header'>
                <div class='content'>
                $bt_fund_text
                </div>
            </div>
            <div class='fond-body'>
                <!-- начало сообщения -->
                <div class="wrp-send-message">
                    <div class="send_message">
                        <div class='fund-animation'>
                          <div id='feedbacklink'>
                            <img width="25" height="19" alt="" src="wp-content/themes/bitarov/images/ico/send_message.png">
                            <a href="#" onclick='return feedbackOpen()'>Оставить обращение</a><span>&darr;</span>
                          </div>
                          <span class='send_ok' id='feedbackmsg'>Ваше обращение успешно отправлено</span>
                        </div>
                        <div class="wrp-window-comment" style="display:none" id='feedbackBox'>
                            <div class="window-comment">
                                <a class="exit" href="#" onclick='return feedbackClose()'></a>
                            <form name='feedbackform' onsubmit='return feedbackSend()'>
                            <div class="msg">
                                <textarea name="message" placeholder='Ваше обращение' onfocus="this.className='active'" onblur="this.className='idle'"></textarea>
                            </div>
                            <div class="email">
                                <input type="text" name="email" placeholder='Ваш e-mail' onfocus="this.className='active'" onblur="this.className='idle'">
                            </div>
                            <div class="name">
                                <input type="text" name="_name" placeholder='Ваше имя' onfocus="this.className='active'" onblur="this.className='idle'">
                            </div>
                            <div class="phone">
                                <input type="text" name="phone" placeholder='Ваш телефон' onfocus="this.className='active'" onblur="this.className='idle'">
                            </div>
                            <div class="clear"></div>
                            <div id="feedback-errmsg"><strong>Обнаружены ошибки:</strong></div>
                            <ol id="feedback-errors">
                              <li>Адрес e-mail указан неверно</li>
                              <li>Пожалуйста укажите номер телефона</li>
                              <li>Пожалуйста, идите нафиг</li>
                            </ol>
                            <div class="send">
                                <input type="submit" name="sendbtn" value="">
                                <input type='hidden' name='form' value='contacts'>
                            </div>
                            <img id='msg-loader' src='wp-content/themes/bitarov/images/css/feedback-loader.gif' alt='' />
                            </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- конец сообщения -->
                <div class='menu' id='fund_menu'>
                    <img src='wp-content/themes/bitarov/images/css/fond-menu-shadow.png' alt='' />
                    <ul>
$fund_menu
                    </ul>
                </div>
HTML;
?>