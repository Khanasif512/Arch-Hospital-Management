<?php 
/*include '../connect.php';*/
/**
 * 
 */

class Organization{ 
     public function todayPendingFollowup($today){       
        return $result = QB::query("SELECT * FROM arch_client_req_tbl WHERE next_followup_date = '{$today}' ORDER BY id DESC LIMIT 30 ")->get();
    }

    public function todayPendingFollowup_count($today){       
        return $result = QB::query("SELECT COUNT(id) as num FROM arch_client_req_tbl WHERE next_followup_date = '{$today}'  ")->first();
    } 
        public function todayContactFollowup($today){       
        return $result = QB::query("SELECT * FROM arch_client_req_tbl WHERE last_followup_date = '{$today}' ORDER BY id DESC LIMIT 30 ")->get();
    }

    public function todayContactFollowup_count($today){       
        return $result = QB::query("SELECT COUNT(id) as num FROM arch_client_req_tbl WHERE last_followup_date = '{$today}'  ")->first();
    }

     public function countOrgComment($today){  
       return $result = QB::query("SELECT COUNT(id) as totalComnt, COUNT(DISTINCT(arch_req_id)) as uniqueID  FROM arch_comments WHERE Date(rem_date) = '{$today}' ")->first();

   }


   public function set_sms_template($post=''){
              $data=array("name"=>$post["name"],
                          "type"=>$post["type"],                          
                          "message"=>$post["message"] 
                           );

              if(empty($post['id'])){
              QB::table('sms_template')->insert($data);
               $msg="Request has been added";               
             echo"<script> window.location.replace('sms-template.php?msg=$msg');</script>";
              }else{
                if(!empty($post['id'])){
                    $id=$post['id'];
                     QB::table('sms_template')->where('id',$id)->update($data);
                     $msg="Request has been updated";
                    echo"<script> window.location.replace('sms-template-add.php?id=$id&msg=$msg');</script>";
                }
              }

   }


   public function get_single_sms_temp($id){
            $query = QB::table('sms_template')->where('id','=',$id);
    return $result = $query->first();
    }

    public function delete_sms_template($id){
             QB::table('sms_template')->where('id',$id)->delete();
                 $msg="Request has been deleted";  
             echo"<script> window.location.replace('sms-template.php?msg=$msg');</script>";
          }

      public function get_all_sms_temp(){
         $query = QB::table('sms_template')->select('*');
            return $result = $query->get();

   }


    public function get_all_temp_type_wise($type){
         $query = QB::table('sms_template')->where('type','=',$type);
            return $result = $query->get();

   }

    public function arch_todays_deliveredSms($today){       
        return $result = QB::query("SELECT COUNT(t1.id) as num, SUM(t1.qty) AS totalQty, COUNT(DISTINCT t1.uhid) AS totalOrg FROM sms_history t1 
                         INNER JOIN arch_client_req_tbl t2 ON t2.id=t1.uhid AND t1.type=2 WHERE DATE(t1.date) = '{$today}'")->first();
    } 

  

public function arch_todays_sentEmail($today){       
        return $result = QB::query("SELECT COUNT(camp_email_set_request.id) as num, COUNT(DISTINCT camp_email_set_request.req_id) as uniqueRequest FROM camp_email_set_request  
                        INNER JOIN camp_email_set ON camp_email_set_request.set_id=camp_email_set.id
                        INNER JOIN camp_email_template ON camp_email_template.id=camp_email_set.temp_id
                        INNER JOIN arch_client_req_tbl ON arch_client_req_tbl.id=camp_email_set_request.req_id WHERE DATE(camp_email_set.time) = '{$today}' ")->first();
    } 

    

    public function set_directory_arch_request_from_admin($post){        

       if(!empty($post['thana_id'])){
        $thana=$post['thana_id'];
       }else{
        $thana=null;
       }

       if(!empty($post['slug_url'])){
       $slug= create_slug($post['slug_url']);
        $query = QB::table('arch_client_req_tbl')->where('slug_url','=',$slug);
         $ck_slug = $query->first();
         if(!empty($ck_slug)){
           $rand=rand(10,100);
           $slug= $ck_slug->slug_url.'_'.$rand;
         }

       }else{
         $slug= create_slug($post['institute_name']);
         $query = QB::table('arch_client_req_tbl')->where('slug_url','=',$slug);
         $ck_slug = $query->first();
         if(!empty($ck_slug)){
           $rand=rand(10,100);
           $slug= $ck_slug->slug_url.'_'.$rand;
         }
       }

      global $gtime;
      $user_id=$_SESSION['user_id'];
     $headerImage=!empty($post['header_image']) ? $post['header_image']: NULL;
     $galleryImage=!empty($post['gallery']) ? $post['gallery']: NULL;

     if(empty($post['req_type'])){
      $req_type='camp';
     }else{
       $req_type=$post['req_type'];
     }
        $data= array(
                        "name"=>$post['name'],
                        "mobile"=>$post['mobile'],
                        "email"=>$post['email'],
                        "institute_name"=>$post['institute_name'],
                        "institute_type"=>$post['institute_type'],
                        "org_address"=>$post['institute_add'],
                        "bed_qty"=>$post['student_qty'],
                        "req_type"=>$req_type,
                        "status"=>6,
                        "remarks"=>$post['remarks'],
                        "district"=>$post['district_id'],
                        "desig"=>$post['desig'],
                        "thana"=>$thana,
                        "req_date"=>$gtime,
                        "req_by"=>$user_id,
                        'header_image'=>$headerImage,
                        'gallery'=>$galleryImage,
                        'contact_number'=>$post['contact_number'],
                        'intro_text'=>$post['intro_text'],
                        'web_link'=>$post['web_link'],
                        'fb_link'=>$post['fb_link'],
                        'bname'=>$post['bname'],
                        'slug_url'=>$slug,
                        'approved_status'=>$post['approved_status'] 
                             
                    );

       $insertId=QB::table('arch_client_req_tbl')->insert($data);
       $insert="Request has been Added";
      if($post['approved_status']=='2'){
       web_log_insert(2,$insertId,1);
       }else{
       web_log_insert(2,$insertId,2);
     }
       $insertId=ID_encode($insertId);
       echo"<script> window.location.replace('directory-org-request-view.php?id=$insertId&msg=$insert');</script>";
    } 


public function update_directory_arch_req($post){
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

       if($post['slug_url']!=$post['pre_slug']){
         $slug_url= create_slug($post['slug_url']);
         $query = QB::table('arch_client_req_tbl')->where('slug_url','=',$slug_url);
         $ck_slug = $query->first();
         if(!empty($ck_slug)){
           $rand=rand(10,100);
           $slug_url= $ck_slug->slug_url.'_'.$rand;
         }
       }else{
        $slug_url=$post['pre_slug'];
       }

       global $gtime;

       if (empty($post['student_qty'])) {

        $post['student_qty']=1;
       }

       $headerImage=!empty($post['header_image']) ? $post['header_image']: NULL;
       $galleryImage=!empty($post['gallery']) ? $post['gallery']: NULL;
        $data= array(
                      "name"=>$post['name'],
                      "institute_name"=>$post['institute_name'],
                      "institute_type"=>$post['institute_type'],
                      "org_address"=>$post['institute_add'],
                      "bed_qty"=>$post['student_qty'],                   
                      "contact_number"=>$post['contact_number'],
                      "district"=>$post['district_id'],
                      "desig"=>$post['desig'],
                      "thana"=>$thana,
                      "update_date"=>$gtime,
                      "update_by"=>$post['update_by'],
                      "bname" =>$post['bname'],
                      "slug_url" =>$slug_url,
                      "web_link" =>$post['web_link'],
                      "fb_link" =>$post['fb_link'],
                      "approved_status" =>$post['approved_status'],
                      "header_image" =>$headerImage,
                      "gallery"=>$galleryImage
                     
                    );


        $id=$post['id'];
        QB::table('arch_client_req_tbl')->where('id',$id)->update($data);
        $query = QB::table('log_web')->where('req_id','=',$id)->where('req_type','=','2')->where('type','=','1');
        $ck_log = $query->first();

        if(empty($ck_log) && $post['approved_status']=='2'){
        web_log_insert(2,$id,1);
        }else{
        web_log_insert(2,$id,2);
        }
        $id=ID_encode($id);
         $update="2";

        echo"<script> window.location.replace('directory-org-request-view.php?id=$id&msg=$update');</script>";
    }


    public function save_user_role_permissions($post='')
    {
     $roleId= $post['roleId'];
     $permissionsId= $post['permissionsId'];
       $data= array(
                    "roleId"=>$roleId,
                    "perms"=>serialize($post['perms'])
                      );

       if(empty($permissionsId)){

         $query = QB::table('user_role_permissions')->where('roleId','=',$roleId);
         $ck_role = $query->first();
         
         if(empty($ck_role)){

       $insertId=QB::table('user_role_permissions')->insert($data);
       $_SESSION['msg']="Permissions Save successfully";   
       $insertId=ID_encode($insertId);
      
      }else{
        $_SESSION['msg']="Permissions Already Exist";   
        $insertId=ID_encode($ck_role->id);
       }

    }else{

        QB::table('user_role_permissions')->where('id',$permissionsId)->update($data);
        $_SESSION['msg']="Permissions Save successfully";   
        $insertId=ID_encode($permissionsId);

       }

       echo"<script> window.location.replace('user-permissions-add.php?permissionId=$insertId');</script>";
      
    }

    public function get_allPermissions($value='')
    {
       return $result = QB::query("SELECT * FROM user_role_permissions  ORDER BY roleId ASC")->get();
    }


 
//28/11/2021

    public function special_org($post=''){

        $data= array(
                    "reqID" =>$post['inputId'],
                    "type"=>'2',
                    "top_org"=>$post['top_org'],
                    "featured_org"=>$post['featured_org'],
                    "status"=>'1',
                     );

       $insertId=QB::table('special_org')->insert($data);

    } 

    public function return_featured_list($id){
      switch ($id) {
    case 0: 
          return  "No"; break;
    case 1: 
          return  "Yes"; break;

        default :
            return "";      
    }
} 

public function featured_type_list($id){
          switch ($id) {
    case 0:
          return "Canceled"; break;     
    case 1: 
          return  "Approved"; break;            
        default :
            return "";  
    }
}

    public function get_featured($id){                  
            
        $query= QB::query("SELECT t1.*,t2.org_address, t2.name as contactName, t2.institute_name, t3.name as districtName FROM special_org t1 LEFT JOIN arch_client_req_tbl t2 ON t1.reqID=t2.id LEFT JOIN district t3 ON t2.district = t3.id WHERE t1.id='$id'");    
            return $result = $query->first();
    }


    public function featured_update($post='')
    {
        
        $data= array(
                      "top_org"=>$post['top_org'],
                      "featured_org"=>$post['featured_org'],
                      "status"=>$post['status']                            
                    );
        
       $feturedId = $post['feturedId'];
  QB::table('special_org')->where('id',$feturedId)->update($data);
        
    }

public function delete_featured($id){
        QB::table('special_org')->where('id',$id)->delete();
        // $delete = "Featured Deleted Succesfully";
        // echo"<script> window.location.replace('featured.php?msg=$delete');</script>";
}  

 public function get_user_wise_arch_status($user_id=null,$status=null,$from_date=null,$to_date=null,$product=NULL){
    // date_default_timezone_set("Asia/Dhaka");
        if(!empty($to_date) && !empty($from_date)){        
      $statement="AND update_date BETWEEN '{$from_date}' AND '{$to_date}'";
      }else{
        $statement="";
      }  
    if($product=='arch'){
     $tbl=  "arch_client_req_tbl";
    }else{
      $tbl=  "witty_client_req_tbl";  
    }
     
        return $query= QB::query("SELECT COUNT(id) as num FROM `{$tbl}` WHERE assign_to='{$user_id}' AND status ='{$status}' {$statement} ")->first();
    }


 public function get_user_wise_comments_summary($user_id=null,$status=null,$from_date=null,$to_date=null,$product=NULL){
    // date_default_timezone_set("Asia/Dhaka");
        if(!empty($to_date) && !empty($from_date)){        
              $statement="AND Date(arch_comments.rem_date) BETWEEN '{$from_date}' AND '{$to_date}'";
              }else{
              $statement="";
          }  
        if($product=='arch'){
         $tbl= " arch_comments  LEFT JOIN arch_client_req_tbl  ON arch_comments.arch_req_id=arch_client_req_tbl.id";
        }else{
          $tbl= " witty_comments t1 LEFT JOIN witty_client_req_tbl t2 ON t1.witty_req_id=t2.id";  
        }
  
        return $query= QB::query("SELECT COUNT(arch_comments.id) as num FROM {$tbl} WHERE arch_comments.user_id='{$user_id}' AND arch_client_req_tbl.status ='{$status}' {$statement} ")->first();
    }

    
    // Abdul Halim
    //Start designations
    public function set_designation($post){
         $data=array("name"=>$post['name']);
         QB::table('customer_designation')->insert($data);
         $msg="Designation has been Added";
         echo"<script> window.location.replace('designation.php?&msg=$msg');</script>";

    }

   public function get_all_designation(){

         $query = QB::table('customer_designation')->select('*')->orderBy('name','ASC');
            return $result = $query->get();

   }

   public function get_designation($id){
       $query = QB::table('customer_designation')->where('id','=',$id);
     return $result = $query->first();
    }

    public function update_designation($post){
            $id=$post['status_id'];
            $data=array("name"=>$post['name']);
             QB::table('customer_designation')->where('id',$id)->update($data);
            $msg="Designation has been updated";
            echo"<script> window.location.replace('designation.php?id=$id?&msg=$msg');</script>";
       }

   public function delete_designation($id){
          QB::table('customer_designation')->where('id',$id)->delete();
            echo"<script> window.location.replace('designation.php');</script>";
        }
   // end designation
        
  //  customer contact
  public function addCustomerContact($post, $type){

            $id = $post['profileID'];
            $hidden_contact_id = $post['hidden_contact_id'];
            $name = $post['name'];
            $designation = $post['designation'];
            
            $pcell = $post['contact'];
            $pmail = $post['mail'];
            $note = $post['note'];
            $old_image = $_POST['old_image'] ?? NULL;
            $old_marketing_file = $_POST['old_marketing_file'] ?? NULL;
            
            // if(!empty($old_image)){
   //          $profile_image =$old_image;
   //       }

            $profile_image = !empty($post['file']) ? $post['file']: NULL;

            if (empty($profile_image)) {
                    $profile_image = $old_image;
            }


            
     $marketing_file = !empty($post['marketting_file']) ? $post['marketting_file']: NULL;
     if (!empty($hidden_contact_id)) {
            $get_data = QB::query("SELECT note, marketing_file FROM `customer_contact` WHERE id='$hidden_contact_id'")->first();
            if (!empty($get_data->marketing_file)) {
                $marketing_file = "{$get_data->marketing_file},{$marketing_file}";
            }

            if (empty($note)) {
                $note = $get_data->note;
            }
     }

     if(empty($marketing_file)){
            $marketing_file = $old_marketing_file;
     }
     
     

        $data = array(
            "customerID" => $id,
            "name" => $name,
            "designationID" => $designation,
        
            "pcell" => $pcell,
            "pmail" => $pmail,
            "note" => $note,
            "profile_img" => $profile_image,
            "marketing_file" => $marketing_file,
            "type" => $type, // type 1 = witty, 2 = arch
            "status" => 1,
        );

         if(!empty($hidden_contact_id)){
            QB::table('customer_contact')->where('id',$hidden_contact_id)->update($data);

            }else{

                QB::table('customer_contact')->insert($data);
            }

        $msg=1;
        $reqID=ID_encode($id);
        if ($type == 1) {   // type 1 = witty, 2 = arch
            echo"<script> window.location.replace('witty-demo-view.php?id=$id&msg=$msg');</script>";
        }elseif ($type == 2) {
           echo"<script> window.location.replace('arch-demo-view.php?id=$id&msg=$msg');</script>";
        }
        
    }
  

      public function CustomerContactList($id,$type){
        
        return QB::query("SELECT t1.*, t2.name as designation_name FROM `customer_contact` t1 LEFT JOIN customer_designation t2 on t1.designationID = t2.id WHERE t1.customerID = '$id' AND t1.type='$type' ORDER BY t1.id DESC LIMIT 5")->get();
      }

      public function TotalCustomer($id, $type){
        return QB::query("SELECT COUNT(t1.id) as num FROM customer_contact t1 WHERE t1.customerID = '$id' AND t1.type='$type'")->first();
      }

      public function get_customer_contact($id){
        return QB::query("SELECT t1.*, t2.name as designation_name FROM `customer_contact` t1 LEFT JOIN customer_designation t2 on t1.designationID = t2.id WHERE t1.id = '$id'")->first();
      }

      // delete marketing file

      public function delete_marketing_file($id, $filename){
       
        $get_data = QB::query("SELECT marketing_file FROM customer_contact  WHERE id = '$id'")->first();
        $marketing_file = $get_data->marketing_file;
        $remove_file = str_replace($filename,"",$marketing_file);

        $data = [
            "marketing_file" => $remove_file
        ];
        return QB::table('customer_contact')->where('id',$id)->update($data);

      }

      public function get_mails($id,$type){

            $get_data =  QB::query("SELECT pmail FROM `customer_contact`   WHERE customerID = '$id' AND type='$type'")->get();
            $mails_arr  = [];
            foreach ($get_data as  $mails) {
                $exp = explode(',', $mails->pmail);
                foreach ($exp as  $value) {
                     
                     $mails_arr[] = $value;
                }
                 
            }
            return $mails_arr;
      } 


      public function web_client_info($id){
         return QB::query("SELECT * FROM `clients`  WHERE id = '$id'")->first();
      }

}

//Role-based access control class
class Rbac{ 

//user permissions insert and update
 public function save_user_role_permissions($post='')
    
    {
     $roleId= $post['roleId'];
     $permissionsId= $post['permissionsId'];
       $data= array(
                    "roleId"=>$roleId,
                    "perms"=>serialize($post['perms'])
                      );

       if(empty($permissionsId)){

         $query = QB::table('user_role_permissions')->where('roleId','=',$roleId);
         $ck_role = $query->first();
         
         if(empty($ck_role)){

       $insertId=QB::table('user_role_permissions')->insert($data);
       $_SESSION['msg']="Permissions Save successfully";   
       $insertId=ID_encode($insertId);
      
      }else{
        $_SESSION['msg']="Permissions Already Exist";   
        $insertId=ID_encode($ck_role->id);
       }

    }else{

        QB::table('user_role_permissions')->where('id',$permissionsId)->update($data);
        $_SESSION['msg']="Permissions Save successfully";   
        $insertId=ID_encode($permissionsId);

       }

       echo"<script> window.location.replace('user-permissions-add.php?permissionId=$insertId');</script>";
      
    }


     public function get_allPermissions($value=''){

       return $result = QB::query("SELECT * FROM user_role_permissions  ORDER BY roleId ASC")->get();
    }

}


