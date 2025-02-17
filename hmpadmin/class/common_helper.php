<?php 

function ID_encode($id,$salt=NULL){
    return base64_encode($id);
}

function ID_decode($encoded_id,$salt=NULL){
    return base64_decode($encoded_id);
}

/*website module function*/

 function create_slug($text){
   if(strlen($text) != mb_strlen($text, 'utf-8'))
    { 
     $text = preg_replace('/\s+/u', '-', trim($text));
    }
    else {
      $text= strtolower(preg_replace('/\s+/u', '-', trim($text)));
    }

 

  if (empty($text)) {
    return 'n-a';
  }

  return $text;
}

    function web_log_insert($reqType,$reqId,$type){
      $time=date("Y-m-d H:i:s");
        $data = array(
            'req_type' =>$reqType,
            'req_id' => $reqId,
            'type' => $type,
            'time' => $time,
            'userby' => $_SESSION['user_id'],

        );
        
        QB::table('log_web')->insert($data);
   } 


  function user_access_level(){                      
            $query = QB::table('user_role')->orderBy('id','ASC')->select('*');
            return $result = $query->get();
            }    
                                                     
  /**
 * Return user access name
**/     
  function return_access($access_group){  
      $query= QB::table('user_role')->where('id','=',$access_group)->first();
      if(!empty($query)){
        return $query->role;
        }
      }

function has_permission($permission,$redirect=NULL,$fail_url=NULL){
	global $flash;
	if (in_array($_SESSION['access_group'], $permission)) {
		if($redirect==NULL){
		  return true ;
		}else{
		  redirect_to("{$redirect}");
		}
	}else {
	   if($fail_url==NULL){
		  redirect_to("login.php");
		}else{
		 $flash->error("You Don't Have Permission To Access!!!",$fail_url);
		}
		
	}
}


function isAthorized($mypermission,$permissionElement){
if(!empty($mypermission)&& !empty($permissionElement)){
if(!array_intersect($mypermission,$permissionElement)){
    return false;
}else{
  return true;
}
}
}

 function convert_date($date="") {
  if (!empty($date)) {
    return date("Y-m-d",strtotime($date));
  } else {
    return  "";
  }  
}

function return_date($date="") {
  if (!empty($date)) {
    return date("d-m-Y",strtotime($date));
  } else {
    return  "";
  }  
}

// Abdul Halim
// start customer_designation function
function customer_designation(){
  $query = QB::table('customer_designation')->orderBy('name','ASC')->select('*');
  return $result = $query->get();
}
 ?>