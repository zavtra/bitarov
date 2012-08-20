<?php

require 'wp-config.php';

@mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die(mysql_error());
@mysql_select_db(DB_NAME) or die(mysql_error());

$new_host = 'bitarov';
$new_url = "http://$new_host/";

echo mysql_query("UPDATE wp_options SET option_value='$new_url' WHERE option_name='home' OR option_name='siteurl'")
  ? 'OK' : 'FAIL';

?>