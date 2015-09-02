import pymysql

def get_piechart_data(house_id):
	try:
		conn = pymysql.connect(host='your server ip', port=3306, user='your username', passwd='your password', db='your db name')
	except:
		print "Cannot connect to database"
		return
	cur = conn.cursor(pymysql.cursors.DictCursor)
	try:
		cur.execute("SELECT device_name,kilowatts FROM housedevices WHERE house_id ="+str(house_id));
	except:
		print "Cannot execute query"
		return
	try:
		result = cur.fetchall()
		res = [{"data":x["kilowatts"],"label":x["device_name"]} for x in result]
	except:
		print "Cannot fetch results"
		return
		
	cur.close()
	conn.close()
	return res
