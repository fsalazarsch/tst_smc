FROM php:8.1-apache


RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libonig-dev \
    libzip-dev \
    zip \
    unzip \
    mariadb-server \
    git \
    curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd mbstring pdo pdo_mysql zip

RUN a2enmod rewrite
COPY ./apache-config.conf /etc/apache2/sites-available/000-default.conf

COPY ./sql /docker-entrypoint-initdb.d

RUN service mysql start && \
    mysql -e "CREATE USER 'user'@'%' IDENTIFIED BY 'password';" && \
    mysql -e "CREATE DATABASE dbname;" && \
    mysql -e "GRANT ALL PRIVILEGES ON dbname.* TO 'user'@'%';" && \
    mysql -e "FLUSH PRIVILEGES;"

COPY . /var/www/html/

WORKDIR /var/www/html
RUN chown -R www-data:www-data /var/www/html

RUN curl -sS https://phar.phpunit.de/phpunit.phar -o /usr/local/bin/phpunit && \
    chmod +x /usr/local/bin/phpunit

EXPOSE 80 3306

CMD ["apache2-foreground"]
# CMD ["phpunit", "--testdox"]
