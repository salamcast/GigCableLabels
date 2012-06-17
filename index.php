<?php

/*
Gig Cable Label Class demo
 */
require_once 'gigcablelabel.class.php';
    if (array_key_exists('label', $_GET)) {
        $label=new GigCableLabel($_GET['label']);
    } else {
        $label=new GigCableLabel();       
    }

    if (array_key_exists('width', $_GET)  && is_numeric($_GET['width']))  $label->width= $_GET['width'];
    if (array_key_exists('height', $_GET) && is_numeric($_GET['height'])) $label->height=$_GET['height'];
    if (array_key_exists('labels', $_GET) && is_numeric($_GET['labels'])) $label->labels=$_GET['labels'];
    $label->make_label();

    exit();
?>
