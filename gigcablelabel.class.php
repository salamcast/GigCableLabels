<?php

/**
 Generates a Resister code based Image based on a number
 */
require_once 'phpqrcode/qrlib.php';
class GigCableLabel {
    private $id=array();
    /**
     * @param array $color resistor color code matching to text color
     */
    private $color;
    /**
     * @param array $hex these colours are based on the resister code colors
     */
    private $hex;
    
    private $arg=array();
    
    
    function __construct($size='', $code="NA") {
        $this->qr=FALSE;
        $this->unit='';
        $this->url='http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
        $this->error='';
        $this->title=__CLASS__;
        if ($size=='') {
            echo $this;
            exit();
        }
        $this->size=$size;

        $this->hex=parse_ini_file(__CLASS__.'/data.ini');
        // set colour codes
        switch ($code) {
            case 'NA':
            default:
                $this->color=parse_ini_file(__CLASS__.'/north_america.ini', TRUE);                
            break;
        }
        foreach (glob(__CLASS__.'/ui-*.ini') as $c) {   
            $this->id[]=str_replace(array(__CLASS__,'.ini', '/ui-' ), array('','',''), $c);
        }

        return TRUE;
    }
    
    function __set($name, $value='') {
        switch ($name) {
            case 'errorCorrectionLevel':
                if (in_array($value, array('L','M','Q','H'))) {
                    $this->arg[$name]= $value;
                } else { $this->arg[$name]='H'; }
            break;
            case 'matrixPointSize':
                if ($value < 41 && $value > 0) { $this->arg[$name]= min(max((int)$value, 1), 40); }
            break;
            case 'desc':
                $c=strlen($value);
                    // these numbers are based on the maximum alphanumeric per qrcode ECC Level
                    // 

                switch ($this->errorCorrectionLevel) {
                    case 'L':
                        switch ($c) {
case $c < 25:$this->matrixPointSize=1;  break;
case $c < 47:$this->matrixPointSize=2;  break;
case $c < 77:$this->matrixPointSize=3;  break;
case $c < 114:$this->matrixPointSize=4;  break;
case $c < 154:$this->matrixPointSize=5;  break;
case $c < 195:$this->matrixPointSize=6;  break;
case $c < 224:$this->matrixPointSize=7;  break;
case $c < 279:$this->matrixPointSize=8;  break;
case $c < 335:$this->matrixPointSize=9;  break;
case $c < 395:$this->matrixPointSize=10;  break;
case $c < 468:$this->matrixPointSize=11;  break;
case $c < 535:$this->matrixPointSize=12;  break;
case $c < 619:$this->matrixPointSize=13;  break;
case $c < 667:$this->matrixPointSize=14;  break;
case $c < 758:$this->matrixPointSize=15;  break;
case $c < 854:$this->matrixPointSize=16;  break;
case $c < 938:$this->matrixPointSize=17;  break;
case $c < 1046:$this->matrixPointSize=18;  break;
case $c < 1153:$this->matrixPointSize=19;  break;
case $c < 1249:$this->matrixPointSize=20;  break;
case $c < 1352:$this->matrixPointSize=21;  break;
case $c < 1460:$this->matrixPointSize=22;  break;
case $c < 1588:$this->matrixPointSize=23;  break;
case $c < 1704:$this->matrixPointSize=24;  break;
case $c < 1853:$this->matrixPointSize=25;  break;
case $c < 1990:$this->matrixPointSize=26;  break;
case $c < 2132:$this->matrixPointSize=27;  break;
case $c < 2223:$this->matrixPointSize=28;  break;
case $c < 2369:$this->matrixPointSize=29;  break;
case $c < 2520:$this->matrixPointSize=30;  break;
case $c < 2677:$this->matrixPointSize=31;  break;
case $c < 2840:$this->matrixPointSize=32;  break;
case $c < 3009:$this->matrixPointSize=33;  break;
case $c < 3183:$this->matrixPointSize=34;  break;
case $c < 3351:$this->matrixPointSize=35;  break;
case $c < 3537:$this->matrixPointSize=36;  break;
case $c < 3729:$this->matrixPointSize=37;  break;
case $c < 3927:$this->matrixPointSize=38;  break;
case $c < 4087:$this->matrixPointSize=39;  break;
case $c < 4296:$this->matrixPointSize=40;  break;
default: return FALSE;
                        }
                    break;
                    case 'H':
                        switch ($c) {
case $c < 10:$this->matrixPointSize=1;  break;
case $c < 20:$this->matrixPointSize=2;  break;
case $c < 35:$this->matrixPointSize=3;  break;
case $c < 50:$this->matrixPointSize=4;  break;
case $c < 64:$this->matrixPointSize=5;  break;
case $c < 84:$this->matrixPointSize=6;  break;
case $c < 93:$this->matrixPointSize=7;  break;
case $c < 122:$this->matrixPointSize=8;  break;
case $c < 143:$this->matrixPointSize=9;  break;
case $c < 174:$this->matrixPointSize=10;  break;
case $c < 200:$this->matrixPointSize=11;  break;
case $c < 227:$this->matrixPointSize=12;  break;
case $c < 259:$this->matrixPointSize=13;  break;
case $c < 283:$this->matrixPointSize=14;  break;
case $c < 321:$this->matrixPointSize=15;  break;
case $c < 365:$this->matrixPointSize=16;  break;
case $c < 408:$this->matrixPointSize=17;  break;
case $c < 452:$this->matrixPointSize=18;  break;
case $c < 493:$this->matrixPointSize=19;  break;
case $c < 557:$this->matrixPointSize=20;  break;
case $c < 587:$this->matrixPointSize=21;  break;
case $c < 640:$this->matrixPointSize=22;  break;
case $c < 672:$this->matrixPointSize=23;  break;
case $c < 744:$this->matrixPointSize=24;  break;
case $c < 779:$this->matrixPointSize=25;  break;
case $c < 864:$this->matrixPointSize=26;  break;
case $c < 910:$this->matrixPointSize=27;  break;
case $c < 958:$this->matrixPointSize=28;  break;
case $c < 1016:$this->matrixPointSize=29;  break;
case $c < 1080:$this->matrixPointSize=30;  break;
case $c < 1150:$this->matrixPointSize=31;  break;
case $c < 1226:$this->matrixPointSize=32;  break;
case $c < 1307:$this->matrixPointSize=33;  break;
case $c < 1394:$this->matrixPointSize=34;  break;
case $c < 1431:$this->matrixPointSize=35;  break;
case $c < 1530:$this->matrixPointSize=36;  break;
case $c < 1591:$this->matrixPointSize=37;  break;
case $c < 1658:$this->matrixPointSize=38;  break;
case $c < 1774:$this->matrixPointSize=39;  break;
case $c < 1852:$this->matrixPointSize=40;  break;
default: return FALSE;
                        }
                    break;
                    case 'Q':
                        switch ($c) {
case $c < 16:$this->matrixPointSize=1;  break;
case $c < 29:$this->matrixPointSize=2;  break;
case $c < 47:$this->matrixPointSize=3;  break;
case $c < 67:$this->matrixPointSize=4;  break;
case $c < 87:$this->matrixPointSize=5;  break;
case $c < 108:$this->matrixPointSize=6;  break;
case $c < 125:$this->matrixPointSize=7;  break;
case $c < 157:$this->matrixPointSize=8;  break;
case $c < 189:$this->matrixPointSize=9;  break;
case $c < 221:$this->matrixPointSize=10;  break;
case $c < 259:$this->matrixPointSize=11;  break;
case $c < 296:$this->matrixPointSize=12;  break;
case $c < 352:$this->matrixPointSize=13;  break;
case $c < 376:$this->matrixPointSize=14;  break;
case $c < 426:$this->matrixPointSize=15;  break;
case $c < 470:$this->matrixPointSize=16;  break;
case $c < 531:$this->matrixPointSize=17;  break;
case $c < 574:$this->matrixPointSize=18;  break;
case $c < 644:$this->matrixPointSize=19;  break;
case $c < 702:$this->matrixPointSize=20;  break;
case $c < 742:$this->matrixPointSize=21;  break;
case $c < 823:$this->matrixPointSize=22;  break;
case $c < 890:$this->matrixPointSize=23;  break;
case $c < 963:$this->matrixPointSize=24;  break;
case $c < 1041:$this->matrixPointSize=25;  break;
case $c < 1094:$this->matrixPointSize=26;  break;
case $c < 1172:$this->matrixPointSize=27;  break;
case $c < 1263:$this->matrixPointSize=28;  break;
case $c < 1322:$this->matrixPointSize=29;  break;
case $c < 1429:$this->matrixPointSize=30;  break;
case $c < 1499:$this->matrixPointSize=31;  break;
case $c < 1618:$this->matrixPointSize=32;  break;
case $c < 1700:$this->matrixPointSize=33;  break;
case $c < 1787:$this->matrixPointSize=34;  break;
case $c < 1867:$this->matrixPointSize=35;  break;
case $c < 1966:$this->matrixPointSize=36;  break;
case $c < 2071:$this->matrixPointSize=37;  break;
case $c < 2181:$this->matrixPointSize=38;  break;
case $c < 2298:$this->matrixPointSize=39;  break;
case $c < 2420:$this->matrixPointSize=40;  break;
default: return FALSE;
                        }
                    break;
                    case 'M':
                        switch ($c) {
case $c < 20:$this->matrixPointSize=1;  break;
case $c < 38:$this->matrixPointSize=2;  break;
case $c < 61:$this->matrixPointSize=3;  break;
case $c < 90:$this->matrixPointSize=4;  break;
case $c < 122:$this->matrixPointSize=5;  break;
case $c < 154:$this->matrixPointSize=6;  break;
case $c < 178:$this->matrixPointSize=7;  break;
case $c < 221:$this->matrixPointSize=8;  break;
case $c < 262:$this->matrixPointSize=9;  break;
case $c < 311:$this->matrixPointSize=10;  break;
case $c < 366:$this->matrixPointSize=11;  break;
case $c < 419:$this->matrixPointSize=12;  break;
case $c < 483:$this->matrixPointSize=13;  break;
case $c < 528:$this->matrixPointSize=14;  break;
case $c < 600:$this->matrixPointSize=15;  break;
case $c < 656:$this->matrixPointSize=16;  break;
case $c < 734:$this->matrixPointSize=17;  break;
case $c < 816:$this->matrixPointSize=18;  break;
case $c < 909:$this->matrixPointSize=19;  break;
case $c < 970:$this->matrixPointSize=20;  break;
case $c < 1035:$this->matrixPointSize=21;  break;
case $c < 1134:$this->matrixPointSize=22;  break;
case $c < 1248:$this->matrixPointSize=23;  break;
case $c < 1326:$this->matrixPointSize=24;  break;
case $c < 1451:$this->matrixPointSize=25;  break;
case $c < 1542:$this->matrixPointSize=26;  break;
case $c < 1637:$this->matrixPointSize=27;  break;
case $c < 1732:$this->matrixPointSize=28;  break;
case $c < 1839:$this->matrixPointSize=29;  break;
case $c < 1994:$this->matrixPointSize=30;  break;
case $c < 2113:$this->matrixPointSize=31;  break;
case $c < 2238:$this->matrixPointSize=32;  break;
case $c < 2369:$this->matrixPointSize=33;  break;
case $c < 2506:$this->matrixPointSize=34;  break;
case $c < 2632:$this->matrixPointSize=35;  break;
case $c < 2780:$this->matrixPointSize=36;  break;
case $c < 2894:$this->matrixPointSize=37;  break;
case $c < 3054:$this->matrixPointSize=38;  break;
case $c < 3220:$this->matrixPointSize=39;  break;
case $c < 3391:$this->matrixPointSize=40;  break;
default: return FALSE;
                        }
                    break;
                }
                $this->arg[$name]=$value;
            break;
            default: $this->arg[$name]=$value; break;
        }
        return TRUE;
    }
    
    function __get($name) {
        switch ($name) {
            case 'matrixPointSize':
             if (!array_key_exists($name, $this->arg)) return 2;
            break;
            case 'errorCorrectionLevel':
             if (!array_key_exists($name, $this->arg)) return 'H';
            break;
            case 'width':
             if (!array_key_exists($name, $this->arg)) return 40;
            break;
            case 'height':
             if (!array_key_exists($name, $this->arg)) return 80;
            break;
            case 'size':
             if (!array_key_exists($name, $this->arg)) return 10;
            break;
            case 'desc':
             if (!array_key_exists($name, $this->arg)) return 'No data has be cued for QR encoding';
            break;
        }
        if (array_key_exists($name, $this->arg)) { return $this->arg[$name]; }
        return;
    }
    
    static function print_page($width, $height,$x,$y,$img_style, $imgdata) {
        if (!ctype_alnum ($width)) return FALSE;
        if (!ctype_alnum ($height)) return FALSE;
        if ( ! is_numeric($x)) return FALSE;
        if ( ! is_numeric($y)) return FALSE;
        if ( ! is_string($img_style)) return FALSE;
        if ( ! is_string($imgdata)) return FALSE;
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
                $table.='<td '.$id.' '.$class.'><img '.$id_img.' '.$class_img.' src="'.$imgdata.'" /></td>';
            }
            $table.='</tr>';
        }
        $table.='</table>';
        header("Content-Type: text/html");
        echo '<!DOCTYPE HTML>';
        echo <<<HTML
<html>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta http-equiv="Content-Language" content="en-us" />
  <title>Print Page</title>
  <style type="text/css">
   body, table, tbody, td, tr { margin: 0; padding: 0; border-width:0; border-spacing: 0; border-collapse:collapse; }
   table { position: absolute; top:0; left:0; }
   td{ width: $width; height: $height; }
   img { $img_style }
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

    /**
     * make the image label with width from $_GET
     */
    function make_label() {
       $w=0;
       $s=str_split($this->size.$this->unit);
       $width=$this->width*count($s);
       if ($this->qr != '') {
        // user data
        $QRfile = '.QRcode-'.md5($this->desc.'|'.$this->errorCorrectionLevel.'|'.$this->matrixPointSize).'.png';
        QRcode::png($this->desc, $QRfile, $this->errorCorrectionLevel, $this->matrixPointSize, 2);
        if (is_file($QRfile)) {
         $qrstmp=imagecreatefrompng($QRfile);
         // @link http://ca3.php.net/manual/en/image.examples-watermark.php
         $marge_right = 0;
         $marge_bottom = 0;
         $sx = imagesx($qrstmp);
         $sy = imagesy($qrstmp);
         list($w_qr, $h_qr, $type, $attr) = getimagesize($QRfile);
         $this->height=$h_qr;
         $width+=$w_qr;
        }
       } else {
         $this->height=80;
       }
       $stamp = imagecreatetruecolor($width, $this->height);
       foreach ($s as $k) {
        $bg_bin= $this->get_bg($k);
        $txt_bin= $this->get_txt($k);
        $bg = ImageColorAllocate($stamp, $bg_bin[0],  $bg_bin[1],  $bg_bin[2]);
        $txt= ImageColorAllocate($stamp, $txt_bin[0], $txt_bin[1], $txt_bin[2]);
        imagefilledrectangle($stamp, $w, 0, $w+$this->width, $this->height, $bg);
        $t=0;
        while ($t < $this->height) {
           $h=round($this->width/2);
           imagestring($stamp, 5, $w+$h-5, $t, $k, $txt);
           $t+=15;
        }
        $w+=$this->width;
       }
       if ($this->qr != '') {
         // user data
         // Copy the stamp image onto our photo using the margin offsets and the photo 
         // width to calculate positioning of the stamp.
         imagecopy($stamp, $qrstmp, imagesx($stamp) - $sx - $marge_right, imagesy($stamp) - $sy - $marge_bottom, 0, 0, imagesx($qrstmp), imagesy($qrstmp));
       }
       
       $this->im=$stamp;
       $filename='.'.$this->size.'-'.__CLASS__.'.png';
       imagepng($this->im, $filename);
       imagedestroy($this->im);
       $imgbinary = fread(fopen($filename, "r"), filesize($filename));
       $this->label='data:image/png;base64,' . base64_encode($imgbinary);

       if (is_file($filename)) unlink($filename);
       if ($this->qr != '' && is_file($QRfile)) unlink($QRfile);
       $json=array(
        'img'=> $this->label,
        'width' => $width,
        'height' => $this->height
        );
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
        header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT"); 
        header("Cache-Control: no-cache, must-revalidate"); 
        header("Pragma: no-cache");
        header("Content-type: application/json");
        $j= json_encode($json);
        //So, you'll have to unescape slashes: 
//$j = str_replace("\/","\\\/",$j); 

//Then, for the trick, escape doule quotes 
//$j = str_replace('"','\\\\"',$j);
echo $j;
        exit();
    }
    
    static function dir() { return './Projects';}
    /**
     *  builds a JSON document of all found ini
     */
    static function load_ui() {
        $ui=__CLASS__.'/ui.ini';
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
        header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT"); 
        header("Cache-Control: no-cache, must-revalidate"); 
        header("Pragma: no-cache");
        header("Content-type: application/json");
        $ini=parse_ini_file($ui, TRUE);
        // select box ini files
        $x=0;
        
        foreach (glob(self::dir().'/*', GLOB_ONLYDIR) as $d) {
            $t=str_replace(array(self::dir().'/'), array(''), $d);
            if ($t == 'DEFAULT') {
                $ini['list_name'][$x]['selected']="selected";
            } else {
                $ini['list_name'][$x]['selected']="";                
            }
            $ini['list_name'][$x]['text']=$t;
            $ini['list_name'][$x]['value']=$t;
            $x++;
        }
        //$ini['list_name'][$x]['selected']="";             
        //$ini['list_name'][$x]['text']="Add New Project";
        //$ini['list_name'][$x]['value']='add_proj';
        foreach (glob(__CLASS__.'/ui-*.ini') as $c) {
            $id=str_replace(array(__CLASS__,'.ini', '/ui-' ), array('','',''), $c);
            $i=parse_ini_file($c, TRUE);
            foreach($i as $ii){
                $ini[$id][]=$ii;
            }
        }
        echo json_encode($ini);
        exit();
    }
    
    function get_bg($k) {
        if (array_key_exists($k, $this->color))   return  $this->get_desc($this->color[$k]['code']);
        return  $this->get_desc($this->color['N']['code']);
    }
    
    function get_txt($k) {
       if (array_key_exists($k, $this->color))    return $this->get_desc($this->color[$k]['text']);
        return $this->get_desc($this->color['N']['text']);
    }
    
    function get_desc($color) {
        $hexcolor = str_split($this->hex[$color], 2); 
        // Convert HEX values to DECIMAL 
        $bincolor=array();
        $bincolor[0] = hexdec("0x{$hexcolor[0]}"); 
        $bincolor[1] = hexdec("0x{$hexcolor[1]}"); 
        $bincolor[2] = hexdec("0x{$hexcolor[2]}"); 
        return $bincolor;
    }
}
// --------------------------------------------------------
// Demo Tester
// --------------------------------------------------------
    //    if (array_key_exists('label', $_GET)) {
    //        $label=new GigCableLabel($_GET['label']);
    //    } else {
    //        $label=new GigCableLabel();       
    //    }
    //    // allow customize
    //    // $this->customize=TRUE;
    //
    //
    //    $label->make_label();
    //    exit();
?>
