<?php

/*
Gig Cable Label Class demo
 */
require_once 'gigcablelabel.class.php';
    if (array_key_exists('print', $_GET)) {
        $label=json_decode($_GET['print']);
        $img=str_replace(' ', '+', $label->img);
        $x=$label->x;
        $y=$label->y;
        $width=$label->width;
        $height=$label->height;
        header("Content-Type: text/html");
        echo '<!DOCTYPE HTML>';
        $table='<table>';
        for ($a=0;$a < $y; $a++) {
            $table.='<tr>';
            for ($b=0; $b < $x; $b++) {
                $table.='<td style="width:'.$width.'; height: '.$height.';" ><img style="width:'.$width.'; height: '.$height.';" src="'.$img.'" /></td>';
            }
            $table.='</tr>';
        }
        $w=str_replace('in', '', $width)*$x;
        $h=str_replace('in', '', $height)*$y;
        echo <<<HTML
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="Content-Language" content="en-us" />
        <title>Print Page</title>
        <style type="text/css">
         body, table, tbody, td,tr { margin: 0; padding: 0; border-width:0; border-spacing: 0; border-collapse:collapse; }
      
         table {
            position: absolute;
            top:0;
            margin-right: auto;
            margin-left: auto;
            width: $w in;
            height: $h in;
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
    }

    if (array_key_exists('label', $_GET)) {
        $label=new GigCableLabel($_GET['label']);
    } else {
        $label=new GigCableLabel();       
    }
    $label->qr=TRUE;
    if (array_key_exists('level',$_GET) && isset($_GET['level'])) $label->errorCorrectionLevel=$_GET['level'];
    if (array_key_exists('size', $_GET) && isset($_GET['size'])) $label->matrixPointSize= $_GET['size'];
    if (array_key_exists('unit', $_GET) && isset($_GET['unit'])) $label->unit= $_GET['unit'];
    if (array_key_exists('desc', $_GET) && isset($_GET['desc']) && trim($_GET['desc']) != '')  $label->desc=trim($_GET['desc']);
        
    $label->make_label();

    exit();
?>
