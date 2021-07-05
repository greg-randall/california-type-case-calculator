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

//collects the list of valid letters
foreach (explode("\n", file_get_contents("valid_letters.txt")) as $letter) {
    $valid_letters[trim($letter)] = "";
}

//sanatize
foreach ($_POST as $key => $value) {
    if ($key == "period") { //seems like php won't take a "." as post/get input??
        $key = ".";
    }
    
    //makes sure the recieved variable is a valid letter and isn't our page of text
    if ($key != "page" && array_key_exists($key, $valid_letters)) {
        //$key = urldecode($key);
        $value = trim($value); //make sure all the counts of letters are integer numbers
        if (is_numeric($value)) {
            $value           = floor($value);
            $sanitized[$key] = $value;
            
        } else {
            $sanitized[$key] = 0;
        }
    } elseif ($key == "page") { //strip html from the page input
        $value           = strip_tags($value);
        $sanitized[$key] = $value;
    }
    $missing[$key] = 0;
    
}

//parse string and count if there are enough letters
$page = str_split($sanitized['page']);
foreach ($page as $char) {
    if ($char != " ") {
        if (array_key_exists($char, $sanitized)) {
            if ($sanitized[$char] >= 1) {
                echo "<span style=\"background-color:#b8ffdc;\">$char</span>"; //good
                $sanitized[$char]--;
            } else {
                echo "<span style=\"background-color:#ffb8b8;\">$char</span>"; //bad
                $missing[$char]++;
            }
        } else {
            echo "<span style=\"background-color:#ffe6b8;\">$char</span>"; //unkown
        }
    } else {
        echo $char;
    }
}
echo "<Br>";

foreach ($missing as $key => $value) {
    if ($value > 0) {
        echo "Need $value more $key<br>";
    }
}
?>

</p>
</div>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js">
	</script>
</body>
</html>