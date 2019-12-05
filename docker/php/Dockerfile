FROM php:7.3-fpm-alpine

ARG TZ
ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_HOME /composer

RUN set -eux && \
  apk add --update-cache --no-cache --virtual=.build-dependencies tzdata && \
  apk add libzip-dev && \
    # apk add libzip-dev && \<== docker-php-ext-install zipを実行するために追加
  apk add \
          # ↓ダメだった
          # libfreetype6-dev \
          # libjpeg62-turbo-dev \
          # libmcrypt-dev \
          # libpng12-dev && \
          # ↓gdインストールのため
          coreutils \
          freetype-dev \
          libjpeg-turbo-dev \
          libltdl \
          libmcrypt-dev \
          libpng-dev && \
  cp /usr/share/zoneinfo/${TZ} /etc/localtime && \
  apk del .build-dependencies && \
  docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ && \
  docker-php-ext-install -j$(nproc) iconv && \
  docker-php-ext-install -j$(nproc) gd && \
  docker-php-ext-install zip bcmath pdo_mysql && \
  #zip を追加しないとphpoffice/spreadsheetがcomposerで取得できない
  curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer && \
  composer config -g repos.packagist composer https://packagist.jp && \
  composer global require hirak/prestissimo && \
  composer require predis/predis

# Xdebug のインストールと有効化
RUN apk add autoconf && \
  apk add gcc g++ make && \
  pecl install xdebug && \
  docker-php-ext-enable xdebug