<?php
// Версия 1.002

function direct_query($query)
 {
 global $wpdb;
 if (empty($wpdb->dbh) or !is_resource($wpdb->dbh)) return false;
 $rt = get_resource_type($wpdb->dbh);
 if ($rt!='mysql link' and $rt!='mysql link persistent') return false;
 $wpdb->num_queries++;
 $result = array(
   'conn'  => $wpdb->dbh,
   'res'   => mysql_query($query, $wpdb->dbh),
   'err'   => mysql_errno($wpdb->dbh),
   'query' => $query
 );
 if ($result['err']===0)
  {
  $result['errstr'] = '';
  $result['cnt'] = is_resource($result['res']) ? mysql_num_rows($result['res']) : 0;
  $result['news'] = mysql_affected_rows($wpdb->dbh);
  }
 else
  {
  $result['errstr'] = mysql_error($wpdb->dbh);
  $result['cnt'] = 0;
  $result['news'] = 0;
  }
 return $result;
 }

function db_query($query)
 {
 global $wpdb;
 $args = func_get_args();
 unset($args[0]);
 $query = str_replace('pref_', $wpdb->base_prefix, $query);
 $query = preg_split('/\?([0-9]+)/', $query, 0, PREG_SPLIT_DELIM_CAPTURE);
 $cnt = count($query);
 if ($cnt>1) for ($j=1; $j<$cnt; $j+=2) $query[$j] = isset($args[$argnum=intval($query[$j])]) ? mysql_real_escape_string($args[$argnum]) : "?$query[$j]";
 $query = implode('', $query);
 return direct_query($query);
 }

function db_check()
 {
 $args = func_get_args();
 $res = call_user_func_array('db_query', $args);
 return $res['cnt']>0;
 }

function db_insert($table)
 {
 global $wpdb;
 $argnum = func_num_args();
 if ($argnum<2) return false;
 $query = "INSERT INTO {$wpdb->base_prefix}$table VALUES(";
 for ($j=1; $j<$argnum; $j++)
  {
  $col = func_get_arg($j);
  $query .= is_null($col) ? 'null,' : ("'" . mysql_escape_string($col) . "',");
  }
 $query[strlen($query)-1] = ')';
 $res = direct_query($query);
 return $res['err']===0;
 }

function db_insert_lid()
 {
 global $wpdb;
 $args = func_get_args();
 if (!$args) $args = array();
 if (!call_user_func_array('db_insert', $args)) return false;
 return mysql_insert_id($wpdb->dbh);
 }

function db_result($res, $convert=false)
 {
 if (!is_array($res) or empty($res['res']) or !is_resource($res['res'])) return array();
 $result = mysql_fetch_array($res['res']);
 if (!is_array($result)) return array();
 $keys = array_keys($result);
 foreach ($keys as $key) if (is_int($key)) unset($result[$key]);
 if (!$convert) return $result;
 $convert = explode(',', strtolower(preg_replace('/\s+/', '', $convert)));
 $j = 0;
 foreach ($result as $field=>$value)
   if (!isset($convert[$j])) break;
   else
    {
    switch ($convert[$j]):
      case 'i' : $result[$field] = intval($value); break;
      case 'f' : $result[$field] = floatval($value); break;
      case 'h' : $result[$field] = htmltext($value); break;
      case 'j' : $result[$field] = js_escape($value); break;
      case 'fn': $result[$field] = ffilt($value); break;
      case 'a' : $result[$field] = array($value); break;
    //case 's': $result[$field] = $value; break;
    endswitch;
    $j++;
    }
 return $result;
 }

function keygen($len=32)
 {
 if ($len<0) return false;
 $result = '';
 for ($j=0; $j<$len; $j++) switch(rand(0, 2)):
   case 0: $result .= chr(rand(97, 122)); break;
   case 1: $result .= chr(rand(65, 90)); break;
   case 2: $result .= chr(rand(48, 57)); break;
 endswitch;
 return $result;
 }

function chkget($params, $only=false)
 {
 $params = explode(',', $params);
 foreach ($params as $n=>$param)
   if ($param=trim($param)) {if (!isset($_GET[$param])) return false;}
   else unset($params[$n]);
 if ($only) foreach ($_GET as $k=>$v) if (!in_array($k, $params)) return false;
 return true;
 }

function chkpost($params, $only=false)
 {
 $params = explode(',', $params);
 foreach ($params as $n=>$param)
   if ($param=trim($param)) {if (!isset($_POST[$param])) return false;}
   else unset($params[$n]);
 if ($only) foreach ($_POST as $k=>$v) if (!in_array($k, $params)) return false;
 return true;
 }

function eg($params, $all=true, $trim=true)
 {
 $params = explode(',', $params);
 $result = array();
 foreach ($params as $param)
  {
  $params = explode('>', $param, 3);
  $param = trim($params[0]);
  $as = trim(empty($params[1]) ? $param : $params[1]);
  if (!$as) $as = $param;
  $type = empty($params[2]) ? '' : trim(strtolower($params[2]));
  if (!$param or !isset($_GET[$param]))
    if ($all) return false;
    else continue;
  $_GET[$param] = stripslashes($_GET[$param]);
  if ($trim) $_GET[$param] = trim($_GET[$param]);
  if ($type=='i') $result[$as] = intval($_GET[$param]);
  elseif ($type=='f' ) $result[$as] = floatval($_GET[$param]);
  elseif ($type=='h' ) $result[$as] = htmltext($_GET[$param]);
  elseif ($type=='j' ) $result[$as] = js_escape($_GET[$param]);
  elseif ($type=='fn') $result[$as] = ffilt($_GET[$param]);
  elseif ($type=='a' ) $result[$as] = (array)$_GET[$param];
  else $result[$as] = $_GET[$param]; // s
  }
 return $result;
 }

function ep($params, $all=true, $trim=true)
 {
 $params = explode(',', $params);
 $result = array();
 foreach ($params as $param)
  {
  $params = explode('>', $param, 3);
  $param = trim($params[0]);
  $as = trim(empty($params[1]) ? $param : $params[1]);
  if (!$as) $as = $param;
  $type = empty($params[2]) ? '' : trim(strtolower($params[2]));
  if (!$param or !isset($_POST[$param]))
    if ($all) return false;
    else continue;
  $_POST[$param] = stripslashes($_POST[$param]);
  if ($trim) $_POST[$param] = trim($_POST[$param]);
  if ($type=='i') $result[$as] = intval($_POST[$param]);
  elseif ($type=='f' ) $result[$as] = floatval($_POST[$param]);
  elseif ($type=='h' ) $result[$as] = htmltext($_POST[$param]);
  elseif ($type=='j' ) $result[$as] = js_escape($_POST[$param]);
  elseif ($type=='fn') $result[$as] = ffilt($_POST[$param]);
  elseif ($type=='a' ) $result[$as] = (array)$_POST[$param];
  else $result[$as] = $_POST[$param]; // s
  }
 return $result;
 }

function chklen(&$s, $min=1, $max=255)
 {
 $len = strlen($s);
 return $len>=$min and $len<=$max;
 }

function htmltext($s)
 {
 return htmlspecialchars($s, ENT_QUOTES);
 }

function eol2br($s)
 {
 return str_replace("\n", "<br>\n", $s);
 }

function optlist($items, $default=false, $escape=true)
 {
 $result = '';
 if ($escape) foreach ($items as $value=>$title) $result .= "<option value='" . htmltext($value) . "'" . ($value==$default ? ' selected' : '') . ">" . htmltext($title) . "</option>";
 else foreach ($items as $value=>$title) $result .= "<option value='$value'" . ($value==$default ? ' selected' : '') . ">$title</option>";
 return $result;
 }

function imagecreatefromfile($filename)
 {
 if (!file_exists($filename) or !is_readable($filename)) return false;
 $type = getimagesize($filename);
 if ($type[2]===1) {$type=IMG_GIF; $ih=imagecreatefromgif($filename);}
 elseif ($type[2]===2) {$type=IMG_JPG; $ih=imagecreatefromjpeg($filename);}
 elseif ($type[2]===3) {$type=IMG_PNG; $ih=imagecreatefrompng($filename);}
 else return false;
 return array(
   'ih' => $ih,
   'type' => $type,
   'w' => imagesx($ih),
   'h' => imagesy($ih)
 );
 }

function thumb($ih_src, $maxW, $maxH)
 {
 $maxH = intval($maxH);
 $maxW = intval($maxW);
 if ($maxH<1 or $maxW<1) return false;
 if (!is_resource($ih_src) or get_resource_type($ih_src)!='gd') return false;
 $height = $new_h = imagesy($ih_src);
 $width = $new_w = imagesx($ih_src);
 $k = $height / $width;
 if ($new_w>$maxW) {$new_w=$maxW; $new_h=round($new_w*$k);}
 if ($new_h>$maxH) {$new_h=$maxH; $new_w=round($new_h/$k);}
 if ($new_h<1 or $new_w<1) return false;
 if (!is_resource($ih_dst=imagecreatetruecolor($new_w, $new_h))) return false;
 if ($width<=$maxW and $height<=$maxH)
   {if (imagecopy($ih_dst, $ih_src, 0, 0, 0, 0, $width, $height)) return array('h'=>$new_h, 'w'=>$new_w, 'ih'=>$ih_dst, 'resized'=>false);}
 elseif (imagecopyresampled($ih_dst, $ih_src, 0, 0, 0, 0, $new_w, $new_h, $width, $height)) return array('h'=>$new_h, 'w'=>$new_w, 'ih'=>$ih_dst, 'resized'=>true);
 imagedestroy($ih_dst);
 return false;
 }

function centrize($ih, $maxw, $maxh, $r=0xFF, $g=0xFF, $b=0xFF)
 {
 $img_w = imagesx($ih);
 $img_h = imagesy($ih);
 $result = imagecreatetruecolor($maxw, $maxh);
 imagefill($result, 0, 0, imagecolorallocate($result, $r, $g, $b));
 $new_x = intval(($maxw/2) - (imagesx($ih)/2));
 $new_y = intval(($maxh/2) - (imagesy($ih)/2));
 imagecopy($result, $ih, $new_x, $new_y, 0, 0, $img_w, $img_h);
 return $result;
 }

function format2ext($format)
 {
 $format = intval($format);
 if ($format==IMG_JPG) return '.jpg';
 if ($format==IMG_GIF) return '.gif';
 if ($format==IMG_PNG) return '.png';
 return '.bin';
 }

function correct_eol($text)
 {
 $win = is_int(strpos($text, "\r\n"));
 $mac = is_int(strpos($text, "\r"));
 $nix = is_int(strpos($text, "\n"));
 if ($mac and !$win and !$nix) return str_replace("\r", "\n", $text);
 if ($win) return str_replace("\r\n", "\n", $text);
 return $text;
 }

function redirect($url)
 {
 if (!headers_sent()) header("Location: $url", true);
 die("<script type='text/javascript'>document.location='$url';</script>");
 }

function ismail($email)
 {
 if (!chklen($email, 3, 100)) return false;
 $email = explode('@', $email);
 if (count($email)<>2) return false;
 if (!preg_match('/^[a-zA-Zа-яА-Я0-9\_\.\-]{1,100}$/', $email[0])) return false;
 if (preg_match('/\-\-/', $email[1])) return false;
 $cnt = count($email[1]=explode('.', $email[1]));
 if ($cnt<2) return false;
 $cnt--;
 for ($j=0; $j<$cnt; $j++)
 if (!preg_match('/^[a-zA-Zа-яА-Я0-9]([a-zA-Zа-яА-Я0-9\-]+[a-zA-Zа-яА-Я0-9]|[a-zA-Zа-яА-Я0-9]|)$/', $email[1][$j])) return false;
 return preg_match('/^[a-zA-Zа-яА-Я]{2,10}$/', $email[1][$cnt])===1;
 }

function nospam($text, $utf8=false)
 {
 if ($utf8) $text = utf2win($text);
 $len = strlen($text);
 $arrtext = array();
 $arrseq = array();
 for ($j=0; $j<$len; $j++)
  {
  $char = $text[$j];
  $charcode = ord($text[$j]);
  if ($charcode<128)
    $char = "\\x" . (($charcode<16) ? ('0') : '') . strtoupper(dechex($charcode));
  $arrtext[$j] = $char;
  }
 $shufstr = '';
 for ($j=$len; $j>0; $j--)
  {
  $n = array_rand($arrtext);
  $shufstr .= $arrtext[$n];
  unset($arrtext[$n]);
  $arrseq[]=$n;
  }
 $arrseq = array_flip($arrseq);
 ksort($arrseq);
 if ($utf8) $shufstr = win2utf($shufstr);
 $script  = "<script type='text/javascript'>";
 $script .= "seq=[" . implode(',', $arrseq) . "];";
 $script .= "str=\"$shufstr\";result='';";
 $script .= "for (j=0;j<seq.length;j++)result+=str.charAt(seq[j]);";
 $script .= "document.write(result);";
 $script .= "</script>";
 return $script;
 }

function numsplit($num)
 {
 $num = strrev($num);
 $num = chunk_split($num, 3, ' ');
 return strrev($num);
 }

function xplode($delimiter, $string, $limit)
 {
 $result = explode($delimiter, $string, $limit);
 $cnt = count($result);
 if ($cnt===$limit) return $result;
 for ($j=$cnt; $j<$limit; $j++) $result[$j] = null;
 return $result;
 }

function numberic($number, $words)
 {
 /* Пример параметра $words
 $words = array(
   0 => 'слов',
   1 => 'слово',
   2 => 'слова'
 );
 */
 if (!is_array($words) or !isset($words[0]) or !isset($words[1]) or !isset($words[2])) return false;
 $num = intval($number);
 if ($num<0) $num = -$num;
 if ($num===0) return $number . " $words[0]";
 if ($num===1) return $number . " $words[1]";
 if ($num>=2 and $num<=4) return $number . " $words[2]";
 if ($num>=5 and $num<=19) return $number . " $words[0]";
 $num = intval(substr($num, strlen($num)-1));
 if ($num===0) return $number . " $words[0]";
 if ($num===1) return $number . " $words[1]";
 if ($num>=2 and $num<=4) return $number . " $words[2]";
 return $number . " $words[0]";
 }

// --------------------------------------------------------------- Инициализация

// Проверка работоспособности библиотеки
global $wpdb;
$libpascal = '';
if (empty($wpdb->dbh) or !is_resource($wpdb->dbh)) $libpascal = 'Библиотека libpascal неработоспособна: не найден объект $wpdb';
else
 {
 $rt = get_resource_type($wpdb->dbh);
 if ($rt!='mysql link' and $rt!='mysql link persistent') $libpascal = 'Библиотека libpascal неработоспособна: wordpress на этом сайте использует подключение к базе данных отличной от MySQL';
 }
define('LIBPASCAL', $libpascal);
if (LIBPASCAL) return;

define('BASEDIR', rtrim(str_replace('\\', '/', dirname(dirname(dirname(dirname(__FILE__))))), '/') . '/');
define('SITE_URL', rtrim(get_site_url(), '/') . '/');

?>