<?php
	// Headers
	header('Access-Control-Allow-Origin: *');
	header('Content-Type: application/json');

	include_once '../config/Database.php';
	include_once '../classes/Edu.php';
	 
	// Instantiate DB and connect
	$database = new Database();
	$db = $database->connect();
	//New instance of the class
	$edu = new Edu($db);

	// Get code
	$id = isset($_GET['id']) ? $_GET['id'] : die();

	// Create array
	$cs_arr = array(htmlspecialchars(strip_tags($id))); 


	// Get record
	$row = $edu->get_one($cs_arr);

	// Check if any record
	if($row) {

	    // Change to JSON
	    echo json_encode($row);
	    http_response_code(200);

	} else {
	    http_response_code(404);
	    echo json_encode(array('message' => 'No Record Found.'));
	}