#!/bin/sh

echo 'Edit this file to replace all instances of <project_name> with the project''s name'
exit;

CONFIG=/home/ec2-user/<project_name>/bin/app-settings.php

HOST=$($CONFIG db.<project_name>db.host)
PORT=$($CONFIG db.<project_name>db.port)
NAME=$($CONFIG db.<project_name>db.database)
USER=$($CONFIG db.<project_name>db.username)
PASS=$($CONFIG db.<project_name>db.password)

mysql -h "$HOST" -P "$PORT" -u "$USER" -p"$PASS" "$NAME"

