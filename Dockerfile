FROM dunglas/frankenphp:1-php8.3

# Set working directory
WORKDIR /app

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    && docker-php-ext-install \
    pcntl \
    zip \
    pdo_mysql \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy project files
COPY . .

# Set environment variables for production
ENV APP_ENV=production
ENV APP_DEBUG=false
ENV OCTANE_SERVER=frankenphp

# Install dependencies
RUN composer install --no-dev --optimize-autoloader

# Create public/build directory for Vite if needed
RUN mkdir -p public/build

# Expose port 8000 for FrankenPHP
EXPOSE 8000

# Start FrankenPHP via Octane
CMD ["php", "artisan", "octane:start", "--host=0.0.0.0", "--port=8000"]
