#!/usr/bin/python

import cgi, cgitb	## handle server requests
cgitb.enable()

form = cgi.FieldStorage()

# HTML header
print 'Content-Type:text/html' # HTML is following
print                          # Leave a blank line
print '<h1>Test response from CGI server</h1>'

# send data for debugging
print form.getvalue("testValue")