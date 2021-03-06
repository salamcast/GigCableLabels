# GigCableLabel

I currently work as a Tech in the Staging and AV world with various companies and I have noticed that many companies don't really follow a single industry standard for labeling their many cables, cases, lighting, audio, etc.  I wrote this program to help solve a problem that can help companies adopt a single standard for color coded labeling based on the resister colour code for 0-9.  The numeric codes are a maximum of 3 characters 0-9 and a letter for meters or feet.  QR code generation is placed beside the colour coded label.

### The generated QR code can contain:

- URL
- E-mail address
- Phone Number 
- SMS
- Address VCARDS
- Calendar Event
- Custom Text

QR codes have many uses for inventory, logistics, documentation, manifests or usage instructions to name a few.  I'm just tired of wasting my time looking for the right size cable when they are all labeled
differently or not at ALL! on a job site.  An example of the dilemma I would face when looking for a 50 foot cable; which cable is more likely to be a 50 ft cable marking that is clear? 

- The one with the red label?
- The one with the white label?
- The one with the yellow label? 
- Green and Black label?

In the resistor code, Green is 5 and Black is 0; so what do you think makes the most sence when hiring many freelancers and/or techs/hands from labour companies?  The resistor code is the winner, but most are stuck in their old ways


***

The QR code generation is from [phpqrcode](http://phpqrcode.sourceforge.net), this works very well and can be turned off in the class (not in the demo).  The QR code size (1 to 40) will be set based on the input string length and ECC level, all the maximum alphanumeric lengths I test against are listed on this [site](http://www.qrcode.com/en/vertable4.html) (link to page 4/4).  I've noticed that stretched QR code images don't work with Norton Snap on my iPhone 4, test your labels before you print any. I have 2 iPhone Apps for testing QR codes, Norton Snap and QRdeCODE. 

### The Demo:

The GigCableLabel demo will demonstrate this class in a RESTful Setup with PHP 5.3 and jQuery.  GET the label, PUT the label in the project directory, DELETE the selected labels from the project directory and POST a new project for labels.  There is still more work todo to make this tool a success, the UI is still very beta, view the [Demo](http://www.salamcast.com/demos/GigCableLabels/).  

- double click the new label to clear the new image and close the window or drag and drop the label on the project window to save it.
- added some multilingual support, English and goggle translated French, Arabic will be next -- Inshallah.
- I have also added Arabic Number labels, but with an English UI
- Multiple projects are now supported for multiple shows, shops, etc and can be made and loaded dynamically.
- Most of the web apps text has been moved into ini text files and loaded as a single JSON object, making it easier to edit and add translations
- added support for custom label sizes and page layout


### A look at the giglabel.php as an example of how to use this class can be used.

    <?php
    /* Gig Cable Label Class demo */
    /* HTTP/1.0 2XX Success Pages */
    function success_201($url) {
      header("HTTP/1.0 201 Created");
      header("Location: ".$url);
    }

    /* HTTP/1.0 4XX Error Pages */
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
    /* HTTP application/json header */
    function json_header() {
      header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
      header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT"); 
      header("Cache-Control: no-cache, must-revalidate"); 
      header("Pragma: no-cache");
      header("Content-type: application/json");
    }
    /* Genarates an UUID
     * 
     * @author Anis uddin Ahmad <admin@ajaxray.com>
     * @link   http://www.phpclasses.org/package/4427-PHP-Generate-feeds-in-RSS-1-0-2-0-an-Atom-formats.html
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
    elseif (array_key_exists('PATH_INFO', $_SERVER)) { $rest=$_SERVER['PATH_INFO']; } else { $rest=''; }
    // imgdata
    if  (array_key_exists('QUERY_STRING', $_SERVER)) { $imgdata=$_SERVER['QUERY_STRING']; } 
    else { $imgdata=''; }
    // RESTful CRUD access switcher
    if  (array_key_exists('REQUEST_METHOD', $_SERVER)) { $method=$_SERVER['REQUEST_METHOD']; } 
    else { $method=''; }

    $webdir=str_replace($_SERVER['DOCUMENT_ROOT'], '', dirname(__FILE__));

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
          if (!array_key_exists('project', $post)) error_403();
          if (!ctype_alnum($post['project'])) error_403();
          $dir=GigCableLabel::dir().'/'.$post['project'];
          if (!is_dir($dir)) mkdir(trim($dir), 0750, true);
          success_201('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
         } else {
          $p=array_shift($r);
          $dir=GigCableLabel::dir().'/'.$p;
          if ($p == '') error_400();
          if (!ctype_alnum($p)) error_403();
          if (!is_dir($dir)) error_404();
         }

         if($method == 'DELETE') {
           $d=glob($dir.'/*.json');
           $f=$dir.'/'.$imgdata.'.json';
           if (in_array($f, $d)) {
            if (is_file($f)) { unlink($f); } else { error_410(); }
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
           $link='http://'.$_SERVER['HTTP_HOST'].$webdir.urlencode(trim($c, '.'));
           $f=file_get_contents($c);
           $json=json_decode($f, true);
           $proj[]=$json;
          }
          echo json_encode($proj);
          exit();
         } else { error_405(); }
        break;
        case 'ui.json': GigCableLabel::load_ui($imgdata); break;
        case 'print':
         $width=array_shift($r);
         $height=array_shift($r);
         $x=array_shift($r);
         $y=array_shift($r);
         $img_style=array_shift($r);
         GigCableLabel::print_page($width, $height,$x,$y,$img_style,$imgdata) || error_404();    
        break;
        //case 'label':
        //    $code=array_shift($r);
        //    if (!ctype_alnum ($code)) error_404();
        //    $label=new GigCableLabel($code);
        //    $label->make_label();    
        //break;
        case 'QR':
            $lvl=array_shift($r);
            if (! ctype_upper($lvl)) error_404();
            $code=array_shift($r);
            if (!ctype_alnum ($code)) error_404();
            $desc=trim(implode('//', $r), '/');
            $label=new GigCableLabel($code);
            $label->qr=TRUE;
            $label->lang=$imgdata;
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
   
### Thanks

- For creating the Arabic Images i took a look at the [ArGlyphs class](http://www.phpclasses.org/package/3192-PHP-Convert-Arabic-text-to-Unicode-for-rendering.html) by a brother from Syria - Khaled Al-Shamaa 
- It showed me how to use a ttf font file for creating UNICODE text images in GD images with imagettftext; imagestring was making the text too small.