FROM php:8.3-cli

# Download the installer script and make it executable
RUN curl -sSL https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions -o /usr/local/bin/install-php-extensions && \
    chmod +x /usr/local/bin/install-php-extensions

# Install the required PHP extensions
RUN install-php-extensions gd xdebug pdo_mysql

# Install composer
RUN curl -sSk https://getcomposer.org/installer | php -- --disable-tls && \
	mv composer.phar /usr/local/bin/composer


COPY . /var/www/project

COPY ./apache.conf /etc/apache2/sites-available/000-default.conf

WORKDIR /var/www/project

EXPOSE 8000

ENTRYPOINT [ "/var/www/project/entrypoint.sh" ] 