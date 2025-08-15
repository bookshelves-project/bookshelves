FROM debian:bookworm

# Set PHP version as a build argument
ARG PHP_VERSION=8.3
ARG NODE_VERSION=22
ENV PHP_VERSION=${PHP_VERSION}
ENV NODE_VERSION=${NODE_VERSION}

# Add the PHP repository
RUN apt-get update && apt-get install -y \
    apt-transport-https lsb-release ca-certificates curl gnupg \
    && curl -sSL https://packages.sury.org/php/apt.gpg | gpg --dearmor -o /usr/share/keyrings/sury.gpg \
    && echo "deb [signed-by=/usr/share/keyrings/sury.gpg] https://packages.sury.org/php/ $(lsb_release -sc) main" > /etc/apt/sources.list.d/sury.list

# Update and install dependencies
RUN apt-get update && apt-get install -y \
    # Install common dependencies
    software-properties-common wget git zsh vim \
    # apt zip php extension
    libzip-dev unzip zip p7zip \
    # apt intl php extension
    libicu-dev \
    # imagemagick and ffmpeg
    imagemagick ffmpeg libmagickwand-dev \
    # apt mariadb and redis php extensions
    mariadb-client redis-tools \
    # Install PHP and extensions
    php${PHP_VERSION} php${PHP_VERSION}-cli php${PHP_VERSION}-fpm php${PHP_VERSION}-dev \
    php${PHP_VERSION}-common \
    php${PHP_VERSION}-redis  \
    php${PHP_VERSION}-pdo  \
    php${PHP_VERSION}-mysql  \
    php${PHP_VERSION}-zip  \
    php${PHP_VERSION}-exif  \
    php${PHP_VERSION}-intl  \
    php${PHP_VERSION}-xml  \
    php${PHP_VERSION}-gd  \
    php${PHP_VERSION}-mbstring \
    php${PHP_VERSION}-curl \
    # Clean up
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* \
    # Install imagick extension
    && git clone https://github.com/Imagick/imagick.git --depth 1 /tmp/imagick \
    && cd /tmp/imagick \
    && phpize \
    && ./configure \
    && make \
    && make install \
    && echo "extension=imagick.so" > /etc/php/${PHP_VERSION}/fpm/conf.d/20-imagick.ini \
    && echo "extension=imagick.so" > /etc/php/${PHP_VERSION}/cli/conf.d/20-imagick.ini

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Install Node.js
RUN curl -fsSL https://deb.nodesource.com/setup_${NODE_VERSION}.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g pnpm

# Setup PHP-FPM
RUN echo "listen = 0.0.0.0:9000" >> /etc/php/${PHP_VERSION}/fpm/pool.d/www.conf \
    && ln -s /usr/sbin/php-fpm${PHP_VERSION} /usr/local/bin/php-fpm

# Set up ZSH as the default shell
SHELL ["/bin/zsh", "-c"]

WORKDIR /app

# Run PHP-FPM in the foreground
CMD ["php-fpm", "-F"]
