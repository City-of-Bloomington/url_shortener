FROM ubuntu:latest
ENV DEBIAN_FRONTEND=noninteractive
ENV TZ=America/Indiana/Indianapolis
RUN ln -snf /usr/share/zoneinfo/America/$TZ /etc/localtime \
    && echo $TZ > /etc/timezone

RUN apt-get update && apt-get install -y apache2 locales \
    && locale-gen en_US.UTF-8
RUN a2enmod alias && \
    a2enmod headers && \
    a2enmod remoteip && \
    a2enmod rewrite

RUN apt-get install -y \
    imagemagick \
    php-common \
    php-cli \
    php-dom \
    php-json \
    php-readline \
    php-mbstring \
    php-pgsql \
    php-intl \
    php-zip \
    unzip \
    php-curl \
    php-ldap \
    php-xsl \
    php-mysql \
    php-imagick \
    libapache2-mod-php

WORKDIR /srv/sites/url_shortener
COPY --chown=www-data:staff . /srv/sites/url_shortener

EXPOSE 80
ENTRYPOINT ["apachectl", "-D", "FOREGROUND"]
