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
    <div class="container" style="margin-bottom:30px;">

<p>
<?php
//echo "<pre>".print_r($_POST,true)."</pre>";
$valid_letters = array( 'ffi', 'fl', '/', '‘', '’', 'k', 'e', 'j', 'b', 'c', 'd', '?', '!', 'l', 'm', 'n', 'h', 'z', 'x', 'v', 'u', 't', '4_to_em', 'q', '1', '2', '3', '4', '5', '6', '7', '8', 'i', 's', 'f', 'g', 'ff', '9', 'fi', '0', 'o', 'y', 'p', 'w', ',', '3_to_em', 'en_quad', 'a', 'r', ';', ':', 'em_quads', '.', '-', '$', '–', '—', '(', ')', '[', ']', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'V', 'W', 'X', 'Y', 'Z', 'J', 'U', '&', 'ffl');

//collects the list of valid letters & sanatizes 
/*
====================================
deal with zero and period and left/right square brackets

====================================
*/



if ($_POST['radio']=="weight") {
    foreach ($valid_letters as $letter) {
        //make sure both keys exist
        if (key_exists("weight_one_$letter", $_POST) && key_exists("weight_total_$letter", $_POST)) {
            //make sure both weights aren't null and are numbers
            if (is_numeric($_POST["weight_one_$letter"]) && is_numeric($_POST["weight_total_$letter"]) ) {
                //echo "$letter -- " . $_POST["weight_total_$letter"] ."/". $_POST["weight_one_$letter"] ."<br>";
                $computed = floor($_POST["weight_total_$letter"] / $_POST["weight_one_$letter"]);
                //make sure the number makes sense, if the number is one or greater accept it otherwise set to zero
                if ($computed >= 1) {
                    $letters_calc[$letter] = $computed;
                } else {
                    $letters_calc[$letter] = 0;
                }
            } else {
                $letters_calc[$letter] = 0; //if keys are null or non-numeric set to zero
            }
        } else {
            $letters_calc[$letter] = 0; //if both keys don't exist set the letter to zero
        }
    }
} else if ($_POST['radio']=="previous") {
    //validate json
    if(validate_json($_POST['previous_data'])){
        $peviously_computed = json_decode($_POST['previous_data'], true);
        foreach ($valid_letters as $letter) {
            if (key_exists($letter, $peviously_computed)) {
                if ($peviously_computed[$letter] < 1) {
                    $letters_calc[$letter] = 0;
                } else {
                    $letters_calc[$letter] = $peviously_computed[$letter];
                }
            }
        }
    //if field is empty
    }else if(strlen($_POST['previous_data'])<1){
        echo "<p>Blank Previous Data, Please Input Data.</p>";
        exit();
    //if field is actually invalid
    //consider trying to fix json or something? 
    }else{
        echo "<p>Invalid Previous Data Input Data.</p>";
        exit();
    }
    //echo "<pre>".print_r($peviously_computed,true)."</pre>";
} else if ($_POST['radio']=="direct") {
    foreach ($valid_letters as $letter) {
        if (key_exists("$letter", $_POST)) {
            if (!is_null($_POST["$letter"]) && is_numeric($_POST["$letter"])) {
                if ($_POST["$letter"] < 1) {
                    $letters_calc[$letter] = 0;
                } else {
                    $letters_calc[$letter] = $_POST["$letter"];
                }
            } else {
                $letters_calc[$letter] = 0;
            }
        } else {
            $letters_calc[$letter] = 0;
        }
    }
} else {
    echo "<p>Please select a radio button on the previous screen.</p>";
    exit();
}
$page = strip_tags($_POST["page"]);

$for_next_time = json_encode($letters_calc);


//parse string and count if there are enough letters
$unknown = array();
$missing = array();

$enough_of_everything = true;
$page                 = str_split($page);
foreach ($page as $char) {
    if ($char != " ") {
        if (array_key_exists($char, $letters_calc)) {
            if ($letters_calc[$char] >= 1) {
                echo "<span style=\"background-color:#b8ffdc;\">$char</span>"; //good
                $letters_calc[$char]--;
            } else {
                echo "<span style=\"background-color:#ffb8b8;\">$char</span>"; //bad
                if (!array_key_exists($char, $missing)) {
                    $missing[$char] = 0;
                }
                $missing[$char]++;
                $enough_of_everything = false;
            }
        } else {
            echo "<span style=\"background-color:#ffe6b8;\">$char</span>"; //unknown
            if (!array_key_exists($char, $unknown)) {
                $unknown[$char] = 0;
            }
            $unknown[$char]++;
        }
    } else {
        echo $char;
    }
}
echo "</p>

<ul style=\"width: 70%;margin: auto\"><li style=\"margin-right:30px; display: inline;\"><span style=\"background-color:#b8ffdc;\">Enough Letters</span></li><li style=\"margin-right:30px; display: inline;\"><span style=\"background-color:#ffb8b8;\">Not Enough Letters</span></li><li style=\"margin-right:30px; display: inline;\"><span style=\"background-color:#ffe6b8;\">Unknown Letters</span></li></ul>

<hr>";

if ($enough_of_everything) {
    echo "<h3 class=\"text-center\">You have enough letters to et the page that you entered!</h3>";
} else {
    echo "<h3 class=\"text-center\">You do not have enough letters to set the page that you entered.</h3>";
}

echo "<br><br><div class=\"row\"><div class=\"col-md-6\"><ul>";
arsort($missing);

foreach ($missing as $key => $value) {
    if ($value > 0) {
        echo "<li>Need $value more of $key.</li>";
    }
}

echo "</ul></div><div class=\"col-md-6\"><ul>";
arsort($unknown);

foreach ($unknown as $key => $value) {
    if ($value > 0) {
        echo "<li>Not sure what $key is, but there were $value.</li>";
    }
}

?></ul>

</div></div>
<hr>
<h2>Save this output for use next time:</h2>
<div style="width:80%;"><form><textarea class="form-control" rows="5" style="min-width: 100%">
<?php echo $for_next_time; ?>
</textarea></form></div>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js">
    </script>
</body>
</html>



<?php

function validate_json($str=NULL) {
    if (is_string($str)) {
        @json_decode($str);
        return (json_last_error() === JSON_ERROR_NONE);
    }
    return false;
}

?>