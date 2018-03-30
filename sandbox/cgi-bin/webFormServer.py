#!/usr/bin/python

import endPoint
                     
import cgi, cgitb, logging
cgitb.enable()

HTML_HEADER = 'Content-Type:text/html' + "\n"
BREAK = '<br>'

class AbstractWebForm(object): 
# Abstract class for processing Json HTTP POSTs 
#  
# Usage:
#   1. Create a web form HTML and save as <code project>/test.html 
#   For example:
#  <form action="cgi-bin/webFormServer.py" method="POST">
#   Some text: <input type="text" name="text" value="Hello World!"/><br>
# 	<input type="submit"/>
#	  </form># 
# 
#   2. Start CGIHTTP server on port 8080
#   python -m CGIHTTPServer 8080
#   
#   3. Open the test.html in a web browser using URL http://localhost:8080/test.html   
#   Accept or change the text input and submit
#
#   4. Web browser will display   
#	Simple
# JSON REQUEST to ENDPOINT **TEST ONLY** >>>>>>>>> 
# {'something': <the text which you input on the form>} 
# JSON RESPONSE <<<< 
# no endPoint defined
#
# ----------------------------------------------------------------------------------------

  def __init__(self, noHttpReq=False):
    self.inputData = cgi.FieldStorage()

    self.noHttpReq = noHttpReq
    logging.basicConfig(format = '%(asctime)s %(levelname)s:%(message)s', level = (logging.DEBUG))  


# To be defined by subclasses:
    self.TITLE = None
    self.ENDPOINT = None
  
  def createJsonReq():  
# To be overridden by subclasses
		pass
  
  def do(self):
# Main method, usually common to subclasses. Sends JSON data to pre-defined endpoint, creates HTML output 
    print HTML_HEADER
    print '<h1>' + self.TITLE + '</h1>'

    self.jsonReq = self.createJsonReq()
    if self.jsonReq:
      if self.ENDPOINT:
 
        if self.noHttpReq:
          self.jsonResp = {'dummy': 'response'}
          self.showReq()
          self.showResp()
        else: # do real http request
          resp = self.ENDPOINT.sendRequest(self.jsonReq)    	# this is the http request
          if resp == 0:                                       # http 200 resp with json
            self.jsonResp = self.ENDPOINT.jsonResponse
            self.showReq()
            self.showResp()
          else: 
            logging.debug('Error: Problem during HTTP request')
      else:
        logging.debug('Error: No endPoint defined')
    else:
      logging.debug('Error: No json request defined')
      
    def showReq(self):
      logging.debug('JSON REQUEST to ENDPOINT', (self.ENDPOINT.url),'>>>>>>>>>')
      logging.debug(self.jsonReq)
      
    def showResp(self):
		print BREAK
		logging.debug('JSON RESPONSE <<<<')
		logging.debug(self.jsonResp)
		print "JSON RESPONSE <<<<" 
 		print BREAK
 		print self.jsonResp

# ---------------------------------------
#  Simple subclass of AbstractWebForm
# ---------------------------------------

class SimpleWebForm(AbstractWebForm):
# Subclass of AbstractWebForm for simple tests / demos
#  - hardwires the json req and resp rather than using a real endpoint

  def __init__(self, noHttpReq=False):
    super(SimpleWebForm, self).__init__()
    self.TITLE = 'Simple'
    self.ENDPOINT = endPoint.DummyEndPoint()
    self.inputText = self.inputData["text"].value  # 		Read values passed from the form

  def createJsonReq(self):  # make the request based on the form data
		return { "sometext": self.inputText }


# Main -------------------------------------
if __name__ == "__main__":
	SimpleWebForm(noHttpReq=True).do()
