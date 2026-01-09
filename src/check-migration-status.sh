#!/bin/bash
# Script to check Phinx migration status inside Docker container
docker exec -it php-app vendor/bin/phinx status -c /var/www/html/src/phinx.yml


