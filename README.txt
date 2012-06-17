@author Karl Holz <newaeon|a|mac|d|com>
@package GigCableLabel


I currently work as a tech and rigger in the Staging and AV world with various companies 
and I have noticed that only a few have a sane way of color coding and labeling their many
cables with their sizes based on the resister code.

I wrote this program to help solve a problem that can help companies adopt a single standard for 
color coded labeling based on the resister code for their various cables of many different sizes.  
I'm tired of wasting my time looking for the right size cable when they are all labeled differently or not at ALL!  

TODO:
- add page sizes for label page output with better alignment
- willing to take some suggestions





// basic php setup for using Gig Cable Labeler as a stand alone setup
 
    if (array_key_exists('label', $_GET)) {
        $label=new GigCableLabel($_GET['label']);
    } else {
        $label=new GigCableLabel();       
    }
    // allow customize
    // $this->customize=TRUE;

    $label->make_label();

    exit();