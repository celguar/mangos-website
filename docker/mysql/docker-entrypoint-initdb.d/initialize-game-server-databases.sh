#!/usr/bin/env sh
set -aeu

if [ "$SETUP_SKIP" = "1" ]; then
  echo "Skip database initialization"
  exit 0
fi

# ... when service is just created, entrypoint launches temporary server for initialization, it's available
#     only through socket (for security reasons, so make using socket explicitly, instead of environment variable)

# Create temporary config to suppress warning "using password as argument is insecure"
cat << EOF > /tmp/.my.cnf
[mysql]
user=root
password=$MYSQL_ROOT_PASSWORD
EOF

# When maridb is used, running `mysql` will trigger an error, make fix of it to keep logs clean
if [ -f /usr/bin/mariadb ]; then
  MYSQL_BIN='/usr/bin/mariadb'
else
  MYSQL_BIN=$(which mysql)
fi

# shellcheck disable=SC2139
alias mysql="$MYSQL_BIN --defaults-file=/tmp/.my.cnf"

# Create empty game server database
cd /usr/local/share/mysql

echo "Downloading database dumps ..."
if [ ! -d "/usr/local/share/mysql/cmangos-sparse" ]; then  # ... if not already downloaded before
  git clone --depth 1 --filter=blob:none --sparse --branch "master" \
        "https://github.com/celguar/spp-classics-cmangos" \
        "/usr/local/share/mysql/cmangos-sparse"
      git -C "/usr/local/share/mysql/cmangos-sparse" \
        sparse-checkout set "Server/Sql/vanilla"
fi

echo "Creating databases ..."
cat << SQL | mysql
CREATE USER '$DB_USERNAME'@'%' IDENTIFIED BY '$DB_PASSWORD' WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0;
GRANT USAGE ON * . * TO '$DB_USERNAME'@'%';

CREATE DATABASE $DB_WORLD_DB DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE DATABASE $DB_AUTH_DB DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE DATABASE $DB_CHARACTERS_1_DB DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE DATABASE $DB_ARMORY_DB DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

GRANT ALL PRIVILEGES ON $DB_WORLD_DB . * TO '$DB_USERNAME'@'%' WITH GRANT OPTION;
GRANT ALL PRIVILEGES ON $DB_AUTH_DB . * TO '$DB_USERNAME'@'%' WITH GRANT OPTION;
GRANT ALL PRIVILEGES ON $DB_CHARACTERS_1_DB . * TO '$DB_USERNAME'@'%' WITH GRANT OPTION;
GRANT ALL PRIVILEGES ON $DB_ARMORY_DB . * TO '$DB_USERNAME'@'%' WITH GRANT OPTION;
SQL

echo "Applying database dumps ..."
# FIXME: dumps contains DB removal/creation!
7za x "/usr/local/share/mysql/cmangos-sparse/Server/Sql/vanilla/world.7z" -so | mysql "$DB_WORLD_DB" &
7za x "/usr/local/share/mysql/cmangos-sparse/Server/Sql/vanilla/armory.7z" -so | mysql "$DB_ARMORY_DB" &
mysql "$DB_AUTH_DB" < "/usr/local/share/mysql/cmangos-sparse/Server/Sql/vanilla/realmd.sql" &
mysql "$DB_AUTH_DB" < "/usr/local/share/mysql/cmangos-sparse/Server/Sql/vanilla/website.sql" &
mysql "$DB_CHARACTERS_1_DB" < "/usr/local/share/mysql/cmangos-sparse/Server/Sql/vanilla/characters.sql" &

# FIXME
cat << SQL | mysql -uroot -proot
UPDATE $DB_AUTH_DB.website_realm_settings SET dbuser = '$DB_USERNAME', dbpass = '$DB_PASSWORD', dbhost = 'mysql', dbport = '3306', dbname = '$DB_WORLD_DB', chardbname = '$DB_CHARACTERS_1_DB', uptime = '0000-00-00 00:00:00', template = 'vanilla' WHERE id_realm = 1;
SQL

wait
rm -f /tmp/.my.cnf
