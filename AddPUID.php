<?php
$servername = "localhost";
$username = "moi";
$password = "moipw";
$dbname = "dhis2";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT * FROM `finalcomcodges`";
$result = $conn->query($sql);
$gesisArray = array();

if ($result->num_rows > 0) {
    
	
    while($row = $result->fetch_assoc()) {

	$gesisArray [] = array($row['GESIS'],$row['UID']);	
    }
} else {
    echo "0 results";
}

$sql = "SELECT * FROM `fslast`";
$result = $conn->query($sql);


if ($result->num_rows > 0) {
    
	
    while($row = $result->fetch_assoc()) {

	for($i = 0; $i < sizeof($gesisArray); $i++)
        {
            similar_text($row['G_CODE'], $gesisArray[$i][0], $percent);
            if($percent >= 98)
            {
                //echo $row['G_CODE'].'______'.$gesisArray[$i][0];echo '<br>';break;
                echo $sql = "update fslast set PUID='".$gesisArray[$i][1]."' where G_CODE=\"$row[G_CODE]\"";echo "<br>";
                $conn->query($sql);                
            }
            
        }
    }
} else {
    echo "0 results";
}

$conn->close();
?>