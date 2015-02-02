#!/bin/sh
cd /srv/123vpc/www/tew-test.123vpc.com

# MAJ svn
svn --update

# nettoyage du cache
app/console cache:clear # --env=prod --no-debug

# installation des assets dans le repertoire web
app/console assets:install --symlink

# restauration des droits
chown -R www-data:www-data /srv/123vpc/www/tew-test.123vpc.com
