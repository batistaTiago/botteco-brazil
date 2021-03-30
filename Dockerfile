FROM php:7.4-fpm

RUN apt-get update && apt-get install -y \
		libfreetype6-dev \
		libjpeg62-turbo-dev \
		libpng-dev \
		nano \
		zip \
		unzip \
		zlib1g-dev \
		libzip-dev \
	&& docker-php-ext-install -j$(nproc) iconv \
	&& docker-php-ext-configure gd --with-freetype --with-jpeg \
	&& docker-php-ext-install -j$(nproc) gd \
	&& docker-php-ext-install pcntl pdo pdo_mysql zip

RUN docker-php-ext-install pcntl pdo pdo_mysql zip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html/src

COPY ./src/package*.json ./
COPY ./src/composer*.json ./

WORKDIR /var/www/html/
