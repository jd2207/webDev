See also DecoderTool.odt

Sequence:

1. Copy all files to some local directory then open two command prompts in this subdirectory.

2. In one command window, run web server listening on 8000
php -S localhost:8000 

3. In the other command window, run http listener which handles the http post to run the decoder:
python decoderServer.py (listens on port 8080)

4. Open logDecoder.html in a browser:
In address bar: http://localhost:8000/logDecoder.html

5. Enter text to decode


