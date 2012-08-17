<?php get_header(); ?>

<!-- контент -->
    <div class='content'>
<?php
$bt_page_breadcrumbs = intval(get_post_meta($post->ID, 'bt_page_breadcrumbs', true));
$bt_page_title = intval(get_post_meta($post->ID, 'bt_page_title', true));
$page_breadcrumbs = $page_title = '';
if ($bt_page_breadcrumbs)
 {
 $current_post = $post;
 $breadcrumbs = '';
 while (true)
  {
  $link = get_permalink($current_post->ID);
  $breadcrumbs = "<span><a href='$link'>{$current_post->post_title}</a><ins class='r'></ins></span>$breadcrumbs";
  if ($current_post->post_parent<1) break;
  else $current_post = get_post($current_post->post_parent);
  }
 $breadcrumbs = "<span class='current'><a href='" . SITE_URL . "'><ins></ins>" . REQUEST_HOST . "</a></span>$breadcrumbs";
 $page_breadcrumbs = "                    <div class='breadcrumbs'>\n                        $breadcrumbs\n                    </div>\n";
 }
if ($bt_page_title) $page_title = "                    <h2>{$post->post_title}</h2>";

if ($page_breadcrumbs or $page_title) echo <<<HTML
<div class='event-header'>
            <div class='wrap'>
                <div class='b-top-left'>
$page_breadcrumbs
$page_title
                </div>
                <div class='clear'></div>
            </div>
</div>
<div class='event-bottom-img'></div>
HTML;

?>
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