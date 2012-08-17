<?php get_header(); ?>

<!-- контент -->
    <div class='content'>
        <div class='event-header'>
            <div class='wrap'>
                <div class='b-top-left'>
                    <div class='breadcrumbs'>
                        <span class='current'><a href='/'><ins></ins><?php echo preg_replace('/^www\./', '', $_SERVER['HTTP_HOST']); ?></a></span>
<?php
$current_post = $post;
while (true)
 {
 $link = get_permalink($current_post->ID);
 echo "<span><a href='$link'>{$current_post->post_title}</a><ins class='r'></ins></span>";
 if ($current_post->post_parent<1) break;
 else $current_post = get_post($current_post->post_parent);
 }
?>
                    </div>
                    <h2><?php echo $current_post->post_title; ?></h2>
                </div>
                <div class='clear'></div>
            </div>
        </div>
        <div class='wrap'>
            <div class='contacts'>
<?php
the_post();
the_content();
?>
            </div>
        </div>

    </div>

<?php get_footer(); ?>