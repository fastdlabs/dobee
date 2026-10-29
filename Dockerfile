# syntax=docker/dockerfile:1

# 1. Build production dependencies from the committed lock file.
FROM composer:2 AS vendor

WORKDIR /app

COPY composer.json composer.lock ./

RUN composer install \
    --no-dev \
    --prefer-dist \
    --no-interaction \
    --no-progress \
    --optimize-autoloader \
    --classmap-authoritative \
    --no-scripts

# 2. Runtime image with PHP, Swoole and database extensions.
FROM php:8.4-cli-bookworm

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        curl \
        libcurl4-openssl-dev \
        libpcre3-dev \
        libsqlite3-dev \
        libssl-dev \
    && pecl install swoole \
    && docker-php-ext-enable swoole \
    && docker-php-ext-install pdo pdo_mysql pdo_sqlite sockets \
    && rm -rf /var/lib/apt/lists/* /tmp/pear

WORKDIR /app

COPY --from=vendor /app/vendor ./vendor
COPY --from=vendor /app/bin ./bin
COPY . .

# Containers must listen on all interfaces, not only loopback.
RUN sed -i 's/127\.0\.0\.1/0.0.0.0/g' config/swoole.php \
    && mkdir -p runtime/logs runtime/cache runtime/pid \
    && chown -R www-data:www-data runtime

USER www-data

EXPOSE 9527

STOPSIGNAL SIGTERM

HEALTHCHECK --interval=15s --timeout=5s --start-period=10s --retries=3 \
    CMD curl -fsS http://127.0.0.1:9527/ >/dev/null || exit 1

CMD ["php", "bin/server", "start"]
