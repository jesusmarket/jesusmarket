#!/bin/sh

cd /var/www/html

echo "chown"
chown -R root *
chgrp -R www *

echo "files"
find wordpress wp-admin wpclone_backup wp-includes scripts wp-content -type f -not \( -path "*/\.git/*" \) -exec chmod 664 {} \;
echo "dirs"
find wordpress wp-admin wpclone_backup wp-includes scripts wp-content -type d -not \( -path "*/\.git/*" \) -exec chmod 775 {} \;
echo "scripts"
chmod 770 scripts/*sh
chmod 770 scripts/*py
echo "done"
