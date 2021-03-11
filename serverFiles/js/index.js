let flscrn = () => !! document.fullscreenElement;
function passTog(){
if(document.getElementsByName("pass")[0].type=="password"){
document.getElementsByName("pass")[0].type = "text";
document.getElementById("passImg").src="images/passshow.svg"
}
else{
document.getElementsByName("pass")[0].type = "password";
document.getElementById("passImg").src="images/passhide.svg"
}
}

function validMail(mail)
{
 if (/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/.test(mail))
  {
    return (true)
  }
    return (false)
}

function sign(tsk){
if(tsk=="in"){
$.post("authAPI.php", {"user":document.getElementsByName("user")[0].value,"pswd":document.getElementsByName("pass")[0].value}, function(data){
if(data != "0"){location.replace("index.php");}
else{alert("Missing/Wrong credentials")}
});
}

else if(tsk=="up"){
if(!validMail(document.getElementsByName('mail')[0].value)){alert("Missing/Invalid email");return;}
if(document.getElementsByName('user')[0].value.length<3){alert('Invalid username');return;}
if(document.getElementsByName('pass')[0].value != document.getElementsByName('pass')[1].value || document.getElementsByName('pass')[0].value.length < 8){alert('Invalid Password/Password Confirmation Mismatch');return;}
$.post("authAPI.php", {"user":document.getElementsByName("user")[0].value,"mail":document.getElementsByName("mail")[0].value,"pswd":document.getElementsByName("pass")[0].value}, function(data){
if(data=='m'){alert('Email is already in use');return;}
else if(data=='u'){alert('Username is already in use');return;}
else{alert('Successfully signed up!!');location.href = 'signin.php';}
});
}
}

function lgout()
{
if(confirm("Are you sure you wanna logout?"))
{
document.cookie = "userId=; expires=Thu, 01 Jan 1970 00:00:00 UTC;";
location.replace("index.php");
}
}

function gotConnected(is){
if(is == "y"){
document.getElementById('cnctText').innerHTML = "Connected";
cnct.style.fill="lime"
}
else{
document.getElementById('cnctText').innerHTML = "Not Connected";
cnct.style.fill="red"
}
}

function pressK(){
pressKey.style.width="calc(100% - 15px)";
closePK.style.display="inline";
keyHead.style.display="inline";
key.style.display="inline";
}

function closeK(){
pressKey.style.width="0";
closePK.style.display="none";
keyHead.style.display="none";
key.style.display="none";
}

function chngPmenuO(){
chngPswd.style.width="calc(100% - 15px)";
closePK.style.display="inline";
keyHead.style.display="inline";
cpw.style.display="inline";
}

function chngPmenuC(){
chngPswd.style.width="0";
closePK.style.display="none";
keyHead.style.display="none";
cpw.style.display="none";
}

function chngP(){
if(curp.value.length < 8){alert('Please enter the current password');return;}
else if(newp.value != conp.value){alert('password confirmation mismatch');return;}
else if(newp.value.length < 8){alert('New password is too small');return;}
$.post("authAPI.php", {"usrn":document.getElementsByClassName('usrn')[0].innerText,"cpwd":curp.value,"npwd":newp.value}, function(data){
if(data == "0"){alert('Incorrect password');return;}
else{chngPmenuC();alert('Password updated!!');return}
});
}

function passTogChng(){
if(newp.type == "password"){
newp.type = "text";
document.getElementById("passImg").src="images/passshow.svg"
}
else{
newp.type = "password";
document.getElementById("passImg").src="images/passhide.svg"
}
}

function dltAccO(){
dltAcnt.style.width="calc(100% - 15px)";
closeDlt.style.display="inline";
dltHead.style.display="inline";
dltElem.style.display="inline";
}
function dltAccC(){
dltAcnt.style.width="0";
closeDlt.style.display="none";
dltHead.style.display="none";
dltElem.style.display="none";
}

function deleteAccount(){
pswd=dltPass.value;
user=document.getElementsByClassName('usrn')[0].innerText;
$.post("authAPI.php", {"usrn":user,"pswd":pswd,"task":"dlt"}, function(data){
if(data == "0"){alert("incorrect password!!");return;}
else{alert("Account deleted successfully");location.replace("index.php");}
});
}

function scrlBtm() {
   var div = document.getElementById("sendNrecv");
   $('#sendNrecv').animate({
      scrollTop: div.scrollHeight - div.clientHeight
   }, 100);
}

function sendOnEnter(e,id,tsk='btn'){
if(e.key == "Enter"){
if(tsk=='btn'){document.getElementById(id).click();}
else if(tsk=='inp'){document.getElementById(id).focus();}
}
}

function sendCmnd()
{
var cmd = cmnds.value;
if(cmd.slice(0,4) == "img " || cmd.slice(0,4) == "lnk "){cmd = " "+cmd;}
$.post("dataAPI.php", {"cmnd":cmd,"from":'send'});
prntMsg(cmd,'send');
cmnds.value = "";
}

function readRepl()
{
$.post("dataAPI.php", {"getRepl":lstCmnd},function(data){
if(data.length > 0 && data.slice(0,2) == "||")
{
rMsg=data.slice(2).split("<@0AND0@>");
lstCmnd = rMsg[1];
prntMsg(rMsg[0],'recv');
}
});
}
function prntMsg(cmd,tsk){
if(cmd == ""){return;}
cmd = htmlEntities(cmd);
if(cmd.slice(0,4) == "img "){cmd=("<a href='uploaded_files/"+cmd.slice(4)+"' download><img src='uploaded_files/"+cmd.slice(4)+"' onerror=\"this.src='images/att.png';this.style.background='white'\"></a><br>").replaceAll("&lt;br&gt;","")}
else if(cmd.slice(0,4) == "lnk "){cmd=("<a target='_blank' href='"+cmd.slice(4)+"'>"+cmd.slice(4)+"</a>").replaceAll("&lt;br&gt;","")}

if(tsk=='recv'){cmd=cmd.replaceAll('&lt;br&gt;','<br>')}
sendNrecv.innerHTML += "<p class='"+tsk+"'>"+cmd+"</p>"
scrlBtm();
}

function getCookie(cname) {
  var name = cname + "=";
  var decodedCookie = decodeURIComponent(document.cookie);
  var ca = decodedCookie.split(';');
  for(var i = 0; i <ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}
function htmlEntities(str) {
    return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
}
function checkConn(){
$.post("dataAPI.php", {"isConn":''}, function(data){
if(data == "1"){gotConnected('y');return;}
gotConnected('n');
});
}

function opnUpldFl(){
upldFl.style.height="calc(100% - 15px)";
keyHead.style.display="inline";
mainUpld.style.display="inline";
closePK.style.display="inline";
}

function clsUpldFl(){
upldFl.style.height="0";
keyHead.style.display="none";
mainUpld.style.display="none";
closePK.style.display="none";
att.value=att.defaultValue
}
function clrCmnds(){
if(confirm("Are you sure to delete chat history?")){
$.post("dataAPI.php", {"clrCmnd":''}, function(data){
console.log(data);
})
alert("Deletion confirmed..");
location.href="index.php"
}
}

function sndFl(){
var fd = new FormData();
var files = $('#att')[0].files[0];
fd.append('file', files);
$.ajax({
url: 'upload.php',
type: 'post',
data: fd,
contentType: false,
processData: false,
success: function(response){
prntMsg("img "+response,'send');
},});
}
