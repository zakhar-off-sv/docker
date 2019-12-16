# Docker for symfony

**Запуск контейнеров:**
1. `$ cd build/container/dev`
2. `$ make init`

**PostgreSQL**:

please use port 54321

**symfony console**:

`$ docker exec -t sf-php-fpm php bin/console`

**php-fpm terminal**:

`$ docker exec -it sf-php-fpm /bin/bash`
