<?php
require_once('database.php');
$userID = '1';
function insertScore($userID, $aWorp, $score){
//Connecten
    global $mysqli;
//Sql inserten
    $sql = "INSERT INTO dobbel_scores (User_ID, Worp, Score) VALUES ('$userID' , '$aWorp', '$score')";
    if($mysqli -> query($sql) === TRUE){
        echo "Insert voltooid <br>";
    }else{
        echo "<br>Error: " . $sql . "<br>" . $mysqli->error;
    }
}

function showAll(){
    global $mysqli;
    global $userID;
    $sql = "SELECT User_ID, Worp, Score, Time From dobbel_scores WHERE User_ID = '$userID'";
    $result = $mysqli->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "User ID: " . $row["User_ID"] . " Worp: " . $row["Worp"] . " Score " . $row["Score"] . " Tijd " . $row["Time"] . "<br>";
        }
    } else {
        echo "niks";
    }
}
?>