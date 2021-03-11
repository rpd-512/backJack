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
<style>
.cmndName{font-size:25px;display:block;margin-bottom:5px;margin-top:15px;}
</style>
</head>

<body>
<?php include "loadBegin.php";?>
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


<div class="help">
<span class="header">Help</span>
<div class="detR">
<span>
<img src="images/helpsym.png" style="border:2px solid black;border-radius:5px;margin-left:-2px;">
BackJack is a website that help you to control your linux devices from all over the world. Now your device is just a command away from you..
</span>
</div>

<div class="detL">
<hr>
<span>
<img src="images/helpconn.png">
<img src="images/helpconf.png">
This show whether your device is connected to internet or not.
This receives the signals from the python based application running on your device..<br>
(You can download that from the menu above)
</span>
</div>

<div class="detR">
<hr>
<span>
<img src="images/helpcmnds.png">
This is where you control your device and send commands from this site to your device. Here you can also send files to be downloaded using the little &#128206; icon.
Use the input box to send commands that are valid for the terminal on your device with a few more commands that will be provided to you below.
The data you sent appears in the blue boxes and the replied data appears in red ones.
</span>
</div>
<div class="detL">
<hr>
<span>
<img src="images/helpprofile.png">
This is used to view your username and email address,
also to change your password or maybe delete your account.
</span>
</div>
</div>

<div class="help">
<span class="header">Valid commands</span>
<div class="detL"><span>Here is a list of commands you can send to your device<br>(except the commands that are already valid for the device terminal)</span></div>
<hr>
<span class="cmndName">scrsht</span><span class="cmndInfo">Takes a screenshot from the device.</span>
<span class="cmndName">webcam</span><span class="cmndInfo">Takes an image from the device's webcam.</span>
<span class="cmndName">ngrk f/ngrk s</span><span class="cmndInfo">Starts and ngrok server from the device,<br> &quot;ngrk f&quot; starts a file server and &quot;ngrk s&quot; starts serving the apache server.<br>NOTE: only works if ngrok is installed on the device</span>
<span class="cmndName">ngLink</span><span class="cmndInfo">Provides the running ngrok server's link if it is already running</span>
<span class="cmndName">ngStop</span><span class="cmndInfo">Stops the running ngrok server</span>
<span class="cmndName">vol</span><span class="cmndInfo">Alters the volume of the system to an integer 0 to 100 provided after the command<br>FOR EXAMPLE: &quot;vol 100&quot;, &quot;vol 50&quot;</span>
<span class="cmndName">ngStop</span><span class="cmndInfo">Opens google chrome if no site name is provided and opens the site if mentioned<br>FOR EXAMPLE: &quot;gglchrm&quot;, &quot;gglchrm https://github.com&quot;</span>
<span class="cmndName">ntfy</span><span class="cmndInfo">Sends a notification on the device. Use &quot;$AND$&quot; to differentiate between title and description<br>FOR EXAMPLE: &quot;ntfy TITLE HERE $AND$ DESCRIPTION HERE&quot;</span>
<span class="cmndName">bat</span><span class="cmndInfo">Show battery conditions if available.</span>
<span class="cmndName">typ</span><span class="cmndInfo">Type some text on your device form a distance<br>FOR EXAMPLE: &quot;typ YOUR TEXT HERE&quot;</span>
<span class="cmndName">prs</span><span class="cmndInfo">Press some key combinations on your device<br><br>Valid key names are:<br>
&quot;tab&quot; for tab<br>
&quot;alt&quot; for alter<br>
&quot;ctrl&quot; for control<br>
&quot;shft&quot; for shift key<br>
&quot;enter&quot; for enter key<br>
&quot;space&quot; for space bar<br>
&quot;bksp&quot; for backspace<br>
&quot;cmd&quot; for windows/super key<br>
&quot;up/down/right/left&quot; for arrow keys<br>
And alphabets and number are the same<br>
<br>
FOR EXAMPLE: &quot;prs cmd+l&quot;, &quot;prs ctrl+shft+t&quot;
</span>
<span class="cmndName">stopRecv</span><span class="cmndInfo">Completely stop the receiver until device is rebooted.</span>
</div>

<div style="margin:auto;width:200px;margin-bottom:50px;">
<script type="text/javascript" src="https://cdnjs.buymeacoffee.com/1.0.0/button.prod.min.js" data-name="bmc-button" data-slug="rpd512" data-color="#FFDD00" data-emoji="" data-font="Cookie" data-text="Buy me a coffee" data-outline-color="#000000" data-font-color="#000000" data-coffee-color="#ffffff" ></script>
</div>
<span style="visibility: hidden;">.</span>
<a class="gitlink" href="https://github.com/rpd-512">RPD Productions</a>
</body>
</html>
