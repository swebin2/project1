<?php
require_once "includes/includepath.php";
require_once "phpmailer/class.phpmailer.php";
require_once "chk_login.php";

$objval	=   new validate();
$objgen		=	new general();

//print_r($_POST);

//exit;

/*$values = "";
foreach($_POST as $key=>$val)
{
  $values .= $key." => ".$val;
}


// the message
$msg =  $values;

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: <info@trickyscore.com>' . "\r\n";

// send email
mail("sumeshtg@gmail.com","Test Webhook",$msg,$headers);
*/

$payment_id         = $_POST['payment_id'];
$payment_request_id = $_POST['payment_request_id'];
$status				= $_POST['status'];
$order_id		    = $_POST['purpose'];
$amount				= $_POST['amount'];

if($status=="Credit")
{
  $msg = $objgen->upd_Row('payments',"pay_status='Completed',payment_id='$payment_id',amount='$amount'","payment_request_id='".$payment_request_id."' and order_id='".$order_id."'");
  
  $msg = $objgen->upd_Row('exam_permission',"status='active'","order_id='".$order_id."'");
  
}
else
{
  $msg = $objgen->upd_Row('payments',"pay_status='Failed'","order_id='".$order_id."'");
}

//print_r($_POST);
?>