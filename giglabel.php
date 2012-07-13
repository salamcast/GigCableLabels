<?php

/*
Gig Cable Label Class demo

 */
/***************************************************************************************************************  
 * HTTP/1.0 2XX Success Pages
*************************************************************************************************************     */
function success_201($url) {
  header("HTTP/1.0 201 Created");
  header("Location: ".$url);
}

/***************************************************************************************************************  
 * HTTP/1.0 4XX Error Pages
*************************************************************************************************************     */
function error_400() {
 header("HTTP/1.0 400 Bad Request");
 echo "<h1>HTTP/1.0 400 Bad Request</h1>";
 echo "This request failed to load this resource<br />";
 echo "Bad Request: ".'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."<br />";
 echo "Go back to the <a href='".'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']."' >Main</a> page";
  exit();
}

function error_403() {
 header("HTTP/1.0 403 Forbidden");
 echo "<h1>HTTP/1.0 403 Forbidden</h1>";
 echo "You're not allowed to request this resource this way <br />";
 echo "Bad Request: ".'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."<br />";
 echo "Go back to the <a href='".'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']."' >Main</a> page";
  exit();
}

function error_404() {
 header("HTTP/1.0 404 Not Found");
 echo "<h1>HTTP/1.0 404 Not Found</h1>";
 echo "Couldn't find the requested resource<br />";
 echo "Requested Resource: ".'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."<br />";
 echo "Go back to the <a href='".'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']."' >Main</a> page";
  exit();
}

function error_405() {
 header("HTTP/1.0 405 Method Not Allowed");
 echo "<h1>HTTP/1.0 405 Method Not Allowed</h1>";
 echo "You're not allowed to do this type of request on this resource<br />";
 echo "Requested Resource: ".'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."<br />";
 echo "Go back to the <a href='".'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']."' >Main</a> page";
  exit();
}

function error_410() {
 header("HTTP/1.0 410 Gone");
 echo "<h1>HTTP/1.0 410 Gone</h1>";
 echo "This Resource is gone<br />";
 echo "Requested Resource: ".'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."<br />";
 echo "Go back to the <a href='".'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']."' >Main</a> page";
  exit();
}

function error_412() {
 header("HTTP/1.0 412 Precondition Failed");
 echo "<h1>HTTP/1.0 412 Precondition Failed</h1>";
 echo "couldn't create/update the resource, try again<br />";
 echo "Requested Resource: ".'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."<br />";
 echo "Go back to the <a href='".'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']."' >Main</a> page";
  exit();
}

function error_413() {
 header("HTTP/1.0 413 Request Entity Too Large");
 echo "<h1>HTTP/1.0 413 Request Entity Too Large</h1>";
 echo "You're discription is too large for this resource<br />- Consider lowering the Error Correction Capability <br />";
 echo "Requested Resource: ".'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."<br />";
 echo "Go back to the <a href='".'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']."' >Main</a> page";
 exit();
}
/***************************************************************************************************************  
 * HTTP application/json header
*************************************************************************************************************     */
function json_header() {
      header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
      header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT"); 
      header("Cache-Control: no-cache, must-revalidate"); 
      header("Pragma: no-cache");
      header("Content-type: application/json");
}
/**   *************************************************************************************************************     */
  /**
  * Genarates an UUID
  * 
  * @author     Anis uddin Ahmad <admin@ajaxray.com>
  * @link       http://www.phpclasses.org/package/4427-PHP-Generate-feeds-in-RSS-1-0-2-0-an-Atom-formats.html ref
  * @param      string  an optional prefix
  * @return     string  the formated uuid
  */
 function uuid($key = null, $prefix ='QR') {
    $key = ($key == null)? 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] : $key;
    $chars = md5($key);
    $uuid  = substr($chars,0,8) . '-';
    $uuid .= substr($chars,8,4) . '-';
    $uuid .= substr($chars,12,4) . '-';
    $uuid .= substr($chars,16,4) . '-';
    $uuid .= substr($chars,20,12);
    return $prefix .'-'. $uuid;
  }

require_once 'gigcablelabel.class.php';
// view switcher
if     (array_key_exists('ORIG_PATH_INFO', $_SERVER)) { $rest=$_SERVER['ORIG_PATH_INFO']; }
elseif (array_key_exists('PATH_INFO', $_SERVER))      { $rest=$_SERVER['PATH_INFO']; } else { $rest=''; }
// imgdata
if  (array_key_exists('QUERY_STRING', $_SERVER)) { $imgdata=$_SERVER['QUERY_STRING']; } else { $imgdata=''; }
// RESTful CRUD access switcher
if  (array_key_exists('REQUEST_METHOD', $_SERVER)) { $method=$_SERVER['REQUEST_METHOD']; } else { $method=''; }

//
$webdir=str_replace($_SERVER['DOCUMENT_ROOT'], '', dirname(__FILE__));
       
//

if ($rest) {
 $r=explode('/', $rest);
 array_shift($r); // drop blank before /
 $page=array_shift($r);
 switch ($page) {
    case 'feed':
     // Make dir
     if($method == 'POST') {
      $p=file_get_contents("php://input");
      $post=json_decode($p, true);
      $dir=GigCableLabel::dir().'/'.$post['project'];
      if (!is_dir($dir)) mkdir($dir, 0750, true);
      success_201('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
     } else {
      $p=array_shift($r);
      if  ($p == '' ) { error_400(); }
      $dir=GigCableLabel::dir().'/'.$p;
      if (!is_dir($dir)) error_404();
     }

     if($method == 'DELETE') {
       $d=glob($dir.'/*.json');
       $f=$dir.'/'.$imgdata.'.json';
       if (in_array($f, $d)) {
        if (is_file($f)) {
         unlink($f);
        } else { error_410(); }
       } else { error_404(); }
       unset($d);
     }
     
     if ($method == 'PUT') {
      $j=file_get_contents("php://input");
      $file=json_decode($j, true);
      if (! array_key_exists('code',$file) && !ctype_alnum ($file['code'])) error_404();
      if (! array_key_exists('width',$file) && !ctype_alnum ($file['width'])) error_404();
      if (! array_key_exists('height',$file) && !ctype_alnum ($file['height'])) error_404();
      if (! array_key_exists('x',$file) && !is_numeric($file['x'])) error_404();
      if (! array_key_exists('y',$file) && !is_numeric($file['y'])) error_404();

      $file['published']=gmdate(DATE_ATOM,time());
      $name=$dir."/".str_replace(':', '|', $file['published']).".json";
      $file['file']=$name;
      $file['url']='http://'.$_SERVER['HTTP_HOST'].$webdir.trim($name, '.');
      $file['id']=uuid($name, $file['code']);
      $file['put']='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
      $file['project']=$p;
      $json=json_encode($file, JSON_ERROR_SYNTAX);
      if (! file_put_contents( $name, $json)) { error_412(); }
      json_header();
      echo $json;
      exit();
    
     } elseif($method == 'DELETE' || $method == 'GET' || $method == 'POST') {
      $uri='http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
      $id=uuid($uri, 'atom');
      $date=gmdate(DATE_ATOM,time());
      json_header();
      $j=glob($dir."/*.json");
      $proj=array();      
      foreach ($j as $c) {
       $link='http://'.$_SERVER['HTTP_HOST'].$webdir.trim($c, '.');
       $f=file_get_contents($c);
       $json=json_decode($f, true);
       $proj[]=$json;
     }
     echo json_encode($proj);
     exit();
     } else { error_405(); }
    break;
    case 'ui.json': GigCableLabel::load_ui(); break;
    case 'print':
        $width=array_shift($r);
        $height=array_shift($r);
        $x=array_shift($r);
        $y=array_shift($r);
        $img_style=array_shift($r);
        GigCableLabel::print_page($width, $height,$x,$y,$img_style,$imgdata) || error_404();    
    break;
    case 'label':
        $code=array_shift($r);
        if (!ctype_alnum ($code)) error_404();
        $label=new GigCableLabel($code);
        $label->make_label();    
    break;
    case 'QR':
        $lvl=array_shift($r);
        if (! ctype_upper($lvl)) error_404();
        $code=array_shift($r);
        if (!ctype_alnum ($code)) error_404();
        $desc=trim(implode('//', $r), '/');
        $label=new GigCableLabel($code);
        $label->qr=TRUE;
        $label->errorCorrectionLevel=$lvl;
        if ($label->desc=trim($desc)) {
          $label->make_label();
        } else { error_413(); }
    break;
 }
 exit();
}
//$label=new GigCableLabel();       
//exit();
?>