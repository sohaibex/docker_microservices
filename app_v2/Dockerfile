FROM php:7.4-alpine

RUN apk update && apk add --no-cache \
    bash \
    curl \
    mariadb-client

RUN docker-php-ext-install sockets mysqli pdo pdo_mysql && docker-php-ext-enable pdo_mysql mysqli pdo


WORKDIR /appli


COPY appliccm/* /appli/

EXPOSE 9014