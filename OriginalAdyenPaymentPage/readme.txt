This project demoes Adyen API via a (super) simpel webpage.

Pre-requisites:

Either
a) deploy on a webserver that support PHP 

OR

b) Install a webserver and allow PHP:
sudo apt-get update
sudo apt-get install apache2

....


Web page structure
====================

index.html - gets a payment amount from the shopper. This is like a cart page. Calls payment.php

payment.php - confirms the amount and seeks payment card payment via either:
	a) direct API (handler.php)
OR
	b) redirects to HPP (https://test.adyen.com/hpp/select.shtml) with payment data 
	   as defined by the given skin code
OR
	c) makes an API call to directory lookup (https://test.adyen.com/hpp/select.shtml) 
	which returns a list of applicable payment methods (defined by the relevant skin) and then call skip.html
	
skip.html - sends payment details to https://test.adyen.com/hpp/skipDetails.shtml 
 unclear if it is doing this via API (curl) or http POST.
  


	
	


To Do
=========

HTML and PHP editing using eclipse ?




