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
.topHead .menu .menuButs button{background:rgba(150,150,150,0.5);}
</style>
</head>

<body>
<?php include "loadBegin.php";?>

<div id="upldFl">
<span id="keyHead">Upload File</span>
<button id="closePK" onclick="clsUpldFl()">&#x2715;</button>
<div id="mainUpld" style="display:none;">
<button onclick="document.getElementById('att').click()" id="slctFl">Select file &#128206;</button>
<div id="prvwSnd"><img src="images/att.png" id="upldPrvw"><button id="sndFl" onclick="sndFl();clsUpldFl()">Send for download</button></div>
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
<button onclick="if(flscrn()){supp[0].innerHTML='Enter<br>Fullscreen';document.exitFullscreen();} else{supp[0].innerHTML='Exit<br>Fullscreen';document.body.requestFullscreen();}" id="supp">Enter<br>Fullscreen</button>
<button onclick="var win = window.open('https://www.buymeacoffee.com/rpd512', '_blank');win.focus();" id="supp">Support the dev</button>
</div>
</div>
</div>

<div class="controller">
<span class="isConnected" title="is the device connected?"><span id="cnctText">Not Connected</span><svg width="50" height="50"><circle cx="30" cy="25" r="10" stroke="white" stroke-width="2" fill="red" id="cnct"/></svg></span>

<div id="sendNrecv">
<?php
$lstCmdId = 0;
$raw_data = $pdo->query("select * from commands where usrId=".$userArr['userId']);
while ($data = $raw_data->fetch(PDO::FETCH_ASSOC))
{
$cmd=htmlentities($data['cmnd']);
if(substr($cmd,0,4)=="img "){$cmd = str_replace("&lt;br&gt;","","<a href='uploaded_files/".substr($cmd,4)."' download><img src='uploaded_files/".substr($cmd,4)."' onerror=\"this.src='images/att.png';this.style.background='white'\"></a>");}
elseif(substr($cmd,0,4)=="lnk "){$cmd = str_replace("&lt;br&gt;","","<a target='_blank' href='".substr($cmd,4)."'>".substr($cmd,4)."</a>");}

if($data['from']=='send'){echo '<p class="send">'.$cmd.'</p>';}
elseif($data['from']=='recv'){echo '<p class="recv">'.str_replace('&lt;br&gt;',"<br>",$cmd).'</p>';}
$lstCmdId = $data['cmdId'];
}
?>
</div>

<input id="cmnds" placeholder="backjack@controller:$" onkeypress="sendOnEnter(event,'sndCmnd')">
<input type='file' id='att' style="display:none;">
<button onclick="opnUpldFl()">&#128206;</button>
<button id="sndCmnd" onclick="sendCmnd()">&gt;-</button>

</div>
<script>
var lstCmnd = <?= $lstCmdId ?>;
var imgExt = ['png','jpg','jpeg','bmp','svg','gif','tiff']
setInterval(function(){checkConn();},1500)
setInterval(function(){readRepl();},500)
setInterval(function(){
if(att.files[0] != undefined){
if(att.files[0].size/(1024*1024) > 50){alert('File too large, exceeding 50mb');clsUpldFl();}
prvwSnd.style.display="inline";
if(imgExt.includes(att.files[0].name.split('.').slice(-1)[0])){upldPrvw.src=window.URL.createObjectURL(att.files[0]);}
else{upldPrvw.src="images/att.png";}
}
else{prvwSnd.style.display="none";}
},500)

</script>
</body>
</html>
