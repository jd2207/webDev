#!/usr/bin/python

import cgi, cgitb	## handle server requests
cgitb.enable()


def addButton():
	print 'Hello World!'
	url = 'http://localhost:8080/cardsAPI.html'
	print '<form method="POST" action=' + url + '>'
	print '<input type="submit" value="Pay by CC" />'
	print '</form>'


# main --------------------------------------------------------
form = cgi.FieldStorage()

# HTML header
print 'Content-Type:text/html' # HTML is following
print                          # Leave a blank line
print '<h1>Confirmation</h1>'

# send data for debugging
print "You have agreed to give me $" + form.getvalue("money")

# add a button which sends a simple request to an endpoint
addButton()

