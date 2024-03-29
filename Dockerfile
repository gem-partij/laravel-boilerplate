FROM php:8.1.9-fpm

# Arguments defined in docker-compose.yml
ARG user
ARG uid

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    autoconf \
    pkg-config \
    libssl-dev \
    libpq-dev \
    libsodium-dev \
    libzip-dev

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd sodium zip
RUN docker-php-ext-install sockets

# Install Postgres
RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql
RUN docker-php-ext-install pdo pdo_pgsql pgsql

# Install mongodb
RUN apt-get install -y wget
RUN wget https://github.com/mongodb/mongo-php-driver/releases/download/1.14.0/mongodb-1.14.0.tgz
RUN pecl install -f mongodb-1.14.0.tgz

# install nginx
RUN apt-get install nginx -y
RUN apt-get install supervisor -y

# Get latest Composer (from docker hub)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Set timezone
# ENV TZ Asia/Jakarta

# Set working directory
WORKDIR /var/www

# USER $user

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]
