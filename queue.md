# Queue

Queues use `redis` to function, the default client is `phpredis`, which requires the PHP extension `predis`.

```sh
QUEUE_CONNECTION=redis
REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
```
