<!DOCTYPE html>
<html lang="en">
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta content="width=device-width, initial-scale=1" name="viewport"><!-- Bootstrap CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
	<title></title>
	<style>


		.input-size {
			width:20px;
		}
	</style>
</head>
<body><br><br>
	<div class="container">

<p>
<?php

$page = str_split($_GET['page']);

foreach ($page as $char)
{
    if (array_key_exists($char, $_GET))
    {
        if ($_GET[$char] >= 1)
        {
            echo "<span style=\"color:green;\">$char</span>";
            $_GET[$char]--;
        }else{echo "<span style=\"color:red;\">$char</span>";}
    }else
    {
        echo "<span style=\"color:orange;\">$char</span>";
    }
}


?></p>
</div>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js">
	</script>
</body>
</html>