FROM php:8.2-apache

# Install required PHP extensions
RUN docker-php-ext-install pdo pdo_mysql mysqli
# Enable Apache rewrite (safe even if you don't use it)
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy project files into container
COPY src/ /var/www/html/

# Fix permissions
RUN chown -R www-data:www-data /var/www/html