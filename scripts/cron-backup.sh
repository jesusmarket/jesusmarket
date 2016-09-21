#!/bin/sh

cd /var/www/html/scripts

COMMIT_MESSAGE="updated cron backup"

#Check project is up to date from origin master before attempting to commit new changes
git pull origin master && /var/www/html/scripts/refresh-permissions.sh

#Copy ec2-user crontab into a temp file
crontab -l -u ec2-user > cron.tmp

#Copy into the cron.md version controlled backup file and remove temp
cp cron.tmp cron.md && rm cron.tmp

#Perform a git add of cron.md file if any changes have been made
git add cron.md
echo "adding new files to git"

git status

#Commit change with message added
git commit -m "$COMMIT_MESSAGE" cron.md
echo "commiting new changes with message: $COMMIT_MESSAGE"

#Push changes out to origin master
git push origin master

echo "Finished commiting new changes"

exit 0
