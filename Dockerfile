FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    curl \
    libzip-dev \
    libpng-dev \
    libpq-dev \
    && docker-php-ext-install \
       gd \
       zip \
       pdo_pgsql

# Install Node.js
RUN curl -fsSL https://deb.nodesource.com/setup_22.x | bash - \
    && apt-get install -y nodejs

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .

RUN composer install --no-dev --optimize-autoloader --no-interaction

# Install frontend dependencies
RUN npm install
RUN npm run build

RUN chmod -R 775 storage bootstrap/cache || true

CMD php artisan serve --host=0.0.0.0 --port=${PORT}
