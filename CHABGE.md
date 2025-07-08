## Installation

```bash
docker run --rm -v "$PWD":/app -w /app php:8.2-cli sh -c "
apt-get update && apt-get install -y unzip zip git libzip-dev && \
docker-php-ext-install zip && \
curl -sS https://getcomposer.org/installer | php && \
mv composer.phar /usr/local/bin/composer && \
composer install && \
php artisan sail:install"
```
