<?php

	include '../config/serverkey.php';
	
	$data = json_decode(file_get_contents('php://input'));
	$studentid = $data->StudentId;
	$timespent = $data->TimeSpent;
	$studentshelped = $data->StudentsHelped;
	$activitieslogged = $data->ActivitiesLogged;
	$serverkey = $data->ServerKey;
	
	if($serverkey != $serverkeyref)
	{
		echo "Unauthorised!";
		return;
	}
	
	if($timespent != "--")
		$timeSpentSeconds = strtotime($timespent) - strtotime("now"); //Get time spent as seconds
	else
		$timeSpentSeconds = 0;
	
	$storedData = array(
		"TimeSpent"=> $timeSpentSeconds ,
		"StudentsHelped"=> $studentshelped,
		"ActivitiesLogged"=> $activitieslogged
	);
	
	$filename = "userfeatures/".$studentid.'.json';
	$fp = fopen($filename, 'w');
	fwrite($fp, "[".json_encode($storedData)."]");
	fclose($fp);
	
	$prediction = (int)exec("python3 predict_makePrediction.py \"".$studentid."\"");
	
	if($prediction)
		$message_arr=array(
			"Status" => true,
			"Message" => "Prediction successful!",
			"Prediction" => $prediction
		);
	else
		$message_arr=array(
			"Status" => true,
			"Message" => "Prediction failed!"
		);
	
	print_r(json_encode($message_arr));
	
?>