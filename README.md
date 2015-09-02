# Non-intrusive Load Monitoring
Machine learning and data analysis on household electricity consumption data

To run the entire setup on your local machine:

### Files present

1. src/: Python source files
2. resources/php/: PHP Scripts
3. resources/public/: User interface HTML, CSS and JavaScript files

### Prerequisites:

1. Python 2.x
2. MySQL Database
3. PHP Server 
4. `nilm` database on the database server (data not uploaded)

### How to use:

1. `cd` to `nilm`
2. To install required python packages, run : `$ setup.py install`
3. To start the python server, run `$ python src/mainserver.py`
4. Start the PHP server on port 80 and point the root directory to `nilm/resources`
5. Start the MySQL database server on port 3306
6. Go to your browser and navigate to URL: `http://localhost:8080/login`

### Please note
This is a demonstration of our work. Server credentials and data have not been provided. To use this, please enter your configuration details.
