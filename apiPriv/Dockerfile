# Base Image
FROM php:8.3-fpm

# Copiar o Composer do container oficial do Composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Instalar dependências do sistema
RUN apt-get update && apt-get install -y \
    libxml2-dev \
    postgresql-contrib \
    autoconf \
    automake \
    libpq-dev \
    libonig-dev \
    libzip-dev \
    libcurl4-openssl-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev

# Instalar extensões PHP
RUN docker-php-ext-install dom pgsql pdo pdo_pgsql mbstring curl gd zip
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install -j$(nproc) gd

# Configurar php.ini
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

# Instalar e configurar Xdebug
RUN pecl install -o -f xdebug \
    && rm -rf /tmp/pear \
    && docker-php-ext-enable xdebug

RUN echo "zend_extension = xdebug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.start_with_request=yes" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.discover_client_host=true" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.client_host=host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "XDEBUG_SESSION=debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.client_port=9003" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.var_display_max_children = 128" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.idekey=docker" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# Copiar arquivos do projeto
COPY composer.json composer.lock* ./
RUN composer install --no-scripts --no-autoloader

# Copiar o resto do código
COPY . .

# Gerar autoload otimizado
RUN composer dump-autoload --optimize

# Expor a porta 9000 para o PHP-FPM
EXPOSE 9000
