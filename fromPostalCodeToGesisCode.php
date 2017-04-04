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

$sql = "SELECT * FROM `commune_gesis`";
$result = $conn->query($sql);
$gesisArray = array();

if ($result->num_rows > 0) {
    
	
    while($row = $result->fetch_assoc()) {

	$gesisArray [] = array($row['COMMUNE'],$row['CODE']);	
    }
} else {
    echo "0 results";
}

$sql = "SELECT * FROM `cm_code` where gesis=''";
$result = $conn->query($sql);


if ($result->num_rows > 0) {
    
	
    while($row = $result->fetch_assoc()) {

	for($i = 0; $i < sizeof($gesisArray); $i++)
        {
            similar_text($row['COMMUNE'], $gesisArray[$i][0], $percent);
            if($percent < 86 && $percent >= 82)
            {
                echo $row['COMMUNE'].'______'.$gesisArray[$i][0];echo '<br>';break;
                //echo $sql = "update cm_code set GESIS='".$gesisArray[$i][1]."' where COMMUNE=\"$row[COMMUNE]\"";echo "<br>";
                //$conn->query($sql);                
            }
            
        }
    }
} else {
    echo "0 results";
}

$conn->close();
?>