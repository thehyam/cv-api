<?php
	// Headers
	header('Access-Control-Allow-Origin: *');
	header('Content-Type: application/json');
	header('Access-Control-Allow-Methods: POST');
	header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

	include_once '../config/Database.php';
	include_once '../classes/Work.php';
	include_once '../classes/Admin.php';

	// Instantiate DB and connect
	$database = new Database();
	$db = $database->connect();

	//New instance of the class
	$work = new Work($db);
	$admin = new Admin($db);

	$access = 0;
	$new_dt_01 = [];

	// Get raw posted data
	$data = json_decode(@file_get_contents("php://input"));
	if (isset($data)) {
		$token = htmlspecialchars(strip_tags($data->token));
		//for auth
		include_once('api_auth.php');

		if ($access) {
			//proceed with creation
			$new_dt_01[] = htmlspecialchars(strip_tags($data->title));
			$new_dt_01[] = htmlspecialchars(strip_tags($data->company));
			$new_dt_01[] = htmlspecialchars(strip_tags($data->start_date));
			$new_dt_01[] = htmlspecialchars(strip_tags($data->end_date));
			
			//add new record
			if($new_dt_01){
				$done = $work->create($new_dt_01);
				if ($done ) {
					echo json_encode(
						        ['message' => 'Record Added!']
						    );
					
				}else{
					echo json_encode(
						        ['message' => 'Record Not Added!']
						    );
					
				}
			}

		}else{
			echo json_encode(
			        ['message' => 'Authorization Failed!']
			    );
		}
		

	}