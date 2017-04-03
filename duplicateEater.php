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

$sql = "SELECT * FROM `duplicate_commune`";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
	$district = $commune = '';
    while($row = $result->fetch_assoc()) {
        echo $row["ID"]. " , " . $row["DISTRICT"]. " , " . $row["COMMUNE"]. " , ".str_replace('"','',$row['PARENT UID'])."<br>";
		
		if($row["DISTRICT"] == $district && $row["COMMUNE"] == $commune)
		{
			$conn->query("delete from duplicate_commune where ID=$row[ID]");
			 
			
		}
		$district = $row["DISTRICT"];$commune = $row["COMMUNE"];
		
    }
} else {
    echo "0 results";
}
$conn->close();
?>