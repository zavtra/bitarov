<?php require TEMPLATEPATH . '/head.php'; ?>

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