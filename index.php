<?php

/*
Gig Cable Label Class demo
 */
require_once 'gigcablelabel.class.php';
// view switcher
if  (array_key_exists('ORIG_PATH_INFO', $_SERVER)) { 
   $rest=$_SERVER['ORIG_PATH_INFO']; 
} elseif  (array_key_exists('PATH_INFO', $_SERVER)) { 
   $rest=$_SERVER['PATH_INFO']; 
} else { $rest=''; }
if  (array_key_exists('QUERY_STRING', $_SERVER)) { 
   $imgdata=$_SERVER['QUERY_STRING']; 
} else {
   $imgdata='';
}
if ($rest) {
 $r=explode('/', $rest);
 array_shift($r);
 $page=array_shift($r);
 switch ($page) {
    case 'print':
        $width=array_shift($r);
        $height=array_shift($r);
        $x=array_shift($r);
        $y=array_shift($r);
        $img_style=array_shift($r);
        $table='<table>';
        for ($a=0;$a < $y; $a++) {
            $table.='<tr>';
            for ($b=0; $b < $x; $b++) {
                if ($a==0 && $b==0) {
                 $id='id="one"';
                 $id_img='id="one_img"';
                 $class='';
                 $class_img='';
                } else {
                 $id='';
                 $id_img='';
                 $class='class="label"';
                 $class_img='class="label_img"';
                }            
                $table.='<td '.$id.' '.$class.' style="width:'.$width.'; height: '.$height.';" ><img '.$id_img.' '.$class_img.'  style="'.$img_style.'" src="'.$imgdata.'" /></td>';
            }
            $table.='</tr>';
        }
        $table.='</table>';
        $w=str_replace('in', '', $width)*$x."in";
        $h=str_replace('in', '', $height)*$y."in";
        $mime="text/html";
        header("Content-Type: ".  $mime);
        echo '<!DOCTYPE HTML>';
        echo <<<HTML
<html>
 <head>
  <meta http-equiv="Content-Type" content="$mime; charset=utf-8" />
  <meta http-equiv="Content-Language" content="en-us" />
  <title>Print Page</title>
  <style type="text/css">
   body, table, tbody, td, tr { margin: 0; padding: 0; border-width:0; border-spacing: 0; border-collapse:collapse; }
      
   table {
            position: absolute;
            top:0;
            margin-right: auto;
            margin-left: auto;
            width:$w;
            height: $h;
   }
  
  </style>
 </head>
 <body>
  $table
 </body>
</html>
HTML
;
     exit();    
    break;

    case 'label':
        $code=array_shift($r);
        $label=new GigCableLabel($code);
        $label->make_label();    
    break;
    case 'QR':
        $lvl=array_shift($r);
        $size=array_shift($r);
        $code=array_shift($r);
        $desc=array_shift($r);
        $label=new GigCableLabel($code);
        //list($a, $page, $width, $height, $x,$y,  $img_style) |array_shift($r);
        $label->qr=TRUE;
        if (isset($width))  $label->errorCorrectionLevel=$lvl;
        if (isset($height)) $label->matrixPointSize= $size;
        if (isset($desc) && trim($desc))  $label->desc=trim($desc);
        $label->make_label();
    break;
 }
 
 
 exit();
}
    $label=new GigCableLabel();       
    exit();
?>
