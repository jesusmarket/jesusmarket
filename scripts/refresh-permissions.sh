#!/bin/sh

cd /var/www/html

echo "chown"
chown -R root *
chgrp -R www-data *

echo "files"
find wordpress wp-admin wpclone_backup wp-includes scripts wp-content -type f -not \( -path "*/\.git/*" \) -exec chmod 664 {} \;
chmod 664 *.php
chmod 640 wp-config.php
chmod 400 readme.html
chmod 400 license.txt
echo "dirs"
find wordpress wp-admin wpclone_backup wp-includes scripts wp-content -type d -not \( -path "*/\.git/*" \) -exec chmod 775 {} \;
echo "scripts"
chmod 740 scripts/*sh
chmod 740 scripts/*py
chmod 000 xmlrpc.php
echo "cleanup .DS_Store files"
find / -depth -name ".DS_Store" -exec rm {} \;
find / -depth -name ".DS_Store?" -exec rm {} \;
echo "done"
