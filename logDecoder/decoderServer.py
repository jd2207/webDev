"""
Very simple HTTP server for decoding logs strings received via http POST requests.

Usage::
    decoder.py [<port>]

    Then on the client side:

    Example 1:
    	curl -d "encoded=foobar" http://localhost[:<port>]
    
	--------------------------------
"""


import SimpleHTTPServer, SocketServer, subprocess, json


class DecoderReceiver(SocketServer.TCPServer):

	def __init__(self, port=8080):
		self.port = port
		return SocketServer.TCPServer.__init__(self, ("", self.port), HTTPPostHandler)

	def start(self):
		print "Decoding Server listening at port", self.port
		self.serve_forever()


class HTTPPostHandler(SimpleHTTPServer.SimpleHTTPRequestHandler):
			
	def do_POST(self):
		content_length = int(self.headers['Content-Length']) # <--- Gets the size of data
		post_data = self.rfile.read(content_length) # <--- Gets the data itself

		#decode json 
		j = json.loads(post_data)
		
		self.send_response(200)
		self.send_header('Content-type', 'text/html')
		self.end_headers()

		encoded = j["encodedString"]
		self.wfile.write("You asked me to decode this:\n%s\n\n" % encoded)
		decoded = 'xxx' + subprocess.check_output(['decodeLogLiveRaw', encoded]) +'yyy'
		self.wfile.write("Decoded version:\n%s\n\n" % decoded)
	
	
if __name__ == "__main__":
	server = DecoderReceiver()
	server.start()


