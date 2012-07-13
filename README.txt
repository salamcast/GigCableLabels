@author Karl Holz <newaeon|a|mac|d|com>
@package GigCableLabel
@link http://www.salamcast.com/demos/GigCableLabels/

I currently work as a Tech in the Staging and AV world with various companies and I have noticed that many companies don't really follow a
single industry standard for labeling their many cables, cases, lighting, audio, etc.  

I wrote this program to help solve a problem that can help companies adopt a single standard for color coded labeling based on the resister
colour code for 0-9 and I have added an alpha numeric number generator for patch list id's.  The alphanumeric codes are a maximum of
4 characters, 2 Letters and 2 numbers.  QR code generation is placed beside the colour coded label.

The generated QR code can contain:
URL
E-mail address
Phone Number 
Address VCARDS
Custom Gig Label

QR codes have many uses for inventory, logistics, documentation, manifests or usage instructions to name a few.

I'm just tired of wasting my time looking for the right size cable when they are all labeled
differently or not at ALL! on a job site. 

An example of the dilemma I would face when looking for a 50 foot cable; which cable is more likely to be a 50 ft cable marking that is clear? 
- The one with the red label?
- The one with the yellow label? 
- Green and Black label?

The QR code generation is from phpqrcode, this works very well and can be turned off in the class (not in the demo)

The QR code size (1 to 40) will be set based on the input string length and ECC level, all the maximum alphanumeric lengths I test against
are listed on this site (link to page 4/4):

http://www.qrcode.com/en/vertable4.html

I've noticed that stretched QR code images don't work with Norton Snap on my iPhone 4, test your labels before you print any. I have 2
iPhone Apps for testing QR codes, Norton Snap and QRdeCODE. 

The Demo:

The GigCableLabel demo will demonstrate this class in a RESTful Setup with PHP 5.3 and jQuery.  GET the label, PUT the label in the project
directory, DELETE the selected labels from the project directory and POST a new project for labels.  There is still more work todo to make
this tool a success, the UI is still very beta.  

- I don't have any way to edit/display current labels yet, just delete them from the server.
- I don't have a function to change the  projects, just add new project folder and add files them
- All HTTP errors can be viewed in your web browsers  dev tools, I use Safari's webkit.


// basic php setup for using Gig Cable Labeler as a stand alone setup    
    $label=new GigCableLabel(96);    // 96, this must be a number   
    $label->make_label();
    $label->qr=TRUE;
    if (isset($level)) $label->errorCorrectionLevel=$level;
    if ($label->desc=trim($desc)) $label->make_label();
header("HTTP/1.0 413 Request Entity Too Large");
 echo "<h1>HTTP/1.0 413 Request Entity Too Large</h1>";
 echo "You're discription is too large for this resource<br />- Consider lowering the Error Correction Capability <br />";
 echo "Requested Resource: ".'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."<br />";
 echo "Go back to the <a href='".'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']."' >Main</a> page";
    exit();
    
    
    look at the giglabel.php file for an example of how to use this class.