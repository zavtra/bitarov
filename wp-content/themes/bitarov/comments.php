<?php

if (!comments_open()) return;
global $post_id;
$comments_list = '';

if (have_comments())
 {
 $comments_count = count($comments);
 $comments_count_word1 = numberic($comments_count, array('Оставлено', 'Оставлен', 'Оставлено'), true);
 $comments_count_word2 = numberic($comments_count, array('комментариев', 'комментарий', 'комментария'), true);
 foreach ($comments as $comment):
   $comment_author = esc_attr($comment->comment_author);
   $comment_email =  esc_attr($comment->comment_author_email);
   $comment_text = get_comment_text();
   $comment_date = rusdate('j F Y, H:i', strtotime(get_comment_date('Y-m-d H:i')));
   $comments_list .= <<<HTML
                    <div class='comment_div' id='comment-{$comment->comment_ID}'>
                        <div class='comment'>
                            $comment_text
                            <img src='wp-content/themes/bitarov/images/css/comment_hvost.png' alt='' />
                        </div>
                        <div class='user'><span>$comment_author,</span> $comment_date</div>
                    </div>
HTML;
 endforeach;
 $comments_list = <<<HTML
                    <div class='list'>
                        <div class='number_comments'>$comments_count_word1 <span>$comments_count $comments_count_word2</span></div>
                    <div class='wrp-comment_div'>
$comments_list
                    </div>
                    </div>
HTML;
 }

echo <<<HTML
                <div class='wrp-send_comment normal' id='comments'>
                    <div class='send_comment'>
                        <img src='wp-content/themes/bitarov/images/ico/send_comment.png' width='22' height='22' alt='' />
                        <a href='#' onclick='return newcomment()'>Комментировать</a>
                        <span>↓</span>
                    </div>

                    <div class='wrp-artic-comment' style='display:none'>
                        <div class='artic-comment'>
                            <form method='POST' action='/wp-comments-post.php'>
                                <div class='msg'>
                                    <input type='hidden' name='comment_post_ID' value='$post_id'>
                                    <textarea name="comment" placeholder='Комментарий' onfocus="this.className='active'" onblur="this.className='idle'"></textarea>
                                </div>
                                <div class='name'>
                                    <input type="text" name="author" placeholder='Ваше имя' onfocus="this.className='active'" onblur="this.className='idle'" />
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

$comments_list

                </div>
HTML;

?>