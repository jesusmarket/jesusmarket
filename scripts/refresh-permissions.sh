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
chmod 740 scripts/*sh
chmod 740 scripts/*py
chgrp ec2-user scripts/ec2-*
chmod 750 scripts/ec2-*
echo "cleanup .DS_Store files"
find / -depth -name ".DS_Store" -exec rm {} \;
find / -depth -name ".DS_Store?" -exec rm {} \;
echo "done"
