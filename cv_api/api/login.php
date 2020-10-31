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
	if (isset($data)) {
		
		$login_arr[]= htmlspecialchars(strip_tags($data->uname));
		$pword = htmlspecialchars(strip_tags($data->pword));
		$login_arr[] = $admin->md5_encrypt($pword);
		
		//getting admin details
		$admin_dt = $admin->get_admin_details($login_arr);
		
		//when there is a record match
		if($admin_dt) {
			$token = $admin->gen_token();
			$today = date('Y-m-d H:i:s');

			//update login time and token
			$adm_id = $admin_dt['id'];
			$update_dt = [$token, $today, $adm_id];
			$done = $admin->update_admin_token($update_dt);
			
			if ($done) {
				
			    echo json_encode(
			        [ 'message' => 'Success', 'token' => $token]
			    );

			}else{
			    echo json_encode(
			        ['message' => 'Authorization Failed!']
			    );
			}
			
		} else {
		    echo json_encode(
		        ['message' => 'Authorization Failed!']
		    );
		}
	} 
