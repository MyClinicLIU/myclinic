# Use an official phpMyAdmin image as base
FROM phpmyadmin/phpmyadmin:latest

# Set environment variables for MySQL connection
ENV PMA_HOST=db-service
ENV PMA_USER=admin
ENV PMA_PASSWORD=root

# The port phpMyAdmin will run on
EXPOSE 80

# Start phpMyAdmin
CMD ["apache2-foreground"]
