from bottle import route, run, debug, template, request, static_file, error, response
from timeseries import timeseries_prediction
from piechart import get_piechart_data
from devicechart import get_device_data
from dbupdate import csvload
from json import dumps

@route('/login')
def login():
	return static_file('login.html', root='./resources/public/')

@route('/update/<houseid>/<filename>')
def call_update(houseid,filename):
	res = csvload(houseid,"/home/user"+filename)
	return res

@route('/timeseries/<houseid>/<timeby>/<value>')
def call_timeseries(houseid,timeby,value):
	response.set_header('Content-Type', 'application/json')
	return timeseries_prediction(houseid,timeby,value)
	
@route('/devicewise/<houseid>')
def call_devicewise(houseid):
	response.set_header('Content-Type', 'application/json')
	return dumps(get_piechart_data(houseid))

@route('/device/<houseid>/<date>')
def call_device(houseid,date):
	response.set_header('Content-Type', 'application/json')
	return dumps(get_device_data(houseid,date))
	
@route('/:filename#.*#')
def send_static(filename):
    return static_file(filename, root='./resources/public/')
	
@error(403)
def mistake403(code):
	return 'There is a mistake in your url!'

@error(404)
def mistake404(code):
	return 'Sorry, this page does not exist!'

def main_fn():
	run(host="localhost", port=8080)
	
if __name__ == "__main__":
	run(host="localhost", port=8080)
