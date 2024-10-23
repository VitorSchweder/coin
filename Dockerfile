# Use the official PHP 7.1 FPM image
FROM php:7.1-fpm

# Install necessary system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    nginx \
    supervisor \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install gd pdo pdo_mysql mbstring tokenizer xml bcmath

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set the working directory to /var/www/html
WORKDIR /var/www/html

# Copy existing Laravel application code into the container
COPY . /var/www/html

# Ensure proper permissions for storage and cache directories
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage /var/www/html/bootstrap/cache

# Copy nginx and supervisor configuration files
COPY nginx.conf /etc/nginx/nginx.conf
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Expose port 80 for Nginx
EXPOSE 80

# Start both PHP-FPM and Nginx using Supervisor
CMD ["supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
