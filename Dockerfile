FROM webdevops/php-nginx-dev:7.4

WORKDIR /app

ENV WEB_DOCUMENT_ROOT=/app/web \
    WEB_DOCUMENT_INDEX=app_dev.php

RUN apt-get update && apt-get install -y default-mysql-client curl less vim
