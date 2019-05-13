#!/bin/bash

cd /var/www/html

tar -cvf /var/www/VersionBackups/OldVersion.tar *

cd /var/www/VersionBackups

tar -xvf NewRelease1.0.tar -C /var/www/html




