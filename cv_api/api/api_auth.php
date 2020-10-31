<?php 
	
	if (isset($token)) {
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

				exit();
			}



			
			
		}
	
	}