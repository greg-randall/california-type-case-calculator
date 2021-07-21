<!DOCTYPE html>
<html lang="en">
<head>
	<!-- Required meta tags -->
	<meta charset="UTF-8">
	<meta content="width=device-width, initial-scale=1" name="viewport"><!-- Bootstrap CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
	<title></title>
	<style>


	       .input-size {
	           width:30px;
	       }
	</style>
</head>
<body>
	<div class="container">
		<form action="process.php" method="post" autocomplete="off" style="margin-bottom:25px;">
			<h2>Page of Text</h2>
			<textarea class="form-control" name="page" rows="10" style="min-width: 100%">There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc. `1234567890-= ~!@#$%^*()_+ ,;[/']\ &lt;:{?}|</textarea><br>
			<br>
			
			<input id="weight" value="weight" name="radio" onclick="javascript:yesnoCheck();" type="radio"> Enter the weight of a single piece of type, and then the total weight of all that piece<br>
			<input id="direct" value="direct" name="radio" onclick="javascript:yesnoCheck();" type="radio"> Enter the count of each piece<br>
			<input id="previous" value="previous" name="radio" onclick="javascript:yesnoCheck();" type="radio"> Paste in previously generated type file<br>
			<br>
			<div id="ifweight" style="display:none">
				<h2>Weight of One</h2>
				<?php echo str_ireplace("name=\"", "name=\"weight_one_", file_get_contents('base-cali-case.html')); ?><br>
				<br>
				<h2>Weight of All</h2>
				<?php echo str_ireplace("name=\"", "name=\"weight_total_", file_get_contents('base-cali-case.html')); ?><br>
			</div>
			<div id="ifdirect" style="display:none">
			    <h2>Count of Each Glyph</h2>
				<?php echo file_get_contents('base-cali-case.html'); ?>
			</div>
			<div id="ifprevious" style="display:none">
				<h2>Previously Used Typecase</h2>
				<textarea class="form-control" name="previous_data" style="min-width: 100%"></textarea><br>
				<br>
			</div><br>
			<input class="text-center" type="submit">
		</form>
	</div>
	<script type="text/javascript">

	function yesnoCheck() {
	   if (document.getElementById('weight').checked) {
	       document.getElementById('ifweight').style.display = 'block';
	   }else{
	       document.getElementById('ifweight').style.display = 'none';
	   }

	   if (document.getElementById('direct').checked) {
	       document.getElementById('ifdirect').style.display = 'block';
	   }else{
	       document.getElementById('ifdirect').style.display = 'none';
	   }

	   if (document.getElementById('previous').checked) {
	       document.getElementById('ifprevious').style.display = 'block';
	   }else{
	       document.getElementById('ifprevious').style.display = 'none';
	   }


	}
   
    // in case someone hits the back button the radio button that is selected shows
    //const body = document.body;
    //body.onload = yesnoCheck;



	</script> 
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js">
	</script>
</body>
</html>