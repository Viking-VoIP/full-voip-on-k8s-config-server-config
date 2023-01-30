#!/bin/bash

not_ready(ERROR) {
  echo "Either Consul is not ready: $ERROR"
  sleep 5
}

# Query for the params to make sure they are available, otherwise wait 5 seconds...
while [[ ! "$(consul kv get backend/db_address)" =~ ^backend-db.*amazonaws.com$ ]];do not_ready("DB_ADDRESS error"); done
while [[ ! "$(consul kv get backend/db_user > /dev/null &>1; echo $?)" -ne "1" ]];do not_ready("DB_USER error"); done
while [[ ! "$(consul kv get backend/db_pass > /dev/null &>1; echo $?)" -ne "1" ]];do not_ready("DB_PASS error"); done

DB_ADDRESS=$(consul kv get backend/db_address)
DB_USER=$(consul kv get backend/db_user)
DB_PASS=$(consul kv get backend/db_pass)

sed "s/{{ DBHOST }}/$DB_ADDRESS/g; s/{{ DBUSER }}/$DB_USER/g; s/{{ DBPASS }}/$DB_PASS/g;" /var/www/html/db_conn.php.template > /var/www/html/db_conn.php
