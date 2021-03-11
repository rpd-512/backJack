<?php
require_once "libs.php";
if(! cookieValid()[0]){header('Location: home.php');}
else{$userArr=cookieValid()[1];}
?>
<!DOCTYPE html>
<html>

<head>
<title>BackJack</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<link rel="shortcut icon" type="image/png" href="images/favicon.png">
<link rel="stylesheet" href="css/style.css">
<link href='https://fonts.googleapis.com/css?family=Viga' rel='stylesheet'>
<link href="https://fonts.googleapis.com/css2?family=Fira+Code&display=swap" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="js/index.js"></script>
</head>

<body>

<table class="profile"/>
<tr><td><table class="profData">
<tr><td>Username</td><td class="usrn"><?= $userArr['name']?></td></tr>
<tr><td>Email</td><td><?= $userArr['mail']?></td></tr>
</table></td></tr>
<tr><td><button onclick="clrCmnds();">Clear command history</button></td></tr>
<tr><td><button onclick="chngPmenuO();">Change Password</button></td></tr>
<tr><td><button onclick="dltAccO();" class="dlt">Delete account</button></td></tr>
</table>

<div id="chngPswd">
<span id="keyHead">Change password</span>
<button id="closePK" onclick="chngPmenuC()">&#x2715;</button>
<div id="cpw">
<input placeholder="Enter current password" id="curp" type="password">
<input placeholder="Enter new password" id="newp" type="password"> <button id="cpwdTog" onclick="passTogChng()"><img src="images/passhide.svg" id="passImg"></button>
<input placeholder="Confirm new password" id="conp" type="password">
<button onclick="chngP()">Change</button>
</div>
</div>

<div id="dltAcnt">
<span id="dltHead">Delete Account<br>We will miss you.. :-(</span>
<button id="closeDlt" onclick="dltAccC()">&#x2715;</button>
<div id="dltElem">
<input placeholder="Enter your password" id="dltPass" type="password">
<button onclick="deleteAccount()">Delete</button>
</div>
</div>

<div class="topHead">
<span class="main">BackJack<img src="images/favicon.png"><span class="wlcm"> Welcome <?=$userArr['name'] ?></span></span>
<div class="menu">
<span>&#xFE19;</span><br>
<div class="menuButs">
<button onclick="location.href = 'index.php'">Controller</button>
<button onclick="location.href = 'profile.php'">Profile</button>
<button onclick="location.href = 'help.php'">Help</button>
<button onclick="lgout()">Logout</button>
<button onclick="var win = window.open('https://www.buymeacoffee.com/rpd512', '_blank');win.focus();" id="supp">Support the dev</button>
</div>
</div>
</div>

<a class="gitlink" href="https://github.com/rpd-512">RPD Productions</a>
<?php include "loadBegin.php";?>
</body>
</html>
