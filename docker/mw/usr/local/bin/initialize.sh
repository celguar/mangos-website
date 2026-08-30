#!/usr/bin/env sh
set -aeu

echo "Creating '$DB_NAME' DB ..."
mysql -e "CREATE DATABASE $DB_NAME"
echo "Done"
