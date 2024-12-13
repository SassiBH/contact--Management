# Use the official PHP CLI image
FROM php:8.1-cli

# Install required PHP extensions
RUN docker-php-ext-install pdo pdo_mysql

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set the working directory for the backend
WORKDIR /var/www/html

# Copy backend application files
COPY ./ /var/www/html

# Run Composer in the correct directory to install dependencies and optimize autoloading
RUN composer install --no-dev --optimize-autoloader

# Expose port 8101 for the backend API
EXPOSE 8101

# Start the PHP built-in server
CMD ["php", "-S", "0.0.0.0:8101", "-t", "/var/www/html/public"]