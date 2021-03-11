<?php
require_once "libs.php";
if(cookieValid()[0]){header('location: index.php');}
?>
<!DOCTYPE html>
<html>

<head>
<title>BackJack || Sign In</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<link rel="shortcut icon" type="image/png" href="images/favicon.png">
<link rel="stylesheet" href="css/style.css">
<link href='https://fonts.googleapis.com/css?family=Viga' rel='stylesheet'>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
<div class="topHead">
<span class="main">BackJack<img src="images/favicon.png"><span style="font-size:30px;">Sign In</span></span>
<div class="menu">
<span>&#xFE19;</span><br>
<div class="menuButs">
<button onclick="location.href = 'home.php'">Home</button>
<button onclick="location.href = 'signin.php'">SignIn</button>
<button onclick="location.href = 'signup.php'">SignUp</button>
</div>
</div>
</div>
<div class="sign">
<div>
<input type="text" placeholder="username" name="user" autocomplete='off' onkeypress="sendOnEnter(event,'pwd','inp')">
<input type="password" placeholder="password" name="pass" id="pwd"  onkeypress="sendOnEnter(event,'btn')"> <button id="passTog" onclick="passTog()"><img src="images/passhide.svg" id="passImg"></button>
<button type="submit" id="btn" onclick="sign('in');">SignIn</button>
</div>
</div>

<a class="gitlink" href="https://github.com/rpd-512">RPD Productions</a>
<?php include "loadBegin.php";?>
</body>
<script src="js/index.js"></script>
</html>
