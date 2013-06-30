<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["x"]))
{
	$targ_w = $targ_h = 150;
	$quality = 100;

	// $src = 'demo_files/pool.jpg';
	$src = $_POST["fileurl"];
	
	// $img_r = $src;
	
	$img_r = str_replace('data:image/png;base64,', '', $src);
	$img_r = base64_decode($img_r);
	// imagepng($img_r,'b.png',100);
	// $img_r = "../app/Jcrop/demos/demo_files/sagomod.png";
	
	// $img_r = $_POST["fileurl"];
	// echo file_get_contents($img_r);
// echo "aaaa"	;	
	
	// $img_r = imagecreatefrompng($src);
	$img_r = imagecreatefrompng($img_r);
	
	$dst_r = ImageCreateTrueColor( $targ_w, $targ_h );
	$savePath = "aab.png";

	imagecopyresampled($dst_r,$img_r,0,0,$_POST['x'],$_POST['y'],
	$targ_w,$targ_h,$_POST['w'],$_POST['h']);

	// header('Content-type: image/jpeg');
	// header('Content-type: image/png');
	// imagepng($dst_r,$savePath,$quality);
	
	// echo $src;
}

// If not a POST request, display page below:

// else if(isset($_POST["uploadImage"]) && (!isset($_POST["x"]))){
else{
?>
		<script src="./js/jquery.min.js"></script>
		<script src="./js/jquery.Jcrop.js"></script>
		<link rel="stylesheet" href="./css/jquery.Jcrop.css" type="text/css" />
		<link rel="stylesheet" href="demo_files/demos.css" type="text/css" />

		<script language="Javascript">

			$(function(){

				$('#cropbox').Jcrop({
					aspectRatio: 1,
					onSelect: updateCoords
				});

			});

			function updateCoords(c)
			{
				$('#x').val(c.x);
				$('#y').val(c.y);
				$('#w').val(c.w);
				$('#h').val(c.h);
			};

			function checkCoords()
			{
				if (parseInt($('#w').val())) return true;
				alert('Please select a crop region then press submit.');
				return false;
			};

		</script>

	<div id="outer">
	<div class="jcExample">
	<div class="article">

		<h1>Jcrop - Crop Behavior</h1>
<?php
		// var_dump($_FILES);
		$pathUrl = $_FILES["myfile"]["tmp_name"];
		$image_unencode = file_get_contents($pathUrl);
		$image_src = base64_encode($image_unencode);
		$filetype = pathinfo($filename, PATHINFO_EXTENSION);
		$data = "data:image/png;base64,".$image_src;
?>
		<!-- This is the image we're attaching Jcrop to -->
<!-- 		<img src="demo_files/pool.jpg" id="cropbox" /> -->
		<img src="<?php echo $data; ?>" id="cropbox" />

		<!-- This is the form that our event handler fills -->
		<form action="crop2.php" method="post" onsubmit="return checkCoords();">
			<input type="hidden" id="x" name="x" />
			<input type="hidden" id="y" name="y" />
			<input type="hidden" id="w" name="w" />
			<input type="hidden" id="h" name="h" />
			<input type="hidden" name="fileurl" value="<?php echo $image_unencode; ?>" />
			<!-- <input type="hidden" name="uploadImage" value="<?php echo $_POST["uploadImage"]; ?>" /> -->
			<input type="submit" value="Crop Image" />
		</form>


	</div>
	</div>
	</div>
<?php
}
?>