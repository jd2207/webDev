#!/usr/bin/python

import webFormServer
from endPoint.endPoint import AuthorizePaymentEndPoint

# ------------------------------------------
#  Simple Example subclass of webFormServer
# ------------------------------------------
class creditCardAPIServer(webFormServer.AbstractWebForm):

	def __init__(self):
		super(creditCardAPIServer, self).__init__()

		self.TITLE = 'Credit Card Payment'

		creds = ('ws_586199', 'Q*-h6a?8Ut!qU<Q(F2y1br{MM')
		self.ENDPOINT = AuthorizePaymentEndPoint(creds, debug=True)

# 		Read values passed from the form
		self.number = self.inputData["number"].value
		self.expMonth = self.inputData["expiryMonth"].value
		self.expYear = self.inputData["expiryYear"].value
		self.cvc = self.inputData["expiryYear"].value
		self.holder = self.inputData["holderName"].value
		self.value = int(self.inputData["value"].value)
		self.currency = self.inputData["currency"].value
		self.reference = self.inputData["reference"].value
		self.merchantAccount = self.inputData["merchantAccount"].value

	def createJsonReq(self):  # make the request based on the form data
		return { 
			"card": {
	    		"number"		: self.number,
	    		"expiryMonth"	: self.expMonth,
	    		"expiryYear"	: self.expYear,
	    		"cvc"			: self.cvc,
	    		"holderName"	: self.holder
	  		},
			"amount": {
	 	    	"value"		: self.value,
	    		"currency"	: self.currency
	  		},
	  		"reference"			: self.reference,
	  		"merchantAccount"	: self.merchantAccount
		}


	def showResult(self):
		print self.resp


# ---------------------------------
#  MAIN 
# ---------------------------------

if __name__ == "__main__":
	creditCardAPIServer().do()
