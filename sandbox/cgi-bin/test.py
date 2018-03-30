#!/usr/bin/python

import cgi, cgitb	## handle server requests
cgitb.enable()

print 'Content-Type:text/html' # HTML is following
print
print 'something'

import logging
logging.basicConfig(format = '%(asctime)s %(levelname)s:%(message)s', level = logging.DEBUG)	
logging.debug('xxx')
