<?php 

include "lib.php";
if($_POST){
	extract($_POST);

	if ($key==$keydb){
		if(isset($tag)&&$tag!=null){
			if($tag=="addsubject"){
				$m->set_data("subject_name",$subject_name);
				$m->set_data("added_date",date("Y-m-d H:i:s"));

			    $subjectname = $d->select("subject_master", "subject_name='$subject_name'");
                if(mysqli_num_rows($subjectname) > 0){
                    $response["status"] = "201";
                    $response["massage"] = "Subject with the same name already exists";
                    echo json_encode($response);
                    exit(); 
                }
			
			  $a=array(
				"subject_name"=>$m->get_data("subject_name"),
			    "added_date"=>$m->get_data("added_date"),
				);
			   $q=$d->insert("subject_master",$a);
	 			if ($q==true) {
	 				$response["status"]="200";
	 				$response["massage"]="subject add success";
	 				echo json_encode($response);
	 			}else{
	 				$response["status"]="201";
	 				$response["massage"]="subject add fail";
	 				echo json_encode($response);
		        }
		    }else if($tag=="editsubject"){
	 	        $q=$d->select("subject_master","subject_id='$subject_id'");
	 	        if(mysqli_num_rows($q)>0){
        		  $m->set_data("subject_name",$subject_name);
        		  $m->set_data("update_date",date("Y-m-d H:i:s"));
          		

          		  $update=array(
          			"subject_name"=>$m->get_data("subject_name"),
          			"update_date"=>$m->get_data("update_date"),
          		
          		    );

          		  $q1=$d->update("subject_master",$update,"subject_id='$subject_id'");
          		  if ($q1==true) {

	          			$response["status"]="200";
	          			$response["massage"]="edit subject success";
	          			echo json_encode($response);

          		    }else{
	          			$response["status"]="201";
	          			$response["massage"]="edit subject faild";
	          			echo json_encode($response);
          		    }
	 	        }else{
	 	        	$response["status"]="201";
          			$response["massage"]="wrong tag";
          			echo json_encode($response);
	 	        }
	        }else if($tag == "getalldetails"){
               if(isset($student_id) && !empty($student_id)){
       
                 $q = $d->select("student_master, subject_master, student_subject_details", "student_master.student_id=student_subject_details.student_id AND subject_master.subject_id=student_subject_details.subject_id AND student_master.student_id='$student_id'");
        
                    if(mysqli_num_rows($q) > 0){
                      $users = array();
                      while($row = mysqli_fetch_assoc($q)){
		                  $userDetails = array(
		                    'student_id' => $row['student_id'],
		                    'student_name' => $row['student_name'],
		                    'student_mobile' => $row['student_mobile'],
		                    'student_email' => $row['student_email'],
		                    'subject_id' => $row['subject_id'],
		                    'subject_name' => $row['subject_name'],
		                    'details_id' => $row['details_id']
		                  );
                          $users[] = $userDetails;
                        }
            
			            $response["status"] = "200";
			            $response["massage"] = "getalldetails of user";
			            $response["data"] = $users;
			            echo json_encode($response);
                    }else{
			            $response["status"] = "201";
			            $response["massage"] = "user not found";
			            echo json_encode($response);
                    }
                }
	        }else if($tag == "getalluserfulldetails"){
               
       
                 $q = $d->select("student_master, subject_master, student_subject_details", "student_master.student_id=student_subject_details.student_id AND subject_master.subject_id=student_subject_details.subject_id ");
        
                    if(mysqli_num_rows($q) > 0){
                      $users = array();
                      while($row = mysqli_fetch_assoc($q)){
		                  $userDetails = array(
		                    'student_id' => $row['student_id'],
		                    'student_name' => $row['student_name'],
		                    'student_mobile' => $row['student_mobile'],
		                    'student_email' => $row['student_email'],
		                    'subject_id' => $row['subject_id'],
		                    'subject_name' => $row['subject_name'],
		                    'details_id' => $row['details_id']
		                  );
                          $users[] = $userDetails;
                        }
            
			            $response["status"] = "200";
			            $response["massage"] = "getalluserdetails with sunject";
			            $response["data"] = $users;
			            echo json_encode($response);
                    }else{
			            $response["status"] = "201";
			            $response["massage"] = "user not found";
			            echo json_encode($response);
                    }
                
	        }else if($tag=="studentsubjectdetails"){

					


			    $m->set_data("student_id",$student_id);
				$m->set_data("subject_id",$subject_id);
			
				$m->set_data("added_date",date("Y-m-d H:i:s"));

				$a=array(
					"student_id"=>$m->get_data("student_id"),
				    "subject_id"=>$m->get_data("subject_id"),
				 
				    "added_date"=>$m->get_data("added_date"),
				);
			
				$q=$d->insert("student_subject_details",$a);
	 			if ($q==true) {
	 				$response["status"]="200";
	 				$response["massage"]="insert success";
	 				echo json_encode($response);
	 			}else{
	 				$response["status"]="201";
	 				$response["massage"]="insert fail";
	 				echo json_encode($response);
		     }
	 	    }else{
		        $response["status"] = "201";
		        $response["massage"] = "wrong tag";
		        echo json_encode($response);
            }   
        }else{
        	$response["status"] = "201";
		    $response["massage"] = "wrong tag";
		    echo json_encode($response);
        }
    }else{
    	$response["status"] = "201";
	    $response["massage"] = "wrong api key";
	    echo json_encode($response);
    }
}
?>

