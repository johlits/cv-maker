FROM php:7.4-apache

# Update package lists and install necessary packages
RUN apt-get update && apt-get install -y \
    texlive \
    texlive-latex-extra \
    texlive-fonts-recommended \
    texlive-fonts-extra \
    cm-super \
    && rm -rf /var/lib/apt/lists/*

# Copy the application files to the Apache document root
COPY . /var/www/html/

# Set the working directory
WORKDIR /var/www/html

# Expose port 80 for the web server
EXPOSE 80
