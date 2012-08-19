<?php
get_header();
?>

<!-- контент -->
    <div class='content'>
        <div class='event-header'>
            <div class='wrap'>
                <div class='b-top-left'>
                    <div class='breadcrumbs'>
<?php
$categories_path = get_cat_path(bt_post_category($post->ID));
$breadcrumbs = "<span class='current'><a href='" . SITE_URL . "'><ins></ins>bitarov.as</a></span>";
foreach ($categories_path as $cat)
 {
 $breadcrumbs .= "<span><a href='" . get_category_link($cat->term_id) . "'>{$cat->name}</a><ins class='r'></ins></span>";
 }
echo "                    $breadcrumbs";
?>
                    </div>
                    <h2><?php the_title() ?></h2>
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
                    <div class='date'><?php echo rusdate('j F Y', strtotime($post->post_date)); ?></div>
                    <?php the_post(); the_content(); ?>
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

<? get_footer(); ?>