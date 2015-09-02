from pandas import read_csv,date_range,Series
from dateutil.parser import parse
import statsmodels.api as sm
from datetime import timedelta
import json
import pickle
from isoweek import Week

		

def get_first_date(value):
	month = {"01":"2014-1-1","02":"2014-2-1","03":"2014-3-1","04":"2014-4-1","05":"2014-5-1","06":"2014-6-1","07":"2014-7-1","08":"2014-8-1","09":"2014-9-1","10":"2014-10-1","11":"2014-11-1","12":"2014-12-1"}
	return month[value.split("-")[-1]]
	
def decide_forecast_time(timeby,value):
		
	if timeby == "Daily":
		d = "2014"+value[4:]
		start = parse(d)
		starti = (parse(d)-parse('2014-1-1')).days * 24
	
		end = parse(d)+timedelta(days=1)
		endi = starti + 24
		
	elif timeby == "Weekly":
		d = Week(2011, 40).monday()
		s = d.strftime("%Y-%m-%d")
		d = "2014"+s[4:]
		start = parse(d)
		starti = (parse(d)-parse('2014-1-1')).days * 24
		end = parse(d)+timedelta(days=7)
		endi = starti + (7*24)
	else:
		d = get_first_date(value)
		start = parse(d)
		starti = (parse(d)-parse('2014-1-1')).days * 24
		end = parse(d)+timedelta(days=30)
		endi = starti + (30*24)
		
	if end.year == 2015:
		end = parse("2014-12-31")
		endi = starti + ((end-parse(d)).days *24)
	
	return start,end,starti,endi
	
def decide_time(timeby,value):
	
	if timeby == "Daily":
		d = "2014"+value[4:]
		start = parse(d)-timedelta(days=3)
		
	elif timeby == "Weekly":
		d = Week(2011, 40).monday()
		s = d.strftime("%Y-%m-%d")
		d = "2014"+s[4:]
		start = parse(d)-timedelta(days=21)
	else:
		d = get_first_date(value)
		start = parse(d)-timedelta(days=90)
	if start.year == 2013:
		start = parse("2014-1-1")
	return start
		
def timeseries_prediction(houseid,timeby,value):
	
	with open("resources/data/ts_"+houseid+".p","rb") as f:
		timeseries_data = pickle.load(f)
	
	with open("resources/data/arma_"+houseid+".p","rb") as f:
		arma_res = pickle.load(f)
	
	start,end,starti,endi = decide_forecast_time(timeby,value)
	forecast_dates = date_range(start=start, end=end,freq='H')
	pred = json.loads(arma_res.predict(exog=forecast_dates)[starti:endi].to_json())
	timestart = decide_time(timeby,value)
	t = json.loads(timeseries_data[timestart:start].to_json())
	
	tlist = map(lambda x: {"W":t[x],"epoch_time":int(x)}, t)
	tlist.extend(map(lambda x: {"predictedW":pred[x],"epoch_time":int(x)}, pred))
	return json.dumps(tlist)
	
