#!/bin/bash
cd /home/adminbpbj/sibaja

php artisan config:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
