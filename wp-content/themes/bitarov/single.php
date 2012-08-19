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
$post_category_id = bt_post_category($post->ID);
$breadcrumbs = "<span class='current'><a href='" . SITE_URL . "'><ins></ins>bitarov.as</a></span>";
foreach (get_cat_path($post_category_id) as $cat)
  $breadcrumbs .= "<span><a href='" . get_category_link($cat->term_id) . "'>{$cat->name}</a><ins class='r'></ins></span>";
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
<?php
$post_category = get_category($post_category_id);
$post_category_link = get_category_link($post_category_id);
$liked_arr = new WP_Query(array('posts_per_page'=>get_option('bt_liked_pp'), 'cat'=>$post_category_id, 'post__not_in'=>array($post->ID)));
$liked = '';
while ($liked_arr->have_posts())
 {
 $liked_arr->the_post();
 $liked .= "<li><a href='" . get_permalink($post->ID) . "'>" . get_the_title() . "</a></li>\n                        ";
 }
if ($liked) echo <<<HTML
                <div class='like_records'>
                    <h3><strong>похожие записи</strong></h3>
                    <span>из рубрики <a href="$post_category_link">{$post_category->name}</a></span>
                    <ul>
                        $liked
                    </ul>
                </div>
HTML;
?>
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