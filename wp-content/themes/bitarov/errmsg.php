<?php
require TEMPLATEPATH . '/head.php';

if (empty($msg)) $msg = 'Произошла ошибка';

echo <<<HTML
<body>
<style type='text/css'>
html, body {width:100%; height:100%; margin:0; padding:0}
.errcenter1 {width:100%; height:100%; text-align:center}
.errcenter2 {margin:auto; max-width:800px; min-width:500px}
.errmsg {border:2px solid #CCC; border-radius:4px; padding:10px 10px; margin:0 50px; text-align:left; font:bold 13px tahoma; color:#333; background:-o-linear-gradient(top,#F8F8F8, #DDD);}
</style>

<table class='errcenter1'><tr><td><div class='errcenter2'>

  <div class='errmsg'>
  $msg<br />
  [ <a href='javascript:history.back(-1)'>Вернуться назад</a> ]
  </div>

</div></td></tr></table>

</body></html>
HTML;

exit;

?>