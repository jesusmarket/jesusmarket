#!/bin/sh

cd /var/www/html

COMMIT_MESSAGE=$1

#Check project is up to date from origin master before attempting to commit new changes
git pull origin master && /var/www/html/scripts/refresh-permissions.sh

#Perform a git add of every file changed in the current working directory
git add *
echo "adding new files to git"

#Commit change with message added
git commit -m "$1"
echo "commiting new changes with message: $1"

#Push changes out to origin master
git push origin master

echo "Finished commiting new changes"

exit 0
