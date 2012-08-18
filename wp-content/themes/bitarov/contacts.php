<?php
/* Template Name: Контакты */
get_header();
?>

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
                <div class='wrp-karta'>
                    <div class='karta'>
<!-- Этот блок кода нужно вставить в ту часть страницы, где вы хотите разместить карту (начало) -->
<div id="ymaps-map-id_1345180514674467712684"></div>
<script type="text/javascript">function fid_1345180514674467712684(ymaps) {var map = new ymaps.Map("ymaps-map-id_1345180514674467712684", {center: [104.30181382006826, 52.27906285872691], zoom: 16, type: "yandex#map"});map.controls.add("zoomControl").add("mapTools").add(new ymaps.control.TypeSelector(["yandex#map", "yandex#satellite", "yandex#hybrid", "yandex#publicMap"]));map.geoObjects.add(new ymaps.Placemark([104.2805983632738, 52.290168559594015], {balloonContent: "Метка"}, {preset: "twirl#lightblueDotIcon"})).add(new ymaps.Placemark([104.30189965075674, 52.278944407150604], {balloonContent: "Метка"}, {preset: "twirl#lightblueDotIcon"}));};</script>
<script type="text/javascript" src="http://api-maps.yandex.ru/2.0/?coordorder=longlat&load=package.full&wizard=constructor&lang=ru-RU&onload=fid_1345180514674467712684"></script>
<!-- Этот блок кода нужно вставить в ту часть страницы, где вы хотите разместить карту (конец) -->

                    </div>
                </div>
                <div class='rekviziti'>
<?php
the_post();
the_content();
?>
                </div>
            </div>
        </div>

    </div>
<?php get_footer(); ?>