#!/usr/bin/python

import webFormServer

# ------------------------------------------
#  Simple Example subclass of webFormServer
# ------------------------------------------
class addTwoNumbers(webFormServer.AbstractWebForm):


	def __init__(self):
		super(addTwoNumbers, self).__init__()

		self.TITLE = 'Addition Calculation'

		self.num1 = int(self.inputData["num1"].value)
		self.num2 = int(self.inputData["num2"].value)

	def showResult(self):
		print '<p>{0} + {1} = {2}</p>'.format(self.num1, self.num2, self.num1 + self.num2)

	def showError(self):
  		print '<p>Sorry, we cannot turn your inputs into numbers (integers).</p>'


# ---------------------------------
#  MAIN 
# ---------------------------------

if __name__ == "__main__":
	addTwoNumbers().do()
