FROM php:7.0-apache
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli
COPY smarty/libs /var/www/Smarty
COPY Date-1.3/ /var/www/lib/Date
RUN mkdir /var/www/templates_c && \
    chown www-data:www-data /var/www/templates_c &&\
    mkdir /var/www/cache && \
    chown www-data:www-data /var/www/cache
COPY plugins/* /var/www/Smarty/plugins/
COPY website/docroot /var/www/html
RUN mkdir -p /var/www/html/smarty_datepick/templates_c &&\
    chown www-data:www-data /var/www/html/smarty_datepick/templates_c
COPY website/configs /var/www/configs
COPY website/templates /var/www/templates
