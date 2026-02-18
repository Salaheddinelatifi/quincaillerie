# Use official PHP image with Apache
FROM php:8.2-apache

# Set working directory
WORKDIR /var/www/html

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip git curl libpq-dev

# Enable PHP extensions
RUN docker-php-ext-install pdo pdo_pgsql zip

# Copy project files to container
COPY . .

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install Laravel dependencies
RUN composer install --optimize-autoloader --no-dev

# Set proper permissions for storage & bootstrap/cache
RUN chown -R www-data:www-data storage bootstrap/cache
RUN chmod -R 775 storage bootstrap/cache

# Expose port 8080 (Render will use this)
EXPOSE 8080

# Start Apache in foreground
CMD ["apache2-foreground"]
