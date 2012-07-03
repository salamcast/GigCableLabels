<?php

/**
 Generates a Resister code based Image based on a number
 */
require_once 'phpqrcode/qrlib.php';
class GigCableLabel {
//    private $size;
    /**
     * @param array $color resistor color code matching to text color
     */
    private $color=array(
     array(
     'code' =>  'black', //0
     'text' => 'white', //0 black
     ),
     array(
     'code' =>  'brown', //1
     'text' => 'white', //1 brown
     ),
     array(
     'code' =>  'red',   //2
     'text' => 'white', //2 red
     ),
     array(
     'code' =>  'orange',//3
     'text' => 'white', //3 orange
     ),
     array(
     'code' =>  'yellow',//4
     'text' => 'black', //4 yellow
     ),
     array(
     'code' =>  'green', //5
     'text' => 'white' //5 green
     ),
     array(
     'code' =>  'blue',  //6
     'text' => 'white' //6 blue
     ),
     array(
     'code' =>  'violet',//7
     'text' => 'white' //7 violet
     ),
     array(
     'code' =>  'grey',  //8
     'text' => 'black' //8 grey
     ),
     array(
     'code' =>  'white',  //9
     'text' => 'black'  //9 white
     )
    );
    
    //private $code=array();
    //private $code_text=array();
    /**
     * @param array $hex these colours are based on the resister code colors
     * @link http://i86.photobucket.com/albums/k119/blaylocj/Fig2_colorcode.jpg
     */
    private $hex=array(
        'black' => '000000', //0
        'brown' => '990000', //1
        'red'   => 'FF0000', //2
        'orange'=> 'FF6600', //3
        'yellow'=> 'FFFF00', //4
        'green' => '00FF00', //5
        'blue'  => '0000FF', //6
        'violet'=> 'FF00FF', //7
        'grey'  => '808080', //8
        'white' => 'FFFFFF', //9
        'gold'  => 'D4A017', //G
        'silver'=> 'C0C0C0', //S
        'none'  => 'FFFFFF'  //N
    );
    
    private $arg=array();
    
    function __construct($size=10) {
        if (! is_numeric($size)) {
            header("HTTP/1.0 403 Forbidden");
            $this->error="<h1>HTTP/1.0 403 Forbidden</h1><p>You Must enter a number</p><p>You entered: $size</p><hr />";
            $this->title='HTTP/1.0 403 Forbidden';
            echo $this;
            exit();
        }
        $this->size=$size;
        $this->desc=<<<D
Type: 
Uses:
Pins:
Date:
length:
D
        ;
        $this->unit='F';
        $this->url='http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
        $this->error='';
        $this->title=__CLASS__;
        return TRUE;
    }
    
    function __set($name, $value='') {
        switch ($name) {
            case 'errorCorrectionLevel':
                if (in_array($value, array('L','M','Q','H')))  $this->arg[$name]= $value;                    
            break;
            case 'matrixPointSize':
                if ($value < 11 && $value > 0) $this->arg[$name]= min(max((int)$value, 1), 10);
                $this->height=$this->arg[$name];
            break;
            case 'size':
                if (is_numeric($value)) $this->arg[$name]=$value;
            break;
            default:
                $this->arg[$name]=$value;                
            break;
        }

        return TRUE;
    }
    
    function __get($name) {
        switch ($name) {
            case 'matrixPointSize':
             if (!array_key_exists($name, $this->arg)) return 4;
            break;
            case 'errorCorrectionLevel':
             if (!array_key_exists($name, $this->arg)) return 'H';
            break;
            case 'width':
             if (!array_key_exists($name, $this->arg)) return 40;
            break;
            case 'size':
             if (!array_key_exists($name, $this->arg)) return 10;
            break;
            case 'desc':
             if (!array_key_exists($name, $this->arg)) return <<<D
Type: 
Uses:
Pins:
Date:
length:
D
;
            break;
        }
        if (array_key_exists($name, $this->arg)) {
            return $this->arg[$name];
        }
        return '';
    }
    
    function __toString() {
//        if (stristr($_SERVER['HTTP_ACCEPT'], "application/xhtml+xml")) {
        //    $this->mime="application/xhtml+xml";
        //    header("Content-Type: ".  $this->mime);
        //    print '<?xml version="1.0" encoding="utf-8"? >';
        // } else {
            $this->mime="text/html";
            header("Content-Type: ".  $this->mime);
   //     }
        
        $unit='<select name="unit">';
        $unit.='     <option value=""'.(($this->unit=='')?' selected="selected"':'').'></option>';
        $unit.='     <option value="F"'.(($this->unit=='F')?' selected="selected"':'').'>Feet</option>';
        $unit.='     <option value="M"'.(($this->unit=='M')?' selected="selected"':'').'>Meter</option>';
        $unit.=' </select>';
        $size='Size: <select name="size" >';
        foreach (array(1,2,3,4,5,6,7,8,9,10) as $i) $size.='<option value="'.$i.'"'.(($this->matrixPointSize==$i)?' selected="selected"':'').'>'.$i.'</option>';
        $size .='</select><br /> ';
        $size.='ECC: <select name="level">';
        $size.='     <option value="L"'.(($this->errorCorrectionLevel=='L')?' selected="selected"':'').'>L - smallest</option>';
        $size.='     <option value="M"'.(($this->errorCorrectionLevel=='M')?' selected="selected"':'').'>M</option>';
        $size.='     <option value="Q"'.(($this->errorCorrectionLevel=='Q')?' selected="selected"':'').'>Q</option>';
        $size.='     <option value="H"'.(($this->errorCorrectionLevel=='H')?' selected="selected"':'').'>H - best</option>';
        $size.=' </select>';
        
        return <<<HTML
<html  xmlns="http://www.w3.org/1999/xhtml" >
    <head>
        <meta http-equiv="Content-Type" content="$this->mime; charset=utf-8" />
        <meta http-equiv="Content-Language" content="en-us" />
        <title>$this->title</title>
        <script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
        <script type="text/javascript" src="js/jquery-ui-1.8.21.custom.min.js"></script>
        <script type="text/javascript" src="js/json2.js"></script>
        <script type="text/javascript" >
        $(function(){
         var label = '$this->label';
         $('#label').attr('src', label);
         $('#maker').dialog({
            title: '$this->title',
            closeOnEscape: false,
            width: '350px',
            position: ['right', 'top']
         });
         $('span.ui-icon.ui-icon-closethick').remove();
        });
        </script>
        <script type="text/javascript" src="js/qr-label.js"></script>
        <link class="css" type="text/css" href="css/style.css" rel="stylesheet" />
        <link class="css" type="text/css" href="css/qr.css" rel="stylesheet" />
 
    </head>
    <body>
$this->error
       <div id='main' ></div>
       <div id='maker'>
        <h3>Label Maker</h3>
   
        <form action="$this->url" >
         <p>Number: <input type='text' size='5' name='label' value="$this->size" />$unit<br />$size</p>
         <p>Discription:<br /><textarea name='desc' rows='3'  >$this->desc</textarea></p>
         <p><input type='submit' value="Make Label"/></p>
        </form>
        <h3>Click Label for preview</h3>
        <img id='label' alt='$this->size'/>
         <select id="page_size">
          <option value='{"width":"4in", "height":"2in", "number":"10", "x":"2", "y":"5"}' selected="selected" >2" Width x 4" Length - 10/Sheet</option>
          <option value='{"width":"4in", "height":"2in", "number":"10", "x":"2", "y":"5"}' >2" Width x 4" Length - 10/Sheet</option>
          <option value='{"width":"8.5in", "height":"11in", "number":"1", "x":"1", "y":"1"}' >8.5" Width x 11" Length - 1/Sheet</option>
          <option value='{"width":"4in", "height":"3.33in", "number":"6", "x":"2", "y":"3"}' >3.33" Width x 4" Length - 6/Sheet</option>
          <option value='{"width":"2.62in", "height":"1in", "number":"30", "x":"3", "y":"10"}' > 1" Width x 2.62" Length 30/Sheet</option>   
         </select>

       </div>

    </body>
</html>
HTML
        ;
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
       }
       $stamp = imagecreatetruecolor($width, $this->height);
       foreach ($s as $k) {
        if (!is_numeric($k)) {
            $bg_bin=$this->get_desc('gold');
            $txt_bin=$this->get_desc('silver');
        } else {
            $bg_bin= $this->get_bg($k);
            $txt_bin= $this->get_txt($k);            
        }
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
       echo $this;
 
    }
    
    function get_bg($k) {
       return  $this->get_desc($this->color[$k]['code']);
    }
    
    function get_txt($k) {
       return $this->get_desc($this->color[$k]['text']);   
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
