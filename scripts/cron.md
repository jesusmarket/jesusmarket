# Runs once a week (every Sunday at midnight) to create a backup of the jesusma6 database using mysqldump
0 0 * * 0 /home/ec2-user/database_backup/script/db-backup.sh

# Runs once a month (first of every month at 1 am) to archive a backup of all the sql files and backs them up on remote backup server host
0 1 1 * * /home/ec2-user/database_backup/script/copy-to-backup.sh

# Check yum updates every friday at 8pm
0 20 * * 5 sudo yum check-update | mailx -s "yum check-update" silvian.dragan@gmail.com

# Disk usage report every sunday at 11am
0 11 * * 0 df -h | mailx -s "disk usage status" silvian.dragan@gmail.com

# Cron backup scheduled to run every hour
0 * * * * sudo /var/www/html/scripts/cron-backup.sh
