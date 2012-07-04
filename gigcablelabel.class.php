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
     '0' => array(
     'code' =>  'black', //0
     'text' => 'white', //0 black
     ),
     '1' =>array(
     'code' =>  'brown', //1
     'text' => 'white', //1 brown
     ),
     '2' =>array(
     'code' =>  'red',   //2
     'text' => 'white', //2 red
     ),
     '3' =>array(
     'code' =>  'orange',//3
     'text' => 'white', //3 orange
     ),
     '4' =>array(
     'code' =>  'yellow',//4
     'text' => 'black', //4 yellow
     ),
     '5' =>array(
     'code' =>  'green', //5
     'text' => 'white' //5 green
     ),
     '6' =>array(
     'code' =>  'blue',  //6
     'text' => 'white' //6 blue
     ),
     '7' =>array(
     'code' =>  'violet',//7
     'text' => 'white' //7 violet
     ),
     '8' =>array(
     'code' =>  'grey',  //8
     'text' => 'black' //8 grey
     ),
     '9' =>array(//9 white
     'code' =>  'white',
     'text' => 'black'  
     ),
     'G' => array(//G gold
     'code' =>  'gold',  
     'text' => 'green'  
     ),
     'S'=>  array(//S silver
     'code' =>  'silver',  
     'text' => 'blue'  
     ), 
     'N'=> array(//N None
     'code' =>  'none',  
     'text' => 'red'  
     ),
     //a-o minus G, S, N
    'A' => array(
     'code' =>  'blue',
     'text' => 'white' 
     ),
    'B' =>array(
     'code' =>  'red',
     'text' => 'white' 
     ),
    'C' =>array(
     'code' =>  'blue',
     'text' => 'white' 
     ),
    'D' =>array(
     'code' =>  'red',
     'text' => 'white' 
     ),
    'E' =>array(
     'code' =>  'blue',
     'text' => 'white' 
     ),
    'F' =>array(
     'code' =>  'red',
     'text' => 'white' 
     ),
    'H' =>array(
     'code' =>  'blue',
     'text' => 'white' 
     ),
    'I' =>array(
     'code' =>  'red',
     'text' => 'white' 
     ),
    'J' =>array(
     'code' =>  'blue',
     'text' => 'white' 
     ),
    'K' =>array(
     'code' =>  'red',
     'text' => 'white'
     ),
    'L' => array(
     'code' =>  'blue',
     'text' => 'white'
     ),
    'M'=>  array(
     'code' =>  'red',
     'text' => 'white' 
     ), 
    'P'=> array(
     'code' =>  'blue',
     'text' => 'white' 
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
    
    function __construct($size='') {
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
            default:
                $this->arg[$name]=$value;                
            break;
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
             if (!array_key_exists($name, $this->arg)) return 'Not data has be cued for QR encoding';
            break;
        }
        if (array_key_exists($name, $this->arg)) {
            return $this->arg[$name];
        }
        return '';
    }
    
    function __toString() {

        $this->mime="text/html";
        header("Content-Type: ".  $this->mime);   


        // size unit
        $unit='<select id="unit">';
        $unit.='     <option value="">N/A</option>';
        $unit.='     <option value="\'">Feet</option>';
        $unit.='     <option value="m">Meter</option>';
        $unit.=' </select>';
        //uses
        $uses='<select id="department">';
        $uses.='     <option value="NA" >none</option>';
        $uses.='     <option value="Power" >Power</option>';
        $uses.='     <option value="Rigging" >Rigging</option>';
        $uses.='     <option value="Motors" >Motors</option>';
        $uses.='     <option value="Lighting" >Lighting</option>';
        $uses.='     <option value="Audio" >Audio</option>';
        $uses.='     <option value="Video" >Video</option>';
        $uses.='     <option value="AV" >A/V</option>';
        $uses.='     <option value="I.T." >I.T.</option>';
        $uses.=' </select>';
        //type
        $type='<select id="type">';
        $type.='     <option value="unknown" >Uknown</option>';
        $type.='     <option value="15 A u-Ground" >15 A u-Ground</option>';
        $type.='     <option value="15 A twist" >15 A twist</option>';
        $type.='     <option value="20 A twist" >20 A twist</option>';
        $type.='     <option value="DMX-3" >DMX-3</option>';
        $type.='     <option value="DMX-4" >DMX-4</option>';
        $type.='     <option value="DMX-5" >DMX-5</option>';
        $type.='     <option value="NL4" >NL4</option>';
        $type.='     <option value="NL8" >NL8</option>';
        $type.='     <option value="cat-5|RJ45" >cat-5/RJ45</option>';
        $type.='     <option value="1|4 " >1/4</option>';
        $type.='     <option value="1|8" >1/8</option>';
        $type.='     <option value="RCA" >RCA</option>';
        $type.='     <option value="S-Video" >S-Video</option>';
        $type.='     <option value="VGA" >VGA</option>';
        $type.='     <option value="DVI" >DVI</option>';
        $type.='     <option value="HDMI" >HDMI</option>';
        $type.='     <option value="12G SOCA" >12G SOCA</option>';
        $type.='     <option value="16G SOCA" >16G SOCA</option>';
        $type.='     <option value="Motor SOCA" >Motor SOCA</option>';
        $type.='     <option value="Motor Control" >Motor Control</option>';
        $type.=' </select>';
        
        $label='<select id="label1" >';
        foreach (array('',0,1,2,3,4,5,6,7,8,9,'G','S','N','A','B','C','D','E','F','H','I','J','K','L','M','P') as $i) $label.='<option value="'.$i.'">'.$i.'</option>';
        $label .='</select>';
        $label.='<select id="label2" >';
        foreach (array('',0,1,2,3,4,5,6,7,8,9,'G','S','N','A','B','C','D','E','F','H','I','J','K','L','M','P') as $i) $label.='<option value="'.$i.'">'.$i.'</option>';
        $label.='</select>';
        $label.='<select id="label3" >';
        foreach (array(0,1,2,3,4,5,6,7,8,9,'G','S','N','A','B','C','D','E','F','H','I','J','K','L','M','P') as $i) $label.='<option value="'.$i.'">'.$i.'</option>';
        $label .='</select>';
        //QR code
        $size='Size: <select id="size" >';
        foreach (array(1,2,3,4,5,6,7,8,9,10) as $i) $size.='<option value="'.$i.'"'.(($this->matrixPointSize==$i)?' selected="selected"':'').'>'.$i.'</option>';
        $size .='</select>  ';
        $size.='ECC: <select id="level">';
        $size.='     <option value="L"'.(($this->errorCorrectionLevel=='L')?' selected="selected"':'').'>L - smallest</option>';
        $size.='     <option value="M"'.(($this->errorCorrectionLevel=='M')?' selected="selected"':'').'>M</option>';
        $size.='     <option value="Q"'.(($this->errorCorrectionLevel=='Q')?' selected="selected"':'').'>Q</option>';
        $size.='     <option value="H"'.(($this->errorCorrectionLevel=='H')?' selected="selected"':'').'>H - best</option>';
        $size.=' </select>';
        //

        $date=date('m/d/Y',time() );
        return <<<HTML
<html  xmlns="http://www.w3.org/1999/xhtml" >
    <head>
        <meta http-equiv="Content-Type" content="$this->mime; charset=utf-8" />
        <meta http-equiv="Content-Language" content="en-us" />
        <title>$this->title</title>
        <script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
        <script type="text/javascript" src="js/jquery-ui-1.8.21.custom.min.js"></script>

        <script type="text/javascript" >
        $(function(){
        
        });
        </script>
        <script type="text/javascript" src="js/qr-label.js"></script>
        <link class="css" type="text/css" href="css/style.css" rel="stylesheet" />
        <link class="css" type="text/css" href="css/qr.css" rel="stylesheet" />
 
    </head>
    <body>

       <div id="top" >
         Size/Code: $label $unit | <input type="checkbox"  id="qr" value="true" checked="checked"/>QR  $size
         <button id='mklabel'>-= Make =-</button>
       </div>
       <div id='main' ></div>
       <div id='maker'>
         <div id="accordion" >
          <h3><a href="#">Equipment Info Label</a></h3>
          <div>
            Type: $type  <br />
            Department: $uses <br /> 
            Date: <input type='text' id='date' value="$date" /><br />
         </div>
         <h3><a href="#">Phone Label</a></h3><div><fieldset><legend>Phone:</legend><input type='text' id='tel' /></fieldset></div>
         <h3><a href="#">URL Label</a></h3><div><fieldset><legend>URL:</legend><input type='text'  id='url' /></fieldset></div>
         <h3><a href="#">Email Label</a></h3><div><fieldset><legend>Email:</legend><input type='text' id='email' /></fieldset></div>
        </div>
        <div id="output"><h3>Click Label for preview</h3>
          <img id='img' alt='$this->size'/>
          <select id="page_size">
           <option value='{"width":"4in", "height":"2in", "number":"10", "x":"2", "y":"5"}' selected="selected" >2" Width x 4" Length - 10/Sheet</option>
           <option value='{"width":"4in", "height":"2in", "number":"10", "x":"2", "y":"5"}' >2" Width x 4" Length - 10/Sheet</option>
           <option value='{"width":"8.5in", "height":"11in", "number":"1", "x":"1", "y":"1"}' >8.5" Width x 11" Length - 1/Sheet</option>
           <option value='{"width":"4in", "height":"3.33in", "number":"6", "x":"2", "y":"3"}' >3.33" Width x 4" Length - 6/Sheet</option>
           <option value='{"width":"2.62in", "height":"1in", "number":"30", "x":"3", "y":"10"}' > 1" Width x 2.62" Length 30/Sheet</option>   
          </select>
         </div>
        <form action="$this->url" ></form>
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

        echo $this->label;
 
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
