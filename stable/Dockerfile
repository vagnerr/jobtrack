FROM php:7.0-apache
COPY smarty/libs /var/www/Smarty
RUN mkdir /var/www/templates_c && \
    chown www-data:www-data /var/www/templates_c &&\
    mkdir /var/www/cache && \
    chown www-data:www-data /var/www/cache
COPY plugins/* /var/www/Smarty/plugins/
COPY website/docroot /var/www/html
COPY website/configs /var/www/configs
COPY website/templates /var/www/templates
