FROM nanoninja/php-fpm:7.1.14
LABEL maintainer="phanvuhoang@gmail.com"
ENV INSTALL_DIR /var/www/html
RUN curl -sS https://getcomposer.org/installer | php &&\
    mv composer.phar /usr/local/bin/composer &&\
    curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar
    
RUN groupadd -g 1000 app && useradd -g 1000 -u 1000 -d /var/www -s /bin/bash app
WORKDIR $INSTALL_DIR