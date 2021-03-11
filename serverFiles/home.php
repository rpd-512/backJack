<?php
require_once "libs.php";
if(cookieValid()[0]){header('location: index.php');}
?>
<!DOCTYPE html>
<html>

<head>
<title>BackJack</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="shortcut icon" type="image/png" href="images/favicon.png">
<link rel="stylesheet" href="css/style.css">
<link href='https://fonts.googleapis.com/css?family=Viga' rel='stylesheet'>
<style>
.brief{text-align:center;font-family:viga;margin-top:100px;font-size:25px;color:white;background:rgba(10,12,13,0.75);padding:5px;}
</style>
</head>

<body>
<?php include "loadBegin.php";?>
<div class="topHead">
<span class="main">BackJack<img src="images/favicon.png"></span>
<div class="menu">
<span>&#xFE19;</span><br>
<div class="menuButs">
<button onclick="location.href = 'home.php'">Home</button>
<button onclick="location.href = 'signin.php'">SignIn</button>
<button onclick="location.href = 'signup.php'">SignUp</button>
</div>
</div>
</div>

<div class="brief">
<p id="brief"></p>
</div>
<a class="gitlink" href="https://github.com/rpd-512">RPD Productions</a>
</body>
<script>
var i = 0;var txt1 = 'BackJack is an experimental web based application developed by<br>Rhiddhi Prasad Das<br>that can be used to control any device with a linux distro running from the internet.';var speed = 20;function typeWriter() {if (i < txt1.length) {try{if(txt1.charAt(i)+txt1.charAt(i+1)+txt1.charAt(i+2)+txt1.charAt(i+3) == "<br>"){document.getElementById("brief").innerHTML += "<br>";i+=4;}else{document.getElementById("brief").innerHTML += txt1.charAt(i);i++;}}catch{document.getElementById("brief").innerHTML += txt1.charAt(i);i++;}setTimeout(typeWriter, speed);}}setTimeout(typeWriter(), 1000);
</script>
</html>
