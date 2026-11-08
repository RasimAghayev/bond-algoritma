FROM php:8.5-cli-alpine AS base
RUN apk add --no-cache bash git unzip libzip-dev oniguruma-dev postgresql-dev \
 && docker-php-ext-install pdo pdo_mysql pdo_pgsql mbstring zip bcmath
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
WORKDIR /app

FROM base AS deps
COPY composer.json composer.lock* ./
RUN if [ -f composer.lock ]; then composer install --no-dev --no-interaction --no-scripts --prefer-dist; else composer update --no-dev --no-interaction --no-scripts --prefer-dist; fi

FROM base AS build
COPY --from=deps /app/vendor ./vendor
COPY . .

FROM base AS runtime
COPY --from=build /app /app
RUN addgroup -S app && adduser -S app -G app && chown -R app:app /app
USER app
EXPOSE 8000
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]

FROM base AS test
USER root
COPY composer.json composer.lock* ./
RUN if [ -f composer.lock ]; then composer install --no-interaction --no-scripts --prefer-dist; else composer update --no-interaction --no-scripts --prefer-dist; fi
COPY . .
RUN php artisan key:generate --ansi \
 && addgroup -S app && adduser -S app -G app \
 && chown -R app:app /app
USER app
CMD ["sh", "-c", "php artisan migrate --force && vendor/bin/pest"]
