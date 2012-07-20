@author Karl Holz <newaeon|a|mac|d|com>
@package GigCableLabel
@link http://www.salamcast.com/demos/GigCableLabels/

I currently work as a Tech in the Staging and AV world with various companies and I have noticed that many companies don't really follow a
single industry standard for labeling their many cables, cases, lighting, audio, etc.  

I wrote this program to help solve a problem that can help companies adopt a single standard for color coded labeling based on the resister
colour code for 0-9 and I have added an alpha numeric number generator for patch list id's.  The alphanumeric codes are a maximum of
5 characters A-Z,0-9.  QR code generation is placed beside the colour coded label.

The generated QR code can contain:

-URL
-E-mail address
-Phone Number 
-SMS
-Address VCARDS
-Calendar Event
-Custom Text

QR codes have many uses for inventory, logistics, documentation, manifests or usage instructions to name a few.

I'm just tired of wasting my time looking for the right size cable when they are all labeled
differently or not at ALL! on a job site.  

An example of the dilemma I would face when looking for a 50 foot cable; which cable is more likely to be a 50 ft
cable marking that is clear? 

- The one with the red label?
- The one with the white label?
- The one with the yellow label? 
- Green and Black label?

In the resistor code, Green is 5 and Black is 0; so what do you think makes the most sence when hiring many freelancers and/or techs/hands from
labour companies?  The resistor code is the winner, but all the 


-------------------------------------------------------------------------------------------------------------------

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

- I don't have any way to display saved labels yet, just delete them from the server. double click didn't seem to work for selectable
- double click the new label to clear the new image and close the window or drag and drop the label on the project window to save it.
- added some multilingual support, English and goggle translated French, Arabic will be next -- Inshallah.
- I have also added Arabic Number and Letter labels, but with an English UI
- Multiple projects are now supported for multiple shows, shops, etc and can be made and loaded dynamically.
- Most of the web apps text has been moved into ini text files and loaded as a single JSON object, making it easier to edit and add translations
- added support for custom label sizes and page layout

//-------------------------------------------------------------------
// Class setup
//-------------------------------------------------------------------
// basic php setup for using Gig Cable Labeler as a stand alone setup    
    $label=new GigCableLabel(96);    // 96, this must be a number   
    $label->make_label();
    $label->qr=TRUE;
    if (isset($level)) $label->errorCorrectionLevel=$level;
    if ($label->desc=trim($desc)) $label->make_label();
    header("HTTP/1.0 404 Not Found");
    echo "<h1>HTTP/1.0 404 Not Found</h1>";
    echo "Label Not Found or couldn't be generated<br />";
    echo "Requested Resource: ".'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."<br />";
    echo "Go back to the <a href='".'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']."' >Main</a> page";
    exit();
//-----------------------------------------------------------------   
    
    look at the giglabel.php file for an example of how to use this class.

//-----------------------------------------------------------------       
// Thanks
//-----------------------------------------------------------------   
 
- For creating the Arabic Images i took a look at the ArGlyphs class by a brother from Syria - Khaled Al-Shamaa
 http://www.phpclasses.org/package/3192-PHP-Convert-Arabic-text-to-Unicode-for-rendering.html
 
It showed me how to use a ttf font file for creating UNICODE text images in GD images with imagettftext; imagestring was making the text too small.
