<!DOCTYPE html>
<html>
<head>
	<title>Voucher Changer</title>
</head>

<link rel="stylesheet" type="text/css" href="bootstrap.css">
<style type="text/css">
	.btn-file {
    position: relative;
    overflow: hidden;
}
.btn-file input[type=file] {
    position: absolute;
    top: 0;
    right: 0;
    min-width: 100%;
    min-height: 100%;
    font-size: 100px;
    text-align: right;
    filter: alpha(opacity=0);
    opacity: 0;
    outline: none;
    background: white;
    cursor: inherit;
    display: block;
}

#img-upload{
    width: 100%;
}
</style>
<body style="background-color: #f4f4f4">

 <nav class="navbar navbar-inverse navbar-fixed-top" style="color: white;border: 0">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">Voucher Changer</a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="#">Upload Voucher</a></li>
      <li><a href="admin.php">Admin Centers</a></li>
    </ul>
  </div>
</nav>

<br><br><br><br>
<div class="container">
<div class="col-md-6">
<form method="post" enctype="multipart/form-data" action="">
    <div class="form-group">
        <label>Upload Image</label>
        <div class="input-group">
            <span class="input-group-btn">
                <span class="btn btn-default btn-file">
                    Browse… <input type="file" name="file" id="imgInp">
                </span>
            </span>
            <input type="text" class="form-control" readonly>
        </div>
        <img id='img-upload'/>
    </div>
<button class="btn btn-info">Submit</button>
</form>
</div>
</div>

<br>
<div class="container">
	<label>Voucher Anda</label>
	<?php
		if (isset($_FILES['file'])) {
			$img = file_get_contents( $_FILES['file']['tmp_name'] );
    	$images = imagecreatefromstring( $img );
			// $images = imagecreatefrompng("stegoimages.png");
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
		}
	?>
</div>


</body>

<script type="text/javascript" src="jquery-1.11.1.min.js"></script>
<script type="text/javascript">
$(document).ready( function() {
    	$(document).on('change', '.btn-file :file', function() {
		var input = $(this),
			label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
		input.trigger('fileselect', [label]);
		});

		$('.btn-file :file').on('fileselect', function(event, label) {

		    var input = $(this).parents('.input-group').find(':text'),
		        log = label;

		    if( input.length ) {
		        input.val(log);
		    } else {
		        if( log ) alert(log);
		    }

		});
		function readURL(input) {
		    if (input.files && input.files[0]) {
		        var reader = new FileReader();

		        reader.onload = function (e) {
		            $('#img-upload').attr('src', e.target.result);
		        }

		        reader.readAsDataURL(input.files[0]);
		    }
		}

		$("#imgInp").change(function(){
		    readURL(this);
		});
	});
</script>
</html>
