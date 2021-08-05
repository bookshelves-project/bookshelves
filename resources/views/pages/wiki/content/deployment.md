# **NGINX**

```nginx
server {
  server_name bookshelves.ink;

  error_page 500 502 503 504 /index.html;
  location = /index.html {
    root /usr/share/nginx/html;
    internal;
  }

  location / {
    include proxy_params;
    proxy_pass http://localhost:3004;
  }

  location ~ ^/(admin|api|css|media|uploads|storage|docs|packages|cache|sanctum|login|logout) {
    include proxy_params;
    proxy_pass http://127.0.0.1:8000;
    proxy_buffer_size 128k;
    proxy_buffers 4 256k;
    proxy_busy_buffers_size 256k;
  }
}
server {
  listen 8000;
  listen [::]:8000;

  server_name bookshelves.ink;

  error_log /var/log/nginx/bookshelves.log warn;
  access_log /var/log/nginx/bookshelves.log;

  root /home/ewilan/www/bookshelves-back/public;
  index index.php;

  add_header X-Frame-Options "SAMEORIGIN";
  add_header X-XSS-Protection "1; mode=block";
  add_header X-Content-Type-Options "nosniff";

  charset utf-8;

  location / {
    try_files $uri $uri/ /index.php?$query_string;
  }

  error_page 404 /index.php;

  location ~ ^/cache/resolve {
    try_files $uri $uri/ /index.php?$query_string;
  }

  location ~ ^/docs/ {
    try_files $uri $uri/ /index.php?$query_string;
  }

  location ~* \.(js|css|png|jpg|jpeg|gif|ico|eot|svg|ttf|woff|woff2)$ {
    expires max;
    log_not_found off;
  }

  location ~ \.php$ {
    include snippets/fastcgi-php.conf;
    fastcgi_pass unix:/run/php/php8.0-fpm.sock;
    fastcgi_buffer_size 128k;
    fastcgi_buffers 4 256k;
    fastcgi_busy_buffers_size 256k;
  }

  location ~ /\.(?!well-known).* {
    deny all;
  }
}
```
