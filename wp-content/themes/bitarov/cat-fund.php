<?php get_header();

// ----------------------------------------------------------------- Шапка фонда
ob_start();
require TEMPLATEPATH . '/fund-header.php';
$fund_header = ob_get_contents();
ob_end_clean();

// ---------------------------------------------------------------------- Анонсы
$mons = array(
  1  => 'Января',
  2  => 'Февраля',
  3  => 'Марта',
  4  => 'Апреля',
  5  => 'Мая',
  6  => 'Июня',
  7  => 'Июля',
  8  => 'Августа',
  9  => 'Сентября',
  10 => 'Октября',
  11 => 'Ноября',
  12 => 'Декабря'
);
$exclude = array();
foreach ($subcategories as $subcategory)
 if ($subcategory['id']<>$current_category_id) $exclude[] = $subcategory['id'];
$args = $wp_query->query_vars;
$args['category__not_in'] = array_merge($args['category__not_in'], $exclude);
query_posts($args);
$fund_announces = '';
while (have_posts())
 {
 the_post();
 $d = intval(get_post_meta($post->ID, 'bt_fund_announce_d', true));
 $m = intval(get_post_meta($post->ID, 'bt_fund_announce_m', true));
 if (isset($mons[$m]) and $d>=1 and $d<=31) $date = "$d<span>$mons[$m]</span>";
 else $date = '';
 $title = get_the_title();
 $content = bt_post_content();
 $fund_announces .= <<<HTML
                    <dl>
                        <dt><div>$date</div></dt>
                        <dd>
                            <h3>$title</h3>
                            <p>$content</p>
                        </dd>
                    </dl>
HTML;
 }

// -------------------------------------------------------------- Вывод страницы

echo <<<HTML

<!-- контент -->
    <div class='content'>

$fund_header

                <div class='items'>
$fund_announces
                </div>
            </div>

        </div>
    </div>

HTML;

get_footer();
?>