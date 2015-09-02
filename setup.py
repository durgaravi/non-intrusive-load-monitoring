import os
from setuptools import setup

def read(fname):
    return open(os.path.join(os.path.dirname(__file__), fname)).read()

setup(
    name = "nilm",
    version = "0.1",
    author = "Kovvali Manasa Rao, Durga R; PES Institute of Technology",
    description = ("A package to perform non-intrusive load monitoring on household data"),
    keywords = "Non-intrusive load monitoring",
    packages=['src'],
	package_data = {"":["resources/data/*","resources/public/*","resources/php/*"]},
	include_package_data = True,
    long_description=read('README.md'),
    install_requires=['pandas','isoweek','dateutil','pymysql','bottle','numpy'],
	entry_points = {'console_scripts': ['nilm = src.mainserver:main_fn']},
)