#!/bin/sh
cd /srv/123vpc/www/tew-test.123vpc.com

# cloning the git master branch (first time)
# git config color.ui true
# git clone https://github.com/daikiridev/talentpool.git

# git update from repository
git pull

# composer dependencies... (composer update only for the dev plateform)
composer install

# DB updating
app/console doctrine:migrations:diff
app/console doctrine:migrations:migrate


# cache cleaning
app/console cache:clear --env=prod

# assets installation into the web directory
app/console assets:install --symlink

# checking rights
chown -R www-data:www-data /srv/123vpc/www/tew-test.123vpc.com