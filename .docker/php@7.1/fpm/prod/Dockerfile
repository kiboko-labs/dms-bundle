FROM php:7.1-fpm-alpine

LABEL maintainer="Grégory Planchat <gregory@kiboko.fr>"

ARG APP_UID=1000
ARG APP_GID=1000
ARG APP_USERNAME=docker
ARG APP_GROUPNAME=docker

RUN set -ex\
    && apk update \
    && apk upgrade \
    && echo "@testing http://nl.alpinelinux.org/alpine/edge/testing" >> /etc/apk/repositories \
    && apk add \
        nodejs \
        shadow@testing \
        ca-certificates \
        wget \
        autoconf \
        bash \
        binutils \
        expat \
        file \
        g++ \
        gcc \
        m4 \
        make \
    && update-ca-certificates

RUN docker-php-ext-install opcache

RUN apk add --update zlib-dev \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip \
    && apk del zlib-dev

RUN apk add --update libxml2-dev \
    && docker-php-ext-configure soap \
    && docker-php-ext-install soap \
    && apk del libxml2-dev

RUN apk add --update libpng-dev libjpeg-turbo-dev freetype-dev freetype libpng libjpeg-turbo \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install gd \
    && apk del libpng-dev libjpeg-turbo-dev freetype-dev

RUN apk add --update icu-dev icu \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl \
    && apk del icu-dev

RUN apk add --update postgresql-dev \
    && docker-php-ext-configure pdo_pgsql \
    && docker-php-ext-install pdo_pgsql \
    && apk del postgresql-libs

RUN apk add --update libmcrypt-dev libmcrypt \
    && docker-php-ext-configure mcrypt --with-mcrypt \
    && docker-php-ext-install mcrypt \
    && apk del libmcrypt-dev

RUN docker-php-ext-configure bcmath \
    && docker-php-ext-install bcmath

RUN docker-php-ext-configure mbstring \
    && docker-php-ext-install mbstring

RUN apk add --no-cache --repository http://dl-3.alpinelinux.org/alpine/edge/testing gnu-libiconv

ENV LD_PRELOAD /usr/lib/preloadable_libiconv.so php

RUN apk del \
        autoconf \
        bash \
        binutils \
        expat \
        file \
        g++ \
        gcc \
        gdbm \
        gmp \
        isl \
        libatomic \
        libbz2 \
        libc-dev \
        libffi \
        libgcc \
        libgomp \
        libldap \
        libltdl \
        libmagic \
        libstdc++ \
        libtool \
        m4 \
        make \
        mpc1 \
        mpfr3 \
        musl-dev \
        perl \
        pkgconf \
        pkgconfig \
        python \
        re2c \
        readline \
        sqlite-libs \
    && rm -rf /tmp/* /var/cache/apk/*

RUN addgroup -g ${APP_GID} ${APP_USERNAME} \
    && adduser -u ${APP_UID} -h /opt/${APP_USERNAME} -H -G ${APP_GROUPNAME} -s /sbin/nologin -D ${APP_USERNAME}

COPY config/pool.ini /usr/local/etc/php/pool.d/default.ini

WORKDIR /var/www/html
