#!C:/Python27/python.exe
print("Content-Type: text/html\n")
from json import loads as jl
from time import gmtime as gm
import datetime
print("<h3>list of all call Received today : </h3>" )
k="buffer/call-"+str(gm().tm_mday).zfill(2)+str(gm().tm_mon).zfill(2)+str(gm().tm_year)+".json"
with open(k) as f:
	data=jl(f.read())
for i in data[len(data):0:-1]:
	print("//**********************"+"<br/>")
	print("Number : "+i['number']+"<br/>")
	print("Time : "+str(datetime.datetime.fromtimestamp(i['times']))+"<br/>")