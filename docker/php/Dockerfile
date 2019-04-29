FROM nanoninja/php-fpm:7.1.14

LABEL maintainer="phanvuhoang@gmail.com"
LABEL php_version="7.1.14"
# LABEL magento_version="2.3.1"
# LABEL description="Magento 2.3.1 with PHP 7.2.12"
ENV INSTALL_DIR /var/www/html

RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer

RUN curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar \
	&& chmod +x wp-cli.phar

WORKDIR $INSTALL_DIR