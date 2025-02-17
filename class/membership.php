<?php

class Membership
{
    /**
     * Handles creating and saving a new membership.
     *
     * @param array $post
     * @param string $gtime
     * @throws Exception
     */

	 public function set_arch_request_from_admin($post='')
    {
    	// date_default_timezone_set("Asia/Dhaka");
   
	   

		   if (!empty($data->application_date)) { 
			$application_date = "Application Date: " . $str->return_convert_date($str->application_date);
		} else {
			$application_date = "";
		}
		
		
   
		  if(!empty($post['thana_id'])){
			  $thana=$post['thana_id'];
		  }else{
			  $thana=null;
		  }

      global $gtime;
      $user_id=$_SESSION['user_id'];
	  $data= array(
		"name"=>$post['name'],					  
		"institute_name"=>$post['institute_name'],
		"institute_type"=>$post['institute_type'],					  
		"bed_qty"=>$post['bed_qty'],				 
		"req_by"=>$user_id		 
);

$insertId=QB::table('arch_client_req_tbl')->insert($data);
	  


	   $data= array(
		//"reqID"=>$user_id,
		"institute_bname"=>$post['institute_bname'],
        "generalmember_no"=>$post['generalmember_no'],
		"tin_no"=>$post['tin_no'],
		"reg_no"=>$post['reg_no'],
		"trade_no"=>$post['trade_no'],
		"hospital_info"=>$post['hospital_info'],
		"diagnostic_selected"=>$post['diagnostic_selected'],
		"payorder_no"=>$post['payorder_no'],
		"application_date"=>$post['application_date'],
		"proposer_name"=>$post['proposer_name'],
		"proposer_company"=>$post['proposer_company'],
	  );

	  $insertId=QB::table('arch_req_details')->insert($data);


	   $insert="Request has been Added";
	   echo"<script> window.location.replace('membership_list.php?id=$insertId&msg=$insert');</script>";

    }


	public function update_user($data='')
	{
	// date_default_timezone_set("Asia/Dhaka");	
    	global $gtime;
	$password=$data['password'];
	$id= $data['id'];	
	if(!empty($password)){
	$pass = password_hash($password, PASSWORD_DEFAULT);
	$data= array(
	      "firstName"=>$data['fname'],
	      "lastName"=>$data['lname'],
	      "firstNum"=>$data['fnum'],
	      "lastNum"=>$data['lnum'],
	      "email"=>$data['email'],
	      "password"=>$pass,
	      "depart"=>$data['dept'],
	      "desig"=>$data['desig'],
	      "roleId"=>$data['roleId'],
	      "status"=>$data['status'],
	      "mydate"=>$gtime
	    );
    }else{
    	$data= array(
	      "firstName"=>$data['fname'],
	      "lastName"=>$data['lname'],
	      "firstNum"=>$data['fnum'],
	      "lastNum"=>$data['lnum'],
	      "email"=>$data['email'],	     
	      "depart"=>$data['dept'],
	      "desig"=>$data['desig'],
	      "roleId"=>$data['roleId'],
	      "status"=>$data['status'],
	      "mydate"=>$gtime
	    );

    }
 QB::table('user_tbl')->where('user_id',$id)->update($data);
	 	 $update="Request has been updated";
	 	 $id=ID_encode($id);
	 echo"<script> window.location.replace('user-profile.php?id=$id&msg=$update');</script>";
	}

	public function user_delete($id){
		QB::table('user_tbl')->where('user_id',$id)->delete();
		 echo"<script> window.location.replace('user-list.php');</script>";
	}
	public function get_all_witty_request(){
			$query = QB::table('witty_client_req_tbl')->select('*')->orderBy('id','DESC');
	return $result = $query->get();
	}

	

	public function fetch_arch_request_details($insertId)
{
    // Ensure to sanitize the input $id to prevent SQL injection
    $id = intval($insertId);

	$rst = QB::table('arch_req_details')
    ->join('arch_client_req_tbl', 'arch_req_details.reqID', '=', 'arch_client_req_tbl.id')
    ->select('arch_req_details.*', 'arch_client_req_tbl.*')
    ->where('arch_req_details.reqID', $id)
	->first();


	// $result = "SELECT arch_req_details.*, t1.*
	// FROM arch_req_details
	// INNER JOIN arch_client_req_tbl AS t1 ON arch_req_details.reqID = t1.id
	// WHERE arch_req_details.id = $id";



    // Query to fetch details from arch_req_details
    // $result = QB::table('arch_req_details')
	// -            ->join(arch_client_req_tbl t1 INNER JOIN arch_req_details)
    //             ->where('id', $id)
    //             ->first(); // Fetches the first record matching the condition

    return $rst;
}

	
	public function update_arch_req($post){
		// date_default_timezone_set("Asia/Dhaka");
	  if(!empty($post['thana_id'])){
		  $thana=$post['thana_id'];
	  }else{
		  if(!empty($post['pre_thana_id'])){ 
		  $thana=$post['pre_thana_id'];
	  }else{
		  $thana=0;
	  }
	  }

   if(!empty($post['nf_date'])){          
		$str =$post['nf_date'];
		$date = DateTime::createFromFormat('d/m/Y', $str);
		$nf_date= $date->format('Y-m-d');
		  
		  }else{
		  $nf_date=null;
	   } 

   if(!empty($post['lf_date'])){     
		$str =$post['lf_date'];
		$date = DateTime::createFromFormat('d/m/Y', $str);
		$lf_date= $date->format('Y-m-d');
	   }else{
		   $lf_date=null;
	   }

	  global $gtime;

	  if (empty($post['student_qty'])) {

		  $post['student_qty']=1;
	  }
	   $data= array(
					 "name"=>$post['name'],
					 "mobile"=>$post['mobile'],
					 "email"=>$post['email'],
					 "institute_name"=>$post['institute_name'],
					 "institute_type"=>$post['institute_type'],
					 "org_address"=>$post['institute_add'],
					 "bed_qty"=>$post['student_qty'],
					 "req_type"=>$post['req_type'],					  
					 "assign_to"=>$post['assign_to'],
					 "status"=>$post['status'],
					 "remarks"=>$post['remarks'],
					 "note"=>$post['note'],
					 "district"=>$post['district_id'],
					 "desig"=>$post['desig'],
					 "thana"=>$thana,
					 "update_date"=>$gtime,
					 "update_by"=>$post['update_by']
				   );

	   $id=$post['id'];
	   QB::table('arch_client_req_tbl')->where('id',$id)->update($data);

	   $data= array(
		
		"institute_bname"=>$post['institute_bname'],
        "generalmember_no"=>$post['generalmember_no'],
		"tin_no"=>$post['tin_no'],
		"reg_no"=>$post['reg_no'],
		"trade_no"=>$post['trade_no'],
		"hospital_info"=>$post['hospital_info'],
		"diagnostic_selected"=>$post['diagnostic_selected'],
		"payorder_no"=>$post['payorder_no'],
		"application_date"=>$post['application_date'],
		"proposer_name"=>$post['proposer_name'],
		"proposer_company"=>$post['proposer_company'],
	  );

	  QB::table('arch_req_details')->insert($data);

	   
		$update="Request has been updated";

	   echo"<script> window.location.replace('membershipdetails_view.php?id=$id&dem=Arch&msg=$update');</script>";
   }


}