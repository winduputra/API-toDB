#!/bin/bash
cd /home/adminbpbj/sibaja

php artisan update:tender-data
php artisan ekatalog:update
php artisan nontender:update
php artisan update:penyedia
php artisan satker:update
php artisan update:struktur-anggaran
php artisan tokodaring:update
php artisan update:swakelola-realisasi
php artisan update:swakelola
