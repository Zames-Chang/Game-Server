FROM hashman/apache2-php-7.2-fpm

RUN apt update && apt install -y libpng-dev
RUN docker-php-ext-install gd

COPY . /code/
