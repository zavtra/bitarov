<?php get_header(); ?>

<!-- контент -->
    <div class='content'>
        <div class='event-header'>
            <div class='wrap'>
                <div class='b-top-left'>
                    <div class='breadcrumbs'>
                        <span class='current'><a href='#'><ins></ins>bitarov.as</a></span>
                        <span><a href='#'>События</a><ins class='r'></ins></span>
                    </div>
                    <h2>События</h2>
                </div>
                <div class='clear'></div>
            </div>
        </div>
        <div class='event-bottom-img'></div>
        <div class='wrap event'>
            <div class='event-body'>
                <div class='list_items'>

<?php
while (have_posts())
 {
 the_post();
 $title = get_the_title();
 $excerpt = get_the_excerpt();
 $link = get_permalink($post->ID);
 echo <<<HTML
                    <div class='item'>
                        <div class='breadcrumbs'><a href='#'>Фонд Битарова</a> &rarr;</div>
                        <h3><a href='$link'>$title</a></h3>
                        <p>$excerpt</p>
                        <div class='more'><a href='$link'>подробнее</a></div>
                        <div class='date'>12 июня 2012</div> <div class='tag'><img src='wp-content/themes/bitarov/images/ico/event-tag.png' width='22' height='11' alt='' /><a href='#'>Спортивные сооружения</a></div>
                    </div>
HTML;
 }
?>

                    <div class='button-show-old'>
                        <a href='#'>Показать предыдущие события</a>
                        <img src='wp-content/themes/bitarov/images/ico/loading.gif' width='50' height='50' alt='' />
                    </div>
                </div>
                <div class='wrp-rubrikator-fixed'>
                    <div class='paginator'>
                        <ul>
                            <li class='current'><a href='#'>1</a></li>
                            <li><a href='#'>2</a></li>
                            <li><a href='#'>3</a></li>
                            <li><a href='#'>4</a></li>
                            <li><a href='#'>5</a></li>
                        </ul>
                        <div class='clear'></div>
                        <div class='visual'>
                            <div><ins></ins></div>
                        </div>
                    </div>
                    <div class='rubrikator-fixed'>
                        <ul>
                            <li class='current'><span><a href='#'>Все записи</a></span></li>
                            <li><span><a href='#'>Политическая деятельность</a></span></li>
                            <li><span><a href='#'>Благотворительный фонд</a></span></li>
                            <li><span><a href='#'>Поздравления</a></span></li>
                            <li><span><a href='#'>Строительство</a></span></li>
                        </ul>
                    </div>
                    <div class='rubrikator-advanced'>
                        <div class='podate'>
                            <span>по годам:</span>
                            <a href='#'>2012</a> <a href='#'>2011</a> <a href='#'>2010</a>
                        </div>
                        <p id='back-top'>
                            <a href='#top'><span></span></a>
                        </p>
                    </div>
                </div>
                <div class='clear'></div>
            </div>
        </div>
    </div>

<?php get_footer(); ?>