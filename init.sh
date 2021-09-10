#!/bin/bash

DB_ADDRESS=$(consul kv get backend/db_address)
DB_USER=$(consul kv get backend/db_user)
DB_PASS=$(consul kv get backend/db_pass)

sed "s/{{ DBHOST }}/$DB_ADDRESS/g; s/{{ DBUSER }}/$DB_USER/g; s/{{ DBPASS }}/$DB_PASS/g;" /var/www/html/db_conn.php.template > /var/www/html/db_conn.php