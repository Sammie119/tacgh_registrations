#!/bin/bash
cd /home/aposaghana/www/test/aposacamp/appfiles/ && php artisan queue:work --daemon --tries=3 >> /home/aposaghana/www/test/aposacamp/appfiles/storage/logs/queue_logfile.log 2>&1
