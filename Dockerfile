# Use an official PHP image with Apache
FROM php:8.2-apache

# Set working directory
WORKDIR /var/www/html

# Copy your PHP script(s) into the container
COPY . .

# Expose port 80
EXPOSE 80
