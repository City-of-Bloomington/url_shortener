#!/bin/bash
# Daily cron script
#
# Creates a tarball containing a full snapshot of the data in the site
#
# @copyright Copyright 2011-2024 City of Bloomington, Indiana
# @license https://www.gnu.org/licenses/agpl-3.0.txt GNU/AGPL, see LICENSE
APPLICATION_NAME="url_shortener"
APPLICATION_HOME="{{ url_shortener_install_path }}"
BACKUP_DIR="{{ url_shortener_backup_path }}"
SITE_HOME="{{ url_shortener_site_home }}"
MYSQL_CREDENTIALS="/etc/mysql/debian.cnf"
MYSQL_DBNAME="{{ url_shortener_db.default.name }}"

#----------------------------------------------------------
# Backups
#----------------------------------------------------------
# How many days worth of tarballs to keep around
num_days_to_keep=5

now=`date +%s`
today=`date +%F`

# Dump the database
mysqldump --defaults-extra-file=$MYSQL_CREDENTIALS $MYSQL_DBNAME > $SITE_HOME/$MYSQL_DBNAME.sql
cd $SITE_HOME/..
tar czf $today.tar.gz $(basename $SITE_HOME)
mv $today.tar.gz $BACKUP_DIR

# Purge any backup tarballs that are too old
cd $BACKUP_DIR
for file in `ls`
do
	atime=`stat -c %Y $file`
	if [ $(( $now - $atime >= $num_days_to_keep*24*60*60 )) = 1 ]
	then
		rm $file
	fi
done
