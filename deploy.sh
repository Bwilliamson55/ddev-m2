#!/bin/bash

# Exit on any error
set -e

composer install
bin/magento setup:upgrade
bin/magento setup:di:compile
bin/magento c:f
#sudo find var generated vendor pub/static pub/media app/etc -type f -exec chmod g+w {} +
#sudo find var generated vendor pub/static pub/media app/etc -type d -exec chmod g+ws {} +
#sudo chown -R :www-data . # Ubuntu
#sudo chmod u+x bin/magento
