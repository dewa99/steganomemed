<!DOCTYPE html>
<html>
<head>
	<title>Voucher Secret Message</title>
</head>
<link rel="stylesheet" type="text/css" href="bootstrap.css">
<body style="background-color: #f4f4f4">

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






<nav class="navbar navbar-inverse navbar-fixed-top" style="color: white;border: 0">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">Voucher Changer</a>
    </div>
    <ul class="nav navbar-nav">
      <li><a href="index.php">Upload Voucher</a></li>
      <li class="active"><a href="admin.php">Admin Centers</a></li>
    </ul>
  </div>
</nav> 

<br><br><br><br>
<div class="container">
	<div class="col-md-6">
	    <div class="form-group">
	        <label>Upload Image</label>
	        <div class="input-group">
	            <span class="input-group-btn">
	                <span class="btn btn-default btn-file">
	                    Browse… <input type="file" id="imgInp">
	                </span>
	            </span>
	            <input type="text" class="form-control" readonly>
	        </div>
	        <img id='img-upload'/>
	    </div>
	<button class="btn btn-info">Submit</button>
	</div>
</div>
<div class="container">
	<div class="col-md-6">
		<div class="input-group">
			Voucher Key
			<input type="text" name="message" class="form-control">
		</div>
	</div>
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