This application works with **Server Side Rendering** with **NuxtJS** and **PHP** with **Laravel**, so you need to serve back-end with virtual host and front-end with a service like [**PM2**](https://pm2.keymetrics.io/).

## **NGINX (SSR)**

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

  location ~ ^/(api|docs|features|storage|assets) {
    try_files $uri $uri/ /index.php?$query_string;
  }

  location ~ \.php$ {
    include snippets/fastcgi-php.conf;
    fastcgi_pass unix:/var/run/php/php8.0-fpm.sock;
  }
}
```

### *PM2*

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
