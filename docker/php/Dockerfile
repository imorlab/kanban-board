# Dockerfile multi-stage para desarrollo y producción

# Etapa base
FROM php:8.3-fpm-alpine as base

# Instalar dependencias del sistema
RUN apk add --no-cache \
    build-base \
    freetype-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    libzip-dev \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    sqlite \
    sqlite-dev \
    oniguruma-dev

# Instalar extensiones PHP
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install \
    pdo \
    pdo_sqlite \
    mbstring \
    zip \
    exif \
    pcntl \
    gd \
    bcmath

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Crear usuario para la aplicación
RUN addgroup -g 1000 -S www && \
    adduser -u 1000 -S www -G www

# Etapa de desarrollo
FROM base as development

WORKDIR /var/www/html

# Copiar archivos de la aplicación
COPY --chown=www:www . .

# Instalar dependencias de Composer (incluyendo dev)
RUN composer install --no-cache --prefer-dist

# Instalar Node.js y npm
RUN apk add --no-cache nodejs npm

# Instalar dependencias de Node.js
RUN npm install

USER www

EXPOSE 9000

CMD ["php-fpm"]

# Etapa de producción
FROM base as production

WORKDIR /var/www/html

# Copiar archivos de la aplicación
COPY --chown=www:www . .

# Instalar dependencias de Composer (solo producción)
RUN composer install --no-cache --no-dev --prefer-dist --optimize-autoloader

# Instalar Node.js y npm
RUN apk add --no-cache nodejs npm

# Instalar y compilar dependencias de Node.js
RUN npm ci --only=production
RUN npm run build

# Limpiar archivos innecesarios
RUN rm -rf node_modules
RUN apk del nodejs npm

# Optimizar para producción
RUN php artisan config:cache || true
RUN php artisan route:cache || true
RUN php artisan view:cache || true

# Configurar permisos
RUN chown -R www:www /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

USER www

EXPOSE 9000

CMD ["php-fpm"]
