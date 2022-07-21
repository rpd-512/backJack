import sqlite3
import hidepass
import hashlib
import json
from sys import exit
from os import system, popen, path, mkdir, rmdir, remove, listdir
from colorama import Fore, Back, Style
from time import sleep
from pyfiglet import figlet_format
from requests import post

siteName = "http://1nvict.000webhostapp.com/backjack/"

def whatIp():
    ip = popen("hostname -I | awk '{print $1}'").read()
    if(ip == "\n"):
        ip = ""
    return ip
def welcome():
    global ip, name
    system("clear")
    print(Fore.GREEN+figlet_format("BackJack",font="slant")+Fore.YELLOW+figlet_format("client manager",font="slant"))
    print(Fore.MAGENTA+"Device name            : "+Fore.YELLOW+popen("hostname").read(),end="")
    print(Fore.MAGENTA+"Running at ip address  : "+Fore.YELLOW+ip,end="")
    try:
        print(Fore.MAGENTA+"Username               : "+Fore.YELLOW+name)
    except:
        pass

def md5hash(txt):
    return (hashlib.md5(txt.encode())).hexdigest()
def authClient():
    global conn, homePath, name, mainUserId
    homePath = "/home/"+popen("whoami").read().replace("\n","")+"/.backJack"
    if(not path.exists(homePath+"/.main.db")):
        print(Fore.CYAN+figlet_format("BackJack Login"))
        print(Fore.YELLOW+"If you don't have an account, please make one here: ",end="")
        print(Fore.CYAN+siteName)
        print("Press ctrl+c to exit\n")
        while(True):
            try:
                user = input(Fore.CYAN+'Enter your backjack username : '+Fore.WHITE)
                pswd = hidepass.getpass(prompt=Fore.CYAN+"Enter your account password  : "+Fore.WHITE)
                try:
                    resp = post(siteName+"authAPI.php",{'user':user,'pswd':pswd})
                except:
                    print(Fore.RED+"Internet connection not found!!")
                    exit()
                auth=int(resp.text)
                if(not bool(auth)):
                    print(Fore.RED+"\nIncorrect/Invalid password or username.\n")
                    continue
                else:
                    print(Fore.GREEN+"Found your account :-) !!\n")
                    while(1):
                        pswd = hidepass.getpass(prompt=Fore.CYAN+"Enter a password for client manager : "+Fore.WHITE)
                        cpwd = hidepass.getpass(prompt=Fore.CYAN+"Confirm your password  : "+Fore.WHITE)
                        if(pswd == cpwd and len(pswd) >= 8):
                            welcome()
                            break
                        elif(len(pswd)<8):
                            print(Fore.RED+"Use a stronger password (longer than 8 digits)")
                        else:
                            print(Fore.RED+"Password confirmation mismatch!!")
                    try:
                        mkdir(homePath)
                    except:
                        pass
                    conn = sqlite3.connect(homePath+"/.main.db")
                    conn.execute("""CREATE TABLE userData(
                        id text,
                        pw text,
                        rv integer
                    )""")
                    conn.execute("""CREATE TABLE cmndData(
                        id integer PRIMARY KEY AUTOINCREMENT NOT NULL,
                        cmnd text,
                        date text,
                        time text
                    )""")
                    conn.execute("insert into userData (id,pw,rv) values('"+md5hash(str(auth)+"saltLAKE")+"','"+md5hash(str(pswd)+"saltLAKE")+"',1)")
                    conn.commit()
                    print(Fore.GREEN+"Successfully logged in!!\n")
                    break
            except KeyboardInterrupt:
                print()
                exit()
    else:
        conn = sqlite3.connect(homePath+"/.main.db")
        data = conn.execute("SELECT * FROM userData")
        for i in data:
            appData = i

        resp = post(siteName+"authAPI.php",{'authid':appData[0]})
        r = int(resp.text)
        if(not r):
            for i in listdir(homePath):
                remove(homePath+'/'+i)
            rmdir(homePath)
            exit()
        resp = post(siteName+"authAPI.php",{'authid':i[0],'giveInfo':''})
        userData = json.loads(str(resp.text))
        name = userData['name']
        while(True):
            pswd = hidepass.getpass(prompt=Fore.GREEN+"Enter client manager password: "+Fore.WHITE)
            if(md5hash(pswd+"saltLAKE") == i[1]):
                welcome()
                break
            else:
                print(Fore.RED+"Wrong Password!!")
def toggle():
    global conn
    cond = 0
    d = conn.execute("select rv from userData")
    for i in d:
        if(i[0] == 0):
            cond = 1
    if(cond == 0):
        print(Fore.WHITE+"Controller connection: "+Fore.RED+"off")
    else:
        print(Fore.WHITE+"Controller connection: "+Fore.GREEN+"on")
    conn.execute("update userData set rv = '"+str(cond)+"'")
    conn.commit()
def reset():
    global homePath
    try:
        print(Fore.GREEN+"\nAre you sure you wanna logout from this device?? (Press ctrl+c to cancel)")
        pwd = hidepass.getpass(prompt=Fore.YELLOW+"Enter your client manager password: "+Fore.WHITE)
        data = conn.execute("SELECT pw from userData")
        for d in data:
            if(d[0] == md5hash(pwd+"saltLAKE")):
                remove(homePath+"/.main.db")
                print(Fore.GREEN+"Successfully logged out!!")
                exit()
            else:
                print(Fore.RED+"Wrong Password!!")
                return
    except KeyboardInterrupt:
        print()
        return()
def cpwd():
    try:
        pwd = hidepass.getpass(prompt=Fore.YELLOW+"Enter your current client manager password: "+Fore.WHITE)
        data = conn.execute("SELECT pw from userData")
        for d in data:
            if(d[0] == md5hash(pwd+"saltLAKE")):
                pass
            else:
                print(Fore.RED+"Wrong Password!!")
                return
        while(True):
            pswd = hidepass.getpass(prompt=Fore.YELLOW+"Enter your new client manager password  : "+Fore.WHITE)
            cpwd = hidepass.getpass(prompt=Fore.YELLOW+"Confirm your new client manager password: "+Fore.WHITE)
            if(pswd == cpwd):
                break
            else:
                print(Fore.RED+"Password confirmation mismatch!!")
                continue
        conn.execute("update userData set pw = '"+md5hash(pswd+"saltLAKE")+"'")
        conn.commit()
        print(Fore.GREEN+"Password updated successfully")
    except KeyboardInterrupt:
        print()
        return
def his():
    hist = conn.execute("SELECT * FROM cmndData")
    empt = 1
    for h in hist:
        empt = 0
        print(h[2],"|",h[3],"|",h[1])
    if(empt):
        print(Fore.GREEN+"No commands ran by the controller yet..")
def runCmnd(c):
    c = c.lower().strip(" ")
    if(c=="help"):
        print(help)
    elif(c=="abt"):
        print(about)
    elif(c=="cls"):
        system("clear")
    elif(c=="ip"):
        print(ip,end="")
    elif(c=="tog"):
        toggle()
    elif(c=="cpwd"):
        cpwd()
    elif(c=="his"):
        his()
    elif(c==""):
        pass
    elif(c=="rst"):
        reset()
    elif(c=="exit"):
        print("Bye!!")
        exit()
    else:
        print(Fore.RED+"Invalid command!!")

def clientSide():
    cmnd = input(Fore.CYAN+"backjack@client"+Fore.WHITE+":$ ")
    runCmnd(cmnd)

ip = whatIp()
if(ip == ""):
    print(Fore.RED+"Internet connection not found!!")
    exit()
help = Fore.GREEN+"\n|Help|\n"+Fore.WHITE+"""
    -> exit  : exit the program
    -> help  : display help
    -> cpwd  : change password
    -> abt   : display about
    -> cls   : clear screen
    -> tog   : toggle controller connection
    -> his   : shows history of all the commands ran by the controller on this device
    -> ip    : return the ip address
    -> rst   : resets or simply logs you out
"""
about=Fore.GREEN+"\n|About|\n"+Fore.WHITE+"""
    This project was created by """+Fore.YELLOW+"Rhiddhi Prasad Das"+Fore.WHITE+""".
    We can use it to control any of our linux based systems from all over the world if it has an internet connection. Enjoy!!

        Github : https://github.com/rpd-512/
        Twitter: https://twitter.com/RhiddhiD
        Fiverr : https://www.fiverr.com/rpd_512
        Email  : rhiddhiprasad@gmail.com
"""
welcome()
authClient()

while True:
    try:
        ip = whatIp()
        clientSide()
    except KeyboardInterrupt:
        print("\nBye!!")
        exit()
