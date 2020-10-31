<?php 
	// Headers
	header('Access-Control-Allow-Origin: *');
	header('Content-Type: application/json');
	header('Access-Control-Allow-Methods: POST');
	header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

	include_once '../config/Database.php';
	include_once '../classes/Admin.php';

	// Instantiate DB and connect
	$database = new Database();
	$db = $database->connect();

	//New instance of the class
	$admin = new Admin($db);

	// Get raw posted data
	$data = json_decode(@file_get_contents("php://input"));
	$access = 0;

	if (isset($data)) {
		$token = htmlspecialchars(strip_tags($data->token));
		//get admin details
		$admin_dt = $admin->get_admin_by_token([ $token ]);
		$last_login = $admin_dt['last_login'];
		$today = date('Y-m-d H:i:s');

		if ($last_login) {

			$passed = $admin->comparing_two_date_time($last_login, $today );
			//when not passed 1 hour
			if (!$passed) {
				$access = 1;
			}else{
				 echo json_encode(
			        ['message' => 'Authorization Failed!']
			    );
			}


			
			
			
		}
		/*$token = $admin->gen_token();
		
		//print_r();
		exit();
		//

		comparing_two_date_time($dt1, $today );
		//update login time and token
		

		$current_act = comparingTwoDateTime($start_date, $today , $days_limit = 1);
		if ($current_act !== true) {
			echo $current_act;
			exit();

		}*/

	}