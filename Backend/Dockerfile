# Use the official PHP CLI image
FROM php:8.1-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    zip \
    libpq-dev \
    && docker-php-ext-install pgsql pdo_pgsql

# Install required PHP extensions
RUN docker-php-ext-install pdo pdo_mysql

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set the working directory for the backend
WORKDIR /var/www/html

# Copy only the necessary application files
COPY composer.json composer.lock /var/www/html/
RUN composer install
RUN composer dump-autoload

# Copy the rest of the application files
COPY ./ /var/www/html

# Ensure proper file permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html
RUN php -r "require 'vendor/autoload.php'; echo 'Autoloader works!';"
# Expose port 8101 for the backend API
EXPOSE 8101

# Start the PHP built-in server
CMD ["sh", "-c", "ls -l /var/www/html/vendor && php -S 0.0.0.0:8101 -t /var/www/html/public"]
