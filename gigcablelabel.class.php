<?php

/**
 Generates a Resister code based Image based on a number
 */

class GigCableLabel {
    private $size;
    
    private $code=array(
        'black', //0
        'brown', //1
        'red',   //2
        'orange',//3
        'yellow',//4
        'green', //5
        'blue',  //6
        'violet',//7
        'grey',  //8
        'white'  //9
    );
    private $code_text=array(
        'white', //0 black
        'white', //1 brown
        'white', //2 red
        'white', //3 orange
        'black', //4 yellow
        'white', //5 green
        'white', //6 blue
        'white', //7 violet
        'black', //8 grey
        'black'  //9 white
    );
    
    private $hex=array(
        'black' => '000000', //0
        'brown' => '990000', //1
        'red'   => 'FF0000',   //2
        'orange'=> 'FF6600',//3
        'yellow'=> 'FFFF00',//4
        'green'=> '00FF00', //5
        'blue'=> '0000FF',  //6
        'violet'=> 'FF00FF',//7
        'grey'=> 'C0C0C0',  //8
        'white'=> 'FFFFFF'  //9
    );
    private $arg=array();
    
    function __construct($size='') {
        $this->width=30;
        $this->height=50;


        
        $this->error='';
        $this->title='GigCableLabeler';
        $this->customize=FALSE;
        if ($size=='') {
            echo $this;
            exit();
        }
        if (! is_numeric($size)) {
            header("HTTP/1.0 403 Forbidden");
            $this->error="<h1>HTTP/1.0 403 Forbidden</h1><p>You Must enter a number</p><p>You entered: $size</p><hr />";
            $this->title='HTTP/1.0 403 Forbidden';
            echo $this;
            exit();
        }
        $this->size=$size;
        return TRUE;
    }
    
    function __toString() {
        if (stristr($_SERVER['HTTP_ACCEPT'], "application/xhtml+xml")) {
            $this->mime="application/xhtml+xml";
            header("Content-Type: ".  $this->mime);
            print '<?xml version="1.0" encoding="utf-8"?>';
        } else {
            $this->mime="text/html";
            header("Content-Type: ".  $this->mime);
        }
        $label=$this->labels();
        $pagesize=$this->get_pagesize();
        if ($this->customize) {

            $width=$this->get_select('width');
            $height=  $this->get_select('height');
            $custom="<br /> Height: $height px <br /> Width: $width px <br /> Labels: $pagesize <br />";
        } else {

            $custom="<br /> Labels (8.5\"x11\"): $pagesize <br />";
        }
        return <<<HTML
<html  xmlns="http://www.w3.org/1999/xhtml" >
    <head>
        <meta http-equiv="Content-Type" content="$this->mime; charset=utf-8" />
        <meta http-equiv="Content-Language" content="en-us" />
        <title>$this->title</title>
        <style type="text/css">
         #maker { 
            width: 220px; 
            margin: 0; padding: 0; 
            position: absolute; 
            top: 0; 
            left: 9in;
            
         }
         .label { 
            width: 8.5in; 
            height 11in; 
            position: absolute; 
            left: 0px; top: 0px; 
            overflow: hidden; 
            border-width: 1px; 
            border-color: black; 
            border-style: solid;

         }
         table {
              width: 8in;
              height:11in;
              position: relative;
              left: 0.25in;
         }
         td { 
            border-bottom-style: dashed;
            width: $this->label_width;
            height: $this->label_height;
            border-color: black;
            border-width: 2px;
            padding: 1px;
            margin: 0px;
            vertical-align: sub;
            text-align: center;
            border-right-style: dashed; 
         }
         img {  
                margin: 0; 
                padding: 0px; 
                height: 99%; 
                width: 99%; 
         }
        </style>
    </head>
    <body>
$this->error
       <div id='main' class='label'>$label</div>
       <div id='maker'>
        <h2>Cable Size Label Maker</h2>
        <p>This will output a 8.5"x11" sized sheet that can be printed on a sticky label page.</p>
        <p>The labels can be placed on the cabels and also don't forget to add a clear protective plastic or 
           wax to ptotect the label from being ripped or pulled off the cable from tape, friction or time.</p>
        <p>Colours are based on the Resister Code</p>
        <form  >
            Cable Length: <input style="float: right; " type='text' size='5' name='label' value="$this->size" /> 
            $custom
            <input type='submit'/>
        </form>
       </div>
      

    </body>
</html>
HTML
        ;
    }


    function labels() {
        if (array_key_exists('pagesize', $_GET) ) {
                $this->pagesize=$_GET['pagesize'];
        } 
        
        $this->label_sizes=array(
            '5x4',
            '8x5',
            '1.5x1'
        );
        switch ($this->pagesize) {
            case '5x4':
                //1.25" x 2.25" Labels
                $this->label_width='1.25in';
                $this->label_height='2.25in';
                $w=5;
                $h=4;
                break;
            case '8x5' : // 1" x 2" Library Labels
                $this->label_width='1in';
                $this->label_height='2in';
                $w=8;
                $h=5;
                break;
            case '1.5x1': //1.5" x 1" Labels
                $this->label_width='1.5in';
                $this->label_height='1in';
                $w=5;
                $h=10;
             break;
            default:
                //1.25" x 2.25" Labels
                // 5 x 4
                $this->pagesize='5x4';
                $this->label_width='1.25in';
                $this->label_height='2.25in';
                $w=5;
                $h=4;
                break;
        }
        
        $l='<table>';
        for ($x=1;$x <= $h; $x++) {
            $l.='<tr>';
            for ($t=1; $t <= $w; $t++) {
             $l.='<td>'.$this->img_tag.'</td>';
            }
            $l.='</tr>';
        }
        $l.='</table>';
        return $l;
    }
    
    function get_select($name) {
        switch ($name) {
            case 'width':
                $start=30;
                $end=50;
            break;
            case 'height':
                $start=70;
                $end=140;
            break;
            default:
                $start=30;
                $end=70;
        }
        
        $box='<select style="float: right;position:relative; top: -18px; " name="'.$name.'" >';
        for ($s=$start; $s <= $end;  ) {
            if ($s == $this->$name) {
                $box.='<option value="'.$s.'" selected="selected" >'.$s.'</option>';
            } else {
                $box.='<option value="'.$s.'" >'.$s.'</option>';
            }
            if ($name == 'width') {
                $s++;
            } elseif ($name == 'height') {
                $s+=5;

            } else {
                $s++;
            }
        }
        $box.='</select>';
        return $box;
    }
    
    function get_pagesize() {
        $a=$this->label_sizes;
        $box='<select style="float: right;position:relative; top: -18px; " name="pagesize" >';
        foreach ( $a as $s ) {
            if ($s == $this->pagesize) {
                $box.='<option value="'.$s.'" selected="selected" >'.$s.'</option>';
            } else {
                $box.='<option value="'.$s.'" >'.$s.'</option>';
            }
        }
        $box.='</select>';
        return $box;
    }
    
    
    function __set($name, $value) {
        $this->arg[$name]=$value;
        return TRUE;
    }
    
    function __get($name) {
        if (array_key_exists($name, $this->arg)) {
            return $this->arg[$name];
        }
        return '';
    }
    
    function make_label() {
       $w=0;
        if ($this->customize) {
            if (array_key_exists('width', $_GET)  && is_numeric($_GET['width']))  $label->width= $_GET['width'];
            if (array_key_exists('height', $_GET) && is_numeric($_GET['height'])) $label->height=$_GET['height'];
        }
       $s=str_split($this->size);
       $width=$this->width*count($s);
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
       $this->im=$stamp;
       $filename='.'.__CLASS__.'.png';
       imagepng($this->im, $filename);
       imagedestroy($this->im);
       $imgbinary = fread(fopen($filename, "r"), filesize($filename));
       $this->label='data:image/png;base64,' . base64_encode($imgbinary);
       $this->img_tag="<img src='".$this->label."' alt='".$this->size."'/>";
       echo $this;
 
    }
    
    

    
    function get_bg($k) {
       return  $this->get_desc($this->code[$k]);
    }
    
    function get_txt($k) {
       return $this->get_desc($this->code_text[$k]);   
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
