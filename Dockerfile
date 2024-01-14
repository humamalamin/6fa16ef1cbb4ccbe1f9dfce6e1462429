# Base image
FROM php:8.0-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    nginx \
    curl \
    libpq-dev \
    libzip-dev \
    unzip \
    git \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_pgsql zip

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set up Nginx
COPY nginx.conf /etc/nginx/sites-available/default
RUN ln -s /etc/nginx/sites-available/default /etc/nginx/sites-enabled2

# Set up working directory
WORKDIR /var/www/html

# Copy application code
COPY . /var/www/html

# Install dependencies using Composer
RUN composer install --no-interaction --optimize-autoloader

# Expose ports
EXPOSE 80

# Start services
CMD service nginx start && php-fpm