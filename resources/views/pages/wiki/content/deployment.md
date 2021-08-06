Bookshelves works with Server Side Rendering with NuxtJS, so you need to serve back-end with virtual host and front-end with a service like [**PM2**](https://pm2.keymetrics.io/).

# **NGINX (SSR)**

Here you have an example for NGINX, note the `proxy_params` on `3002` port (can be any other port) is for PM2.

```nginx
server {
  listen 80;
  server_name bookshelves.ink;
  root /home/user/www/bookshelves-back/public;
  index index.php index.html;

  add_header X-Frame-Options "SAMEORIGIN";
  add_header X-XSS-Protection "1; mode=block";
  add_header X-Content-Type-Options "nosniff";
  add_header X-Robots-Tag "index, follow";

  charset utf-8;

  error_log /var/log/nginx/bookshelves.log warn;
  access_log /var/log/nginx/bookshelves.log;

  location / {
    include proxy_params;
    proxy_pass http://localhost:3002;
  }

  location ~ ^/(api|docs|opds|catalog|wiki|webreader|storage|media|css) {
    try_files $uri $uri/ /index.php?$query_string;
  }

  location ~ \.php$ {
    include snippets/fastcgi-php.conf;
    fastcgi_pass unix:/var/run/php/php8.0-fpm.sock;
  }
}
```

## *PM2*

You can install PM2 with NPM.

```bash
npm install pm2@latest -g
```

Here a config for `ecosystem.config.js`, you can create this config at `~/` for example. Take same port as `proxy_params`.

```js
module.exports = {
  apps: [
    {
      name: "bookshelves",
      script: "npm",
      cwd: "/home/user/www/bookshelves-front",
      args: "start",
      env: {
        PORT: 3002,
      },
    },
  ],
};
```

Start PM2 with this config and save it.

```bash
pm2 start ~/ecosystem.config.js
pm2 save
```

# **NGINX (SSG)**

You can use Bookshelves with Static Site Generation, but you will have some problems with queyr parameters like for pagination.

```nginx
map $sent_http_content_type $expires {
  default off;
  text/html epoch;
  text/css max;
  application/javascript max;
  ~image/ max;
}
server {
  listen 80;

  add_header X-Frame-Options "SAMEORIGIN";
  add_header X-XSS-Protection "1; mode=block";
  add_header X-Content-Type-Options "nosniff";
  add_header X-Robots-Tag "index, follow";

  expires $expires;

  root /home/user/www/bookshelves-front/dist;
  index index.html;

  server_name bookshelves.ink;

  error_page 404 /200.html;

  location ^~ /assets/ {
    gzip_static on;
    expires 12h;
    add_header Cache-Control public;
  }

  location / {
    try_files $uri $uri/ /index.html;
  }

  location ~ ^/(api|opds|catalog|wiki|webreader|storage|media|css) {
    include proxy_params;
    proxy_pass http://127.0.0.1:8000;
  }

  location ~ ^/(docs) {
    root /home/user/www/bookshelves-back/public;
    index index.html;
    try_files $uri $uri/ /index.html;
  }
}
server {
  listen 8000;
  server_name bookshelves.ink;
  root /home/user/www/bookshelves-back/public;
  index index.php;

  error_log /var/log/nginx/bookshelves.log warn;
  access_log /var/log/nginx/bookshelves.log;

  location / {
    try_files $uri $uri/ /index.php?$query_string;
  }

  location ~ \.php$ {
    include snippets/fastcgi-php.conf;
    fastcgi_pass unix:/var/run/php/php8.0-fpm.sock;
  }
}
```
