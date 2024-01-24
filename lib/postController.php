<?php 
include "lib.php";
if($_POST){
	extract($_POST);
	if ($key==$keydb) {
		if(isset($tag)&&$tag!=null){
			if($tag=="addpost"){

			   $folder = './post/';
			   if (!is_dir($folder)) {
                 mkdir($folder, 0755, true);
                }
			   if (!empty($_FILES["post_image"]["name"])) {
			        $allowedExtensions = array('jpg', 'png', 'jpeg', 'gif', 'pdf', 'doc');
			        $filename = $_FILES["post_image"]["name"];
			        $fileExtension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
			        

                    if (in_array($fileExtension, $allowedExtensions)) {
			            $tempname = $_FILES["post_image"]["tmp_name"];
			            $newFilePath = $folder . $filename;


			            if (move_uploaded_file($tempname, $newFilePath)) {
			                $m->set_data('post_image', $newFilePath);
			            } else {
			                $response["message"] = "File upload failed.";
			                $response["status"] = "201";
			                echo json_encode($response);
			                exit; 
			            }
			        }else {
            
				            $response["message"] = "Invalid file extension. Allowed extensions are jpg, png, jpeg, gif, pdf, doc.";
				            $response["status"] = "201";
				            echo json_encode($response);
				            exit; 
                        }  
                } else {
		        }
		        $q = $d->select("student_master","student_id='$student_id'");
		        if (mysqli_num_rows($q) > 0){
		        	$m->set_data('student_id',$student_id);
		     	
		     		$m->set_data('post_name',$post_name);
				    $m->set_data('added_date',date('Y/m/d H:i:s'));
				    $a = array(
						'student_id'=>$m->get_data('student_id'),
					
						'post_image'=>$m->get_data('post_image'),
						'added_date'=>$m->get_data('added_date'),
						'post_name'=>$m->get_data('post_name'),
			        );
			        $q7=$d->insert("post_master",$a);
			        $post_id = $con->insert_id;
			        if ($q7 == true) {

						$response["post_id"] = $post_id;
						$response["message"]="user post insert successfully.";
						$response["status"]="200";
						echo json_encode($response);

			        }else{
						$response["message"]="user post faild.";
						$response["status"]="201";
						echo json_encode($response); 
			        }

		        }else{
					$response["message"]="user post faild.";
					$response["status"]="201";
					echo json_encode($response); 
			    }
            } else if($tag=="getallpost"){

			  $get="";
              $q=$d->select("post_master,student_master","post_master.student_id=student_master.student_id");
              if(mysqli_num_rows($q)>0){
              	   $response["postlist"]=array();
              	   while ($data = mysqli_fetch_array($q)) {
              	   	  // $post_id = $data["post_id"];
              	   	  $postList = array();
              	   	      $postList["post_id"] = $data["post_id"];
              	   	      $postList["student_id"] = $data["student_id"];
              	   	      $postList["student_name"] = $data["student_name"];
              	   	      $postList["student_email"] = $data["student_email"];

              	   	      $postList["student_mobile"] = $data["student_mobile"];
              	   	      $postList["post_name"] = $data["post_name"];
              	   	      $postList["post_image"] ="http://localhost/StudentInformation/lib/". $data["post_image"];
              	   	    array_push($response["postlist"], $postList);

              	    }
              	    $response["message"] = "getall user post Successfully.";
                    $response["status"] = "200";
                    echo json_encode($response);
                }else{
                	$response["message"] = "user get post failed.";
                    $response["status"] = "201";
                    echo json_encode($response);  
                }
		    }else{
				$response["status"]="201";
				$response["massage"]="wrong tag";
				echo json_encode($response);
			}
		}else{
			$response["status"]="201";
			$response["massage"]="something went Wrong";
			echo json_encode($response);
		}
    }else{
		$response["status"]="201";
	 	$response["massage"]=" Wrong Api Key";
	 	echo json_encode($response);
	}
}    
	
?>	
