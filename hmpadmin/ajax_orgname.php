<?php 
require_once("../main_function.php");
 $obj=new operation;
if(!isset($_GET['searchTerm'])){ 
// // $fetchData = mysqli_query($con,"select * from users order by name limit 5");
// $fetchData=$this->user_model->get_reqsites();
// }else{ 
$search = $_GET['searchTerm'];   
$fetchData = $obj->get_orgname($search);
} 
$data = array();
$blank="->";
foreach($fetchData->result() as $row){    
$data[] = array("id"=>$row->id, "text"=>$row->institute_name);
}
echo json_encode($data);