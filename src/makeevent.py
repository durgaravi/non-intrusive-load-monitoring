from pandas import read_csv
from glob import glob
import datetime
from dateutil.parser import parse

def getDayType(day):
	if day in ["Sat","Sun"]:
		return '0'
	else:
		return '1'
		
def getTimezone(hr):
	if hr >= 5 and hr < 9:
		return '1'
	elif hr >= 9 and hr < 13:
		return '2'
	elif hr >=13 and hr < 17:
		return '3'
	elif hr >= 17 and hr < 21:
		return '4'
	elif hr >=21 or hr == 0:
		return '5'
	elif hr >= 1 and hr < 5:
		return '6'


def write_event_csv(houseid,inputfile):
	try:
		device = str(houseid)
		startindex = 1
		data = read_csv(inputfile,index_col=False, header=0)
		timestamp = [parse(x) for x in data[" Time"][startindex:]]
		power = data[" kW_Raw_Data"][startindex:]
		outputfile = "h"+device+"_event.csv"
		f = open(outputfile,"w")
		f.write("Device,Timezone,Duration,DayType,AveragePower_minute\n")
		print "Writing..."
		oldpower = power[startindex]
		starttime = timestamp[0]
		#devices_on = set()
		totalsum = 0
		for i,t in enumerate(timestamp):
			p = power[i+startindex]
			totalsum += p
			if abs(oldpower-p) > 0.1:
				daytype = getDayType((t-datetime.timedelta(minutes=330)).strftime("%a"))
				timezone = getTimezone(int((t-datetime.timedelta(minutes=330)).strftime("%H")))
				duration = (t - starttime).seconds/60.0
				f.write(device+","+timezone+","+str(duration)+","+daytype+","+str(totalsum/duration)+"\n")
				starttime = t
				oldpower = p
				totalsum = 0
			
		f.close()
		print "Done!"
	except:
		return False
	return outputfile