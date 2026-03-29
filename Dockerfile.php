FROM php:8.2-apache

# Enable Apache rewrite module (important for routing)
RUN a2enmod rewrite

# Copy your PHP project files into Apache web directory
COPY . /var/www/html/

# Set proper permissions
RUN chown -R www-data:www-data /var/www/html

# Expose web server port
EXPOSE 80

# Start Apache in foreground
CMD ["apache2-foreground"]