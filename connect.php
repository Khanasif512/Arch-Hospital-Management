<?php
 session_start();
$PAGINATION_PERPAGE =25;
$localhost="localhost";
$db= "hmp_db";
$users="root";
$pass="";
defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);
defined('SITE_ROOT') ? null :
define('SITE_ROOT', DS.'wamp86'.DS.'www'.DS.'hmp');
defined('SITE_URL')   ? null : define("SITE_URL", "http://192.168.1.5/hmp/");
date_default_timezone_set("Asia/Dhaka");
$gtime=date("Y-m-d H:i:s");
$gdate = date("Y-m-d");

require 'Query_builder/vendor/autoload.php';
$config = array(
	            'driver'    => 'mysql', // Db driver
	            'host'      =>$localhost,
	            'database'  =>$db,
	            'username'  =>$users,
	            'password'  =>$pass,
	            'charset'   => 'utf8', // Optional
	            'collation' => '', // Optional
	            'prefix'    => '', // Table prefix, optional
                );
new \Pixie\Connection('mysql', $config, 'QB');

require 'hmpadmin/class/common_helper.php';
require 'hmpadmin/class/FlashMessages.php';

global $mysqli;
$mysqli = new mysqli($localhost,$users,$pass,$db);

if ($mysqli -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
}


if(isset($_SESSION['user_id']) && isset($_SESSION['email'])){
  $user_id=$_SESSION['user_id'];
  $query= QB::table('user_tbl')->where('user_id','=',$user_id);
  $usersInfo=$query->first();
  if(!empty($usersInfo)){
   $roleIDGlobal=$usersInfo->roleId;
   $permissionsGlobal = QB::table('user_role_permissions')->where('roleId','=',$roleIDGlobal)->first();  
  }

   if(!empty($permissionsGlobal->perms)){
  $perms=unserialize($permissionsGlobal->perms);
   }else{
    $perms=array();
   }
}


function pagination($query=null,$per_page=20,$page=1,$url='?',$totalRow=null) {   
    if(!empty($totalRow)){
   $total = $totalRow;
  }else{
     $query = "SELECT COUNT(*) as `num` FROM {$query}";
    $row = QB::query($query)->first();

    $total = $row->num;
  }

    $adjacents = "2"; // default was  2
     
    $firstlabel = "&lsaquo;&lsaquo; First";
    $prevlabel = "&lsaquo; Prev";
    $nextlabel = "Next &rsaquo;";
	  $lastlabel = "Last &rsaquo;&rsaquo;";
     
    $page = ($page == 0 ? 1 : $page);  
    $start = ((int)$page - 1) * (int)$per_page;                               
     
    $first = 1;
    $prev = (int)$page - 1;                          
    $next = (int)$page + 1;
     
    $lastpage = ceil($total/$per_page);
     
    $lpm1 = $lastpage - 1; // //last page minus 1
     
    $pagination = "";
    if($lastpage > 1){   
        $pagination .= "<nav aria-label='Page navigation example'> <ul class='pagination'>";
        $pagination .= "<li class='page_info'>&nbsp;Page {$page} of {$lastpage}</li>";
             
            if ($page > 1) { $pagination.= "<li><a href='{$url}pages={$first}'>{$firstlabel}</a></li>";
                           $pagination.= "<li><a href='{$url}pages={$prev}'>{$prevlabel}</a></li>"; }
             
        if ($lastpage < 3 + ($adjacents * 2)){   
            for ($counter = 1; $counter <= $lastpage; $counter++){
                if ($counter == $page)
                    $pagination.= "<li><a class='active'>{$counter}</a></li>";
                else
                    $pagination.= "<li><a href='{$url}pages={$counter}'>{$counter}</a></li>";                    
            }
         
        } elseif($lastpage > 3 + ($adjacents * 2)){
             
            if($page < 1 + ($adjacents * 2)) {
                 
                for ($counter = 1; $counter < 2 + ($adjacents * 2); $counter++){
                    if ($counter == $page)
                        $pagination.= "<li><a class='active'>{$counter}</a></li>";
                    else
                        $pagination.= "<li><a href='{$url}pages={$counter}'>{$counter}</a></li>";                    
                }
                $pagination.= "<li class='dot'></li>";
                $pagination.= "<li><a href='{$url}pages={$lpm1}'>{$lpm1}</a></li>";
                $pagination.= "<li><a href='{$url}pages={$lastpage}'>{$lastpage}</a></li>";  
                     
            } elseif($lastpage - ($adjacents*2) > $page && $page > ($adjacents * 2)) {
                 
                $pagination.= "<li><a href='{$url}pages=1'>1</a></li>";
                $pagination.= "<li><a href='{$url}pages=2'>2</a></li>";
                $pagination.= "<li class='dot'></li>";
                for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
                    if ($counter == $page)
                        $pagination.= "<li><a class='active'>{$counter}</a></li>";
                    else
                        $pagination.= "<li><a href='{$url}pages={$counter}'>{$counter}</a></li>";                    
                }
                $pagination.= "<li class='dot'></li>";
                $pagination.= "<li><a href='{$url}pages={$lpm1}'>{$lpm1}</a></li>";
                $pagination.= "<li><a href='{$url}pages={$lastpage}'>{$lastpage}</a></li>";      
                 
            } else {
                 
                $pagination.= "<li><a href='{$url}pages=1'>1</a></li>";
                $pagination.= "<li><a href='{$url}pages=2'>2</a></li>";
                $pagination.= "<li class='dot'></li>";
                for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
                    if ($counter == $page)
                        $pagination.= "<li><a class='active'>{$counter}</a></li>";
                    else
                        $pagination.= "<li><a href='{$url}pages={$counter}'>{$counter}</a></li>";                    
                }
            }
        }
		 // temp solution for not showing pagination
         if(!isset($counter)){
            $counter = $total;
         }
         
            if ($page < $counter - 1) {
            	$pagination.= "<li><a href='{$url}pages={$next}'>{$nextlabel}</a></li>";
				$pagination.= "<li><a href='{$url}pages=$lastpage'>{$lastlabel}</a></li>";
			}
         
        $pagination.= "</ul> </nav>";        
    }
     
    return $pagination;
}



function curPageURL() {
	$targetpage1 = basename($_SERVER['REQUEST_URI']); 	//your file name  (the name of this file)
	//$targetpage2 = explode("&page", $targetpage1);
	list($targetpage) = explode("&pages", $targetpage1);
	return $targetpage=$targetpage."&";
}


function company_email_list(){
     return $company_mail = array(
                               '1' =>"winsohel@gmail.com" ,
                               '2' =>"winsharif@gmail.com" ,
                               '2' =>"tanvir.mkt.esteem@gmail.com" ,
                               '3' =>"tutul@esteemsoftbd.com" ,
                               '4' =>"rifatrrahman@gmail.com" ,
                               '5' =>"write.mahmudul@gmail.com", 
                               '6' =>"mdmohiuddin.diu@gmail.com", 
                               '7' =>"mosharofn178@gmail.com", 
                               '8' =>"ibrahimbabu5@gmail.com", 
                               '9' =>"teams@esteemsoftbd.com" 
                             );
}

function return_company_email($id=""){
  switch ($id) {
    case 1: 
      return  "winsohel@gmail.com"; break;
    case 1: 
      return  "winsharif@gmail.com"; break;
    case 2: 
      return  "tanvir.mkt.esteem@gmail.com"; break;
    case 3: 
      return  "tutul@esteemsoftbd.com"; break;
    case 4: 
      return  "rifatrrahman@gmail.com"; break;
   case 5: 
      return  "write.mahmudul@gmail.com"; break;
  case 6: 
      return  "mdmohiuddin.diu@gmail.com"; break;
  case 7: 
      return  "mosharofn178@gmail.com"; break;
 case 8: 
      return  "ibrahimbabu5@gmail.com"; break;
 case 9: 
      return  "teams@esteemsoftbd.com"; break;
        default :
            return "";      
    }
}



//  function checkEmail($email) {
//          // $find1 = strpos($email, '@');
//          // $find2 = strpos($email, '.');
//          // return ($find1 !== false && $find2 !== false && $find2 > $find1);
//          // return (boolean) filter_var($email, FILTER_VALIDATE_EMAIL);
//      if (!preg_match("/^([a-zA-Z0-9\._-])+([a-zA-Z0-9\._-] )*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/" , $email)){
//           return false;
//      }
//      return true;
// }

?>