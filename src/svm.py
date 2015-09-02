import pickle
from pandas import read_csv
import numpy
import pymysql

def predict_test(houseid,inputfile,eventfile):
	try:
		conn = pymysql.connect(host='your server ip', port=3306, user='your username', passwd='your password', db='your db name',autocommit=True)
	except:
		print "Cannot connect to database"
		return False
	startindex = 1
	try:
		data = read_csv(eventfile,index_col=False, header=0)
		X_test = data[["Timezone","Duration","DayType","AveragePower_minute"]]

		data = read_csv(inputfile,index_col=False, header=0)
		data = data[startindex:]
		with open("resources/data/Y"+str(houseid)+".p", "rb") as f:
			Y = pickle.load(f)

		expected = Y

		with open("resources/data/h"+str(houseid)+".p", "rb") as f:
			lin_clf = pickle.load(f)
			
		predicted = lin_clf.predict(X_test)
		next = 0
		pred = predicted[next]
		j = int(X_test["Duration"][next])
		for i in range(startindex,startindex+len(data)):
			
			if j==0 and (next+1)<len(predicted):
				next += 1
				pred = predicted[next]
				j = int(X_test["Duration"][next])
				
			else:
				j -= 1
			date = data[" Time"][i].strip().split(" ")[0]
			l = data[" Time"][i].strip().split(" ")[1].split(":")
			try:
				cur = conn.cursor(pymysql.cursors.DictCursor)
				cur.execute("INSERT INTO houselogs VALUES ("+str(houseid)+",'"+date+"',"+str(l[0])+","+str(l[1])+","+str(data[" kW_Raw_Data"][i])+",'"+str(pred)+"');");
			except:
				print "Cannot execute query"
				return False
	except:
		return False
	
	return True
		
