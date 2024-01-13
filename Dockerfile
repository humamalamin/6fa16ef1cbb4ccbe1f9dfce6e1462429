# Gunakan gambar resmi PHP 8.0
FROM php:8.0-fpm

RUN apt-get update

# Install Postgre PDO
RUN apt-get install -y libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql

# Instal ekstensi PHP yang dibutuhkan
RUN docker-php-ext-install pdo pdo_pgsql

# Instal Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Setel direktori kerja ke direktori aplikasi
WORKDIR /var/www/html

# Salin file aplikasi ke dalam kontainer
COPY . /var/www/html

# Instal dependensi proyek menggunakan Composer
RUN composer install

# Expose port 9000 (port default PHP-FPM)
EXPOSE 9000

# Perintah yang akan dijalankan ketika kontainer dijalankan
CMD ["php-fpm"]
