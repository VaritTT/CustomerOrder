ARG PHP_VERSION=8
FROM php:${PHP_VERSION}-apache
RUN docker-php-ext-install mysqli
RUN groupadd -r apache && useradd -r -g apache apache-user
# เป็นการให้สิทธิ์ขั้นต่ำเป็นระดับ user 
RUN chown -R apache-user:apache /var/www/html
USER apache-user
COPY src/ /var/www/html/