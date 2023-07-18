<?php
	$conn = new mysqli('mysqlcentral01.usm.my', 'usmi_rw', 'IdDIaJkdhHcjiHb', 'uw_dbusmiweb');

	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}
	
?>