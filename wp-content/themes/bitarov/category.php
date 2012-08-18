<?php
if (!is_category()) return include TEMPLATEPATH . '/404.php';
$id_cat = get_query_var('cat');
$cats = get_cat_path($id_cat);
$selected_template = '/404.php';
foreach ($cats as $cat) if (file_exists(TEMPLATEPATH . "/{$cat->slug}.php")) $selected_template = "/{$cat->slug}.php";
include TEMPLATEPATH . $selected_template;
?>