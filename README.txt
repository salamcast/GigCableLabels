@author Karl Holz <newaeon|a|mac|d|com>
@package GigCableLabel
@link http://www.salamcast.com/demos/GigCableLabels/

I currently work as a Tech in the Staging and AV world with various companies 
and I have noticed that only a few have a sane way of labeling their many
cables, cases, lighting, audio, etc.  I wrote this program to help solve a problem
that can help companies adopt a single standard for color coded labeling based on the
resister colour code for 0-9,G,S,N and some extra charaters A-F,H-M,P with blue and red
background.  There is also an option to add a QR code beside the colour coded label.
The QR code can contain a URL, E-mail address, Phone Number and text message. QR codes have
many uses for inventory, logistics, documentation, manifests or usage instructions to name a few

I'm just tired of wasting my time looking for the right size cable when they are all labeled
differently or not at ALL! on a gig.  An example of the delema i would face when looking for a
50 foot cable; which cable is more likely to be a 50 ft cable marking that is clear? the one with
the red label? the one with the yellow label? or Green and Black label?

The QR code generation is from phpqrcode, this works very well and can be turned off


I've noticed that streched QR code images don't work with Norton Snap on my iPhone 4,
test your labels before you print any.

all print pages have their own link, you can bookmark it for later, because the URL are
much cleaner looking and control the view of the document and it contents.

the uses are endless, use your imagination, play around, test your codes with your phone,
make sure they work!!!  This is designed with tinkering in mind for the print able page.

example of uri template for print (HTML5 output)

/print/{td css width)/{td css height}/{x}/{y}/{label_style}+'?'+{base64_img};


// basic php setup for using Gig Cable Labeler as a stand alone setup    
    $label=new GigCableLabel(96);    // 96, this must be a number   
    $label->make_label();
    $label->qr=TRUE;
    if (isset($level)) $label->errorCorrectionLevel=$level;
    if (isset($size)) $label->matrixPointSize= $size;
    if (isset($unit)) $label->unit= $unit;
    if (isset($desc) && trim($desc) != '')  $label->desc=trim($desc);
    $label->make_label();
    exit();