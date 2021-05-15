FROM webdevops/php-nginx-dev:7.4

WORKDIR /app

ENV WEB_DOCUMENT_ROOT=/app/web \
    WEB_DOCUMENT_INDEX=app_dev.php

# See https://www.php.net/manual/en/ini.core.php#ini.realpath-cache-ttl
# I/O on filesystem is very slow in Windows / Mac, so we increase this value
ENV php.realpath_cache_ttl=7200

RUN apt-get update && apt-get install -y default-mysql-client curl less vim
