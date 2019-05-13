#!/bin/bash

cd /var/www/html

rm *

cd /var/www/VersionBackups

tar -xvf OldVersion1.0.tar -C /var/www/html


