FROM php:8.2-apache

<<<<<<< HEAD
# Install mysqli + pdo_mysql extensions
=======
# Install mysqli + pdo_mysql
>>>>>>> f9236fd490e04be70fdb65320c3cea3a39755678
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Enable Apache rewrite module
RUN a2enmod rewrite

# Copy project
COPY . /var/www/html/

<<<<<<< HEAD
# Permissions
=======
# Set permissions
>>>>>>> f9236fd490e04be70fdb65320c3cea3a39755678
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80

<<<<<<< HEAD
CMD ["apache2-foreground"]
=======
CMD ["apache2-foreground"]
>>>>>>> f9236fd490e04be70fdb65320c3cea3a39755678
