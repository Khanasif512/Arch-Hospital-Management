<?php 
require_once("../main_function.php");
require_once("class/organization.php");
$org=new Organization;
$obj=new operation;

if (!empty($_POST['id'])) {
	 $id = $_POST['id'];
	
	 $data= $org->get_customer_contact($id);
	 echo json_encode($data);
}

if (!empty($_POST['del_id']) && !empty($_POST['filename'])) {
	$id = $_POST['del_id'];
	$filename = $_POST['filename'];
	return $org->delete_marketing_file($id, $filename);
}

?>