#!/bin/sh
cd /srv/123vpc/www/tew-test.123vpc.com

# cloning the git master branch
git clone https://github.com/daikiridev/talentpool.git

# composer dependencies...
composer install

# DB updating

# cache cleaning
app/console cache:clear # --env=prod --no-debug

# assets installaiton into web directory
app/console assets:install --symlink

# checking rights
chown -R www-data:www-data /srv/123vpc/www/tew-test.123vpc.com