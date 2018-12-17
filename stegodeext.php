<?php
    // header("Content-Type: image/");
    // header("Content-Type: application/json");

    $images = imagecreatefrompng("stegoimages.png");
    $imginfo['width']  = imagesx($images);
    $imginfo['height'] = imagesy($images);
    // $imginfo['rgb'] = array();

    $msg = "";

    for ($y=0; $y < $imginfo['height'] ; $y++) {
        for ($x=0; $x < $imginfo['width'] - 1; $x+=2) {
            $p = imagecolorat($images, $x, $y);
            $psen = imagecolorat($images, $x+1, $y);

            $cp = imagecolorsforindex($images, $p);
            $cpsen = imagecolorsforindex($images, $psen);

            $cpred = $cp['red'];
            $cpsenred = $cpsen['red'];

            $h1 = $cpred-$cpsenred;
            $msg .= strlen($msg) < (27*7) ? substr(decbin($h1),-1) : '';
        }
    }
    $data = "";
    $msg = str_split($msg , 7);
    foreach ($msg as $m) {
        $data .= chr(bindec($m));
    }
    echo $data."\n";

    // echo $msg[1]."\n";
?>
