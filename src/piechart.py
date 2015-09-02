import pymysql

def get_piechart_data(house_id):
	try:
		conn = pymysql.connect(host='localhost', port=3306, user='root', passwd='', db='nilmtemp')
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