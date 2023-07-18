<?php
	
	$time_startPhp = microtime(true); 
	include '../config/serverkey.php';
	
	$data = json_decode(file_get_contents('php://input'));
	$university = $data->University;
	$algorithm = $data->Algorithm;
	$feature1 = $data->Feature1; //2
	$feature2 = $data->Feature2; //1
	$feature3 = $data->Feature3; //3
	$feature4 = $data->Feature4; //4
	$feature5 = $data->Feature5; //6
	$feature6 = $data->Feature6; //5
	$serverkey = $data->ServerKey;
	
	if($serverkey != $serverkeyref)
	{
		echo "Unauthorised!";
		return;
	}
	
	$dummy = strtotime("now") - strtotime("now"); //Simulate calculating the time spent in seconds
	
	$dummy2 = $dummy; //Simulate assigning the time spent to the array.
	
	$storedData = array(
		"Feature1" => $feature1, //2
		"Feature2" => $feature2, //1
		"Feature3" => $feature3, //3
		"Feature4" => $feature4, //4
		//"Feature5" => $feature5, //6
		"Feature6" => $feature6 //5
	);
	
	$filename = "unifeatures/".$university.'.json';
	$fp = fopen($filename, 'w');
	fwrite($fp, "[".json_encode($storedData)."]");
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
	$prediction = (int)exec("python3 makePrediction_".$learningType."_".$algorithm.".py \"".$university."\"");
	$time_endPy = microtime(true);
	
	$time_endPhp = microtime(true);
	$execution_timePhp = $time_endPhp - $time_startPhp;
	$execution_timePy = $time_endPy - $time_startPy;
	
	if($prediction)
		$message_arr=array(
			"Status" => true,
			"Message" => "Prediction successful!",
			"Prediction" => $prediction,
			"TimePhp" => $execution_timePhp,
			"TimePy" => $execution_timePy
		);
	else
		$message_arr=array(
			"Status" => false,
			"Message" => "Prediction failed!",
			"TimePhp" => $execution_timePhp,
			"TimePy" => $execution_timePy
		);
	
	print_r(json_encode($message_arr));

?>