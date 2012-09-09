<?php
if (!is_category()) return include TEMPLATEPATH . '/404.php';

// Информация о текущей категории
$current_category_id = $id_cat = get_query_var('cat');
$current_category = get_category($id_cat);
$current_cat_link = rtrim(get_category_link($id_cat), '/');
$current_cat_link_opt = $current_cat_link;
$uri_year = chkget('posts-year') ? ('year'.intval($_GET['posts-year']).'/') : '';
$current_cat_path = get_cat_path($current_category_id);
$current_cat_level = count($current_cat_path);

// Число страниц категории
$current_page_number = intval(get_query_var('paged'));
if ($current_page_number<1) $current_page_number = 1;
$per_page = intval(get_query_var('posts_per_page'));
$total_posts = intval($wp_query->found_posts);
if ($per_page>0 and $total_posts>0)
 {
 $pages_count = $total_posts / $per_page;
 if (is_float($pages_count)) $pages_count = intval($pages_count)+1;
 }
else $pages_count = 1;
$category_paginagor = ($pages_count>1) ? gen_pages($current_page_number, $pages_count, 3) : array();
//$category_paginagor = array();
//for ($j=1; $j<=$pages_count; $j++) $category_paginagor[] = $j;

// Подкатегории
$cats = get_categories(array('parent'=>$id_cat, 'hide_empty'=>0));
if (!$cats and $current_category->category_parent>1)
 {
 $cats = get_categories(array('parent'=>$current_category->category_parent, 'hide_empty'=>0));
 $subcategories = array(array('name'=>'Все записи', 'link'=>get_category_link($current_category->category_parent), 'id'=>$current_category->category_parent));
 foreach ($cats as $k=>$v) $subcategories[] = array('name'=>$v->name, 'link'=>get_category_link($v->term_id), 'id'=>$v->term_id);
 }
elseif ($cats)
 {
 $subcategories = array(array('name'=>'Все записи', 'link'=>"$current_cat_link/", 'id'=>$id_cat));
 foreach ($cats as $k=>$v) $subcategories[] = array('name'=>$v->name, 'link'=>get_category_link($v->term_id), 'id'=>$v->term_id);
 }
else $subcategories = array();
unset($cats);

// Выбор шаблона для текущей категории
$cats = get_cat_path($id_cat);
$selected_template = '/cat-default.php';
foreach ($cats as $cat) if (file_exists(TEMPLATEPATH . "/cat-{$cat->slug}.php")) $selected_template = "/cat-{$cat->slug}.php";
include TEMPLATEPATH . $selected_template;

?>