<?php
get_header();

echo <<<HTML

<!-- контент -->
    <div class='content'>
        <div class='event-header'>
            <div class='wrap'>
                <div class='b-top-left'>
                    <div class='breadcrumbs'>
                        <span class='current'><a href='#'><ins></ins>bitarov.as</a></span>
                        <span><a href='#'>Мнение</a><ins class='r'></ins></span>
                    </div>
                    <h2>Нужно активнее сотрудничать с крупными предприятиями и финансово-промышленными группам</h2>
                </div>
                <div class='clear'></div>
            </div>
        </div>
        <div class='event-bottom-img'></div>
        <div class='wrap'>
            <div class='wrp_article'>
                <div class='like_records'>
                    <h3><strong>похожие записи</strong></h3>
                    <span>из рубрики <a href="#">Политическая ситуация</a></span>
                    <ul>
                        <li><a href="#">Нужно активнее сотрудничать с крупными предприятиями и финансово- промышленными группами</a></li>
                        <li><a href="#">Нового министра строительства будем оценивать по реальным делам</a></li>
                        <li><a href="#">Другую должность даже не рассматривал</a></li>
                    </ul>
                </div>
                <div class='article'>
                    <div class='date'>31 сентября 2012</div>
                    <div class='wrp_substrate'>
                        <div class='top'></div>
                        <div class='substrate'>
                            <dl>
                                <dt></dt>
                                <dd>Комментарии советника губернатора Иркутской области Александра Битарова относительно позиции главы Приангарья о деятельности финансово-промышленных групп и крупных предприятий в регионе.</dd>
                            </dl>
                        </div>
                        <div class='bottom'></div>
                    </div>

                    <div class='article_text'>
                        <p>Уверен, что для многих россиян появление новой широкой общественной коалиции стало неожиданным, но это, как ни странно, внесло свежую струю в политическую жизнь России накануне выборов в Государственную Думу. Похоже, вместе с экономикой модернизация началась и в политике. Политике противопоказана стагнация и в партии «Единая Россия» это понимают. Сегодня нам необходима и модернизация гражданского общества, которое не должно оставаться в стороне от принятия стратегических решений по развитию страны. </p>
                        <p>Создание Общероссийского народного фронта – это путь к обновлению. Любая партия состоит из людей, и если они подолгу засиживаются на своих местах, развитие прекращается. Общероссийский народный фронт – это отличный «банк» честных, энергичных, целеустремленных людей, которые любят свою родину и готовы отдать все свои силы, чтобы каждому в нашей стране жилось лучше. </p>
                        <p><strong>Сегодня «Единая Россия»</strong> своим примером демонстрирует открытость и демократичность в выборе кандидатов в депутаты Государственной думы. Идет реализация трех инициатив: «Народная программа», «Народный бюджет» и «Народное предварительное голосование». </p>

                        <div class='tag'><img width="22" height="11" alt="" src="wp-content/themes/bitarov/images/ico/event-tag.png"> <a href="#">строительство в Иркутской области</a></div>
                    </div>
                </div>
                <div class='clear'></div>
                <div class='wrp-send_comment normal'>
                    <div class='send_comment'>
                        <img src='wp-content/themes/bitarov/images/ico/send_comment.png' width='22' height='22' alt='' />
                        <a href=''>Комментировать</a>
                        <span>↓</span>
                    </div>

                    <div class='wrp-artic-comment' style='display:block'>
                        <div class='artic-comment'>
                            <form>
                                <div class='msg'>
                                    <textarea name="msg" placeholder='Комментарий' onfocus="this.className='active'" onblur="this.className='idle'"></textarea>
                                </div>
                                <div class='name'>
                                    <input type="text" name="name" placeholder='Ваше имя' onfocus="this.className='active'" onblur="this.className='idle'" />
                                </div>
                                <div class='email'>
                                    <input type="text" name="email" placeholder='Ваш e-mail' onfocus="this.className='active'" onblur="this.className='idle'" />
                                </div>
                                <div class='clear'></div>
                                <div class='send'>
                                    <input type='submit' value='' />
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class='list'>
                        <div class='number_comments'>Оставлен <span>1 комментарий</span></div>
                    <div class='wrp-comment_div'>
                    <div class='comment_div'>
                        <div class='comment'>
                            Александр Битаров один из самых порядочных людей из всех, кого я знаю. Удачи!
                            <img src='wp-content/themes/bitarov/images/css/comment_hvost.png' alt='' />
                        </div>
                        <div class='user'><span>Сергей,</span> 20 июня 2012</div>
                    </div>

                    <div class='comment_div'>
                        <div class='comment'>
                            Вспомнив в очередной раз теплым словом свой москвич, решил написать про литье которое на нем стояло! Предлагаю Вашему вниманию кованные диски производства России ВСМПО “Вега” с разболтовкой 4*100 R15.
                            <img src='wp-content/themes/bitarov/images/css/comment_hvost.png' alt='' />
                        </div>
                        <div class='user'><span>Вася,</span> 20 июня 2012</div>
                    </div>
                    </div>
                    </div>
                </div>
            </div>
            <div class='clear'></div>
        </div>
    </div>
HTML;

get_footer();
?>