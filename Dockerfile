FROM php:8.2-cli-alpine AS base
RUN apk add --no-cache bash git unzip libzip-dev oniguruma-dev \
 && docker-php-ext-install pdo pdo_mysql mbstring zip bcmath
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
WORKDIR /app

FROM base AS deps
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --no-scripts --optimize-autoloader

FROM base AS build
COPY --from=deps /app/vendor ./vendor
COPY . .

FROM base AS runtime
COPY --from=build /app /app
RUN addgroup -S app && adduser -S app -G app && chown -R app:app /app
USER app
EXPOSE 8000
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
