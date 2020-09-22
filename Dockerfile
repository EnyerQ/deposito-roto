FROM php:7.3-apache
ARG CACHE_DATE=2016-01-19

RUN docker-php-ext-install pdo_mysql

# enabling mod_rewrite
RUN cp /etc/apache2/mods-available/rewrite.load /etc/apache2/mods-enabled/

#RUN cp /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini

#COPY /www /var/www/html

#RUN chmod -R a+rwX /var/www/html/LINEATIEMPO/libreria/MPDF/vendor/mpdf/mpdf/tmp
#RUN chmod -R a+rwX /var/www/html/