<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
<title>Битаров - главная</title>
<base href='<?php echo SITE_URL ?>' />
<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
<link href='wp-content/themes/bitarov/styles.css' rel='stylesheet' type='text/css' />
<link href='wp-content/themes/bitarov/template.css' rel='stylesheet' type='text/css' />
<link href='wp-content/themes/bitarov/orbit-1.2.3.css' rel='stylesheet' type='text/css' />
<link href='wp-content/themes/bitarov/jscrollpane.css' rel='stylesheet' type='text/css' />
<link rel='shortcut icon' href='favicon.ico' type='image/x-icon' />
<script src='wp-content/themes/bitarov/js/jquery.min.js' type="text/javascript"></script>
<script src='wp-content/themes/bitarov/js/jquery.orbit-1.2.3.min.js' type="text/javascript"></script>
<script src='wp-content/themes/bitarov/js/jmousewhell.min.js' type="text/javascript"></script>
<script src='wp-content/themes/bitarov/js/jscroll.min.js' type="text/javascript"></script>
<script src='wp-content/themes/bitarov/js/jquery.scrolling-parallax.js' type="text/javascript"></script>
<script src='wp-content/themes/bitarov/js/global.js' type="text/javascript"></script>
</head>
<body>

<div class='container'>
<!-- шапка -->
    <div class='header'>
        <div class='wrap'>  
            <div class='wrp_h_owner'>
                <a href="/"><span class='h_owner'></span></a>
            </div>
			<?php wp_nav_menu('menu=top_right'); ?>
			<?php wp_nav_menu('menu=top_left'); ?>
        </div>
    </div>