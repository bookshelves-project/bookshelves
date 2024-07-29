FROM php:8.2-fpm
# ARG user
# ARG uid

WORKDIR /app

RUN apt update && apt install -y \
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

RUN apt install -y \
  jpegoptim \
  gifsicle \
  pngquant \
  optipng \
  webp

RUN apt clean && rm -rf /var/lib/apt/lists/*

RUN git clone https://github.com/Imagick/imagick && cd imagick && phpize && ./configure && make && make install

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

# RUN git clone https://github.com/cataphract/php-rar && cd php-rar && phpize && ./configure && make && make install

# pecl_path=$(pecl config-get ext_dir)
# phpini_path=$(php -i | grep /.+/php.ini -oE)
# sudo cp ./modules/rar.so $pecl_path
# sudo echo "extension=rar.so" > $phpini_path

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN groupadd -g 1000 laravel && useradd -u 1000 -ms /bin/bash -g laravel laravel

COPY . /app
COPY --chown=www-data:www-data . /app

RUN rm -rf /app/node_modules
RUN rm -rf /app/vendor

RUN chown -R laravel:laravel /app

USER laravel

RUN curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.7/install.sh | bash
RUN sh -c "$(curl -fsSL https://raw.githubusercontent.com/robbyrussell/oh-my-zsh/master/tools/install.sh)"

RUN sed -i 's/robbyrussell/pmcgee/g' $HOME/.zshrc
RUN cat <<EOT >>/home/laravel/.zshrc
export NVM_DIR="$([ -z "${XDG_CONFIG_HOME-}" ] && printf %s "${HOME}/.nvm" || printf %s "${XDG_CONFIG_HOME}/nvm")"
[ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh" # This loads nvm
EOT
RUN wget -qO- https://get.pnpm.io/install.sh | ENV="$HOME/.shrc" SHELL="$(which sh)" sh -

RUN composer install --no-dev --optimize-autoloader
RUN /home/laravel/.nvm/versions/node/v20.12.2/bin/pnpm install --frozen-lockfile

EXPOSE 9000
CMD ["php-fpm"]
