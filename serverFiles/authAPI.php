<?php
require_once "libs.php";
$salt = "5EF934A0CB92375B6DE2D5B5B9B93309";
$raw_data = $pdo->query("select * from userData");

if(isset($_POST['user']) and isset($_POST['pswd']) and isset($_POST['mail']))
{
signUp($_POST['user'],$_POST['pswd'],$_POST['mail'],$salt);
}

elseif(isset($_POST['user']) and isset($_POST['pswd']))
{
signIn($_POST['user'],$_POST['pswd'],$salt);
}

elseif(isset($_POST['authid']) and isset($_POST['giveInfo']))
{
while ($data = $raw_data->fetch(PDO::FETCH_ASSOC))
{
if(strtolower(md5($data['userId']."saltLAKE")) == strtolower($_POST['authid'])){echo json_encode($data);exit();}
}
echo "0";
}

elseif(isset($_POST['authid']))
{
while ($data = $raw_data->fetch(PDO::FETCH_ASSOC))
{
if(strtolower(md5($data['userId']."saltLAKE")) == strtolower($_POST['authid'])){echo "1";exit();}
}
echo "0";
}

elseif(isset($_POST['usrn']) and isset($_POST['npwd']) and isset($_POST['cpwd']))
{
chngPswd($salt);
}
elseif(isset($_POST['task']) and $_POST['task']=="dlt"){
deleteAcc($salt);
}

?>
