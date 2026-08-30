FROM php:7.4-apache AS php-base
ENV PHP_DATE_TIMEZONE=UTC

RUN <<EOF
set -eux
cat << 'SOURCES' > /etc/apt/sources.list
deb http://deb.debian.org/debian bullseye main contrib non-free
deb http://deb.debian.org/debian bullseye-updates main contrib non-free
deb http://security.debian.org/debian-security bullseye-security main contrib non-free
SOURCES
apt-get update -y --allow-insecure-repositories --allow-unauthenticated
apt-get install -y debian-archive-keyring --allow-unauthenticated
EOF

RUN <<EOF
set -eux
apt-get install -y --no-install-recommends --no-install-suggests \
  libfreetype6-dev \
  libjpeg62-turbo-dev \
  libpng-dev \
  libonig-dev \
  libxml2-dev \
  libicu-dev \
  libgmp-dev \
  libzip-dev \
  default-mysql-client \
  libarchive-tools \
  p7zip-full \
  unzip \
  git
rm -rf /var/lib/apt/lists/*
EOF

RUN <<EOF
ln -s /usr/include/x86_64-linux-gnu/gmp.h /usr/include/gmp.h
docker-php-ext-configure gd --with-freetype --with-jpeg
docker-php-ext-install -j$(nproc) gd mbstring xml pdo_mysql mysqli intl gmp zip
EOF

RUN a2enmod rewrite

WORKDIR /var/www/html

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]

# todo add healthcheck

FROM php-base AS php-dev

RUN <<EOF
cp /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini
sed -e "s#^;date.timezone =.*#date.timezone = ${PHP_DATE_TIMEZONE:-UTC}#g" -i /usr/local/etc/php/php.ini
EOF

FROM php-base AS php-prod

RUN <<EOF
cp /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini
sed -e "s#^;date.timezone =.*#date.timezone = ${PHP_DATE_TIMEZONE:-UTC}#g" -i /usr/local/etc/php/php.ini
EOF

COPY . .

FROM mariadb:12.0 AS mariadb-dev

RUN apt update && apt-get install p7zip curl git -y
RUN ln -s /usr/bin/mariadb /usr/bin/mysql

RUN <<EOF
mkdir -p /usr/local/share/mysql
chown mysql:mysql /usr/local/share/mysql
EOF

VOLUME /usr/local/share/mysql

HEALTHCHECK --interval=5s --timeout=5s --retries=30 CMD mariadb-admin ping -h 127.0.0.1 -u root -P3306 -p$MYSQL_ROOT_PASSWORD || exit 1
