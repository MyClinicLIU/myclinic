# Use an official PHP image with Apache
FROM php:7.4-apache

# Install additional PHP extensions if needed
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Set the working directory in the container
WORKDIR /var/www/html

# Copy the application code to the container
COPY . /var/www/html

# Expose port 80 to access the web server
EXPOSE 80

# Start Apache in the foreground
CMD ["apache2-foreground"]