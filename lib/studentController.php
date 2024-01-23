<?php 
include "lib.php";
if($_POST){
	extract($_POST);




	if ($key==$keydb) {

		if(isset($tag)&&$tag!=null)
		{
			if($tag=="login"){
				    $q2 = $d->select("student_master", "student_email='$student_email' AND student_password='$student_password'AND student_status=0");

					if($q2){
						$data=mysqli_num_rows($q2);
						if ($data>0) {

							$studentdata=mysqli_fetch_array($q2);
							
						
							
						    $response["student_data"] = array(
							    "student_id" => $studentdata["student_id"],
								"student_name" => $studentdata["student_name"],
								"student_email" => $studentdata["student_email"],
								"student_mobile" => $studentdata["student_mobile"]
                            );
                            $response["status"]="201";
							$response["massage"]=" login Sucess";
                            echo json_encode($response);
				 		   
						}else{
							$response["status"]="201";
				 		   $response["massage"]=" invelid user";
				 		   echo json_encode($response);
						}

						mysqli_free_result($q2);

					}else{
					   $response["status"]="201";
			 		   $response["massage"]=" login faild";
			 		   echo json_encode($response);
					}
			}
			else if($tag=="register"){

						$q2=$d->select("student_master","student_email='$student_email'");

						if(mysqli_num_rows($q2)>0){
							$response["status"]="201";
			 				$response["massage"]="email already exist";
			 				echo json_encode($response);
			 				exit();
						}  

						$q3=$d->select("student_master","student_mobile='$student_mobile'");

						if(mysqli_num_rows($q3)>0){
							$response["status"]="201";
			 				$response["massage"]="phone no. already exist";
			 				echo json_encode($response);
			 				exit();
						}  


					    $m->set_data("name",$student_name);
						$m->set_data("mobile",$student_mobile);
						$m->set_data("email",$student_email);
						$m->set_data("password",$student_password);
						$m->set_data("added_date",date("Y-m-d H:i:s"));

						$a=array(
							"student_name"=>$m->get_data("name"),
						    "student_mobile"=>$m->get_data("mobile"),
						    "student_email"=>$m->get_data("email"),
						    "student_password"=>$m->get_data("password"),
						    "added_date"=>$m->get_data("added_date"),
						);
	 			
						$q=$d->insert("student_master",$a);
			 			if ($q==true) {
			 				$response["status"]="200";
			 				$response["massage"]="register success";
			 				echo json_encode($response);
			 			}else{
			 				$response["status"]="201";
			 				$response["massage"]="register fail";
			 				echo json_encode($response);
 			            }
	 	    }else if($tag=="updateprofile"){
	 	            	$q=$d->select("student_master","student_id='$student_id'");
	 	            	if(mysqli_num_rows($q)>0){
	 	            		$m->set_data("student_name",$student_name);
	 	              		$m->set_data("student_email",$student_email);
	 	              		$m->set_data("student_mobile",$student_mobile);
	 	              		$m->set_data("update_date",date("Y-m-d H:i:s"));

	 	              		$update=array(
	 	              			"student_name"=>$m->get_data("student_name"),
	 	              			"student_email"=>$m->get_data("student_email"),
	 	              			"student_mobile"=>$m->get_data("student_mobile"),
	 	              			"update_date"=>$m->get_data("update_date"),
	 	              		);

	 	              		$q1=$d->update("student_master",$update,"student_id=$student_id");
	 	              		if ($q1==true) {

	 	              			$response["status"]="200";
	 	              			$response["massage"]="updateprofile success";
	 	              			echo json_encode($response);

	 	              		}else{
	 	              			$response["status"]="201";
	 	              			$response["massage"]="updateprofile faild";
	 	              			echo json_encode($response);
	 	              		}
	 	              	}
	 	    }else if($tag=="listactiveuser"){
                $q = $d->select("student_master", "student_status=0");
 	            if (mysqli_num_rows($q) > 0) {
                   $users = array();
                    while ($row = mysqli_fetch_array($q)) {
                        $users[] = array(
	                        "student_id" => $row["student_id"],
	                        "student_name" => $row["student_name"],
	                        "student_email" => $row["student_email"],
	                        "student_mobile" => $row["student_mobile"]
                        );
                    }
 	              	$response["status"] = "200";
	                $response["massage"] = "List of active users";
	                $response["users"] = $users;
	                echo json_encode($response);  
		        }else {
	                $response["status"] = "201";
	                $response["massage"] = "No inactive users found";
	                echo json_encode($response);
                }
            }else if ($tag == "deactive") {
             $deactivate = isset($student_id) ? $student_id : 0;

				if ($deactivate > 0) {
				    $q = $d->update("student_master", array("student_status" => 1), "student_id=$deactivate");

				    if ($q == true) {
				        $response["status"] = "200";
				        $response["massage"] = "User deactivated successfully";
				        echo json_encode($response);
				    } else {
				        $response["status"] = "201";
				        $response["massage"] = "Failed to deactivate user";
				        echo json_encode($response);
				    }
				} else {
				    $response["status"] = "201";
				    $response["massage"] = "Invalid student ID";
				    echo json_encode($response);
				}
            }else if ($tag == "active") {
             $activate = isset($student_id) ? $student_id : 1;

				if ($activate > 0) {
				    $q = $d->update("student_master", array("student_status" => 0), "student_id=$activate");

				    if ($q == true) {
				        $response["status"] = "200";
				        $response["massage"] = "User activated successfully";
				        echo json_encode($response);
				    } else {
				        $response["status"] = "201";
				        $response["massage"] = "Failed to activate user";
				        echo json_encode($response);
				    }
				} else {
				    $response["status"] = "201";
				    $response["massage"] = "Invalid student ID";
				    echo json_encode($response);
				}
            }else{
				$response["status"]="201";
				$response["massage"]=" Wrong  tag";
				echo json_encode($response);
		    }
		}else{

			$response["status"]="201";
	 		$response["massage"]="Something went Wrong";
	 		echo json_encode($response);
        }
	}else{
		$response["status"]="201";
	 	$response["massage"]="Something went Wrong";
	 	echo json_encode($response);
	}	
}    
	
?>