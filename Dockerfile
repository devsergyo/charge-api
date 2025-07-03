FROM php:8.4-fpm-alpine

ARG user=www-data
ARG uid=33

RUN apk add --no-cache \
    git \
    curl \
    postgresql-dev \
    oniguruma-dev \
    zip \
    unzip \
    shadow

RUN docker-php-ext-install \
    pdo \
    pdo_pgsql \
    mbstring \
    bcmath

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN if [ "$user" != "www-data" ]; then \
        addgroup -g $uid $user && \
        adduser -D -u $uid -G $user -G www-data $user; \
    fi

WORKDIR /var/www/html

COPY --chown=$user:www-data . .

RUN mkdir -p storage/logs storage/framework/cache storage/framework/sessions storage/framework/views bootstrap/cache \
    && chown -R $user:www-data storage bootstrap/cache \
    && chmod -R 2775 storage bootstrap/cache

USER $user

EXPOSE 9000

CMD ["php-fpm"] 