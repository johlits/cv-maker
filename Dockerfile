# Use an official PHP runtime as a parent image
FROM php:7.4-cli

# Install necessary packages
RUN apt-get update && apt-get install -y \
    texlive \
    texlive-latex-extra \
    texlive-fonts-recommended \
    && rm -rf /var/lib/apt/lists/*

# Set the working directory
WORKDIR /app

# Copy composer files and install dependencies if needed
# COPY composer.json composer.lock ./
# RUN composer install --no-scripts --no-autoloader

# Copy the rest of the application code
COPY . .

# Run your PHP application
CMD [ "php", "./cv-maker.php" ]
