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

    private $charmap=array();    
    
    function __construct($size='') {
        // This is where mac OS X has is stored
        if (is_file('/Library/Fonts/Arial Unicode.ttf')) {
            $this->font  = '/Library/Fonts/Arial Unicode.ttf';
        } else {
            // get a copy of this file or set your own ttf font
            // http://www.microsoft.com/typography/fonts/font.aspx?fmid=1081
            // $label->font="<your unicode ttf font>.ttf"
            $this->font  = 'Arial Unicode.ttf';// name of file on Mac OS X Lion
            //$this->font  = 'arialuni.ttf';          
        }
        $this->font_size=16;
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
        // 
        $this->hex=parse_ini_file(__CLASS__.'/data.ini');
        // char map for other character like arabic for number 0-9
        $this->charmap=parse_ini_file(__CLASS__.'/char_map.ini', TRUE);
        // set colour codes
        $this->color=parse_ini_file(__CLASS__.'/colour_code.ini', TRUE);                
       
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
            case 'lang':
//                var_dump($this->charmap); exit();
                $keys=array_keys($this->charmap['0']);
                if (!in_array($value, $keys)) return FALSE;
                $this->arg[$name]=$value;
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
            case 'lang':
             if (!array_key_exists($name, $this->arg)) return 'en'; //'en';
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
       $d='';
//       $s=str_split($this->size.$this->unit);
        $s=str_split($this->size);
        $chars=count($s);
        $this->height=80;
        $width=($this->height/2);
        $this->width=$width*$chars;
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
                $width=($this->height/2);
                $this->width=$width*$chars;
                $this->width+=$w_qr;
                $this->font_size=$width;
            }
        } 
       
        $stamp = imagecreatetruecolor($this->width, $this->height);
        foreach ($s as $k) {
            $bg_bin= $this->get_bg($k);
            $txt_bin= $this->get_txt($k);
            $bg = ImageColorAllocate($stamp, $bg_bin[0],  $bg_bin[1],  $bg_bin[2]);
            $txt= ImageColorAllocate($stamp, $txt_bin[0], $txt_bin[1], $txt_bin[2]);
            imagefilledrectangle($stamp, $w, 0, $w+$width, $this->height, $bg);
            $t=round($this->height/2)+($this->font_size/2);
        
            $tag=$k;
            if (array_key_exists($k, $this->charmap) && array_key_exists($this->lang, $this->charmap[$k])) {
                $tag=strtoupper($this->charmap[$k][$this->lang]);
            } 
            $h=round($this->width/2);
            imagettftext($stamp, $this->font_size, 0, $w+($width/6), $t, $txt, $this->font, $tag);
            $w+=$width;
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
        'width' => $this->width,
        'height' => $this->height
        );
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
        header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT"); 
        header("Cache-Control: no-cache, must-revalidate"); 
        header("Pragma: no-cache");
        header("Content-type: application/json");
        $j= json_encode($json);
        echo $j;
        exit();
    }
    
    static function dir() { return './Projects';}
    /**
     *  builds a JSON document of all found ini
     */
    static function load_ui($lang='en') {
        $ui=__CLASS__.'/'.$lang.'/ui.ini';
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
        header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT"); 
        header("Cache-Control: no-cache, must-revalidate"); 
        header("Pragma: no-cache");
        header("Content-type: application/json");
        $ini=parse_ini_file($ui, TRUE);
        // select box ini files
        $x=0;
        $text=parse_ini_file(__CLASS__.'/'.$lang.'/text.ini');
        foreach ($text as $k => $t) {
            $ini[$k]['text']=$t;
        }
//        if ($lang=='fr') { print_r($ini); exit(); }
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
        
        foreach (glob(__CLASS__.'/'.$lang.'/ui-*.ini') as $c) {
            $id=str_replace(array(__CLASS__,'.ini', '/ui-', '/'.$lang ), array('','','', ''), $c);
            $i=parse_ini_file($c, TRUE);
            foreach($i as $ii){
                $ini[$id][]=$ii;
            }
        }

        // if $lang is fr, switch to en for use of the same latters and numbers
        if ($lang == 'fr') { $lang='en'; }
        
        // char map for numbers
        $charmap=parse_ini_file(__CLASS__.'/numbers.ini', TRUE);

        $x=0;
        $ini["num1"][$x]['selected']="";
        $ini["num1"][$x]['text']='';
        $ini["num1"][$x]['value']='';
        $ini["num2"][$x]['selected']="";
        $ini["num2"][$x]['text']='';
        $ini["num2"][$x]['value']='';
        $ini["num3"][$x]['selected']="";
        $ini["num3"][$x]['text']='';
        $ini["num3"][$x]['value']='';
        $x++;
        foreach( $charmap as $k => $v) {
            $ini["num1"][$x]['selected']="";
            $ini["num1"][$x]['text']=$charmap[$k][$lang];
            $ini["num1"][$x]['value']=$k;
            $ini["num2"][$x]['selected']="";
            $ini["num2"][$x]['text']=$charmap[$k][$lang];
            $ini["num2"][$x]['value']=$k;
            $ini["num3"][$x]['selected']="";
            $ini["num3"][$x]['text']=$charmap[$k][$lang];
            $ini["num3"][$x]['value']=$k;
            $x++;
        }
        // character map
        $charmap=parse_ini_file(__CLASS__.'/char_map.ini', TRUE);
        $x=0;
                $x=0;
        $ini["alphanum1"][$x]['selected']="";
        $ini["alphanum1"][$x]['text']='';
        $ini["alphanum1"][$x]['value']='';
        $ini["alphanum2"][$x]['selected']="";
        $ini["alphanum2"][$x]['text']='';
        $ini["alphanum2"][$x]['value']='';
        $ini["alphanum3"][$x]['selected']="";
        $ini["alphanum3"][$x]['text']='';
        $ini["alphanum3"][$x]['value']='';
        $ini["alphanum4"][$x]['selected']="";
        $ini["alphanum4"][$x]['text']='';
        $ini["alphanum4"][$x]['value']='';
        $ini["alphanum5"][$x]['selected']="";
        $ini["alphanum5"][$x]['text']='';
        $ini["alphanum5"][$x]['value']='';
        $x++;
        foreach( $charmap as $k => $v) {
            $ini["alphanum1"][$x]['selected']="";
            $ini["alphanum1"][$x]['text']=strtoupper($charmap[$k][$lang]);
            $ini["alphanum1"][$x]['value']=$k;
            $ini["alphanum2"][$x]['selected']="";
            $ini["alphanum2"][$x]['text']=strtoupper($charmap[$k][$lang]);
            $ini["alphanum2"][$x]['value']=$k;
            $ini["alphanum3"][$x]['selected']="";
            $ini["alphanum3"][$x]['text']=strtoupper($charmap[$k][$lang]);
            $ini["alphanum3"][$x]['value']=$k;
            $ini["alphanum4"][$x]['selected']="";
            $ini["alphanum4"][$x]['text']=strtoupper($charmap[$k][$lang]);
            $ini["alphanum4"][$x]['value']=$k;
            $ini["alphanum5"][$x]['selected']="";
            $ini["alphanum5"][$x]['text']=strtoupper($charmap[$k][$lang]);
            $ini["alphanum5"][$x]['value']=$k;
            $x++;
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
// functions moved from giglabel.php
// --------------------------------------------------------

/* Gig Cable Label Class demo  */
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
 json_header();
 $http=array();
 $http['header']="HTTP/1.0 400 Bad Request";
 $http['msg']="This request failed to load this resource";
 $http['request']='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
 $http['link']='http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
 echo json_encode($http);
 exit();
}

function error_403($msg='') {
 header("HTTP/1.0 403 Forbidden");
 json_header();
 $http=array();
 $http['header']="HTTP/1.0 403 Forbidden";
 if ($msg=='' || !is_string($msg)) {
  $http['msg']="You're not allowed to request this resource this way "; 
 } else {
   $http['msg']=$msg;
 }
 $http['request']='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
 $http['link']='http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
 echo json_encode($http);
 exit();

}

function error_404() {
 header("HTTP/1.0 404 Not Found");
 json_header();
 $http=array();
 $http['header']="HTTP/1.0 404 Not Found";
 $http['msg']="Couldn't find the requested resource";
 $http['request']='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
 $http['link']='http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
 echo json_encode($http);
 exit();
}

function error_405() {
 header("HTTP/1.0 405 Method Not Allowed");
 json_header();
 $http=array();
 $http['header']="HTTP/1.0 405 Method Not Allowed";
 $http['msg']="You're not allowed to do this type of request on this resource";
 $http['request']='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
 $http['link']='http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
 echo json_encode($http);
 exit();
}

function error_410() {
 header("HTTP/1.0 410 Gone");
 json_header();
 $http=array();
 $http['header']="HTTP/1.0 410 Gone";
 $http['msg']="This Resource is gone";
 $http['request']='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
 $http['link']='http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
 echo json_encode($http);
 exit();
}

function error_412() {
 header("HTTP/1.0 412 Precondition Failed");
 json_header();
 $http=array();
 $http['header']="HTTP/1.0 412 Precondition Failed";
 $http['msg']="couldn't create/update the resource, try again";
 $http['request']='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
 $http['link']='http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
 echo json_encode($http);
 exit();
}

function error_413() {
 header("HTTP/1.0 413 Request Entity Too Large");
 json_header();
 $http=array();
 $http['header']="HTTP/1.0 413 Request Entity Too Large";
 $http['msg']="You're discription is too large for this resource<br />- Consider lowering the Error Correction Capability ";
 $http['request']='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
 $http['link']='http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
 echo json_encode($http);
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

?>
