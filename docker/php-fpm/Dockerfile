FROM php:7.4-fpm

COPY wait-for-it.sh /usr/bin/wait-for-it

RUN chmod +x /usr/bin/wait-for-it

RUN apt-get update && \
    apt-get install -y --no-install-recommends libssl-dev zlib1g-dev curl unzip libxml2-dev libpq-dev libzip-dev && \
    docker-php-ext-install pdo && docker-php-ext-install pdo_mysql && \
    docker-php-ext-enable pdo_mysql && \
    apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN apt-get update \
	&& apt-get install -y libgmp-dev wget \
	&& ln -s /usr/include/x86_64-linux-gnu/gmp.h /usr/include/gmp.h \
	&& docker-php-ext-install -j$(nproc) \
		gmp \
		bcmath

COPY --from=composer /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

CMD composer i -o ; wait-for-it mysql_test:3306; -- php yii migrate --interactive=0  ;  php-fpm
EXPOSE 9000
