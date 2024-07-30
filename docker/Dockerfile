FROM php:8.2-fpm
# ARG user
# ARG uid

# apt requirements
RUN apt update && apt install -y \
  apt-transport-https \
  build-essential \
  ca-certificates \
  curl \
  git \
  imagemagick \
  libmagickwand-dev \
  libonig-dev \
  libpng-dev \
  libxml2-dev \
  libzip-dev \
  p7zip-full \
  unzip \
  vim \
  wget \
  zip \
  zsh

# apt images requirements
RUN apt install -y \
  jpegoptim \
  gifsicle \
  pngquant \
  optipng \
  webp

# apt clean
RUN apt clean && rm -rf /var/lib/apt/lists/*

# install PHP imagick
RUN git clone https://github.com/Imagick/imagick && \
  cd imagick && \
  phpize && \
  ./configure && \
  make && \
  make install

# install PHP extensions
RUN docker-php-ext-install \
  bcmath \
  exif \
  fileinfo \
  gd \
  intl \
  mbstring \
  pcntl \
  pdo_mysql \
  zip

# install PHP rar
RUN git clone https://github.com/cataphract/php-rar && \
  cd php-rar && \
  phpize && \
  ./configure && \
  make && \
  make install

# pecl_path=$(pecl config-get ext_dir)
# phpini_path=$(php -i | grep /.+/php.ini -oE)
# sudo cp ./modules/rar.so $pecl_path
# sudo echo "extension=rar.so" > $phpini_path

# install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# create laravel user
RUN groupadd -g 1000 laravel && useradd -u 1000 -ms /bin/bash -g laravel laravel

# copy app files
COPY . /app
COPY --chown=www-data:www-data . /app

# set permissions
RUN chown -R laravel:laravel /app

# switch to laravel user
USER laravel

WORKDIR /home/laravel

# install oh-my-zsh
RUN sh -c "$(curl -fsSL https://raw.githubusercontent.com/robbyrussell/oh-my-zsh/master/tools/install.sh)"
RUN sed -i 's/robbyrussell/pmcgee/g' $HOME/.zshrc
RUN cat <<EOT >>/home/laravel/.zshrc
export NVM_DIR="$([ -z "${XDG_CONFIG_HOME-}" ] && printf %s "${HOME}/.nvm" || printf %s "${XDG_CONFIG_HOME}/nvm")"
[ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh" # This loads nvm
EOT

ENV NVM_VERSION 0.39.7
ENV NVM_DIR /home/laravel/.nvm
ENV NODE_VERSION 20.16.0

# install nvm
RUN curl https://raw.githubusercontent.com/creationix/nvm/v0.39.7/install.sh | bash && \
  . $NVM_DIR/nvm.sh && \
  nvm install $NODE_VERSION && \
  nvm alias default $NODE_VERSION && \
  nvm use default && \
  npm install -g pnpm

# add node to $PATH
ENV PATH $NVM_DIR/versions/node/v$NODE_VERSION/bin:$PATH

# install pnpm
ENV PNPM_HOME="/pnpm"
ENV PATH="$PNPM_HOME:$PATH"

WORKDIR /app

# delete node_modules and vendor
RUN rm -rf /app/node_modules
RUN rm -rf /app/public/storage
RUN rm -rf /app/vendor

# install dependencies
RUN composer install --no-dev --optimize-autoloader
RUN pnpm install --frozen-lockfile
RUN pnpm build:no-check
RUN pnpm build:ssr

# Ensure that the storage and cache directories exist
RUN mkdir -p /app/storage/framework/cache/data /app/storage/framework/sessions /app/storage/framework/views

# Run storage:link to create the storage symlink
RUN php artisan storage:link

# Change current user to www
USER www-data

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]
