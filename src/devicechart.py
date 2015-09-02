import pymysql

def format_time(date,hour,min):
	l = date.split("/")
	return l[2]+"-"+l[1]+"-"+l[0]+" "+str(hour)+":"+str(min)

def get_device_data(house_id,date):
	date="/".join([str(int(x)).zfill(2) for x in date.split("-")])
	try:
		conn = pymysql.connect(host='your server ip', port=3306, user='your username', passwd='your password', db='your db name')
	except:
		print "Cannot connect to database"
		return
	cur = conn.cursor(pymysql.cursors.DictCursor)
	try:
		cur.execute("SELECT hour,min,kilowatts,devices_on FROM houselogs WHERE house_id ="+str(house_id)+" and date='"+date+"';");
	except:
		print "Cannot execute query"
		return
	try:
		result = cur.fetchall()
		res = [{"kilowatts":x["kilowatts"],"time":format_time(date,x["hour"],x["min"]),"devices_on":x["devices_on"].split(";")} for x in result]
	except:
		print "Cannot fetch results"
		return
		
	cur.close()
	conn.close()
	return res
