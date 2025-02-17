<?php  
require 'vendor/autoload.php';
 // Start a Session
if (!session_id()) @session_start();	
// Instantiate the class
$msg = new \Plasticbrain\FlashMessages\FlashMessages();
$msg->info('This is an info message');
$msg->success('This is a success message');
$msg->warning('This is a warning message');
$msg->error('This is an error message');
 
// Display the messages
$msg->display();