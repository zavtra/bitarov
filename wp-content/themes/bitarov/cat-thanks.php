<?php
get_header();

// ----------------------------------------------------------------- Шапка фонда
ob_start();
require TEMPLATEPATH . '/fund-header.php';
$fund_header = ob_get_contents();
ob_end_clean();

// --------------------------------------------------------------- Благодарности
$res = db_query("SELECT id, caption, text FROM pref_bt_thanks ORDER BY pos");
$slides_count = $res['cnt'] / 4;
if (is_float($slides_count)) $slides_count = intval($slides_count)+1;
$thank_slides = '';
for ($current_slide=1; $current_slide<=$slides_count; $current_slide++)
 {
 $miniblock1 = $miniblock2 = $miniblock3 = $miniblock4 = '';
 for ($j=1; $j<=4; $j++) if (extract(db_result($res, 'i,h,h')))
  {
  $var = "miniblock$j";
  $$var = <<<HTML
                                        <td class='miniblock'><dl>
                                            <dt><img src='wp-content/uploads/thanks/$id.png' width='100' height='100' alt='' /></dt>
                                            <dd>
                                                <span class='name'>$caption</span>
                                                <span class='text'>$text</span>
                                            </dd>
                                        </dl></td>
HTML;
  }

 $thank_slides .= <<<HTML
                        <div class='slide1'>
                            <table>
                                <tbody>
                                    <tr>
$miniblock1
$miniblock2
                                    </tr>
                                    <tr>
$miniblock3
$miniblock4
                                    </tr>
                                </tbody>
                            </table>
                        </div>
HTML;

 }

// -------------------------------------------------------------- Вывод страницы

echo <<<HTML

<!-- контент -->
    <div class='content'>

$fund_header

                <div class='slider_container'>
                    <div id='fond-slider'>
$thank_slides
                    </div>
                    <div class='border-bottom'><img src="wp-content/themes/Bitarov/images/css/bitarov_fond-slova_border_bottom.png" width="1000" height="4" alt="" /></div>
                </div>
            </div>
        </div>
    </div>

HTML;

get_footer();
?>