import pymysql
from pandas import read_csv
from makeevent import write_event_csv
from svm import predict_test


def csvload(houseid,filename):
	print "Filename:",filename
	eventfile = write_event_csv(houseid,filename)
	res = predict_test(houseid,filename,eventfile)
	print "res:",res
	if res:
		return "Upload Successful"
	else:
		return "Unsuccessful upload. Please Try again"
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	