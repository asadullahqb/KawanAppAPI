<?php
	include 'config/conn.php';

	$sql = "SELECT * FROM test";

	$stmt = $conn->prepare($sql);
	$stmt->execute();
	$result = $stmt->get_result();
	while ($row = $result->fetch_assoc()) 
	{
		echo "Id: ". $row['id'];
		echo ", Message: ". $row['firstname']."<br>";
	}
?>