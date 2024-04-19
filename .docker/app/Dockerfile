FROM php:8.2-fpm

LABEL maintainer="glavvra4durki@gmail.com"

RUN apt-get update \
    && apt-get install -y nano git unzip wget sudo \
    libicu-dev libmcrypt-dev libxml2-dev libgmp-dev libpng-dev libzip-dev libpq-dev

RUN docker-php-ext-install bcmath \
	gettext \
    gd \
	gmp \
	intl \
	opcache \
	pcntl \
	pdo_pgsql \
	sockets \
    zip

RUN pecl install mcrypt && echo "extension=mcrypt.so" > /usr/local/etc/php/conf.d/mcrypt.ini
RUN pecl install igbinary && echo "extension=igbinary.so" > /usr/local/etc/php/conf.d/igbinary.ini
RUN yes '' | pecl install redis && echo "extension=redis.so" > /usr/local/etc/php/conf.d/redis.ini
RUN pecl install xdebug && echo "zend_extension=xdebug.so" > /usr/local/etc/php/conf.d/xdebug.ini

RUN cd /usr/local/bin \
	&& curl https://getcomposer.org/composer-2.phar > composer \
	&& chmod +x composer

RUN chmod g+w /usr/local/etc/php/conf.d/ \
    && usermod -a -G staff www-data \
    && usermod --shell /bin/bash www-data \
    && chown www-data:staff /var/www \
    && echo 'www-data ALL=(ALL:ALL) NOPASSWD: ALL' > /etc/sudoers.d/www-data

COPY --chown=www-data:www-data ./ /var/www/app

COPY ./.docker/app/php/fpm/php-fpm.conf /usr/local/etc/php-fpm.d/99-symfony.conf
COPY ./.docker/app/php/fpm/php.ini /usr/local/etc/php/php.ini
COPY ./.docker/nginx/.htpasswd /etc/nginx/.htpasswd

ENV TZ=Europe/Moscow
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone && echo "date.timezone=$TZ" >> /usr/local/etc/php/conf.d/extra.ini

RUN echo 'memory_limit = 2G' >> /usr/local/etc/php/conf.d/extra.ini

RUN rm -rf /var/www/app/var/cache/* /var/www/app/var/log/*
RUN chmod +x /var/www/app/.docker/app/cmd.sh

WORKDIR /var/www/app

ARG UID=1000
ARG GID=1001
RUN usermod --uid ${UID} www-data && groupmod --gid $GID www-data

USER www-data

CMD /var/www/app/.docker/app/cmd.sh
