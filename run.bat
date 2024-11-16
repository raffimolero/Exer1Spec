@echo off

set TARGET="target"

IF EXIST "%TARGET%" (rd /s/q "%TARGET%")
cd src
php -t . -c ./php.ini build.php
cd "../%TARGET%"
php -S localhost:8000