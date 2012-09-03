<?php
require TEMPLATEPATH . '/head.php';

$menu_left = wp_nav_menu(array('menu'=>'top_right', 'echo'=>false));
$menu_right = wp_nav_menu(array('menu'=>'top_left', 'echo'=>false));

$siteurl = SITE_URL;
$mainlink = is_home() ? "<span class='h_owner'></span>" : "<a href='$siteurl'><span class='h_owner'></span></a>";

echo <<<HTML
<body>
<div class='container'>
<!-- шапка -->
    <div class='header'>
        <div class='wrap'>
            <div class='wrp_h_owner'>
                $mainlink
            </div>
        $menu_left
        $menu_right
        </div>
    </div>
HTML;

?>