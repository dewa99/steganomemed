<?php
    header("Content-Type: image/png");
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=voucher.png');
    header('Content-Transfer-Encoding: binary');
    header('Connection: Keep-Alive');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    header('Content-Length: ' . $size);

    if (isset($_FILES['file']) && isset($_POST['message'])) {
    $string = $_POST['message'];

    //to binary
    $message = array();
    for ($i=0; $i < strlen($string) ; $i++) {
        $binary = decbin(ord($string[$i]));
        $binary = strlen($binary) < 7 ? "0".$binary : $binary;
        $message[] = $binary;
    }

    $messagestr = implode($message);

    $img = file_get_contents( $_FILES['file']['tmp_name'] );
    $images = imagecreatefromstring( $img );
    // $images = imagecreatefrompng("image.png");
    // $aspect = imagesy($images) / imagesx($images);
    // $images = imagescale ( $images, 50 , 50 * $aspect);
    $imginfo['width']  = imagesx($images);
    $imginfo['height'] = imagesy($images);
    // $imginfo['rgb'] = array();

    $msgidx = 0;

    // de process
    for ($y=0; $y < $imginfo['height'] ; $y++) {
        for ($x=0; $x < $imginfo['width'] - 1; $x+=2) {
            if (strlen($messagestr) > 0 &&  $msgidx < strlen($messagestr)) {
                //ambil pixel
                $p = imagecolorat($images, $x, $y);
                $psen = imagecolorat($images, $x+1, $y);
                //ambil rgb
                $cp = imagecolorsforindex($images, $p);
                $cpsen = imagecolorsforindex($images, $psen);
                //ambil merah saja
                $cpred = $cp['red'];
                $cpsenred = $cpsen['red'];
                //hitung de
                $l = floor(($cpred + $cpsenred) / 2);
                $h = $cpred - $cpsenred;
                // if ($l >= 127) {
                    // $hsen = 2*(255 - $l);
                // }else{
                    $hsen = (2 * $h) + $messagestr[$msgidx];
                // }
                //inc msg
                $msgidx++;
                //hitung pixel red baru
                $pbaru = $l + floor(($hsen + 1) / 2);
                $psenbaru = $l - floor(($hsen) / 2);
                //buat color baru
                $pcolorbaru  = imagecolorallocate($images, $pbaru, $cp['green'], $cp['blue']);
                $psencolorbaru  = imagecolorallocate($images, $psenbaru, $cpsen['green'], $cpsen['blue']);
                //replace on pixel
                imagesetpixel($images , $x , $y , $pcolorbaru);
                imagesetpixel($images , $x+1 , $y, $psencolorbaru);
            }
        }
    }


    //buat print pixel

    // for ($y=0; $y < $imginfo['height'] ; $y++) {
    //     for ($x=0; $x < $imginfo['width'] -1; $x++) {
    //         $p = imagecolorat($images, $x, $y);
    //         $cp = imagecolorsforindex($images, $p);
    //         echo str_pad($cp['red'], 3, "0", STR_PAD_LEFT). " ";
    //     }
    //     echo "\n";
    // }


    // echo json_encode($imginfo,JSON_PRETTY_PRINT);

    imagepng($images);


    // $data = '';
    // decode
    // foreach ($simpan as $char) {
    //     $data .= chr(bindec($char));
    // }

    // echo base64_decode($data)."\n";
  }
?>
