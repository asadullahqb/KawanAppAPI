<?php

	$time_startPhp = microtime(true);
	include '../config/conn.php';
	include '../config/serverkey.php';
	
	$data = json_decode(file_get_contents('php://input'));
	$serverkey = $data->ServerKey;
	$timeinterval = $data->TimeInterval;
	$algorithm =  $data->Algorithm;
	$data = $data->Data;
	/*
	if($serverkey != $serverkeyref)
	{
		echo "Unauthorised!";
		return;
	}*/
	
	//Remove server key and convert time spent
	$processedData = array();
	foreach($data as $individualData)
	{
		$dummy = strtotime("now") - strtotime("now"); //Simulate: Get time spent as seconds
		$dummy2 = $dummy; //Simulate assigning to the array
		
		$temp = array(
			"Feature1"=> $individualData->Feature1, //2
			"Feature2"=> $individualData->Feature2, //1
			"Feature3"=> $individualData->Feature3, //3
			"Feature4"=> $individualData->Feature4, //4
			//"Feature5"=> $individualData->Feature5, //6
			"Feature6"=> $individualData->Feature6, //5
			//"Ranking"=> $individualData->Ranking
			"Label"=> $individualData->Label
		);
		array_push($processedData, $temp);
	}
	
	$fp = fopen('features.json', 'w');
	fwrite($fp, json_encode($processedData));
	fclose($fp);
	
	switch($algorithm)
	{
		case "RFR":
			$learningType = "regression";
			$algorithm = "RF";
			break;
		case "NBR":
			$learningType = "regression";
			$algorithm = "NB";
			break;
		case "RFC":
			$learningType = "classification";
			$algorithm = "RF"; 
			break;
		case "NBC":
			$learningType = "classification";
			$algorithm = "NB";
			break;
	}

	$time_startPy = microtime(true);
	$trained = exec("python3 buildModel_".$learningType."_".$algorithm.".py") == "True"; 
	$time_endPy = microtime(true);

	$time_endPhp = microtime(true);

	$execution_timePhp = $time_endPhp - $time_startPhp;
	$execution_timePy = $time_endPy - $time_startPy;

	if($trained)
		$message_arr=array(
			"Status" => true,
			"Message" => "Model training succeeded!",
			"TimePhp" => $execution_timePhp,
			"TimePy" => $execution_timePy
		);
	else 
		$message_arr=array(
			"Status" => false,
			"Message" => "Model training failed!",
			"TimePhp" => $execution_timePhp,
			"TimePy" => $execution_timePy
		);
		
	print_r(json_encode($message_arr));
?>