FROM php:8.0.13-fpm-alpine

EXPOSE 8080

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN apk update && apk add \
    build-base \
    freetype-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    libzip-dev \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    oniguruma-dev \
    curl

RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl
RUN docker-php-ext-install bcmath
RUN docker-php-ext-configure gd
RUN docker-php-ext-install gd

# Install Redis Extension
RUN apk add autoconf && pecl install -o -f redis \
    &&  rm -rf /tmp/pear \
    &&  docker-php-ext-enable redis && apk del autoconf

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR "/laravel"

COPY . .

COPY .env.example .env

RUN rm -rf composer.lock package-lock.json

RUN mkdir -p storage/framework/laravel-excel
RUN mkdir -p storage/framework/sessions  
RUN mkdir -p storage/framework/testing  
RUN mkdir -p storage/framework/views

RUN composer install --ignore-platform-reqs

RUN cp ./php-conf/uploads.ini /usr/local/etc/php/conf.d/uploads.ini
#RUN cp cron-job /etc/cron.d/cron-job

RUN chmod 755 /laravel/start.sh
#RUN chmod 0644 /etc/cron.d/cron-job
#RUN crontab /etc/cron.d/cron-job
#RUN touch /var/log/cron.log

RUN chmod -R 777 storage
RUN chmod -R 777 public
RUN chmod -R 777 resources
RUN chmod -R 777 bootstrap

CMD ["/laravel/start.sh"]
