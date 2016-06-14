<?php
require_once('database.php');
require_once('functions.php');

$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($mysqli->connect_errno) {
    echo 'Error: ' . $mysqli->connect_errno . ' : ' . $mysqli->connect_error;
    exit();
} else {
    echo "<p>Connection Ok</p>";
}?>
<body>
<h2>Koen Schutte MD1A</h2>
<form><input style="font-size: 180%;" type="submit" value="Gooi de dobbelstenen!"></form>
<?php

$worpen = array();
function dobbelSteen($worp){
    $im = @imagecreate(200, 200) or die("Cannot Initialize new GD image stream");
    $background_color = imagecolorallocate($im, 0, 180, 0);
    $white = imagecolorallocate($im, 255, 255, 255);

    if($worp > 1) {
        imagefilledellipse($im, 50, 50, 40, 40, $white);//1
        imagefilledellipse($im, 150, 150, 40, 40, $white);//7
    }

    if($worp==4||$worp==5||$worp==6){
        imagefilledellipse($im, 150, 50, 40, 40, $white);//2
        imagefilledellipse($im, 50, 150, 40, 40, $white);//5
    }

    if($worp == 6){
        $counter = 6;
        imagefilledellipse($im, 50, 100, 40, 40, $white);//3
        imagefilledellipse($im, 150, 100, 40, 40, $white);//6
    }

    if ($worp == 1||$worp == 5||$worp==3){
        imagefilledellipse($im, 100,100,40,40,$white);//4
    }

    imagepng($im,"worp" . $worp .".png");
    imagedestroy($im);
    print " <img class='dobbel' src=worp$worp.png?".date("U").">";

}

for ($i=0 ;  $i <5   ; $i++)
{$worp = rand(1,6);
    dobbelSteen($worp);
    //de complete worp is nodig in een array tbv score analyse
    //maak de array
    array_push($worpen, $worp);
}
function analyse($aWorp){
    $aScore = array (0,0,0,0,0,0,0);//initialiseer de array met alle waarden op 0
    for ($i = 1 ; $i <= 6 ; $i++){//outer loop
        for ($j = 0 ; $j <5 ; $j++){//inner loop
            if ($aWorp[$j] == $i){
                $aScore[$i]++;
            }}}
    return $aScore; //$aScore is een lokale variabele.
    //via de return krijg je de array $aScore  'buiten de functie'
}
$antwoord = "Niks";

$aWorp = analyse($worpen);
rsort($aWorp);
if($aWorp['0'] == 5){
    $antwoord = "Poker";
}
if($aWorp[0] == 4){
    $antwoord = "Carre";
}
if($aWorp[0] == 3 && $aWorp[1] == 2){
    $antwoord = "Full house";
}
if($aWorp[0] == 3){
    $antwoord = "3 of a kind";
}

if($aWorp[0] == 2){
    $antwoord = "One pair";
}

if($aWorp[0] == 2 && $aWorp[1] == 2){
    $antwoord = "Two pair";
}

echo '<p>'. $antwoord . '</p>';
$worp = implode($aWorp);
insertScore($userID, $worp, $antwoord);
showAll();
?>
</body>
<style>
    body{
        text-align: center;
        background-color: #DFDFDF;
    }
    .dobbel{
        border: 2px solid black;
        margin: 20px;
    }

    p{
      font-size: 200%;
        text-align: center;
    }
</style>