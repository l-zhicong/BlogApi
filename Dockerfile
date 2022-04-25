FROM php:8.0-fpm

ENV WWW_HOME /data/www/BlogApi

#RUN git clone https://github.com/L-zhicong/BlogApi
COPY ./ $WWW_HOME
WORKDIR $WWW_HOME

#更换源
RUN    sed -i "s/deb.debian.org/mirrors.aliyun.com/g" /etc/apt/sources.list

#编译安装核心扩展 gd
RUN apt-get update &&\
    apt-get install -y   zip unzip libfreetype6-dev libjpeg62-turbo-dev libpng-dev &&\
    docker-php-ext-configure gd --with-freetype --with-jpeg &&\
    docker-php-ext-install -j$(nproc) gd \
           && docker-php-ext-install pdo_mysql \
           && docker-php-ext-install opcache \
           && docker-php-ext-install mysqli
#pecl 安装扩展 redis
RUN pecl install redis-5.3.2 \
    && docker-php-ext-enable redis

#安装conposer
ENV COMPOSER_HOME /root/composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
ENV PATH $COMPOSER_HOME/vendor/bin:$PATH

RUN composer install

CMD ["php","think","run"]