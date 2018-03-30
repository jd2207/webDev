#!/bin/bash

python -m CGIHTTPServer 8080&
php -S localhost:8000&
