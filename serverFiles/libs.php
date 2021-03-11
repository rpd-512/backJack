<?php
require_once 'pdoData.php';

function cookieValid(){
$pdo = $GLOBALS['pdo'];
if(isset($_COOKIE['userId']))
{
$raw_data = $pdo->query("select * from userData");
while ($data = $raw_data->fetch(PDO::FETCH_ASSOC))
{
if($_COOKIE['userId'] == md5($data['userId'].$data['pswd'].'saltLAKE')){return [true,$data];}
}
return [false];
}
return [false];
}

function signIn($u,$p,$salt){
$pdo = $GLOBALS['pdo'];
$raw_data = $pdo->query("select * from userData");
while ($data = $raw_data->fetch(PDO::FETCH_ASSOC))
{
if(strtolower($u) == strtolower($data['name']) and strtolower(md5($salt.$p)) == strtolower($data['pswd']))
{
echo $data['userId'];
setcookie("userId",md5($data['userId'].$data['pswd']."saltLAKE"),time()+60*60*24*60);
return $data['userId'];
exit();
}
}
echo "0";
}

function signUp($u,$p,$e,$salt){
$pdo = $GLOBALS['pdo'];
$raw_data = $pdo->query("select * from userData");
while ($data = $raw_data->fetch(PDO::FETCH_ASSOC))
{
if(strtolower($e) == strtolower($data['mail'])){echo 'm';exit();}
else if(strtolower($u) == strtolower($data['name'])){echo 'u';exit();}
}

$qry = "insert into userData (name,mail,pswd,lastAct) values(:user, :mail, :pswd,'')";
$raw_data = $pdo->prepare($qry);
$raw_data->execute(array(
':user' => htmlentities($u),
':mail' => htmlentities($e),
':pswd' => htmlentities(md5($salt.$p))
));
}

function chngPswd($salt){
$usrn = $_POST['usrn'];
$cpwd = $_POST['cpwd'];
$npwd = $_POST['npwd'];
$pdo = $GLOBALS['pdo'];
$auth = 0;
$raw_data = $pdo->query("select * from userData");
while ($data = $raw_data->fetch(PDO::FETCH_ASSOC))
{
if(strtolower($data['name']) == strtolower($usrn) and strtolower(md5($salt.$cpwd)) == strtolower($data['pswd']))
{
$auth=1;
}
}
if($auth == 0){echo "0"; exit();}
$id = signIn($usrn,$cpwd,$salt);
$qry = 'update userData SET pswd=:pwd where userId='.$id.';';
$raw_data = $pdo->prepare($qry);
$raw_data->execute(array(
':pwd' => htmlentities(md5($salt.$npwd))
));
signIn($usrn,$npwd,$salt);
}

function deleteAcc($salt){

$usrn = $_POST['usrn'];
$pswd = $_POST['pswd'];
$pdo = $GLOBALS['pdo'];
$auth = 0;
$raw_data = $pdo->query("select * from userData");
while ($data = $raw_data->fetch(PDO::FETCH_ASSOC))
{
if(strtolower($data['name']) == strtolower($usrn) and strtolower(md5($salt.$pswd)) == strtolower($data['pswd']))
{
$auth=1;
}
}
if($auth == 0){echo "0"; exit();}
$id = signIn($usrn,$pswd,$salt);
$qry = 'delete from userData where userId='.$id.';';
$raw_data = $pdo->prepare($qry);
$raw_data->execute(array());
}
?>
