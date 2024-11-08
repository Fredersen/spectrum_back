FROM php:8.3-cli

# ADD --chmod=0755 https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

# RUN install-php-extensions gd xdebug

RUN ( curl -sSLf https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions -o - || echo 'return 1' ) | sh -s \
      gd xdebug

RUN curl -sSk https://getcomposer.org/installer | php -- --disable-tls && \
	mv composer.phar /usr/local/bin/composer

RUN apt update && apt install -yqq nodejs npm

COPY . /var/www/project

COPY ./apache.conf /etc/apache2/sites-available/000-default.conf

RUN cd /var/www/project && \
      composer install

WORKDIR /var/www/project

EXPOSE 8000

ENTRYPOINT [ "entypoint.sh" ] 