<?php

	include '../config/serverkey.php';
	
	$data = json_decode(file_get_contents('php://input'));
	$serverkey = $data[0]->ServerKey;
	
	if($serverkey != $serverkeyref)
	{
		echo "Unauthorised!";
		return;
	}
	
	//Remove server key and convert time spent
	$processedData = array();
	foreach($data as $individualData)
	{
		if($individualData->TimeSpent != "--")
			$timeSpentSeconds = strtotime($individualData->TimeSpent) - strtotime("now"); //Get time spent as seconds
		else
			$timeSpentSeconds = 0;
		$temp = array(
			"TimeSpent"=> $timeSpentSeconds ,
			"StudentsHelped"=> $individualData->StudentsHelped,
			"ActivitiesLogged"=> $individualData->ActivitiesLogged,
			"Ranking"=> $individualData->Ranking
		);
		array_push($processedData, $temp);
	}
	
	$fp = fopen('predict_features.json', 'w');
	fwrite($fp, json_encode($processedData));
	fclose($fp);
	
	$trained = exec("python3 predict_buildModel.py") == "True";

	if($trained)
		$message_arr=array(
			"Status" => true,
			"Message" => "Model training succeeded!",
		);
	else 
		$message_arr=array(
			"Status" => false,
			"Message" => "Model training failed!",
		);
		
	print_r(json_encode($message_arr));
	
?>