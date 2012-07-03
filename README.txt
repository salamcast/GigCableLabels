@author Karl Holz <newaeon|a|mac|d|com>
@package GigCableLabel


I currently work as a tech and rigger in the Staging and AV world with various companies 
and I have noticed that only a few have a sane way of color coding and labeling their many
cables with their sizes based on the resister code.

I wrote this program to help solve a problem that can help companies adopt a single standard for 
color coded labeling based on the resister colour code for their various cables of many different sizes.  
I'm tired of wasting my time looking for the right size cable when they are all labeled differently or not at ALL!

What would make more scene for a 50 foot cable?
- red label?
- yellow label?
- or Green and Black, which would actually match 5 and 0 in the Resistor code

I have added QR code generation from phpqrcode, which works fairly well and all images now have a QR code attached to them.
These types of coded images have many uses for inventory, logistics, documentation, manifests or usage instructions.

-you can embed a url alone and have it opened once scanned.
-you can embed setup instructions for projectors, speakers, lighting and audio boards
-you could also embed your pack list for each create you ship

the uses are endless, use your imagination 



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