#!/bin/sh
echo 'Edit this file to replace all instances of <project_name> with the project''s name'
exit;

cd /etc/nginx/conf.d
sudo ln -f -s /home/ec2-user/<project_name>/etc/nginx/<project_name>.conf .

sudo chmod 755 /home/ec2-user
sudo chown nginx:ec2-user /var/lib/php/session/

cd /home/ec2-user/<project_name>

CONFIG=/home/ec2-user/<project_name>/bin/app-settings.php

HOST=$($CONFIG db.<project_name>db.host)
PORT=$($CONFIG db.<project_name>db.port)
NAME=$($CONFIG db.<project_name>db.database)
USER=$($CONFIG db.<project_name>db.username)
PASS=$($CONFIG db.<project_name>db.password)

echo "creating database $NAME"
mysql -uroot -pdevpass314 -h "$HOST" -P "$PORT" -e"CREATE DATABASE $NAME;"
mysql -uroot -pdevpass314 -h "$HOST" -P "$PORT" -e"GRANT ALL PRIVILEGES ON $NAME.* TO '$USER'@'localhost' IDENTIFIED BY '$PASS' WITH GRANT OPTION;"
mysql -uroot -pdevpass314 -h "$HOST" -P "$PORT" -e"FLUSH PRIVILEGES;"

echo updating database to latest version

/home/ec2-user/<project_name>/scripts/update-database.sh migrate

echo restarting dev things
/home/ec2-user/<project_name>/scripts/restart-dev-things.sh

echo checking log access
touch /home/ec2-user/<project_name>/logs/error.log
chmod a+rw /home/ec2-user/<project_name>/logs/error.log
touch /home/ec2-user/<project_name>/logs/app.log
chmod a+rw /home/ec2-user/<project_name>/logs/app.log
touch /home/ec2-user/<project_name>/logs/hybridauth.log
chmod a+rw /home/ec2-user/<project_name>/logs/hybridauth.log
