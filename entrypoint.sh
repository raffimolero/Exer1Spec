#!/bin/bash

cd src
php build.php
cd $TARGET
php -S 0.0.0.0:8000