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

RUN printf "deb http://archive.debian.org/debian/ jessie main\ndeb-src http://archive.debian.org/debian/ jessie main\ndeb http://security.debian.org jessie/updates main\ndeb-src http://security.debian.org jessie/updates main" > /etc/apt/sources.list

RUN apt-get update && apt-get install -y \
    git

RUN groupadd -g 1000 app \
 && useradd -g 1000 -u 1000 -d /var/www -s /bin/bash app

RUN chown -R www-data: /var/www/html

RUN \
  chmod 777    /var/www/ &&\
    chmod 777 /var/www/html

USER www-data
RUN git clone https://github.com/arialdomartini/oh-my-git.git ~/.oh-my-git && echo source ~/.oh-my-git/prompt.sh >> ~/.bashrc

WORKDIR $INSTALL_DIR