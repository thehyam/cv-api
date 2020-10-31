<?php
	// Headers
	header('Access-Control-Allow-Origin: *');
	header('Content-Type: application/json');

	include_once '../config/Database.php';
	include_once '../classes/Web.php';
	include_once '../classes/Admin.php';

	// Instantiate DB and connect
	$database = new Database();
	$db = $database->connect();

	//New instance of the class
	$web = new Web($db);
	$admin = new Admin($db);

	// Get code
	$id = isset($_GET['id']) ? $_GET['id'] : die();
	$token = isset($_GET['token']) ? $_GET['token'] : die();

	// Create array

	$access = 0;
	if ($id && $token) {
		
		$id = htmlspecialchars(strip_tags($id));
		$token = htmlspecialchars(strip_tags($token));
		//for auth
		include_once('api_auth.php');
		
		if ($access) {
			
			$del_arr = [$id]; 
			// Delete 
			if($web->delete($del_arr)) {

			    echo json_encode( 
			        ['message' => 'Record deleted']
			    );
			} else {
			    echo json_encode(
			        ['message' => 'Record not deleted']
			    );
			}
		}else{
			echo json_encode(
			        ['message' => 'Authorization Failed!']
			    );
		}
	}