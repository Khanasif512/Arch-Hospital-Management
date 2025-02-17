<?php 
include 'connect.php';
/**
 * 
 */

class operation{ 
public function insert_witty_demo($post){
	global $gdate,$gtime;
$query= QB::table('settings')->where('name','=','auto_assign_user_witty_demo');
$result=$query->first();
// date_default_timezone_set("Asia/Dhaka");
$status=3;
$data= array(
			  "name"=>$post['fname'],
			  "mobile"=>$post['pnumber'],
			  "email"=>$post['email'],
			  "institute_name"=>$post['institutename'],
			  "institute_type"=>$post['institutetype'],
			  "institute_add"=>$post['instituteaddress'],
			  "student_qty"=>$post['studentno'],
			  "desig"=>$post['desig'],
			  "district"=>$post['district_id'],
			  "status"=>$status,
			  "thana"=>$post['thana_id'],
			  "req_type"=>"Demo",
			  "assign_to"=>$result->value,
			  "req_date"=>$gtime
				);
 QB::table('witty_client_req_tbl')->insert($data);
}

public function insert_witty_price($post){
$query= QB::table('settings')->where('name','=','auto_assign_user_witty_price');
$result=$query->first();
global $gtime;
$status=3;
$data= array(
			  "name"=>$post['fname'],
			  "mobile"=>$post['pnumber'],
			  "email"=>$post['email'],
			  "institute_name"=>$post['institutename'],
			  "institute_type"=>$post['institutetype'],
			  "institute_add"=>$post['instituteaddress'],
			  "student_qty"=>$post['studentno'],
			  "desig"=>$post['desig'],
			  "district"=>$post['district_id'],
			  "thana"=>$post['thana_id'],
			  "status"=>$status,
			  "req_type"=>"Price",
			  "assign_to"=>$result->value,
			  "req_date"=>$gtime
				); 

 QB::table('witty_client_req_tbl')->insert($data);
}

// price and demo for one function

public function insert_arch_demo($post,$type){

if($type=="Price"){
$query= QB::table('settings')->where('name','=','auto_assign_user_arch_price');
$result=$query->first();
}else{
$query= QB::table('settings')->where('name','=','auto_assign_user_arch_demo');
$result=$query->first();
}
$status=3;
global $gtime;
$data=array(
           "name"=>$post['fname'],
           "desig"=>"N/A",
           "mobile"=>$post['pnumber'],
           "email"=>$post['email'],
           "institute_name"=>$post['institutename'],
           "bed_qty"=>$post['bedno'],
           "org_address"=>$post['instituteaddress'],
           "institutetype"=>$post['institutetype'],             
           "req_type"=>$type,           
           "district"=>$post['district_id'],
           "thana"=>$post['thana_id'], 
           "status"=>$status,
           "assign_to"=>$result->value,       
           "req_date"=>$gtime
              );

QB::table('arch_client_req_tbl')->insert($data);

}


public function login_function($data){

	$email=$data['username'];
	$password=$data['password'];
	$query= QB::table('user_tbl')->where('email','=',$email);
	$result=$query->first();
if(!empty($result->password)){
if(password_verify($password,$result->password)){
  $_SESSION['email']=$result->email;
  $_SESSION['user_id']=$result->user_id;
  $_SESSION['userLogin'] = "Loggedin";
  $_SESSION['name']=$result->firstName.' '.$result->lastName;
  //unset( $_SESSION['errorMessage'] );
  echo"<script> window.location.replace('dashboard.php');</script>";
  }else{	
  $_SESSION['errorMessage'] = "Please Enter Valied Email Or password"; 
  }
  }else{	
	$_SESSION['errorMessage'] = "Please Enter Valied Email Or password";	
    }
}



public function user_registration($data='')
{
	$email=$data['email'];
	$query= QB::table('user_tbl')->where('email','=',$email);
	$result=$query->first();
if(empty($result)){ 
		global $gtime;
	$password=$data['password'];	
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
   $insertId =QB::table('user_tbl')->insert($data);
   $insert="Request has been Added";
 echo"<script> window.location.replace('user-profile.php?id=$insertId&msg=$insert');</script>";

}else{    

	 echo"<script> window.location.replace('add-user.php');</script>";
}

}

public function get_all_users(){
	$query = QB::table('user_tbl')->where('status','=',1)->orderBy('orderby','ASC')->select('*');
	return $result = $query->get();
}

public function detailsAndupdateProfile($id){
		$query= QB::table('user_tbl')->where('user_id','=',$id);
		return $result=$query->first();
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

	public function detailsWityclientRequest($id){
			$query = QB::table('witty_client_req_tbl')->where('id','=',$id);
	return $result = $query->first();
	}	

	public function detailsarchclientRequest($id){
			$query = QB::table('arch_client_req_tbl')->where('id','=',$id);
	return $result = $query->first();
	}


public function convert_date($date="") {
  if (!empty($date)) {
    return date("Y-m-d",strtotime($date));
  } else {
    return  "";
  }  
}

public function convert_db_date($date="") {
  if (!empty($date)) {
  	    $rq_date = DateTime::createFromFormat('d/m/Y',  $date);	    
     return $rq_date->format('Y-m-d');
  } else {
    return  "";
  }  
}

public function return_convert_date($date="") {
  if (!empty($date)) {
    return date("d-m-Y",strtotime($date));
  } else {
    return  "";
  }  
}

	public function update_witty_client_req($post){
	
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
					  "institute_add"=>$post['institute_add'],
					  "student_qty"=>$post['student_qty'],
					  "req_type"=>$post['req_type'],
					  "assign_to"=>$post['assign_to'],
					  "status"=>$post['status'],
					  "remarks"=>$post['remarks'],
					  "note"=>$post['note'],
					  "district"=>$post['district_id'],
					  "desig"=>$post['desig'],					  
					  "thana"=>$thana,
					  "next_followup_date"=>$nf_date,	
					  "last_followup_date"=>$lf_date,
					  "update_date"=>$gtime,
					  "update_by"=>$post['update_by']
				    );

		$id=$post['id'];
	  QB::table('witty_client_req_tbl')->where('id',$id)->update($data);
		 $update="Request has been updated";
	     // INFO::$msg->info('Request has been updated');
		echo"<script> window.location.replace('witty-demo-view.php?id=$id&dem=Witty&msg=$update');</script>";
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
					  "next_followup_date"=>$nf_date,	
					  "last_followup_date"=>$lf_date,
					  "update_date"=>$gtime,
					  "update_by"=>$post['update_by']
				    );

		$id=$post['id'];
		QB::table('arch_client_req_tbl')->where('id',$id)->update($data);

		
		 $update="Request has been updated";

		echo"<script> window.location.replace('arch-demo-view.php?id=$id&dem=Arch&msg=$update');</script>";
	}

	public function delete_witty_client_request($id){
			 QB::table('witty_client_req_tbl')->where('id',$id)->delete();
			 echo"<script> window.location.replace('witty-request.php');</script>";
	      }
	public function delete_arch_client_request($id){
			 QB::table('arch_client_req_tbl')->where('id',$id)->delete();
			 echo"<script> window.location.replace('witty-request.php');</script>";
	      }


    public function get_district(){
 	        $query = QB::table('district')->select('*');
            return $result = $query->get();
          }


          public function getStateRows($district_id){
			$query = QB::table('thana')->where('district_id','=',$district_id);
        	return $result = $query->get();

          }

public function type_list() {
		  return array(
				"1"=>"Bangla M",
				"2"=>"English V",
				"3"=>"English M",
				"4"=>"Madrasah",
				"5"=>"Polytechnic"
		);
}
public function font_type_list() {
		  return array(
				"1"=>"Bangla Medium",
				"2"=>"English Version",
				"3"=>"English Medium",
				"4"=>"Madrasah",
				"5"=>"Polytechnic Institute"
		     );
}

public function return_type($id){
	  switch ($id) {
    case 1: 
          return  "Bangla M"; break;
    case 2: 
          return  "English V"; break;
    case 3: 
          return  "English M"; break;
    case 4: 
          return  "Madrasah"; break;
    case 5: 
          return  "Polytechnic"; break;

		default :
			return "";		
    }
}

public function arch_type_list(){
	return array(
           "Individually Owned"=>"Individually Owned",
           "Jointly Owned"=>"Jointly Owned",
           "Private Ltd"=>"Private Ltd",
           "Public Limited"=>"Public Limited"

	);
}
public function font_arch_type_list(){
	return array(
           "Individually Owned"=>"Individually Owned",
           "Jointly Owned"=>"Jointly Owned",
           "Private Ltd"=>"Private Ltd",
           "Public Limited"=>"Public Limited"

	);
}

public function return_arch_type_list($id){
	  switch ($id) {
    case 1: 
          return  "Individually Owned"; break;
    case 2: 
          return  "Jointly Owned"; break;
    case 3: 
          return  "Private Ltd"; break;
    case 4: 
          return  "Public Limited"; break;

		default :
			return "";		
    }
}

public function return_arch_type_icon($id){
	     switch ($id) {
			    case 1: 			         
			        return  '<i class="fas fa-hospital-symbol"></i>'; break;
			    case 2: 			          
			          return  '<i class="fas fa-briefcase-medical"></i>'; break;
			    case 3: 
			           return  '<i class="fas fa-x-ray"></i>'; break;
			    case 4: 
			         return  '<i class="fas fa-hospital"></i>'; break;

					default :
						return "";		
    }
}

public function return_query_icon($query){
	     switch ($query) {
			    case 'Price': 			         
			        return  '<i class="far fa-money-bill-alt"></i>'; break;
			    case 'Demo': 			          
			          return  '<i class="fas fa-laptop"></i>'; break;
			    case 'camp': 
			           return  '<i class="fas fa-bullhorn"></i>'; break;
			    case 'Refer': 
			         return  '<i class="fas fa-hand-holding-heart"></i>'; break;

					default :
						return "";		
    }
}


public function set_status($post){
	 $data=array("name"=>$post['name']);
	 QB::table('status')->insert($data);
	 $msg="Request has been Added";
	 echo"<script> window.location.replace('status.php?&msg=$msg');</script>";

    }

   public function get_all_status(){
   	     $query = QB::table('status')->select('*');
            return $result = $query->get();

   } 
   public function get_status($id){
   		   $query = QB::table('status')->where('id','=',$id);
        	return $result = $query->first();
          }

   public function update_status($post){   	     
        	$id=$post['status_id'];
   		    $data=array("name"=>$post['name']);	    
	         QB::table('status')->where('id',$id)->update($data);
	        $msg="Status has been updated";	
	        echo"<script> window.location.replace('view_status.php?id=$id?&msg=$msg');</script>";
       }    

   public function delete_Status($id){
   		  QB::table('status')->where('id',$id)->delete();
		  echo"<script> window.location.replace('status.php');</script>";
        }

 public function return_times($datetime="") {
  if (!empty($datetime)){
    return date("d-m-Y h:i A",strtotime($datetime));
  } else {
    return  "";
  }  
}  

public function set_witty_comments($post, $id){
	// date_default_timezone_set("Asia/Dhaka");
	
	global $gtime;

	$data=array("remarks"=>$post['remarks'],
                 "witty_req_id"=>$post['witty_req_id'],
                 "user_id"=>$post['user_id'],
                 "rem_date"=>$gtime
                   );
	 QB::table('witty_comments')->insert($data);
 echo"<script> window.location.replace('witty-demo-view.php?id=$id');</script>";

}

public function witty_last_five_comments($id){
	   $query = QB::table('witty_comments')->select('witty_comments.*','user_tbl.firstName','user_tbl.lastName')->where('witty_comments.witty_req_id','=',$id)->leftjoin('user_tbl', 'user_tbl.user_id', '=', 'witty_comments.user_id')->orderBy('witty_comments.id', 'DESC')->limit(10);
       return $result = $query->get();

      }

    public function set_arch_comments($post,$id){
    // date_default_timezone_set("Asia/Dhaka");
		global $gtime;
	$data=array("remarks"=>trim($post['remarks']),
                 "arch_req_id"=>$post['arch_req_id'],
                 "user_id"=>$post['user_id'],
                 "rem_date"=>$gtime
                   );
	 QB::table('arch_comments')->insert($data);
	 echo"<script> window.location.replace('arch-demo-view.php?id=$id');</script>";

}


public function arch_last_five_comments($id){
	   $query = QB::table('arch_comments')->select('arch_comments.*','user_tbl.firstName','user_tbl.lastName')->where('arch_comments.arch_req_id','=',$id)->leftjoin('user_tbl', 'user_tbl.user_id', '=', 'arch_comments.user_id')->orderBy('arch_comments.id', 'DESC')->limit(15);
       return $result = $query->get();

      }

public function get_arch_comments(){
  $query = QB::table('arch_comments')->select('arch_comments.*','user_tbl.firstName','user_tbl.lastName','arch_client_req_tbl.institute_name')->leftjoin('user_tbl', 'user_tbl.user_id', '=', 'arch_comments.user_id')->leftjoin('arch_client_req_tbl','arch_client_req_tbl.id','=','arch_comments.arch_req_id')->orderBy('id', 'DESC');
       return $result = $query->get();

} 

public function get_witty_comments(){
  $query = QB::table('witty_comments')->select('witty_comments.*','user_tbl.firstName','user_tbl.lastName','witty_client_req_tbl.institute_name')->leftjoin('user_tbl', 'user_tbl.user_id', '=', 'witty_comments.user_id')->leftjoin('witty_client_req_tbl','witty_client_req_tbl.id','=','witty_comments.witty_req_id')->orderBy('id', 'DESC');
       return $result = $query->get();

}      

public function get_user_name($id){
	  $query = QB::table('user_tbl')->where('user_id','=',$id);
      $result = $query->first();
     return $result->firstName.' '.$result->lastName;
}


 public function get_orgname($value='')
{
      $query=QB::table('arch_client_req_tbl')->where('institute_name', 'LIKE', '%'.$value.'%')->limit(10);
      return $result = $query->get();

}

public function todays_witty_request(){
	// date_default_timezone_set("Asia/Dhaka");
global $gdate;
	return $query=QB::query("SELECT COUNT(id) as num  FROM witty_client_req_tbl WHERE DATE(req_date) = '{$gdate}'")->first();

	
}
public function todays_witty_price_request(){
	// date_default_timezone_set("Asia/Dhaka");
	global $gdate;
	return $query=QB::query("SELECT COUNT(id) as num  FROM witty_client_req_tbl WHERE DATE(req_date) = '{$gdate}' AND req_type ='Price' ")->first();

	
}

public function todays_witty_demo_request(){
	// date_default_timezone_set("Asia/Dhaka");
	global $gdate;
	return $query=QB::query("SELECT COUNT(id) as num  FROM witty_client_req_tbl WHERE DATE(req_date) = '{$gdate}' AND req_type ='Demo' ")->first();

	
}
// arch

public function todays_arch_request(){
	// date_default_timezone_set("Asia/Dhaka");
global $gdate;
	return $query=QB::query("SELECT COUNT(id) as num  FROM arch_client_req_tbl WHERE DATE(req_date) = '{$gdate}'")->first();

	
}

public function todays_arch_price_request(){
	// date_default_timezone_set("Asia/Dhaka");
     global $gdate;
	return $query=QB::query("SELECT COUNT(id) as num  FROM arch_client_req_tbl WHERE DATE(req_date) = '{$gdate}' AND req_type ='Price' ")->first();

	
}

public function todays_arch_demo_request(){
	// date_default_timezone_set("Asia/Dhaka");
    global $gdate;
	return $query=QB::query("SELECT COUNT(id) as num  FROM arch_client_req_tbl WHERE DATE(req_date) = '{$gdate}' AND req_type ='Demo' ")->first();

	
}

public function todays_pending_followup(){
	// date_default_timezone_set("Asia/Dhaka");
   global $gdate;
	return $query=QB::query("SELECT id, institute_name,status,bed_qty FROM (SELECT id, status,institute_name, Null AS bed_qty FROM witty_client_req_tbl WHERE next_followup_date = '{$gdate}'  UNION ALL SELECT id,status, institute_name, bed_qty FROM arch_client_req_tbl WHERE next_followup_date = '{$gdate}' )  ab GROUP BY id, institute_name")->limit(10)->get();
	
    }
public function todays_pending_followup_count(){
	// date_default_timezone_set("Asia/Dhaka");
global $gdate;
	return $query=QB::query("SELECT id, institute_name, bed_qty FROM (SELECT id, institute_name, Null AS bed_qty FROM witty_client_req_tbl WHERE next_followup_date = '{$gdate}'  UNION ALL SELECT id, institute_name, bed_qty FROM arch_client_req_tbl WHERE next_followup_date = '{$gdate}' )  ab GROUP BY id, institute_name")->get();
	
    }

public function todays_contact_followup(){
	// date_default_timezone_set("Asia/Dhaka");
     global $gdate;        
	return $query=QB::query("SELECT id, institute_name,status, bed_qty FROM (SELECT id, institute_name,status, Null AS bed_qty FROM witty_client_req_tbl WHERE last_followup_date = '{$gdate}'  UNION ALL SELECT id, institute_name,status,bed_qty FROM arch_client_req_tbl WHERE last_followup_date = '{$gdate}' )  ab GROUP BY id, institute_name")->limit(10)->get();
	
    }
public function todays_last_followup_count(){
	// date_default_timezone_set("Asia/Dhaka");
       global $gdate;       
	return $query=QB::query("SELECT id, institute_name, bed_qty FROM (SELECT id, institute_name, Null AS bed_qty FROM witty_client_req_tbl WHERE last_followup_date = '{$gdate}'  UNION ALL SELECT id, institute_name, bed_qty FROM arch_client_req_tbl WHERE last_followup_date = '{$gdate}' )  ab GROUP BY id, institute_name")->get();
	
    }

    public function get_all_arch_status($id=null){
    	return $query= QB::query("SELECT COUNT(id) as num FROM arch_client_req_tbl WHERE status='{$id}'")->first();
    }  

    public function get_all_witty_status($id=null){
    	return $query= QB::query("SELECT COUNT(id) as num FROM witty_client_req_tbl WHERE status='{$id}'")->first();
    }   
  public function get_all_today_arch_status($id=null,$fromDate=NULL,$toDate=NULL){
  	// date_default_timezone_set("Asia/Dhaka");
  	    global $gdate;
    	return $query= QB::query("SELECT COUNT(id) as num FROM `arch_client_req_tbl` WHERE status ='{$id}' AND update_date BETWEEN '{$fromDate}' AND '{$toDate}'")->first();
    } 
   public function get_all_today_witty_status($id=null,$fromDate=NULL,$toDate=NULL){
   	// date_default_timezone_set("Asia/Dhaka");
  	    global $gdate;
  	   
    	return $query= QB::query("SELECT COUNT(id) as num FROM witty_client_req_tbl WHERE status='{$id}' AND update_date BETWEEN '{$fromDate}' AND '{$toDate}'")->first();
    }


	public function new_request_witty_from_admin($post){    
		// date_default_timezone_set("Asia/Dhaka");
		$query= QB::table('settings')->where('name','=','auto_assign_user_witty_demo');
		$result=$query->first();
		if(!empty($post['assign_to'])){
			$assign=$post['assign_to'];
		}else{
			$assign=$result->value;
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
			  "mobile"=>$post['mobile'],
			  "email"=> $post["email"],
			  "institute_name"=> $post["institute_name"],
			  "institute_type"=>$post['institute_type'],
			  "institute_add"=>$post['institute_add'],
			  "student_qty"=>$post['student_qty'],
			  "desig"=>$post['desig'],
			  "district"=>$post['district_id'],
			  "thana"=>$thana,
			  "req_type"=>$post['req_type'],
			  "assign_to"=>$assign,
			  "status"=>$post['status'],
			  "remarks"=>$post['remarks'],
			  "req_date"=>$gtime,
			  "req_by"=>$user_id
				); 

     $insertId = QB::table('witty_client_req_tbl')->insert($data);
     $insert="Request has been Added";
	  echo"<script> window.location.replace('witty-demo-view.php?id=$insertId&msg=$insert');</script>";
    }

//   public function set_arch_request_from_admin($post='')
//   {

// 	if(!empty($post['application_date'])){     
// 		$str =$post['application_date'];
// 		$date = DateTime::createFromFormat('d/m/Y', $str);
// 		$application_date= $date->format('Y-m-d');
// 	   }else{
// 		   $application_date=null;
// 	   }

//     //    if(!empty($post['thana_id'])){
//     //    	$thana=$post['thana_id'];
//     //    }else{
//     //    	$thana=null;
//     //    }

//       global $gtime;
//       $user_id=$_SESSION['user_id'];
// 		$data= array(
// 					  "name"=>$post['name'],
// 					  "mobile"=>$post['mobile'],
// 					  "email"=>$post['email'],
// 					  "institute_name"=>$post['institute_name'],
// 					  "institute_type"=>$post['institute_type'],
// 					  "org_address"=>$post['institute_add'],
// 					  "bed_qty"=>$post['bed_qty'],
// 					  "req_type"=>$post['req_type'],
// 					  "status"=>$post['status'],
// 					  "district"=>$post['district_id'],
// 					  "desig"=>$post['desig'],
// 					  "thana"=>$post['thana'],
// 					  "req_by"=>$user_id					 
// 				    );

// 	   QB::table('arch_client_req_tbl')->insert($data);


// 	   $data= array(
// 		// "reqID"=>$user_id,
// 		"institute_bname"=>$post['institute_bname'],
//         "generalmember_no"=>$post['generalmember_no'],
// 		"tin_no"=>$post['tin_no'],
// 		"reg_no"=>$post['reg_no'],
// 		"trade_no"=>$post['trade_no'],
// 		"hospital_info"=>$post['hospital_info'],
// 		"diagnostic_selected"=>$post['diagnostic_selected'],
// 		"payorder_no"=>$post['payorder_no'],
// 		"application_date"=>$post['application_date'],
// 		"proposer_name"=>$post['proposer_name'],
// 		"proposer_company"=>$post['proposer_company'],
// 	  );

// 	  $insertId=QB::table('arch_req_details')->insert($data);

// 	   $insert="Request has been Added";
// 	   echo"<script> window.location.replace('arch-demo-view.php?id=$insertId&msg=$insert');</script>";

//     }


    public function get_thana_name($id){
    	 $query= QB::table('thana')->where('id','=', $id);
      return $result=$query->first();

    }

    public function return_district($id){
	$query= QB::table('district')->where('id','=', $id);
          return $result=$query->first();
}


public function all_pending_request(){
	$status=3;
	return $query=QB::query("SELECT id, institute_name, bed_qty FROM (SELECT id, institute_name, Null AS bed_qty FROM witty_client_req_tbl WHERE status = '{$status}'  UNION ALL SELECT id, institute_name, bed_qty FROM arch_client_req_tbl WHERE status = '{$status}' )  ab GROUP BY id, institute_name")->limit(15)->get();
	
    }
public function witty_latest_comments($value=''){ 


       return $query= QB::query("SELECT t1.*, t2.firstName, t2.lastName, t3.institute_name, t4.name AS districtName, t5.name AS statusName
     						FROM witty_comments t1
     						LEFT JOIN user_tbl t2 ON t1.user_id=t2.user_id
     						LEFT JOIN witty_client_req_tbl t3 ON t3.id= t1.witty_req_id
     						LEFT JOIN district t4 ON t4.id=t3.district
     						LEFT JOIN status t5 ON t3.status=t5.id ORDER BY t1.id DESC LIMIT 30 ")->get();
}

public function arch_latest_comments($value=''){ 


    return $query= QB::query("SELECT t1.*, t2.firstName, t2.lastName, t3.institute_name, t4.name AS districtName, t5.name AS statusName
     						FROM arch_comments t1
     						LEFT JOIN user_tbl t2 ON t1.user_id=t2.user_id
     						LEFT JOIN arch_client_req_tbl t3 ON t3.id= t1.arch_req_id
     						LEFT JOIN district t4 ON t4.id=t3.district
     						LEFT JOIN status t5 ON t3.status=t5.id  ORDER BY t1.id DESC LIMIT 30 ")->get();

     
}

// Campaign start here
public function set_campaign($post=null){
	$data=array("camp_name"=>$post['name'],
                "type"=>$post['type'],
                "status"=>$post['status']);
	 QB::table('campaign')->insert($data);
	 $msg="Request has been added";
	 echo"<script> window.location.replace('campaign.php?&msg=$msg');</script>";

}

   public function get_all_campagin(){
   	     $query = QB::table('campaign')->select('*')->where('status','1')->orderBy('id','DESC');
            return $result = $query->get();

   }  

   public function get_all_campagin_type($type){
   	     $query = QB::table('campaign')->where('type','=',$type)->where('status','=',1)->orderBy('camp_name','ASC');
            return $result = $query->get();

   } 

      public function get_campaign($id){
   		   $query = QB::table('campaign')->where('id','=',$id);
        	return $result = $query->first();
          }
     public function update_campaign($post){   	     
        	$id=$post['camp_id'];
   		    $data=array("camp_name"=>$post['name'],
                        "type"=>$post['type'],
                        "status"=>$post['status']);   
	         QB::table('campaign')->where('id',$id)->update($data);
	        $msg="Campaign has been updated";	
	        echo"<script> window.location.replace('view_campaign.php?id=$id?&msg=$msg');</script>";
       }  

        public function delete_campaign($id){
   		  QB::table('campaign')->where('id',$id)->delete();
		  echo"<script> window.location.replace('campaign.php');</script>";
        }

        public function get_number_of_camp($id){
        	return $query=QB::query("SELECT COUNT(id) as num  FROM campaign_list WHERE camp_id = '{$id}'")->first();
        }

    public function set_campaign_list($post){
    

        	foreach ($post['checkbox'] as  $value) {
        		$check=QB::table('campaign_list')->where('camp_id','=', $post['campaign_id'])->where('req_id','=',$value)->first();
        	   if(empty($check)){
        	   $data=array("camp_id"=>$post['campaign_id'],
                        "req_id"=>$value
                );
          
        	    QB::table('campaign_list')->insert($data);
        	}}
        	
        	  
	   $msg="Request has been added";	  
	 if($post['type']==1){
	    echo"<script> window.location.replace('witty-request.php?msg=$msg');</script>";
      } 
      if($post['type']==2){
	    echo"<script> window.location.replace('arch-request.php?msg=$msg');</script>";
      }
        }

 

   public function set_camp_email_template($post=''){
              $data=array("name"=>$post["name"],
                          "type"=>$post["type"],
                          "subject"=>$post["subject"],
                          "body"=>$post["body"], 
                           );

              if(empty($post['id'])){
              QB::table('camp_email_template')->insert($data);
               $msg="Request has been added";               
             echo"<script> window.location.replace('cam_email_template.php?msg=$msg');</script>";
              }else{
              	if(!empty($post['id'])){
              		$id=$post['id'];
              		 QB::table('camp_email_template')->where('id',$id)->update($data);
                     $msg="Request has been updated";
                    echo"<script> window.location.replace('camp_add_email_template.php?id=$id&msg=$msg');</script>";
              	}
              }

   }

     public function get_all_camp_email_temp(){
   	     $query = QB::table('camp_email_template')->select('*');
            return $result = $query->get();

   } 


	public function get_single_camp_email_temp($id){
			$query = QB::table('camp_email_template')->where('id','=',$id);
	return $result = $query->first();
	}

	public function delete_camp_email_template($id){
			 QB::table('camp_email_template')->where('id',$id)->delete();
			     $msg="Request has been deleted";  
			 echo"<script> window.location.replace('cam_email_template.php?msg=$msg');</script>";
	      }

	public function get_template($type,$temp_id){
			return $check=QB::table('camp_email_template')->where('id','=', $temp_id)->where('type','=',$type)->first();
	} 
	
	public function get_all_institue_by_type($type=''){
		if(!empty($type)){
			if($type==1){				
			$tbl="witty_client_req_tbl";
			}
			if($type==2){
            $tbl="arch_client_req_tbl";
			}

			 $query = QB::table($tbl)->select('*')->orderBy('id','DESC');;
            return $result = $query->get();
		}
	} 

	public function set_all_camp_email($post=null, $type=null, $attached=null){
		       		$company_mail =null;   
	            $cc_mails = $post["cc_mail"];
              if(!empty($cc_mails) && is_array($cc_mails)){	           
		           $cc_mail = implode(',', $cc_mails);
			         }else{
			         	$cc_mail=NULL;
			         }

	           if(isset($post["company_mail"])){
	   	       	$company_mails = $post["company_mail"];
	           	$company_mail = implode(',', $company_mails); 
	            }	            
	           
	           $todate_time = date("Y-m-d H:i:s");


		 $data = array('temp_id' => $post["temp_id"],
		 	           'subject'=>$post["subject"],
		 	           'body'=>$post["body"],
		 	           'send_by'=>$_SESSION['user_id'],
		 	           'cc_mail'=>$cc_mail,
		 	           'company_email'=>$company_mail,
		 	           'attached'=>$attached,
		 	           'time'=>$todate_time
		              );
        

    $last_id= QB::table('camp_email_set')->insert($data);  

 
    //  $msg="Request has been added";               
    // echo"<script> window.location.replace('cam_email_template.php?msg=$msg');</script>"; 
    
       if(isset($post['institute'])){

       	if($type==1){
           $institute= $this->detailsWityclientRequest($post["institute"]);
           }

         if($type==2){
       	   $institute=$this->detailsarchclientRequest($post["institute"]);
          }      

         $to_mail=$institute->email; 



         if(filter_var($to_mail, FILTER_VALIDATE_EMAIL)){
         	
       	 $institute_set = array('set_id' =>$last_id,
       	                       'req_id'=>$post['institute'],
       	                       'to_email'=>$to_mail
       	                      );

       	QB::table('camp_email_set_request')->insert($institute_set);

       }


   }

      if(isset($post['campaign'])){         
        if($type=='1'){        
        $campaign_req = QB::table('campaign_list')->select('campaign_list.*','witty_client_req_tbl.email')->leftjoin('witty_client_req_tbl', 'witty_client_req_tbl.id', '=', 'campaign_list.req_id')->where('camp_id','=',$post['campaign'])->get();            
        }elseif($type=='2'){        
        $campaign_req = QB::table('campaign_list')->select('campaign_list.*','arch_client_req_tbl.email')->leftjoin('arch_client_req_tbl', 'arch_client_req_tbl.id', '=', 'campaign_list.req_id')->where('camp_id','=',$post['campaign'])->get();            
        }

        
         foreach ($campaign_req  as  $req) { 

         	if(filter_var($req->email, FILTER_VALIDATE_EMAIL)){

                	$campaign = array('set_id' =>$last_id,
       	                             'req_id'=>$req->req_id,
       	                             'to_email'=>$req->email
       	                          );

       	QB::table('camp_email_set_request')->insert($campaign);
       }
       }

       }
                    
 }    


	public function arch_campaign_delete($get){
		$camp_id=$get['camp_id'];
		QB::table('campaign_list')->where('camp_id',$camp_id)->where('req_id',$get['del_req_id'])->delete();
		$msg="Request has been deleted";
		echo"<script> window.location.replace('campaign_arch.php?type=2&camp_id=$camp_id&msg=$msg');</script>";
	}
		public function witty_campaign_delete($get){
		     $camp_id=$get['camp_id'];
		     QB::table('campaign_list')->where('camp_id',$camp_id)->where('req_id',$get['del_req_id'])->delete();
		     $msg="Request has been deleted";
		  echo"<script> window.location.replace('campaign_witty.php?type=1&camp_id=$camp_id&msg=$msg');</script>";
	}
    
    public function get_camp_email_sending_req($get){
    	$id=$get['camp_email_set_req_id'];
    	$type=$get['type'];
		 // if($type==1){
	 	 //$req_tbl="witty_client_req_tbl";
	     //} 	
	    // if($type==2){
	    //$req_tbl="arch_client_req_tbl";
	    //}  
        // ->leftjoin('{$req_tbl}', '{$req_tbl}.id', '=', 'camp_email_set_request.req_id')
    	 // ->leftjoin('user_tbl', 'user_tbl.user_id', '=', 'camp_email_set.send_by')
    	 return $query = QB::table('camp_email_set_request')->select('camp_email_set.*','camp_email_set_request.req_id','user_tbl.firstName','user_tbl.lastName')->where('camp_email_set_request.id','=',$id)->leftjoin('camp_email_set', 'camp_email_set.id', '=', 'camp_email_set_request.set_id')->leftjoin('user_tbl', 'user_tbl.user_id', '=', 'camp_email_set.send_by')->first();
          
    }


public function get_settings_value($data){
	$query= QB::table('settings')->where('name','=',$data);
	$result=$query->first();
	return $result->value;
}

  public function witty_latest_five($id, $type){
  	$query= QB::table('sms_history')->select('*')->where('uhid','=',$id)->where('type',$type)->orderBy('id','DESC')->limit(10);
	return $result=$query->get();

  } 

   public function email_latest_five($id, $type){
  	$query= QB::table('camp_email_set_request')
  	        ->select('camp_email_set_request.*','camp_email_set.subject','camp_email_set.time')
  	        ->leftjoin('camp_email_set', 'camp_email_set.id', '=', 'camp_email_set_request.set_id')
  	        ->leftjoin('camp_email_template', 'camp_email_template.id', '=', 'camp_email_set.temp_id')
  	        ->where('camp_email_set_request.req_id','=',$id)->where('camp_email_template.type',$type)->orderBy('camp_email_set_request.id','DESC')->limit(5);
	return $result=$query->get();

  }

 public function assign_getCampaign($id, $type){
  	$query= QB::table('campaign')->select('*')->innerjoin('campaign_list', 'campaign_list.camp_id', '=', 'campaign.id')->where('campaign.type','=',$type)->where('campaign_list.req_id',$id);
	return $result=$query->get();

  }

  public function get_setting($name){
           	$result= QB::table('settings')->select('*')->where('name',$name)->first();
           	if(!empty($result)){
           		return $result->value;
           	}
           	} 
   public function update_setting($name, $value){
          
             $data=array("value"=>$value);
           	QB::table('settings')->where('name',$name)->update($data);     

           }
//update satart here

public function set_documents($post='', $file=Null){


   $today=date("Y-m-d");
    $str =$post['doc_date'];
    $doc_date = DateTime::createFromFormat('d/m/Y', $str);
    $doc_date= $doc_date->format('Y-m-d');
 if(!empty($post['documentID']) && $post['documentID']!=" "){
   	$docId=$post['documentID'];
if(!empty($file)){
	if(!empty($_POST['file_names'])){
 $updateFile=$_POST['file_names'].','.$file;
}else{
	 $updateFile=$file;
}
}else{
	if(!empty($_POST['file_names']) && $_POST['file_names']!=" "){
	$updateFile=$_POST['file_names'];
}else{
	$updateFile=Null;
}
}

   	$data= array(
					  "name"=>$post['doc_name'],
					  "reqID"=>$post['reqID'],
					  "softID"=>$post['softID'],
					  "type"=>$post['type'],
					  "file_names"=>$updateFile,
					  "note"=>$post['note'],
					  "date"=>$doc_date,
					  "status"=>$post['status'],
					  "update_date"=>$today,
					  "user_id"=>$_SESSION["user_id"]
				    );
   		QB::table('documents')->where('id',$docId)->update($data);

   	 $insert="Document has been Updated";

   }else{

		$data= array(
					  "name"=>$post['doc_name'],
					  "reqID"=>$post['reqID'],
					  "softID"=>$post['softID'],
					  "type"=>$post['type'],
					  "file_names"=>$file,
					  "note"=>$post['note'],
					  "date"=>$doc_date,
					  "status"=>$post['status'],
					  "user_id"=>$_SESSION["user_id"]
				    );

	   $docId=QB::table('documents')->insert($data);
	   $insert="Document has been Added";
	 }

	   echo"<script> window.location.replace('new-document.php?doc_id=$docId&msg=$insert');</script>";

    }
	public function get_documents($id){
			$query = QB::table('documents')->where('id','=',$id);
	return $result = $query->first();
	}
public function get_all_documents($id, $softId){	
   return $query=QB::query("SELECT documents.*,doc_type.name AS docName, user_tbl.firstName,user_tbl.lastName 
   	                        FROM documents LEFT JOIN doc_type ON doc_type.id=documents.type 
   	                        LEFT JOIN user_tbl ON user_tbl.user_id=documents.user_id WHERE documents.reqID='$id' AND documents.softID='$softId' ")->get();

}

//type start here
public function set_docType($post){
	 $data=array("name"=>$post['name']);
	 QB::table('doc_type')->insert($data);
	 $msg="Request has been Added";
	 echo"<script> window.location.replace('doc_type.php?&msg=$msg');</script>";

    }

   public function get_all_docType(){
   	     $query = QB::table('doc_type')->select('*')->orderBy('name','ASC');
            return $result = $query->get();

   }
   public function get_docType($id){
   		   $query = QB::table('doc_type')->where('id','=',$id);
        	return $result = $query->first();
          }

   public function update_docType($post){
        	$id=$post['status_id'];
   		    $data=array("name"=>$post['name']);
	         QB::table('doc_type')->where('id',$id)->update($data);
	        $msg="Status has been updated";
	        echo"<script> window.location.replace('view_status.php?id=$id?&msg=$msg');</script>";
       }

   public function delete_docType($id){
   		  QB::table('doc_type')->where('id',$id)->delete();
		  echo"<script> window.location.replace('doc_type.php');</script>";
        }


//type end here

         public function set_single_campaign_list($post,$type){

        		$check=QB::table('campaign_list')->where('camp_id','=', $post['campaign_id'])->where('req_id','=',$post['reqID'])->first();
        	   if(empty($check)){
        	   $data=array("camp_id"=>$post['campaign_id'],
                        "req_id"=>$post['reqID']
                );
        	    QB::table('campaign_list')->insert($data);
        	    $msg=1;
        	}else{
        		$msg=11;
        	}


	 $id=$post['reqID'];
	 if($type==1){
	    echo"<script> window.location.replace('witty-demo-view.php?id=$id&msg=$msg');</script>";
      }
      if($type==2){
	    echo"<script> window.location.replace('arch-demo-view.php?id=$id&msg=$msg');</script>";
      }
        }


   public function get_all_exportData(){
        	return $query=QB::query("SELECT * FROM 	arch_client_req_tbl ORDER BY id DESC")->get();
        }

   public function export_all_data($table){
   	// Fetch records from database 
$results = QB::query("SELECT * FROM {$table} ORDER BY id DESC")->get(); 
 
if(!empty($results)){ 
    $delimiter = ","; 
    $filename = "Export-data_" . date('Y-m-d') . ".csv"; 
     
    // Create a file pointer 
    $f = fopen('php://memory', 'w'); 
     
    // Set column headers 
    $fields = array('Name', 'Number', 'Info'); 
    fputcsv($f, $fields, $delimiter); 
     
    // Output each row of the data, format line as csv and write to file pointer 
     
       foreach($results as $row){ 
       	if(empty($row->name)){
       		$name=$row->name;
       	}else{
       			$name=$row->institute_name;
         }
        $lineData = array($name, $row->mobile, $row->institute_name); 
        fputcsv($f, $lineData, $delimiter);       	
   
    } 
     
    // Move back to beginning of file 
    fseek($f, 0); 
     
    // Set headers to download file rather than displayed 
    header('Content-Type: text/csv'); 
    header('Content-Disposition: attachment; filename="' . $filename . '";'); 
     
    //output all remaining data on a file pointer 
    fpassthru($f); 
} 
exit; 
 
   }


   // role start
   public function set_role($post=''){
		    	$data= array(
							  "role"=>$post['role'],							   
						    );
			    $insertId=QB::table('user_role')->insert($data);
			     $update="User Role has been Inserted";
				echo"<script> window.location.replace('user_role.php?msg=$update');</script>";
		}

	public function set_update($post=''){
				
				$data= array(
							  "role"=>$post['role'],							   
						    );
			    $id=$post['id'];
				QB::table('user_role')->where('id',$id)->update($data);
				//echo"<script> window.location.replace('user_role.php');</script>";
				 $update="User Role has been updated";

				echo"<script> window.location.replace('user_role.php?msg=$update');</script>";
				
		    }
		    
    public function get_role_one($id) {
    	$query = QB::table('user_role')->where('id',$id);
    	 return $result = $query->first();
    }  

     public function get_all_role() {
    	$query = QB::table('user_role')->select('*');
    	 return $result = $query->get();
    } 
  //role end

}

function escape($string){
	global $mysqli;
	$string = trim($string);
	return $mysqli->real_escape_string($string);  
}




