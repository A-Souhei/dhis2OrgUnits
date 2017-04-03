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

$sql = "SELECT ID,DISTRICT,COMMUNE, CODE as Code, `PARENT UID` as pid , (select count(COMMUNE) from duplicate_commune as dc where dc.COMMUNE=cm.COMMUNE) as COUNTCOMM FROM `duplicate_commune` as cm";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row

    while($row = $result->fetch_assoc()) {
		
		if((int)$row["COUNTCOMM"] >= 2)
		{
			
			echo $sql = "update duplicate_commune set COMMUNE=CONCAT('$row[COMMUNE]', ' _'  , '$row[DISTRICT]') where ID=$row[ID]";echo "<br>";
			$conn->query($sql);
			 //echo $row["COMMUNE"]. ' -> '.$row["COUNTCOMM"].'<br>';
			
		}
			$puid = str_replace(array('.', ' ', "\n", "\t", "\r","\""), '', $row['pid']);
			echo $sql = "update duplicate_commune set $row[pid]=$puid where ID=$row[ID]";echo "<br>";
			$conn->query($sql);		
		
    }
} else {
    echo "0 results";
}
$conn->close();
?>